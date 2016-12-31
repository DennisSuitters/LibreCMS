<?php
if(stristr($html,'<settings')){
	preg_match('/<settings items="(.*?)">/',$html,$matches);
	$count=$matches[1];
}else$count=4;
if(stristr($html,'<print page="notes">'))$html=str_replace('<print page="notes">',$page['notes'],$html);
$html=preg_replace('~<settings.*?>~is','',$html,1);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
$s=$db->query("SELECT * FROM content WHERE contentType='testimonials' AND status='published' ORDER BY ti DESC");
$i=0;
$items='';
$testitems='';
if($s->rowCount()>0){
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$item;
		if($i==0)$items=str_replace('<print content=active>',' active',$items);else$items=str_replace('<print content=active>','',$items);
		$items=str_replace('<print content=schemaType>',$r['schemaType'],$items);
		$items=str_replace('<print config=title>',$config['seoTitle'],$items);
		$items=str_replace('<print datePub>',date('Y-d-m',$r['ti']),$items);
		if(stristr($items,'<print content=avatar>')){
			if($r['cid']!=0){
				$su=$db->prepare("SELECT avatar,gravatar FROM login WHERE id=:id");
				$su->execute(array(':id'=>$r['cid']));
				$ru=$su->fetch(PDO::FETCH_ASSOC);
				if($ru['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$ru['avatar']))
					$items=str_replace('<print content=avatar>','media/avatar/'.$ru['avatar'],$items);
				elseif($r['file']&&file_exists('media'.DS.'avatar'.DS.basename($r['file'])))
					$items=str_replace('<print content=avatar>','media/avatar/'.$r['file'],$items);
				elseif(stristr($ru['gravatar'],'@'))
					$items=str_replace('<print content=avatar>','http://gravatar.com/avatar/'.md5($ru['gravatar']),$items);
				elseif(stristr($ru['gravatar'],'gravatar.com'))
					$items=str_replace('<print content=avatar>',$ru['gravatar'],$items);
				else$items=str_replace('<print content=avatar>',$noavatar,$items);
			}elseif($r['file']&&file_exists('media'.DS.'avatar'.DS.basename($r['file'])))
				$items=str_replace('<print content=avatar>','media/avatar/'.$r['file'],$items);
			else$items=str_replace('<print content=avatar>',$noavatar,$items);
		}
		$items=str_replace('<print content="notes">',strip_tags($r['notes']),$items);
		$items=str_replace('<print content="business">',$r['business'],$items);
		$items=str_replace('<print content=name>',$r['name'],$items);
		$items=str_replace('<print content="name">',$r['name'],$items);
		$testitems.=$items;
		$i++;
	}
}
if($i>0){
	$html=str_replace('<controls>','',$html);
	$html=str_replace('</controls>','',$html);
}else$html=preg_replace('~<controls>.*?<\/controls>~is','',$html,1);
$html=preg_replace('~<items>.*?<\/items>~is',$testitems,$html,1);
$content.=$html;
