<?php
$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
if(isset($_SESSION['uid'])){$uid=$_SESSION['uid'];}else{$uid=0;}
if(filter_var($email,FILTER_VALIDATE_EMAIL)){
	$s=$db->prepare("SELECT id,status FROM login WHERE email=:email");
	$s->execute(array(':email'=>$email));
	if($s->rowCount()>0){
		$ru=$s->fetch(PDO::FETCH_ASSOC);
		if($ru['status']=='delete'||$ru['status']=='disabled'){?>
			<div class="alert alert-danger">The account associated with the details provided has been suspended</div>
<?php 	}
	}else{
		$business=filter_input(INPUT_POST,'business',FILTER_SANITIZE_EMAIL);
		$address=filter_input(INPUT_POST,'address',FILTER_SANITIZE_EMAIL);
		$suburb=filter_input(INPUT_POST,'suburb',FILTER_SANITIZE_EMAIL);
		$city=filter_input(INPUT_POST,'city',FILTER_SANITIZE_EMAIL);
		$state=filter_input(INPUT_POST,'state',FILTER_SANITIZE_EMAIL);
		$postcode=filter_input(INPUT_POST,'postcode',FILTER_SANITIZE_EMAIL);
		$phone=filter_input(INPUT_POST,'phone',FILTER_SANITIZE_EMAIL);
		$username=explode('@',$email);
		$q=$db->prepare("INSERT INTO login (username,password,email,business,address,suburb,city,state,postcode,phone,status,active,rank,ti) VALUES (:username,'',:email,:business,:address,:suburb,:city,:state,:postcode,:phone,'','1','0',:ti)");
		$q->execute(array(':username'=>$username[0].time(),':email'=>$email,':business'=>$business,':address'=>$address,':suburb'=>$suburb,':city'=>$city,':state'=>$state,':postcode'=>$postcode,':phone'=>$phone,':ti'=>$ti));
		$id=$db->lastInsertId();
		$su=$db->prepare("SELECT id FROM login WHERE id='$id'");
		$su->execute(array(':id'=>$id));
		$ru=$su->fetch(PDO::FETCH_ASSOC);
	}
	$r=$db->query("SELECT MAX(id) as id FROM orders")->fetch(PDO::FETCH_ASSOC);
	$dti=$ti+$config['orderPayti'];
	$qid='Q'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
	$q=$db->prepare("INSERT INTO orders (cid,uid,qid,qid_ti,due_ti,status,ti) VALUES (:cid,:uid,:qid,:qid_ti,:due_ti,'pending',:ti)");
	$q->execute(array(':cid'=>$ru['id'],':uid'=>$uid,':qid'=>$qid,':qid_ti'=>$ti,':due_ti'=>$dti,':ti'=>$ti));
	$oid=$db->lastInsertId();
	$s=$db->prepare("SELECT * FROM cart WHERE si=:si");
	$s->execute(array(':si'=>SESSIONID));
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$si=$db->prepare("SELECT title,quantity FROM content WHERE id=:id");
		$si->execute(array(':id'=>$r['iid']));
		$i=$si->fetch(PDO::FETCH_ASSOC);
		$quantity=$i['quantity']-$r['quantity'];
		$qry=$db->prepare("UPDATE content SET quantity=:quantity WHERE id=:id");
		$qry->execute(array(':quantity'=>$quantity,':id'=>$r['iid']));
		$sq=$db->prepare("INSERT INTO orderitems (oid,iid,title,quantity,cost,ti) VALUES (:oid,:iid,:title,:quantity,:cost,:ti)");
		$sq->execute(array(':oid'=>$oid,':iid'=>$r['iid'],':title'=>$i['title'],':quantity'=>$r['quantity'],':cost'=>$r['cost'],':ti'=>$ti));
	}
	$q=$db->prepare("DELETE FROM cart WHERE si=:si");
	$q->execute(array(':si'=>SESSIONID));
	$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
	if($config['email']!=''){
		require'class.phpmailer.php';
		$mail=new PHPMailer();
		$mail->IsSMTP();
		$mail->SetFrom($config['email'],$config[seoTitle]);
		$mail->AddAddress($config['email']);
		$mail->IsHTML(true);
		$mail->Subject='New Order was Created at '.$config[seoTitle];
		$msg='New Order was Created at '.$config[seoTitle].'<br />';
		$msg.='Order #'.$qid;
		$mail->Body=$msg;
		$mail->AltBody=$msg;
		if($mail->Send()){}
	}
	echo'<div class="alert alert-success">Thank you for placing an Order, a representative will process your order as soon as humanly possible</div>';
}else{
	echo'<div class="alert alert-danger">The Email entered is not valid</div>';
}
