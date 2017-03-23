<?php
$rank=0;
$notification='';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$html=str_replace('<print view>',$view,$html);
$s=$db->prepare("SELECT * FROM menu WHERE contentType=:contentType AND LOWER(title)=LOWER(:title)");
$s->execute(array(':contentType'=>$view,':title'=>str_replace('-',' ',$args[0])));
$r=$s->fetch(PDO::FETCH_ASSOC);
$html=str_replace(array('<print content="notes">'),rawurldecode($r['notes']),$html);
$seoTitle=empty($r['seoTitle'])?trim(htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8')):htmlspecialchars($r['seoTitle'],ENT_QUOTES,'UTF-8');
$metaRobots=!empty($r['metaRobots'])?htmlspecialchars($r['metaRobots'],ENT_QUOTES,'UTF-8'):'index,follow';
$seoCaption=!empty($r['seoCaption'])?htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8');
$seoCaption=empty($seoCaption)?htmlspecialchars($config['seoCaption'],ENT_QUOTES,'UTF-8'):$seoCaption;
$seoDescription=!empty($r['seoDescription'])?htmlspecialchars($r['seoDescription'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8');
$seoDescription=empty($seoDescrption)?htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'):$seoDescription;
$seoKeywords=!empty($r['seoKeywods'])?htmlspecialchars($r['seoKeywords'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8');
$seoKeywords=empty($seoKeywords)?htmlspecialchars($config['seoKeywords'],ENT_QUOTES,'UTF-8'):$seoKeywords;

$content.=$html;
