<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(stristr($html,'<address')){
	$html=preg_replace(
		array(
			'/<print config=[\"\']?address[\"\']?>/',
			'/<print config=[\"\']?state[\"\']?>/',
			'/<print config=[\"\']?suburb[\"\']?>/',
			'/<print config=[\"\']?country[\"\']?>/',
			'/<print config=[\"\']?postcode[\"\']?>/',
			'/<print config=[\"\']?phone[\"\']?>/',
			'/<print config=[\"\']?mobile[\"\']?>/'
		),
		array(
			htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
			htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8'),
			htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
			htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8'),
			htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
			htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'),
			htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8')
		),
		$html
	);
}
$s=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='subject' ORDER BY title ASC");
$s->execute();
if($s->rowCount()>0){
	$html=preg_replace(
		array(
			'~<subjectText>.*?<\/subjectText>~is',
			'/<subjectSelect>/',
			'/<\/subjectSelect>/'
		),
		'',
		$html
	);
	$options='';
	while($r=$s->fetch(PDO::FETCH_ASSOC))$options.='<option value="'.$r['id'].'" role="option">'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'</option>';
	$html=str_replace('<subjectOptions>',$options,$html);
}else{
	$html=preg_replace(
		array(
			'~<subjectSelect>.*?<\/subjectSelect>~is',
			'/<subjectText>/',
			'/<\/subjectText>/'
		),
		'',
		$html
	);
}
require'core'.DS.'parser.php';
$content.=$html;
