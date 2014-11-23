<?php
if(isset($user['rank'])&&$user['rank']>0){
	$link='<a href="logout"><small>Logout</small></a>';
}else{
	if($config['options']{3}==1){$link_x=' or Sign Up';}else{$link_x='';}
	if($config['options']{2}==1){
		$link='<a href="#" data-toggle="modal" data-target="#login"><small>Login'.$link_x.'</small></a>';
	}else{
		$link='<a href="login/"><small>Login'.$link_x.'</small></a>';
	}
}
$html=str_replace('<login>',$link,$html);
$content.=$html;
