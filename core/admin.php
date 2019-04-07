<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Admin
 *
 * admin.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Admin
 * @package    core/admin.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix Booking View Cookie.
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(!isset($_COOKIE['bookingview'])){
  setcookie("bookingview","calendar",time()+(60*60*24*14));
  $_COOKIE['bookingview']='calendar';
}
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
$sp->execute([':contentType'=>$view]);
include'core'.DS.'login.php';
if($_SESSION['rank']>399){
  if(isset($_SESSION['rank'])){
    if($_SESSION['rank']==100)$rankText=localize('Subscriber');
    if($_SESSION['rank']==200)$rankText=localize('Member');
    if($_SESSION['rank']==300)$rankText=localize('Client');
    if($_SESSION['rank']==400)$rankText=localize('Contributor');
    if($_SESSION['rank']==500)$rankText=localize('Author');
    if($_SESSION['rank']==600)$rankText=localize('Editor');
    if($_SESSION['rank']==700)$rankText=localize('Moderator');
    if($_SESSION['rank']==800)$rankText=localize('Manager');
    if($_SESSION['rank']==900)$rankText=localize('Administrator');
    if($_SESSION['rank']==1000)$rankText=localize('Developer');
  }else
    $rankText=localize('Visitor');
  $nous=$db->prepare("SELECT COUNT(id) AS cnt FROM `".$prefix."login` WHERE lti>:lti AND rank!=1000");
  $nous->execute([':lti'=>time()-300]);
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
