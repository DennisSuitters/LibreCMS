<?php
if($_SESSION['rank']>0){
	$su=$db->prepare("SELECT avatar,gravatar FROM login WHERE id=:uid");
	$su->execute(array(':uid'=>$_SESSION['uid']));
	$user=$su->fetch(PDO::FETCH_ASSOC);
	if($view=='proofs'||$view=='proof')
		$html=str_replace('<print active="proofs">',' class="active"',$html);
	else
		$html=str_replace('<print active="proofs">','',$html);
	if($view=='orders'||$view=='order')
		$html=str_replace('<print active="orders">',' class="active"',$html);
	else
		$html=str_replace('<print active="orders">','',$html);
	if($view=='settings')
		$html=str_replace('<print active="settings">',' class="active"',$html);
	else
		$html=str_replace('<print active="settings">','',$html);
	if(stristr($html,'<print user=avatar>')||stristr($html,'<print user="avatar">')){
		if(isset($user)&&$user['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$user['avatar']))
			$html=str_replace(array('<print user=avatar>','<print user="avatar">'),'media'.DS.'avatar'.DS.$user['avatar'],$html);
		elseif(isset($user)&&$user['gravatar']!=''){
			if(stristr('@',$user['gravatar']))
				$html=str_replace(array('<print user=avatar>','<print user="avatar">'),'http://gravatar.com/avatar/'.md5($user['gravatar']),$html);
			elseif(stristr('gravatar.com/avatar/'))
				$html=str_replace(array('<print user=avatar>','<print user="avatar">'),$user['gravatar'],$html);
			else
				$html=str_replace(array('<print user=avatar>','<print user="avatar">'),$noavatar,$html);
		}else
			$html=str_replace(array('<print user=avatar>','<print user="avatar">'),$noavatar,$html);
	}
	$html=str_replace(array('<accountmenu>','</accountmenu>'),'',$html);
}else
	$html=preg_replace('~<accountmenu>.*?<\/accountmenu>~is','',$html,1);
$html=str_replace(array('<print config=seoTitle>','<print config="seoTitle">'),$config['seoTitle'],$html);
$html=str_replace(array('<print meta=url>','<print meta="url">'),URL,$html);
if(stristr($html,'<buildMenu')){
//	preg_match('/<buildMenu>([\w\W]*?)<\/buildMenu>/',$html,$matches);
	$htmlMenu='';
	$s=$db->query("SELECT * FROM menu WHERE menu='head' AND mid=0 AND active=1 ORDER BY ord ASC");
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$sm=$db->prepare("SELECT * FROM menu WHERE mid=:mid AND active=1 ORDER BY ord ASC");
		$sm->execute(array(':mid'=>$r['id']));
		$htmlMenu.='<li class="';
		if($sm->rowCount()>0)$htmlMenu.='dropdown';
		if($r['contentType']==$view)$htmlMenu.=' active';
		$htmlMenu.='" role="listitem">';
		$htmlMenu.='<a href="';
		if($r['contentType']!='index'){
			if(isset($r['url'][0])&&$r['url'][0]=='#')
				$htmlMenu.=URL.$r['url'];
			elseif(isset($r['url'])&&filter_var($r['url'],FILTER_VALIDATE_URL))
				$htmlMenu.=$r['url'];
			else
				$htmlMenu.=URL.$r['contentType'];
			$htmlMenu.='" rel="'.$r['contentType'].'"';
		}else{
			$htmlMenu.=URL.'" rel="home"';
		}
		$htmlMenu.='>'.$r['title'].'</a>';
		if($sm->rowCount()>0){
			$htmlMenu.='<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="caret"></i><span class="sr-only">Toggle dropdown menu</span><span class="toggle drop down"></span></a>';
			$htmlMenu.='<ul class="dropdown-menu pull-right">';
			while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
				$htmlMenu.='<li><a href="';
				if($rm['contentType']!='index'){
					if(isset($rm['url'][0])&&$rm['url'][0]=='#')
						$htmlMenu.=URL.$rm['url'];
					elseif(isset($rm['url'])&&filter_var($rm['url'],FILTER_VALIDATE_URL))
						$htmlMenu.=$rm['url'];
					else
						$htmlMenu.=URL.strtolower($rm['contentType']);
					if($rm['contentType']=='page')
						$htmlMenu.='/'.str_replace(' ','-',strtolower($rm['title']));
					$htmlMenu.='" rel="'.$rm['contentType'].'"';
				}else{
					$htmlMenu.=URL.'" rel="home"';
				}
				$htmlMenu.=' role="link" rel="'.$rm['contentType'].'">'.$rm['title'].'</a></li>';
			}
			$htmlMenu.='</ul>';
		}else
			$htmlMenu.='</li>';
	}
	$html=preg_replace('~<buildMenu>.*?<\/buildMenu>~is',$htmlMenu,$html,1);
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
	}else$socialItems='';
	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$socialItems,$html,1);
	if($config['options']{9}==1){
		$html=str_replace(array('<rss>','</rss>'),'',$html);
		if($page['contentType']=='article'||$page['contentType']=='portfolio'||$page['contentType']=='event'||$page['contentType']=='news'||$page['contentType']=='inventory'||$page['contentType']=='service')
			$html=str_replace('<print rsslink>','rss/'.$page['contentType'],$html);
		else
			$html=str_replace('<print rsslink>','rss',$html);
		$html=str_replace('<print rssicon>',frontsvg('social-rss'),$html);
	}else
		$html=preg_replace('~<rss>.*?<\/rss>~is','',$html,1);
}
if(isset($_GET['activate'])&&$_GET['activate']!=''){
	$activate=filter_input(INPUT_GET,'activate',FILTER_SANITIZE_STRING);
	$sa=$db->prepare("UPDATE login SET active='1',activate='',rank='100' WHERE activate=:activate");
	$sa->execute(array(':activate'=>$activate));
	if($sa->rowCount()>0)
		$html=str_replace('<activation>','<div class="alert alert-success">Your Account is now Active!</div>',$html);
	else
		$html=str_replace('<activation>','<div class="alert alert-danger">There was an Issue Activating your Account!</div>',$html);
}else
	$html=str_replace('<activation>','',$html);
if($config['postcode']==0)$config['postcode']='';
$html=str_replace(array(
	'<print config=business>','<print config="business">',
	'<print config=address>','<print config="address">',
	'<print config=suburb>','<print config="suburb">',
	'<print config=postcode>','<print config="postcode">',
	'<print config=country>','<print config="country">',
	'<print config=email>','<print config="email">',
	'<print config=phone>','<print config="phone">',
	'<print config=mobile>','<print config="mobile">'
),array(
	htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8'),
),$html);
$content.=$html;
