<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Meta Footer Renderer
 *
 * meta_footer.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Meta Footer
 * @package    core/view/meta_footer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(preg_match('/<block include=[\"\']?meta_footer.html[\"\']?>/',$template)&&file_exists(THEME.DS.'meta_footer.html')){
  $footer=file_get_contents(THEME.DS.'meta_footer.html');
  $footer=preg_replace([
    '/<print theme>/'
  ],[
    THEME
  ],$footer);
}else
  $footer='You MUST include a meta_footer template';
$content.=$footer;
