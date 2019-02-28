<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Login
 *
 * login.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Login
 * @package    core/login.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!isset($act))
  $act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
if($act=='logout'){
  $_SESSION['loggedin']=false;
  $_SESSION['rank']=0;
  $params=session_get_cookie_params();
  setcookie(session_name(),'',time()-42000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
  session_destroy();
}elseif($act=='login'||(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true)){
  $username=isset($_POST['username'])?filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING):$_SESSION['username'];
  $password=isset($_POST['password'])?filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING):$_SESSION['password'];
  $q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE username=:username AND activate='' AND active='1' LIMIT 1");
  $q->execute([':username'=>$username]);
  $user=$q->fetch(PDO::FETCH_ASSOC);
  if($user['id']!=0){
    if(password_verify($password,$user['password'])){
      $_SESSION['username']=$user['username'];
      $_SESSION['password']=$password;
      $_SESSION['uid']=$user['id'];
      $_SESSION['rank']=$user['rank'];
      $_SESSION['loggedin']=true;
    }else{
      $_SESSION['loggedin']=false;
      $_SESSION['rank']=0;
    }
  }else{
    $_SESSION['loggedin']=false;
    $_SESSION['rank']=0;
  }
}else{
  $_SESSION['loggedin']=false;
  $_SESSION['rank']=0;
}
if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
  $q=$db->prepare("UPDATE `".$prefix."login` SET lti=:lti,userAgent=:userAgent,userIP=:userIP WHERE id=:id");
  $q->execute([
    ':lti'=>time(),
    ':id'=>$_SESSION['uid'],
    ':userAgent'=>$_SERVER['HTTP_USER_AGENT'],
    ':userIP'=>$_SERVER['REMOTE_ADDR']
  ]);
}
