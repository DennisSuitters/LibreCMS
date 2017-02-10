<?php
include'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
if($id!=0){
  $s=$db->prepare("SELECT * FROM messages WHERE id=:id");
  $s->execute(array(':id'=>$id));
  $r=$s->fetch(PDO::FETCH_ASSOC);
  print'<pre>'.quoted_printable_decode($r['notes_raw']).'</pre>';
}
