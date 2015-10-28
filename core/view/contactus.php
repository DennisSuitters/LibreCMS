<?php
$theme=parse_ini_file(THEME.'/theme.ini',true);
$error=0;
$notification='';
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
if(isset($act)&&$act=='add_message'){
	if($_POST['emailtrap']=='none'){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
			$subject=filter_input(INPUT_POST,'subject',FILTER_SANITIZE_STRING);
			$notes=filter_input(INPUT_POST,'notes',FILTER_SANITIZE_STRING);
			$q=$db->prepare("INSERT INTO messages (uid,folder,to_email,to_name,from_email,from_name,subject,status,notes_raw,ti) VALUES ('0',:folder,:to_email,:to_name,:from_email,:from_name,:subject,:status,:notes_raw,:ti)");
			$q->execute(array(':folder'=>'INBOX',':to_email'=>$config['email'],':to_name'=>$config['business'],':from_email'=>$email,':from_name'=>$name,':subject'=>$subject,':status'=>'unread',':notes_raw'=>$notes,':ti'=>time()));
			$id=$db->lastInsertId();
			$e=$db->errorInfo();
			if(is_null($e[2])){
				if($config['email']!=''){
					if($error==0){
						require'core/class.phpmailer.php';
						$mail=new PHPMailer();
						$mail->IsSMTP();
						$mail->SetFrom($email,$name);
						$toname=$config['email'];
						$mail->AddAddress($config['email']);
						$mail->IsHTML(true);
						$mail->Subject='Contact Email via '.$config['seoTitle'].': '.$subject;
						$msg='Message Date: '.date($config['dateFormat'],$ti).'<br />';
						$msg.='Subject: '.$subject.'<br />';
						$msg.='Name: '.$name.'<br />';
						$msg.='Email: '.$email.'<br />';
						$msg.='Message: '.$notes;
						$mail->Body=$msg;
						$mail->AltBody=$msg;
						if($mail->Send()){
							$notification=$theme['settings']['contactus_success'];
						}else{
							$notification=$theme['settings']['contactus_error'];
						}
					}
				}
			}else{
				$notification=$theme['settings']['contactus_error'];
			}
		}
	}
}
require'core/parser.php';
$html=str_replace('<notification>',$notification,$html);
$content.=$html;
