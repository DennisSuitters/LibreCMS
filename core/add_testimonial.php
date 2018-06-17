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
$ip=$_SERVER['REMOTE_ADDR'];
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
$name=isset($_POST['name'])?filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'name',FILTER_SANITIZE_STRING);
$business=isset($_POST['business'])?filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'business',FILTER_SANITIZE_STRING);
$review=isset($_POST['review'])?filter_input(INPUT_POST,'review',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'review',FILTER_SANITIZE_STRING);
if($act=='add_test'){
  if($_POST['emailtrap']==''){
    $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
      $q=$db->prepare("INSERT INTO content (contentType,ip,title,email,name,business,notes,status,ti) VALUES ('testimonials',:ip,:title,:email,:name,:business,:notes,'unapproved',:ti)");
      $q->execute(
        array(
          ':ip'       => $ip,
          ':title'    => $name.' - '.$business,
          ':email'    => $email,
          ':name'     => $name,
          ':business' => $business,
          ':notes'    => $review,
          ':ti'       => time()
        )
      );
      $e=$db->errorInfo();
      if(is_null($e[2]))
        $notification.=$theme['settings']['testimonial_success'];
      else
        $notification.=$theme['settings']['testimonial_error'];
    }else
      $notification.=$theme['settings']['testimonial_erroremail'];
  }else
    $notification.=$theme['settings']['testimonial_errorspam'];
}
echo$notification;