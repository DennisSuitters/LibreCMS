<?php
preg_match('/<settings itemcount="([\w\W]*?)" contenttype="([\w\W]*?)">/',$html,$matches);
$html=preg_replace('~<settings.*?>~is','',$html,1);
$itemCount=$matches[1];
if($itemCount==0)$itemCount=5;
$contentType=$matches[2];
if($contentType=='all')$contentType='%';
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$it=$matches[1];
$items='';
$s=$db->prepare("SELECT * FROM content WHERE featured='1' AND internal!='1' AND status='published' AND contentType LIKE :contentType ORDER BY ti DESC");
$s->execute(array(':contentType'=>$contentType));
$indicators='';
$indicator='';
$featuredIndicators='';
$ii=$s->rowCount();
$i=0;
if($ii>0){
	if(stristr($html,'<indicators>')){
		preg_match('/<indicators>([\w\W]*?)<\/indicators>/',$html,$matches);
		$indicator=$matches[1];
	}
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$filechk=basename($r['file']);
		if(!$r['file']&&!file_exists('media'.DS.$filechk))continue;
		$item=$it;
		$indicatorItem=$indicator;
		if($i==0){
			$item=str_replace('<print active>',' active',$item);
			$indicatorItem=str_replace('<print active>','active',$indicatorItem);
		}else{
			$item=str_replace('<print active>','',$item);
			$indicatorItem=str_replace('<print active>','',$indicatorItem);
		}
		$indicatorItem=str_replace('<print indicatorCount>',$i,$indicatorItem);
		if($r['options']{0}==1){
			$item=str_replace('<cost>','',$item);
			$item=str_replace('</cost>','',$item);
			$item=str_replace('<print content="cost">',$r['cost'],$item);
		}else$item=preg_replace('~<cost>.*?<\/cost>~is','',$item,1);
		if($r['caption']!='')$item=str_replace('<print content="caption">',$r['caption'],$item);
		$item=str_replace('<print link>',$r['contentType'].'/'.str_replace(' ','-',$r['title']),$item);
		$item=str_replace('<print content="image">','<img src="'.$r['file'].'" class="img-responsive" alt="'.$r['title'].'">',$item);
		$item=str_replace('<print content=schemaType>',$r['schemaType'],$item);
		$item=str_replace('<print content=title>',$r['title'],$item);
		$item=str_replace('<print content="title">',$r['title'],$item);
		$item=str_replace('<print content="contentType">','<div>'.$r['contentType'].'</div>',$item);
		$items.=$item;
		$i++;
		$indicators.=$indicatorItem;
	}
}
if($ii>1){
	$html=preg_replace('~<indicators>.*?<\/indicators>~is',$indicators,$html,1);
	$html=str_replace('<featuredIndicators>','',$html);
	$html=str_replace('</featuredIndicators>','',$html);
	$html=str_replace('<featuredControls>','',$html);
	$html=str_replace('</featuredControls>','',$html);
}else{
	$html=preg_replace('~<featuredControls>.*?<\/featuredControls>~is','',$html,1);
	$html=str_replace('<featuredIndicators>','',$html);
}
if($i>0)$html=preg_replace('~<items>.*?<\/items>~is',$items,$html,1);else$html='';
$content.=$html;
