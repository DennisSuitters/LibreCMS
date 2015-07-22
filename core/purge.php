<?php
session_start();
include'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$uid=$_SESSION['uid'];
$s=$db->prepare("SELECT * FROM ".$tbl." WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
$nda='';
foreach($r as $o){
	$nda.=$o.'|';
}
$s=$db->prepare("INSERT INTO logs (
	uid,rid,view,contentType,refTable,refColumn,oldda,newda,action,ti
) VALUES (
	:uid,:rid,:view,:contentType,:refTable,:refColumn,:oldda,:newda,:action,:ti)");
$s->execute(array(
	':uid'=>$uid,
	':rid'=>$id,
	':view'=>$r['contentType'],
	':contentType'=>$r['contentType'],
	':refTable'=>$tbl,
	':refColumn'=>'all',
	':oldda'=>$nda,
	':newda'=>'',
	':action'=>'purge',
	':ti'=>time()
));
if($tbl=='tracker'){
	$q=$db->prepare("DELETE FROM tracker WHERE vid=:vid");
	$q->execute(array(':vid'=>$id));
}
if($tbl=='orders'){
	$q=$db->prepare("DELETE FROM orderitems WHERE oid=:oid");
	$q->execute(array(':oid'=>$id));
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
