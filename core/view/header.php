<?php
if($_SESSION['rank']>0){
	if($view=='proofs'||$view=='proof')$html=str_replace('<print activeproofs>',' class="active"',$html);else $html=str_replace('<print activeproofs>','',$html);
	if($view=='orders'||$view=='order')$html=str_replace('<print activeorders>',' class="active"',$html);else $html=str_replace('<print activeorders>','',$html);
	if($view=='settings')$html=str_replace('<print activesettings>',' class="active"',$html);else $html=str_replace('<print activesettings>','',$html);
	if(stristr($html,'<print user=avatar>')){
		if(isset($user)&&$user['gravatar']!='')
			$html=str_replace('<print user=avatar>','http://gravatar.com/avatar/'.md5($user['gravatar']),$html);
		elseif(isset($user)&&$user['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$user['avatar']))
			$html=str_replace('<print user=avatar>','media'.DS.'avatar'.DS.$user['avatar'],$html);
		else
			$html=str_replace('<print user=avatar>',$noavatar,$html);
	}
	$html=str_replace('<accountmenu>','',$html);
	$html=str_replace('</accountmenu>','',$html);
}else $html=preg_replace('~<accountmenu>.*?<\/accountmenu>~is','',$html,1);
$html=str_replace('<print config=seoTitle>',$config['seoTitle'],$html);
$s=$db->query("SELECT * FROM menu WHERE menu='head' AND active='1' ORDER BY ord ASC");
preg_match('/<buildMenu>([\w\W]*?)<\/buildMenu>/',$html,$matches);
$htmlMenu=$matches[1];
$menu='';
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	$buildMenu=$htmlMenu;
	if($view==$r['contentType']||$view==$r['contentType'].'s'){
		$buildMenu=str_replace('<print menu=active>',' active',$buildMenu);
	}else{
		$buildMenu=str_replace('<print menu=active>','',$buildMenu);
	}
	if($r['contentType']!='index'){
		$buildMenu=str_replace('<print menu=contentType>',$r['contentType'],$buildMenu);
	}else $buildMenu=str_replace('<print menu=contentType>','',$buildMenu);
	$buildMenu=str_replace('<print menu=title>',$r['title'],$buildMenu);
	if($r['contentType']=='cart'){
		$buildMenu=str_replace('<menuCart>',$cart,$buildMenu);
	}else{
		$buildMenu=str_replace('<menuCart>','',$buildMenu);
	}
	$menu.=$buildMenu;
}
$html=str_replace('<buildMenu>',$menu.'<buildMenu>',$html);
$html=preg_replace('~<buildMenu>.*?<\/buildMenu>~is','',$html,1);
$content.=$html;
