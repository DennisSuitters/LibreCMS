<script>/*<![CDATA[*/
<?php
if(session_status()==PHP_SESSION_NONE)session_start();
include'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
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
  $id='timeline';
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
  if($tbl=='media')$el='media_items_';
}
if($tbl=='errorlog'){
    unlink('..'.DS.'media'.DS.'cache'.DS.'error.log');
    $el='l_';
    $id=0;
}
$e=$db->errorInfo();
if($tbl=='subscribers')$el='s_';
if(is_null($e[2])){
  if($tbl=='media'){?>
    window.top.window.$('#<?php echo$el.$id;?>').addClass('animated zoomOut');
    setTimeout(function(){window.top.window.$('#<?php echo$el.$id;?>').remove();},500);
<?php }else{?>
    window.top.window.$('#<?php echo$el.$id;?>').addClass('animated zoomOut');
    setTimeout(function(){window.top.window.$('#<?php echo$el.$id;?>').remove();},500);
<?php }
}
if($tbl=='logs'){?>
  window.top.window.$('#<?php echo$id;?>').slideUp(500,function(){$(this).remove()});
<?php }?>
  window.top.window.Pace.stop();
/*]]>*/</script>
