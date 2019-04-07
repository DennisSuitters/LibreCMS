<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Magic Image
 *
 * magicimage.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Magic Image
 * @package    core/magicimage.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix Notifications.
 */
echo'<script>';
$getcfg=true;
require'db.php';
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
$s=$db->prepare("SELECT id,file,thumb FROM `".$prefix."content` WHERE id=:id");
$s->execute([':id'=>$id]);
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
  window.top.window.toastr["danger"]('<?php echo localize('alert_magicimage_danger_error');?>);
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
  window.top.window.toastr["danger"]('<?php echo localize('alert_magicimage_danger_notfound');?>');
<?php   break;
      case 2:?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_magicimage_danger_unreadable');?>');
<?php   break;
      case 3:?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_magicimage_danger_unwritable');?>');
<?php   break;
      case 4:?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_magicimage_danger_unsupportedsource');?>');
<?php   break;
      case 5:?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_magicimage_danger_unsupportedtarget');?>');
<?php   break;
      case 6:?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_magicimage_danger_unsupportedtarget');?>');
<?php   break;
      case 7:?>
  window.top.window.toastr["danger"](<?php echo localize('alert_magicimage_danger_nogd');?>);
<?php   break;
      case 8:?>
  window.top.window.toastr["danger"](<?php echo localize('alert_magicimage_danger_nochmod');?>');
<?php   break;
      case 9:?>
  window.top.window.toastr["danger"](<?php echo localize('alert_magicimage_danger_noexif');?>');
<?php   break;
    }
  }else{
    if($act=='thumb'){
      $s=$db->prepare("UPDATE content SET thumb=:thumb WHERE id=:id");
      $s->execute([
        ':thumb'=>URL.'media'.DS.$imgdest,
        ':id'=>$id
      ]);?>
  window.top.window.$('#thumbimage').attr('src','<?php echo'media'.DS.$imgdest.'?'.time();?>');
  window.top.window.$('#thumb').val('<?php echo URL.'media'.DS.$imgdest.'?'.time();?>');
<?php } else {?>
  window.top.window.$('#fileimage').attr('src','<?php echo'media'.DS.$imgdest.'?'.time();?>');
  window.top.window.$('#file').val('<?php echo URL.'media'.DS.$imgdest.'?'.time();?>');
<?php }
  }
}
echo'</script>';
