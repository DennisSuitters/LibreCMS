<?php
$doc=new DOMDocument();
if($show=='item'){
	@$doc->loadHTML($item);
	$parse=$item;
}else{
	@$doc->loadHTML($html);
	$parse=$html;
}
$tags=$doc->getElementsByTagName('print');
foreach($tags as $tag){
	if($tag->hasAttribute('content')){
		$attribute='content';
		$print=$tag->getAttribute('content');
	}
	if($tag->hasAttribute('user')){
		$attribute='user';
		$print=$tag->getAttribute('user');
	}
	if($tag->hasAttribute('config')){
		$attribute='config';
		$print=$tag->getAttribute('config');
	}
	switch($print){
		case'contentType':
			$parse=str_replace('<print '.$attribute.'=contentType>','<div>'.$r['contentType'].'</div>',$parse);
			break;
		case'dateCreated':
			$parse=str_replace('<print '.$attribute.'=dateCreated>','Created: '.date($config['dateFormat'],$r['ti']),$parse);
			break;
		case'datePublished':
			if($r['tis']!=0)
				$parse=str_replace('<print '.$attribute.'=datePublished>','Published: '.date($config['dateFormat'],$r['tis']),$parse);
			else
				$parse=str_replace('<print '.$attribute.'=datePublished>','Published: '.date($config['dateFormat'],$r['ti']),$parse);
			break;
		case'dateEvent':
			$dateEvent='';
			if($r['tis']!=0){
				$dateEvent.='Event Date: '.date($config['dateFormat'],$t['tis']);
				if($r['tie']!=0)
					$dateEvent.=' to '.date($config['dateFormat'],$r['tie']);
			}
			$parse=str_replace('<print '.$attribute.'=dateEvent>',$dateEvent,$parse);
			break;
		case'dateEdited':
			$dateEdited='';
			if($tag->hasAttribute('userRank'))
				$dateEditedRank=$tag->getAttribute('userRank');
			else
				$dateEditedRank=0;
			if($user['rank']>$dateEditedRank){
				if($r['eti']==0)
					$dateEdited='Edited: Never';
				else
					$dateEdited='Edited: '.date($config['dateFormat'],$r['eti']).' by <strong>'.$r['login_user'].'</strong>';
			}
			$parse=preg_replace('%<print '.$attribute.'=dateEdited.+?>%',$dateEdited,$parse,1);
			break;
		case'categories':
			$categories='';
			if($r['category_1']!=''){
				$categories='Category: <a href="'.$view.'/'.str_replace(' ','-',htmlentities($r['category_1'],ENT_QUOTES,'UTF-8')).'">'.htmlentities($r['category_1'],ENT_QUOTES,'UTF-8').'</a>';
				if($r['category_2']!='')
					$categories.=' / <a href="'.$view.'/'.str_replace(' ','-',htmlentities($r['category_1'],ENT_QUOTES,'UTF-8').'/'.htmlentities($r['category_2'],ENT_QUOTES,'UTF-8')).'">'.htmlentities($r['category_2'],ENT_QUOTES,'UTF-8').'</a>';
			}
			$parse=str_replace('<print '.$attribute.'=categories>',$categories,$parse);
			break;
		case'tags':
			if($r['tags']!=''){
				$tags=explode(',',$r['tags']);
				$tagged='';
				foreach($tags as $tag)
					$tagged.='<a href="search/'.htmlentities($tag,ENT_QUOTES,'UTF-8').'">#'.htmlentities($tag,ENT_QUOTES,'UTF-8').'</a> ';
				$parse=str_replace('<print '.$attribute.'=tags>','Tags: '.$tagged,$parse);
			}else
				$parse=str_replace('<print '.$attribute.'=tags>','',$parse);
			break;
		case'avatar':
			if($r['gravatar']!='')
				$avatar='http://gravatar.com/avatar/'.md5($r['gravatar']).'?s=100&amp;d=mm';
			elseif($r['avatar']!=''&&file_exists('media/avatar/'.$r['avatar']))
				$avatar='media/avatar/'.$r['avatar'];
			else
				$avatar='core/images/noavatar.jpg';
			$parse=str_replace('<print '.$attribute.'=avatar>',$avatar,$parse);
			break;
		case'backgroundColor':
			$parse=str_replace('<print '.$attribute.'=backgroundColor>',ltrim($r['backgroundColor'],'#'),$parse);
			break;
		case'cost':
			$cost='';
			if($r['contentType']=='inventory'||$r['contentType']=='service'){
				if($r['options']{0}==1){
					$parse=str_replace('<print '.$attribute.'=cost>',htmlentities($r['cost'],ENT_QUOTES,'UTF-8'),$parse);
					if($r['contentType']=='services'){
						if($r['bookable']==1){
							if(stristr($parse,'<service>')){
								$parse=str_replace('<print content=bookservice>',URL.'bookings/'.$r['id'],$parse);
								$parse=str_replace('<service>','',$parse);
								$parse=str_replace('</service>','',$parse);
								$parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
							}
						}
					}else $parse=preg_replace('~<service>.*?<\/service>~is','',$parse,1);
						if($r['contentType']=='inventory'){
							if(stristr($parse,'<inventory>')){
								$parse=str_replace('<inventory>','',$parse);
								$parse=str_replace('</inventory>','',$parse);
								$parse=preg_replace('~<service>.*?<\/service>~is','',$parse,1);
							}elseif(stristr($parse,'<inventory>')&&$r['contentType']!='inventory')
								$parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
						}else $parse=preg_replace('~<inventory>.*?<\/inventory>~is','',$parse,1);
						$parse=str_replace('<controls>','',$parse);
						$parse=str_replace('</controls>','',$parse);
					}else
						$parse=preg_replace('~<cost>.*?<\/cost>~is','',$parse,1);
				}else
					$parse=preg_replace('~<cost>.*?<\/cost>~is','',$parse,1);
			break;
		case'thumb':
			if($r['thumb']!=''&&file_exists('media/'.$r['thumb']))
				$parse=str_replace('<print '.$attribute.'=thumb>','media/'.$r['thumb'],$parse);
			else
				$parse=str_replace('<print '.$attribute.'=thumb>','core/images/noimage.jpg',$parse);
			break;
		case'file':
			if($r['thumb']!=''&&file_exists('media/'.$r['file']))
				$parse=str_replace('<print '.$attribute.'=file>','media/'.$r['file'],$parse);
			else
				$parse=str_replace('<print '.$attribute.'=file>','core/images/noimage.jpg',$parse);
			break;
		case'notes':
			if($show=='categories'){
				$r['notes']=strip_tags($r['notes']);
				$r['notes']=substr(htmlentities($r['notes'],ENT_QUOTES,'UTF-8'),0,201);
			}
			$parse=str_replace('<print '.$attribute.'=notes>',$r['notes'],$parse);
			break;
		case'social':
			break;
		default:
			if($attribute=='content')
				$parse=str_replace('<print content='.$print.'>',$r[$print],$parse);
			if($attribute=='user'){
				if(isset($user[$print]))
					$parse=str_replace('<print user='.$print.'>',$user[$print],$parse);
			}else{
				$parse=str_replace('<print user='.$print.'>','',$parse);
			}
			if($attribute=='config')
				$parse=str_replace('<print config='.$print.'>',$config[$print],$parse);
	}
}
if($show=='item')
	$item=$parse;
else
	$html=$parse;
