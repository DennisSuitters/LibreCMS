<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo'<script>/*<![CDATA[*/';
$getcfg=true;
require_once'db.php';
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
$s=$db->prepare("SELECT id,file,thumb FROM `".$prefix."content` WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
include'zebra_image.php';
$image=new Zebra_Image();
$image->auto_handle_exif_orientation=false;
if($act=='thumb'){
  if(!file_exists($r['thumb'])){
    $imgsrc=basename($r['file']);
    $imgdest='t_'.$imgsrc;
    $width=$config['mediaMaxWidthThumb'];
    $height=$config['mediaMaxHeightThumb'];
    $process=true;
  }elseif($r['thumb']!=''&&file_exists($r['thumb'])){
    $imgsrc=basename($r['thumb']);
    $imgdest=$imgsrc;
    $width=$config['mediaMaxWidthThumb'];
    $height=$config['mediaMaxHeightThumb'];
    $process=true;
  }else{
    $process=false;?>
  window.top.window.$.notify({type:'danger',icon:'',message:'The file set as the Thumbnail does NOT exists on the server!'});
<?php }
}
if($act=='file'){
  if($r['file']=='')
    $process=false;
  else{
    $imgsrc=basename($r['file']);
    $imgdest=$imgsrc;
    $width=$config['mediaMaxWidth'];
    $height=$config['mediaMaxHeight'];
    $process=true;
  }
}
if($process==true){
  $image->source_path='..'.DS.'media'.DS.$imgsrc;
  $image->target_path='..'.DS.'media'.DS.$imgdest;
  $image->jpeg_quality=100;
  $image->preserve_aspect_ratio=true;
  $image->enlarge_smaller_images=true;
  $image->preserve_time=true;
  $image->handle_exif_orientation_tag=true;
  if(!$image->resize($width,$height,ZEBRA_IMAGE_CROP_CENTER)){
    switch($image->error){
      case 1:?>
  window.top.window.$.notify({type:'danger',icon:'',message:'Source file could not be found!'});
<?php   break;
      case 2:?>
  window.top.window.$.notify({type:'danger',icon:'',message:'Source file is not readable!'});
<?php   break;
      case 3:?>
  window.top.window.$.notify({type:'danger',icon:'',message:'Could not write target file!'});
<?php   break;
      case 4:?>
  window.top.window.$.notify({type:'danger',icon:'',message:'Unsupported source file format!'});
<?php   break;
      case 5:?>
  window.top.window.$.notify({type:'danger',icon:'',message:'Unsupported target file format!'});
<?php   break;
      case 6:?>
  window.top.window.$.notify({type:'danger',icon:'',message:'GD library version does not support target file format!'});
<?php   break;
      case 7:?>
  window.top.window.$.notify({type:'danger',icon:'',message:'GD library is not installed!'});
<?php   break;
      case 8:?>
  window.top.window.$.notify({type:'danger',icon:'',message:'"chmod" command is disabled via configuration!'});
<?php   break;
      case 9:?>
  window.top.window.$.notify({type:'danger',icon:'',message:'"exif_read_data" function is not available!'});
<?php   break;
    }
  }else{
    if($act=='thumb'){
      $s=$db->prepare("UPDATE content SET thumb=:thumb WHERE id=:id");
      $s->execute(
        array(
          ':thumb'=>URL.'media'.DS.$imgdest,
          ':id'=>$id
        )
      );?>
  window.top.window.$('#thumbimage').attr('src','<?php echo'media'.DS.$imgdest.'?'.time();?>');
  window.top.window.$('#thumb').val('<?php echo URL.'media'.DS.$imgdest.'?'.time();?>');
<?php } else {?>
  window.top.window.$('#fileimage').attr('src','<?php echo'media'.DS.$imgdest.'?'.time();?>');
  window.top.window.$('#file').val('<?php echo URL.'media'.DS.$imgdest.'?'.time();?>');
<?php }
  }
}
echo'/*]]>*/</script>';
