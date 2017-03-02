<?php
require'db.php';
$i=0;
foreach($_POST['media_items']as$id){
  $s=$db->prepare("UPDATE media SET ord=:ord WHERE id=:id");
  $s->execute(array(':ord'=>$i,':id'=>$id));
  $i++;
}
