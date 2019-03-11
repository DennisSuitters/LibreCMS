<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Cart Renderer
 *
 * cart.php version 2.0.1
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Cart
 * @package    core/view/cart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.1
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    Add logic and storage for Postage Options
 */
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$notification='';
$ti=time();
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
if($args[0]=='confirm'){
	if($_POST['emailtrap']=='none'){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		$rewards=filter_input(INPUT_POST,'rewards',FILTER_SANITIZE_STRING);
		$po=filter_input(INPUT_POST,'postoption',FILTER_SANITIZE_STRING);
		$uid=isset($_SESSION['uid'])?$_SESSION['uid']:0;
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$s=$db->prepare("SELECT id,status FROM `".$prefix."login` WHERE email=:email");
			$s->execute([':email'=>$email]);
			if($s->rowCount()>0){
				$ru=$s->fetch(PDO::FETCH_ASSOC);
				if($ru['status']=='delete'||$ru['status']=='disabled')
					$notification.=$theme['settings']['account_suspend'];
				else
					$uid=$ru['id'];
			}else{
				$business=filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING);
				$address=filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING);
				$suburb=filter_input(INPUT_POST,'suburb',FILTER_SANITIZE_STRING);
				$city=filter_input(INPUT_POST,'city',FILTER_SANITIZE_STRING);
				$state=filter_input(INPUT_POST,'state',FILTER_SANITIZE_STRING);
				$postcode=filter_input(INPUT_POST,'postcode',FILTER_SANITIZE_STRING);
				$country=filter_input(INPUT_POST,'country',FILTER_SANITIZE_STRING);
				$phone=filter_input(INPUT_POST,'phone',FILTER_SANITIZE_STRING);
				$username=explode('@',$email);
				$q=$db->prepare("INSERT INTO `".$prefix."login` (username,
					password,email,business,address,suburb,city,state,postcode,country,phone,status,active,rank,ti) VALUES (:username,'',:email,:business,:address,:suburb,:city,:state,:postcode,:country,:phone,'','1','0',:ti)");
				$q->execute([
					':username'=>$username[0],
					':email'=>$email,
					':business'=>$business,
					':address'=>$address,
					':suburb'=>$suburb,
					':city'=>$city,
					':state'=>$state,
					':postcode'=>$postcode,
					':country'=>$country,
					':phone'=>$phone,
					':ti'=>$ti
				]);
				$id=$db->lastInsertId();
				$uid=$id;
				$q=$db->prepare("UPDATE `".$prefix."login` SET username=:username WHERE id=:id");
				$q->execute([
					':id'=>$id,
					':username'=>$username[0].$id
				]);
				$su=$db->prepare("SELECT id FROM `".$prefix."login` WHERE id=:id");
				$su->execute([':id'=>$id]);
				$ru=$su->fetch(PDO::FETCH_ASSOC);
				$uid=$r['id'];
			}
			$r=$db->query("SELECT MAX(id) as id FROM `".$prefix."orders`")->fetch(PDO::FETCH_ASSOC);
			$sr=$db->prepare("SELECT id,quantity,tis,tie FROM `".$prefix."rewards` WHERE code=:code");
			$sr->execute([':code'=>$rewards]);
			if($sr->rowCount()>0){
				$reward=$sr->fetch(PDO::FETCH_ASSOC);
				if(!$reward['tis']>$ti&&!$reward['tie']<$ti)$rewards['id']=0;
				if($reward['quantity']<1)
					$reward['id']=0;
				else{
					$sr=$db->prepare("UPDATE `".$prefix."rewards` SET quantity=:quantity WHERE code=:code");
					$sr->execute([
						':quantity'=>$rewards['quantity']-1,
						':code'=>$rewards
					]);
				}
			}else
				$reward['id']=0;
			$dti=$ti+$config['orderPayti'];
			$qid='Q'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
			$postOption='';
			$postCost=0;
			if($po!=0){
				$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
				$sc->execute([':id'=>$po]);
				$rc=$sc->fetch(PDO::FETCH_ASSOC);
				$postOption=$rc['title'];
				$postCost=$rc['value'];
			}
			$q=$db->prepare("INSERT INTO `".$prefix."orders` (cid,uid,qid,qid_ti,due_ti,postageOption,postageCost,rid,status,ti) VALUES (:cid,:uid,:qid,:qid_ti,:due_ti,:postageOption,:postageCost,:rid,'pending',:ti)");
			$q->execute([
				':cid'=>$ru['id'],
				':uid'=>$uid,
				':qid'=>$qid,
				':qid_ti'=>$ti,
				':due_ti'=>$dti,
				':postageOption'=>$postOption,
				':postageCost'=>$postCost,
				':rid'=>$reward['id'],
				':ti'=>$ti
			]);
			$oid=$db->lastInsertId();
			$s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE si=:si");
			$s->execute([':si'=>SESSIONID]);
			while($r=$s->fetch(PDO::FETCH_ASSOC)){
				$si=$db->prepare("SELECT title,quantity FROM `".$prefix."content` WHERE id=:id");
				$si->execute([':id'=>$r['iid']]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$quantity=$i['quantity']-$r['quantity'];
				$qry=$db->prepare("UPDATE `".$prefix."content` SET quantity=:quantity WHERE id=:id");
				$qry->execute([
					':quantity'=>$quantity,
					':id'=>$r['iid']
				]);
				$sq=$db->prepare("INSERT INTO `".$prefix."orderitems` (oid,iid,cid,title,quantity,cost,ti) VALUES (:oid,:iid,:cid,:title,:quantity,:cost,:ti)");
				$sq->execute([
					':oid'=>$oid,
					':iid'=>$r['iid'],
					':cid'=>$r['cid'],
					':title'=>$i['title'],
					':quantity'=>$r['quantity'],
					':cost'=>$r['cost'],
					':ti'=>$ti
				]);
			}
			$q=$db->prepare("DELETE FROM `".$prefix."cart` WHERE si=:si");
			$q->execute([':si'=>SESSIONID]);
			$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
			if($config['email']!=''){
				require'core'.DS.'class.phpmailer.php';
				$mail=new PHPMailer;
				$mail->isSendmail();
				$mail->SetFrom($config['email'],$config['seoTitle']);
				$mail->AddAddress($config['email']);
				$mail->IsHTML(true);
				$mail->Subject='New Order was Created at '.$config['seoTitle'];
				$msg='New Order was Created at '.$config['seoTitle'].'<br />'.'Order #'.$qid;
				$mail->Body=$msg;
				$mail->AltBody=strip_tags(preg_replace('/<br(\s+)?\/?>/i',"\n",$msg));;
				if($mail->Send()){}
			}
			$notification.=$theme['settings']['cart_success'];
		}else
			$notification.=$theme['settings']['cart_suspend'];
		$html=preg_replace('~<emptycart>.*?<\/emptycart>~is',$notification,$html,1);
	}else
		$html=preg_replace('~<emptycart>.*?<\/emptycart>~is','',$html,1);
}else{
	$total=0;
	if(stristr($html,'<items')){
		$s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE si=:si ORDER BY ti DESC");
		$s->execute([':si'=>SESSIONID]);
		preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
		$cartloop=$matches[1];
		$cartitems='';
		if($s->rowCount()>0){
			while($ci=$s->fetch(PDO::FETCH_ASSOC)){
				$cartitem=$cartloop;
				$si=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
				$si->execute([':id'=>$ci['iid']]);
				$i=$si->fetch(PDO::FETCH_ASSOC);
				$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
				$sc->execute([':id'=>$ci['cid']]);
				$c=$sc->fetch(PDO::FETCH_ASSOC);
				if($i['thumb']!='')
					$image=$i['thumb'];
				elseif($i['fileURL']!='')
					$image=$i['fileURL'];
				elseif($i['file']!='')
					$image=$i['file'];
				else
					$image=NOIMAGE;
				$cartitem=preg_replace([
					'/<print content=[\"\']?image[\"\']?>/',
					'/<print content=[\"\']?code[\"\']?>/',
					'/<print content=[\"\']?title[\"\']?>/',
					'/<print choice>/',
					'/<print cart=[\"\']?id[\"\']?>/',
					'/<print cart=[\"\']?quantity[\"\']?>/',
					'/<print cart=[\"\']?cost[\"\']?>/',
					'/<print itemscalculate>/'
				],[
					$image,
					htmlspecialchars($i['code'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($i['title'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($c['title'],ENT_QUOTES,'UTF-8'),
					$ci['id'],
					htmlspecialchars($ci['quantity'],ENT_QUOTES,'UTF-8'),
					$ci['cost'],
					$ci['cost']*$ci['quantity']
				],$cartitem);
				$total=$total+($ci['cost']*$ci['quantity']);
				$cartitems.=$cartitem;
			}
			$total=$total+$ci['postagecost'];
			$html=preg_replace([
				'~<items>.*?<\/items>~is',
				'/<print totalcalculate>/'
			],[
		 		$cartitems,
				$total
			],$html);
			$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='postoption' ORDER BY title ASC");
			$sc->execute();
			$option='';
			if($sc->rowCount()>0){
				while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
					$option.='<option value="'.$rc['id'].'">'.$rc['title'].' (&#36;'.$rc['value'].')</option>';
				}
				$html=preg_replace([
					'/<postoptions>/',
					'/<postageoptions>/',
					'/<\/postageoptions>/',
					'/<emptycart>/',
					'/<\/emptycart>/'
				],[
					$option,
					'',
					'',
					'',
					''
				],$html);
			}else{
				$html=preg_replace('~<postageoptions>.*?<\/postoptions','<input type="hidden" name="postoption" value="0">',$html,1);
			}
			if(isset($user['id'])&&$user['id']>0)
				$html=preg_replace('~<loggedin>.*?<\/loggedin>~is','<input type="hidden" name="email" value="'.htmlspecialchars($user['email'],ENT_QUOTES,'UTF-8').'">',$html,1);
		}else
			$html=preg_replace('~<emptycart>.*?<\/emptycart>~is',$theme['settings']['cart_empty'],$html,1);
	}
}
$content.=$html;
