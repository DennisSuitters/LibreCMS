<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
require'db.php';
$iid=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$cid=filter_input(INPUT_GET,'cid',FILTER_SANITIZE_NUMBER_INT);
$ti=time();
$sc=$db->prepare("SELECT id FROM `".$prefix."cart` WHERE iid=:iid AND cid=:cid AND si=:si");
$sc->execute(
  array(
    ':iid'=>$iid,
    ':cid'=>$cid,
    ':si'=>SESSIONID
  )
);
if($sc->rowCount()>0){
  $q=$db->prepare("UPDATE `".$prefix."cart` SET quantity=quantity+1 WHERE iid=:iid AND si=:si");
  $q->execute(
    array(
      ':iid'=>$iid,
      ':si'=>SESSIONID
    )
  );
}else{
  if(isset($iid)&&$iid!=0){
    $q=$db->prepare("SELECT cost FROM `".$prefix."content` WHERE id=:id");
    $q->execute(
      array(
        ':id'=>$iid
      )
    );
    $r=$q->fetch(PDO::FETCH_ASSOC);
    if(is_numeric($r['cost'])){
      $q=$db->prepare("INSERT INTO `".$prefix."cart` (iid,cid,quantity,cost,si,ti) VALUES (:iid,:cid,'1',:cost,:si,:ti)");
      $q->execute(
        array(
          ':iid'=>$iid,
          ':cid'=>$cid,
          ':cost'=>$r['cost'],
          ':si'=>SESSIONID,
          ':ti'=>$ti
        )
      );
    }
  }
}
$q=$db->prepare("SELECT SUM(quantity) as quantity FROM `".$prefix."cart` WHERE si=:si");
$q->execute(
  array(
    ':si'=>SESSIONID
  )
);
$r=$q->fetch(PDO::FETCH_ASSOC);
echo$r['quantity'];
