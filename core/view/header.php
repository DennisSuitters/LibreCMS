<?php
if($_SESSION['rank']>0){
	$su=$db->prepare("SELECT avatar,gravatar FROM login WHERE id=:uid");
	$su->execute(array(':uid'=>$_SESSION['uid']));
	$user=$su->fetch(PDO::FETCH_ASSOC);
	if($view=='proofs'||$view=='proof')$html=str_replace('<print active="proofs">',' class="active"',$html);else $html=str_replace('<print active="proofs">','',$html);
	if($view=='orders'||$view=='order')$html=str_replace('<print active="orders">',' class="active"',$html);else $html=str_replace('<print active="orders">','',$html);
	if($view=='settings')$html=str_replace('<print active="settings">',' class="active"',$html);else $html=str_replace('<print active="settings">','',$html);
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
$s=$db->query("SELECT * FROM menu WHERE menu='head' AND active='1' ORDER BY ord ASC");
preg_match('/<buildMenu>([\w\W]*?)<\/buildMenu>/',$html,$matches);
$htmlMenu=$matches[1];
$menu='';
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	$buildMenu=$htmlMenu;
	if($view==$r['contentType']||$view==$r['contentType'].'s')$buildMenu=str_replace('<print active=menu>',' active',$buildMenu);else$buildMenu=str_replace('<print active=menu>','',$buildMenu);
	if($r['contentType']!='index')$buildMenu=str_replace('<print menu=contentType>',$r['contentType'],$buildMenu);else$buildMenu=str_replace('<print menu=contentType>','',$buildMenu);
	$buildMenu=str_replace('<print menu="title">',$r['title'],$buildMenu);
	if($r['contentType']=='cart')$buildMenu=str_replace('<menuCart>',$cart,$buildMenu);else$buildMenu=str_replace('<menuCart>','',$buildMenu);
	$menu.=$buildMenu;
}
$html=str_replace('<buildMenu>',$menu.'<buildMenu>',$html);
$html=preg_replace('~<buildMenu>.*?<\/buildMenu>~is','',$html,1);
$content.=$html;
