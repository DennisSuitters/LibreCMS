<?php
if(file_exists('core/config.ini'))$settings=parse_ini_file('core/config.ini',TRUE);
else$settings=parse_ini_file('config.ini',TRUE);
try{
	$dns=$settings['database']['driver'].':host='.$settings['database']['host'].((!empty($settings['database']['port']))?(';port='.$settings['database']['port']):'').';dbname='.$settings['database']['schema'];
	$db=new PDO($dns,$settings['database']['username'],$settings['database']['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){echo'ERROR: '.$e->getMessage();}
