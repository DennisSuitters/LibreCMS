<?php
if($_SESSION['rank']>0){
	$su=$db->prepare("SELECT avatar,gravatar FROM login WHERE id=:uid");
	$su->execute(array(':uid'=>$_SESSION['uid']));
	$user=$su->fetch(PDO::FETCH_ASSOC);
	if($view=='proofs'||$view=='proof')
		$html=str_replace('<print active="proofs">',' class="active"',$html);else $html=str_replace('<print active="proofs">','',$html);
	if($view=='orders'||$view=='order')
		$html=str_replace('<print active="orders">',' class="active"',$html);else $html=str_replace('<print active="orders">','',$html);
	if($view=='settings')
		$html=str_replace('<print active="settings">',' class="active"',$html);
	else
		$html=str_replace('<print active="settings">','',$html);
	if(stristr($html,'<print user=avatar>')){
		if(isset($user)&&$user['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$user['avatar']))$html=str_replace('<print user=avatar>','media'.DS.'avatar'.DS.$user['avatar'],$html);
		elseif(isset($user)&&$user['gravatar']!=''){
			if(stristr('@',$user['gravatar']))$html=str_replace('<print user=avatar>','http://gravatar.com/avatar/'.md5($user['gravatar']),$html);elseif(stristr('gravatar.com/avatar/'))$html=str_replace('<print user=avatar>',$user['gravatar'],$html);else$html=str_replace('<print user=avatar>',$noavatar,$html);
		}else$html=str_replace('<print user=avatar>',$noavatar,$html);
	}
	$html=str_replace('<accountmenu>','',$html);
	$html=str_replace('</accountmenu>','',$html);
}else$html=preg_replace('~<accountmenu>.*?<\/accountmenu>~is','',$html,1);
$html=str_replace('<print config="seoTitle">',$config['seoTitle'],$html);

if(stristr($html,'<print meta=url>'))
	$html=str_replace('<print meta=url>',URL,$html);
$s=$db->query("SELECT * FROM menu WHERE menu='head' AND active='1' ORDER BY ord ASC");
if(stristr($html,'<buildMenu')){
	preg_match('/<buildMenu>([\w\W]*?)<\/buildMenu>/',$html,$matches);
	$htmlMenu=$matches[1];
	$menu='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$buildMenu=$htmlMenu;
		if($view==$r['contentType']||$view==$r['contentType'].'s')
			$buildMenu=str_replace('<print active=menu>',' active',$buildMenu);
		else
			$buildMenu=str_replace('<print active=menu>','',$buildMenu);
		if($r['contentType']!='index'){
			$buildMenu=str_replace('<print menu=url>',URL.$r['contentType'],$buildMenu);
			$buildMenu=str_replace('<print rel=contentType>',strtolower($r['contentType']),$buildMenu);
		}else{
			$buildMenu=str_replace('<print menu=url>',URL,$buildMenu);
			$buildMenu=str_replace('<print rel=contentType>','home',$buildMenu);
		}
		$buildMenu=str_replace('<print menu="title">',$r['title'],$buildMenu);
		if($r['contentType']=='cart')$buildMenu=str_replace('<menuCart>',$cart,$buildMenu);else$buildMenu=str_replace('<menuCart>','',$buildMenu);
		$menu.=$buildMenu;
	}
	$html=str_replace('<buildMenu>',$menu.'<buildMenu>',$html);
	$html=preg_replace('~<buildMenu>.*?<\/buildMenu>~is','',$html,1);
}
if(stristr($html,'<buildSocial')){
	preg_match('/<buildSocial>([\w\W]*?)<\/buildSocial>/',$html,$matches);
	$htmlSocial=$matches[1];
	$socialItems='';
	$s=$db->query("SELECT * FROM choices WHERE contentType='social' AND uid=0 ORDER BY icon ASC");
	if($s->rowCount()>0){
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$buildSocial=$htmlSocial;
			$buildSocial=str_replace('<print sociallink>',$r['url'],$buildSocial);
			$buildSocial=str_replace('<print socialicon>',frontsvg('social-'.$r['icon']),$buildSocial);
			$socialItems.=$buildSocial;
		}
	}else $socialItems='';
	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$socialItems,$html,1);
	if($config['options']{9}==1){
		$html=str_replace('<rss>','',$html);
		$html=str_replace('</rss>','',$html);
		if($page['contentType']=='article'||$page['contentType']=='portfolio'||$page['contentType']=='event'||$page['contentType']=='news'||$page['contentType']=='inventory'||$page['contentType']=='service')
			$html=str_replace('<print rsslink>','rss/'.$page['contentType'],$html);
		else
			$html=str_replace('<print rsslink>','rss',$html);
		$html=str_replace('<print rssicon>',frontsvg('social-rss'),$html);
	}else{
		$html=preg_replace('~<rss>.*?<\/rss>~is','',$html,1);
	}
}
if(isset($_GET['activate'])&&$_GET['activate']!=''){
	$activate=filter_input(INPUT_GET,'activate',FILTER_SANITIZE_STRING);
	$sa=$db->prepare("UPDATE login SET active='1',activate='',rank='100' WHERE activate=:activate");
	$sa->execute(array(':activate'=>$activate));
	if($sa->rowCount()>0){
		$html=str_replace('<activation>','<div class="alert alert-success">Your Account is now Active!</div>',$html);
	}else{
		$html=str_replace('<activation>','<div class="alert alert-danger">There was an Issue Activating your Account!</div>',$html);
	}
}else{
	$html=str_replace('<activation>','',$html);
}
if(stristr($html,'<address')){
	if($config['business']!='')$business=$config['business'];else$business='';
	$html=str_replace('<print config="business">',$business,$html);
	if($config['address']!='')$address=$config['address'].', ';else$address='';
	$html=str_replace('<print config="address">',$address,$html);
	if($config['suburb']!='')$suburb=$config['suburb'].', ';else$suburb='';
	$html=str_replace('<print config="suburb">',$suburb,$html);
	if($config['postcode']!=0)$postcode=$config['postcode'].', ';else$postcode='';
	$html=str_replace('<print config="postcode">',$postcode,$html);
	if($config['country']!='')$country=$config['country'];else$country='';
	$html=str_replace('<print config="country">',$country,$html);
	if($config['email']!='')$email='<a href="contactus/">'.$config['email'].'</a>';else$email='';
	$html=str_replace('<print config="email">',$email,$html);
	if($config['phone']!='')$phone='<a href="tel:'.str_replace(' ','',$config['phone']).'">'.$config['phone'].'</a>';else$phone='';
	$html=str_replace('<print config=phone>',$phone,$html);
	$html=str_replace('<print config="phone">',$phone,$html);
	if($config['mobile']!='')$mobile='<span class="mobile"><a href="tel:'.str_replace(' ','',$config['mobile']).'">'.$config['mobile'].'</a></span>';else$mobile='';
	$html=str_replace('<print config=mobile>',$mobile,$html);
	$html=str_replace('<print config="mobile">',$mobile,$html);
}
$content.=$html;