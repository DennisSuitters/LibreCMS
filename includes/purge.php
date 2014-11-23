<?php
session_start();
include'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
if($tbl=='tracker'){
	$q=$db->prepare("DELETE FROM tracker WHERE vid=:vid");
	$q->execute(array(':vid'=>$id));
}
if($tbl=='orders'){
	$q=$db->prepare("DELETE FROM orderitems WHERE oid=:oid");
	$q->execute(array(':oid'=>$id));
}
if($tbl=='content'){
	$q=$db->prepare("SELECT thumb,file FROM content WHERE id=:id");
	$q->execute(array(':id'=>$id));
	$r=$q->fetch();
	if($r[thumb]!=''){unlink("../files/".$r[thumb]);}
	if($r[file]!=''){unlink("../files/".$r[file]);}
}
$q=$db->prepare("DELETE FROM $tbl WHERE id=:id");
$q->execute(array(':id'=>$id));
$e=$db->errorInfo();?>
<script>/*<![CDATA[*/
<?php if(is_null($e[2])){?>
	window.top.window.$('#l_<?php echo$id;?>').slideUp(500,function(){$(this).remove()});
<?php }?>
	window.top.window.$('#busy').css("display","none");
/*]]>*/</script>
