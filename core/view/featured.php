<?php
preg_match('/<settings itemcount="([\w\W]*?)" contenttype="([\w\W]*?)" order="([\w\W]*?)">/',$html,$matches);
$html=preg_replace('~<settings.*?>~is','',$html,1);
$itemCount=$matches[1];
$limit=', '.$matches[1];
if($itemCount==0){
	$itemCount=$config['showItems'];
	$limit='';
}
$contentType=$matches[2];
$cT=$matches[2];
if($contentType=='all'||$contentType=='mixed')$contentType='%';
if($matches[3]=='asc'||$matches[3]=='ASC'){
	$order='ti ASC';
	$arrayOrder='asc';
}elseif($matches[3]=='rand'||$matches[3]=='random'){
	$order='RAND()';
	$arrayOrder='random';
}else{
	$order='ti DESC';
	$arrayOrder='desc';
}
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$it=$matches[1];
$items='';
$fi=0;
$featuredfiles=array();
if($cT=='all'||$cT=='mixed'||$cT=='folder'){
	if(file_exists('media'.DS.'carousel'.DS)){
		foreach(glob('media'.DS.'carousel'.DS.'*.*') as $file){
			$fileinfo=pathinfo($file);
			if($file=='.')continue;
			if($file=='..')continue;
			if($fileinfo['extension']=='html')continue;
			$filetime=filemtime($file);
			$fileinfo=pathinfo($file);
			$filename=basename($file,'.'.$fileinfo['extension']);
			if(file_exists('media'.DS.'carousel'.DS.$filename.'.html'))$filehtml=file_get_contents('media'.DS.'carousel'.DS.$filename.'.html');else$filehtml='';
			$featuredfiles[]=['contentType'=>'carousel','thumb'=>'','file'=>$file,'title'=>basename(rtrim($file),3),'link'=>'nolink','seoCaption'=>$filehtml,'notes'=>'','ti'=>$filetime];
		}
	}
}
if($cT!='folder'){
	$s=$db->prepare("SELECT * FROM content WHERE file!='' OR thumb!='' AND featured='1' AND internal!='1' AND status='published' AND contentType LIKE :contentType ORDER BY $order $limit");
	$s->execute(array(':contentType'=>$contentType));
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		if($r['featured']!=1||$r['internal']==1)continue;
		$filechk=basename($r['file']);
		if(file_exists('media'.DS.$filechk)){
			$featuredfiles[]=['contentType'=>$r['contentType'],'thumb'=>$r['thumb'],'file'=>$r['file'],'title'=>$r['title'],'link'=>$r['contentType'].'/'.url_encode($r['title']),'seoCaption'=>$r['seoCaption'],'notes'=>$r['notes'],'ti'=>$r['ti']];
		}
	}
}
$indicators='';
$indicator='';
$featuredIndicators='';
if($arrayOrder=='random')shuffle($featuredfiles);elseif($arrayOrder=='asc')asort($featuredfiles);else arsort($featuredfiles);
$featuredfiles=array_slice($featuredfiles,0,$itemCount);
$ii=count($featuredfiles);
$i=0;
if($ii>0){
	if(stristr($html,'<indicators>')){
		preg_match('/<indicators>([\w\W]*?)<\/indicators>/',$html,$matches);
		$indicator=$matches[1];
	}
	foreach($featuredfiles as $key => $r){
		$item=$it;
		$indicatorItem=$indicator;
		if($i==0){
			$item=str_replace('<print active>',' active',$item);
			$indicatorItem=str_replace('<print active>','active',$indicatorItem);
		}else{
			$item=str_replace('<print active>','',$item);
			$indicatorItem=str_replace('<print active>','',$indicatorItem);
		}
		$indicatorItem=str_replace('<print indicatorCount>',$i,$indicatorItem);
		if($r['link']=='nolink')$item=preg_replace('~<link>.*?<\/link>~is','',$item,1);
		else{
			$item=str_replace('<link>','',$item);
			$item=str_replace('</link>','',$item);
			$item=str_replace('<print link>',$r['contentType'].'/'.urlencode(str_replace(' ','-',$r['title'])),$item);
		}
		$item=str_replace('<print content=title>',$r['title'],$item);
		if(stristr($item,'<print content=thumb>')){
			if($r['thumb']!='')$item=str_replace('<print content=thumb>',$r['thumb'],$item);elseif($r['file']!='')$item=str_replace('<print content=thumb>',$r['file'],$item);else$item=str_replace('<print content=thumb>','',$item);
		}
		if(stristr($item,'<print content=alt>')){
			if($r['file']!=''){
				$alt=pathinfo($r['file']);
				$alt=$alt['filename'];
				$alt=str_replace('-',' ',$alt);
				$alt=ucfirst($alt);
			}else$alt=$r['title'];
			$item=str_replace('<print content=alt>',$alt,$item);
		}
		if(stristr($item,'<print content=image>')){
			if($r['file']!='')$item=str_replace('<print content=image>',$r['file'],$item);else$item=str_replace('<print content=image>','',$item);
		}
		if($r['link']=='nolink')$item=str_replace('<print content="title">','<span class="hidden">'.$r['title'].'</span>',$item);else$item=str_replace('<print content="title">',$r['title'],$item);
		if($r['contentType']=='carousel')$item=preg_replace('~<caption>.*?<\/caption>~is',$r['seoCaption'],$item,1);
		else{
			$r['notes']=strip_tags($r['notes']);
			$pos=strpos($r['notes'],' ',300);
			$r['notes']=substr(rawurldecode($r['notes']),0,$pos).'...';
			if($r['seoCaption']!='')$item=str_replace('<print content="caption">',$r['seoCaption'],$item);elseif($r['notes']!='')$item=str_replace('<print content="caption">',strip_tags(rawurldecode($r['notes'])),$item);else$item=str_replace('<print content="caption">','',$item);
			if($r['notes']!='')$item=str_replace('<print content="notes">',strip_tags(rawurldecode($r['notes'])),$item);else$item=str_replace('<print content="notes">','',$item);
			$item=str_replace('<caption>','',$item);
			$item=str_replace('</caption>','',$item);
		}
		$items.=$item;
		$i++;
		$indicators.=$indicatorItem;
	}
}
if($ii>1){
	$html=preg_replace('~<indicators>.*?<\/indicators>~is',$indicators,$html,1);
	$html=str_replace('<featuredIndicators>','',$html);
	$html=str_replace('</featuredIndicators>','',$html);
	$html=str_replace('<featuredControls>','',$html);
	$html=str_replace('</featuredControls>','',$html);
}else{
	$html=preg_replace('~<featuredControls>.*?<\/featuredControls>~is','',$html,1);
	$html=str_replace('<featuredIndicators>','',$html);
}
if($i>0)$html=preg_replace('~<items>.*?<\/items>~is',$items,$html,1);else$html='';
$content.=$html;
