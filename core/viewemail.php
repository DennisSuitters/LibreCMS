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
 * @changes    v2.0.4 Check if message html exists if not try to use plain.
 * @changes    v2.0.4 Add Detect and Decrypt of Base64 Messages
 * @changes    v2.0.5 Fix Messages reading correct storage of Messages Body.
 */
require'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
if($id!=0){
  $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE id=:id");
  $s->execute([':id'=>$id]);
  $r=$s->fetch(PDO::FETCH_ASSOC);
  if($r['notes_html']=='')$r['notes_html']=$r['notes_plain'];
  if($r['notes_html']=='')$r['notes_html']=$r['notes_raw'];
  if(is_base64_string($r['notes_html']))$r['notes_html']=base64_decode($r['notes_html']);
  print quoted_printable_decode($r['notes_html']);
}
function is_base64_string($s) {
  if (($b = base64_decode($s, TRUE)) === FALSE) {
    return FALSE;
  }
  $e = mb_detect_encoding($b);
  if (in_array($e, array('UTF-8', 'ASCII'))) { // YMMV
    return TRUE;
  } else {
    return FALSE;
  }
}