<?php
if(stristr($html,'<events')){
	preg_match('/<events>([\w\W]*?)<\/events>/',$html,$matches);
	$event=$matches[1];
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE 'events' AND internal!='1' AND status='published' ORDER BY ti DESC LIMIT 2");
	$s->execute();
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$event;
		$items=str_replace('<print content=schematype',$r['schemaType'],$items);
		$items=str_replace('<print content="title">',$r['title'],$items);
		$items=str_replace('<print metaDate>',date($config['dateFormat'],$r['tis']),$items);
		$items=str_replace('<print time',date($config['dateFormat'],$r['tis']),$items);
		$items=str_replace('<print link>',URL.'events/'.urlencode(str_replace(' ','-',$r['title'])),$items);
		if($r['seoCaption']=='')$r['seoCaption']=strip_tags($r['notes']);
		$items=str_replace('<print content="caption">',preg_replace('/\s+?(\S+)?$/','',substr($r['seoCaption'],0,151)),$items);
		$output.=$items;
	}
	$html=preg_replace('~<events>.*?<\/events>~is',$output,$html,1);
}
if(stristr($html,'<news')){
	preg_match('/<news>([\w\W]*?)<\/news>/',$html,$matches);
	$news=$matches[1];
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE 'news' AND internal!='1' AND status='published' ORDER BY ti DESC LIMIT 2");
	$s->execute();
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$news;
		$items=str_replace('<print content=schematype',$r['schemaType'],$items);
		$items=str_replace('<print content="title">',$r['title'],$items);
		$items=str_replace('<print metaDate>',date($config['dateFormat'],$r['tis']),$items);
		$items=str_replace('<print time',date($config['dateFormat'],$r['tis']),$items);
		$items=str_replace('<print link>',URL.'news/'.urlencode(str_replace(' ','-',$r['title'])),$items);
		if($r['seoCaption']=='')$r['seoCaption']=strip_tags($r['notes']);
		$items=str_replace('<print content="caption">',preg_replace('/\s+?(\S+)?$/','',substr($r['seoCaption'],0,151)),$items);
		$output.=$items;
	}
	$html=preg_replace('~<news>.*?<\/news>~is',$output,$html,1);
}
$content.=$html;
