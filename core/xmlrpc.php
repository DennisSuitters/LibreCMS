<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(session_status()==PHP_SESSION_NONE)
  session_start();
require'db.php';
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$ti=time();
echo'Thank you for giving the system an excuse to Blacklist your IP... <strong>'.$ip.'</strong>';
$s=$db->prepare("DELETE FROM `".$prefix."iplist` WHERE ti<:ti");
$s->execute(array(':ti'=>time()-2592000));
$s=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");
$s->execute(
  array(
    ':ip'=>$ip
  )
);
if($s->rowCount()<1){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $sql=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,ti) VALUES (:ip,:oti,:ti)");
  $sql->execute(array(
    ':ip'=>$ip,
    ':oti'=>$ti,
    ':ti'=>time()
  ));
}
