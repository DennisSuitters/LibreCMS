<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - View Email
 *
 * viewemail.php version 2.0.3
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - View Email
 * @package    core/viewemail.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.3
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.3 Change where data is retreieved for nice HTML Emails.
 */
require'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
if($id!=0){
  $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE id=:id");
  $s->execute([':id'=>$id]);
  $r=$s->fetch(PDO::FETCH_ASSOC);
  print quoted_printable_decode($r['notes_html']);
}