<?php
require'includes/db.php';
$config=$this->getconfig($db);
$ti=time();
$html='';
$content='';
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
require'includes/login.php';
require'view/cart_quantity.php';
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
		if($view=='accounts')$inbed='accounts';
		if($view=='cart')$inbed='cart';
		if($view=='sitemap')$inbed='sitemap';
		if($view=='media')$inbed='media';
		if($view=='messages')$inbed='messages';
		if($view=='orders')$inbed='orders';
		if($view=='preferences')$inbed='preferences';
		require'view/'.$inbed.'.php';
		$req=$inbed;
	}
}
if($user['rank']>699){
	require'includes/meta_head.php';
}else{
	require'view/meta_head.php';
}
print $content;
if($user['rank']>699)require'includes/meta_footer.php';else require'meta_footer.php';
