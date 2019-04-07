<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Add Suggestion
 *
 * add_suggestion.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Add Suggestion
 * @package    core/add_suggestion.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
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
include'sanitise.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$r=isset($_POST['dar'])?filter_input(INPUT_POST,'dar',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'dar',FILTER_SANITIZE_STRING);
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
if($t=='content'||$t=='menu'||$t=='config'&&$c=='notes'||$c=='PasswordResetLayout'||$c=='orderEmailLayout'||$c=='orderEmailNotes'||$c=='passwordResetLayout'||$c=='accountActivationLayout'||$c=='bookingEmailLayout'||$c=='bookingAutoReplyLayout'||$c=='contactAutoReplyLayout'||$c=='dateFormat'||$c=='newslettersOptOutLayout'){
  $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'da',FILTER_UNSAFE_RAW);
}else{
  $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'da',FILTER_SANITIZE_STRING);
  $da=kses($da,array());
}
if(strlen($da)<12&&$da=='<p><br></p>')
  $da=str_replace('<p><br></p>','',$da);
if(strlen($da)<24&&$da=='%3Cp%3E%3Cbr%3E%3C/p%3E')
  $da=str_replace('%3Cp%3E%3Cbr%3E%3C/p%3E','',$da);
$si=session_id();
$ti=time();
$s=$db->prepare("INSERT INTO `".$prefix."suggestions` (rid,t,c,notes,reason,ti) VALUES (:rid,:t,:c,:notes,:r,:ti)");
$s->execute([
  ':rid'=>$id,
  ':t'=>$t,
  ':c'=>$c,
  ':notes'=>$da,
  ':r'=>$r,
  ':ti'=>$ti
]);
$s=$db->prepare("UPDATE ".$prefix.$t." SET suggestions=1 WHERE id=:id");
$s->execute([':id'=>$id]);
echo'<div class="alert alert-success" role="alert">'.localize('Suggestion Saved').'</div>';
