<?php
require'db.php';
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
$ti=time();
if($config['development']==1){
  error_reporting(E_ALL);
  ini_set('display_errors','On');
}else{
  error_reporting(E_ALL);
  ini_set('display_errors','Off');
  ini_set('log_errors','On');
  ini_set('error_log','..'.DS.'media'.DS.'cache'.DS.'error.log');
}
$theme=parse_ini_file('..'.DS.'layout'.DS.$config['theme'].DS.'theme.ini',true);
$error=0;
$notification='';
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
if($act=='add_message'){
	if($_POST['emailtrap']=='none'){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
			$subject=filter_input(INPUT_POST,'subject',FILTER_SANITIZE_STRING);
			$ss=$db->prepare("SELECT * FROM choices WHERE id=:id");
			$ss->execute(array(':id'=>$subject));
			if($ss->rowCount()==1){
				$rs=$ss->fetch(PDO::FETCH_ASSOC);
				$subject=$rs['title'];
				if($rs['url']!='')$config['email']=$rs['url'];
			}
			$notes=filter_input(INPUT_POST,'notes',FILTER_SANITIZE_STRING);
			$q=$db->prepare("INSERT INTO messages (uid,folder,to_email,to_name,from_email,from_name,subject,status,notes_raw,ti) VALUES ('0',:folder,:to_email,:to_name,:from_email,:from_name,:subject,:status,:notes_raw,:ti)");
			$q->execute(array(':folder'=>'INBOX',':to_email'=>$config['email'],':to_name'=>$config['business'],':from_email'=>$email,':from_name'=>$name,':subject'=>$subject,':status'=>'unread',':notes_raw'=>$notes,':ti'=>time()));
			$id=$db->lastInsertId();
			$e=$db->errorInfo();
			if(is_null($e[2])){
				if($config['email']!=''){
					if($error==0){
						require'class.phpmailer.php';
						$mail=new PHPMailer();
						$mail->IsSMTP();
						$mail->SetFrom($email,$name);
						$toname=$config['email'];
						$mail->AddAddress($config['email']);
						$mail->IsHTML(true);
						$mail->Subject='Contact Email via '.$config['business'].': '.$subject;
						$msg='Message Date: '.date($config['dateFormat'],$ti).'<br />';
						$msg.='Subject: '.$subject.'<br />';
						$msg.='Name: '.$name.'<br />';
						$msg.='Email: '.$email.'<br />';
						$msg.='Message: '.$notes;
						$mail->Body=$msg;
						$mail->AltBody=$msg;
						if($mail->Send())
							$notification=$theme['settings']['contactus_success'];
						else
							$notification=$theme['settings']['contactus_error'];
						$mail2=new PHPMailer();
						$mail2->IsSMTP();
						$mail2->SetFrom($config['email'],$config['business']);
						$toname=$email;
						$mail2->AddAddress($email);
						$mail2->IsHTML(true);
						if($config['contactAutoReplySubject']!=''){
							$subject=$config['contactAutoReplySubject'];
							if(stristr($subject,'{business}'))$subject=str_replace('{business}',$config['business'],$subject);
							if(stristr($subject,'{date}'))$subject=str_replace('{date}',date($config['dateFormat'],$ti),$subject);
						}else$subject='Thank you for contacting '.$config['business'];
						$mail2->Subject=$subject;
						if($config['contactAutoReplyLayout']!=''){
							$msg2=rawurldecode($config['contactAutoReplyLayout']);
							if(stristr($msg2,'{business}'))$msg2=str_replace('{business}',$config['business'],$msg2);
							if(stristr($msg2,'{date}'))$msg2=str_replace('{date}',date($config['dateFormat'],$ti),$msg2);
							if(stristr($msg2,'{name}'))$msg2=str_replace('{name}',$name,$msg2);
							$n=explode(' ',$name);
							$namefirst=$n[0];
							$namelast=end($n);
							if(stristr($msg2,'{first}'))$msg2=str_replace('{first}',$namefirst,$msg2);
							if(stristr($msg2,'{last}'))$msg2=str_replace('{last}',$namelast,$msg2);
							if(stristr($msg2,'{subject}'))$msg2=str_replace('{subject}',$subject,$msg2);
						}else{
							$msg2='Thank you for ';
							if($config['business']!='')
								$msg2.=' Contacting '.$config['business'];
							else
								$msg2.=' us.';
							$msg2.='<br />';
							$msg2.='Someone will be in touch to respond to your request.<br />';
							if($config['business']!=''){
								$msg2.='Kind Regards,<br />';
								$msg2.=$config['business'];
							}
						}
						$mail2->Body=$msg2;
						$mail2->AltBody=$msg2;
						if($mail2->Send())
							$notification=$theme['settings']['contactus_success'];
						else
							$notification=$theme['settings']['contactus_error'];
					}
				}
			}else$notification=$theme['settings']['contactus_error'];
		}
	}
  echo$notification;
}
