<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Add Message IP to Blacklist
 *
 * add_messageblacklist.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Add Message IP to Blacklist
 * @package    core/add_messageblacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT ip,ti FROM `".$prefix."messages` WHERE id=:id");
$s->execute([':id'=>$id]);
if($s->rowCount()>0){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $sql=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,ti) VALUES (:ip,:oti,:ti)");
  $sql->execute([
    ':ip'=>$r['ip'],
    ':oti'=>$r['ti'],
    ':ti'=>time()
  ]);
  echo'<script>window.top.window.$("#blacklist'.$id.'").addClass("hidden");</script>';
}
