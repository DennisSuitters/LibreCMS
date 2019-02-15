<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))
  define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require_once'..'.DS.'db.php';
$theme=parse_ini_file('..'.DS.'..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
include'..'.DS.'class.projecthoneypot.php';
include'..'.DS.'class.spamfilter.php';
$error=0;
$notification=$blacklisted='';
$ip=($_SERVER['REMOTE_ADDR']='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR']);
$ti=time();
$spam=FALSE;
if($config['php_options']{3}==1&&$config['php_APIkey']!=''){
  $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
  if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1){
    $blacklisted=$theme['settings']['blacklist'];
    $sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
    $sc->execute(
      array(
        ':ip'=>$ip
      )
    );
    if($sc->rowCount()<1){
      $s=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,ti) VALUES (:ip,:oti,:ti)");
      $s->execute(
        array(
          ':ip'=>$ip,
          ':oti'=>$ti,
          ':ti'=>$ti
        )
      );
    }
  }
}
if(isset($_POST['emailtrap'])&&$_POST['emailtrap']=='none'){
  $email=filter_input(INPUT_POST,'rsteml',FILTER_SANITIZE_STRING);
  if($config['spamfilter']{0}==1&&$spam==FALSE){
    $filter=new SpamFilter();
    $result=$filter->check_email($email);
    if($result){
      $blacklisted=$theme['settings']['blacklist'];
      $spam=TRUE;
    }
    if($config['spamfilter']{1}==1&&$spam==TRUE){
      $sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
      $sc->execute(
        array(
          ':ip'=>$ip
        )
      );
      if($sc->rowCount()<1){
        $s=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,ti) VALUES (:ip,:oti,:ti)");
        $s->execute(
          array(
            ':ip'=>$ip,
            ':oti'=>$ti,
            ':ti'=>$ti
          )
        );
      }
    }
  }
  if($spam==FALSE){
    $s=$db->prepare("SELECT id,name,email FROM `".$prefix."login` WHERE email=:email LIMIT 1");
    $s->execute(
      array(
        ':email'=>$email
      )
    );
    $c=$s->fetch(PDO::FETCH_ASSOC);
    if($s->rowCount()>0){
      $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
      $password=substr(str_shuffle($chars),0,8);
      $hash=password_hash($password,PASSWORD_DEFAULT);
      $us=$db->prepare("UPDATE `".$prefix."login` SET password=:password WHERE id=:id");
      $us->execute(
        array(
          ':password'=>$hash,
          ':id'=>$c['id']
        )
      );
      include'..'.DS.'class.phpmailer.php';
    	$mail=new PHPMailer;
    	$mail->isSendmail();
    	$toname=$c['name'];
    	$mail->SetFrom($config['email'],$config['business']);
    	$mail->AddAddress($c['email']);
    	$mail->IsHTML(true);
      $subject=isset($config['passwordResetSubject'])&&$config['passwordResetSubject']!=''?$config['passwordResetLayout']:'Password Reset from {business}';
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
    	$msg=isset($config['passwordResetLayout'])&&$config['passwordResetLayout']!=''?$config['passwordResetLayout']:'<p>Hi {name},</p><p>A Password Reset was requested, it is now: {password}</p><p>We recommend changing the above password after logging in.</p>';
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
    	if($mail->Send())
        $notification=$theme['settings']['passwordreset_success'];
      else
        $notification=$theme['settings']['passwordreset_erroremail'];
    }else
      $notification=$theme['settings']['passwordrest_erroraccount'];
  }
}else
  $notification=$theme['settings']['passwordreset_errorinvalidemail'];
echo$blacklisted.$notification;
