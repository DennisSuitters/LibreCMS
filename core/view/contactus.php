<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Contact Us Renderer
 *
 * contactus.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Contact Us
 * @package    core/view/contactus.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(stristr($html,'<address')){
	$html=preg_replace([
		'/<print config=[\"\']?address[\"\']?>/',
		'/<print config=[\"\']?state[\"\']?>/',
		'/<print config=[\"\']?suburb[\"\']?>/',
		'/<print config=[\"\']?country[\"\']?>/',
		'/<print config=[\"\']?postcode[\"\']?>/',
		'/<print config=[\"\']?phone[\"\']?>/',
		'/<print config=[\"\']?mobile[\"\']?>/'
	],[
		htmlspecialchars($config['address'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['state'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['suburb'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['country'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['postcode'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['phone'],ENT_QUOTES,'UTF-8'),
		htmlspecialchars($config['mobile'],ENT_QUOTES,'UTF-8')
	],$html);
}
$s=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='subject' ORDER BY title ASC");
$s->execute();
if($s->rowCount()>0){
	$html=preg_replace([
		'~<subjectText>.*?<\/subjectText>~is',
		'/<subjectSelect>/',
		'/<\/subjectSelect>/'
	],'',$html);
	$options='';
	while($r=$s->fetch(PDO::FETCH_ASSOC))
		$options.='<option value="'.$r['id'].'" role="option">'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'</option>';
	$html=str_replace('<subjectOptions>',$options,$html);
}else{
	$html=preg_replace([
		'~<subjectSelect>.*?<\/subjectSelect>~is',
		'/<subjectText>/',
		'/<\/subjectText>/'
	],'',$html);
}
require'core'.DS.'parser.php';
$content.=$html;
