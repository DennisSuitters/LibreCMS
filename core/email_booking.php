<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Email Booking
 *
 * email_booking.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Email Booking
 * @package    core/email_booking.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
echo'<script>';
$getcfg=true;
require'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$q=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
$q->execute([':id'=>$id]);
$r=$q->fetch(PDO::FETCH_ASSOC);
$r['notes']=rawurldecode($r['notes']);
$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$s->execute([':id'=>$r['cid']]);
$c=$s->fetch(PDO::FETCH_ASSOC);
$ti=time();
if($c['email']!=''){
  $si=$db->prepare("SELECT code,title FROM `".$prefix."content` WHERE id=:id");
  $si->execute([':id'=>$r['rid']]);
  $i=$si->fetch(PDO::FETCH_ASSOC);
  require'class.phpmailer.php';
  $mail=new PHPMailer;
  $mail->isSendmail();
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
  $subject=isset($config['bookingEmailSubject'])&&$config['bookingEmailSubject']!=''?$config['bookingEmailSubject']:'Booking Information from {business}';
  $namee=explode(' ',$r['name']);
  $subject=str_replace([
    '{business}',
    '{name}',
    '{first}',
    '{last}',
    '{date}'
  ],[
    $config['business'],
    $r['name'],
    $namee[0],
    end($namee),
    date($config['dateFormat'],$r['tis'])
  ],$subject);
  $mail->Subject=$subject;
  $msg=isset($config['bookingEmailLayout'])&&$config['bookingEmailLayout']!=''?rawurldecode($config['bookingEmailLayout']):'Hi {first},<br />{details}<br /><br />Please check the details above, and get in touch if any need correcting.<br /><br />Kind Regards,<br />{business}';
  $msg=str_replace([
    '{business}',
    '{name}',
    '{first}',
    '{last}',
    '{date}',
    '{details}'
  ],[
    $config['business'],
    $r['name'],
    $namee[0],
    end($namee),
    date($config['dateFormat'],$r['tis']),
    'Booking Status: '.ucfirst($r['status']).'<br />Name: '.$r['name'].'<br />Email: '.$r['email'].'<br />Business: '.$r['business'].'<br />Address: '.$r['address'].'<br />Suburb: '.$r['suburb'].'<br />City: '.$r['city'].'<br />State: '.$r['state'].'<br />Postcode: '.$r['postcode'].'<br />Phone: '.$r['phone'].'<br />Service/Event Booked: ['.$i['code'].'] '.$i['title'].'<br />Booked For: '.date($config['dateFormat'],$r['tis']).($r['tie']!=0?' To '.date($config['dateFormat'],$r['tie']):'').'<br />Notes: '.rawurldecode($r['notes'])
  ],$msg);
  $mail->Body=$msg;
  $mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
  if($mail->Send()){?>
window.top.window.$.notify({type:'success',icon:'',message:'The Booking to <?php echo($r['business']!=''?$r['business']:$r['name']);?> was Sent Successfully!'});
  <?php }else{?>
window.top.window.$.notify({type:'danger',icon:'',message:'There was an issue sending the Order to <?php echo($r['business']!=''?$r['business']:$r['name']);?>!'});
  <?php }
}else{?>
window.top.window.$.notify({type:'info',icon:'',message:'Client\'s Email has not been set!'});
<?php }?>
window.top.window.Pace.stop();
<?php
echo'</script>';
