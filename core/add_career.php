<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Add Career Item
 *
 * add_career.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Add Career
 * @package    core/add_career.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
include'sanitise.php';
function svg2($svg,$class=null,$size=null){
	return'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
function localize($t){
  static $tr=NULL;
  global $config;
  if(is_null($tr)){
    if(file_exists('core'.DS.'i18n'.DS.$config['language'].'.txt'))
      $lf='core'.DS.'i18n'.DS.$config['language'].'.txt';
    else
      $lf='core'.DS.'i18n'.DS.'en-AU.txt';
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
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$title=isset($_POST['title'])?filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'title',FILTER_SANITIZE_STRING);
$business=isset($_POST['business'])?filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'business',FILTER_SANITIZE_STRING);
$tis=isset($_POST['tisx'])?filter_input(INPUT_POST,'tisx',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'tisx',FILTER_SANITIZE_STRING);
$tie=isset($_POST['tiex'])?filter_input(INPUT_POST,'tiex',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'tiex',FILTER_SANITIZE_STRING);
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'da',FILTER_UNSAFE_RAW);
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
if(strlen($da)<12&&$da=='<p><br></p>')
  $da=str_replace('<p><br></p>','',$da);
if(strlen($da)<24&&$da=='%3Cp%3E%3Cbr%3E%3C/p%3E')
  $da=str_replace('%3Cp%3E%3Cbr%3E%3C/p%3E','',$da);
$si=session_id();
$ti=time();
$s=$db->prepare("INSERT INTO `".$prefix."content` (cid,contentType,title,business,notes,tis,tie,ti) VALUES (:cid,'career',:title,:business,:notes,:tis,:tie,:ti)");
$s->execute([
  ':cid'=>$id,
  ':title'=>$title,
  ':business'=>$business,
  ':notes'=>$da,
  ':tis'=>$tis,
  ':tie'=>$tie,
  ':ti'=>$ti
]);
echo'<script>window.top.window.$("#careers").append(\'<div id="l_'.$id.'"><div class="form-group row"><div class="col-4"><input type="text" class="form-control" value="'.$title.'" readonly role="textbox"></div><div class="col-4"><input type="text" class="form-control" value='.$business.'" readonly role="textbox"></div><div class="col-2"><input type="text" class="form-control" value="'.($tis==0?localize('Current'):date('Y-M',$tis)).'" readonly role="textbox"></div><div class="col-2"><input type="text" class="form-control" value="'.($tie==0?localize('Current'):date('Y-M',$tie)).'" readonly role="textbox"></div></div><div class="form-group row"><div class="col"><div class="form-control" readonly>'.$da.'</div></div><div class="col-1"><button class="btn btn-secondary trash" onclick="purge(`'.$id.'`,`content`)" data-tooltip="tooltip" title="'.localize('Delete').'" role="button" aria-label="<?php echo localize('aria_delete');?>">'.svg2('libre-gui-trash').'</button></div></div><hr></div>\');</script>';
