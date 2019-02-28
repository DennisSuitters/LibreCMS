<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Update Theme
 *
 * updatetheme.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Update Theme
 * @package    core/updatetheme.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
define('DS',DIRECTORY_SEPARATOR);
$file=$_POST['file'];
$code=$_POST['code'];
$fp=fopen('..'.DS.$file,'w');
fwrite($fp,$code);
fclose($fp);
echo'<script>window.top.window.Pace.stop();</script>';