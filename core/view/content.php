<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Content Renderer
 *
 * content.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Content
 * @package    core/view/content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$notification='';
$show='categories';
$status='published';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$itemCount=$config['showItems'];
if($view=='newsletters'){
	if($args[0]=='unsubscribe'&&isset($args[1])){
		$s=$db->prepare("DELETE FROM `".$prefix."subscribers` WHERE hash=:hash");
		$s->execute([':hash'=>$args[1]]);
		$notification=$theme['settings']['notification_unsubscribe'];
	}
}
if($view=='page')
	$show='';
elseif($view=='search'){
	if(isset($args[0])&&$args[0]!='')
		$search='%'.html_entity_decode(str_replace('-','%',$args[0])).'%';
	elseif(isset($_POST['search'])&&$_POST['search']!='')
		$search='%'.html_entity_decode(str_replace('-','%',filter_input(INPUT_POST,'search',FILTER_SANITIZE_STRING))).'%';
	else
		$search='%';
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(code) LIKE LOWER(:search) OR LOWER(brand) LIKE LOWER(:search) OR LOWER(title) LIKE LOWER(:search) OR LOWER(category_1) LIKE LOWER(:search) OR LOWER(category_2) LIKE LOWER(:search) OR LOWER(seoKeywords) LIKE LOWER(:search) OR LOWER(tags) LIKE LOWER(:search) OR LOWER(seoCaption) LIKE LOWER(:search) OR LOWER(seoDescription) LIKE LOWER(:search) OR LOWER(notes) LIKE LOWER(:search) AND status=:status ORDER BY ti DESC");
	$s->execute([
		':search'=>$search,
		':status'=>$status
	]);
}elseif($view=='index'){
	$contentType='';
	$itemCount=4;
	if(stristr($html,'<settings')){
		preg_match('/<settings.*items=[\"\'](.+?)[\"\'].*>/',$html,$matches);
		$itemCount=isset($matches[1])?$matches[1]:10;
		preg_match('/<settings.*contenttype=[\"\'](.*?)[\"\'].*>/',$html,$matches);
		$contentType=isset($matches[1])?$matches[1]:'';
	}
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND contentType NOT LIKE 'message%' AND contentType NOT LIKE 'testimonial%' AND contentType NOT LIKE 'proof%' AND status LIKE :status AND internal!='1' AND pti < :ti	ORDER BY featured DESC, ti DESC LIMIT $itemCount");
	$s->execute([
		':contentType'=>$contentType.'%',
		':status'=>$status,
		':ti'=>time()
	]);
}elseif($view=='bookings')
	$id=(isset($args[0])?(int)$args[0]:0);
elseif(isset($args[1])&&strlen($args[1])==2){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND ti < :ti ORDER BY ti ASC");
	$s->execute([
		':contentType'=>$view,
		':ti'=>DateTime::createFromFormat('!d/m/Y','01/'.$args[1].'/'.$args[0])->getTimestamp()
	]);
	$show='categories';
}elseif(isset($args[0])&&strlen($args[0])==4){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND ti>:ti ORDER BY ti ASC");
	$tim=strtotime('01-Jan-'.$args[0]);
	$s->execute([
		':contentType'=>$view,
		':ti'=>DateTime::createFromFormat('!d/m/Y','01/01/'.$args[0])->getTimestamp()
	]);
	$show='categories';
}elseif(isset($args[1])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),
		':status'=>$status,
		':ti'=>time()
	]);
}elseif(isset($args[0])){
	$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND LOWER(category_1) LIKE LOWER(:category_1) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
	$s->execute([
		':contentType'=>$view,
		':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),
		':status'=>$status,
		':ti'=>time()
	]);
	if($s->rowCount()<1){
		if($view=='proofs'){
			$status='%';
			if($_SESSION['loggedin']==false)
				die();
		}
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND LOWER(title) LIKE LOWER(:title) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
		$s->execute([
			':contentType'=>$view,
			':title'=>html_entity_decode(str_replace('-',' ',$args[0])),
			':status'=>$status,
			':ti'=>time()
		]);
		$show='item';
	}
}else{
	if($view=='proofs'){
		if(isset($_SESSION['uid'])&&$_SESSION['uid']!=0){
			$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE 'proofs' AND uid=:uid ORDER BY ord ASC, ti DESC");
			$s->execute([':uid'=>$_SESSION['uid']]);
		}
	}else{
		$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC LIMIT $itemCount");
		$s->execute([
			':contentType'=>$view,
			':status'=>$status,
			':ti'=>time()
		]);
	}
}
if($show=='categories'){
	$contentType=$view;
	$html=preg_replace('~<item>.*?<\/item>~is','',$html,1);
	if(stristr($html,'<settings')){
		$matches=preg_match_all('/<settings items="(.*?)" contenttype="(.*?)">/',$html,$matches);
		$count=$matches[1];
		$html=preg_replace('~<settings.*?>~is','',$html,1);
	}else
		$count=1;
	$html=str_replace('<print view>',$view,$html);
	if(stristr($html,'<print page="coverVideo">')){
		if($page['coverVideo']!=''){
			$cover=basename($page['coverVideo']);
			$html=preg_replace(
				'/<print page=[\"\']?coverVideo[\"\']?>/',
				'<video preload autoplay loop muted><source src="'.htmlspecialchars($page['coverVideo'],ENT_QUOTES,'UTF-8').'" type="video/mp4"></video>',
				$html
			);
		}else
			$html=preg_replace('/<print page=[\"\']?coverVideo[\"\']?>/','',$html);
	}
	if(stristr($html,'<print page=cover>')){
		if($page['cover']!=''||$page['coverURL']!=''){
			$cover=basename($page['cover']);
			$coverLink='';
			if(isset($page['cover'])&&$page['cover']!='')
				$coverLink.='media'.DS.$cover;
			elseif($page['coverURL']!='')
				$coverLink.=$page['coverURL'];
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','background-image:url('.htmlspecialchars($coverLink,ENT_QUOTES,'UTF-8').');',$html);
		}else
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','',$html);
	}
	if(preg_match('/<print page=[\"\']?cover[\"\']?>/',$html)){
		if($page['cover']!=''||$page['coverURL']!=''){
			$cover=basename($page['cover']);
			list($width,$height)=getimagesize($page['cover']);
			$coverHTML='<img src="';
			if(file_exists('media'.DS.$cover))
				$coverHTML.=htmlspecialchars($page['cover'],ENT_QUOTES,'UTF-8');
			elseif($page['coverURL']!='')
				$coverHTML.=htmlspecialchars($page['coverURL'],ENT_QUOTES,'UTF-8');
			$coverHTML.='" alt="';
			if($page['attributionImageTitle']==''&&$page['attributionImageName']==''&&$page['attributionImageURL']==''){
				if($page['attributionImageTitle'])$coverHTML.=$page['attributionImageTitle'].$page['attributionImageName']!=''?' - ':'';
				if($page['attributionImageName'])$coverHTML.=$page['attributionImageName'].$page['attributionImageURL']!=''?' - ':'';
				if($page['attributionImageURL'])$coverHTML.=htmlspecialchars($page['attributionImageURL'],ENT_QUOTES,'UTF-8');
			}else
				$coverHTML.=$page['seoTitle']!=''?$page['seoTitle']:$config['seoTitle'];
			if($page['seoTitle']==''&&$config['seoTitle']=='')
				$coverHTML.=htmlspecialchars(basename($page['cover']),ENT_QUOTES,'UTF-8');
			$coverHTML.='">';
		}else
			$coverHTML='';
		$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/',$coverHTML,$html);
	}
	$html=preg_replace([
		'/<print page=[\"\']?notes[\"\']?>/',
		'/<print page=[\"\']?contentType[\"\']?>/',
		'/<notification>/'
	],[
		rawurldecode($page['notes']),
		htmlspecialchars(ucfirst($page['contentType']),ENT_QUOTES,'UTF-8').($page['contentType']=='article'||$page['contentType']=='service'?'s':''),
		$notification
	],$html);
	$html=$config['business']?preg_replace('/<print content=[\"\']?seoTitle[\"\']?>/',htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),$html):preg_replace('/<print content=[\"\']?seoTitle[\"\']?>/',htmlspecialchars($config['seoTitle'],ENT_QUOTES,'UTF-8'),$html);
	if(stristr($html,'<mediaitems')){
		$sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE pid=:pid AND rid=0 ORDER BY ord ASC");
		$sm->execute([':pid'=>$page['id']]);
		if($sm->rowCount()>0){
			preg_match('/<mediaitems>([\w\W]*?)<\/mediaitems>/',$html,$matches2);
			$media=$matches2[1];
			preg_match('/<mediaimages>([\w\W]*?)<\/mediaimages>/',$media,$matches3);
			$mediaitem=$matches3[1];
			$mediaoutput='';
			while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
				$mediaitems=$mediaitem;
				list($width,$height)=getimagesize($rm['file']);
				$tags='';
				if($rm['tags']!=''){
					$mediatags=explode(',',$rm['tags']);
					foreach($mediatags as$mt)$tags.='#'.htmlspecialchars($mt,ENT_QUOTES,'UTF-8').' ';
				}
				$mediaitems=preg_replace([
					'/<print media=[\"\']?image[\"\']?>/',
					'/<print media=[\"\']?width[\"\']?>/',
					'/<print media=[\"\']?height[\"\']?>/',
					'/<print media=[\"\']?title[\"\']?>/',
					'/<print media=[\"\']?category_1[\"\']?>/',
					'/<print media=[\"\']?category_2[\"\']?>/',
					'/<print media=[\"\']?attributionName[\"\']?>/',
					'/<print media=[\"\']?attributionURL[\"\']?>/',
					'/<print media=[\"\']?exifISO[\"\']?>/',
					'/<print media=[\"\']?exifAperture[\"\']?>/',
					'/<print media=[\"\']?exifFocalLength[\"\']?>/',
					'/<print media=[\"\']?exifShutterSpeed[\"\']?>/',
					'/<print media=[\"\']?exifCamera[\"\']?>/',
					'/<print media=[\"\']?exifLens[\"\']?>/',
					'/<print media=[\"\']?exifFilename[\"\']?>/',
					'/<print media=[\"\']?exifTime[\"\']?>/',
					'/<print media=[\"\']?tags[\"\']?>/',
					'/<print media=[\"\']?seoTitle[\"\']?>/',
					'/<print media=[\"\']?caption[\"\']?>/',
					'/<print media=[\"\']?description[\"\']?>/'
				],[
					htmlspecialchars($rm['file'],ENT_QUOTES,'UTF-8'),
					$width,
					$height,
					htmlspecialchars($rm['title'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['category_1'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['category_2'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['attributionImageName'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['attributionImageURL'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifISO'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifAperture'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifFocalLength'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifShutterSpeed'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifCamera'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifLens'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['exifFilename'],ENT_QUOTES,'UTF-8'),
					date($config['dateFormat'],$rm['exifti']),
					$tags,
					htmlspecialchars($rm['seoTitle'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['seoCaption'],ENT_QUOTES,'UTF-8'),
					htmlspecialchars($rm['seoDescription'],ENT_QUOTES,'UTF-8')
				],$mediaitems);
				$mediaoutput.=$mediaitems;
			}
			$html=preg_replace('~<mediaimages>.*?<\/mediaimages>~is',$mediaoutput,$html,1);
		}else
			$html=preg_replace('~<mediaitems>.*?<\/mediaitems>~is','',$html,1);
	}
	if(stristr($html,'<items')){
		preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
		$item=$matches[1];
		$output='';
		$si=1;
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$filechk=$noimage;
			$thumbchk=$noimage;
			if($view=='search'){
				if($r['contentType']=='testimonials'||$r['contentType']=='proofs')continue;
			}
			$sr=$db->prepare("SELECT active FROM `".$prefix."menu` WHERE contentType=:contentType");
			$sr->execute([':contentType'=>$r['contentType']]);
			$pr=$sr->fetch(PDO::FETCH_ASSOC);
			if($pr['active']!=1)continue;
			if($r['status']!=$status)continue;
			$items=$item;
			$contentType=$r['contentType'];
			if($r['fileURL']!=''&&($r['thumb']==''||$r['file']=='')){
				$filechk=$r['fileURL'];
				$shareImage=$r['fileURL'];
			}else{
				$filechk=basename($r['file']);
				$thumbchk=basename($r['thumb']);
				if($r['thumb']!=''&&file_exists('media'.DS.$thumbchk))
					$shareImage='media'.DS.basename($r['thumb']);
				elseif($r['file']!=''&&file_exists('media'.DS.$filechk))
					$shareImage='media'.DS.basename($r['file']);
				else
					$shareImage=URL.NOIMAGE;
			}
			if($si==1)$si++;
			$items=preg_replace([
				'/<print content=[\"\']?thumb[\"\']?>/',
				'/<print content=[\"\']?image[\"\']?>/',
				'/<print content=[\"\']?file[\"\']?>/',
				'/<print content=[\"\']?title[\"\']?>/',
				'/<print profileLink>/',
				'/<print content=[\"\']?linktitle[\"\']?>/',
				'/<print content=[\"\']?author[\"\']?>/',
				'/<print content=[\"\']?dateCreated[\"\']?>/',
				'/<print content=[\"\']?datePublished[\"\']?>/',
				'/<print content=[\"\']?dateEdited[\"\']?>/',
				'/<print content=[\"\']?contentType[\"\']?>/',
				'/<print content=[\"\']?alttitle[\"\']?>/',
				'/<print content=[\"\']?notes[\"\']?>/'
			],[
				$shareImage,
				$shareImage,
				$shareImage,
				htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
				URL.'profile/'.strtolower(str_replace(' ','-',htmlspecialchars($r['login_user'],ENT_QUOTES,'UTF-8'))),
				URL.$r['contentType'].'/'.strtolower(str_replace(' ','-',htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'))),
				htmlspecialchars($r['login_user'],ENT_QUOTES,'UTF-8'),
				date($config['dateFormat'],$r['ti']),
				date($theme['settings']['dateFormat'],$r['pti']),
				date($theme['settings']['dateFormat'],$r['eti']),
				$r['contentType'],
				htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
				($view=='index'?substr(htmlspecialchars(strip_tags($r['notes']),ENT_QUOTES,'UTF-8'),0,300).'...':htmlspecialchars(strip_tags($r['notes']),ENT_QUOTES,'UTF-8'))
			],$items);
			$r['notes']=strip_tags($r['notes']);
			if($r['contentType']=='testimonials'||$r['contentType']=='testimonial'){
				if(stristr($items,'<controls>'))
					$items=preg_replace('~<controls>.*?<\/controls>~is','',$items,1);
				$controls='';
			}else{
				if(stristr($items,'<view>')){
					$items=preg_replace([
						'/<print content=[\"\']?linktitle[\"\']?>/',
						'/<print content=[\"\']?title[\"\']?>/',
						'/<view>/',
						'/<\/view>/'
					],[
						URL.$r['contentType'].'/'.url_encode($r['title']),
						htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8'),
						'',
						''
					],$items);
				}
				if($r['contentType']=='service'||$r['contentType']=='events'){
					if($r['bookable']==1){
						if(stristr($items,'<service')){
							$items=preg_replace([
								'/<print content=[\"\']?bookservice[\"\']?>/',
								'/<service>/',
								'/<\/service>/',
								'~<inventory>.*?<\/inventory>~is'
							],[
								$r['id'],
								'',
								'',
								''
							],$items);
						}
					}else
						$items=preg_replace('~<service.*?>.*?<\/service>~is','',$items,1);
				}else
					$items=preg_replace('~<service>.*?<\/service>~is','',$items,1);
				if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
					if(stristr($items,'<inventory')){
						$items=preg_replace([
							'/<inventory>/',
							'/<\/inventory>/',
							'~<service>.*?<\/service>~is'
						],'',$items);
					}elseif(stristr($items,'<inventory')&&$r['contentType']!='inventory'&&!is_numeric($r['cost']))
						$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
				}else
					$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
				$items=str_replace([
					'<controls>',
					'</controls>'
				],'',$items);
			}
			require'core'.DS.'parser.php';
			$output.=$items;
		}
		$html=preg_replace([
			'~<items>.*?<\/items>~is',
			'~<item>.*?<\/item>~is'
		],[
			$output,
			''
		],$html,1);
	}else
		$html=preg_replace('~<items>.*?<\/items>~is','',$html,1);
	$html=preg_replace([
		'~<item>.*?<\/item>~is',
		'/<items>/',
		'/<\/items>/'
	],'',$html);
	if(stristr($html,'<more>')){
		if($s->rowCount()<=$config['showItems'])
			$html=preg_replace('~<more>.*?<\/more>~is','',$html,1);
		else{
			$html=preg_replace([
				'/<more>/',
				'/<\/more>/',
				'/<print view>/',
				'/<print contentType>/',
				'/<print config=[\"\']?showItems[\"\']?>/'
			],[
				'',
				'',
				$view,
				$contentType,
				$config['showItems']
			],$html);
		}
	}
}
if($view=='testimonials')$show='';
if($show=='item'){
	$html=preg_replace('~<items>.*?<\/items>~is','',$html,1);
	$r=$s->fetch(PDO::FETCH_ASSOC);
	$su=$db->prepare("UPDATE `".$prefix."content` SET views=:views WHERE id=:id");
	$su->execute([
		':views'=>$r['views']+1,
		':id'=>$r['id']
	]);
	if($r['fileURL']!='')
		$shareImage=$r['fileURL'];
	elseif($r['file']!='')
		$shareImage=$r['file'];
	elseif($r['thumb']!='')
		$shareImage=$r['thumb'];
	$seoTitle=empty($r['seoTitle'])?trim(htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8')):trim(htmlspecialchars($r['seoTitle'],ENT_QUOTES,'UTF-8'));
	$metaRobots=!empty($r['metaRobots'])?htmlspecialchars($r['metaRobots'],ENT_QUOTES,'UTF-8'):'index,follow';
	$seoCaption=!empty($r['seoCaption'])?htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8');
	$seoCaption=empty($seoCaption)?htmlspecialchars($config['seoCaption'],ENT_QUOTES,'UTF-8'):$seoCaption;
	$seoDescription=!empty($r['seoDescription'])?htmlspecialchars($r['seoDescription'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8');
	$seoDescription=empty($seoDescrption)?htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'):$seoDescription;
	$seoKeywords=!empty($r['seoKeywods'])?htmlspecialchars($r['seoKeywords'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoKeywords'],ENT_QUOTES, 'UTF-8');
	$seoKeywords=empty($seoKeywords)?htmlspecialchars($config['seoKeywords'],ENT_QUOTES,'UTF-8'):$seoKeywords;
	$canonical=URL.$view.'/'.url_encode($r['title']);
	$contentTime=isset($r['eti'])&&($r['eti']>$r['ti'])?$r['eti']:isset($r['ti'])?$r['ti']:0;
	if(preg_match('/<print page=[\"\']?cover[\"\']?>/',$html)){
		if($r['fileURL'])
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','<img class="img-responsive" src="'.$r['fileURL'].'" alt="'.$r['title'].'" role="image">',$html);
		elseif($r['file'])
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','<img class="img-responsive" src="'.$r['file'].'" alt="'.$r['title'].'" role="image">',$html);
		elseif($page['cover'])
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','<img src="'.$page['cover'].'" alt="'.$r['title'].'" role="image">',$html);
		elseif($page['coverURL'])
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','<img src="'.$page['coverURL'].'" alt="'.$r['title'].'" role="image">',$html);
		else
			$html=preg_replace('/<print page=[\"\']?cover[\"\']?>/','',$html);
	}
	if(preg_match('/<print content=[\"\']?image[\"\']?>/',$html)){
		if($r['fileURL'])
			$html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['fileURL'],$html);
		elseif($r['file'])
			$html=preg_replace('/<print content=[\"\']?image[\"\']?>/',$r['file'],$html);
		else
			$html=preg_replace('/<print content=[\"\']?image[\"\']?>/','',$html);
	}
	if(stristr($html,'<item')){
		preg_match('/<item>([\w\W]*?)<\/item>/',$html,$matches);
		$item=$matches[1];
		if(stristr($item,'<mediaitems')){
			$sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE pid=0 AND rid=:rid ORDER BY ord ASC");
			$sm->execute([':rid'=>isset($r['id'])?$r['id']:$page['id']]);
			if($sm->rowCount()>0){
				preg_match('/<mediaitems>([\w\W]*?)<\/mediaitems>/',$item,$matches2);
				$media=$matches2[1];
				preg_match('/<mediaimages>([\w\W]*?)<\/mediaimages>/',$media,$matches3);
				$mediaitem=$matches3[1];
				$mediaoutput='';
				while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
					$mediaitems=$mediaitem;
					list($width,$height)=getimagesize($rm['file']);
					$tags='';
					if($rm['tags']!=''){
						$mediatags=explode(',',$rm['tags']);
						foreach($mediatags as$mt)$tags.='#'.htmlspecialchars($mt,ENT_QUOTES,'UTF-8').' ';
					}
					$mediaitems=preg_replace([
						'/<print media=[\"\']?image[\"\']?>/',
						'/<print media=[\"\']?width[\"\']?>/',
						'/<print media=[\"\']?height[\"\']?>/',
						'/<print media=[\"\']?title[\"\']?>/',
						'/<print media=[\"\']?category_1[\"\']?>/',
						'/<print media=[\"\']?category_2[\"\']?>/',
						'/<print media=[\"\']?attributionName[\"\']?>/',
						'/<print media=[\"\']?attributionURL[\"\']?>/',
						'/<print media=[\"\']?exifISO[\"\']?>/',
						'/<print media=[\"\']?exifAperture[\"\']?>/',
						'/<print media=[\"\']?exifFocalLength[\"\']?>/',
						'/<print media=[\"\']?exifShutterSpeed[\"\']?>/',
						'/<print media=[\"\']?exifCamera[\"\']?>/',
						'/<print media=[\"\']?exifLens[\"\']?>/',
						'/<print media=[\"\']?exifFilename[\"\']?>/',
						'/<print media=[\"\']?exifTime[\"\']?>/',
						'/<print media=[\"\']?tags[\"\']?>/',
						'/<print media=[\"\']?seoTitle[\"\']?>/',
						'/<print media=[\"\']?caption[\"\']?>/',
						'/<print media=[\"\']?description[\"\']?>/'
					],[
						htmlspecialchars($rm['file'],ENT_QUOTES,'UTF-8'),
						$width,
						$height,
						htmlspecialchars($rm['title'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['category_1'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['category_2'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['attributionImageName'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['attributionImageURL'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifISO'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifAperture'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifFocalLength'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifShutterSpeed'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifCamera'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifLens'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['exifFilename'],ENT_QUOTES,'UTF-8'),
						date($config['dateFormat'],$rm['exifti']),
						$tags,
						htmlspecialchars($rm['seoTitle'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['seoCaption'],ENT_QUOTES,'UTF-8'),
						htmlspecialchars($rm['seoDescription'],ENT_QUOTES,'UTF-8')
					],$mediaitems);
					$mediaoutput.=$mediaitems;
				}
				$item=preg_replace([
					'/<mediaitems>/',
					'/<\/mediaitems>/',
					'~<mediaimages>.*?<\/mediaimages>~is'
				],[
					'',
					'',
					$mediaoutput
				],$item);
			}else
				$item=preg_replace('~<mediaitems>.*?<\/mediaitems>~is','',$item,1);
		}else
			$item=preg_replace('~<mediaitems>.*?<\/mediaitems>~is','',$item,1);
		if(isset($r['contentType'])&&($r['contentType']=='service'||$r['contentType']=='events')){
			if($r['bookable']==1){
				if(stristr($item,'<service>')){
					$item=preg_replace([
						'/<service>/',
						'/<\/service>/',
						'~<inventory>.*?<\/inventory>~is',
						'/<print content=[\"\']?bookservice[\"\']?>/'
					],[
						'',
						'',
						'',
						$r['id']
					],$item);
				}
			}else
				$item=preg_replace('~<service.*?>.*?<\/service>~is','',$item,1);
		}else
			$item=preg_replace('~<service>.*?<\/service>~is','',$item,1);
		$address=$edit=$contentQuantity='';
		if(isset($r['contentType'])&&($r['contentType']=='inventory')){
			if(is_numeric($r['quantity'])&&$r['quantity']!=0)
				$contentQuantity.=$r['stockStatus']=='quantity'?($r['quantity']==0?'<link itemptop="availability" href="http://schema.org/OutOfStock"><div class="quantity">Out Of Stock</div>':'<link itemprop="availability" href="http://schema.org/OutOfStock"><div class="quantity">'.htmlspecialchars($r['quantity'],ENT_QUOTES,'UTF-8').' <span class="quantity-text">In Stock</span></div>'):($r['stockStatus']=='none'?'<link itemprop="availability" href="http://schema.org/OutOfStock">':'<link itemprop="availability" href="http://schema.org/'.ucwords($r['stockStatus']).'"><div class="quantity">'.ucwords($r['stockStatus']).'</div>');	
			$item=preg_replace([
				'/<print content=[\"\']?quantity[\"\']?>/'
			],[
				$contentQuantity
			],$item);
		}else
			$item=preg_replace('/<print content=[\"\']?quantity[\"\']?>/','',$item);
		if(stristr($item,'<choices')){
			$scq=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE rid=:id ORDER BY title ASC");
			$scq->execute([':id'=>isset($r['id'])?$r['id']:$page['id']]);
			if($scq->rowCount()>0){
				$choices='<select class="choices form-control" onchange="$(\'.addCart\').data(\'cartchoice\',$(this).val());$(\'.choices\').val($(this).val());"><option value="0">Select an Option</option>';
				while($rcq=$scq->fetch(PDO::FETCH_ASSOC)){
					if($rcq['ti']==0)continue;
					$choices.='<option value="'.$rcq['id'].'">'.htmlspecialchars($rcq['title'],ENT_QUOTES,'UTF-8').':'.$rcq['ti'].'</option>';
				}
				$choices.='</select>';
				$item=str_replace('<choices>',$choices,$item);
			}else
				$item=str_replace('<choices>','',$item);
		}else
			$item=str_replace('<choices>','',$item);
		if(stristr($item,'<json-ld>')){
			$r['schemaType']=isset($r['schemaType'])?$r['schemaType']:$page['schemaType'];
			$r['notes']=isset($r['notes'])?$r['notes']:$page['notes'];
			$r['business']=isset($r['business'])?$r['business']:$config['business'];
			$r['pti']=isset($r['pti'])?$r['pti']:$page['ti'];
			$r['ti']=isset($r['ti'])?$r['ti']:$page['ti'];
			$r['eti']=isset($r['eti'])?$r['eti']:$page['eti'];
			$jsonld='<script type="application/ld+json">{"@context":"http://schema.org/","@type":"'.$r['schemaType'].'","headline":"'.$r['title'].'","alternativeHeadline":"'.$r['title'].'","image":"';
			if(isset($r['thumb'])&&$r['thumb']!='')
				$jsonld.=$r['thumb'];
			elseif(isset($r['file'])&&$r['file']!='')
				$jsonld.=$r['file'];
			elseif(isset($r['fileURL'])&&$r['fileURL']!='')
				$jsonld.=$r['fileURL'];
			else
				$jsonld.=NOIMAGE;
			if(isset($r['author']))
				$jsonld.='","author":"'.$r['name'].'"';
			if(isset($r['category_1'])){
				$jsonld.='","genre":"'.$r['category_1'];
				if($r['category_2']!='')
					$jsonld.=" > ".$r['category_2'];
			}
			$jsonld.='","keywords":"'.$seoKeywords;
			$jsonld.='","wordcount":"'.htmlspecialchars(strlen(strip_tags($r['notes'])),ENT_QUOTES,'UTF-8');
			$jsonld.='","publisher":"'.htmlspecialchars($r['business'],ENT_QUOTES,'UTF-8');
			$jsonld.='","url":"'.URL.$view.'/';
			$jsonld.='","datePublished":"'.date('Y-m-d',$r['pti']);
			$jsonld.='","dateCreated":"'.date('Y-m-d',$r['ti']);
			$jsonld.='","dateModified":"'.date('Y-m-d',$r['eti']);
			$jsonld.='","description":"'.htmlspecialchars(strip_tags(rawurldecode($seoDescription)),ENT_QUOTES,'UTF-8');
			$jsonld.='","articleBody":"'.htmlspecialchars(strip_tags(escaper($r['notes'])),ENT_QUOTES,'UTF-8');
			$jsonld.='"}</script>';
			$item=str_replace('<json-ld>',$jsonld,$item);
		}
		$item=preg_replace([
			'/<print author=[\"\']?link[\"\']?>/'
		],[
			URL.'profile/'.strtolower(str_replace(' ','-',htmlspecialchars($r['login_user'],ENT_QUOTES,'UTF-8'))),
		],$item);
		if($view!='page'&&stristr($item,'<review')){
			preg_match('/<review>([\w\W]*?)<\/review>/',$item,$matches);
			$review=$matches[1];
			$sr=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE contentType='review' AND status='approved' AND rid=:rid");
			$sr->execute([':rid'=>isset($r['id'])?$r['id']:$page['id']]);
			$reviews='';
			while($rr=$sr->fetch(PDO::FETCH_ASSOC)){
				$reviewitem=$review;
				if(stristr($reviewitem,'<json-ld-review>')){
					$jsonldreview='<script type="application/ld+json">{"@context":"http://schema.org","@type":"Review","author":"'.htmlspecialchars($rr['name'],ENT_QUOTES,'UTF-8').'","datePublished":"'.date('Y-m-d',$rr['ti']).'","description":"'.htmlspecialchars(strip_tags(rawurldecode($r['notes'])),ENT_QUOTES,'UTF-8').'","name":"'.htmlspecialchars($rr['name'],ENT_QUOTES,'UTF-8').'","reviewRating":{"@type":"Rating","bestRating":"5","ratingValue":"'.$rr['cid'].'","worstRating":"1"}}</script>';
					$reviewitem=str_replace('<json-ld-review>',$jsonldreview,$reviewitem);
				}
				$reviewitem=preg_replace('/<print review=[\"\']?rating[\"\']?>/',$rr['cid'],$reviewitem);
				$rset=['','','','','',''];
				$rset[$rr['cid']]='set';
				$reviewitem=preg_replace([
					'/<print review=[\"\']?set5[\"\']?>/',
					'/<print review=[\"\']?set4[\"\']?>/',
					'/<print review=[\"\']?set3[\"\']?>/',
					'/<print review=[\"\']?set2[\"\']?>/',
					'/<print review=[\"\']?set1[\"\']?>/',
					'/<print review=[\"\']?name[\"\']?>/',
					'/<print review=[\"\']?dateAtom[\"\']?>/',
					'/<print review=[\"\']?datetime[\"\']?>/',
					'/<print review=[\"\']?date[\"\']?>/',
					'/<print review=[\"\']?review[\"\']?>/'
				],[
					$rset[5],
					$rset[4],
					$rset[3],
					$rset[2],
					$rset[1],
					htmlspecialchars($rr['name'],ENT_QUOTES,'UTF-8'),
					date('Y-m-d',$rr['ti']),
					date('Y-m-d H:i:s',$rr['ti']),
					date($config['dateFormat'],$rr['ti']),
					htmlspecialchars(strip_tags($rr['notes']),ENT_QUOTES,'UTF-8')
				],$reviewitem);
				$reviews.=$reviewitem;
			}
			$item=preg_replace('~<review>.*?<\/review>~is',$reviews,$item,1);
		}
		require'core'.DS.'parser.php';
		$authorHTML='';
		$seoTitle=$r['title'].' - '.$config['seoTitle'];
		if(isset($r['contentType'])&&($r['contentType']=='article'||$r['contentType']=='portfolio'))
			$item=preg_replace('~<controls>.*?<\/controls>~is','',$item,1);
		$html=preg_replace([
			'~<settings.*?>~is',
			'~<items>.*?<\/items>~is',
			'~<more>.*?<\/more>~is',
			'/<print page=[\"\']?notes[\"\']?>/'
		],'',$html);
		if($view=='article'||$view=='events'||$view=='news'||$view=='proofs'){
			if(file_exists(THEME.DS.'comments.html')){
				$comments=$commentsHTML='';
				$sc=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE contentType=:contentType AND rid=:rid AND status!='unapproved' ORDER BY ti ASC");
				$sc->execute([
					':contentType'=>$view,
					':rid'=>$r['id']
				]);
				$commentsHTML=file_get_contents(THEME.DS.'comments.html');
				$commentsHTML=preg_replace([
					'/<print content=[\"\']?id[\"\']?>/',
					'/<print content=[\"\']?contentType[\"\']?>/',
				],[
					$r['id'],
					$r['contentType']
				],$commentsHTML);
				$commentDOC=new DOMDocument();
				@$commentDOC->loadHTML($commentsHTML);
				preg_match('/<items>([\w\W]*?)<\/items>/',$commentsHTML,$matches);
				while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
					$comment=$matches[1];
					$rc['notes']=htmlspecialchars(strip_tags(rawurldecode($rc['notes'])),ENT_QUOTES,'UTF-8');
					require'core'.DS.'parser.php';
					$comments.=$comment;
				}
				$commentsHTML=preg_replace('~<items>.*?<\/items>~is',$comments,$commentsHTML,1);
				$commentsHTML=$r['options']{1}==1?str_replace(array('<comment>','</comment>'),'',$commentsHTML):preg_replace('~<comment>.*?<\/comment>~is','',$commentsHTML,1);
				$commentsHTML=preg_replace('~<items>.*?<\/items>~is','',$commentsHTML,1);
				$item.=$commentsHTML;
			}else
				$item.='Comments for this post is Enabled, but no <strong>"'.THEME.DS.'comments.html"</strong> template file exists';
		}
		$html=preg_replace('~<item>.*?<\/item>~is',$item,$html,1);
	}
}
if($view=='login'){
	$html=preg_replace('/<print url>/',URL,$html,1);
	if($config['options']{3}==1)
		$html=preg_replace('/<[\/]?signup?>/','',$html,1);
	else
		$html=preg_replace('~<signup>.*?<\/signup>~is','',$html,1);
}
$content.=$html;
