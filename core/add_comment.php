<script>/*<![CDATA[*/
<?php session_start();
include'db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
define('SESSIONID',session_id());
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
define('THEME','../layout/'.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$theme=parse_ini_file(THEME.'/theme.ini',true);
$act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
$ip=$_SERVER['REMOTE_ADDR'];
$error=0;
$ti=time();
if($act=='add_comment'){
	if($_POST['emailtrap']==''){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
			$contentType=filter_input(INPUT_POST,'ct',FILTER_SANITIZE_STRING);
			$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
			$notes=filter_input(INPUT_POST,'notes',FILTER_SANITIZE_STRING);
			$q=$db->prepare("SELECT id,name,email,avatar,gravatar FROM login WHERE email=:email");
			$q->execute(array(':email'=>$email));
			$u=$q->fetch(PDO::FETCH_ASSOC);
			if($u['email']=='')$u=array('id'=>'0','name'=>$name,'email'=>$email,'avatar'=>'','gravatar'=>'');
			$q=$db->prepare("INSERT INTO comments (contentType,rid,uid,ip,avatar,gravatar,email,name,notes,status,ti) VALUES (:contentType,:rid,:uid,:ip,:avatar,:gravatar,:email,:name,:notes,:status,:ti)");
			$q->execute(array(':contentType'=>$contentType,':rid'=>$rid,':uid'=>$u['id'],':ip'=>$ip,':avatar'=>$u['avatar'],':gravatar'=>$u['gravatar'],':email'=>$u['email'],':name'=>$u['name'],':notes'=>$notes,':status'=>'unapproved',':ti'=>$ti));
			$id=$db->lastInsertId();
			$e=$db->errorInfo();
			if(is_null($e[2])){
				if($config['email']!=''){
					if($error==0){
						$q=$db->prepare("SELECT * FROM content WHERE id=:id");
						$q->execute(array(':id'=>$rid));
						$r=$q->fetch(PDO::FETCH_ASSOC);
						require'class.phpmailer.php';
						$mail=new PHPMailer();
						$mail->IsSMTP();
						$mail->SetFrom($email,$name);
						$mail->AddAddress($config['email']);
						$mail->IsHTML(true);
						$mail->Subject='Comment on '.ucfirst($r['contentType']).': '.$r['title'];
						$msg='A comment was made on '.ucfirst($r['contentType']).': '.$r['title'];
						$msg.='Name: '.$name.'<br />';
						$msg.='Email: '.$email.'<br />';
						$msg.='Comment: '.$notes;
						$mail->Body=$msg;
						$mail->AltBody=$msg;
						if($mail->Send())$notification=$theme['settings']['comment_success'];
						else$notification=$theme['settings']['comment_error'];
					}
				}
			}else$notification=$theme['settings']['comment_error'];
		}
	}
}?>
	window.top.document.getElementById("notification").innerHTML='<?php echo$notification;?>';
/*]]>*/</script>
