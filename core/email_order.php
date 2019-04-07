<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Email Order
 *
 * email_order.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Email Order
 * @package    core/email_order.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 */
$getcfg=true;
require'db.php';
include'tcpdf'.DS.'tcpdf.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$w=filter_input(INPUT_GET,'w',FILTER_SANITIZE_STRING);
$act=filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
$q=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE id=:id");
$q->execute([':id'=>$id]);
$r=$q->fetch(PDO::FETCH_ASSOC);
$r['notes']=rawurldecode($r['notes']);
$s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$s->execute([':id'=>$r['cid']]);
$c=$s->fetch(PDO::FETCH_ASSOC);
$ti=time();
if($r['qid']!='')$oid=$r['qid'];
if($r['iid']!='')$oid=$r['iid'];
$pdf=new TCPDF(PDF_PAGE_ORIENTATION,PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($config['business']);
$pdf->SetTitle('Order #'.$oid);
$pdf->SetSubject('Order #'.$oid);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP,PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE,PDF_MARGIN_BOTTOM);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFont('helvetica','',12);
$pdf->AddPage();
$html='<style>'.
        'body{margin:0;padding:0}'.
        'table{border:0;margin:0}'.
        'table,table tr{background-color:#fff}'.
        'table tr th{background-color:#000;color:#fff;font-size:10px}'.
        'h1,h2,h3,h4,h5,h6,p{margin:0}'.
        '.col-50{width:50px}'.
        '.col-75{width:75px}'.
        '.col-100{width:100px}'.
        '.col-150{width:150px}'.
        '.col-250{width:250px}'.
        '.text-center{text-align:center}'.
        '.text-right{text-align:right}'.
        '.pending{color:#080}'.
        '.overdue{color:#800}'.
      '</style>'.
      '<body>';
$pdflogo='';
if(file_exists('..'.DS.'media'.DS.'orderheading.png'))
  $pdflogo='..'.DS.'media'.DS.'orderheading.png';
elseif(file_exists('..'.DS.'media'.DS.'orderheading.jpg'))
  $pdflogo='..'.DS.'media'.DS.'orderheading.jpg';
elseif(file_exists('..'.DS.'media'.DS.'orderheading.gif'))
  $pdflogo='..'.DS.'media'.DS.'orderheading.gif';
elseif(file_exists('..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'orderheading.png'))
  $pdflogo='..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'orderheading.png';
elseif(file_exists('..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'orderheading.jpg'))
  $pdflogo='..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'orderheading.jpg';
elseif(file_exists('..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'orderheading.gif'))
  $pdflogo='..'.DS.'layout'.DS.$config['theme'].DS.'images'.DS.'orderheading.gif';
else
  $pdflogo='';
if($pdflogo!='')
  $html.='<table class="table"><tr><td style="text-align:right"><img src="'.$pdflogo.'"></td></tr></table>';
$html.='<table class="table">'.
          '<tr>'.
            '<td>'.
              '<h3>'.localize('From').'</h3>'.
              '<p>'.
                '<strong>'.$config['business'].'</strong><br />'.
                localize('ABN').': <strong>'.$config['abn'].'</strong><br />'.
                $config['address'].', '.$config['suburb'].', '.$config['city'].', '.$config['state'].', '.$config['postcode'].
              '</p>'.
            '</td>'.
            '<td>'.
              '<h3>'.localize('To').'</h3>'.
              '<p>'.
                '<strong>'.$c['business'] . '</strong><br />'.
                $c['name'].'<br />'.$c['address'].', '.$c['suburb'].', '.$c['city'].', '.$c['state'].', '.$c['postcode'].
              '</p>'.
            '</td>'.
            '<td>'.
              '<h3>'.localize('Details').'</h3>'.
              '<p>'.
                '<small>'.localize('Order').' <strong>#'.$r['qid'] . $r['iid'].'</strong><br />'.
                localize('Order Date').': <strong>'.date($config['dateFormat'],$r['qid_ti'].$r['iid_ti']) . '</strong><br />'.
                localize('Due Date').': <strong class="'.$r['status'].'">'.date($config['dateFormat'], $r['due_ti']) . '</strong><br />'.
                localize('Status').': <strong class="'.$r['status'].'">'.ucfirst($r['status']).'</strong></small>'.
              '</p>'.
            '</td>'.
          '</tr>'.
        '</table>'.
        '<br />'.
        '<br />'.
        '<table class="table table-striped">'.
          '<thead>'.
            '<tr>'.
              '<th class="col-75">'.localize('Item Code').'</th>'.
              '<th class="col-150">'.localize('Title').'</th>'.
              '<th class="col-150">'.localize('Option').'</th>'.
              '<th class="col-50 text-center">'.localize('Quantity').'</th>'.
              '<th class="col-50 text-right">'.localize('Cost').'</th>'.
              '<th class="col-50 text-right">'.localize('Total').'</th>'.
            '</tr>'.
          '</thead>'.
          '<tbody>';
$i=13;
$ot=$st=$pwc=0;
$zeb=1;
$s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid AND status!='delete'");
$s->execute([':oid'=>$id]);
while($ro=$s->fetch(PDO::FETCH_ASSOC)){
	$si=$db->prepare("SELECT code,title FROM `".$prefix."content` WHERE id=:id");
	$si->execute([':id'=>$ro['iid']]);
	$i=$si->fetch(PDO::FETCH_ASSOC);
	$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
	$sc->execute([':id'=>$ro['cid']]);
	$ch=$sc->fetch(PDO::FETCH_ASSOC);
  $st=$ro['cost']*$ro['quantity'];
	$html.='<tr'.($zeb==1?' style="background-color:#f4f4f4;"':' style="backgroound-color:#fff;"').'>'.
	         '<td class="col-75"><small>'.$i['code'].'</small></td>'.
	         '<td class="col-150"><small>'.($ro['title']==''?$i['title']:$ro['title']).'</small></td>'.
           '<td class="col-150"><small>'.$ch['title'].'</small></td>'.
           '<td class="col-50 text-center"><small>'.$ro['quantity'].'</small></td>'.
           '<td class="col-50 text-right"><small>'.$ro['cost'].'</small></td>'.
           '<td class="col-50 text-right">'.$st.'</td>'.
          '</tr>';
  $ot=$ot+$st;
  $zeb=($zeb==1?0:1);
}
$html.='</tbody>'.
        '<tfoot>';
$sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE id=:rid");
$sr->execute([':rid'=>$r['rid']]);
if($sr->rowCount()>0){
	$reward=$sr->fetch(PDO::FETCH_ASSOC);
	$html.='<tr style="background-color:#f0f0f0">'.
            '<td colspan="3" class="text-right"><small>'.localize('Rewards').'</small></td>'.
            '<td class="col-75 text-right"><small>';
	if($reward['method']==1){
    $html.='$';
    $ot=$o-$reward['value'];
  }
  $html.=$reward['value'];
  if($reward['method']==0){
    $html.='%';
    $ot=($ot*((100-$reward['value'])/100));
  }
  $html.=' Off</small></td>'.
          '<td class="col-75 text-right"><strong>'.$ot.'</strong></td>'.
        '</tr>';
}
if($r['postage']!=0){
	$html.='<tr style="background-color:#f0f0f0">'.
            '<td colspan="3">&nbsp;</td>'.
            '<td class="col-75 text-right">Postage</td>'.
            '<td class="col-75 text-right"><strong>'.$r['postage'].'</strong></td>'.
          '</tr>';
	$ot=$ot+$r['postage'];
}
$html.='<tr style="background-color:#f0f0f0">'.
          '<td colspan="3">&nbsp;</td>'.
          '<td class="col-75 text-right"><strong>'.localize('Total').'</strong></td>'.
          '<td class="col-75 text-right '.$r['status'].'"><strong>'.$ot.'</strong></td>'.
        '</tr>'.
      '</tfoot>'.
    '</table>'.
    '<br />'.
    '<br />'.
    '<table class="table">'.
      '<tbody>'.
        '<tr>'.
          '<td>'.
            '<h4>'.localize('Notes').'</h4>'.
            '<p style="font-size:8px">'.rawurldecode($r['notes']).'</p>'.
          '</td>'.
          '<td>'.
            '<h4>'.localize('Banking Details').'</h4>'.
            '<p>'.
              '<small>'.localize('Bank').': <strong>'.$config['bank'].'</strong><br />'.
              localize('Account Name').': <strong>'.$config['bankAccountName'].'</strong><br />'.
              localize('Account Number').': <strong>'.$config['bankAccountNumber'].'</strong><br />'.
              localize('BSB').': <strong>'.$config['bankBSB'].'</strong></small>'.
            '</p>'.
          '</td>'.
        '</tr>'.
      '</tbody>'.
    '</table>'.
  '</body>';
$pdf->writeHTML($html,true,false,true,false,'');
$pdf->Output(__DIR__.DS.'..'.DS.'media'.DS.'orders'.DS.$oid.'.pdf','F');
chmod('..' .DS.'media'.DS.'orders'.DS.$oid.'.pdf',0777);
echo'<script>';
if($act=='print'){?>
	window.top.window.open('media/orders/<?php echo$oid;?>.pdf','_blank');
<?php }else{
	require'class.phpmailer.php';
	$mail=new PHPMailer;
	$mail->isSendmail();
	$toname=$c['name'];
	$mail->SetFrom($config['email'],$config['business']);
	$mail->AddAddress($c['email']);
	$mail->IsHTML(true);
  if($config['orderEmailReadNotification']{0}==1){
    $mail->AddCustomHeader("X-Confirm-Reading-To:".$config['email']);
    $mail->AddCustomHeader("Return-receipt-to:".$config['email']);
    $mail->AddCustomHeader("Disposition-Notification-To:".$config['email']);
    $mail->ConfirmReadingTo=$config['email'];
  }
  $namee=explode(' ',$c['name']);
  $subject=isset($config['orderEmailSubject'])&&$config['orderEmailSubject']!=''?$config['orderEmailSubject']:localize('Order {order_number} from {business}';
  $subject=str_replace([
    '{'.localize('business').'}',
    '{'.localize('name').'}',
    '{'.localize('first').'}',
    '{'.localize('last').'}',
    '{'.localize('date').'}',
    '{'.localize('order_number').'}'
  ],[
    $config['business'],
    $c['name'],
    $namee[0],
    end($namee),
    date($config['dateFormat'],$r['ti']),
    $oid
  ],$subject);
	$mail->Subject=$subject;
	$msg=isset($config['orderEmailLayout'])&&$config['orderEmailLayout']!=''?rawurldecode($config['orderEmailLayout']):localize('order_emaillayot');
  $msg=str_replace([
    '{'.localize('business').'}',
    '{'.localize('name').'}',
    '{'.localize('first').'}',
    '{'.localize('last').'}',
    '{'.localize('date').'}',
    '{'.localize('order_number').'}',
    '{'.localize('notes').'}'
  ],[
    $config['business'],
    $c['name'],
    $namee[0],
    end($namee),
    date($config['dateFormat'],$r['ti']),
    $oid,
    rawurldecode($r['notes'])
  ],$msg);
	$mail->Body=$msg;
	$mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));
	$mail->AddAttachment('..'.DS.'media'.DS.'orders'.DS.$oid.'.pdf');
	if($mail->Send()){
    $alertmsg=str_replace('{business}',$c['business']!=''?$c['business']:$c['name'],localize('alert_order_success_sent'));?>
window.top.window.toastr["success"]('<?php echo$alertmsg;?>');
<?php }else{
    $alertmsg=str_replace('{business}',$c['business']!=''?$c['business']:$c['name'],localize('alert_order_danger_error'));?>
window.top.window.toastr["danger"]('<?php echo$alertmsg;?>');
<?php }
}?>
  window.top.window.Pace.stop();
<?php
echo'</script>';
