<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - XMLRPC Blacklister
 *
 * xmlrpc.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - XMLRPC Blacklister
 * @package    core/xmlrpc.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$ti=time();
echo'Thank you for giving the system an excuse to Blacklist your IP... <strong>'.$ip.'</strong>';
$s=$db->prepare("DELETE FROM `".$prefix."iplist` WHERE ti<:ti");
$s->execute(array(':ti'=>time()-2592000));
$s=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");
$s->execute([':ip'=>$ip]);
if($s->rowCount()<1){
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $sql=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,ti) VALUES (:ip,:oti,:ti)");
  $sql->execute([
    ':ip'=>$ip,
    ':oti'=>$ti,
    ':ti'=>time()
  ]);
}
