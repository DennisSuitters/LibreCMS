<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo'<script>/*<![CDATA[*/';
$getcfg=true;
require_once'db.php';
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$adminfolder=isset($_POST['adminfolder'])?filter_input(INPUT_POST,'adminfolder',FILTER_SANITIZE_STRING):'';
if($adminfolder==''){?>
  window.top.window.$('#adminfolder').addClass('is-invalid');
  window.top.window.toastr["error"]("Folder must NOT be blank!<br>Change not saved!");
<?php
}else{
  $s=$db->prepare("SELECT id FROM menu WHERE file LIKE :file");
  $s->execute(array(':file'=>$adminfolder));
  if($s->rowCount()>0){?>
    window.top.window.$('#adminfolder').addClass('is-invalid');
    window.top.window.toastr["error"]("Folder must NOT be the same as an already existing Page!<br>Change not saved!");
<?php }elseif($adminfolder==$settings['system']['admin']){
  $htmladmin='<a href="'.URL.$settings['system']['admin'].'">'.URL.'</a>';?>
  window.top.window.$('#adminaccess').html(`<?php echo$htmladmin;?>`);
  window.top.window.$('#adminfolder').removeClass('is-invalid');
  window.top.window.toastr["info"]("Administration Access Folder Still The Same!");
<?php }else{
  $txt='[database]'.PHP_EOL.
       'prefix = '.$settings['database']['prefix'].PHP_EOL.
       'driver = '.$settings['database']['driver'].PHP_EOL.
       'host = '.$settings['database']['host'].PHP_EOL.
       (isset($settings['database']['port'])==''?';port = 3306'.PHP_EOL:'port = '.$settings['database']['port'].PHP_EOL).
       'schema = '.$settings['database']['schema'].PHP_EOL.
       'username = '.$settings['database']['username'].PHP_EOL.
       'password = '.$settings['database']['password'].PHP_EOL.
       '[system]'.PHP_EOL.
       'version = '.time().PHP_EOL.
       'url = '.$settings['system']['url'].PHP_EOL.
       'admin = '.$adminfolder.PHP_EOL;
  if(file_exists('config.ini'))
    unlink('config.ini');
  $oFH=fopen("config.ini",'w');
  fwrite($oFH,$txt);
  fclose($oFH);
  $htmladmin='<a href="'.URL.$adminfolder.'">'.URL.'</a>';?>
  window.top.window.$('#adminfolder').addClass('is-valid');
  window.top.window.$('#adminaccess').html(`<?php echo$htmladmin;?>`);
  window.top.window.toastr["success"]("Administration Access Folder Updated!");
<?php }
}
echo'/*]]>*/</script>';