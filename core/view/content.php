<?php
$rank=0;
$show='categories';
$status='published';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
if($view=='index'){
	if(stristr($html,'<settings')){
		preg_match('/<settings items="([\w\W]*?)" contenttype="([\w\W]*?)">/',$html,$matches);
		if(isset($matches[1]))
			$itemCount=$matches[1];
		else $itemCount=$config['itemCount'];
		if($itemCount==0)$itemCount=10;
		if(isset($matches[2])){
			$contentType=$matches[2];
			if($contentType=='all'||$contentType==0)$contentType='%';
		}else $contenType='%';
	}else{
		$itemCount=$config['showItems'];
		$contentType='%';
	}
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType OR contentType LIKE :c2 AND contentType NOT LIKE 'message%' AND contentType!='testimonial%' AND contentType!='proof%' AND status LIKE :status AND internal!='1' ORDER BY ti DESC LIMIT $itemCount");
	$s->execute(array(':contentType'=>$contentType,':c2'=>$contentType.'s',':status'=>$status));
}elseif($view=='search'){
	$search='%';
	if(isset($args[0])){
		$search='%'.str_replace('-',' ',$args[0]).'%';
	}else{
		$search='%'.str_replace('-',' ',filter_input(INPUT_POST,'search',FILTER_SANITIZE_STRING)).'%';
	}
	$s=$db->prepare("SELECT * FROM content WHERE code=:code OR LOWER(brand) LIKE LOWER(:brand) OR LOWER(title) LIKE LOWER(:title) OR LOWER(category_1) LIKE LOWER(:category_1) OR LOWER(category_2) LIKE LOWER(:category_2) OR LOWER(keywords) LIKE LOWER(:keywords) OR LOWER(tags) LIKE LOWER(:tags) OR LOWER(caption) LIKE LOWER(:caption) OR LOWER(notes) LIKE LOWER(:notes) AND contentType NOT LIKE 'message%' AND internal!='1' ORDER BY ti DESC");
	$s->execute(array(':code'=>$search,':brand'=>$search,':category_1'=>$search,':category_2'=>$search,':title'=>$search,':keywords'=>$search,':tags'=>$search,':caption'=>$search,':notes'=>$search));
}elseif($view=='bookings'){
	if(isset($args[0]))$id=(int)$args[0];else $id=0;
}elseif(isset($args[1])){
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND status LIKE :status AND internal!='1' ORDER BY ti DESC");
	$s->execute(array(':contentType'=>$view,':category_1'=>str_replace('-',' ',$args[0]),':category_2'=>str_replace('-',' ',$args[1]),':status'=>$status));
}elseif(isset($args[0])){
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND LOWER(category_1) LIKE LOWER(:category_1) AND status LIKE :status AND internal!='1' ORDER BY ti DESC");
	$s->execute(array(':contentType'=>$view,':category_1'=>str_replace('-',' ',$args[0]),':status'=>$status));
	if($s->rowCount()<1){
		$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND LOWER(title) LIKE LOWER(:title) AND status LIKE :status AND internal!='1' ORDER BY ti DESC");
		$s->execute(array(':contentType'=>$view,':title'=>str_replace('-',' ',$args[0]),':status'=>$status));
		$show='item';
	}
}else{
	if($view=='proofs'||$view=='proof'){
		$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND cid=:cid ORDER BY ti DESC");
		$s->execute(array(':contentType'=>$view,':cid'=>$user['id']));
	}else{
		$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND status LIKE :status AND internal!='1' ORDER BY ti DESC");
		$s->execute(array(':contentType'=>$view,':status'=>$status));
	}
}

if($show=='categories'){
	if(stristr($html,'<settings')){
		$matches=preg_match_all('/<settings items="(.*?)" contenttype="(.*?)">/',$html,$matches);
		$count=$matches[1];
		$html=preg_replace('~<settings.*?>~is','',$html,1);
	}else
		$count=1;
	if(stristr($html,'<print page="cover">')){
		if($page['cover']!=''&&file_exists('media/'.$page['cover']))
			$html=str_replace('<print page="cover">','<img src="media/'.$page['cover'].'">',$html);
		elseif($page['coverURL']!='')
			$html=str_replace('<print page="cover">','<img src="'.$page['coverURL'].'">',$html);
		else
			$html=str_replace('<print page="cover">','',$html);
	}
	$html=str_replace('<print page="cover">','',$html);
	$html=str_replace('<print page="notes">',$page['notes'],$html);
	if($config['business'])
		$html=str_replace('<print content=seoTitle>',htmlentities($config['business'],ENT_QUOTES,'UTF-8'),$html);
	else
		$html=str_replace('<print content=seoTitle>',htmlentities($config['seoTitle'],ENT_QUOTES,'UTF-8'),$html);
	if(stristr($html,'<loop>')){
		preg_match('/<loop>([\w\W]*?)<\/loop>/',$html,$matches);
		$item=$matches[1];
		$output='';
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$items=$item;
			require'core'.DS.'parser.php';
			if($r['contentType']=='testimonials'||$r['contentType']=='testimonial'){
				if(stristr($items,'<controls>'))
					$items=preg_replace('~<controls>.*?<\/controls>~is','',$items,1);
				$controls='';
			}else{
				if(stristr($items,'<view>')){
					$items=str_replace('<print content=linktitle>',URL.$r['contentType'].'/'.str_replace(' ','-',htmlentities($r['title'],ENT_QUOTES,'UTF-8')),$items);
					$items=str_replace('<view>','',$items);
					$items=str_replace('</view>','',$items);
				}
				if($r['contentType']=='services'){
					if($r['bookable']==1){
						if(stristr($items,'<service>')){
							$items=str_replace('<print content=bookservice>',URL.'bookings/'.$r['id'],$items);
							$items=str_replace('<service>','',$items);
							$items=str_replace('</service>','',$items);
							$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
						}
					}else
						$items=preg_replace('~<service.*?>.*?<\/service>~is','',$items,1);
				}else
					$items=preg_replace('~<service>.*?<\/service>~is','',$items,1);
				if($r['contentType']=='inventory'){
					if(stristr($items,'<inventory>')){
						$items=str_replace('<inventory>','',$items);
						$items=str_replace('</inventory>','',$items);
						$items=preg_replace('~<service>.*?<\/service>~is','',$items,1);
					}elseif(stristr($items,'<inventory>')&&$r['contentType']!='inventory')
						$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
				}else
					$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
				$items=str_replace('<controls>','',$items);
				$items=str_replace('</controls>','',$items);
			}
			$output.=$items;
		}
		$html=preg_replace('~<loop>.*?<\/loop>~is',$output,$html,1);
		$html=preg_replace('~<item>.*?<\/item>~is','',$html,1);
	}else
		$html=preg_replace('~<loop>.*?<\/loop>~is','',$html,1);
	$html=preg_replace('~<item>.*?<\/item>~is','',$html,1);
	$html=str_replace('<loop>','',$html);
	$html=str_replace('</loop>','',$html);
}
if($show=='item'){
	$r=$s->fetch(PDO::FETCH_ASSOC);
	$seoTitle=$r['title'].' - '.ucfirst($r['contentType']).' - '.htmlentities($config['seoTitle'],ENT_QUOTES,'UTF-8');
	if($r['caption']!=''){
		$seoDescription=htmlentities($r['caption'],ENT_QUOTES,'UTF-8');
		$seoCaption=htmlentities($r['caption'],ENT_QUOTES,'UTF-8');
	}else{
		$seoDescription=htmlentities(strip_tags($r['caption']),ENT_QUOTES,'UTF-8');
		$seoCaption=htmlentities(strip_tags($r['caption']),ENT_QUOTES,'UTF-8');
	}
	if($r['eti']>$ti)$contentTime=$r['eti'];else$contentTime=$r['ti'];
	$contentTime=$r['eti'];
	$seoKeywords=htmlentities($r['keywords'],ENT_QUOTES,'UTF-8');
	$canonical=URL.$view.'/'.str_replace(' ','-',htmlentities($r['title'],ENT_QUOTES,'UTF-8'));
	preg_match('/<item>([\w\W]*?)<\/item>/',$html,$matches);
	$item=$matches[1];
	$address='';
	$edit='';
	require'core'.DS.'parser.php';
	$authorHTML='';
	$seoTitle=$r['title'].' - '.$config['seoTitle'];
	$seoKeywords=$r['keywords'];
	$seoDescription=$r['caption'];
	$item=str_replace('<CONTROLS>','...more...',$item);
	$html=preg_replace('~<settings.*?>~is','',$html,1);
	$html=preg_replace('~<loop>.*?<\/loop>~is','',$html,1);
	$html=str_replace('<print page="notes">','',$html);
	if($view=='article'||$view=='events'||$view=='news'||$view=='proofs'){
		if(file_exists(THEME.DS.'comments.html')){
			$comments='';
			$commentsHTML='';
			$sc=$db->prepare("SELECT * FROM comments WHERE contentType=:contentType AND rid=:rid AND status!='unapproved' ORDER BY ti ASC");
			$sc->execute(array(':contentType'=>$view,':rid'=>$r['id']));
			$commentsHTML=file_get_contents(THEME.DS.'comments.html');
			if(stristr($commentsHTML,'<print content=id>'))$commentsHTML=str_replace('<print content=id>',$r['id'],$commentsHTML);
			if(stristr($commentsHTML,'<print content=contentType>'))$commentsHTML=str_replace('<print content=contentType>',$r['contentType'],$commentsHTML);
			$commentDOC=new DOMDocument();
			@$commentDOC->loadHTML($commentsHTML);
			preg_match('/<loop>([\w\W]*?)<\/loop>/',$commentsHTML,$matches);
			while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
				$comment=$matches[1];
				require'core'.DS.'parser.php';
				$comments.=$comment;
			}
				$commentsHTML=preg_replace('~<loop>.*?<\/loop>~is',$comments,$commentsHTML,1);
			if($r['options']{1}==1){

			}
			$commentsHTML=preg_replace('~<loop>.*?<\/loop>~is','',$commentsHTML,1);
			$item.=$commentsHTML;
		}else{
			$item.='Comments for this post is Enabled, but no <strong>"'.THEME.DS.'comments.html"</strong> template file exists';
		}
	}
	$html=preg_replace('~<item>.*?<\/item>~is',$item,$html,1);
}
$content.=$html;
