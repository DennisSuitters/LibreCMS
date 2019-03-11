<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Manifest Generator
 *
 * manifest.php version 2.0.1
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Core - Manifest Generator
 * @package    core/manifest.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.1
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Create File
 */
header('Content-Type: application/json');
$getcfg=true;
require'db.php';
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(!defined('THEME'))define('THEME','layout'.DS.$config['theme']);
if(!defined('URL'))define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
if(!defined('FAVICON')){
  if(file_exists(THEME.DS.'images'.DS.'favicon.png')){
  	define('FAVICON',THEME.DS.'images'.DS.'favicon.png');
  	define('FAVICONTYPE','image/png');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon.gif')){
  	define('FAVICON',THEME.DS.'images'.DS.'favicon.gif');
  	define('FAVICONTYPE','image/gif');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon.jpg')){
  	define('FAVICON',THEME.DS.'images'.DS.'favicon.jpg');
  	define('FAVICONTYPE','image/jpg');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon.ico')){
  	define('FAVICON',THEME.DS.'images'.DS.'favicon.ico');
  	define('FAVICONTYPE','image/ico');
  }else{
  	define('FAVICON','core'.DS.'images'.DS.'favicon.png');
  	define('FAVICONTYPE','image/png');
  }
}
echo json_encode([
  "short_name"=>$config['business'],
  "name"=>$config['seoTitle'],
  "gcm_user_visible_only"=>true,
  "description"=>$config['seoDescription'],
  "start_url"=>URL,
  "display"=>"standalone",
  "orientation"=>"portrait",
  "background_color"=>'#000',
  "theme_color"=>"#f0f0f0",
  "icons"=>[
    [
      "src"=>FAVICON,
      "sizes"=>"64x64",
      "type"=>'image/png'
    ]
  ]
]);
