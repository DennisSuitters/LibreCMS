<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(preg_match('/<block include=[\"\']?meta_head.html[\"\']?>/',$template)&&file_exists(THEME.DS.'meta_head.html'))
	$head=file_get_contents(THEME.DS.'meta_head.html');
elseif(stristr($template,'</head>')){
	preg_match('/<head>([\w\W]*?)<\/head>/',$template,$matches);
	$head=$matches[1];
}else
	$head='You MUST include a meta_head template, or inbed a meta head section';
