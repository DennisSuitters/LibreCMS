<?php
$meta='';
if(stristr($template,'<print meta_head>')){
	$meta=file_get_contents(THEME.'/meta_head.html');
}elseif(stristr($template,'</head>')){
	preg_match('/<head>([\w\W]*?)<\/head>/',$template,$matches);
	$meta=$matches[1];
}else{
	echo$template;
	echo'You MUST include a meta_head template, or inbed a meta head section';
}
$meta=str_replace('<print seoTitle>',$seoTitle,$meta);
$meta=str_replace('<print urlSEOTitle>',str_replace(' ','-',$seoTitle),$meta);
$meta=str_replace('<print config:url>',PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'],$meta);
$meta=str_replace('<print view>',$view,$meta);
$meta=str_replace('<print seoKeywords>',$seoKeywords,$meta);
if($view=='index'&&$seoDescription!='')
    $meta=str_replace('<print seoCaption>',$seoDescription,$meta);
else $meta=str_replace('<print seoCaption>',$seoCaption,$meta);
$meta=str_replace('<print shareImage>',$share_image,$meta);
$meta=str_replace('<print favicon>',$favicon,$meta);
$meta=str_replace('<print dateAtom>',date(DATE_ATOM,time()),$meta);
if(stristr($meta,'<print config:seoGoogleVerification>'))
	$meta=str_replace('<print config:seoGoogleVerification>','<meta name="google-site-verification" content="'.$config['seoGoogleVerification'].'" />',$meta);
if(stristr($meta,'<print config:seoBingVerification>'))
	$meta=str_replace('<print config:seoBingVerification>','<meta name="msvalidate.01" content="'.$config['seoBingVerification'].'" />',$meta);
if(stristr($meta,'<print config:seoPinterestVerification>'))
	$meta=str_replace('<print config:seoPinterestVerification>','<meta name="p:domain_verify" content="'.$config['seoPinterestVerification'].'" />',$meta);
$head.=$meta;
