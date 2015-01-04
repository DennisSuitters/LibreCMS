<?php
require'core/db.php';
$config=$this->getconfig($db);
$ti=time();
$html='';
$head='';
$content='';
$foot='';
$css=THEME.'/css/';
$favicon=$this->favicon();
$share_image=$favicon;
$noimage=$this->noimage();
$noavatar=$this->noavatar();
$sp=$db->prepare("SELECT * FROM menu WHERE contentType=:contentType");
$sp->execute(array(':contentType'=>$view));
$page=$sp->fetch(PDO::FETCH_ASSOC);
/*
	So for home page I'd say yes, brand first then tag line. For category pages,
	I'd say category first then brand name, for product pages,
	I'd say full product name and don't worry about the brand.
*/
if($view=='index')$seoTitle=empty($page['seoTitle'])?$config['seoTitle']:$page['seoTitle'];else $seoTitle=empty($page['seoTitle'])?ucfirst($view).' - '.$config['seoTitle']:$page['seoTitle'];
$seoDescription=empty($page['seoDescription'])?$config['seoDescription']:$page['seoDescription'];
$seoCaption=empty($page['seoCaption'])?$config['seoCaption']:$page['seoCaption'];
$seoKeywords=empty($page['seoKeywords'])?$config['seoKeywords']:$page['seoKeywords'];
require'core/login.php';
require'core/cart_quantity.php';
if($user['rank']>699){
	$status="%";
}else{
	$status="published";
}
$content='';
require'view/account.php';
if(file_exists(THEME.'/'.$view.'.html')){
	$template=file_get_contents(THEME.'/'.$view.'.html');
}elseif(file_exists(THEME.'/default.html')){
	$template=file_get_contents(THEME.'/default.html');
}else $template=file_get_contents(THEME.'/content.html');
$newDom=new DOMDocument();
@$newDom->loadHTML($template);
$tag=$newDom->getElementsByTagName('block');
foreach($tag as$tag1){
	$inc=$tag1->getAttribute('inc');
	$inbed=$tag1->getAttribute('inbed');
	if($inc!=''){
		$html=file_get_contents(THEME.'/'.$inc.'.html');
		require'view/'.$inc.'.php';
		$req=$inc;
	}
	if($inbed!=''){
		preg_match('/<block inbed='.$inbed.'>([\w\W]*?)<\/block inbed='.$inbed.'>/',$template,$matches);
		$html=$matches[1];
		if($view=='cart')$inbed='cart';
		if($view=='sitemap')$inbed='sitemap';
		require'view/'.$inbed.'.php';
		$req=$inbed;
	}
}
require'view/meta_head.php';
require'view/meta_footer.php';
print $head.$content.$foot;
# Here goes the ungainly, and over cumbersome Analytics Data Collection
$ip=$_SERVER['REMOTE_ADDR'];
$httpReferer=$_SERVER['HTTP_REFERER'];
$httpUserAgent=$_SERVER['HTTP_USER_AGENT'];
$pageName=$view;
$queryString=$_SERVER['QUERY_STRING'];
$currentPage=$view.'/'.$show;
$bot=is_bot();
$browser=getBrowser();
$ti=time();
if($view==''){$view='index';}
if($act!='logout'){
	$vid=0;
	if(isset($_SESSION['tracker'])){
		$vid=isset($_SESSION['vid'])?$_SESSION['vid']:0;
		if($_SESSION['currentPage']!=$currentPage){
			$q=$db->prepare("INSERT INTO tracker (vid,contentType,ip,pageName,queryString,httpReferer,httpUserAgent,bot,browser,os,ti) VALUES (:vid,:contentType,:ip,:pageName,:queryString,:httpReferer,:httpUserAgent,:bot,:browser,:os,:ti)");
			$q->execute(array(':vid'=>$vid,':contentType'=>$view,':ip'=>$ip,':pageName'=>$pageName,':queryString'=>$queryString,':httpReferer'=>$httpReferer,':httpUserAgent'=>$httpUserAgent,':bot'=>$bot,':browser'=>$browser['name'],':os'=>$browser['platform'],':ti'=>$ti));
			$_SESSION['currentPage']=$currentPage;        
		}
	}else{
		$q=$db->prepare("INSERT INTO tracker (vid,contentType,ip,pageName,queryString,httpReferer,httpUserAgent,bot,browser,os,ti) VALUES (:vid,:contentType,:ip,:pageName,:queryString,:httpReferer,:httpUserAgent,:bot,:browser,:os,:ti)");
		$q->execute(array(':vid'=>$vid,':contentType'=>$view,':ip'=>$ip,':pageName'=>$pageName,':queryString'=>$queryString,':httpReferer'=>$httpReferer,':httpUserAgent'=>$httpUserAgent,':bot'=>$bot,':browser'=>$browser['name'],':os'=>$browser['platform'],':ti'=>$ti));
		$e=$db->errorInfo();
		if(!is_null($e[2])){
			$_SESSION['tracker']=false;
		}else{
			$_SESSION['tracker']=true;
			$lid=$db->lastInsertId();
			$lr=$db->query("SELECT MAX(vid) as next FROM tracker")->fetch(PDO::FETCH_ASSOC);
			$l=$lr['next'];
			if(!isset($l))
				$l=1;
			else
				$l++;
			$q=$db->prepare("UPDATE tracker SET vid=:vid WHERE id=:id");
			$q->execute(array(':vid'=>$l,':id'=>$lid));
			$_SESSION['vid']=$l;
			$_SESSION['currentPage']=$currentPage;
		}
	}
}
function is_bot(){
	$botlist=array(
		"Teoma",			"alexa",			"froogle",				"Gigabot",
		"inktomi",			"looksmart",		"URL_Spider_SQL",		"Firefly",
		"NationalDirectory","Ask Jeeves",		"TECNOSEEK",			"InfoSeek",
		"WebFindBot",		"girafabot",		"crawler",				"www.galaxy.com",
		"Googlebot",		"Scooter",			"Slurp",				"msnbot",
		"appie",			"FAST",				"WebBug",				"Spade",
		"ZyBorg",			"rabaz",			"Baiduspider",			"Feedfetcher-Google",
		"TechnoratiSnoop",	"Rankivabot",		"Mediapartners-Google",	"Sogou web spider",
		"WebAlta Crawler",	"TweetmemeBot",		"Butterfly",			"Twitturls",
		"Me.dium",			"Twiceler"
	);
	foreach($botlist as$bot){
		if(strpos($_SERVER['HTTP_USER_AGENT'],$bot)!==false){return$bot;}
	}
	return'visitor';
}
function getBrowser(){
	$uagent=$_SERVER['HTTP_USER_AGENT'];
	$bname='Unknown';
	$platform='Unknown';
	$version="";
	if(preg_match('/linux/i',$uagent))
		$platform='linux';
	elseif(preg_match('/macintosh|mac os x/i',$uagent))
		$platform='mac';
	elseif(preg_match('/windows|win32/i',$uagent))
		$platform='windows';
	if(preg_match('/MSIE/i',$uagent)&&!preg_match('/Opera/i',$uagent)){
		$bname='Explorer';
		$ub="MSIE";
	}elseif(preg_match('/Firefox/i',$uagent)){
		$bname='Firefox';
		$ub="Firefox";
	}elseif(preg_match('/Chrome/i',$uagent)){
		$bname='Chrome';
		$ub="Chrome";
	}elseif(preg_match('/Safari/i',$uagent)){
		$bname='Safari';
		$ub="Safari";
	}elseif(preg_match('/Opera/i',$uagent)){
		$bname='Opera';
		$ub="Opera";
	}elseif(preg_match('/Netscape/i',$uagent)){
		$bname='Netscape';
		$ub="Netscape";
	}
	$known=array('Version',$ub,'other');
	$pattern='#(?<browser>'.join('|',$known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if(!preg_match_all($pattern,$uagent,$matches)){}
	$i=count($matches['browser']);
	if($i!=1){
		if(strripos($uagent,"Version")<strripos($uagent,$ub))
			$version=$matches['version'][0];
		else
			$version=$matches['version'][1];
	}else
		$version=$matches['version'][0];
	if($version==null||$version==""){$version="?";}
	return array(
		'userAgent'=>$uagent,	'name'=>$bname,		'version'=>$version,
		'platform'=>$platform,	'pattern'=>$pattern
	);
}
# This action does not relate. There is no data. It does not relate. Go! Leave me, all of you!
