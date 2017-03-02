<?php
if(stristr($html,'<items')){
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $gal=$matches[1];
  $s=$db->prepare("SELECT * FROM media WHERE pid=:pid ORDER BY ord ASC");
  $s->execute(array(':pid'=>$page['id']));
  $output='';
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $items=$gal;
    $items=str_replace('<print media=file>',$r['file'],$items);
    if($r['title']!='')$r['title']='<div class="title">'.$r['title'].'</div>';
    $items=str_replace('<print media="title">',$r['title'],$items);
    $items=str_replace('<print media="caption">',$r['seoCaption'],$items);
    $output.=$items;
  }
	$gals=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
}else$gals='';
$content.=$gals;
