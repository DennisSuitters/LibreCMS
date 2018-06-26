<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(isset($_POST['emailtrap'])&&$_POST['emailtrap']==''){
  $eml=filter_input(INPUT_POST,'rsteml',FILTER_SANITIZE_STRING);
  require'..'.DS.'db.php';
  $theme=parse_ini_file(THEME.DS.'theme.ini',true);
  $notification='';
  $config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("SELECT id,name,email FROM login WHERE email=:email LIMIT 1");
  $s->execute(array(':email'=>$eml));
  $c=$s->fetch(PDO::FETCH_ASSOC);
  if($s->rowCount()>0){
    $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
    $password=substr(str_shuffle($chars),0,8);
    $hash=password_hash($password,PASSWORD_DEFAULT);
    $us=$db->prepare("UPDATE login SET password=:password WHERE id=:id");
    $us->execute(
      array(
        ':password'=>$hash,
        ':id'      =>$c['id']
      )
    );
    require'..'.DS.'class.phpmailer.php';
  	$mail=new PHPMailer;
  	$mail->isSendmail();
  	$toname=$c['name'];
  	$mail->SetFrom($config['email'],$config['business']);
  	$mail->AddAddress($c['email']);
  	$mail->IsHTML(true);
    $subject=(isset($config['passwordResetSubject'])&&$config['passwordResetSubject']!=''?$config['passwordResetLayout']:'Password Reset from {business}');
    $subject=str_replace(
      array(
        '{business}',
        '{date}'
      ),
      array(
        $config['business'],
        date($config['dateFormat'],time())
      ),
      $subject
    );
  	$mail->Subject=$subject;
  	$msg=(isset($config['passwordResetLayout'])&&$config['passwordResetLayour']!=''?$config['passwordResetLayout']:'<p>Hi {name},</p><p>A Password Reset was requested, it is now: {password}</p><p>We recommend changing the above password after logging in.</p>');
    $namee=explode(' ',$c['name']);
    $msg=str_replace(
      array(
        '{business}',
        '{name}',
        '{first}',
        '{last}',
        '{date}',
        '{password}'
      ),
      array(
        $config['business'],
        $c['name'],
        $namee[0],
        end($namee),
        date($config['dateFormat'],time()),
        $password
      ),
      $msg
    );
  	$mail->Body=$msg;
  	$mail->AltBody=$msg;
  	if($mail->Send())$notification=$theme['settings']['passwordreset_success'];
    else$notification=$theme['settings']['passwordreset_erroremail'];
  }else$notification=$theme['settings']['passwordrest_erroraccount'];
}else$notification=$theme['settings']['passwordreset_errorinvalidemail'];
echo$notification;
