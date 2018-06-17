<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$getcfg=true;
require'db.php';
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$error=0;
$notification='';
$ti=time();
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
if($act=='add_message'){
	if($_POST['emailtrap']=='none'){
		$email =filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$name   =filter_input(INPUT_POST, 'name',    FILTER_SANITIZE_STRING);
			$subject=filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
			$ss=$db->prepare("SELECT * FROM choices WHERE id=:id");
			$ss->execute(array(':id'=>$subject));
			if($ss->rowCount()==1){
				$rs=$ss->fetch(PDO::FETCH_ASSOC);
				$subject=$rs['title'];
				if($rs['url']!='')$config['email']=$rs['url'];
			}
			$notes=filter_input(INPUT_POST,'notes',FILTER_SANITIZE_STRING);
			$q=$db->prepare("INSERT INTO messages (uid,folder,to_email,to_name,from_email,from_name,subject,status,notes_raw,ti) VALUES ('0',:folder,:to_email,:to_name,:from_email,:from_name,:subject,:status,:notes_raw,:ti)");
			$q->execute(
        array(
          ':folder'     => 'INBOX',
          ':to_email'   => $config['email'],
          ':to_name'    => $config['business'],
          ':from_email' => $email,
          ':from_name'  => $name,
          ':subject'    => $subject,
          ':status'     => 'unread',
          ':notes_raw'  => $notes,
          ':ti'         => time()
        )
      );
			$id=$db->lastInsertId();
			$e=$db->errorInfo();
			if(is_null($e[2])){
				if($config['email']!=''){
					if($error==0){
						require'class.phpmailer.php';
						$mail   = new PHPMailer;
            $mail  -> isSendmail();
						$mail  -> SetFrom($email, $name);
						$toname = $config['email'];
						$mail  -> AddAddress($config['email']);
						$mail  -> IsHTML(true);
						$mail  -> Subject = 'Contact Email via '.$config['business'].': '.$subject;
						$msg    = 'Message Date: '.date($config['dateFormat'],$ti).'<br />'.
											'Subject: '.$subject.'<br />'.
											'Name: '.$name.'<br />'.
											'Email: '.$email.'<br />'.
											'Message: '.$notes;
						$mail  -> Body=$msg;
						$mail  -> AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
						if($mail->Send())
							$notification=$theme['settings']['contactus_success'];
						else
							$notification=$theme['settings']['contactus_error'];
						$mail2 = new PHPMailer;
						$mail2 -> isSendmail();
						$mail2 -> SetFrom($config['email'], $config['business']);
						$toname = $email;
						$mail2 -> AddAddress($email);
						$mail2 -> IsHTML(true);
						$subject=(isset($config['contactAutoReplySubject'])&&$config['contactAutoReplySubject']=''?$config['contactAutoReplySubject']:'Thank you for contacting {business}');
						$subject=str_replace(
							array(
								'{business}',
								'{date}'
							),
							array(
								$config['business'],
								date($config['dateFormat'],$ti)
							),
							$subject
						);
						$mail2 -> Subject=$subject;
						$msg2=(isset($config['contactAutoReplyLayout'])&&$config['contactAutoReplyLayout']!=''?rawurldecode($config['contactAutoReplyLayout']):'Thank you for Contacting {business}<br />Someone will be in touch to respond to your request.<br />Kind Regards,<br />{business}');
						$n=explode(' ',$name);
						$namefirst=$n[0];
						$namelast=end($n);
						$msg2=str_replace(
							array(
								'{business}',
								'{date}',
								'{name}',
								'{first}',
								'{last}',
								'{subject}'
							),
							array(
								($config['business']!=''?$config['business']:'us'),
								date($config['dateFormat'],$ti),
								$name,
								$namefirst,
								$namelast,
								$subject
							),
							$msg2
						);
						$mail2->Body=$msg2;
						$mail2->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
						if($mail2->Send())
							$notification=$theme['settings']['contactus_success'];
						else
							$notification=$theme['settings']['contactus_error'];
					}
				}
			}else
				$notification=$theme['settings']['contactus_error'];
		}
	}
  echo$notification;
}
