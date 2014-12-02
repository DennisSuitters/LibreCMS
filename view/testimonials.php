<?php
if($view=='index'){
	preg_match('/<settings itemCount=(.*?)>/',$html,$matches);
	$count=$matches[1];
	$html=preg_replace('~<settings.*?>~is','',$html,1);
	preg_match('/<loop>([\w\W]*?)<\/loop>/',$html,$matches);
	$item=$matches[1];
	$s=$db->query("SELECT * FROM content WHERE contentType='testimonials' ORDER BY ti DESC LIMIT 5");
	$i=0;
	$items='';
	$testitems='';
	if($s->rowCount()>0){
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$items=$item;
			if($i==0){$items=str_replace('<print content=active>',' active',$items);}else $items=str_replace('<print content=active>','',$items);
			$items=str_replace('<print content=schemaType>',$r['schemaType'],$items);
			if($r['email']){
				$items=str_replace('<print content=avatar>','http://gravatar.com/avatar/'.md5($r['email']).'?s=100&amp;d=mm',$items);
			}else $items=str_replace('<print content=avatar>',$noavatar,$items);
			$items=str_replace('<print content=notes>',$r['notes'],$items);
			$items=str_replace('<print content=name>',$r['name'],$items);
			$testitems.=$items;
			$i++;
		}
		if($i>1){
			$html=str_replace('<CONTROLS>','<div class="pull-right"><a class="left" href="#testimonials" data-slide="prev"><span class="fa fa-chevron-left fa-2x"></span></a><a class="right" href="#testimonials" data-slide="next"><span class="fa fa-chevron-right fa-2x"></span></a></div>',$html);
		}else{
			$html=str_replace('<CONTROLS>','',$html);
		}
		$html=preg_replace('~<loop>.*?<\/loop>~is',$testitems,$html,1);
		$content.=$html;
	}
}
