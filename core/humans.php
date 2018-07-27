<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
header("Content-Type:text/plain");
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require_once'core'.DS.'db.php';
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
