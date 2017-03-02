<?php
require'db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
if($config['development']==1){
  error_reporting(E_ALL);
  ini_set('display_errors','On');
}else{
  error_reporting(E_ALL);
  ini_set('display_errors','Off');
  ini_set('log_errors','On');
  ini_set('error_log','..'.DS.'media'.DS.'cache'.DS.'error.log');
}
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$q=$db->prepare("SELECT * FROM content WHERE id=:id");
$q->execute(array(':id'=>$id));
$r=$q->fetch(PDO::FETCH_ASSOC);
$r['notes']=rawurldecode($r['notes']);
$s=$db->prepare("SELECT * FROM login WHERE id=:id");
$s->execute(array(':id'=>$r['cid']));
$c=$s->fetch(PDO::FETCH_ASSOC);
$ti=time();
$si=$db->prepare("SELECT code,title FROM content WHERE id=:id");
$si->execute(array(':id'=>$r['rid']));
$i=$si->fetch(PDO::FETCH_ASSOC);?>
<script>/*<![CDATA[*/
<?php require"class.phpmailer.php";
	$mail=new PHPMailer();
	$mail->IsSMTP();
	$toname=$c['name'];
	$mail->SetFrom($config['email'],$config['business']);
	$mail->AddAddress($r['email']);
	$mail->IsHTML(true);
  if($config['bookingEmailReadNotification']{0}==1){
    $mail->AddCustomHeader("X-Confirm-Reading-To:".$config['email']);
    $mail->AddCustomHeader("Return-receipt-to:".$config['email']);
    $mail->AddCustomHeader("Disposition-Notification-To:".$config['email']);
    $mail->ConfirmReadingTo=$config['email'];
  }
  $subject=$config['bookingEmailSubject'];
  $subject=str_replace('{business}',$config['business'],$subject);
  $subject=str_replace('{name}',$r['name'],$subject);
	$name=explode(' ',$r['name']);
	$subject=str_replace('{first}',$name[0],$subject);
  if(isset($name[1]))$subject=str_replace('{last}',$name[1],$subject);else$subject=str_replace('{last}','',$subject);
  $subject=str_replace('{date}',date($config['dateFormat'],$r['tis']),$subject);
	$mail->Subject=$subject;
	$msg=rawurldecode($config['bookingEmailLayout']);
	$msg=str_replace('{name}',$r['name'],$msg);
  $msg=str_replace('{first}',$name[0],$msg);
  if(isset($name[1]))$msg=str_replace('{last}',$name[1],$msg);else$msg=str_replace('{last}','',$msg);
	$msg=str_replace('{date}',date($config['dateFormat'],$r['tis']),$msg);
  $details='Booking Status: '.ucfirst($r['status']).'<br />';
  $details.='Name: '.$r['name'].'<br />';
  $details.='Email: '.$r['email'].'<br />';
  $details.='Business: '.$r['business'].'<br />';
  $details.='Address: '.$r['address'].'<br />';
  $details.='Suburb: '.$r['suburb'].'<br />';
  $details.='City: '.$r['city'].'<br />';
  $details.='State: '.$r['state'].'<br />';
  $details.='Postcode: '.$r['postcode'].'<br />';
  $details.='Phone: '.$r['phone'].'<br />';
  $details.='Service/Event Booked: ['.$i['code'].']'.$i['title'].'<br />';
  $details.='Booked For: '.date($config['dateFormat'],$r['tis']);
  if($r['tie']!=0)$details.=' To '.$date($config['dateFormat'],$r['tie']);
  $details.='<br />';
  $details.='Notes: '.rawurldecode($r['notes']);
  $msg=str_replace('{details}',$details,$msg);
  $msg=str_replace('{business}',$config['business'],$msg);
	$mail->Body=$msg;
	$mail->AltBody=$msg;
	if($mail->Send()){?>
	window.top.window.$('#notifications').append('<div class="alert alert-success notification_<?php echo$r['ti'];?> animated">The Booking to <?php if($r['business'])echo$r['business'];else echo$r['name'];?> was Sent Successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
  window.top.window.$('.notification_<?php echo$r['ti'];?>').addClass("bounceIn").delay(4000).queue(function(){$(this).addClass("zoomOut").delay(500).queue(function(){$(this).remove().dequeue();}).dequeue();});
<?php }else{?>
	window.top.window.$('#notifications').append('<div class="alert alert-danger notification_<?php echo$r['ti'];?> animated bounceIn">There was an issue sending the Order<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
  window.top.window.$('.notification_<?php echo$r['ti'];?>').addClass("bounceIn").delay(4000).queue(function(){$(this).addClass("zoomOut").delay(500).queue(function(){$(this).remove().dequeue();}).dequeue();});
<?php }?>
  window.top.window.Pace.stop();
/*]]>*/</script>
