<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$getcfg=true;
include'db.php';
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$notification='';
$emailtrap=isset($_POST['emailtrap'])?filter_input(INPUT_POST,'emailtrap',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'emailtrap',FILTER_SANITIZE_STRING);
$email=isset($_POST['email'])?filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING);
if($emailtrap==''){
  if(filter_var($email,FILTER_VALIDATE_EMAIL)){
    $q=$db->prepare("SELECT id FROM subscribers WHERE email=:email");
    $q->execute(array(':email'=>$email));
    if($q->rowCount()<1){
      $q=$db->prepare("INSERT INTO subscribers (email,hash,ti) VALUES (:email,:hash,:ti)");
      $q->execute(
        array(
          ':email'=>$email,
          ':hash' =>md5($email),
          ':ti'   =>time()
        )
      );
      $e=$db->errorInfo();
      if(is_null($e[2]))$notification.=$theme['settings']['subscriber_success'];
      else$notification.=$theme['settings']['subscriber_error'];
    }else$notification.=$theme['settings']['subscriber_already'];
  }else$notification.=$theme['settings']['subscriber_spam'];
}else$notification.=$theme['settings']['subscriber_spam'];
echo$notification;
