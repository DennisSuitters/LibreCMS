<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo'<script>/*<![CDATA[*/';
if(session_status()==PHP_SESSION_NONE)
  session_start();
require'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$col=filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
$el='l_';
if($id!=0&&$tbl!='logs'){
  $s=$db->prepare("SELECT * FROM ".$prefix.$tbl." WHERE id=:id");
  $s->execute(
    array(
      ':id'=>$id
    )
  );
  $r=$s->fetch(PDO::FETCH_ASSOC);
  if($tbl=='config'||$tbl=='login')
    $r['contentType']='';
  $nda='';
  foreach($r as$o)$nda.=$o.'|';
}
if($tbl=='suggestions'){
  $s=$db->prepare("SELECT * FROM `".$prefix."suggestions` WHERE id=:id");
  $s->execute(
    array(
      ':id'=>$id
    )
  );
  if($s->rowCount()==1){
    $r=$s->fetch(PDO::FETCH_ASSOC);
    $ss=$db->prepare("UPDATE ".$prefix.$r['t']." SET suggestions=0 WHERE id=:id");
    $ss->execute(
      array(
        ':id'=>$r['rid']
      )
    );
  }
}
if($id==0&&$tbl=='iplist'){
  $q=$db->query("DELETE FROM `".$prefix."iplist`");
  $q->execute();
  $id=='iplist';
}
if($id==0&&$tbl=='logs'){
  $q=$db->query("DELETE FROM `".$prefix."logs`");
  $q->execute();
  $id='timeline';
}
if($id==0&&$tbl=='tracker'){
  $q=$db->query("DELETE FROM `".$prefix."tracker`");
  $q->execute();
  $id='tracker';
}
if($id==0&&$tbl=='pageviews'){
  $q=$db->query("UPDATE menu SET views='0'");
  $q->execute();
  $id='';
}
if($id==0&&$tbl=='contentviews'){
  $q=$db->prepare("UPDATE content SET views='0' WHERE contentType=:contentType");
  $q->execute(
    array(
      ':contentType'=>$col
    )
  );
  $id='';
}
if($tbl=='orders'){
  $q=$db->prepare("DELETE FROM `".$prefix."orderitems` WHERE oid=:oid");
  $q->execute(
    array(
      ':oid'=>$id
    )
  );
}
if($id!=0&&$id!='activity'){
  $q=$db->prepare("DELETE FROM `".$prefix.$tbl."` WHERE id=:id");
  $q->execute(
    array(
      ':id'=>$id
    )
  );
  if($tbl=='media')
    $el='media_items_';
}
if($tbl=='errorlog'){
  unlink('..'.DS.'media'.DS.'cache'.DS.'error.log');
  $el='l_';
  $id=0;
}
if($tbl=='choices'){?>
  window.top.window.$('#l_<?php echo$id;?>').addClass('animated zoomOut');
  window.top.window.setTimeout(function(){window.top.window.$('#l_<?php echo$id;?>').remove();},500);
  window.top.window.$('[data-tooltip="tooltip"], .tooltip').tooltip('hide');
<?php }
echo'/*]]>*/</script>';
