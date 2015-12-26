<?php
if(stristr($template,'<block include="meta_head.html">')&&file_exists(THEME.'/meta_head.html')){
	$head=file_get_contents(THEME.'/meta_head.html');
}elseif(stristr($template,'</head>')){
	preg_match('/<head>([\w\W]*?)<\/head>/',$template,$matches);
	$head=$matches[1];
}else{
	$head='You MUST include a meta_head template, or inbed a meta head section';
}
