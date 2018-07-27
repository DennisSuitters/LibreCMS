<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require_once'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT ip,ti FROM `".$prefix."comments` WHERE id=:id");
$s->execute(array(':id'=>$id));
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $sql=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,ti) VALUES (:ip,:oti,:ti)");
  $sql->execute(array(
    ':ip'=>$r['ip'],
    ':oti'=>$r['ti'],
    ':ti'=>time()
  ));
  echo'<script>/*<![CDATA[*/window.top.window.$("#blacklist'.$id.'").addClass("hidden");/*]]>*/</script>';
}
