<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require'core'.DS.'db.php';
if(isset($_GET['previous']))header("location:".$_GET['previous']);
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$ti=time();
$favicon=$this->favicon();
$share_image=$favicon;
$noimage=$this->noimage();
$noavatar=$this->noavatar();
$help=parse_ini_file('core'.DS.'help.ini',TRUE);
$sp=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE contentType=:contentType");
$sp->execute(
  array(
    ':contentType'=>$view
  )
);
include'core'.DS.'login.php';
if($_SESSION['rank']>399){
  if(isset($_SESSION['rank'])){
    if($_SESSION['rank']==100)$rankText='Subscriber';
    if($_SESSION['rank']==200)$rankText='Member';
    if($_SESSION['rank']==300)$rankText='Client';
    if($_SESSION['rank']==400)$rankText='Contributor';
    if($_SESSION['rank']==500)$rankText='Author';
    if($_SESSION['rank']==600)$rankText='Editor';
    if($_SESSION['rank']==700)$rankText='Moderator';
    if($_SESSION['rank']==800)$rankText='Manager';
    if($_SESSION['rank']==900)$rankText='Administrator';
    if($_SESSION['rank']==1000)$rankText='Developer';
  }else
    $rankText='Visitor';
  $nous=$db->prepare("SELECT COUNT(id) AS cnt FROM `".$prefix."login` WHERE lti>:lti AND rank!=1000");
  $nous->execute(array(':lti'=>time()-300));
  $nou=$nous->fetch(PDO::FETCH_ASSOC);
  $nc=$db->query("SELECT COUNT(status) AS cnt FROM `".$prefix."comments` WHERE contentType!='review' AND status='unapproved'")->fetch(PDO::FETCH_ASSOC);
  $nr=$db->query("SELECT COUNT(id) AS cnt FROM `".$prefix."comments` WHERE contentType='review' AND  status='unapproved'")->fetch(PDO::FETCH_ASSOC);
  $nm=$db->query("SELECT COUNT(status) AS cnt FROM `".$prefix."messages` WHERE status='unread'")->fetch(PDO::FETCH_ASSOC);
  $po=$db->query("SELECT COUNT(status) AS cnt FROM `".$prefix."orders` WHERE status='pending'")->fetch(PDO::FETCH_ASSOC);
  $nb=$db->query("SELECT COUNT(status) AS cnt FROM `".$prefix."content` WHERE contentType='booking' AND status!='confirmed'")->fetch(PDO::FETCH_ASSOC);
  $nu=$db->query("SELECT COUNT(id) AS cnt FROM `".$prefix."login` WHERE activate!='' AND active=0")->fetch(PDO::FETCH_ASSOC);
  $nt=$db->query("SELECT COUNT(id) AS cnt FROM `".$prefix."content` WHERE contentType='testimonials' AND status!='published'")->fetch(PDO::FETCH_ASSOC);
  $navStat=$nc['cnt']+$nr['cnt']+$nm['cnt']+$po['cnt']+$nb['cnt']+$nu['cnt']+$nt['cnt'];
  require'core'.DS.'layout'.DS.'meta_head.php';
  require'core'.DS.'layout'.DS.'header.php';
  require'core'.DS.'layout'.DS.'sidebar.php';
  if($view=='add'){
    if($args[0]=='bookings')
      require'core'.DS.'layout'.DS.'bookings.php';
    else
      require'core'.DS.'layout'.DS.'content.php';
  }else
    require'core'.DS.'layout'.DS.$view.'.php';
  require'core'.DS.'layout'.DS.'meta_footer.php';
}else
  require'core'.DS.'layout'.DS.'login.php';
