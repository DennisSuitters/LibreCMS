<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$getcfg=true;
include'db.php';
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$ip=$_SERVER['REMOTE_ADDR'];
$notification='';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$emailtrap=isset($_POST['emailtrap'])?filter_input(INPUT_POST,'emailtrap',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'emailtrap',FILTER_SANITIZE_STRING);
$rating=isset($_POST['rating'])?filter_input(INPUT_POST,'rating',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'rating',FILTER_SANITIZE_NUMBER_INT);
$email=isset($_POST['email'])?filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING);
$name=isset($_POST['name'])?filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'name',FILTER_SANITIZE_STRING);
$review=isset($_POST['review'])?filter_input(INPUT_POST,'review',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'review',FILTER_SANITIZE_STRING);
if($emailtrap==''){
  if(filter_var($email,FILTER_VALIDATE_EMAIL)){
    $q=$db->prepare("INSERT INTO comments (contentType,rid,ip,email,name,notes,cid,status,ti) VALUES ('review',:rid,:ip,:email,:name,:notes,:cid,'unapproved',:ti)");
    $q->execute(
      array(
        ':rid'   => $id,
        ':ip'    => $ip,
        ':email' => $email,
        ':name'  => $name,
        ':notes' => $review,
        ':cid'   => $rating,
        ':ti'    => time()
      )
    );
    $e=$db->errorInfo();
    if(is_null($e[2]))
      $notification.=$theme['settings']['review_success'];
    else
      $notification.=$theme['settings']['review_error'];
  }else
    $notification.=$theme['settings']['review_errorspam'];
}else
  $notification.=$theme['settings']['review_errorspam'];
echo$notification;
