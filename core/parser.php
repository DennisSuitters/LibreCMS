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
if(stristr($parse,'<print content=id>'))
	$parse=str_replace('<print content=id>',$r['id'],$parse);
if(stristr($parse,'<print content=schemaType>'))
	$parse=str_replace('<print content=schemaType>',htmlentities($r['schemaType'],ENT_QUOTES,'UTF-8'),$parse);
if(preg_match('/<author>([\w\W]*?)<\/author>/',$parse)&&$view=='article'&&$r['uid']!=0){
	$parse=str_replace('<author>','',$parse);
	$parse=str_replace('</author>','',$parse);
}else
	$parse=preg_replace('~<author>.*?<\/author>~is','',$parse,1);
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
	if($tag->hasAttribute('class'))$class=$tag->getAttribute('class');else$class='';
	if($tag->hasAttribute('alt'))$alt=$tag->getAttribute('alt');else$alt='';
	if($tag->hasAttribute('type'))$type=$tag->getAttribute('type');else$type='text';
	if($tag->hasAttribute('strip')&&$tag->getAttribute('type')=='true')$strip=true;else$strip=false;
	$print=$tag->getAttribute($attribute);
	if($container!=''){
		$parsing.='<'.$container;
		if($class!='')$parsing.=' class="'.$class.'"';
		$parsing.='>';
	}
	if($leadingtext!='')$parsing.=$leadingtext;
	switch($print){
		case'contentType':
			$parsing.=ucfirst($r['contentType']);
			break;
		case'dateCreated':
			if($attribute=='comments')$parsing.=date($config['dateFormat'],$rc['ti']);
			elseif($_SESSION['rank']>$userrank)$parsing.=date($config['dateFormat'],$r['ti']);
			else$container=$parsing='';
			break;
		case'datePublished':
			if($r['pti']!=0)$parsing.=date($config['dateFormat'],$r['pti']);
			else$parsing.=date($config['dateFormat'],$r['ti']);
			break;
		case'dateEvent':
			if($r['tis']!=0){
				$parsing.=date($config['dateFormat'],$r['tis']);
				if($r['tie']!=0)$parsing.=' to '.date($config['dateFormat'],$r['tie']);
			}else$container=$parsing='';
			break;
		case'dateEdited':
			if($_SESSION['rank']>$userrank){
				if($r['eti']==0)$parsing.='Never';
				else$parsing.=date($config['dateFormat'],$r['eti']).' by <strong>'.$r['login_user'].'</strong>';
			}else$container=$parsing='';
			break;
		case'categories':
			if($r['category_1']!=''){
				$parsing.=' <a href="'.$view.'/'.urlencode(str_replace(' ','-',$r['category_1'])).'" rel="tag">'.htmlspecialchars($r['category_1'],ENT_QUOTES,'UTF-8').'</a>';
				if($r['category_2']!='')$parsing.=' / <a href="'.$view.'/'.urlencode(str_replace(' ','-',$r['category_1'])).'/'.urlencode(str_replace(' ','-',$r['category_2'])).'" rel="tag">'.htmlspecialchars($r['category_2'],ENT_QUOTES,'UTF-8').'</a>';
			}else$container=$parsing='';
			break;
		case'tags':
			if($r['tags']!=''){
				$tags=explode(',',$r['tags']);
				foreach($tags as$tag)$parsing.='<a href="search/'.urlencode(str_replace(' ','-',$tag)).'">#'.htmlspecialchars($tag,ENT_QUOTES,'UTF-8').'</a> ';
			}else$container=$parsing='';
			break;
		case'cost':
			if($r['contentType']=='inventory'||$r['contentType']=='service'){
				if($r['options']{0}==1||$r['cost']!=''){
					if(is_numeric($r['cost'])&&$r['cost']!=0){
						$parsing.='<meta itemprop="priceCurrency" content="AUD"><span class="cost" itemprop="price" content="'.$r['cost'].'">';
						if(is_numeric($r['cost']))$parsing.='&#36;';
						$parsing.=htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>';
					}else$parsing.='<span class="cost">'.htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>';
					if($r['contentType']=='service'&&$r['bookable']==1){
						if(stristr($parse,'<service>')){
							$parse=str_replace('<service>','',$parse);
							$parse=str_replace('</service>','',$parse);
							$parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
						}elseif(stristr($parse,'<service>')&&$r['contentType']!='service')
							$parse=preg_replace('~<service>.*?<\/service>~is','',$parse,1);
					}else$parse=preg_replace('~<service>.*?<\/service>~is','',$parse,1);
					if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
						if(stristr($parse,'<inventory>')){
							$parse=str_replace('<inventory>','',$parse);
							$parse=str_replace('</inventory>','',$parse);
							$parse=preg_replace('~<service>.*?<\/service>~is','',$parse,1);
						}elseif(stristr($parse,'<inventory>')&&$r['contentType']!='inventory')
							$parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
					}else$parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
				}
				$parse=str_replace('<controls>','',$parse);
				$parse=str_replace('</controls>','',$parse);
				$parse=str_replace('<cost>','',$parse);
				$parse=str_replace('</cost>','',$parse);
			}else$parse=preg_replace('~<cost>.*?<\/cost>~is','',$parse,1);
			break;
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
			if($r['thumb']!=''&&(file_exists('media'.DS.$thumbchk)||file_exists('../../media'.DS.$thumbchk)))
				$parsing.='<img src="'.$r['thumb'].'" alt="'.$r['title'].'">';
			elseif($r['file']!=''&&(file_exists('media'.DS.$filechk)||file_exists('../../media'.DS.$filechk)))
				$parsing.='<img src="'.$r['file'].'" alt="'.$r['title'].'">';
			break;
		case'image':
			$filechk=basename($r['file']);
			if($r['file']!=''&&(file_exists('media'.DS.$filechk)||file_exists('../../media'.DS.$filechk)))
				$parsing.='<img class="'.$class.'" src="'.$r['file'].'" alt="'.$r['title'].'">';
			break;
		case'imageURL':
			$parsing.=$r['file'];
		case'avatar':
			$parsing.='<img class="'.$class.'" src="';
			if($attribute=='author'){
				$authour['avatar']=basename($author['avatar']);
				if($author['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$author['avatar']))
					$parsing.='media'.DS.'avatar'.DS.$author['avatar'].'"';
				elseif($author['gravatar']!=''){
					if(stristr($author['avatar'],'@'))
						$parsing.='http://gravatar.com/avatar/'.md5($author['gravatar']).'"';
					elseif(stristr($author['gravatar'],'gravatar.com/avatar'))
						$parsing.=$author['gravatar'];
					else
						$parsing.=THEME.DS.'images'.DS.'noavatar.jpg';
				}else
					$parsing.=THEME.DS.'images'.DS.'noavatar.jpg"';
				if($alt=='name'){
					$parsing.=' alt="';
					if($author['name'])$parsing.=$author['name'];else$parsing.=$author['username'];
					$parsing.='"';
				}
			}
			if($attribute=='comments'){
				if($rc['uid']!=0){
					$scu=$db->prepare("SELECT avatar,gravatar FROM login WHERE id=:rcuid");
					$scu->execute(array(':rcuid'=>$rc['uid']));
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
			if($attribute=='author'){
				if($author['name'])$parsing.=htmlspecialchars($author['name'],ENT_QUOTES,'UTF-8');
				else$parsing.=htmlspecialchars($author['username'],ENT_QUOTES,'UTF-8');
			}
			if($attribute=='comments')$parsing.=htmlspecialchars($rc['name'],ENT_QUOTES,'UTF-8');
			if($attribute=='content')$parsing.=htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8');
			break;
		case'caption':
			if($length!=0)$caption=strtok(wordwrap($r['seoCaption'],$length,"...\n"),"\n");
			else$caption=$r['seoCaption'];
			$parsing.=$caption;
		case'notes':
			if($attribute=='author')$notes=$author['notes'];
			if($attribute=='comments')$notes=$rc['notes'];
			if($attribute=='page')$notes=$page['notes'];
			if($attribute=='content')$notes=$r['notes'];
			if($strip==true)$notes=strip_tags($notes);
			if($length!=0)$notes=strtok(wordwrap($notes,$length,"...\n"),"\n");
			$parsing.=$notes;
			break;
		case'notesCount':
			if($attribute=='author')$notesCount=strlen($author['notes']);
			if($attribute=='comments')$notesCount=strlen($rc['notes']);
			if($attribute=='page')$notesCount=strlen($page['notes']);
			if($attribute=='content')$notesCount=strlen($r['notes']);
			$parsing.=$notesCount;
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
		case'time':
				if($attribute=='comments')$parsing.=date($config['dateFormat'],$rc['ti']);
				elseif($_SESSION['rank']>$userrank)$parsing.=date($config['dateFormat'],$r['ti']);
				else$container=$parsing='';
				break;
			break;
		default:
			if($attribute=='content'){
				if($r[$print]!=''){
					if($_SESSION['rank']>$userrank)$parsing.=htmlspecialchars($leadingtext.$r[$print],ENT_QUOTES,'UTF-8');
				}
			}
			if($attribute=='user'){
				if(isset($user[$print]))$parsing=$user[$print];
			}
			if($attribute=='config')$parsing.=$config[$print];
	}
	if($container!='')$parsing.='</'.$container.'>';
	$parse=preg_replace('~<print[^>]+.*?'.$attribute.'=.'.$print.'.*?[^>]+>~is',$parsing,$parse,1);
}
if($show=='item'){
	if(isset($comment)&&$comment!='')$comment=$parse;
	else$item=$parse;
}elseif(isset($comment))$comment=$parse;
else$items=$parse;
