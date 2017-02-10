<script>/*<![CDATA[*/
<?php
if(session_status()==PHP_SESSION_NONE)session_start();
include'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$uid=$_SESSION['uid'];
$el='l_';
if($id!=0&&$tbl!='logs'){
  $s=$db->prepare("SELECT * FROM ".$tbl." WHERE id=:id");
  $s->execute(array(':id'=>$id));
  $r=$s->fetch(PDO::FETCH_ASSOC);
  if($tbl=='config'||$tbl=='login')
  $r['contentType']='';
  $nda='';
  foreach($r as$o)$nda.=$o.'|';
}
if($id==0&&$tbl=='logs'){
  $q=$db->query("DELETE FROM logs");
  $q->execute();
  $id='activity';
}
if($id==0&&$tbl=='tracker'){
  $q=$db->query("DELETE FROM tracker");
  $q->execute();
  $id='tracker';
}
if($tbl=='orders'){
  $q=$db->prepare("DELETE FROM orderitems WHERE oid=:oid");
  $q->execute(array(':oid'=>$id));
}
if($id!=0&&$id!='activity'){
  $q=$db->prepare("DELETE FROM $tbl WHERE id=:id");
  $q->execute(array(':id'=>$id));
}
if($tbl=='errorlog'){
    unlink('..'.DS.'media'.DS.'cache'.DS.'error.log');
    $el='l_';
    $id=0;
}
$e=$db->errorInfo();
if($tbl=='subscribers')$el='s_';
if(is_null($e[2])){?>
  window.top.window.$('#<?php echo$el.$id;?>').slideUp(500,function(){$(this).remove()});
<?php }
if($tbl=='logs'){?>
  window.top.window.$('#details<?php echo$id;?>').slideUp(500,function(){$(this).remove()});
<?php }?>
  window.top.window.Pace.stop();
/*]]>*/</script>
