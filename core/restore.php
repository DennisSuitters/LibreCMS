<?php
session_start();
include'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$uid=$_SESSION['uid'];
$s=$db->prepare("SELECT * FROM logs WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
$tbl=$r['refTable'];
$col=$r['refColumn'];
$sl=$db->prepare("UPDATE $tbl SET $col=:da WHERE id=:id");
$sl->execute(array(
	':da'=>$r['oldda'],
	':id'=>$r['rid']
));
?>
<script>/*<![CDATA[*/
	window.top.window.$('#busy').css("display","none");
/*]]>*/</script>
