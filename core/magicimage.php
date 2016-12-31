<script>/*<![CDATA[*/
<?php
include'db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
define('DS',DIRECTORY_SEPARATOR);
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
define('THEME','..'.DS.'layout'.DS.$config['theme']);
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
$s=$db->prepare("SELECT id,file,thumb FROM content WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
require'zebra_image.php';
$image=new Zebra_Image();
$image->auto_handle_exif_orientation=false;
if($act=='thumb'){
  if(!file_exists($r['thumb'])){
    $imgsrc=basename($r['file']);
    $imgdest='t_'.$imgsrc;
    $width=$theme['settings']['thumb_width'];
    $height=$theme['settings']['thumb_height'];
    $process=true;
  }elseif($r['thumb']!=''&&file_exists($r['thumb'])){
    $imgsrc=basename($r['thumb']);
    $imgdest=$imgsrc;
    $width=$theme['settings']['thumb_width'];
    $height=$theme['settings']['thumb_height'];
    $process=true;
  }else{
    $process=false;?>
  window.top.window.$('#error').html('<div class="alert alert-danger">The file set as the Thumbnail does NOT exists on the server!</div>');
<?php }
}
if($act=='file'){
  if($r['file']=='')$process=false;
  else{
    $imgsrc=basename($r['file']);
    $imgdest=$imgsrc;
    $width=$theme['settings']['image_width'];
    $height=$theme['settings']['image_height'];
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
  window.top.window.$('#error').html('<div class="alert alert-danger">Source file could not be found!</div>');
<?php   break;
      case 2:?>
  window.top.window.$('#error').html('<div class="alert alert-danger">Source file is not readable!</div>');
<?php   break;
      case 3:?>
  window.top.window.$('#error').html('<div class="alert alert-danger">Could not write target file!</div>');
<?php   break;
      case 4:?>
  window.top.window.$('#error').html('<div class="alert alert-danger">Unsupported source file format!</div>');
<?php   break;
      case 5:?>
  window.top.window.$('#error').html('<div class="alert alert-danger">Unsupported target file format!</div>');
<?php   break;
      case 6:?>
  window.top.window.$('#error').html('<div class="alert alert-danger">GD library version does not support target file format!</div>');
<?php   break;
      case 7:?>
  window.top.window.$('#error').html('<div class="alert alert-danger">GD library is not installed!</div>');
<?php   break;
      case 8:?>
  window.top.window.$('#error').html('<div class="alert alert-danger">"chmod" command is disabled via configuration!</div>');
<?php   break;
      case 9:?>
  window.top.window.$('#error').html('<div class="alert alert-danger">"exif_read_data" function is not available</div>');
<?php   break;
    }
  }else{
    if($act=='thumb'){
      $s=$db->prepare("UPDATE content SET thumb=:thumb WHERE id=:id");
      $s->execute(array(':thumb'=>URL.'media'.DS.$imgdest,':id'=>$id));?>
  window.top.window.$('#thumbimage').attr('src','<?php echo'media'.DS.$imgdest;?>');
  window.top.window.$('#thumb').val('<?php echo URL.'media'.DS.$imgdest;?>');
<?php }else{?>
  window.top.window.$('#fileimage').attr('src','<?pgp echo'media'.DS.$imgdest;?>');
  window.top.window.$('#file').val('<?php echo URL.'media'.DS.$imgdest;?>');
<?php }
  }
}?>
/*]]>*/</script>
