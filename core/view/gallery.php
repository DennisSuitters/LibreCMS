<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$gals='';
if(stristr($html,'<items')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $gal=$matches[1];
  $s=$db->prepare("SELECT * FROM media WHERE pid=:pid ORDER BY ord ASC");
  $s->execute(array(':pid'=>10));
  $output='';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $items=$gal;
    $items=preg_replace(
      array(
        '/<print media=[\"\']?file[\"\']?>/',
        '/<print media=[\"\']?title[\"\']?>/',
        '/<print media=[\"\']?caption[\"\']?>/',
        '/<print media=[\"\']?attributionName[\"\']?>/',
        '/<print media=[\"\']?attributionURL[\"\']?>/'
      ),
      array(
        $r['file'],
        htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['attributionImageName'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['attributionImageURL'],ENT_QUOTES,'UTF-8')
      ),
      $items
    );
    if($r['attributionImageName']!=''&&$r['attributionImageURL']!=''){
      $items=str_replace(
        array(
          '<attribution>',
          '</attribution>'
        ),
        '',
        $items
      );
    }else$items=preg_replace('~<attribution>.*?<\/attribution>~is','',$items);
    $output.=$items;
  }
	$gals=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
}else$gals='';
$content.=$gals;
