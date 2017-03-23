<?php
if($_SESSION['rank']>0)
	$link='<a href="?act=logout">Logout</a>';
else{
	if($config['options']{3}==1)
		$link_x=' or Sign Up';
	else{
		$link_x='';
		$html=preg_replace('~<block signup>.*?<\/block signup>~is','',$html,1);
	}
	if($config['options']{2}==1)
		$link='<a href="login/">Login'.$link_x.'</a>';
	else
		$link='<a href="login/">Login'.$link_x.'</a>';
}
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
if(isset($_SESSION['rank'])&&$_SESSION['rank']>899)
	$html=str_replace('<administration>','<a target="_blank" href="'.$settings['system']['admin'].'">Administration</a>',$html);
else
	$html=str_replace('<administration>','',$html);
$html=str_replace(array(
	'<print theme=title>','<print theme="title">',
	'<print theme=creator>','<print theme="creator">',
	'<print theme=creator_url>','<print theme="creator_url">',
	'<print year>',
	'<print config=business>','<print config="business">',
	'<print config=abn>','<print config="abn">',
	'<login>',
	'<print config=business>','<print config="business">',
	'<print config=address>','<print config="address">',
	'<print config=suburb>','<print config="suburb">',
	'<print config=postcode>','<print config="postcode">',
	'<print config=country>','<print config="country">',
	'<print config=email>','<print config="email">',
	'<print config=phone>','<print config="phone">',
	'<print config=mobile>','<print config="mobile">'
),array(
	htmlspecialchars($theme['title'],ENT_QUOTES,'UTF-8'),htmlspecialchars($theme['title'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator'],ENT_QUOTES,'UTF-8'),htmlspecialchars($theme['creator'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($theme['creator_url'],ENT_QUOTES,'UTF-8'),htmlspecialchars($theme['creator_url'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['abn'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['abn'],ENT_QUOTES,'UTF-8'),
	$link,$link,
	htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['email'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'),
	htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8'),htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8')
),$html);
if(stristr($html,'<subjectText>')){
	$s=$db->prepare("SELECT * FROM choices WHERE contentType='subject' ORDER BY title ASC");
	$s->execute();
	if($s->rowCount()>0){
		$html=preg_replace('~<subjectText>.*?<\/subjectText>~is','',$html,1);
		$html=str_replace(array('<subjectSelect>','</subjectSelect>'),'',$html);
		$options='';
		while($r=$s->fetch(PDO::FETCH_ASSOC))$options.='<option value="'.$r['id'].'" role="option">'.$r['title'].'</option>';
		$html=str_replace('<subjectOptions>',$options,$html);
	}else{
		$html=preg_replace('~<subjectSelect>.*?<\/subjectSelect>~is','',$html,1);
		$html=str_replace(array('<subjectText>','</subjectText>'),'',$html);
	}
}
if(stristr($html,'<buildMenu')){
	$s=$db->query("SELECT * FROM menu WHERE menu='footer' AND mid=0 AND active=1 ORDER BY ord ASC");
	preg_match('/<buildMenu>([\w\W]*?)<\/buildMenu>/',$html,$matches);
	$htmlMenu=$matches[1];
	$menu='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$buildMenu=$htmlMenu;
		if($r['contentType']=='page'&&$r['title']==$activeTitle)
			$buildMenu=str_replace('<print active=menu>',' active',$buildMenu);
		elseif($view==$r['contentType']||$view==$r['contentType'].'s')
			$buildMenu=str_replace('<print active=menu>',' active',$buildMenu);
		else
			$buildMenu=str_replace('<print active=menu>','',$buildMenu);
		if($r['contentType']!='index'){
			if(isset($r['url'][0])&&$r['url'][0]=='#')
				$buildMenu=str_replace('<print menu=url>',URL.$r['url'],$buildMenu);
			elseif(filter_var($r['url'],FILTER_VALIDATE_URL))
				$buildMenu=str_replace('<print menu=url>',$r['url'],$buildMenu);
			elseif($r['contentType']=='page'&&$r['title']!='')
					$buildMenu=str_replace(array('<print menu=url>','<print menu="url">'),URL.strtolower($r['contentType']).'/'.str_replace(' ','-',$r['title']),$buildMenu);
			else
				$buildMenu=str_replace('<print menu=url>',URL.$r['contentType'],$buildMenu);
			$buildMenu=str_replace('<print rel=contentType>',strtolower($r['contentType']),$buildMenu);
		}else{
			$buildMenu=str_replace('<print menu=url>',URL,$buildMenu);
			$buildMenu=str_replace('<print rel=contentType>','home',$buildMenu);
		}
		$buildMenu=str_replace(array('<print menu=title>','<print menu="title">'),$r['title'],$buildMenu);
		if($r['contentType']=='cart')
			$buildMenu=str_replace('<menuCart>',$cart,$buildMenu);
		else
			$buildMenu=str_replace('<menuCart>','',$buildMenu);
		if($r['contentType']=='cart')
			$buildMenu=str_replace('<menuCart>',$cart,$buildMenu);
		else
			$buildMenu=str_replace('<menuCart>','',$buildMenu);
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
	}else
		$socialItems='';
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
$content.=$html;
