<?php
if(stristr($html,'<settings')){
	preg_match('/<settings itemcount="(.*?)">/',$html,$matches);
	$count=$matches[1];
}else $count=4;
$html=preg_replace('~<settings.*?>~is','',$html,1);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
if($count==0)$s=$db->query("SELECT * FROM content WHERE contentType='testimonials' ORDER BY ti DESC");
else$s=$db->query("SELECT * FROM content WHERE contentType='testimonials' ORDER BY ti DESC LIMIT $count");
$i=0;
$items='';
$testitems='';
if($s->rowCount()>0){
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$item;
		if($i==0)$items=str_replace('<print content=active>',' active',$items);
		else$items=str_replace('<print content=active>','',$items);
		$items=str_replace('<print content=schemaType>',$r['schemaType'],$items);
		$items=str_replace('<print content="avatar">','http://gravatar.com/avatar/'.md5($r['email']).'?s=100&amp;d=mm',$items);
		$items=str_replace('<print content="notes">',$r['notes'],$items);
		$items=str_replace('<print content="name">',$r['name'],$items);
		$testitems.=$items;
		$i++;
	}
	if($i>1){
		$html=str_replace('<controls>','',$html);
		$html=str_replace('</controls>','',$html);
	}else{
		$html=preg_replace('~<controls>.*?<\/controls>~is','',$html,1);
	}
	$html=preg_replace('~<items>.*?<\/items>~is',$testitems,$html,1);
	$content.=$html;
}
