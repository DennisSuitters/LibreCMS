<?php
$meta='';
if(stristr($template,'<block include="meta_head.html">')){
	$meta=file_get_contents(THEME.'/meta_head.html');
}elseif(stristr($template,'</head>')){
	preg_match('/<head>([\w\W]*?)<\/head>/',$template,$matches);
	$meta=$matches[1];
}else{
	echo'You MUST include a meta_head template, or inbed a meta head section';
}
$meta=str_replace('<print seoTitle>',$seoTitle,$meta);
$meta=str_replace('<print urlSEOTitle>',str_replace(' ','-',$seoTitle),$meta);
$meta=str_replace('<print config:url>',URL,$meta);
$meta=str_replace('<print view>',$view,$meta);
$meta=str_replace('<print seoKeywords>',$seoKeywords,$meta);
if($view=='index'&&$seoDescription!='')
    $meta=str_replace('<print seoCaption>',$seoDescription,$meta);
else $meta=str_replace('<print seoCaption>',$seoCaption,$meta);
$meta=str_replace('<print shareImage>',$share_image,$meta);
$meta=str_replace('<print favicon>',$favicon,$meta);
$meta=str_replace('<print dateAtom>',date(DATE_ATOM,time()),$meta);
$content.=$meta;
