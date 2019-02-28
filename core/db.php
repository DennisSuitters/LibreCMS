<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Database and User Login Mechanism used everywhere
 *
 * db.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Database and User Login Mechanism used
 *             everywhere
 * @package    core/db.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(session_status()==PHP_SESSION_NONE){
  session_start();
  define('SESSIONID',session_id());
}
if(file_exists('..'.DS.'..'.DS.'core'.DS.'config.ini'))
  $settings=parse_ini_file('..'.DS.'..'.DS.'core'.DS.'config.ini',TRUE);
elseif(file_exists('..'.DS.'core'.DS.'config.ini'))
  $settings=parse_ini_file('..'.DS.'core'.DS.'config.ini',TRUE);
elseif(file_exists('core'.DS.'config.ini'))
  $settings=parse_ini_file('core'.DS.'config.ini',TRUE);
elseif(file_exists('config.ini'))
  $settings=parse_ini_file('config.ini',TRUE);
else{
  require'core'.DS.'layout'.DS.'install.php';
  die();
}
$prefix=$settings['database']['prefix'];
try{
  $dns=((!empty($settings['database']['driver']))?($settings['database']['driver']):'').((!empty($settings['database']['host']))?(':host='.$settings['database']['host']):'').((!empty($settings['database']['port']))?(';port='.$settings['database']['port']):'').((!empty($settings['database']['schema']))?(';dbname='.$settings['database']['schema']):'');
  $db=new PDO($dns,$settings['database']['username'],$settings['database']['password']);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  if(isset($getcfg)&&$getcfg==true){
    if(session_status()==PHP_SESSION_NONE){
      session_start();
      define('SESSIONID',session_id());
    }
    $config=$db->query("SELECT * FROM `".$prefix."config` WHERE id=1")->fetch(PDO::FETCH_ASSOC);
    if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443){
      if(!defined('PROTOCOL'))define('PROTOCOL','https://');
    }else{
      if(!defined('PROTOCOL'))define('PROTOCOL','http://');
    }
    if($config['development']==1){
      error_reporting(E_ALL);
      ini_set('display_errors','On');
    }else{
      error_reporting(E_ALL);
      ini_set('display_errors','Off');
      ini_set('log_errors','On');
      ini_set('error_log','..'.DS.'media'.DS.'cache'.DS.'error.log');
    }
  }
}catch(PDOException $e){
  require'core'.DS.'layout'.DS.'install.php';
  die();
}
