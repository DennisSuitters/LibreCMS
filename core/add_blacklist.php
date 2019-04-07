<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Add Blacklist Item
 *
 * add_blacklist.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Add Blacklist
 * @package    core/add_blacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix Notifications.
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
function localize($t){
  static $tr=NULL;
  global $config;
  if(is_null($tr)){
    if(file_exists('i18n'.DS.$config['language'].'.txt'))
      $lf='i18n'.DS.$config['language'].'.txt';
    else
      $lf='i18n'.DS.'en-AU.txt';
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
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
if($t=='comments')
  $s=$db->prepare("SELECT ip,ti FROM `".$prefix."comments` WHERE id=:id");
else
  $s=$db->prepare("SELECT ip,ti FROM `".$prefix."tracker` WHERE id=:id");
$s->execute([':id'=>$id]);
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $sql=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,ti) VALUES (:ip,:oti,:ti)");
  $sql->execute([
    ':ip'=>$r['ip'],
    ':oti'=>$r['ti'],
    ':ti'=>time()
  ]);
  echo localize('blacklist_ipadded');
}else
  echo localize('blacklist_ipexists');
echo'<script>window.top.window.$("[data-tooltip=`tooltip`]").tooltip(`hide`);</script>';
