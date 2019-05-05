<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Featured Renderer
 *
 * featured.php version 2.0.1
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Featured
 * @package    core/view/featured.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.1
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Add Sluggification
 * @changes    v2.0.3 Fix File HTML Carousel Output
 */
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
if($contentType=='all'||$contentType=='mixed')
	$contentType='%';
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
		foreach(glob('media'.DS.'carousel'.DS.'*.*')as$file){
			$fileinfo=pathinfo($file);
			if($file=='.')continue;
			if($file=='..')continue;
			if($fileinfo['extension']=='html')continue;
			$filetime=filemtime($file);
			$fileinfo=pathinfo($file);
			$filename=basename($file,'.'.$fileinfo['extension']);
			if(file_exists('media'.DS.'carousel'.DS.$filename.'.html'))
				$filehtml=file_get_contents('media'.DS.'carousel'.DS.$filename.'.html');
			else
				$filehtml='';
			$featuredfiles[]=[
				'contentType'=>'carousel',
				'thumb'=>'',
				'file'=>$file,
				'title'=>basename(rtrim($file),3),
				'link'=>'nolink',
				'seoCaption'=>$filehtml,
				'notes'=>'',
				'ti'=>$filetime
			];
		}
	}
}
if($cT!='folder'){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE file!='' OR thumb!='' AND featured='1' AND internal!='1' AND status='published' AND contentType LIKE :contentType ORDER BY $order $limit");
	$s->execute([':contentType'=>$contentType]);
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		if($r['featured']!=1||$r['internal']==1)continue;
		$filechk=basename($r['file']);
		if(file_exists('media'.DS.$filechk)){
			$featuredfiles[]=[
				'contentType'=>$r['contentType'],
				'thumb'=>$r['thumb'],
				'file'=>$r['file'],
				'title'=>$r['title'],
				'link'=>$r['contentType'].'/'.$r['urlSLug'],
				'seoCaption'=>$r['seoCaption'],
				'attributionImageTitle'=>$r['attributionImageTitle'],
				'attributionImageName'=>$r['attributionImageName'],
				'attributionImageURL'=>$r['attributionImageURL'],
				'notes'=>$r['notes'],
				'ti'=>$r['ti'
				]
			];
		}
	}
}
$indicators=$indicator=$featuredIndicators='';
if($arrayOrder=='random')
	shuffle($featuredfiles);
elseif($arrayOrder=='asc')
	asort($featuredfiles);
else
	arsort($featuredfiles);
$featuredfiles=array_slice($featuredfiles,0,$itemCount);
$ii=count($featuredfiles);
$i=0;
if($ii>0){
	if(stristr($html,'<indicators>')){
		preg_match('/<indicators>([\w\W]*?)<\/indicators>/',$html,$matches);
		$indicator=$matches[1];
	}
	foreach($featuredfiles as$key=>$r){
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
		if($r['link']=='nolink')
			$item=preg_replace('~<link>.*?<\/link>~is','',$item,1);
		else{
			$item=str_replace([
				'<link>',
				'</link>',
				'<print link>',
			],[
				'',
				'',
				$r['contentType'].'/'.$r['urlSlug'],
			],$item);
		}
		$item=preg_replace('/<print content=[\"\']?title[\"\']?>/',$r['title'],$item);
		if(preg_match('/<print content=[\"\']?thumb[\"\']?>/',$item)){
			if($r['thumb']!='')
				$item=preg_replace('/<print content=[\"\']?thumb[\"\']?>/',$r['thumb'],$item);
			elseif($r['file']!='')
				$item=preg_replace('/<print content=[\"\']?thumb[\"\']?>/',$r['file'],$item);
			else
				$item=preg_replace('/<print content=[\"\']?thumb[\"\']?>/','',$item);
		}
		if(preg_match('/<print content=[\"\']?alt[\"\']?>/',$item)){
			if($r['file']!=''){
				$alt=pathinfo($r['file']);
				$alt=$alt['filename'];
				$alt=str_replace('-',' ',$alt);
				$alt=ucfirst($alt);
			}else
				$alt=$r['title'];
			$item=preg_replace('/<print content=[\"\']?alt[\"\']?>/',htmlspecialchars($alt,ENT_QUOTES,'UTF-8'),$item);
		}
		if(preg_match('/<print content=[\"\']?image[\"\']?>/',$item))
			$item=$r['file']!=''?preg_replace('/<print content=[\"\']?image[\"\']?>/',htmlspecialchars($r['file'],ENT_QUOTES,'UTF-8'),$item):preg_replace('/<print content=[\"\']?image[\"\']?>/','',$item);
		$item=$r['link']=='nolink'?preg_replace('/<print content=[\"\']?title[\"\']?>/','<span class="hidden">'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'</span>',$item):preg_replace('/<print content=[\"\']?title[\"\']?>/',htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),$item);
		if($r['contentType']=='carousel')
			$item=preg_replace('~<caption>.*?<\/caption>~is',$r['seoCaption'],$item,1);
		else{
			$r['notes']=strip_tags($r['notes']);
			$pos=strpos($r['notes'],' ',300);
			$r['notes']=substr(rawurldecode($r['notes']),0,$pos).'...';
			if($r['seoCaption']!='')
				$item=preg_replace('/<print content=[\"\']?caption[\"\']?>/',htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'),$item);
			elseif($r['notes']!='')
				$item=preg_replace('/<print content=[\"\']?caption[\"\']?>/',htmlspecialchars(rawurldecode($r['notes']),ENT_QUOTES,'UTF-8'),$item);
			else
				$item=preg_replace('/<print content=[\"\']?caption[\"\']?>/','',$item);
			if($r['attributionImageName']!=''&&$r['attributionImageURL']!=''){
				$item=preg_replace([
					'/<print media=[\"\']?attributionName[\"\']?>/',
	        '/<print media=[\"\']?attributionURL[\"\']?>/',
					'/<attribution>/',
          '/<\/attribution>/'
				],[
					htmlspecialchars($r['attributionImageName'],ENT_QUOTES,'UTF-8'),
	        htmlspecialchars($r['attributionImageURL'],ENT_QUOTES,'UTF-8'),
					'',
					''
				],$item);
			}else
				$item=preg_replace('~<attribution>.*?<\/attribution>~is','',$items);
			$item=$r['notes']!=''?preg_replace('/<print content=[\"\']?notes[\"\']?>/',htmlspecialchars(strip_tags(rawurldecode($r['notes'])),$item,ENT_QUOTES,'UTF-8')):preg_replace('/<print content=[\"\']?notes[\"\']?>/','',$item);
			$item=str_replace([
				'<caption>',
				'</caption>'
			],'',$item);
		}
		$items.=$item;
		$i++;
		$indicators.=$indicatorItem;
	}
}
if($ii>1){
	$html=preg_replace([
		'~<indicators>.*?<\/indicators>~is',
		'/<featuredIndicators>/',
		'/<\/featuredIndicators>/',
		'/<featuredControls>/',
		'/<\/featuredControls>/'
	],[
		$indicators,
		'',
		'',
		'',
		''
	],$html);
}else{
	$html=preg_replace([
		'~<featuredControls>.*?<\/featuredControls>~is',
		'/<featuredIndicators>/',
		'/<\/featuredIndicators>/'
	],'',$html);
}
$html=$i>0?preg_replace('~<items>.*?<\/items>~is',$items,$html,1):'';
$content.=$html;
