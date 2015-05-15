<?php
$theme=parse_ini_file(THEME.'/theme.ini',true);
$notification='';
if($act=='add_booking'){
	if($_POST['emailtrap']==''){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
			$business=filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING);
			$address=filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING);
			$suburb=filter_input(INPUT_POST,'suburb',FILTER_SANITIZE_STRING);
			$city=filter_input(INPUT_POST,'city',FILTER_SANITIZE_STRING);
			$state=filter_input(INPUT_POST,'state',FILTER_SANITIZE_STRING);
			$postcode=filter_input(INPUT_POST,'postcode',FILTER_SANITIZE_STRING);
			$phone=filter_input(INPUT_POST,'phone',FILTER_SANITIZE_STRING);
			$notes=filter_input(INPUT_POST,'notes',FILTER_SANITIZE_STRING);
			$tis=filter_input(INPUT_POST,'tis',FILTER_SANITIZE_STRING);
			$tim=filter_input(INPUT_POST,'tim',FILTER_SANITIZE_STRING);
			if($tis==0){
				$tis=$ti;
			}else{
				$tis=strtotime($tis.$tim);
			}
			$rid=isset($_POST['rid'])?filter_input(INPUT_POST,'rid',FILTER_SANITIZE_STRING):0;
			if($rid!=0){
				$s=$db->prepare("SELECT id,tie FROM content WHERE id=:id");
				$s->execute(array(':id'=>$rid));
				$r=$s->fetch(PDO::FETCH_ASSOC);
				$tie=$r['tie'];
			}else{
				$tie=0;
			}
			$q=$db->prepare("INSERT INTO content (contentType,name,email,business,address,suburb,city,state,postcode,phone,notes,rid,status,ti,tis,tie) VALUES ('booking',:name,:email,:business,:address,:suburb,:city,:state,:postcode,:phone,:notes,:rid,'unconfirmed',:ti,:tis,:tie)");
			$q->execute(array(':name'=>$name,':email'=>$email,':business'=>$business,':address'=>$address,':suburb'=>$suburb,':city'=>$city,':state'=>$state,':postcode'=>$postcode,':phone'=>$phone,':notes'=>$notes,':rid'=>$rid,':ti'=>$ti,':tis'=>$tis,':tie'=>$tie));
			$e=$db->errorInfo();
			if(is_null($e[2])){
				if($config['email']!=''){
					require'core/class.phpmailer.php';
					$mail=new PHPMailer();
					$mail->IsSMTP();
					$mail->SetFrom($email,$name);
					$toname=$config['email'];
					$mail->AddAddress($config['email']);
					$mail->IsHTML(true);
					$mail->Subject='Booking Created: '.$name;
					$msg='Booking Date: '.date($config['dateFormat'],$tis).'<br />';
					if($rid!=0){
						$s=$db->prepare("SELECT * FROM content WHERE id=:id");
						$s->execute(array(':id'=>$rid));
						$r=$s->fetch(PDO::FETCH_ASSOC);
						$msg.='Booked: '.ucfirst(rtrim($r['contentType'],'s')).' - '.$r['title'];
					}
					$msg.='Name: '.$name.'<br />';
					$msg.='Email: '.$email.'<br />';
					$msg.='Business: '.$business.'<br />';
					$msg.='Address: '.$address.'<br />';
					$msg.='Suburb: '.$suburb.'<br />';
					$msg.='City: '.$city.'<br />';
					$msg.='State: '.$state.'<br /';
					$msg.='Postcode: '.$postcode.'<br />';
					$msg.='Phone: '.$phone.'<br />';
					$msg.='Notes: '.$notes;
					$mail->Body=$msg;
					$mail->AltBody=$msg;
					if($mail->Send()){
						$notification=$theme['settings']['booking_success'];
					}
				}
			}else{
				$notification=$theme['settings']['booking_error'];
			}
		}
	}
}else{
	$sql=$db->query("SELECT * FROM content WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
	if($sql->rowCount()>0){
		$bookable='';
		while($row=$sql->fetch(PDO::FETCH_ASSOC)){
			$bookable.='<option value="'.htmlentities($row['id'],ENT_QUOTES,'UTF-8').'>'.ucfirst(htmlentities($row['contentType'],ENT_QUOTES,'UTF-8'));
			if($row['code']!='')$bookable.=':'.htmlentities($row['code'],ENT_QUOTES,'UTF-8');
			$bookable.=':'.htmlentities($row['title'],ENT_QUOTES,'UTF-8').'</option>';
		}
		$html=str_replace('<serviceoptions>',$bookable,$html);
		$html=str_replace('<bookservices>','',$html);
		$html=str_replace('</bookservices>','',$html);
	}else{
		$html=preg_replace('~<bookservices>.*?<\/bookservices>~is','<input type="hidden" name="service" value="0">',$html,1);
	}
}
$html=str_replace('<notification>',$notification,$html);
$content.=$html;
