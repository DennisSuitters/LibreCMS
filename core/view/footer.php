<?php
if($_SESSION['rank']>0){
	$link='<a href="logout"><small>Logout</small></a>';
}else{
	if($config['options']{3}==1){
		$link_x=' or Sign Up';
	}else{
		$link_x='';
		$html=preg_replace('~<block signup>.*?<\/block signup>~is','',$html,1);
	}
	if($config['options']{2}==1){
		$link='<a href="#" data-toggle="modal" data-target="#login"><small>Login'.$link_x.'</small></a>';
	}else{
		$link='<a href="login/"><small>Login'.$link_x.'</small></a>';
	}
}
$theme=parse_ini_file(THEME.'/theme.ini',true);
$html=str_replace('<print theme=title>',$theme['title'],$html);
$html=str_replace('<print theme=creator>','<a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>',$html);
$html=str_replace('<login>',$link,$html);
$content.=$html;
