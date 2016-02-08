<?php
session_start();
require'db.php';
$tbl=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$col=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
if($uid>0){
	$su=$db->prepare("SELECT username,name FROM login WHERE id=:id");
	$su->execute(array(':id'=>$uid));
	$u=$su->fetch(PDO::FETCH_ASSOC);
	if($u['name']=='')$lu=$u['username'];else$lu=$u['name'];
}else$lu='';
$ti=time();
foreach($_GET['ord']as$p=>$i){
	$s=$db->prepare("UPDATE $tbl SET $col=:col,eti=:ti,uid=:uid,login_user=:lu WHERE id=:id");
	$s->execute(array(':id'=>$i,':col'=>$p,':ti'=>$ti,':uid'=>$uid,':lu'=>$lu));
}
