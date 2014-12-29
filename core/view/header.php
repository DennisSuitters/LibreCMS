<?php
$html=str_replace('<print config=seoTitle>',$config['seoTitle'],$html);
$s=$db->query("SELECT * FROM menu WHERE menu='head' AND active='1' ORDER BY ord ASC");
preg_match('/<buildMenu>([\w\W]*?)<\/buildMenu>/',$html,$matches);
$htmlMenu=$matches[1];
$menu='';
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	$buildMenu=$htmlMenu;
	if($view==$r['contentType']){
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
