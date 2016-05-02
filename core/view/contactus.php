<?php
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
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
						require'core'.DS.'class.phpmailer.php';
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
						if($mail->Send()){
							$notification=$theme['settings']['contactus_success'];
							$mail=new PHPMailer();
							$mail->IsSMTP();
							$mail->SetFrom($config['email'],$config['business']);
							$toname=$email;
							$mail->AddAddress($email);
							$mail->IsHTML(true);
							$sub=$config['contactAutoReplySubject'];
							$sub=str_replace('{business}',$config['business'],$sub);
							$sub=str_replace('{date}',date($config['dateFormat'],$ti),$sub);
							$mail->Subject=$sub;
							$msg=$config['contactAutoReplyLayout'];
							$msg=str_replace('{business}',$config['business'],$msg);
							$msg=str_replace('{date}',date($config['dateFormat'],$ti),$msg);
							$msg=str_replace('{name}',$name,$msg);
							$n=explode(' ',$name);
							$namefirst=$n[0];
							$namelast=end($n);
							$sub=str_replace('{first}',$namefirst,$sub);
							$sub=str_replace('{last}',$namelast,$sub);
							$msg=str_replace('{subject}',$subject,$msg);
							$mail->Body=$msg;
							$mail->AltBody=$msg;
							if($mail->Send())$notification=$theme['settings']['contactus_success'];
							else $notification=$theme['settings']['contactus_error'];
						}else $notification=$theme['settings']['contactus_error'];

					}
				}
			}else $notification=$theme['settings']['contactus_error'];
		}
	}
}
$s=$db->prepare("SELECT * FROM choices WHERE contentType='subject' ORDER BY title ASC");
$s->execute();
if($s->rowCount()>0){
	$html=preg_replace('~<subjectText>.*?<\/subjectText>~is','',$html,1);
	$html=str_replace('<subjectSelect>','',$html);
	$html=str_replace('</subjectSelect>','',$html);
	$options='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$options.='<option value="'.$r['id'].'">'.$r['title'].'</option>';
	}
	$html=str_replace('<subjectOptions>',$options,$html);
}else{
	$html=preg_replace('~<subjectSelect>.*?<\/subjectSelect>~is','',$html,1);
	$html=str_replace('<subjectText>','',$html);
	$html=str_replace('</subjectText>','',$html);
}
require'core'.DS.'parser.php';
$html=str_replace('<notification>',$notification,$html);
$content.=$html;
