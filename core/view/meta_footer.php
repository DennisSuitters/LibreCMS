<?php
$footer='';
if(stristr($template,'<block include="meta_footer.html">')){
	$footer=file_get_contents(THEME.'/meta_footer.html');
}else{
	echo'You MUST include a meta_footer template';
}
$content.=$footer;
