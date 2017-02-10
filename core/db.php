<?php
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
try{
  $dns=((!empty($settings['database']['driver']))?($settings['database']['driver']):'').
  ((!empty($settings['database']['host']))?(':host='.$settings['database']['host']):'').
  ((!empty($settings['database']['port']))?(';port='.$settings['database']['port']):'').
  ((!empty($settings['database']['schema']))?(';dbname='.$settings['database']['schema']):'');
  $db=new PDO($dns,$settings['database']['username'],$settings['database']['password']);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  require'core'.DS.'layout'.DS.'install.php';
  die();
}
