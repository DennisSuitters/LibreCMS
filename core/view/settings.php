<?php
$rank=0;
$show='';
$theme=parse_ini_file(THEME.'/theme.ini',true);
$currentPassCSS='';
$currentPassHidden=$theme['settings']['settings_hidden'];
$matchPassCSS='';
$matchPassHidden=$theme['settings']['settings_hidden'];
$successHidden=$theme['settings']['settings_hidden'];
$successShow=$theme['settings']['settings_show'];
$success=$theme['settings']['settings_hidden'];
$act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
if(isset($_SESSION['uid'])&&$_SESSION['uid']>0){
	$s=$db->prepare("SELECT * FROM login WHERE id=:id");
	$s->execute(array(':id'=>$_SESSION['uid']));
	$user=$s->fetch(PDO::FETCH_ASSOC);
}
if(isset($user)&&$user['rank']>0){
	if(isset($act)&&$act=='updatePassword'&&isset($_POST['emailTrap'])&&$_POST['emailTrap']==''){
		if(isset($_POST['currentPass'])){
			$currentPass=filter_input(INPUT_POST,'currentPass',FILTER_SANITIZE_STRING);
			$cPass=hash('SHA512',$user['username']).hash('SHA512',$currentPass);
			if($cPass==$user['password']){
				if(isset($_POST['newPass'])&&isset($_POST['confirmPass'])){
					$newPass=filter_input(INPUT_POST,'newPass',FILTER_SANITIZE_STRING);
					$confirmPass=filter_input(INPUT_POST,'confirmPass',FILTER_SANITIZE_STRING);
					if($newPass==$confirmPass){
						$pass=hash('SHA512',$user['username']).hash('SHA512',$newPass);
						$s=$db->prepare("UPDATE login SET password=:password WHERE id=:id");
						$s->execute(array(':password'=>$pass,':id'=>$user['id']));
						$success='';
					}else{
						$matchPassCSS=$theme['settings']['settings_errorInput'];
						$matchPassHidden=$theme['settings']['settings_show'];
					}
				}else{
					$matchPassCSS=$theme['settings']['settings_errorInput'];
					$matchPassHidden=$theme['settings']['settings_show'];
				}
			}else{
				$currentPassCSS=$theme['settings']['settings_errorInput'];
				$currentPassHidden=$theme['settings']['settings_show'];
			}
		}
	}
	if(isset($act)&&$act=='updateAccount'&&isset($_POST['emailTrap'])&&$_POST['emailTrap']==''){
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
		$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
		$url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_STRING);
		$business=filter_input(INPUT_POST,'business',FILTER_SANITIZE_STRING);
		$phone=filter_input(INPUT_POST,'phone',FILTER_SANITIZE_STRING);
		$mobile=filter_input(INPUT_POST,'mobile',FILTER_SANITIZE_STRING);
		$address=filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING);
		$suburb=filter_input(INPUT_POST,'suburb',FILTER_SANITIZE_STRING);
		$city=filter_input(INPUT_POST,'city',FILTER_SANITIZE_STRING);
		$state=filter_input(INPUT_POST,'state',FILTER_SANITIZE_STRING);
		$postcode=filter_input(INPUT_POST,'postcode',FILTER_SANITIZE_STRING);
		$s=$db->prepare("UPDATE login SET email=:email,name=:name,url=:url,business=:business,phone=:phone,mobile=:mobile,address=:address,suburb=:suburb,city=:city,state=:state,postcode=:postcode WHERE id=:id");
		$s->execute(array(':email'=>$email,':name'=>$name,':url'=>$url,':business'=>$business,':phone'=>$phone,':mobile'=>$mobile,':address'=>$address,':suburb'=>$suburb,':city'=>$city,':state'=>$state,':postcode'=>$postcode,':id'=>$user['id']));
		$e=$db->errorInfo();
		if(is_null($e[2])){
			$s=$db->prepare("SELECT * FROM login WHERE id=:id");
			$s->execute(array(':id'=>$user['id']));
			$user=$s->fetch(PDO::FETCH_ASSOC);
			if(stristr($html,'<success accountHidden>'))$html=str_replace('<success accountHidden>',$theme['settings']['settings_show'],$html);
				if(stristr($html,'<error accountHidden>'))$html=str_replace('<error accountHidden>',$theme['settings']['settings_hidden'],$html);
		}else{
			if(stristr($html,'<success accountHidden>'))$html=str_replace('<success accountHidden>',$theme['settings']['settings_hidden'],$html);
			if(stristr($html,'<error accountHidden>'))$html=str_replace('<error accountHidden>',$theme['settings']['settings_show'],$html);
		}
	}else{
		if(stristr($html,'<success accountHidden>'))$html=str_replace('<success accountHidden>',$theme['settings']['settings_hidden'],$html);
		if(stristr($html,'<error accountHidden>'))$html=str_replace('<error accountHidden>',$theme['settings']['settings_hidden'],$html);
	}
	if(stristr($html,'<error currentPassCSS>'))$html=str_replace('<error currentPassCSS>',$currentPassCSS,$html);
	if(stristr($html,'<error currentPassHidden>'))$html=str_replace('<error currentPassHidden>',$currentPassHidden,$html);
	if(stristr($html,'<error matchPassCSS>'))$html=str_replace('<error matchPassCSS>',$matchPassCSS,$html);
	if(stristr($html,'<error matchPassHidden>'))$html=str_replace('<error matchPassHidden>',$matchPassHidden,$html);
	if(stristr($html,'<success passUpdated>'))$html=str_replace('<success passUpdated>',$success,$html);
	if(stristr($html,'<print user=gravatar>'))$html=str_replace('<print user=gravatar>',$user['gravatar'],$html);
	if(stristr($html,'<print user=ti>'))$html=str_replace('<print user=ti>',date($config['dateFormat'],$user['ti']),$html);
	if(stristr($html,'<print user=username>'))$html=str_replace('<print user=username>',$user['username'],$html);
	if(stristr($html,'<print user=rank>')){
		$rank='Visitor';
		switch($user['rank']){
			case 100:$rank='Subscriber';break;
			case 200:$rank='Member';break;
			case 300:$rank='Client';break;
			case 400:$rank='Contributor';break;
			case 500:$rank='Moderator';break;
			case 600:$rank='Author';break;
			case 700:$rank='Editor';break;
			case 800:$rank='Manager';break;
			case 900:$rank='Administrator';break;
			case 1000:$rank='Developer';break;
			default:$rank='Visitor';break;
		}
		$html=str_replace('<print user=rank>',$rank,$html);
	}
	if(stristr($html,'<print user=email>'))$html=str_replace('<print user=email>',$user['email'],$html);
	if(stristr($html,'<print user=name>'))$html=str_replace('<print user=name>',$user['name'],$html);
	if(stristr($html,'<print user=url>'))$html=str_replace('<print user=url>',$user['url'],$html);
	if(stristr($html,'<print user=business>'))$html=str_replace('<print user=business>',$user['business'],$html);
	if(stristr($html,'<print user=phone>'))$html=str_replace('<print user=phone>',$user['phone'],$html);
	if(stristr($html,'<print user=mobile>'))$html=str_replace('<print user=mobile>',$user['mobile'],$html);
	if(stristr($html,'<print user=address>'))$html=str_replace('<print user=address>',$user['address'],$html);
	if(stristr($html,'<print user=suburb>'))$html=str_replace('<print user=suburb>',$user['suburb'],$html);
	if(stristr($html,'<print user=city>'))$html=str_replace('<print user=city>',$user['city'],$html);
	if(stristr($html,'<print user=state>'))$html=str_replace('<print user=state>',$user['state'],$html);
	if(stristr($html,'<print user=postcode>')){
		if($user['postcode']==0)$user['postcode']='';
		$html=str_replace('<print user=postcode>',$user['postcode'],$html);
	}

}else{
	$html='';
	if(file_exists(THEME.'/noaccess.html')){
		$html=file_get_contents(THEME.'/noaccess.html');
	}
}
$content.=$html;
