<?php
require'core/db.php';
$config=$this->getconfig($db);
$ti=time();
$show='';
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
if($view=='index')$seoTitle=empty($page['seoTitle'])?$config['seoTitle']:$page['seoTitle'];
else$seoTitle=empty($page['seoTitle'])?ucfirst($view).' - '.$config['seoTitle']:$page['seoTitle'];
$seoDescription=empty($page['seoDescription'])?$config['seoDescription']:$page['seoDescription'];
$seoCaption=empty($page['seoCaption'])?$config['seoCaption']:$page['seoCaption'];
$seoKeywords=empty($page['seoKeywords'])?$config['seoKeywords']:$page['seoKeywords'];
$canonical=URL.$view.'/';
if(isset($act)&&$act=='logout')require'core/login.php';
require'core/cart_quantity.php';
if($_SESSION['rank']>699)$status="%";
else$status="published";
$content='';
if($config['maintenance']{0}==1&&(isset($_SESSION['rank'])&&$_SESSION['rank']<400)){
	if(file_exists(THEME.'/maintenance.html')){
		$template=file_get_contents(THEME.'/maintenance.html');
	}else{
		$template=file_get_contents('core/layout/maintenance.html');
	}
}elseif(file_exists(THEME.'/'.$view.'.html'))
	$template=file_get_contents(THEME.'/'.$view.'.html');
elseif(file_exists(THEME.'/default.html'))
	$template=file_get_contents(THEME.'/default.html');
else
	$template=file_get_contents(THEME.'/content.html');
$newDom=new DOMDocument();
@$newDom->loadHTML($template);
$tag=$newDom->getElementsByTagName('block');
foreach($tag as$tag1){
	$inc=$tag1->getAttribute('include');
	$inbed=$tag1->getAttribute('inbed');
	if($inc!=''){
		$inc=rtrim($inc,'.html');
		if(file_exists(THEME.'/'.$inc.'.html'))
			$html=file_get_contents(THEME.'/'.$inc.'.html');
		else
			$html='';
		require'view/'.$inc.'.php';
		$req=$inc;
	}
	if($inbed!=''){
		preg_match('/<block inbed="'.$inbed.'">([\w\W]*?)<\/block>/',$template,$matches);
		$html=isset($matches[1])?$matches[1]:'';
		if($view=='cart')$inbed='cart';
		if($view=='sitemap')$inbed='sitemap';
		if($view=='settings')$inbed='settings';
		require'view/'.$inbed.'.php';
		$req=$inbed;
	}
}
$head=str_replace('<print seoTitle>',$seoTitle,$head);
$head=str_replace('<print canonical>',$canonical,$head);
$head=str_replace('<print config:url>',URL,$head);
$head=str_replace('<print view>',$view,$head);
$head=str_replace('<print seoKeywords>',$seoKeywords,$head);
if($view=='index'&&$seoDescription!='')$head=str_replace('<print seoCaption>',$seoDescription,$head);
else$head=str_replace('<print seoCaption>',$seoCaption,$head);
$head=str_replace('<print shareImage>',$share_image,$head);
$head=str_replace('<print favicon>',$favicon,$head);
$head=str_replace('<print dateAtom>',date(DATE_ATOM,time()),$head);
print"<!--\n * Powered by LibreCMS (https://github.com/StudioJunkyard/LibreCMS)\n * Copyleft 2015 Studio Junkyard (http://studiojunkyard.com/)\n * Licensed under GPLv3 <http://www.gnu.org/licenses/>\n-->\n".$head.$content;
