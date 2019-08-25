<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Display More Tracking Items
 *
 * more_tracker.php version 2.0.5
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Display More Tracking Items
 * @package    core/more_tracker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.5
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
function svg($svg,$class=null,$size=null){
	echo'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
function svg2($svg,$class=null,$size=null){
	return'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
$t=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$s=$db->prepare("SELECT * FROM `".$prefix."tracker` ORDER BY ti DESC LIMIT $c,20");
$s->execute();
$c=$c+$c;
if($s->rowCount()>0){
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    echo'<tr id="l_'.$r['id'].'" data-ip="'.$r['ip'].'" class="small animated fadeIn">'.
          '<td class="text-wrap align-middle" style="min-width:200px;max-width:250px;">'.$r['id'].': '.trim($r['urlDest']).'</td>'.
          '<td class="text-wrap align-middle" style="min-width:200px;max-width:250px;">'.trim($r['urlFrom']).'</td>'.
          '<td class="text-center align-middle">'.
            '<a target="_blank" href="http://www.ipaddress-finder.com/?ip='.$r['ip'].'">'.$r['ip'].'</a>'.
            '<button class="btn btn-secondary btn-sm trash" data-tooltip="tooltip" title="Remove all of this IP" onclick="purge(`'.$r['ip'].'`,`clearip`)" aria-label="Remove all of this IP">'.svg2('libre-gui-eraser').'</button>'.
          '</td>'.
          '<td class="text-center align-middle">'.ucfirst($r['browser']).'</td>'.
          '<td class="text-center align-middle">'.ucfirst($r['os']).'</td>'.
          '<td class="text-center align-middle">'.date($config['dateFormat'],$r['ti']).'</td>'.
          '<td class="align-middle">'.
            '<div class="btn-group float-right">'.
              '<button class="btn btn-secondary pathviewer" data-tooltip="tooltip" title="View Visitor Path" data-toggle="popover" data-dbid="'.$r['id'].'" aria-label="aria_view">'.svg2('libre-seo-path').'</button>';
    if($config['php_options']{0}==1){
      echo'<button class="btn btn-secondary phpviewer" data-tooltip="tooltip" title="Check IP with Project Honey Pot" data-toggle="popover" data-dbid="'.$r['id'].'" data-dbt="tracker" aria-label="aria_check">'.svg2('libre-brand-projecthoneypot').'</button>';
    }
              echo'<button class="btn btn-secondary trash" onclick="purge(`'.$r['id'].'`,`tracker`)" data-tooltip="tooltip" title="Delete" aria-label="aria_delete">'.svg2('libre-gui-trash').'</button>'.
            '</div>'.
          '</td>'.
          '</tr>';
  }
          echo'<tr id="more_'.$c.'">'.
            '<td colspan="7">'.
              '<div class="form-group">'.
                '<div class="input-group">'.
                  '<button class="btn btn-secondary btn-block" onclick="more(`tracker`,`'.$c.'`);">More</button>'.
                '</div>'.
              '</div>'.
            '</td>'.
          '</tr>';
}else{
  echo'nomore';
}