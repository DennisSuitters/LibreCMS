<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Generate Humans Text
 *
 * humans.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Generate Humans Text
 * @package    core/humans.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header("Content-Type:text/plain");
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require'core'.DS.'db.php';
$config=$db->query("SELECT development,seoTitle,theme FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$theme=parse_ini_file('layout'.DS.$config['theme'].DS.'theme.ini',true);
$siteTitle=$config['seoTitle']!=''?$config['seoTitle']:URL;
$themeTitle=$theme['title'];
$themeCreator=$theme['creator'];
$themeURL=$theme['creator_url'];
echo <<< "OUT"
$siteTitle is powered by LibreCMS [https://github.com/DiemenDesign/LibreCMS]
Theme "$themeTitle" by $themeCreator [$themeURL]

/* TEAM */
Developer: Dennis Suitters
Site: https://github.com/DiemenDesign/
Location: Nirvana, Earth

Help: You, are you interested in helping develop LibreCMS further?
Site: Jump into the GitHub Repo. https://github.com/DiemenDesign/LibreCMS
Location: Your Work Station

/* THANKS */
Name: Alan Raycraft, [http://www.raycraft.com.au/]
For: Patience, Suggestions.

/* SITE */
Standards: HTML5, CSS3, PHP, jQuery, Vanilla Javascript
Backend Components: PHP, PDO, jQuery, Javascript, Bootstrap (Administration)
Frontend Componenets: Dependant on theme
Software: A FOSS Editor
OUT;
