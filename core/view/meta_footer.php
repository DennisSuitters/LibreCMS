<?php
if(stristr($template,'<block include="meta_footer.html">')&&file_exists(THEME.DS.'meta_footer.html'))$footer=file_get_contents(THEME.DS.'meta_footer.html');else$footer='You MUST include a meta_footer template';
$content.=$footer;
