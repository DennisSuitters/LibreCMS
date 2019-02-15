<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$html=preg_replace(
	array(
		'/<print page=[\"\']?notes[\"\']?>/'
	),
	array(
		rawurldecode($page['notes'])
	),
	$html
);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
$s=$db->query("SELECT DISTINCT contentType FROM `".$prefix."content` WHERE contentType!='' AND internal!='1' AND status='published' ORDER BY contentType ASC");
$items=$testitems='';
if($s->rowCount()>0){
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$item;
		$testlinks='';
		$items=preg_replace('/<print content=[\"\']?contentType[\"\']?>/',ucfirst($r['contentType']),$items);
		$ss=$db->prepare("SELECT DISTINCT id,title FROM `".$prefix."content` WHERE contentType=:content_type AND title!='' AND status='published' AND internal!='1' ORDER BY contentType ASC, ord ASC, ti DESC");
		$ss->execute(
			array(
				':content_type'=>$r['contentType']
			)
		);
		while($rs=$ss->fetch(PDO::FETCH_ASSOC))
			$testlinks.='<a href="'.$r['contentType'].'/'.urlencode(str_replace(' ','-',$rs['title'])).'">'.$rs['title'].'</a><br>';
		$items=preg_replace(
			array(
				'/<print links>/',
			),
			array(
				$testlinks,
			),
			$items
		);
		$sitemapitems.=$items;
	}
}
$html=preg_replace('~<items>.*?<\/items>~is',$sitemapitems,$html,1);
$content.=$html;
