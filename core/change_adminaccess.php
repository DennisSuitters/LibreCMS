<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Change Admin Access Folder
 *
 * change_adminaccess.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Change Admin Access Folder
 * @package    core/change_adminaccess.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix Notifications.
 */
echo'<script>';
$getcfg=true;
require'db.php';
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$adminfolder=isset($_POST['adminfolder'])?filter_input(INPUT_POST,'adminfolder',FILTER_SANITIZE_STRING):'';
if($adminfolder==''){?>
  window.top.window.$('#adminfolder').addClass('is-invalid');
  window.top.window.toastr["danger"]('<?php echo localize('alert_adminaccess_danger_blank');?>');
<?php
}else{
  $s=$db->prepare("SELECT id FROM menu WHERE file LIKE :file");
  $s->execute([':file'=>$adminfolder]);
  if($s->rowCount()>0){?>
    window.top.window.$('#adminfolder').addClass('is-invalid');
    window.top.window.toastr["danger"]('<?php echo localize('alert_adminaccess_danger_badpage');?>');
<?php }elseif($adminfolder==$settings['system']['admin']){
  $htmladmin='<a href="'.URL.$settings['system']['admin'].'">'.URL.'</a>';?>
  window.top.window.$('#adminaccess').html(`<?php echo$htmladmin;?>`);
  window.top.window.$('#adminfolder').removeClass('is-invalid');
  window.top.window.toastr["info"]('<?php echo localize('alert_adminaccess_info_same');?>');
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
  window.top.window.toastr["success"]('<?php echo localize('alert_adminaccess_success_updated');?>');
<?php }
}
echo'</script>';
