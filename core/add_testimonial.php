<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$getcfg=true;
require_once'db.php';
include'class.projecthoneypot.php';
include'class.spamfilter.php';
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$error=0;
$notification=$blacklisted='';
$ti=time();
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$spam=FALSE;
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'');
if($act=='add_test'){
  if($config['php_options']{3}==1&&$config['php_APIkey']!=''){
    $h=new ProjectHoneyPot($ip,$config['php_APIkey']);
    if($h->hasRecord()==1||$h->isSuspicious()==1||$h->isCommentSpammer()==1){
      $blacklisted=$theme['settings']['blacklist'];
      $spam=TRUE;
      $sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
      $sc->execute(array(':ip'=>$ip));
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
  if($_POST['emailtrap']=='none'){
    $id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    $name=isset($_POST['name'])?filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'name',FILTER_SANITIZE_STRING);
    $business=isset($_POST['business'])?filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'business',FILTER_SANITIZE_STRING);
    $review=isset($_POST['review'])?filter_input(INPUT_POST,'review',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'review',FILTER_SANITIZE_STRING);
    $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
    if($config['spamfilter']{0}==1&&$spam==FALSE){
      $filter=new SpamFilter();
      $result=$filter->check_email($email);
      if($result){
        $blacklisted=$theme['settings']['blacklist'];
        $spam=TRUE;
      }
      $result=$filter->check_text($name.' '.$business.' '.$review);
      if($result){
        $blacklisted=$theme['settings']['blacklist'];
        $spam=TRUE;
      }
      if($config['spamfilter']{1}==1&&$spam==TRUE){
        $sc=$db->prepare("SELECT id FROM `".$prefix."iplist` WHERE ip=:ip");
  			$sc->execute(array(':ip'=>$ip));
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
      if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $q=$db->prepare("INSERT INTO `".$prefix."content` (contentType,ip,title,email,name,business,notes,status,ti) VALUES ('testimonials',:ip,:title,:email,:name,:business,:notes,'unapproved',:ti)");
        $q->execute(
          array(
            ':ip'=>$ip,
            ':title'=>$name.' - '.$business,
            ':email'=>$email,
            ':name'=>$name,
            ':business'=>$business,
            ':notes'=>$review,
            ':ti'=>time()
          )
        );
        $e=$db->errorInfo();
        if(is_null($e[2]))
          $notification.=$theme['settings']['testimonial_success'];
        else
          $notification.=$theme['settings']['testimonial_error'];
      }else
        $notification.=$theme['settings']['testimonial_erroremail'];
    }
  }else
    $notification.=$theme['settings']['testimonial_errorspam'];
}
echo$blacklisted.$notification;
