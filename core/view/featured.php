<?php
preg_match('/<settings itemCount=([\w\W]*?) contentType=([\w\W]*?)>/',$html,$matches);
$html=preg_replace('~<settings.*?>~is','',$html,1);
$itemCount=$matches[1];
if($itemCount==0)$itemCount=5;
$contentType=$matches[2];
if($contentType=='all')$contentType='%';
preg_match('/<loop>([\w\W]*?)<\/loop>/',$html,$matches);
$it=$matches[1];
$items='';
$s=$db->prepare("SELECT * FROM content WHERE featured='1' AND internal!='1' AND status='published' AND contentType LIKE :contentType ORDER BY ti DESC");
$s->execute(array(':contentType'=>$contentType));
$indicators='';
$ii=$s->rowCount();
$i=0;
if($ii>0){
    if($ii>1)$indicators='<ol class="carousel-indicators">';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
        if(file_exists('media/'.$r['file'])){
            $item=$it;
            if($ii>1){
                $indicators.='<li data-target="#featured" data-slide-to="'.$i.'"';
                if($i==0)$indicators.=' class="active"';
                $indicators.='></li>';
            }
            if($i==0)
                $item=str_replace('<print active>',' active',$item);
            else
                $item=str_replace('<print active>','',$item);
            if($r['options']{0}==1){
                $cost='<aside class="price text-right" itemprop="offerDetails" itemscope itemtype="http://schema.org/Offer"><meta itemprop="currency" content="AUD" /><span itemprop="price">&#36;'.$r['cost'].'</span></aside>';
                $item=str_replace('<print content=cost>',$cost,$item);
            }else
                $item=str_replace('<print content=cost>','',$item);
            if($r['caption']!='')
                $item=str_replace('<print content=caption>',$r['caption'],$item);
            else
                $item=str_replace('<print content=caption>',preg_replace('/\s+?(\S+)?$/','',substr(strip_tags($r['notes']),0,1149)),$item);
			$item=str_replace('<print content=featuredBackgroundColor>',ltrim($r['featuredBackgroundColor'],'#'),$item);
            $item=str_replace('<print link>',$r['contentType'].'/'.str_replace(' ','-',$r['title']),$item);
            $item=str_replace('<print content=file>','<img src="media/'.$r['file'].'" alt="'.$r['title'].'">',$item);
            $item=str_replace('<print content=schemaType>',$r['schemaType'],$item);
            $item=str_replace('<print content=title>',$r['title'],$item);
            $item=str_replace('<print content=contentType>','<div>'.$r['contentType'].'</div>',$item);
            $items.=$item;
            $i++;
        }
	}
	if($ii>1)$indicators.='</ol>';
}
if($i>1){
    $html=str_replace('<carouselControls>','',$html);
    $html=str_replace('</carouselControls>','',$html);
}else{
    $html=preg_replace('~<carouselControls>.*?<\/carouselControls>~is','',$html,1);
    $indicators='';
}
if($i>0){
	$html=str_replace('<carouselIndicators>',$indicators,$html);
	$html=preg_replace('~<loop>.*?<\/loop>~is',$items,$html,1);
}else{
	$html=str_replace('<carouselIndicators>','',$html);
    $html='';
}
$content.=$html;
