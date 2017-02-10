<?php
if(session_status()==PHP_SESSION_NONE)session_start();
include'db.php';
$si=session_id();
$iid=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$cid=filter_input(INPUT_GET,'cid',FILTER_SANITIZE_NUMBER_INT);
$ti=time();
$sc=$db->prepare("SELECT id FROM cart WHERE iid=:iid AND cid=:cid AND si=:si");
$sc->execute(array(':iid'=>$iid,':cid'=>$cid,':si'=>$si));
if($sc->rowCount()>0){
  $q=$db->prepare("UPDATE cart SET quantity=quantity+1 WHERE iid=:iid AND si=:si");
  $q->execute(array(':iid'=>$iid,':si'=>$si));
}else{
  if(isset($iid)&&$iid!=0){
    $q=$db->prepare("SELECT cost FROM content WHERE id=:id");
    $q->execute(array(':id'=>$iid));
    $r=$q->fetch(PDO::FETCH_ASSOC);
    if(is_numeric($r['cost'])){
      $q=$db->prepare("INSERT INTO cart (iid,cid,quantity,cost,si,ti) VALUES (:iid,:cid,'1',:cost,:si,:ti)");
      $q->execute(array(':iid'=>$iid,':cid'=>$cid,':cost'=>$r['cost'],':si'=>$si,':ti'=>$ti));
    }
  }
}
$q=$db->prepare("SELECT SUM(quantity) as quantity FROM cart WHERE si=:si");
$q->execute(array(':si'=>$si));
$r=$q->fetch(PDO::FETCH_ASSOC);
echo$r['quantity'];
