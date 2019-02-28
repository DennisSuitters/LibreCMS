<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Add Subscriber
 *
 * add_subscriber.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Add Subscriber
 * @package    core/add_subscriber.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$getcfg=true;
require'db.php';
include'class.projecthoneypot.php';
include'class.spamfilter.php';
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$error=0;
$notification=$blacklisted='';
$ti=time();
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$spam=FALSE;
if($config['php_options']{3}==1&&$config['php_APIkey']!=''){
  $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
  if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1){
    $blacklisted=$theme['settings']['blacklist'];
    $spam=TRUE;
    $sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
    $sc->execute([':ip'=>$ip]);
    if($sc->rowCount()<1){
      $s=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,ti) VALUES (:ip,:oti,:ti)");
      $s->execute([
        ':ip'=>$ip,
        ':oti'=>$ti,
        ':ti'=>$ti
      ]);
    }
  }
}
if($_POST['emailtrap']=='none'){
  $email=isset($_POST['email'])?filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING);
  if($config['spamfilter']{0}==1&&$spam==FALSE){
    $filter=new SpamFilter();
    $result=$filter->check_email($email);
    if($result){
      $blacklisted=$theme['settings']['blacklist'];
      $spam=TRUE;
    }
    $result=$filter->check_text($email);
    if($result){
      $blacklisted=$theme['settings']['blacklist'];
      $spam=TRUE;
    }
    if($config['spamfilter']{1}==1&&$spam==TRUE){
      $sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
      $sc->execute([':ip'=>$ip]);
      if($sc->rowCount()<1){
        $s=$db->prepare("INSERT INTO `".$prefix."iplist` (ip,oti,ti) VALUES (:ip,:oti,:ti)");
        $s->execute([
          ':ip'=>$ip,
          ':oti'=>$ti,
          ':ti'=>$ti
        ]);
      }
    }
  }
  if($spam==FALSE){
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
      $q=$db->prepare("SELECT id FROM `".$prefix."subscribers` WHERE email=:email");
      $q->execute([':email'=>$email]);
      if($q->rowCount()<1){
        $q=$db->prepare("INSERT INTO `".$prefix."subscribers` (email,hash,ti) VALUES (:email,:hash,:ti)");
        $q->execute([
          ':email'=>$email,
          ':hash'=>md5($email),
          ':ti'=>time()
        ]);
        $e=$db->errorInfo();
        if(is_null($e[2]))
          $notification.=$theme['settings']['subscriber_success'];
        else
          $notification.=$theme['settings']['subscriber_error'];
      }else
        $notification.=$theme['settings']['subscriber_already'];
    }else
      $notification.=$theme['settings']['subscriber_spam'];
  }
}else
  $notification.=$theme['settings']['subscriber_spam'];
echo$blacklisted.$notification;
