<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(stristr($html,'<events')){
	preg_match('/<events>([\w\W]*?)<\/events>/',$html,$matches);
	$event=$matches[1];
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE 'events' AND internal!='1' AND status='published' ORDER BY ti DESC LIMIT 2");
	$s->execute();
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$event;
		if($r['seoCaption']=='')$r['seoCaption']=strip_tags($r['notes']);
		$items=preg_replace(
			array(
				'/<print content=[\"\']?schematype[\"\']?>/',
				'/<print content=[\"\']?title[\"\']?>/',
				'/<print metaDate>/',
				'/<print time>/',
				'/<print link>/',
				'/<print content=[\"\']?caption[\"\']?>/'
			),
			array(
				$r['schemaType'],
				htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
				date($config['dateFormat'],$r['tis']),
				date($config['dateFormat'],$r['tis']),
				URL.'events/'.urlencode(str_replace(' ','-',$r['title'])),
				htmlspecialchars(preg_replace('/\s+?(\S+)?$/','',substr($r['seoCaption'],0,151)),ENT_QUOTES,'UTF-8')
			),
			$items
		);
		$output.=$items;
	}
	$html=preg_replace('~<events>.*?<\/events>~is',$output,$html,1);
}
if(stristr($html,'<news')){
	preg_match('/<news>([\w\W]*?)<\/news>/',$html,$matches);
	$news=$matches[1];
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE 'news' AND internal!='1' AND status='published' ORDER BY ti DESC LIMIT 2");
	$s->execute();
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$news;
		if($r['seoCaption']=='')$r['seoCaption']=strip_tags($r['notes']);
		$items=preg_replace(
			array(
				'/<print content=[\"\']?schemaType[\"\']?>/',
				'/<print content=[\"\']?title[\"\']?>/',
				'/<print metaDate>/',
				'/<print time>/',
				'/<print link>/',
				'/<print content=[\"\']?caption[\"\']?>/'
			), array(
				$r['schemaType'],
				htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
				date($config['dateFormat'],$r['tis']),
				date($config['dateFormat'],$r['tis']),
				URL.'news/'.urlencode(str_replace(' ','-',$r['title'])),
				htmlspecialchars(preg_replace('/\s+?(\S+)?$/','',substr($r['seoCaption'],0,151)),ENT_QUOTES,'UTF-8')
			),
			$items
		);
		$output.=$items;
	}
	$html=preg_replace('~<news>.*?<\/news>~is',$output,$html,1);
}
$content.=$html;
