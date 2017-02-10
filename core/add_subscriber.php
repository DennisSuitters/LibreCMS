<?php
include'db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
if($config['development']==1){
  error_reporting(E_ALL);
  ini_set('display_errors','On');
}else{
  error_reporting(E_ALL);
  ini_set('display_errors','Off');
  ini_set('log_errors','On');
  ini_set('error_log','..'.DS.'media'.DS.'cache'.DS.'error.log');
}

$emailtrap=isset($_POST['emailtrap'])?filter_input(INPUT_POST,'emailtrap',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'emailtrap',FILTER_SANITIZE_STRING);
$email=isset($_POST['email'])?filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING);
if($emailtrap==''){
  if(filter_var($email,FILTER_VALIDATE_EMAIL)){
    $q=$db->prepare("INSERT INTO subscribers (email,hash,ti) VALUES(:email,:hash,:ti)");
    $q->execute(array(':email'=>$email,':hash'=>md5($email),':ti'=>time()));
    $e=$db->errorInfo();
    if(is_null($e[2]))echo'<div class="alert alert-success">Thank you for Subscribing to Our Newletters.</div>';
    else echo'<div class="alert alert-danger">There was an Issue adding your Subscription.</div>';
  }else echo'<div class="alert alert-info">Spammers and Email Harvesters not welcome.</div>';
}else echo'<div class="alert alert-info">Spammers and Email Harvesters not welcome.</div>';
