<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Email Booking
 *
 * email_booking.php version 2.0.2
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
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix Notifications.
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
  $subject=isset($config['bookingEmailSubject'])&&$config['bookingEmailSubject']!=''?$config['bookingEmailSubject']:localize('booking_emailsubject');
  $namee=explode(' ',$r['name']);
  $subject=str_replace([
    '{'.localize('business').'}',
    '{'.localize('name').'}',
    '{'.localize('first').'}',
    '{'.localize('last').'}',
    '{'.localize('date').'}'
  ],[
    $config['business'],
    $r['name'],
    $namee[0],
    end($namee),
    date($config['dateFormat'],$r['tis'])
  ],$subject);
  $mail->Subject=$subject;
  $msg=isset($config['bookingEmailLayout'])&&$config['bookingEmailLayout']!=''?rawurldecode($config['bookingEmailLayout']):localize('booking_emaillayout');
  $msg=str_replace([
    '{'.localize('business').'}',
    '{'.localize('name').'}',
    '{'.localize('first').'}',
    '{'.localize('last').'}',
    '{'.localize('date').'}',
    '{'.localize('details').'}'
  ],[
    $config['business'],
    $r['name'],
    $namee[0],
    end($namee),
    date($config['dateFormat'],$r['tis']),
    localize('Booking Status').': '.ucfirst($r['status']).'<br />'.localize('Name').': '.$r['name'].'<br />'.localize('Email').': '.$r['email'].'<br />'.localize('Business').': '.$r['business'].'<br />'.localize('Address').': '.$r['address'].'<br />'.localize('Suburb').': '.$r['suburb'].'<br />'.localize('City').': '.$r['city'].'<br />'.localize('State').': '.$r['state'].'<br />'.localize('Postcode').': '.$r['postcode'].'<br />'.localize('Phone').': '.$r['phone'].'<br />'.localize('Service/Event Booked').': ['.$i['code'].'] '.$i['title'].'<br />'.localize('Booked For').': '.date($config['dateFormat'],$r['tis']).($r['tie']!=0?' '.localize('To').' '.date($config['dateFormat'],$r['tie']):'').'<br />'.localize('Notes').': '.rawurldecode($r['notes'])
  ],$msg);
  $mail->Body=$msg;
  $mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
  if($mail->Send()){
    $alertmsg=str_replace('{'.localize('business').'}',$r['business']!=''?$r['business']:$r['name'],localize('alert_booking_success_sent'));?>
window.top.window.toastr["success"]('<?php echo$alertmsg;?>');
  <?php }else{
    $alertmsg=str_replace('{'.localize('business').'}',$r['business']!=''?$r['business']:$r['name'],localize('alert_booking_danger_errorsend'));?>
window.top.window.toastr["danger"]('<?php echo$alertmsg;?>');
  <?php }
}else{?>
window.top.window.toastr["info"]('<?php echo localize('alert_booking_info_noclientemail');?>');
<?php }?>
window.top.window.Pace.stop();
<?php
echo'</script>';
