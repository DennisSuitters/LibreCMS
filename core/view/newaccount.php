<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require'..'.DS.'db.php';
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$notification='';
if(isset($_POST['terms'])&&$_POST['terms']=='yes'){
  if(isset($_POST['emailtrap'])&&$_POST['emailtrap']==''){
    if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)
      define('PROTOCOL','https://');
    else
      define('PROTOCOL','http://');
    define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url']);
    $eml=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $un=filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    if($un!=''){
//      $config = $db -> query("SELECT * FROM config WHERE id=1") -> fetch(PDO::FETCH_ASSOC);
      $s=$db->prepare("SELECT username FROM login WHERE username=:username LIMIT 1");
      $s->execute(array(':username'=>$un));
      $r=$s->fetch(PDO::FETCH_ASSOC);
      if($s->rowCount()>0)
        $notification.=$theme['settings]']['signup_erroruserexists'];
      else{
        $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
        $password=substr(str_shuffle($chars), 0, 8);
        $hash=password_hash($password, PASSWORD_DEFAULT);
        $activate=md5(time());
        $us=$db->prepare("INSERT INTO login (username,password,email,hash,activate,active,ti) VALUES (:username,:password,:email,:hash,:activate,:active,:ti)");
        $us->execute(
          array(
            ':username' => $un,
            ':password' => $hash,
            ':email'    => $eml,
            ':hash'     => md5($eml),
            ':activate' => $activate,
            ':active'   => 0,
            ':ti'       => time()
          )
        );
        require'..'.DS.'class.phpmailer.php';
        $mail=new PHPMailer;
      	$mail->isSendmail();
      	$toname=$un;
      	$mail->SetFrom($config['email'], $config['business']);
      	$mail->AddAddress($eml);
      	$mail->IsHTML(true);
        $subject=(isset($config['accountActivationSubject'])&&$config['accountActivationSubject']!=''?$config['accountActivationLayout']:'Account Activation for {username} from {site}.');
        $subject=str_replace(
          array(
            '{username}',
            '{site}'
          ),
          array(
            $un,
            $config['business']
          )
          $subject
        );
      	$mail->Subject=$subject;
      	$msg=(isset($config['accountActivationLayout'])&&$config['accountActivationLayout']!=''?$config['accountActivationLayout']:'<p>Hi {username},</p><p>Below is the Activation Link to enable your Account at {site}.<br>{activation_link}</p><p>If this email is in error, and you did not sign up for an Account, please take the time to contact us to let us know, or alternatively ignore this email and your email will be purged from our system in a few days.</p>');
        $msg=str_replace(
          array(
            '{username}',
            '{site}',
            '{activation_link}',
            '{password}'
          ),
          array(
            $un,
            $config['business'],
            '<a href="'.URL.'?activate='.$activate.'">'.URL.'?activate='.$activate.'</a>',
            $password
          ),
          $msg
        );
      	$mail->Body=$msg;
      	$mail->AltBody=$msg;
      	if($mail->Send())
          $notification.=$theme['settings']['signup_success'];
        else
          $notification.=$theme['settings']['signup_error'];
      }
    }else
      $notification.=$theme['settings']['signup_errorusername'];
  }else{
    $notification.=$theme['settings']['signup_erroremail'];
  }
}else{
  $notification.=$theme['settings']]['signup_errorterms'];
}
echo$notification;
