<?php
require'core'.DS.'db.php';
$config=$this->getconfig($db);
$ti=time();
$show='';
$html='';
$head='';
$content='';
$foot='';
$css=THEME.DS.'css'.DS;
$favicon=FAVICON;
$shareImage=FAVICON;
$noimage=NOIMAGE;
$noavatar=NOAVATAR;
$sp=$db->prepare("SELECT * FROM menu WHERE contentType=:contentType");
$sp->execute(array(':contentType'=>$view));
$page=$sp->fetch(PDO::FETCH_ASSOC);
if(isset($act)&&$act=='logout')require'core/login.php';
require'core'.DS.'cart_quantity.php';
if($_SESSION['rank']>699)$status="%";
else$status="published";
$content='';
if($config['maintenance']{0}==1&&(isset($_SESSION['rank'])&&$_SESSION['rank']<400)){
	if(file_exists(THEME.DS.'maintenance.html')){
		$template=file_get_contents(THEME.DS.'maintenance.html');
	}else{
		$template=file_get_contents('core'.DS.'layout'.DS.'maintenance.html');
	}
}elseif(file_exists(THEME.DS.$view.'.html'))
	$template=file_get_contents(THEME.DS.$view.'.html');
elseif(file_exists(THEME.DS.'default.html'))
	$template=file_get_contents(THEME.DS.'default.html');
else
	$template=file_get_contents(THEME.DS.'content.html');
$newDom=new DOMDocument();
@$newDom->loadHTML($template);
$tag=$newDom->getElementsByTagName('block');
foreach($tag as$tag1){
	$include=$tag1->getAttribute('include');
	$inbed=$tag1->getAttribute('inbed');
	if($include!=''){
		$include=rtrim($include,'.html');
		if(file_exists(THEME.DS.$include.'.html'))
			$html=file_get_contents(THEME.DS.$include.'.html');
		else
			$html='';
		require'view'.DS.$include.'.php';
		$req=$include;
	}
	if($inbed!=''){
		preg_match('/<block inbed="'.$inbed.'">([\w\W]*?)<\/block>/',$template,$matches);
		$html=isset($matches[1])?$matches[1]:'';
		if($view=='cart')$inbed='cart';
		if($view=='sitemap')$inbed='sitemap';
		if($view=='settings')$inbed='settings';
		require'view'.DS.$inbed.'.php';
		$req=$inbed;
	}
}
if($view=='index')
	$seoTitle=empty($page['seoTitle'])?$config['seoTitle']:$page['seoTitle'];
else{
	if(!isset($seoTitle)||$seoTitle=='')
		$seoTitle=empty($page['seoTitle'])?ucfirst($view).' - '.$config['seoTitle']:$page['seoTitle'].' - '.$config['seoTitle'];
}
$head=str_replace('<print seoTitle>',$seoTitle,$head);

if(!isset($seoDescription)||$seoDescription=='')$seoDescription=empty($page['seoDescription'])?$config['seoDescription']:$page['seoDescription'];
if($view=='index'&&$seoDescription!='')$head=str_replace('<print seoCaption>',$seoDescription,$head);
else$head=str_replace('<print seoCaption>',$seoCaption,$head);

if(!isset($seoCaption)||$seoCaption=='')$seoCaption=empty($page['seoCaption'])?$config['seoCaption']:$page['seoCaption'];

if(!isset($seoKeywords)||$seoKeywords=='')$seoKeywords=empty($page['seoKeywords'])?$config['seoKeywords']:$page['seoKeywords'];
$head=str_replace('<print seoKeywords>',$seoKeywords,$head);

if(!isset($contentTime)){if($page['eti']>$config['ti'])$contentTime=$page['eti'];else$contentTime=$config['ti'];}
$head=str_replace('<print dateAtom>',date(DATE_ATOM,$contentTime),$head);

if(!isset($canonical)||$canonical=='')$canonical=URL.$view.'/';
$head=str_replace('<print canonical>',$canonical,$head);

$head=str_replace('<print url>',URL,$head);
$head=str_replace('<print view>',$view,$head);
$head=str_replace('<print shareImage>',$shareImage,$head);
$head=str_replace('<print favicon>',FAVICON,$head);
print"<!--\n * Powered by LibreCMS (https://github.com/StudioJunkyard/LibreCMS)\n * Copyleft 2015 Studio Junkyard (http://studiojunkyard.com/)\n * Licensed under GPLv3 <http://www.gnu.org/licenses/>\n-->\n".$head.$content;
