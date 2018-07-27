<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$rank=0;
$notification='';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$html=str_replace('<print view>',$view,$html);
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE contentType=:contentType AND LOWER(title)=LOWER(:title)");
$s->execute(
  array(
    ':contentType'=>$view,
    ':title'=>str_replace('-',' ',$args[0])
  )
);
$r=$s->fetch(PDO::FETCH_ASSOC);
$html=preg_replace(
  array(
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
  ),
  array(
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
  ),
  $html
);
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
