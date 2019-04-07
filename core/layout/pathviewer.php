<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - View Visitor Path via IP
 *
 * pathviewer.php version 2.0.2
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
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
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
  echo'<table class="table table-condensed table-striped table-hover" role="table">';
    echo'<thead><tr role="row"><th role="columnheader">'.localize('URL From').'</th><th role="columnheader">'.localize('URL Dest').'</th><th role="columnheader">'.localize('Date').'</th><th role="columnheader">'.localize('Browser/OS').'</th></tr></thead>';
    echo'<tbody>';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    echo'<tr class="small" role="row">';
      echo'<td role="cell">'.$r['urlFrom'].'</td>';
      echo'<td role="cell">'.$r['urlDest'].'</td>';
      echo'<td role="cell">'.date($config['dateFormat'],$r['ti']).'</td>';
      echo'<td role="cell">'.$r['browser'].' using '.$r['os'].'</td>';
    echo'</tr>';
  }
  echo'</tbody></table>';
}
echo'</div>';
