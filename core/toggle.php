<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Toggle
 *
 * toggle.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Toggle
 * @package    core/toggle.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$bit=filter_input(INPUT_GET,'b',FILTER_SANITIZE_NUMBER_INT);
$tbl=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$col=filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$ti=time();
if(($tbl!='NaN'&&$col!='NaN')||($tbl!=''&&$col!='')){
  if(in_array($tbl,['cart','choices','comments','config','content','iplist','login','logs','media','menu','messages','orderitems','orders','rewards','subscribers','suggestions','tracker'])&&in_array($col,['active','bio_options','bookable','bookingEmailReadNotification','comingsoon','development','featured','important','internal','maintenance','method','newsletter','newslettersEmbedImages','options','orderEmailReadNotification','php_options','pin','recurring','starred','suggestions'])){
    $q=$db->prepare("SELECT $col as c FROM `".$prefix.$tbl."` WHERE id=:id");
    $q->execute([':id'=>$id]);
    $r=$q->fetch(PDO::FETCH_ASSOC);
    $r['c']{$bit}=$r['c']{$bit}==1?0:1;
    $q=$db->prepare("UPDATE `".$prefix.$tbl."` SET $col=:c WHERE id=:id");
    $q->execute([':c'=>$r['c'],':id'=>$id]);
  }
}
if($tbl!='messages'||$col!='pin')echo'<script>window.top.window.$("#'.$tbl.$col.$bit.'").remove();";</script>';
