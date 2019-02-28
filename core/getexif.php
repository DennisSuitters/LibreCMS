<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Get EXIF Image Information
 *
 * getexif.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Get EXIF Image Information
 * @package    core/getexif.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
echo'<script>window.top.window.$("#notification").html("");';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$s=$db->prepare("SELECT file FROM ".$prefix."$t WHERE id=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
if($r['file']!=''){
  switch($c){
    case'exifFilename':
      $out=basename($r['file']);
      break;
    case'exifCamera':
      $out='Camera';
      break;
    case'exifLens':
      $out='Lens';
      break;
    case'exifAperture':
      $out='Aperture';
      break;
    case'exifFocalLength':
      $out='Focal Length';
      break;
    case'exifShutterSpeed':
      $out='Shutter Speed';
      break;
    case'exifISO':
      $out='ISO';
      break;
    case'exifti':
      $out=time();
      break;
    default:
      $out='nothing';
  }
  $s=$db->prepare("UPDATE ".$prefix."$t SET $c=:out WHERE id=:id");
  $s->execute([
    ':id'=>$id,
    ':out'=>$out
  ]);?>
  window.top.window.$('#<?php echo$c;?>').val('<?php echo$out;?>');
<?php }else{?>
  window.top.window.$('#notification').html('<div class="alert alert-info">There is no image to get the EXIF Info from.</div>');
<?php }?>
  window.top.window.Pace.stop();
<?php
echo'</script>';
