<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - View Visitor Path via IP
 *
 * pathviewer.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Popup - Path Viewer
 * @package    core/layout/pathviewer.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
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
$sg->execute([':id'=>$id]);
$gr=$sg->fetch(PDO::FETCH_ASSOC);
$s=$db->prepare("SELECT * FROM `".$prefix."tracker` WHERE ip=:ip ORDER BY ti ASC");
$s->execute([':ip'=>$gr['ip']]);
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
