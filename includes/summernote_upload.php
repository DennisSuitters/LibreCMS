<?php
include"db.php";
$config=$db->query("SELECT url FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
if($_FILES['file']['name']){
	if(!$_FILES['file']['error']){
		$name=md5(time());
		$ext=explode('.',$_FILES['file']['name']);
		$filename=strtolower($name.'.'.$ext[1]);
		$destination='../media/'.$filename;
		$location=$_FILES["file"]["tmp_name"];
		move_uploaded_file($location,$destination);
		echo'http://'.$_SERVER['HTTP_HOST'].$config[url].'media/'.$filename;
	}
}
