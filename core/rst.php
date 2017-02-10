<?php
require'db.php';
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
if($config['development']==1){
  error_reporting(E_ALL);
  ini_set('display_errors','On');
}else{
  error_reporting(E_ALL);
  ini_set('display_errors','Off');
  ini_set('log_errors','On');
  ini_set('error_log','..'.DS.'media'.DS.'cache'.DS.'error.log');
}
if(isset($_POST['emailtrap'])&&$_POST['emailtrap']==''){
  $eml=filter_input(INPUT_POST,'rst',FILTER_SANITIZE_STRING);
  $s=$db->prepare("SELECT id,name,email FROM login WHERE email=:email LIMIT 1");
  $s->execute(array(':email'=>$eml));
  $c=$s->fetch(PDO::FETCH_ASSOC);
  if($s->rowCount()>0){
    $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
    $password=substr(str_shuffle($chars),0,8);
    $hash=password_hash($password,PASSWORD_DEFAULT);
    $us=$db->prepare("UPDATE login SET password=:password WHERE id=:id");
    $us->execute(array(':password'=>$hash,':id'=>$c['id']));
    require"class.phpmailer.php";
  	$mail=new PHPMailer();
  	$mail->IsSMTP();
  	$toname=$c['name'];
  	$mail->SetFrom($config['email'],$config['business']);
  	$mail->AddAddress($c['email']);
  	$mail->IsHTML(true);
  	$mail->Subject='Password Reset from '.$config['business'];
  	$msg=rawurldecode($config['PasswordResetLayout']);
  	$msg=str_replace('{name}',$c['name'],$msg);
  	$name=explode(' ',$c['name']);
  	$msg=str_replace('{password}',$password,$msg);
  	$mail->Body=$msg;
  	$mail->AltBody=$msg;
  	if($mail->Send()){
      echo'<div class="alert alert-success text-center">Check your Email!</div>';
    }else{
      echo'<div class="alert alert-danger text-center">Problem Sending Email!</div>';
    }
  }else{
    echo'<div class="alert alert-danger text-center">No Account Found!</div>';
  }
}else{
  $r=rand(0,10);
  switch($r){
    case 0:
      $out='No doubt you thought that was terribly clever.';
      break;
    case 1:
      $out='You’ve attempted logic. Not all attempts succeed.';
      break;
    case 2:
      $out='Either your educators have failed you, or you have failed them.';
    default:
      $out='Go Away!';
  }
  echo'<div class="alert alert-danger">'.$out.'</div>';
}
