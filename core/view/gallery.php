<?php
// http://idangero.us/swiper/#.WM3RIHWGPVM
if(stristr($html,'<items')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $gal=$matches[1];
  $s=$db->prepare("SELECT * FROM media WHERE pid=:pid ORDER BY ord ASC");
  $s->execute(array(':pid'=>$page['id']));
  $output='';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $items=$gal;
    if($r['title']!='')
      $r['title']='<div class="title">'.$r['title'].'</div>';
    $items=str_replace(array(
      '<print media=file>','<print media="file">',
      '<print media=title>','<print media="title">',
      '<print media=caption>','<print media="caption">'
    ),array(
      $r['file'],$r['file'],
      htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'),htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8')
    ),$items);
    $output.=$items;
  }
	$gals=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
}else
  $gals='';
$content.=$gals;
