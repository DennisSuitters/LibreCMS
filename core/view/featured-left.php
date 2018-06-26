<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(stristr($html,'<categories')){
	preg_match('/<categories>([\w\W]*?)<\/categories>/',$html,$matches);
	$cat=$matches[1];
	$s=$db->prepare("SELECT DISTINCT category_1 FROM content WHERE contentType LIKE 'inventory' AND internal!='1' AND status='published' ORDER BY category_1 ASC");
	$s->execute();
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$cat;
		$items=preg_replace(
			array(
				'/<print content=[\"\']?link[\"\']?>/',
				'/<print content=[\"\']?category_1[\"\']?>/'
			),
			array(
				URL.'inventory/'.urlencode(str_replace(' ','-',$r['category_1'])),
				htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8')
			),
			$items
		);
		$output.=$items;
	}
	$cats=preg_replace('~<categories>.*?<\/categories>~is',$output,$html,1);
}else$cats='';
$content.=$cats;
