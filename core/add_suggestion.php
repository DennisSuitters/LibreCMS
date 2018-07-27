<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require_once'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
include'sanitise.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$r=isset($_POST['dar'])?filter_input(INPUT_POST,'dar',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
if($t=='content'||$t=='menu'||$t=='config'&&$c=='notes'||$c=='PasswordResetLayout'||$c=='orderEmailLayout'||$c=='orderEmailNotes'||$c=='passwordResetLayout'||$c=='accountActivationLayout'||$c=='bookingEmailLayout'||$c=='bookingAutoReplyLayout'||$c=='contactAutoReplyLayout'||$c=='dateFormat'||$c=='newslettersOptOutLayout'){
  $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'da',FILTER_UNSAFE_RAW);
}else{
  $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'da',FILTER_SANITIZE_STRING);
  $da=kses($da,array());
}
if(strlen($da)<12&&$da=='<p><br></p>')$da=str_replace('<p><br></p>','',$da);
if(strlen($da)<24&&$da=='%3Cp%3E%3Cbr%3E%3C/p%3E')$da=str_replace('%3Cp%3E%3Cbr%3E%3C/p%3E','',$da);
$si=session_id();
$ti=time();
$s=$db->prepare("INSERT INTO `".$prefix."suggestions` (rid,t,c,notes,reason,ti) VALUES (:rid,:t,:c,:notes,:r,:ti)");
$s->execute(
  array(
    ':rid'=>$id,
    ':t'=>$t,
    ':c'=>$c,
    ':notes'=>$da,
    ':r'=>$r,
    ':ti'=>$ti
  )
);
$s=$db->prepare("UPDATE ".$prefix.$t." SET suggestions=1 WHERE id=:id");
$s->execute(array(':id'=>$id));
echo'<div class="alert alert-success">Suggestion Saved.</div>';
