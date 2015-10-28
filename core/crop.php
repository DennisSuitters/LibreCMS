<?php
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$t=filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING);
$c=filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING);
$x=filter_input(INPUT_POST,'x',FILTER_SANITIZE_STRING);
$y=filter_input(INPUT_POST,'y',FILTER_SANITIZE_STRING);
$w=filter_input(INPUT_POST,'w',FILTER_SANITIZE_STRING);
$h=filter_input(INPUT_POST,'h',FILTER_SANITIZE_STRING);
require'db.php';
if($c=='thumb')$s=$db->prepare("SELECT file as img FROM ".$t." WHERE id=:id");
else $s=$db->prepare("SELECT ".$c." as img FROM ".$t." WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
if($c=='cover')$r['img']='media/'.$r['img'];
if($c=='coverURL'){
  if(file_exists('../media/'.$r['img'])){
    $r['img']='media/'.$r['img'];
  }else{
    $img = substr($r['img'], strrpos($r['img'], '/') + 1);
    copy($r['img'], '../media/'.$img);
    $s=$db->prepare("UPDATE ".$t." SET coverURL=:img WHERE id=:id");
    $s->execute(array(':img'=>$img,':id'=>$id));
    $r['img']='media/'.$img;
  }
}
if($c=='fileURL'){
  if(file_exists('../media/'.$r['img'])){
    $r['img']='media/'.$r['img'];
  }else{
    $img = substr($r['img'], strrpos($r['img'], '/') + 1);
    copy($r['img'], '../media/'.$img);
    $s=$db->prepare("UPDATE ".$t." SET fileURL=:img WHERE id=:id");
    $s->execute(array(':img'=>$img,':id'=>$id));
    $r['img']='media/'.$img;
  }
}
$im = imagecreatefromjpeg('../'.$r['img'] );
$to_crop_array = array('x' =>$x , 'y' => $y, 'width' => $w, 'height'=> $h);
$thumb_im = imagecrop($im, $to_crop_array);
imagejpeg($thumb_im, '../'.$r['img'], 100);
?>
<script>/*<![CDATA[*/
  window.top.window.$('#coverimg').html('<img src="<?php echo$r['img'];?>">');
  window.top.window.$('#media').modal('hide');
  window.top.window.$('#block').css({'display':'none'});
/*]]>*/</script>
