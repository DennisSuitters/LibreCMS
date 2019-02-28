<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Meta Head Renderer
 *
 * meta_head.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Meta Head
 * @package    core/view/meta_head.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(preg_match('/<block include=[\"\']?meta_head.html[\"\']?>/',$template)&&file_exists(THEME.DS.'meta_head.html'))
	$head=file_get_contents(THEME.DS.'meta_head.html');
elseif(stristr($template,'</head>')){
	preg_match('/<head>([\w\W]*?)<\/head>/',$template,$matches);
	$head=$matches[1];
}else
	$head='You MUST include a meta_head template, or inbed a meta head section';
