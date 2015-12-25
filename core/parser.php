<?php
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
	}else$parse='';
}
if(stristr($parse,'<print content=id>'))$parse=str_replace('<print content=id>',$r['id'],$parse);
if(stristr($parse,'<print content=schemaType>'))$parse=str_replace('<print content=schemaType>',htmlentities($r['schemaType'],ENT_QUOTES,'UTF-8'),$parse);
if(preg_match('/<author>([\w\W]*?)<\/author>/',$parse)&&$view=='article'&&$r['uid']!=0){
	$parse=str_replace('<author>','',$parse);
	$parse=str_replace('</author>','',$parse);
}else $parse=preg_replace('~<author>.*?<\/author>~is','',$parse,1);
$tags=$doc->getElementsByTagName('print');
foreach($tags as$tag){
	$parsing='';
	if($tag->hasAttribute('page'))$attribute='page';
	if($tag->hasAttribute('content'))$attribute='content';
	if($tag->hasAttribute('user'))$attribute='user';
	if($tag->hasAttribute('config'))$attribute='config';
	if($tag->hasAttribute('author')){
		$attribute='author';
		$sa=$db->prepare("SELECT * FROM login WHERE id=:id");
		$sa->execute(array(':id'=>$r['uid']));
		$author=$sa->fetch(PDO::FETCH_ASSOC);
	}
	if($tag->hasAttribute('comments'))$attribute='comments';
	if($tag->hasAttribute('container'))$container=$tag->getAttribute('container');else$container='';
	if($tag->hasAttribute('leadingtext'))$leadingtext=$tag->getAttribute('leadingtext');else$leadingtext='';
	if($tag->hasAttribute('userrank'))$userrank=$tag->getAttribute('userrank');else$userrank=-1;
	if($tag->hasAttribute('length'))$length=$tag->getAttribute('length');else$length=0;
	if($tag->hasAttribute('striptags'))$striptags=$tag->getAttribute('striptags');else$striptags='no';
	if($tag->hasAttribute('class'))$class=$tag->getAttribute('class');else$class='';
	if($tag->hasAttribute('alt'))$alt=$tag->getAttribute('alt');else$alt='';
	if($tag->hasAttribute('type'))$type=$tag->getAttribute('type');else$type='text';
	$print=$tag->getAttribute($attribute);
	if($container){
		$parsing.='<'.$container;
		if($class)$parsing.=' class="'.$class.'"';
		$parsing.='>';
	}
	if($leadingtext)$parsing.=$leadingtext;
	switch($print){
		case'contentType':
			$parsing.=ucfirst($r['contentType']);
			break;
		case'dateCreated':
			if($attribute=='comments')$parsing.=date($config['dateFormat'],$rc['ti']);
			else if($_SESSION['rank']>$userrank)$parsing.=date($config['dateFormat'],$r['ti']);
			break;
		case'datePublished':
			if($r['tis']!=0)$parsing.=date($config['dateFormat'],$r['tis']);
			else$parsing.=date($config['dateFormat'],$r['ti']);
			break;
		case'dateEvent':
			if($r['tis']!=0){
				$parsing.=date($config['dateFormat'],$t['tis']);
				if($r['tie']!=0)$parsing.=' to '.date($config['dateFormat'],$r['tie']);
			}
			break;
		case'dateEdited':
			if($_SESSION['rank']>$userrank){
				if($r['eti']==0)$parsing.='Never';
				else$parsing.=date($config['dateFormat'],$r['eti']).' by <strong>'.$r['login_user'].'</strong>';
			}
			break;
		case'categories':
			if($r['category_1']!=''){
				$parsing.=' <a href="'.$view.'/'.str_replace(' ','-',htmlentities($r['category_1'],ENT_QUOTES,'UTF-8')).'">'.htmlentities($r['category_1'],ENT_QUOTES,'UTF-8').'</a>';
				if($r['category_2']!='')$parsing.=' / <a href="'.$view.'/'.str_replace(' ','-',htmlentities($r['category_1'],ENT_QUOTES,'UTF-8').'/'.htmlentities($r['category_2'],ENT_QUOTES,'UTF-8')).'">'.htmlentities($r['category_2'],ENT_QUOTES,'UTF-8').'</a>';
			}
			break;
		case'tags':
			if($r['tags']!=''){
				$tags=explode(',',$r['tags']);
				foreach($tags as$tag)$parsing.='<a href="search/'.htmlentities(str_replace(' ','-',$tag),ENT_QUOTES,'UTF-8').'">#'.htmlentities($tag,ENT_QUOTES,'UTF-8').'</a> ';
			}
			break;
		case'cost':
			if($r['contentType']=='inventory'||$r['contentType']=='service'){
				if($r['options']{0}==1){
					$parsing.=htmlentities($r['cost'],ENT_QUOTES,'UTF-8');
					if($r['contentType']=='services'){
						if($r['bookable']==1){
							if(stristr($parse,'<service>')){
								$parse=str_replace('<print content=bookservice>',URL.'bookings/'.$r['id'],$parse);
								$parse=str_replace('<service>','',$parse);
								$parse=str_replace('</service>','',$parse);
								$parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
							}
						}
					}
					if($r['contentType']=='inventory'){
						if(stristr($parse,'<inventory>')){
							$parse=str_replace('<inventory>','',$parse);
							$parse=str_replace('</inventory>','',$parse);
							$parse=preg_replace('~<service>.*?<\/service>~is','',$parse,1);
						}elseif(stristr($parse,'<inventory>')&&$r['contentType']!='inventory')
							$parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
					}else$parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
					$parse=str_replace('<controls>','',$parse);
					$parse=str_replace('</controls>','',$parse);
					$parse=str_replace('<cost>','',$parse);
					$parse=str_replace('</cost>','',$parse);
				}
			}else$parse=preg_replace('~<cost>.*?<\/cost>~is','',$parse,1);
			break;
		case'cover':
			if($attribute=='page'){
				if($page['cover']!=''&&file_exists('media/'.$page['cover']))$parsing.='<img class="'.$class.'" src="media/'.$page['cover'].'">';
				elseif($page['coverURL']!='')$parsing.='<img class="'.$class.'" src="'.$page['coverURL'].'">';
				else$parsing.='';
			}
			break;
		case'thumb':
			if($r['thumb']&&file_exists('media/'.$r['thumb']))$parsing.='<img src="media/'.$r['thumb'].'" alt="'.$r['title'].'">';
			break;
		case'image':
			if($r['file']&&file_exists('media/'.$r['file']))$parsing.='<img src="media/'.$r['file'].'" alt="'.$r['title'].'">';
			break;
		case'avatar':
			$parsing.='<img class="'.$class.'" src="';
			if($attribute=='author'){
				if($author['gravatar'])$parsing.='http://gravatar.com/avatar/'.md5($author['gravatar']).'"';
				elseif($author['avatar']&&file_exists('media/avatar/'.$author['avatar']))$parsing.='media/avatar/'.$author['avatar'].'"';
				else $parsing.=THEME.'/images/noavatar.jpg"';
				if($alt=='name'){
					$parsing.=' alt="';
					if($author['name'])$parsing.=$author['name'];else$parsing.=$author['username'];
					$parsing.='"';
				}
			}
			if($attribute=='comments'){
				if($rc['gravatar']!='')$parsing.='http://gravatar.com/avatar/'.md5($rc['gravatar']);
				elseif($rc['avatar']&&file_exists('media/avatar/'.$rc['avatar']))$parsing.='media/avatar/'.$rc['avatar'];
				else$parsing.=THEME.'/images/noavatar.jpg';
				$parsing.='" alt="'.$rc['name'].'"';
			}
			$parsing.='">';
			break;
		case'name':
			if($attribute=='author'){
				if($author['name'])$parsing.=htmlentities($author['name'],ENT_QUOTES,'UTF-8');
				else$parsing.=htmlentities($author['username'],ENT_QUOTES,'UTF-8');
			}
			if($attribute=='comments')$parsing.=htmlentities($rc['name'],ENT_QUOTES,'UTF-8');
			if($attribute=='content')$parsing.=htmlentities($r['name'],ENT_QUOTES,'UTF-8');
			break;
		case'notes':
			if($attribute=='author')$notes=$author['notes'];
			if($attribute=='comments')$notes=$rc['notes'];
			if($attribute=='page')$notes=$page['notes'];
			if($attribute=='content')$notes=$r['notes'];
			if($striptags!='null'||$striptags!='false'||$striptags!='no'||$striptags!='')$notes=strip_tags($notes,$striptags);
			if($length!=0)$notes=strtok(wordwrap($notes,$length,"...\n"),"\n");
			$parsing.=htmlentities($notes,ENT_QUOTES,'UTF-8');
			break;
		case'email':
			if($attribute=='author'){
				if($author['email']){
					$parsing.='<a href="mailto:'.$author['email'].'" rel="nofollow">';
					if($type=='icon')$parsing.='<'.$theme['settings']['icon_container'].' class="'.$class.'"></'.$theme['settings']['icon_container'].'>';
					else$parsing.=$author['email'];
					$parsing.='</a>';
				}
			}
			break;
		case'social':
			if($attribute=='author'){
				$sa=$db->prepare("SELECT * FROM choices WHERE uid=:uid");
				$sa->execute(array(':uid'=>$r['uid']));
				while($sr=$sa->fetch(PDO::FETCH_ASSOC)){
					$parsing.='<a href="'.$sr['url'].'" title="'.$sr['title'].'">';
					if($type=='icon')$parsing.='<'.$theme['settings']['icon_container'].' class="'.$class.$sr['icon'].'"></'.$theme['settings']['icon_container'].'>';
					else$parsing.=$sr['title'].' ';
					$parsing.='</a>';
				}
			}
			break;
		default:
			if($attribute=='content'){
				if($r[$print]!=''){
					if($_SESSION['rank']>$userrank)$parsing.=htmlentities($leadingtext.$r[$print],ENT_QUOTES,'UTF-8');
				}
			}
			if($attribute=='user'){
				if(isset($user[$print]))$parsing=$user[$print];
			}
			if($attribute=='config')$parsing.=$config[$print];
	}
	if($container)$parsing.='</'.$container.'>';
	$parse=preg_replace('~<print .*?'.$attribute.'=.'.$print.'.*?>~is',$parsing,$parse,1);
}
if($show=='item'){
	if(isset($comment)&&$comment!='')$comment=$parse;
	else$item=$parse;
}elseif(isset($comment))$comment=$parse;
else$items=$parse;
