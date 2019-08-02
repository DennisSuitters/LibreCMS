<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Newsletter
 *
 * newsletter.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Newletter
 * @package    core/newsletter.php
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
define('THEME','..'.DS.'layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('ADMINURL',URL.$settings['system']['admin'].'/');
define('UNICODE','UTF-8');
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT title,notes FROM `".$prefix."content` WHERE id=:id");
$s->execute([':id'=>$id]);
$news=$s->fetch(PDO::FETCH_ASSOC);
$u=$db->prepare("UPDATE `".$prefix."content` SET status=:status,tis=:tis WHERE id=:id");
$u->execute([
  ':status'=>'published',
  ':tis'=>time(),
  ':id'=>$id
]);
include'class.phpmailer.php';
if($config['email']!=''){
  $mail=new PHPMailer;
  $body=rawurldecode($news['notes']);
  $body=eregi_replace("[\]",'',$body);
  $mail->isSendmail();
  $mail->isHTML(true);
  $mail->SetFrom($config['email'],$config['business']);
  $mail->Subject=$news['title'];
  $mail->AltBody=localize('warning_newsletteralt');
  if($config['newslettersEmbedImages']{0}==1){
    preg_match_all('/<img.*?>/',$body,$matches);
    if(isset($matches[0])){
      $i=1001;
      foreach($matches[0] as$img){
        $imgid='img'.($i++);
        preg_match('/src="(.*?)"/',$body,$m);
        if(!isset($m[1]))continue;
        $arr=parse_url($m[1]);
        if(!isset($arr['host'])||!isset($arr['path']))continue;
        $imgname=basename($m[1]);
        $mail->addEmbeddedImage('..'.DS.'media'.DS.$imgname,$imgid,$imgname);
        $body=str_replace($img,'<img alt="" src="cid:'.$imgid.'" style="border:none"/>',$body);
      }
    }
  }
  $betweenDelay=$config['newslettersSendMax']!=''||$config['newslettersSendMax']==0?$config['newslettersSendMax']:$betweenDelay=50;
  $sendCount=1;
  $sendDelay=$config['newslettersSendDelay']!=''||$config['newslettersSendDelay']==0?$config['newslettersSendDelay']:1;
  ignore_user_abort(true);
  set_time_limit(300);
  $s=$db->prepare("SELECT DISTINCT email,hash FROM `".$prefix."subscribers` UNION SELECT DISTINCT email,hash FROM `".$prefix."login` WHERE newsletter=1");
  $s->execute();
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    if(($sendCount % $betweenDelay)==0)sleep($sendDelay);
    $mail->AddAddress($r['email']);
    $optOut=$config['newslettersOptOutLayout'];
    $optOut=str_replace('{optOutLink}',URL.'newsletters/unsubscribe/'.$r['hash'],$optOut);
    $mail->Body=$body.$optOut;
    if($mail->Send()){
      $mail->clearAllRecipients();
      $sendCount++;
    }
  }
  if(!empty($mail->ErrorInfo)){?>
    window.top.window.toastr("danger")('<?php echo$mail->ErrorInfo;?>');
    window.top.window.$('#block').css({'display':'none'});
<?php }else{?>
    window.top.window.toastr["success"]('<?php echo localize('alert_newsletter_success_sent');?>');
    window.top.window.$('#block').css({'display':'none'});
<?php }
}else{?>
  window.top.window.toastr("danger")('<?php echo localize('alert_newsletter_danger_noemail');?>');
  window.top.window.Pace.stop();
<?php }
echo'</script>';
