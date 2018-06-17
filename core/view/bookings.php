<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$notification='';
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
if($act=='add_booking'){
	if($_POST['emailtrap']=='none'){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$name     =filter_input(INPUT_POST,'name',    FILTER_SANITIZE_STRING);
			$business =filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING);
			$address  =filter_input(INPUT_POST,'address', FILTER_SANITIZE_STRING);
			$suburb   =filter_input(INPUT_POST,'suburb',  FILTER_SANITIZE_STRING);
			$city     =filter_input(INPUT_POST,'city',    FILTER_SANITIZE_STRING);
			$state    =filter_input(INPUT_POST,'state',   FILTER_SANITIZE_STRING);
			$postcode =filter_input(INPUT_POST,'postcode',FILTER_SANITIZE_STRING);
			$phone    =filter_input(INPUT_POST,'phone',   FILTER_SANITIZE_STRING);
			$notes    =filter_input(INPUT_POST,'notes',   FILTER_SANITIZE_STRING);
			$tis      =filter_input(INPUT_POST,'tis',     FILTER_SANITIZE_STRING);
			$tim      =filter_input(INPUT_POST,'tim',     FILTER_SANITIZE_STRING);
			$tis=($tis==0?$ti:strtotime($tis.$tim));
			$rid=isset($_POST['rid'])?filter_input(INPUT_POST,'rid',FILTER_SANITIZE_STRING):0;
			if($rid!=0){
				$s=$db->prepare("SELECT id,tie FROM content WHERE id=:id");
				$s->execute(array(':id'=>$rid));
				$r=$s->fetch(PDO::FETCH_ASSOC);
				$tie=$r['tie'];
			}else
				$tie=0;
			$q=$db->prepare("INSERT INTO content (rid,contentType,name,email,business,address,suburb,city,state,postcode,phone,notes,status,tis,tie,ti) VALUES (:rid,:contentType,:name,:email,:business,:address,:suburb,:city,:state,:postcode,:phone,:notes,:status,:tis,:tie,:ti)");
			$q->execute(
				array(
					':rid'         => $rid,
					':contentType' => 'booking',
					':name'        => $name,
					':email'       => $email,
					':business'    => $business,
					':address'     => $address,
					':suburb'      => $suburb,
					':city'        => $city,
					':state'       => $state,
					':postcode'    => $postcode,
					':phone'       => $phone,
					':notes'       => $notes,
					':status'      => 'unconfirmed',
					':tis'         => $tis,
					':tie'         => $tie,
					':ti'          => $ti
				)
			);
			$e=$db->errorInfo();
			if(is_null($e[2])){
				if($config['email']!=''){
					require'core'.DS.'class.phpmailer.php';
					$mail=new PHPMailer;
					$mail->isSendmail();
					$mail->SetFrom($email,$name);
					$toname=$config['email'];
					$mail->AddAddress($config['email']);
					$mail->IsHTML(true);
					$mail->Subject='Booking Created by '.$name.' at '.$config['business'];
					$msg='Booking Date: '.date($config['dateFormat'],$tis).'<br />';
					if($rid!=0){
						$s=$db->prepare("SELECT * FROM content WHERE id=:id");
						$s->execute(array(':id'=>$rid));
						$r=$s->fetch(PDO::FETCH_ASSOC);
						$msg.='Booked: '.ucfirst(rtrim($r['contentType'],'s')).' - '.$r['title'];
					}
					$msg.='Name: '.$name.'<br />'.
								'Email: '.$email.'<br />'.
								'Business: '.$business.'<br />'.
								'Address: '.$address.'<br />'.
								'Suburb: '.$suburb.'<br />'.
								'City: '.$city.'<br />'.
								'State: '.$state.'<br />'.
								'Postcode: '.$postcode.'<br />'.
								'Phone: '.$phone.'<br />'.
								'Notes: '.$notes;
					$mail->Body=$msg;
					$mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
					if($mail->Send())
						$notification=$theme['settings']['booking_success'];
				}
				if($email!=''){
					$mail2=new PHPMailer;
					$mail2->isSendmail();
					$mail2->SetFrom($config['email'], $config['business']);
					$toname=$email;
					$mail2->AddAddress($email);
					$mail2->IsHTML(true);
					$namee=explode(' ',$name);
					$subject=(isset($config['bookingAutoReplySubject'])&&$config['bookingAutoReplySubject']!=''?$config['bookingAutoReplySubject']:'Booking Confirmation from {business}');
					$subject=str_replace(
						array(
							'{business}',
							'{name}',
							'{first}',
							'{last}',
							'{date}'
						),
						array(
							$config['business'],
							$name,
							$namee[0],
							end($namee),
							date($config['dateFormat'],$ti)
						),
						$subject
					);
					$mail2->Subject=$subject;
					$msg2=(isset($config['bookingAutoReplyLayour'])&&$config['bookingAutoReplyLayout']!=''?rawurldecode($config['bookingAutoReplyLayour']):'Thank you for '.($config['business']!=''?' Booking with {business}':'').' your Booking.<br />Someone will be in touch to confirm your Booking time.<br />Regards,<br />{business}');
					$bookingDate=($tis!=0?date($config['dateFormat'],$tis):'');
					$bookingService=($rid!=0?ucfirst(rtrim($r['contentType'],'s')).' - '.$r['title']:'');
					$msg2=str_replace(
						array(
							'{business}',
							'{name}',
							'{first}',
							'{last}',
							'{date}',
							'{booking_date}',
							'{service}'
						),
						array(
							$config['business'],
							$name,
							$namefirst,
							$namelast,
							date($config['dateFormat'],$ti),
							$bookingDate,
							$bookingService
						),
						$msg2
					);
					$mail2->Body=$msg2;
					$mail2->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg2));
					if($mail2->Send())
						$notification=$theme['settings']['booking_success'];
					else
						$notification=$theme['settings']['booking_error'];
				}
			}else
				$notification=$theme['settings']['booking_error'];
		}
	}
}else{
	$sql=$db->query("SELECT * FROM content WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
	if($sql->rowCount()>0){
		$bookable='';
		while($row=$sql->fetch(PDO::FETCH_ASSOC)){
			$bookable.='<option value="'.htmlentities($row['id'],ENT_QUOTES,'UTF-8').'" role="option"';
			if($row['id']==$args[0])$bookable.=' selected';
			$bookable.='>'.ucfirst(htmlentities($row['contentType'],ENT_QUOTES,'UTF-8'));
			if($row['code']!='')$bookable.=':'.htmlentities($row['code'],ENT_QUOTES,'UTF-8');
			$bookable.=':'.htmlentities($row['title'],ENT_QUOTES,'UTF-8').'</option>';
		}
		$html=str_replace(
			array(
				'<serviceoptions>',
				'<bookservices>',
				'</bookservices>'
			),
			array(
				$bookable,
				'',
				''
			),
			$html
		);
	}else
		$html=preg_replace('~<bookservices>.*?<\/bookservices>~is','<input type="hidden" name="service" value="0">',$html,1);
}
$html=str_replace('<notification>',$notification,$html);
$content.=$html;
