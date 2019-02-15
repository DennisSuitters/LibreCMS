<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require'..'.DS.'db.php';
$idh=time();
echo'<div id="pathviewer'.$idh.'" class="table-responsive">';
define('URL', PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$sg=$db->prepare("SELECT ip FROM `".$prefix."tracker` WHERE id=:id");
$sg->execute(array(':id'=>$id));
$gr=$sg->fetch(PDO::FETCH_ASSOC);
$s=$db->prepare("SELECT * FROM `".$prefix."tracker` WHERE ip=:ip ORDER BY ti ASC");
$s->execute(array(':ip'=>$gr['ip']));
if($s->rowCount()>0){
  echo'<table class="table table-condensed table-striped table-hover">';
    echo'<thead><tr><th>URL From</th><th>URL Dest</th><th>Date</th><th>Browser/OS</th></tr></thead>';
    echo'<tbody>';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    echo'<tr class="small">';
      echo'<td>'.$r['urlFrom'].'</td>';
      echo'<td>'.$r['urlDest'].'</td>';
      echo'<td>'.date($config['dateFormat'],$r['ti']).'</td>';
      echo'<td>'.$r['browser'].' using '.$r['os'].'</td>';
    echo'</tr>';
  }
  echo'</tbody></table>';
}
echo'</div>';
