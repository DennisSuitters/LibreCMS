<?php
$rank=0;
$show='categories';
$status='published';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$itemCount=$config['showItems'];
if($view=='index'){
	if(stristr($html,'<settings')){
		preg_match('/<settings items="([\w\W]*?)" contenttype="([\w\W]*?)">/',$html,$matches);
		if(isset($matches[1]))$itemCount=$matches[1];else$itemCount=$config['itemCount'];
		if($itemCount==0)$itemCount=10;
		if(isset($matches[2])){
			$contentType=$matches[2];
			if($contentType=='all'||$contentType=='')$contentType='%';
		}else$contenType='%';
	}else{
		$itemCount=$config['showItems'];
		$contentType='%';
	}
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND contentType NOT LIKE 'message%' AND contentType NOT LIKE 'testimonial%' AND contentType NOT LIKE 'proof%' AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY featured DESC, ti DESC LIMIT $itemCount");
	$s->execute(array(':contentType'=>$contentType.'%',':status'=>$status,':ti'=>time()));
}elseif($view=='search'){
	$search='%';
	if(isset($args[0]))$search='%'.html_entity_decode(str_replace('-',' ',$args[0])).'%';else$search='%'.html_entity_decode(str_replace('-',' ',filter_input(INPUT_POST,'search',FILTER_SANITIZE_STRING))).'%';
	$s=$db->prepare("SELECT * FROM content WHERE code=:code OR LOWER(brand) LIKE LOWER(:brand) OR LOWER(title) LIKE LOWER(:title) OR LOWER(category_1) LIKE LOWER(:category_1) OR LOWER(category_2) LIKE LOWER(:category_2) OR LOWER(seoKeywords) LIKE LOWER(:keywords) OR LOWER(tags) LIKE LOWER(:tags) OR LOWER(seoCaption) LIKE LOWER(:caption) OR LOWER(seoDescription) LIKE LOWER(:description) OR LOWER(notes) LIKE LOWER(:notes) AND contentType NOT LIKE 'message%' AND internal!='1' AND pti < :ti ORDER BY ti DESC");
	$s->execute(array(':code'=>$search,':brand'=>$search,':category_1'=>$search,':category_2'=>$search,':title'=>$search,':keywords'=>$search,':tags'=>$search,':caption'=>$search,':description'=>$search,':notes'=>$search,':ti'=>$ti));
}elseif($view=='bookings'){
	if(isset($args[0]))$id=(int)$args[0];else$id=0;
}elseif(isset($args[1])&&strlen($args[1])==2){
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND ti < :ti ORDER BY ti ASC");
	$s->execute(array(':contentType'=>$view.'%',':ti'=>DateTime::createFromFormat('!d/m/Y', '01/'.$args[1].'/'.$args[0])->getTimestamp()));
	$show='categories';
}elseif(isset($args[0])&&strlen($args[0])==4){
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND ti>:ti ORDER BY ti ASC");
	$tim=strtotime('01-Jan-'.$args[0]);
	$s->execute(array(':contentType'=>$view.'%',':ti'=>DateTime::createFromFormat('!d/m/Y', '01/01/'.$args[0])->getTimestamp()));
	$show='categories';
}elseif(isset($args[1])){
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
	$s->execute(array(':contentType'=>$view,':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),':category_2'=>html_entity_decode(str_replace('-',' ',$args[1])),':status'=>$status,':ti'=>time()));
}elseif(isset($args[0])){
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND LOWER(category_1) LIKE LOWER(:category_1) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
	$s->execute(array(':contentType'=>$view.'%',':category_1'=>html_entity_decode(str_replace('-',' ',$args[0])),':status'=>$status,':ti'=>time()));
	if($s->rowCount()<1){
		if($view=='proofs'||$view=='proof'){
			$status='%';
			if($_SESSION['loggedin']==false)die();
		}
		$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND LOWER(title) LIKE LOWER(:title) AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC");
		$s->execute(array(':contentType'=>$view.'%',':title'=>html_entity_decode(str_replace('-',' ',$args[0])),':status'=>$status,':ti'=>time()));
		$show='item';
	}
}else{
	if($view=='proofs'||$view=='proof'){
		if(isset($_SESSION['uid'])&&$_SESSION['uid']!=0){
			$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE 'proof%' AND cid=:cid ORDER BY ti DESC");
			$s->execute(array(':cid'=>$_SESSION['uid']));
		}
	}else{
		$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND status LIKE :status AND internal!='1' AND pti < :ti ORDER BY ti DESC LIMIT $itemCount");
		$s->execute(array(':contentType'=>$view,':status'=>$status,':ti'=>time()));
	}
}
if($show=='categories'){
	$contentType=$view;
	if(stristr($html,'<settings')){
		$matches=preg_match_all('/<settings items="(.*?)" contenttype="(.*?)">/',$html,$matches);
		$count=$matches[1];
		$html=preg_replace('~<settings.*?>~is','',$html,1);
	}else$count=1;
	if(stristr($html,'<print page="cover"')){
		if($page['cover']!=''||$page['coverURL']!=''){
			$cover=basename($page['cover']);
			$coverHTML='<img src="';
			if(file_exists('media'.DS.$cover))$cover='media'.DS.$page['cover'];elseif($page['coverURL']!='')$cover=$page['coverURL'];
			$coverHTML.='" alt="';
			if($page['attributionImageTitle']==''&&$page['attributionImageName']==''&&$page['attributionImageURL']==''){
				if($page['attributionImageTitle']){
					$cover.=$page['attributionImageTitle'];
					if($page['attributionImageName'])$cover.=' - ';
				}
				if($page['attributionImageName']){
					$cover.=$page['attributionImageName'];
					if($page['attributionImageURL'])$cover.=' - ';
				}
				if($page['attributionImageURL'])$cover.=$page['attributionImageURL'];
			}else{
				if($page['seoTitle'])$cover.=$page['seoTitle'];else$config['seoTitle'];
			}
			if($page['seoTitle']==''&&$config['seoTitle']=='')$cover.=basename($page['cover']);
				$cover.='">';
		}else$cover='';
		$html=str_replace('<print page="cover">',$cover,$html);
	}
	$html=str_replace('<print page="notes">',$page['notes'],$html);
	if($config['business'])$html=str_replace('<print content=seoTitle>',htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),$html);else$html=str_replace('<print content=seoTitle>',htmlspecialchars($config['seoTitle'],ENT_QUOTES,'UTF-8'),$html);
	if(stristr($html,'<items>')){
		preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
		$item=$matches[1];
		$output='';
		$si=1;
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$items=$item;
			$contentType=$r['contentType'];
			if($si==1){
				$filechk=basename($r['file']);
				$thumbchk=basename($r['thumb']);
				if($r['file']!=''&&file_exists('media'.DS.$filechk)){
					$shareImage=$r['file'];
					$si++;
				}elseif($r['thumb']!=''&&file_exists('media'.DS.$thumbchk)){
					$shareImage=$r['thumb'];
					$si++;
				}
			}
			$r['notes']=strip_tags($r['notes']);
			require'core'.DS.'parser.php';
			if($r['contentType']=='testimonials'||$r['contentType']=='testimonial'){
				if(stristr($items,'<controls>'))$items=preg_replace('~<controls>.*?<\/controls>~is','',$items,1);
				$controls='';
			}else{
				if(stristr($items,'<view>')){
					$items=str_replace('<print content=linktitle>',URL.$r['contentType'].'/'.urlencode(str_replace(' ','-',$r['title'])),$items);
					$items=str_replace('<view>','',$items);
					$items=str_replace('</view>','',$items);
				}
				if($r['contentType']=='service'){
					if($r['bookable']==1){
						if(stristr($items,'<service>')){
							$items=str_replace('<print content=bookservice>',URL.'bookings/'.$r['id'],$items);
							$items=str_replace('<service>','',$items);
							$items=str_replace('</service>','',$items);
							$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
						}
					}else$items=preg_replace('~<service.*?>.*?<\/service>~is','',$items,1);
				}else$items=preg_replace('~<service>.*?<\/service>~is','',$items,1);
				if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
					if(stristr($items,'<inventory>')){
						$items=str_replace('<inventory>','',$items);
						$items=str_replace('</inventory>','',$items);
						$items=preg_replace('~<service>.*?<\/service>~is','',$items,1);
					}elseif(stristr($items,'<inventory>')&&$r['contentType']!='inventory'&&!is_numeric($r['cost']))$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
				}else$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
				$items=str_replace('<controls>','',$items);
				$items=str_replace('</controls>','',$items);
			}
			$output.=$items;
		}
		$html=preg_replace('~<items>.*?<\/items>~is',$output,$html,1);
		$html=preg_replace('~<item>.*?<\/item>~is','',$html,1);
	}else$html=preg_replace('~<items>.*?<\/items>~is','',$html,1);
	$html=preg_replace('~<item>.*?<\/item>~is','',$html,1);
	$html=str_replace('<items>','',$html);
	$html=str_replace('</items>','',$html);
	if(stristr($html,'<more')){
		if($s->rowCount()<$config['showItems']){
			$html=preg_replace('~<more>.*?<\/more>~is','',$html,1);
		}else{
			$html=str_replace('<more>','',$html);
			$html=str_replace('</more>','',$html);
			$html=str_replace('<print view>',$view,$html);
			$html=str_replace('<print contentType>',$contentType,$html);
			$html=str_replace('<print config=showItems>',$config['showItems'],$html);
		}
	}
}
if($show=='item'){
	$r=$s->fetch(PDO::FETCH_ASSOC);
	$su=$db->prepare("UPDATE content SET views=:views WHERE id=:id");
	$su->execute(array(':views'=>$r['views']+1,':id'=>$r['id']));
	if($r['file']!='')
		$shareImage=$r['file'];
	elseif($r['thumb']!='')
		$shareImage=$r['thumb'];
	$seoTitle=$r['title'].' - '.ucfirst($r['contentType']).' - '.htmlspecialchars($config['seoTitle'],ENT_QUOTES,'UTF-8');
	if($r['seoCaption'])$seoCaption=htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8');elseif($page['seoCaption'])$seoCaption=htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8');else$seoCaption=htmlspecialchars($config['seoCaption'],ENT_QUOTES,'UTF-8');
	if($r['seoDescription'])$seoDescription=htmlspecialchars($r['seoDescription'],ENT_QUOTES,'UTF-8');
elseif($page['seoDescription'])$seoDescription=htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8');else$seoDescription=htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8');
	if($r['seoKeywords'])$seoKeywords=htmlspecialchars($r['seoKeywords'],ENT_QUOTES,'UTF-8');elseif($page['seoKeywords'])$seoKeywords=htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8');else$seoKeywords=htmlspecialchars($config['seoKeywords'],ENT_QUOTES,'UTF-8');
	$canonical=URL.$view.'/'.urlencode(str_replace(' ','-',$r['title']));
	if($r['eti']>$r['ti'])$contentTime=$r['eti'];else$contentTime=$r['ti'];
	preg_match('/<item>([\w\W]*?)<\/item>/',$html,$matches);
	$item=$matches[1];
	if($r['contentType']=='service'){
		if($r['bookable']==1){
			if(stristr($item,'<service>')){
				$item=str_replace('<print content=bookservice>',URL.'bookings/'.$r['id'],$item);
				$item=str_replace('<service>','',$item);
				$item=str_replace('</service>','',$item);
				$item=preg_replace('~<inventory>.*?<\/inventory>~is','',$item,1);
			}
		}else$item=preg_replace('~<service.*?>.*?<\/service>~is','',$item,1);
	}else$item=preg_replace('~<service>.*?<\/service>~is','',$item,1);
	$address='';
	$edit='';
	$contentQuantity='';
	if($r['contentType']=='inventory'){
		if(is_numeric($r['quantity'])&&$r['quantity']!=0){
			$contentQuantity='<link itemprop="availability" href="http://schema.org/InStock">';
			$contentQuantity.='<div class="quantity">Quantity<br>'.htmlspecialchars($r['quantity'],ENT_QUOTES,'UTF-8').'</div>';
		}elseif(is_numeric($r['quantity'])&&$r['quantity']==0){
			$contentQuantity='<link itemprop="availability" href="http://schema.org/OutOfStock">';
			$contentQuantity.='<div class="quantity">Out of Stock</div>';
		}else$contentQuantity.='<div class="quantity">Quantity<br>'.htmlspecialchars($r['quantity'],ENT_QUOTES,'UTF-8').'</div>';
		$item=str_replace('<print content="quantity">',$contentQuantity,$item);
	}else
		$item=str_replace('<print content="quantity">','',$item);
	require'core'.DS.'parser.php';
	$authorHTML='';
	$seoTitle=$r['title'].' - '.$config['seoTitle'];
	if($r['contentType']=='article'||$r['contentType']=='portfolio')$item=preg_replace('~<controls>.*?<\/controls>~is','',$item,1);
	$html=preg_replace('~<settings.*?>~is','',$html,1);
	$html=preg_replace('~<items>.*?<\/items>~is','',$html,1);
	$html=preg_replace('~<more>.*?<\/more>~is','',$html,1);
	$html=str_replace('<print page="notes">','',$html);
/* Comments */
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
			preg_match('/<items>([\w\W]*?)<\/items>/',$commentsHTML,$matches);
			while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
				$comment=$matches[1];
				require'core'.DS.'parser.php';
				$comments.=$comment;
			}
			$commentsHTML=preg_replace('~<items>.*?<\/items>~is',$comments,$commentsHTML,1);
			if($r['options']{1}==1){
				$commentsHTML=str_replace('<comment>','',$commentsHTML);
				$commentsHTML=str_replace('</comment>','',$commentsHTML);
			}else$commentsHTML=preg_replace('~<comment>.*?<\/comment>~is','',$commentsHTML,1);
			$commentsHTML=preg_replace('~<items>.*?<\/items>~is','',$commentsHTML,1);
			$item.=$commentsHTML;
		}else$item.='Comments for this post is Enabled, but no <strong>"'.THEME.DS.'comments.html"</strong> template file exists';
	}
	$html=preg_replace('~<item>.*?<\/item>~is',$item,$html,1);
}
$content.=$html;
