<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Add Category
 *
 * add_mailbox.php version 2.0.3
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Add Mailbox
 * @package    core/add_mailbox.php
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
$uid=isset($_POST['uid'])?filter_input(INPUT_POST,'uid',FILTER_SANITIZE_NUMBER_INT):'';
$type=$_POST['t'];
$port=isset($_POST['port'])?filter_input(INPUT_POST,'port',FILTER_SANITIZE_NUMBER_INT):'';
$flag=isset($_POST['f'])?filter_input(INPUT_POST,'f',FILTER_SANITIZE_STRING):'';
$url=isset($_POST['url'])?filter_input(INPUT_POST,'url',FILTER_SANITIZE_STRING):'';
$mailusr=isset($_POST['mailusr'])?filter_input(INPUT_POST,'mailusr',FILTER_SANITIZE_STRING):'';
$mailpwd=isset($_POST['mailpwd'])?filter_input(INPUT_POST,'mailpwd',FILTER_SANITIZE_STRING):'';
if($port!=''&&$url!=''&&$mailusr!=''&&$mailpwd!=''){
  $s=$db->prepare("INSERT INTO `".$prefix."choices` (uid,contentType,type,port,flag,url,username,password) VALUES (:uid,'mailbox',:type,:port,:flag,:url,:username,:password)");
  $s->execute([
		':uid'=>$uid,
		':type'=>$type,
		':port'=>$port,
		':flag'=>$flag,
		':url'=>$url,
		':username'=>$mailusr,
		':password'=>$mailpwd
	]);
  $id=$db->lastInsertId();?>
<script>
  window.top.window.$('#mailboxes').append('<div id="l_<?php echo$id;?>" class="form-group row"><div class="input-group"><label for="type<?php echo$id;?>" class="input-group-text"><?php echo localize('Type');?></label><input type="text" id="type<?php echo$id;?>" class="form-control" value="<?php echo strtoupper($type);?>" readonly role="textbox"><label for="port<?php echo$id;?>" class="input-group-text"><?php echo localize('Port');?></label><input type="text" id="port<?php echo$id;?>" class="form-control" value="<?php echo$port;?>" readonly role="textbox"><label for="flag<?php echo$id;?>" class="input-group-text"><?php echo localize('Flag');?></label><input type="text" id="flag<?php echo$id;?>" class="form-control" value="<?php echo$flag;?>" readonly role="textbox"></div><div class="input-group"><label for="url<?php echo$id;?>" class="input-group-text"><?php echo localize('Server');?></label><input type="text" id="url<?php echo$id;?>" class="form-control" value="<?php echo$url;?>" readonly role="textbox"><label for="mailusr<?php echo$id;?>" class="input-group-text"><?php echo localize('Username');?></label><input type="text" id="mailusr<?php echo$id;?>" class="form-control" value="<?php echo$mailusr;?>" readonly role="textbox"><label for="mailpwd<?php echo$id;?>" class="input-group-text"><?php echo localize('Password');?></label><input type="text" id="mailpwd<?php echo$id;?>" class="form-control" value="<?php echo$mailpwd;?>" readonly role="textbox"><div class="input-group-append"><form target="sp" action="core/purge.php" role="form"><input type="hidden" name="id" value="<?php echo$id;?>"><input type="hidden" name="t" value="choices"><button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button></form></div></div></div>');
</script>
<?php }
