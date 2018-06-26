<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(preg_match('/<block include=[\"\']?meta_footer.html[\"\']?>/',$template)&&file_exists(THEME.DS.'meta_footer.html'))$footer=file_get_contents(THEME.DS.'meta_footer.html');else$footer='You MUST include a meta_footer template';
$content.=$footer;
