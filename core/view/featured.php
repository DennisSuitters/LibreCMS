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
if($contentType=='all')$contentType='%';
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
if(file_exists('media/carousel/')){
	foreach(glob('media/carousel/*.*') as $file){
		if($file=='.')continue;
		if($file=='..')continue;
		$filetime=filemtime($file);
		$featuredfiles[]=[
			'contentType'=>'carousel',
			'file'=>$file,
			'title'=>'',
			'link'=>'',
			'ti'=>$filetime
		];
	}
}
$s=$db->prepare("SELECT * FROM content WHERE file!='' AND featured='1' AND internal!='1' AND status='published' AND contentType LIKE :contentType ORDER BY $order $limit");
$s->execute(array(':contentType'=>$contentType));
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	$filechk=basename($r['file']);
	if(file_exists('media'.DS.$filechk)){
		$featuredfiles[]=[
			'contentType'=>$r['contentType'],
			'file'=>$r['file'],
			'title'=>$r['title'],
			'link'=>$r['contentType'].DS.str_replace(' ','-',$r['title']),
			'ti'=>$r['ti']
		];
	}
}
$indicators='';
$indicator='';
$featuredIndicators='';
if($arrayOrder=='random')shuffle($featuredfiles);
elseif($arrayOrder=='asc')asort($featuredfiles);
else arsort($featuredfiles);
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
		$item=str_replace('<print link>',$r['contentType'].DS.str_replace(' ','-',$r['title']),$item);
		$item=str_replace('<print content="image">','<img src="'.$r['file'].'" class="img-responsive" alt="'.$r['title'].'">',$item);
		$item=str_replace('<print content=title>',$r['title'],$item);
		$item=str_replace('<print content="title">',$r['title'],$item);
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
