<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Add Cart Item
 *
 * add_cart.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Add Cart Item
 * @package    core/add_cart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$iid=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$cid=filter_input(INPUT_GET,'cid',FILTER_SANITIZE_NUMBER_INT);
$ti=time();
$sc=$db->prepare("SELECT id FROM `".$prefix."cart` WHERE iid=:iid AND cid=:cid AND si=:si");
$sc->execute([
  ':iid'=>$iid,
  ':cid'=>$cid,
  ':si'=>SESSIONID
]);
if($sc->rowCount()>0){
  $q=$db->prepare("UPDATE `".$prefix."cart` SET quantity=quantity+1 WHERE iid=:iid AND si=:si");
  $q->execute([
    ':iid'=>$iid,
    ':si'=>SESSIONID
  ]);
}else{
  if(isset($iid)&&$iid!=0){
    $q=$db->prepare("SELECT cost FROM `".$prefix."content` WHERE id=:id");
    $q->execute([':id'=>$iid]);
    $r=$q->fetch(PDO::FETCH_ASSOC);
    if(is_numeric($r['cost'])){
      $q=$db->prepare("INSERT INTO `".$prefix."cart` (iid,cid,quantity,cost,si,ti) VALUES (:iid,:cid,'1',:cost,:si,:ti)");
      $q->execute([
        ':iid'=>$iid,
        ':cid'=>$cid,
        ':cost'=>$r['cost'],
        ':si'=>SESSIONID,
        ':ti'=>$ti
      ]);
    }
  }
}
$q=$db->prepare("SELECT SUM(quantity) as quantity FROM `".$prefix."cart` WHERE si=:si");
$q->execute([':si'=>SESSIONID]);
$r=$q->fetch(PDO::FETCH_ASSOC);
echo$r['quantity'];
