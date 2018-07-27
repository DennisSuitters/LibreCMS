<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo'<script>/*<![CDATA[*/';
if(session_status()==PHP_SESSION_NONE)session_start();
require_once'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$uid=$_SESSION['uid'];
$s=$db->prepare("SELECT * FROM `".$prefix."logs` WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
$tbl=$r['refTable'];
$col=$r['refColumn'];
$sl=$db->prepare("UPDATE `".$prefix.$tbl."` SET $col=:da WHERE id=:id");
$sl->execute(
  array(
    ':da'=>$r['oldda'],
    ':id'=>$r['rid']
  )
);
if($col=='notes'){?>
  if(window.top.window.$('.summernote')){
    window.top.window.$('.summernote').summernote('code','<?php echo rawurldecode($r['oldda']);?>');
  }
<?php }else{?>
  if(window.top.window.$('#<?php echo$col;?>')){
    window.top.window.$('#<?php echo$col;?>').val('<?php echo$r['oldda'];?>');
  }
<?php }?>
  window.top.window.Pace.stop();
<?php
echo'/*]]>*/</script>';
