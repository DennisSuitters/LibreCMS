<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(session_status()==PHP_SESSION_NONE)
  session_start();
require_once'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
include'sanitise.php';
function svg2($svg,$class=null,$size=null){
	return'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
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
$s=$db->prepare("INSERT INTO `".$prefix."content` (cid,contentType,title,business,notes,tis,tie,ti) VALUES (:cid,'education',:title,:business,:notes,:tis,:tie,:ti)");
$s->execute(
  array(
    ':cid'=>$id,
    ':title'=>$title,
    ':business'=>$business,
    ':notes'=>$da,
    ':tis'=>$tis,
    ':tie'=>$tie,
    ':ti'=>$ti
  )
);

echo'<script>/*<![CDATA[*/';
echo'window.top.window.$("#education").append(\'<div id="l_'.$id.'">';
  echo'<div class="form-group row">';
    echo'<div class="col-4">';
      echo'<input type="text" class="form-control" value="'.$title.'" readonly>';
    echo'</div>';
    echo'<div class="col-4">';
      echo'<input type="text" class="form-control" value='.$business.'" readonly>';
    echo'</div>';
    echo'<div class="col-2">';
      echo'<input type="text" class="form-control" value="'.($tis==0?'Current':date('Y-M',$tis)).'" readonly>';
    echo'</div>';
    echo'<div class="col-2">';
      echo'<input type="text" class="form-control" value="'.($tie==0?'Current':date('Y-M',$tie)).'" readonly>';
    echo'</div>';
  echo'</div>';
  echo'<div class="form-group row">';
    echo'<div class="col">';
      echo'<div class="form-control" readonly>'.$da.'</div>';
    echo'</div>';
    echo'<div class="col-1">';
      echo'<button class="btn btn-secondary trash" onclick="purge(`'.$id.'`,`content`)" data-toggle="tooltip" title="Delete">'.svg2('libre-gui-trash').'</button>';
    echo'</div>';
  echo'</div>';
  echo'<hr>';
echo'</div>\');';
echo'/*]]>*/</script>';
