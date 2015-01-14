<?php
$rank=0;
$show='categories';
$status='published';
if($view=='index'){
	preg_match('/<settings itemCount="([\w\W]*?)" contentType="([\w\W]*?)">/',$html,$matches);
	$itemCount=$matches[1];
	if($itemCount==0)$itemCount=10;
	$contentType=$matches[2];
	if($contentType=='all')$contentType='%';
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND contentType NOT LIKE 'message%' AND contentType!='testimonials' AND contentType!='proofs' AND status LIKE :status AND internal!='1' ORDER BY ti DESC LIMIT $itemCount");
	$s->execute(array(':contentType'=>$contentType,':status'=>$status));
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
	if($view=='proofs'){
		$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND cid=:cid ORDER BY ti DESC");
		$s->execute(array(':contentType'=>$view,':cid'=>$user['id']));
	}else{
		$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND status LIKE :status AND internal!='1' ORDER BY ti DESC");
		$s->execute(array(':contentType'=>$view,':status'=>$status));
	}
}
//if($view=='testimonials'){
//	$s=$db->query("SELECT * FROM content WHERE contentType='testimonials'");
//}
if($view=='bookings'){
	$sql=$db->query("SELECT id,contentType,code,title FROM content WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
	if($sql->rowCount()>0){
		$bookable='';
		while($row=$sql->fetch(PDO::FETCH_ASSOC)){
			$bookable.='<option value="'.$row['id'].'"';
			if($id==$row['id']){
				$bookable.=' selected';
			}
			$bookable.='>'.ucfirst($row['contentType']);
			if($row['code']!=''){$bookable.=':'.$row['code'];}
			$bookable.=':'.$row['title'].'</option>';
		}
		$html=str_replace('<serviceoptions>',$bookable,$html);
		$html=str_replace('<bookservices>','',$html);
		$html=str_replace('</bookservices>','',$html);
	}else{
		$html=preg_replace('~<bookservices>.*?<\/bookservices>~is','<input type="hidden" name="service" value="0">',$html,1);
	}
}
if($show=='categories'){
	if(stristr($html,'<settings')){
		$matches=preg_match_all('/<settings items="(.*?)" contenttype="(.*?)">/',$html,$matches);
		$count=$matches[1];
		$html=preg_replace('~<settings.*?>~is','',$html,1);
	}else $count=1;
	$html=str_replace('<print page=notes>',$page['notes'],$html);
	if($config['business'])$html=str_replace('<print content=seoTitle>',$config['business'],$html);
		else $html=str_replace('<print content=seoTitle>',$config['seoTitle'],$html);
	$html=str_replace('<print config=address>',$config['address'],$html);
	$html=str_replace('<print config=suburb>',$config['suburb'],$html);
	$html=str_replace('<print config=state>',$config['state'],$html);
	$html=str_replace('<print config=country>',$config['country'],$html);
	if($config['postcode']!=0)$html=str_replace('<print config=postcode>',$config['postcode'],$html);
		else $html=str_replace('<print config=postcode>','',$html);
	$html=str_replace('<print config=phone>',$config['phone'],$html);
	$html=str_replace('<print config=mobile>',$config['mobile'],$html);
	if(stristr($html,'<loop>')){
		preg_match('/<loop>([\w\W]*?)<\/loop>/',$html,$matches);
		$item=$matches[1];
		$output='';
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$items=$item;
			$items=str_replace('<print content=id>',$r['id'],$items);
			if($view!=$r['contentType'])
				$items=str_replace('<print content=contentType>','<div>'.$r['contentType'].'</div>',$items);
				else $items=str_replace('<print content=contentType>','',$items);
			$items=str_replace('<print content=status>','',$items);
			$items=str_replace('<print content=schemaType>',$r['schemaType'],$items);
			$items=str_replace('<print content=dateCreated>','Created: '.date($config['dateFormat'],$r['ti']),$items);
			if(stristr($items,'<print content=datePublished>')){
				if($r['tis']!=0)$items=str_replace('<print content=datePublished>','Published: '.date($config['dateFormat'],$r['tis']),$items);
					else $items=str_replace('<print content=datePublished>','Published: '.date($config['dateFormat'],$r['ti']),$items);
			}
			if(stristr($items,'<print content=dateEvent>')){
				$dateEvent='';
				if($r['tis']!=0){
					$dateEvent.='Event Date: '.date($config['dateFormat'],$r['tis']);
					if($r['tie']!=0)$dateEvent.=' to '.date($config['dateFormat'],$r['tie']);
				}
				$items=str_replace('<print content=dateEvent>',$dateEvent,$items);
			}
			if(stristr($items,'<print content=categories>')){
				if($r['category_1']!=''){
					$categories='Category: <a href="'.$r['contentType'].'/'.str_replace(' ','-',$r['category_1']).'">'.$r['category_1'].'</a>';
					if($r['category_2']!='')$categories.=' / <a href="'.$r['contentType'].'/'.str_replace(' ','-',$r['category_1'].'/'.$r['category_2']).'">'.$r['category_2'].'</a>';
				}else $categories='';
				$items=str_replace('<print content=categories>',$categories,$items);
			}
			if($r['brand']!='')$items=str_replace('<print content=brand>','Brand: '.$r['brand'],$items);
				else $items=str_replace('<print content=brand>','',$items);
			if(stristr($items,'<print content=tags>')){
				if($r['tags']!=''){
					$tags=explode(',',$r['tags']);
					$tagged='Tags: ';
					foreach($tags as $tag){
						$tagged.='<a href="search/'.str_replace(' ','-',$tag).'">#'.$tag.'</a> ';
					}
					$items=str_replace('<print content=tags>',$tagged,$items);
				}else $items=str_replace('<print content=tags>','',$items);
			}
			$items=str_replace('<print content=name>',$r['name'],$items);
			if($r['contentType']=='testimonials'){
				if($r['email'])$items=str_replace('<print content=avatar>','http://gravatar.com/avatar/'.md5($r['email']).'?s=100&amp;d=mm',$items);
					else $items=str_replace('<print content=avatar>',$noavatar,$items);
			}
			if($r['file']&&file_exists('media/'.$r['file'])){
				$items=str_replace('<print coverimage>','<img src="media/'.$r['file'].'" alt="'.$r['title'].'">',$items);
			}else{
				$items=str_replace('<print content=featuredBackgroundColor>',ltrim($r['featuredBackgroundColor'],'#'),$items);
				if($r['featuredBackgroundColor']==''){
					$items=str_replace('<print coverimage>','<img src="core/images/noimage.jpg" alt="'.$r['title'].'">',$items);
				}else{
					$items=str_replace('<print coverimage>','',$items);
				}
			}
			$items=str_replace('<print content=title>',$r['title'],$items);
			if($r['options']{0}==1){
				$items=str_replace('<cost>','',$items);
				$items=str_replace('</cost>','',$items);
				$items=str_replace('<print content=cost>',$r['cost'],$items);
			}else $items=preg_replace('~<cost>.*?<\/cost>~is','',$items,1);
			$items=str_replace('<print content=notes>',substr(strip_tags($r['notes']),0,201),$items);
			if($r['contentType']=='testimonials'){
				if(stristr($items,'<controls>'))
				$items=preg_replace('~<controls>.*?<\/controls>~is','',$items,1);
				$controls='';
			}else{
				if(stristr($items,'<view>')){
					$items=str_replace('<print content=linktitle>',URL.$r['contentType'].'/'.str_replace(' ','-',$r['title']),$items);
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
					}
				}else $items=preg_replace('~<service>.*?<\/service>~is','',$items,1);
				if($r['contentType']=='inventory'){
					if(stristr($items,'<inventory>')){
						$items=str_replace('<inventory>','',$items);
						$items=str_replace('</inventory>','',$items);
						$items=preg_replace('~<service>.*?<\/service>~is','',$items,1);
					}elseif(stristr($items,'<inventory>')&&$r['contentType']!='inventory'){
						$items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
					}
				}else $items=preg_replace('~<inventory>.*?<\/inventory>~is','',$items,1);
				$items=str_replace('<controls>','',$items);
				$items=str_replace('</controls>','',$items);
			}
			$output.=$items;
		}
		$html=preg_replace('~<loop>.*?<\/loop>~is',$output,$html,1);
		$html=preg_replace('~<item>.*?<\/item>~is','',$html,1);
	}else $html=preg_replace('~<loop>.*?<\/loop>~is','',$html,1);
	$html=preg_replace('~<item>.*?<\/item>~is','',$html,1);
	$html=str_replace('<loop>','',$html);
	$html=str_replace('</loop>','',$html);
	if(stristr($html,'<inc file=')){
		$newDom2=new DOMDocument();
		@$newDom2->loadHTML($html);
		$int=$newDom2->getElementsByTagName('inc');
		foreach($int as $int1){
			$inbed2=$int1->getAttribute('file');
			if($inbed2!='')require $inbed2.'.php';
		}
		preg_match_all('/<loop>([\w\W]*?)<\/loop>/',$html,$matches);
		$item=$matches[1];
	}
}
if($show=='item'){
	$r=$s->fetch(PDO::FETCH_ASSOC);
	preg_match('/<item>([\w\W]*?)<\/item>/',$html,$matches);
	$item=$matches[1];
	$address='';
	if($config['options']{1}==1){
		$address.='<address class="thumbnail item mini-map';
		if($config['options']{7}==1){$address.=' col-md-6';}else{$address.=' col-md-12';}
		$address.='"><div class="content"><h4>'.$config['seoTitle'].'</h4><span class="adr"><span class="street-address" itemprop="streetAddress">'.$config['address'].', '.$config['suburb'].', </span><br><span class="region" itemprop="addressLocality">'.$config['state'].', </span><span class="country-name" itemprop="addressCountry">'.$config['country'].', </span><span class="postal-code" itemprop="postalCode">'.$config['postcode'].'</span></span><br><br><span class="tel" itemprop="telephone">Phone<a href="tel:'.$config['phone'].'">'.$config['phone'].'</a></span><br><br><span class="tel" itemprop="telephone">Mobile<a href="tel:'.$config['mobile'].'">'.$config['mobile'].'</a></span></div></address>';
		$item=str_replace('<print config=address>',$address,$item);
	}
	$item=str_replace('<print config=address>',$address,$item);
	if($r['file']&&file_exists('media/'.$r['file'])){
		$item=str_replace('<print content=image>','<img class="intense" src="media/'.$r['file'].'" data-image="media/'.$r['file'].'" alt="'.$r['title'].'" data-title="'.$r['title'].'" data-caption="'.$r['caption'].'">',$item);
	}else $item=str_replace('<print content=image>','',$item);
	$edit='';
	$item=str_replace('<print content=title>',$r['title'],$item);

//		preg_match_all('/<print[^>]+>/i',$item,$result);
	$doc=new DOMDocument();
	@$doc->loadHTML($item);
	$tags=$doc->getElementsByTagName('print');
	foreach($tags as $tag){
		$print=$tag->getAttribute('content');
//		preg_match_all('/(content)=([^]*)/i',$print,$tag);
		if($print!=''){
			switch($print){
				case'categories':
					$categories='';
					if($r['category_1']!=''){
						$categories='Category: <a href="'.$view.'/'.str_replace(' ','-',$r['category_1']).'">'.$r['category_1'].'</a>';
						if($r['category_2']!=''){
							$categories.=' / <a href="'.$view.'/'.str_replace(' ','-',$r['category_1'].'/'.$r['category_2']).'">'.$r['category_2'].'</a>';
						}
					}
					$item=str_replace('<print content=categories>',$categories,$item);
					break;
				case'tags':
					if($r['tags']!=''){
						$tags=explode(',',$r['tags']);
						$tagged='';
						foreach($tags as$tag){
							$tagged.='<a href="search/'.$tag.'">#'.$tag.'</a> ';
						}
						$item=str_replace('<print content=tags>','Tags: '.$tagged,$item);
					}else{
						$item=str_replace('<print content=brand>','',$item);	
					}
					break;
				case'dateCreated':
					$dateCreated='';
					$dateCreated='Created: '.date($config['dateFormat'],$r['ti']);
					$item=str_replace('<print content=dateCreated>',$dateCreated,$item);
					break;
				case'datePublished':
					$datePublished='';
					if($r['tis']!=0){
						$datePublished='Published: '.date($config['dateFormat'],$r['tis']);
					}else{
						$datePublished='Published: '.date($config['dateFormat'],$r['ti']);
					}
					$item=str_replace('<print content=datePublished>',$datePublished,$item);
					break;
				case'dateEvent':
					$dateEvent='';
					if($r['tis']!=0){
						$dateEvent.='Event Date: '.date($config['dateFormat'],$r['tis']);
						if($r['tie']!=0){
							$dateEvent.=' to '.date($config['dateFormat'],$r['tie']);
						}
					}
					$item=str_replace('<print content=dateEvent>',$dateEvent,$item);
					break;
				case'cost':
					$cost='';
					if($r['options']{0}==1){
						$cost='<aside class="price text-right" itemprop="offerDetails" itemscope 	itemtype="http://schema.org/Offer"><meta itemprop="currency" content="AUD" /><h4 itemprop="price">&#36;'.$r['cost'].'</h4>';
						if($user['rank']<699){
							if($view=='inventory'){
								$cost.=' <button class="btn btn-success btn-xs" onclick="$(\'#cart\').load(\'includes/add_cart.php?id='.$r['id'].'\');">Add to Cart</button>';
							}
							if($view=='services'){
								$cost.=' <a class="btn btn-success btn-xs" href="bookings/'.$r['id'].'">Book Service</a>';
							}
						}
						$cost.='</aside>';
					}
					$item=str_replace('<print content=cost>',$cost,$item);
					break;
				default:
					$item=str_replace('<print content='.$print.'>',$r[$print],$item);
			}
		}
	}
	$authorHTML='';
	if(stristr($item,'<author')&&$view=='article'&&$r['uid']!=0){
		$saD=$db->prepare("SELECT * FROM login WHERE id=:id");
		$saD->execute(array(':id'=>$r['uid']));
		$authorData=$saD->fetch(PDO::FETCH_ASSOC);
		if($saD->rowCount()>0){
			preg_match('/<author>([\w\W]*?)<\/author>/',$item,$matches);
			$authorHTML=$matches[0];
			if(stristr($item,'<print user=avatar>')){
				if($authorData['avatar']&&file_exists('media/'.$authorData['avatar'])){
					$authorHTML=str_replace('<print user=avatar>','media/'.$authorData['avatar'],$authorHTML);
				}elseif($authorData['gravatar']){
					$authorHTML=str_replace('<print user=avatar>','http://www.gravatar.com/avatar/'.md5($authorData['gravatar']).'',$authorHTML);
				}else{
					$authorHTML=str_replace('<print user=avatar>','images/noavatar.jpg',$authorHTML);
				}
			}
			$authorHTML=str_replace('<print user=name>',$authorData['name'],$authorHTML);
			$authorHTML=str_replace('<print user=notes>',$authorData['notes'],$authorHTML);
			if(stristr($item,'<print user=email')) $authorHTML=str_replace('<print user=email>','<a href="mailto:'.$authorData['email'].'"><i class="fa fa-envelope-square fa-2x"></i></a>',$authorHTML);
			if(stristr($item,'<print user=social')){
				$authorSocial='';
				$saS=$db->prepare("SELECT * FROM choices WHERE uid=:uid");
				$saS->execute(array(':uid'=>$r['uid']));
				while($saR=$saS->fetch(PDO::FETCH_ASSOC)){
					$authorSocial.='<a target="_blank" href="'.$saR['url'].'"><i class="fa fa-'.$saR['icon'].' fa-2x"></i></a> ';
				}
				$authorHTML=str_replace('<print user=social>',$authorSocial,$authorHTML);
			}
		}
	}
	$item=preg_replace('~<author>.*?<\/author>~is',$authorHTML,$item,1);
	$seoTitle=$r['title'].' - '.$config['seoTitle'];
	$seoKeywords=$r['keywords'];
	$seoDescription=$r['caption'];
    
	if($view=='article'||$view=='events'||$view=='news'||$view=='proofs'){
		if($user['rank']>699){
			$sc=$db->prepare("SELECT * FROM comments WHERE contentType=:contentType AND rid=:rid ORDER BY ti ASC");
		}else{
			$sc=$db->prepare("SELECT * FROM comments WHERE contentType=:contentType AND rid=:rid AND status!='unapproved' ORDER BY ti ASC");
		}
		$sc->execute(array(':contentType'=>$view,':rid'=>$r['id']));
		if($sc->rowCount()>0){
			$item.='<div id="comments" class="clearfix"><h3>Discussion</h3>';
			while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
				$item.='<div id="l_'.$rc['id'].'" class="media';
				if($rc['status']=='delete')$item.=' danger';
				if($rc['status']=='unapproved')$item.=' warning';
				$item.='">';
				$item.='<div class="media-object pull-left">';
				$su=$db->prepare("SELECT * FROM login WHERE id=:id");
				$su->execute(array(':id'=>$rc['uid']));
				$ru=$su->fetch(PDO::FETCH_ASSOC);
				if($ru['gravatar']!=''){
					$avatar=$ru['gravatar'];
				}elseif($ru['avatar']!=''&&file_exists('files/'.$ru['avatar'])){
					$avatar='files/'.$ru['avatar'];
				}else{
					$avatar='images/noavatar.jpg';
				}
				$item.='<img class="commentavatar img-thumbnail" src="'.$avatar.'">';
				$item.='</div>';
				$item.='<div class="media-body">';
				$item.='<div class="well">';
				$item.='<h5 class="media-heading">Name: '.$rc['name'].'</h5>';
				$item.='<time><small class="text-muted">'.date($config['dateFormat'],$rc['ti']).'</small></time>'.strip_tags($rc['notes']);
				if($user['rank']>699){
					$item.='<div id="controls-'.$rc['id'].'" class="pull-right">';
					$item.='<button id="approve_'.$rc['id'].'" class="btn btn-success btn-xs';if($rc['status']!='unapproved'){$item.=' hidden';}$item.='" onclick="update(\''.$rc['id'].'\',\'comments\',\'status\',\'\')">Approve</button> ';
					$item.='<button class="btn btn-danger btn-xs" onclick="purge(\''.$rc['id'].'\',\'comments\')">Delete</button>';
					$item.='</div>';
				}
				$item.='</div>';
				$item.='</div>';
			}
			$item.='</div>';
		}
		if($r['options']{1}==1||$user['rank']>0){
			$item.='<div class="media">';
				$item.='<div class="media-body col-lg-12 col-md-12 col-sm-12 col-xs-12">';
					$item.='<iframe name="comments" id="comments" class="hidden"></iframe>';
					$item.='<form role="form" target="comments" method="post" action="includes/add_data.php">';
						$item.='<input type="hidden" name="act" value="add_comment">';
						$item.='<input type="hidden" name="rid" value="'.$r['id'].'">';
						$item.='<input type="hidden" name="contentType" value="'.$r['contentType'].'">';
						$item.='<div class="form-group">';
			if($user['rank']>0&&$user['email']!=''){
							$item.='<input type="hidden" name="email" value="'.$user['email'].'">';
			}else{
							$item.='<label for="email" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Email</label>';
							$item.='<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">';
								$item.='<input type="text" class="form-control" name="email" value="" placeholder="Enter an Email..." required>';
							$item.='</div>';
			}
			if($user['rank']>0&&$user['name']!=''){
							$item.='<input type="hidden" name="name" value="'.$user['name'].'">';
			}else{
							$item.='<label for="name" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Name</label><div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7"><input type="text" class="form-control" name="name" value="" placeholder="Enter a Name..." required></div>';
			}
			$item.='<label for="da" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Comment</label><div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7"><textarea id="da" class="form-control" name="da" placeholder="Enter a Comment..." required></textarea></div><label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">&nbsp;</label><div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7"><button class="btn btn-success btn-block">Add Comment</button></div></div></form></div></div>';
		}
		$item.='</div>';
	}
	$item=str_replace('<CONTROLS>','<div class="text-right">More...</div>',$item);
	$html=preg_replace('~<item>.*?<\/item>~is',$item,$html,1);
	$html=preg_replace('~<settings.*?>~is','',$html,1);
	$html=preg_replace('~<loop>.*?<\/loop>~is','',$html,1);
	$html=str_replace('<print page=notes>','',$html);
}
$content.=$html;
