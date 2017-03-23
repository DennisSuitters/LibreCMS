<?php // htmlspecialchars( ,ENT_QUOTES,'UTF-8')
if(stristr($html,'<settings')){
	preg_match('/<settings items="(.*?)">/',$html,$matches);
	$count=$matches[1];
}else
	$count=4;
$html=str_replace(array('<print page=notes>','<print page="notes">'),rawurldecode($page['notes']),$html);
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
		if($i==0)
			$items=str_replace('<print content=active>',' active',$items);
		else
			$items=str_replace('<print content=active>','',$items);
		$items=str_replace(array('<print content=schemaType>','<print content="schemaType">'),$r['schemaType'],$items);
		$items=str_replace(array('<print config=title>','<print config="title">'),$config['seoTitle'],$items);
		$items=str_replace('<print datePub>',date('Y-d-m',$r['ti']),$items);
		if(stristr($items,'<print content=avatar>')){
			if($r['cid']!=0){
				$su=$db->prepare("SELECT avatar,gravatar FROM login WHERE id=:id");
				$su->execute(array(':id'=>$r['cid']));
				$ru=$su->fetch(PDO::FETCH_ASSOC);
				if($ru['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$ru['avatar']))
					$items=str_replace(array('<print content=avatar>','<print content="avatar">'),'media'.DS.'avatar'.DS.$ru['avatar'],$items);
				elseif($r['file']&&file_exists('media'.DS.'avatar'.DS.basename($r['file'])))
					$items=str_replace(array('<print content=avatar>','<print content="avatar">'),'media'.DS.'avatar'.DS.$r['file'],$items);
				elseif(stristr($ru['gravatar'],'@'))
					$items=str_replace(array('<print content=avatar>','<print content="avatar">'),'http://gravatar.com/avatar/'.md5($ru['gravatar']),$items);
				elseif(stristr($ru['gravatar'],'gravatar.com'))
					$items=str_replace(array('<print content=avatar>','<print content="avatar">'),$ru['gravatar'],$items);
				else
					$items=str_replace(array('<print content=avatar>','<print content="avatar">'),$noavatar,$items);
			}elseif($r['file']&&file_exists('media'.DS.'avatar'.DS.basename($r['file'])))
				$items=str_replace(array('<print content=avatar>','<print content="avatar">'),'media'.DS.'avatar'.DS.$r['file'],$items);
			else
				$items=str_replace(array('<print content=avatar>','<print content="avatar">'),$noavatar,$items);
		}
		$items=str_replace(array('<print content=notes>','<print content="notes">'),strip_tags(rawurldecode($r['notes'])),$items);
		$items=str_replace(array('<print content=business>','<print content="business">'),$r['business'],$items);
		$items=str_replace(array('<print content=name>','<print content="name">'),$r['name'],$items);
		$testitems.=$items;
		$i++;
	}
}
if($i>0){
	$html=str_replace(array('<controls>','</controls>'),'',$html);
}else
	$html=preg_replace('~<controls>.*?<\/controls>~is','',$html,1);
$html=preg_replace('~<items>.*?<\/items>~is',$testitems,$html,1);
$content.=$html;
