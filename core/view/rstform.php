<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if (isset($_POST['emailtrap']) && $_POST['emailtrap'] == '') {
  $eml = filter_input(INPUT_POST, 'rsteml', FILTER_SANITIZE_STRING);
  require '..' . DS . 'db.php';
  $config = $db -> query("SELECT * FROM config WHERE id=1") -> fetch(PDO::FETCH_ASSOC);
  $s = $db -> prepare("SELECT id,name,email FROM login WHERE email=:email LIMIT 1");
  $s -> execute(
    array(
      ':email' => $eml
    )
  );
  $c = $s -> fetch(PDO::FETCH_ASSOC);
  if ($s -> rowCount() > 0) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&";
    $password = substr(str_shuffle($chars), 0, 8);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $us = $db->prepare("UPDATE login SET password=:password WHERE id=:id");
    $us -> execute(
      array(
        ':password' => $hash,
        ':id'       => $c['id']
      )
    );
    require '..' . DS . 'class.phpmailer.php';
  	$mail = new PHPMailer;
  	$mail -> isSendmail();
  	$toname = $c['name'];
  	$mail -> SetFrom($config['email'], $config['business']);
  	$mail -> AddAddress($c['email']);
  	$mail -> IsHTML(true);
  	$mail -> Subject = 'Password Reset from ' . $config['business'];
  	$msg = $config['PasswordResetLayout'];
  	$msg = str_replace('{name}', $c['name'], $msg);
  	$msg = str_replace('{password}', $password, $msg);
  	$mail -> Body = $msg;
  	$mail -> AltBody = $msg;
  	if ($mail -> Send())
      echo '<div class="alert alert-success text-center">Check your Email!</div>';
    else
      echo '<div class="alert alert-danger text-center">Problem Sending Email!</div>';
  } else
    echo '<div class="alert alert-danger text-center">No Account Found!</div>';
} else {
  $r = rand(0, 10);
  switch ($r) {
    case 0:
      $out = 'No doubt you thought that was terribly clever.';
      break;
    case 1:
      $out = 'You’ve attempted logic. Not all attempts succeed.';
      break;
    case 2:
      $out = 'Either your educators have failed you, or you have failed them.';
    default:
      $out = 'Go Away!';
  }
  echo '<div class="alert alert-danger">' . $out . '</div>';
}
