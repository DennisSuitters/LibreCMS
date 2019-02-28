<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Parser to Parse common tags
 *
 * parser.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Parser to Parse common tags
 * @package    core/parser.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$doc=new DOMDocument();
if($show=='item'){
	if(isset($comment)&&$comment!=''){
		@$doc->loadHTML($comment);
		$parse=$comment;
	}else{
		@$doc->loadHTML($item);
		$parse=$item;
	}
}else{
	if(isset($items)){
		@$doc->loadHTML($items);
		$parse=$items;
	}else
		$parse='';
}
$parse=preg_replace([
		'/<print content=[\"\']?id[\"\']?>/',
		'/<print content=[\"\']?schemaType[\"\']?>/'
	],[
		isset($r['id'])?$r['id']:$page['id'],
		isset($r['schemaType'])?htmlentities($r['schemaType'],ENT_QUOTES,'UTF-8'):htmlentities($page['schemaType'],ENT_QUOTES,'UTF-8')
	],$parse);
if(preg_match('/<author>([\w\W]*?)<\/author>/',$parse)&&$view=='article'&&$r['uid']!=0)
	$parse=str_replace(['<author>','</author>'],'',$parse);
else
	$parse=preg_replace('~<author>.*?<\/author>~is','',$parse,1);
$tags=$doc->getElementsByTagName('print');
foreach($tags as$tag){
	$parsing='';
	if($tag->hasAttribute('page'))
		$attribute='page';
	if($tag->hasAttribute('content'))
		$attribute='content';
	if($tag->hasAttribute('user'))
		$attribute='user';
	if($tag->hasAttribute('config'))
		$attribute='config';
	if($tag->hasAttribute('author')){
		$attribute='author';
		$r['uid']=isset($r['uid'])?$r['uid']:0;
		$sa=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
		$sa->execute([':id'=>$r['uid']]);
		$author=$sa->fetch(PDO::FETCH_ASSOC);
	}
	if($tag->hasAttribute('comments'))$attribute='comments';
	$container=$tag->hasAttribute('container')?$tag->getAttribute('container'):'';
	$leadingtext=$tag->hasAttribute('leadingtext')?$tag->getAttribute('leadingtext'):'';
	$userrank=$tag->hasAttribute('userrank')?$tag->getAttribute('userrank'):-1;
	$length=$tag->hasAttribute('length')?$tag->getAttribute('length'):0;
	$class=$tag->hasAttribute('class')?$tag->getAttribute('class'):'';
	$alt=$tag->hasAttribute('alt')?$tag->getAttribute('alt'):'';
	$type=$tag->hasAttribute('type')?$tag->getAttribute('type'):'text';
	$strip=$tag->hasAttribute('strip')&&$tag->getAttribute('type')=='true'?true:false;
	$print=$tag->getAttribute($attribute);
	if($container!='')$parsing.='<'.$container.($class!=''?' class="'.$class.'"':'').'>';
	if($leadingtext!='')$parsing.=$leadingtext;
	switch($print){
		case'contentType':
			$parsing.=ucfirst($r['contentType']);
			break;
		case'dateCreated':
			if($attribute=='comments')
				$parsing.=date($config['dateFormat'],$rc['ti']);
			elseif($_SESSION['rank']>$userrank)
				$parsing.=date($config['dateFormat'],$r['ti']);
			else
				$container=$parsing='';
			break;
		case'datePublished':
			if(isset($r['pti'])&&$r['pti']!=0)
				$parsing.=date($config['dateFormat'],$r['pti']);
			elseif(isset($r['ti'])&&$r['ti']!=0)
				$parsing.=date($config['dateFormat'],$r['ti']);
			else
				$parsing.='';
			break;
		case'dateEvent':
			if(isset($r['tis'])){
				if($r['tis']!=0){
					$parsing.=date($config['dateFormat'],$r['tis']);
					if($r['tie']!=0)$parsing.=' to '.date($config['dateFormat'],$r['tie']);
				}else
					$container=$parsing='';
			}
			break;
		case'dateEdited':
			if($_SESSION['rank']>$userrank)
				$parsing.=$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by <strong>'.$r['login_user'].'</strong>';
			else
				$container=$parsing='';
			break;
		case'categories':
			if(isset($r['category_1'])&&$r['category_1']!=''){
				$parsing.=' <a href="'.$view.'/'.urlencode(str_replace(' ','-',$r['category_1'])).'" rel="tag">'.htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8').'</a>';
				if($r['category_2']!='')
					$parsing.=' / <a href="'.$view.'/'.urlencode(str_replace(' ','-',$r['category_1'])).'/'.urlencode(str_replace(' ','-',$r['category_2'])).'" rel="tag">'.htmlspecialchars($r['category_2'],ENT_QUOTES,'UTF-8').'</a>';
			}else
				$container=$parsing='';
			break;
		case'tags':
			if(isset($r['tags'])&&$r['tags']!=''){
				$tags=explode(',',$r['tags']);
				foreach($tags as$tag)
					$parsing.='<a href="search/'.urlencode(str_replace(' ','-',$tag)).'">#'.htmlspecialchars($tag,ENT_QUOTES,'UTF-8').'</a> ';
			}else
				$container=$parsing='';
			break;
		case'cost':
			if(isset($r['contentType'])&&($r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='events')){
				if($r['options']{0}==1||$r['cost']!=''){
					if(is_numeric($r['cost'])&&$r['cost']!=0){
						$parsing.='<meta itemprop="priceCurrency" content="AUD"><span class="cost" itemprop="price" content="'.$r['cost'].'">';
						if(is_numeric($r['cost']))$parsing.='&#36;';
						$parsing.=htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>';
					}else
						$parsing.='<span class="cost">'.htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>';
					if($r['contentType']=='service'||$r['contentType']=='events'&&$r['bookable']==1){
						if(stristr($parse,'<service>')){
							$parse=preg_replace([
								'~<inventory>.*?<\/inventory>~is',
								'/<service>/',
								'/<\/service>/'
							],'',$parse);
						}elseif(stristr($parse,'<service>')&&$r['contentType']!='service')
							$parse=preg_replace('~<service>.*?<\/service>~is','',$parse,1);
					}else
						$parse=preg_replace('~<service>.*?<\/service>~is','',$parse,1);
					if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
						if(stristr($parse,'<inventory>')){
							$parse=preg_replace([
								'~<service>.*?<\/service>~is',
								'/<inventory>/',
								'/<\/inventory>/'
							],'',$parse);
						}elseif(stristr($parse,'<inventory>')&&$r['contentType']!='inventory')
							$parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
					}else
						$parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
				}
				$parse=str_replace([
					'<controls>',
					'</controls>',
					'<cost>',
					'</cost>'
				],'',$parse);
			}else
				$parse=preg_replace('~<cost>.*?<\/cost>~is','',$parse,1);
			break;
		case'stockStatus':
			$parsing.=$r['stockStatus']=='quantity'?($r['quantity']==0?'out of stock':'in stock'):$r['stockStatus'];
		case'cover':
			if($attribute=='page'){
				$coverchk=basename($page['cover']);
				if($page['cover']!=''&&file_exists('media'.DS.$coverchk))
					$parsing.='<img class="'.$class.'" src="'.$page['cover'].'">';
				elseif($page['coverURL']!='')
					$parsing.='<img class="'.$class.'" src="'.$page['coverURL'].'">';
				else
					$parsing.='';
			}
			break;
		case'thumb':
			$filechk=basename($r['file']);
			$thumbchk=basename($r['thumb']);
			if($r['thumb']!=''&&(file_exists('media'.DS.$thumbchk)||file_exists('..'.DS.'..'.DS.'media'.DS.$thumbchk)))
				$parsing.='<img src="'.$r['thumb'].'" alt="'.$r['title'].'">';
			elseif($r['file']!=''&&(file_exists('media'.DS.$filechk)||file_exists('..'.DS.'..'.DS.'media'.DS.$filechk)))
				$parsing.='<img src="'.$r['file'].'" alt="'.$r['title'].'">';
			else
				$parsing.=NOIMAGE;
			break;
		case'image':
			if(isset($r['file'])&&$r['file']!=''){
				$filechk=basename($r['file']);
				$parsing.=$r['file']!=''&&(file_exists('media'.DS.$filechk)||file_exists('..'.DS.'..'.DS.'media'.DS.$filechk))?'<img class="'.$class.'" src="'.$r['file'].'" alt="'.$r['title'].'">':'';
			}elseif(isset($r['fileURL'])&&$r['fileURL']!='')
				$parsing.=$r['fileURL'];
			else
				$parsing.='';
			break;
		case'imageURL':
			$parsing.=$r['fileURL'];
		case'avatar':
			$parsing.='<img class="'.$class.'" src="';
			if($attribute=='author'){
				$author['avatar']=basename($author['avatar']);
				if($author['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$author['avatar']))
					$parsing.='media'.DS.'avatar'.DS.$author['avatar'].'"';
				elseif(isset($author['gravatar'])&&$author['gravatar']!=''){
					if(stristr($author['avatar'],'@'))
						$parsing.='http://gravatar.com/avatar/'.md5($author['gravatar']).'"';
					elseif(stristr($author['gravatar'],'gravatar.com/avatar'))
						$parsing.=$author['gravatar'].'"';
					else
						$parsing.=NOAVATAR.'"';
				}else
					$parsing.=NOAVATAR.'"';
				if($alt=='name'){
					$parsing.=' alt="';
					if(isset($author['name'])&&$author['name'])
						$parsing.=$author['name'];
					elseif(isset($author['username']))
						$parsing.=$author['username'];
					$parsing.='"';
				}
			}
			if($attribute=='comments'){
				if($rc['uid']!=0){
					$scu=$db->prepare("SELECT avatar,gravatar FROM `".$prefix."login` WHERE id=:rcuid");
					$scu->execute([':rcuid'=>$rc['uid']]);
					$rcu=$scu->fetch(PDO::FETCH_ASSOC);
					$rc['avatar']=$rcu['avatar'];
					$rc['gravatar']=$rcu['gravatar'];
				}
				$rc['avatar']=basename($rc['avatar']);
				if($rc['avatar']&&file_exists('media'.DS.'avatar'.DS.$rc['avatar']))
					$parsing.='media'.DS.'avatar'.DS.$rc['avatar'];
				elseif($rc['gravatar']!=''){
					if(stristr($rc['gravatar'],'@'))
						$parsing.='http://gravatar.com/avatar/'.md5($rc['gravatar']);
					elseif(stristr($rc['gravatar'],'gravatar.com/avatar'))
						$parsing.=$rc['gravatar'];
					else
						$parsing.=THEME.DS.'images'.DS.'noavatar.jpg';
				}else
					$parsing.=THEME.DS.'images'.DS.'noavatar.jpg';
				$parsing.='" alt="'.$rc['name'].'"';
			}
			$parsing.='>';
			break;
		case'name':
			if($attribute=='author')
				$parsing.=$author['name']?htmlspecialchars($author['name'],ENT_QUOTES, 'UTF-8'):htmlspecialchars($author['username'],ENT_QUOTES,'UTF-8');
			if($attribute=='comments')
				$parsing.=htmlspecialchars($rc['name'],ENT_QUOTES,'UTF-8');
			if($attribute=='content')
				$parsing.=htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8');
			break;
		case'caption':
			$parsing.=$length!=0?strtok(wordwrap($r['seoCaption'],$length,"...\n"),"\n"):$r['seoCaption'];
		case'notes':
			if($attribute=='author')$notes=rawurldecode($author['notes']);
			if($attribute=='comments')$notes=rawurldecode($rc['notes']);
			if($attribute=='page')$notes=rawurldecode($page['notes']);
			if($attribute=='content')$notes=rawurldecode($r['notes']);
			if($strip==true)$notes=strip_tags($notes);
			if($length!=0)$notes=strtok(wordwrap($notes,$length,"...\n"),"\n");
			$parsing.=$notes;
			break;
		case'notesCount':
			if($attribute=='author')$notesCount=strlen(strip_tags(rawurldecode($author['notes'])));
			if($attribute=='comments')$notesCount=strlen(strip_tags(rawurldecode($rc['notes'])));
			if($attribute=='page')$notesCount=strlen(strip_tags(rawurldecode($page['notes'])));
			if($attribute=='content')$notesCount=strlen(strip_tags(rawurldecode($r['notes'])));
			$parsing.=$notesCount;
		case'email':
			if($attribute=='author'){
				if($author['email'])
					$parsing.='<a href="mailto:'.$author['email'].'" rel="nofollow">'.($type=='icon'?'<'.$theme['settings']['icon_container'].' class="'.$class.'">'.frontsvg('libre-gui-email').'</'.$theme['settings']['icon_container'].'>':$author['email']).'</a>';
			}
			break;
		case'social':
			if($attribute=='author'){
				$sa =$db->prepare("SELECT * FROM `".$prefix."choices` WHERE uid=:uid AND contentType='social'");
				$sa->execute([':uid'=>$r['uid']]);
				while($sr=$sa->fetch(PDO::FETCH_ASSOC))
					$parsing.='<a href="'.$sr['url'].'" title="'.$sr['title'].'">'.($type=='icon'?'<'.$theme['settings']['icon_container'].' class="'.$class.'">'.frontsvg('libre-social-'.$sr['icon']).'</'.$theme['settings']['icon_container'].'>':$sr['title'].' ').'</a>';
			}
			break;
		case'time':
				if($attribute=='comments')
					$parsing.=date($config['dateFormat'],$rc['ti']);
				elseif($_SESSION['rank']>$userrank)
					$parsing.=date($config['dateFormat'],$r['ti']);
				else
					$container=$parsing='';
				break;
			break;
		default:
			if($attribute=='content'){
				if(isset($r[$print])){
					if($_SESSION['rank']>$userrank)
						$parsing.=htmlspecialchars($leadingtext.$r[$print],ENT_QUOTES,'UTF-8');
				}
			}
			if($attribute=='user'){
				if(isset($user[$print]))$parsing.=$user[$print];
			}
			if($attribute=='config')$parsing.=$config[$print];
			if($attribute=='media')$parsing.=$rm[$print];
	}
	if($container!='')$parsing.='</'.$container.'>';
	$parse=preg_replace('~<print[^>]+.*?'.$attribute.'=.'.$print.'.*?[^>]+>~is',$parsing,$parse,1);
/*	$parse=preg_replace('~<print '.$attribute.'=[\"\']?'.$print.'[\"\']?>~is',$parsing,$parse,1); */
}
if($show=='item'){
	if(isset($comment)&&$comment!='')
		$comment=$parse;
	else
		$item=$parse;
}elseif(isset($comment))
	$comment=$parse;
else
	$items=$parse;
