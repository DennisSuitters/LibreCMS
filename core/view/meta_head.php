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
