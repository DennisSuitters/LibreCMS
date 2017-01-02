<?php
if(file_exists('core/config.ini'))
  $settings=parse_ini_file('core/config.ini',TRUE);
elseif(file_exists('../core/config.ini'))
  $settings=parse_ini_file('../core/config.ini',TRUE);
elseif(file_exists('config.ini'))
  $settings=parse_ini_file('config.ini',TRUE);
else{
    require'core/layout/install.php';
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
  require'core/layout/install.php';
  die();
}
