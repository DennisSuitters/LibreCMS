<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$html=preg_replace(
  array(
    '/<print theme>/',
    '/<print url>/',
    '/<print meta=favicon>/',
    '/<print config=[\"\']?business[\"\']?>/'
  ),
  array(
    THEME,
    URL,
    $favicon,
    htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8')
  ),
  $html
);
if(stristr($html,'<buildSocial')){
	preg_match('/<buildSocial>([\w\W]*?)<\/buildSocial>/',$html,$matches);
	$htmlSocial=$matches[1];
	$socialItems='';
	$s=$db->query("SELECT * FROM `".$prefix."choices` WHERE contentType='social' AND uid=0 ORDER BY icon ASC");
	if($s->rowCount()>0){
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$buildSocial=$htmlSocial;
			$buildSocial=str_replace(
				array(
					'<print sociallink>',
					'<print socialicon>'
				),
				array(
					htmlspecialchars($r['url'],ENT_QUOTES,'UTF-8'),
					frontsvg('libre-social-'.$r['icon'])
				),
				$buildSocial
			);
			$socialItems.=$buildSocial;
		}
	}else
		$socialItems='';
	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$socialItems,$html,1);
}
$content.=$html;
