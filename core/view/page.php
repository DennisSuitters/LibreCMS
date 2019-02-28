<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Page Renderer
 *
 * page.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Page
 * @package    core/view/page.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$notification='';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$html=str_replace('<print view>',$view,$html);
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE contentType=:contentType AND LOWER(title)=LOWER(:title)");
$s->execute([
  ':contentType'=>$view,
  ':title'=>str_replace('-',' ',$args[0])
]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$html=preg_replace([
  '/<print content=[\"\']?title[\"\']?>/',
  '/<print content=[\"\']?notes[\"\']?>/',
  '/<print content=[\"\']?schemaType[\"\']?>/',
  '/<cost>([\w\W]*?)<\/cost>/',
  '/<review>([\w\W]*?)<\/review>/',
  '/<author>([\w\W]*?)<\/author>/',
  '/<settings([\w\W]*?)>/',
  '/<print page=[\"\']?notes[\"\']?>/',
  '/<items>([\w\W]*?)<\/items>/',
  '/<more>([\w\W]*?)<\/more>/',
  '/<item>/',
  '/<\/item>/'
],[
  $r['title'],
  rawurldecode($r['notes']),
  $r['contentType'],
  '',
  '',
  '',
  '',
  '',
  '',
  '',
  ''
],$html);
$items=$html;
include'core'.DS.'parser.php';
$html=$items;
$seoTitle=empty($r['seoTitle'])?trim(htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8')):htmlspecialchars($r['seoTitle'],ENT_QUOTES,'UTF-8');
$metaRobots=!empty($r['metaRobots'])?htmlspecialchars($r['metaRobots'],ENT_QUOTES,'UTF-8'):'index,follow';
$seoCaption=!empty($r['seoCaption'])?htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8');
$seoCaption=empty($seoCaption)?htmlspecialchars($config['seoCaption'],ENT_QUOTES,'UTF-8'):$seoCaption;
$seoDescription=!empty($r['seoDescription'])?htmlspecialchars($r['seoDescription'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8');
$seoDescription=empty($seoDescrption)?htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'):$seoDescription;
$seoKeywords=!empty($r['seoKeywods'])?htmlspecialchars($r['seoKeywords'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8');
$seoKeywords=empty($seoKeywords)?htmlspecialchars($config['seoKeywords'],ENT_QUOTES,'UTF-8'):$seoKeywords;
$content.=$html;
