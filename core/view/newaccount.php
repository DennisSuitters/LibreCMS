<?php
if(isset($_POST['emailtrap'])&&$_POST['emailtrap']==''){
  require'..'.DS.'db.php';
  if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
  define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url']);
  $eml=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
  $un=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
  if($un!=''){
    $config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
    $s=$db->prepare("SELECT username FROM login WHERE username=:username LIMIT 1");
    $s->execute(array(':username'=>$un));
    $r=$s->fetch(PDO::FETCH_ASSOC);
    if($s->rowCount()>0)echo'<div class="alert alert-danger text-center">Username Already Exists!</div>';
    else{
      $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
      $password=substr(str_shuffle($chars),0,8);
      $hash=password_hash($password,PASSWORD_DEFAULT);
      $activate=md5(time());
      $us=$db->prepare("INSERT INTO login (username,password,email,hash,activate,active,ti) VALUES (:username,:password,:email,:hash,:activate,:active,:ti)");
      $us->execute(array(':username'=>$un,':password'=>$hash,':email'=>$eml,':hash'=>md5($eml),':activate'=>$activate,':active'=>0,':ti'=>time()));
      require'..'.DS.'class.phpmailer.php';
      $mail=new PHPMailer();
    	$mail->IsSMTP();
    	$toname=$un;
    	$mail->SetFrom($config['email'],$config['business']);
    	$mail->AddAddress($eml);
    	$mail->IsHTML(true);
    	$mail->Subject='Account Activation from '.$config['business'];
    	$msg=$config['accountActivationLayout'];
    	$msg=str_replace('{username}',$un,$msg);
      $msg=str_replace('{activation_link}','<a href="'.URL.'?activate='.$activate.'">'.URL.'?activate='.$activate.'</a>',$msg);
    	$msg=str_replace('{password}',$password,$msg);
    	$mail->Body=$msg;
    	$mail->AltBody=$msg;
    	if($mail->Send())echo'<div class="alert alert-success text-center">Check your Email!</div>';else echo'<div class="alert alert-danger text-center">Problem Sending Email!</div>';
    }
  }else echo'<div class="alert alert-danger text-center">Must have a username</div>';
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
