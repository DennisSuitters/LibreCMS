<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Upgrade
 *
 * upgrade.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Upgrade
 * @package    core/upgrade.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix Notifications.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
ini_set('max_execution_time',60);
require'db.php';
$config=$db->query("SELECT language,update_url,development FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
function localize($t){
  static $tr=NULL;
  global $config;
  if(is_null($tr)){
    if(file_exists('i18n'.DS.$config['language'].'.txt'))
      $lf='i18n'.DS.$config['language'].'.txt';
    else
      $lf='core'.DS.'i18n'.DS.'en-AU.txt';
    $lfc=file_get_contents($lf);
    $tr=json_decode($lfc,true);
  }
  if(is_array($tr)){
    if(!array_key_exists($t,$tr))
      echo'Error: No "'.$t,'" Key in '.$config['language'];
    else
      return$tr[$t];
  }else
    echo'Error: '.$config['language'].' is malformed';
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
echo'<script>';
  'window.top.window.$(`#updateheading`).html(`<?php echo localize('System Updates');?>...`);'.
  'window.top.window.$(`#update`).html(``);';
$settings=parse_ini_file('config.ini',TRUE);
$gV=file_get_contents($config['update_url'].'versions');
$update=0;
$uL='';
$found=true;
$vL=explode("\n",$gV);
foreach($vL as $aV){
  if($aV=='')continue;
  if($aV<$settings['system']['version'])continue;
  if(!is_file('..'.DS.'media'.DS.'updates'.DS.$aV.'.zip')){
  echo'window.top.window.$(`#update`).append(`<div class="alert alert-info" role="alert">'.localize('alert_upgrade_info_download').'...</div>`);';
   if(false===file_get_contents($config['update_url'].$aV.".zip",0,null,0,1)){
    $found=false;
    echo'window.top.window.$(`#update`).append(`<div class="alert alert-danger" role="alert">'.localize('alert_upgrade_danger_nofile').'...</div>`);';
  }else{
    $newUpdate=file_get_contents($config['update_url'].$aV.'.zip');
    if(!is_dir('..'.DS.'media'.DS.'updates'.DS))
      mkdir('..'.DS.'media'.DS.'updates'.DS);
    $dlHandler=fopen('..'.DS.'media'.DS.'updates'.DS.$aV.'.zip','w');
    if(!fwrite($dlHandler,$newUpdate)){
      $found=false;
      echo'window.top.window.$(`#update`).append(`<div class="alert alert-danger" role="alert">'.localize('alert_upgrade_danger_notsaved').'</div>`);';
      exit();
    }
    fclose($dlHandler);
    echo'window.top.window.$(`#update`).append(`<div class="alert alert-success" role="alert">'.localize('alert_upgrade_info_downloaded').'...</div>`);';
    }
  }else{
    echo'window.top.window.$(`#update`).append(`<div class="alert alert-info" role="alert">'.localize('alert_upgrade_info_alreadydownloaded').'....</div>`);';
  }
if($found==true){
  $zipHandle=zip_open('..'.DS.'media'.DS.'updates'.DS.$aV.'.zip');
  $html='<ul>';
  while($aF=zip_read($zipHandle)){
    $thisFileName=zip_entry_name($aF);
    $thisFileDir=dirname($thisFileName);
    if(substr($thisFileName,-1,1)=='/')continue;
    if(!is_dir('..'.DS.$thisFileDir)){
      mkdir('..'.DS.$thisFileDir );
      $html.='<li>Created Directory '.$thisFileDir.'</li>';
    }
    if(!is_dir('..'.DS.$thisFileName)){
      $html.='<li>'.$thisFileName.'...........';
      $contents=zip_entry_read($aF,zip_entry_filesize($aF));
      $updateThis='';
      if($thisFileName=='core'.DS.'upgrade.sql'){
        $prefix=$settings['database']['prefix'];
  			$sql=file_get_contents('core'.DS.'upgrade.sql');
  			$sql=str_replace([
  					"CREATE TABLE `",
  					"INSERT INTO `",
  					"ALTER TABLE `"
  				],[
  					"CREATE TABLE `".$prefix,
  					"INSERT INTO `".$prefix,
  					"ALTER TABLE `".$prefix
  				],$sql);
  			$q=$db->exec($sql);
  			$e=$db->errorInfo();        
        $upgradeExec=fopen('doupgrade.php','w');
        fwrite($upgradeExec,$contents);
        fclose($upgradeExec);
        include('doupgrade.php');
        unlink('doupgrade.php');
        $html.=' <strong class="text-success">'.localize('SQL EXECUTED').'</strong></li>';
      }else{
        $updateThis=fopen('..'.DS.$thisFileName,'w');
        fwrite($updateThis,$contents);
        fclose($updateThis);
        unset($contents);
        $html.=' <strong class="text-success">'.localize('UPDATED').'</strong></li>';
      }
    }
  }
  echo'window.top.window.$(`#update`).append(`'.$html.'`);';
  $updated=TRUE;
  $txt='[database]'.PHP_EOL;
  $txt.='driver = '.$settings['database']['driver'].PHP_EOL;
  $txt.='host = '.$settings['database']['host'].PHP_EOL;
  if(isset($settings['database']['port'])=='')
    $txt.=';port = 3306'.PHP_EOL;
  else
    $txt.='port = '.$settings['database']['post'].PHP_EOL;
  $txt.='schema = '.$settings['database']['schema'].PHP_EOL;
  $txt.='username = '.$settings['database']['username'].PHP_EOL;
  $txt.='password = '.$settings['database']['password'].PHP_EOL;
  $txt.='[system]'.PHP_EOL;
  $txt.='version = '.time().PHP_EOL;
  $txt.='url = '.$settings['system']['url'].PHP_EOL;
  $txt.='admin = '.$settings['system']['admin'].PHP_EOL;
  if(file_exists('config.ini'))unlink('config.ini');
  $oFH=fopen("config.ini",'w');
  fwrite($oFH,$txt);
  fclose($oFH);
  echo'window.top.window.$(`#update`).append(`<div class="alert alert-success" role="alert">'.localize('alert_upgrade_success_config').'</div>`);';
  }else{
  echo'window.top.window.$(`#update`).append(`<div class="alert alert-danger" role="alert">'.localize('alert_upgrade_danger_noupdate').'</div>`);';
  }
}
$su=$db->prepare("UPDATE config SET uti=:uti WHERE id='1'");
$su->execute([':uti'=>time()]);
  echo'window.top.window.Pace.stop();'.
'</script>';
