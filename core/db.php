<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
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
    if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)
      define('PROTOCOL','https://');
    else
      define('PROTOCOL','http://');
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
