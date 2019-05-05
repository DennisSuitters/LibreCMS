<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Add Category
 *
 * add_category.php version 2.0.3
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Add Category Option
 * @package    core/add_category.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.3
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.3 Create File
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
define('ADMINNOAVATAR','core'.DS.'images'.DS.'libre-gui-noavatar.svg');
function svg($svg,$class=null,$size=null){
	echo'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
function localize($t){
  static $tr=NULL;
  global $config;
  if(is_null($tr)){
    if(file_exists('i18n'.DS.$config['language'].'.txt'))
      $lf='i18n'.DS.$config['language'].'.txt';
    else
      $lf='i18n'.DS.'en-AU.txt';
    $lfc=file_get_contents($lf);
    $tr=json_decode($lfc,true);
  }
  if(is_array($tr)){
    if(!array_key_exists($t,$tr))
      echo'Error: No "'.$t,'" Key in '.$config['language'];
    else
      return$tr[$t];
  }else
    echo'Error: '.$config['language'].' is malformed';
}
//$cat=isset($_POST['cat'])?filter_input(INPUT_POST['cat'],FILTER_SANITIZE_STRING):'';
$cat=filter_var($_POST['cat'],FILTER_SANITIZE_STRING);
$ct=isset($_POST['ct'])?filter_input(INPUT_POST,'ct',FILTER_SANITIZE_STRING):'';
$icon=isset($_POST['icon'])?filter_input(INPUT_POST,'icon',FILTER_SANITIZE_STRING):'';
if($cat!=''){
  $s=$db->prepare("INSERT INTO `".$prefix."choices` (contentType,icon,url,title) VALUES ('category',:icon,:c,:t)");
  $s->execute([
		':c'=>$ct,
		':icon'=>$icon,
		':t'=>$cat
	]);
  $id=$db->lastInsertId();?>
<script>
  window.top.window.$('#category').append('<div id="l_<?php echo$id;?>" class="form-group row"><div class="input-group col"><label for="cat<?php echo$id;?>" class="input-group-text"><?php echo localize('Category');?></label><input type="text" id="cat<?php echo$id;?>" class="form-control" value="<?php echo$cat;?>" readonly role="textbox"><label for="ct<?php echo$id;?>" class="input-group-text"><?php echo localize('Content');?></label><input type="text" id="ct<?php echo$id;?>" class="form-control" value="<?php echo$ct;?>" readonly role="textbox"><div class="input-group-text"><?php echo localize('Image');?></div><div class="input-group-append img"><?php echo$icon!=''?'<a href="'.$icon.'" data-lightbox="lightbox"><img id="thumbimage" src="'.$icon.'" alt="Thumbnail"></a>':'<img id="thumbimage" src="core/images/noimage.png" alt="No Image">';?></div><div class="input-group-append"><form target="sp" action="core/purge.php" role="form"><input type="hidden" name="id" value="<?php echo$id;?>"><input type="hidden" name="t" value="choices"><button class="btn btn-secondary trash" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button></form></div></div></div>');
</script>
<?php }

