<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Coming Soon Renderer
 *
 * comingsoon.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Coming Soon
 * @package    core/view/comingsoon.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$html=preg_replace([
  '/<print theme>/',
  '/<print url>/',
  '/<print meta=favicon>/',
  '/<print config=[\"\']?business[\"\']?>/'
],[
  THEME,
  URL,
  $favicon,
  htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8')
],$html);
if(stristr($html,'<buildSocial')){
	preg_match('/<buildSocial>([\w\W]*?)<\/buildSocial>/',$html,$matches);
	$htmlSocial=$matches[1];
	$socialItems='';
	$s=$db->query("SELECT * FROM `".$prefix."choices` WHERE contentType='social' AND uid=0 ORDER BY icon ASC");
	if($s->rowCount()>0){
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$buildSocial=$htmlSocial;
			$buildSocial=str_replace([
				'<print sociallink>',
				'<print socialicon>'
			],[
				htmlspecialchars($r['url'],ENT_QUOTES,'UTF-8'),
				frontsvg('libre-social-'.$r['icon'])
			],$buildSocial);
			$socialItems.=$buildSocial;
		}
	}else
    $socialItems='';
	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$socialItems,$html,1);
}
$content.=$html;
