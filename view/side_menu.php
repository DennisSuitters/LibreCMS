<?php
$side_menu=file_get_contents(THEME.'/side_menu.html');
if($view=='article'||$view=='portfolio'||$view=='gallery'||$view=='inventory'||$view=='services'){
	$categories='';
	$sc=$db->prepare("SELECT DISTINCT category_1 FROM content WHERE contentType=:contentType AND category_1!='' AND contentType!='events' AND title!='' AND status LIKE :status ORDER BY category_1 ASC");
	$sc->execute(array(':contentType'=>$view,':status'=>$status));
	if($sc->rowCount()>0){
		$categories.='<div class="list-group">';
			$categories.='<a class="list-group-item" href="'.$view.'"><h4 class="list-group-item-heading">'.ucfirst($view).' Categories</h4></a>';
		while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
			$categories.='<div class="list-group-item">';
				$categories.='<p class="list-group-item-text">';
					$categories.='<h5>';
						$categories.='<a href="'.$view.'/'.strtolower(str_replace(' ','-',$rc['category_1'])).'">'.substr($rc['category_1'],0,30);
			if(strlen($r['category_1'])>30)$categories.='...';
						$categories.='</a>';
					$categories.='</h5>';
			$scc=$db->prepare("SELECT DISTINCT category_2 FROM content WHERE contentType=:contentType AND category_1=:category_1 AND category_2!='' AND contentType!='events' AND title!='' AND status LIKE :status ORDER BY category_2 ASC");
			$scc->execute(array(':contentType'=>$view,':category_1'=>$rc['category_1'],':status'=>$status));
			if($scc->rowCount()>0){
				while($rcc=$scc->fetch(PDO::FETCH_ASSOC)){
					$categories.='<h6 class="margin-left-10">';
						$categories.='<a href="'.$view.'/'.strtolower(str_replace(" ","-",$rc['category_1'].'/'.$rcc['category_2'])).'">'.substr($rcc['category_2'],0,30);
					if(strlen($rcc['category_2'])>30)$categories.='...';
						$categories.='</a>';
					$categories.='</h6>';
				}
			}
				$categories.='</p>';
			$categories.='</div>';
		}
		$categories.='</div>';
	}
	$side_menu=str_replace('<sideMenu categories>',$categories,$side_menu);
}
$sm=$db->prepare("SELECT id,contentType,schemaType,title,notes,tis,tie,ti FROM content WHERE contentType IN ('news') AND status LIKE :status AND internal!='1' AND title!='' ORDER BY ti DESC LIMIT 10");
$sm->execute(array(':status'=>$status));
$categories='';
if($sm->rowCount()>0){
	$categories.='<div class="list-group">';
		$categories.='<a class="list-group-item" href="news"><h4 class="list-group-item-heading">News</h4></a>';
	while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
		$categories.='<a class="list-group-item" href="'.$rm['contentType'].'/'.strtolower(str_replace(' ','-',$rm['title'])).'" itemscope itemtype="http://schema.org/'.$r['schemaType'].'"">';
			$categories.='<h5 class="list-group-item-heading" itemprop="headline">'.$rm['title'].'</h5>';
			$categories.='<meta itemprop="datePublished" content="'.date('Y-m-d',$r['ti']).'"/>';
			$categories.='<p class="list-group-item-text">';
		if($rm['tis']!=0){
			$start_day=date('dS',$rm['tis']);
			$start_month=date('M',$rm['tis']);
			$start_time=date('H:i',$rm['tis']);
				$categories.='<time class="text-muted">';
					$categories.='<small>'.$start_day.' '.$start_month.' '.$start_time.'</small>';
				$categories.='</time>';
			if($rm['tie']!=0){
				$end_day=date('dS',$rm['tie']);
				$end_month=date('M',$rm['tie']);
				$end_time=date('H:i',$rm['tie']);
				$categories.=' &rarr; <time class="text-muted">';
					$categories.='<small>';
				if($start_day!=$end_day)$categories.=$end_day.' ';
				if($start_month!=$end_month)$categories.=$end_month.' ';
				if($start_time!=$end_time)$categories.=$end_time;
					$categories.='</small>';
				$categories.='</time>';
			}
		}else{
				$categories.='<time class="text-muted">';
					$categories.='<small>'.date($config['dateFormat'],$rm['ti']).'</small>';
				$categories.='</time>';
		}
		$rm['notes']=strip_tags($rm['notes']);
				$categories.='<small>'.substr($rm['notes'],0,100).'...</small>';
			$categories.='</p>';
		$categories.='</a>';
	}
	$categories.='</div>';
}
$side_menu=str_replace('<sideMenu news>',$categories,$side_menu);

$sm=$db->prepare("SELECT id,contentType,schemaType,title,notes,tis,tie,ti FROM content WHERE contentType IN ('events') AND status LIKE :status AND internal!='1' AND title!='' ORDER BY ti DESC LIMIT 10");
$sm->execute(array(':status'=>$status));
$categories='';
if($sm->rowCount()>0){
	$categories.='<div class="list-group">';
		$categories.='<a class="list-group-item" href="events"><h4 class="list-group-item-heading">Events</h4></a>';
	while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
		$categories.='<a class="list-group-item" href="'.$rm['contentType'].'/'.strtolower(str_replace(' ','-',$rm['title'])).'" itemscope itemtype="http://schema.org/'.$r['schemaType'].'"">';
			$categories.='<h5 class="list-group-item-heading" itemprop="headline">'.$rm['title'].'</h5>';
			$categories.='<meta itemprop="datePublished" content="'.date('Y-m-d',$r['ti']).'"/>';
			$categories.='<p class="list-group-item-text">';
		if($rm['tis']!=0){
			$start_day=date('dS',$rm['tis']);
			$start_month=date('M',$rm['tis']);
			$start_time=date('H:i',$rm['tis']);
				$categories.='<time class="text-muted">';
					$categories.='<small>'.$start_day.' '.$start_month.' '.$start_time.'</small>';
				$categories.='</time>';
			if($rm['tie']!=0){
				$end_day=date('dS',$rm['tie']);
				$end_month=date('M',$rm['tie']);
				$end_time=date('H:i',$rm['tie']);
				$categories.=' &rarr; <time class="text-muted">';
					$categories.='<small>';
				if($start_day!=$end_day)$categories.=$end_day.' ';
				if($start_month!=$end_month)$categories.=$end_month.' ';
				if($start_time!=$end_time)$categories.=$end_time;
					$categories.='</small>';
				$categories.='</time>';
			}
		}else{
				$categories.='<time class="text-muted">';
					$categories.='<small>'.date($config['dateFormat'],$rm['ti']).'</small>';
				$categories.='</time>';
		}
		$rm['notes']=strip_tags($rm['notes']);
				$categories.='<small>'.substr($rm['notes'],0,100).'...</small>';
			$categories.='</p>';
		$categories.='</a>';
	}
	$categories.='</div>';
}
$side_menu=str_replace('<sideMenu events>',$categories,$side_menu);

$sm=$db->prepare("SELECT DISTINCT contentType FROM content WHERE contentType IN ('article','portfolio','inventory','services','gallery') AND status LIKE :status AND internal!='1' AND title!='' ORDER BY contentType ASC");
$sm->execute(array(':status'=>$status));
$categories='';
if($sm->rowCount()>0){
	$categories.='<div class="list-group">';
		$categories.='<span class="list-group-item"><h4 class="list-group-item-heading">Content</h4></span>';
	while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
		$categories.='<a class="list-group-item" href="'.$rm['contentType'].'">';
//			$categories.='<a class="text-right" target="_blank" href="rss/'.$rm['contentType'].'"><i class="fa fa-rss"></i></a>';
			$categories.='<h4 class="list-group-item-heading">';
				$categories.=ucfirst($rm['contentType']);
			$categories.='</h4>';
		$categories.='</a>';
		$sm2=$db->prepare("SELECT id,contentType,schemaType,title,category_1,category_2,notes,caption,thumb,file,ti FROM content WHERE contentType=:contentType AND status LIKE :status AND internal!='1' AND contentType!='events' AND contentType!='testimonialis' AND title!='' ORDER BY ti DESC LIMIT 10");
		$sm2->execute(array(':contentType'=>$rm['contentType'],':status'=>$status));
		if($sm2->rowCount()>0){
			while($rm2=$sm2->fetch(PDO::FETCH_ASSOC)){
				if($rm['contentType']=='gallery'){
					if(file_exists('media/'.$rm2['file'])){
		$categories.='<a class="list-group-item clearfix" href="'.$rm2['contentType'].'/'.strtolower(str_replace(' ','-',$rm2['title'])).'"  itemscope itemtype="http://schema.org/'.$rm2['schemaType'].'">';
			$categories.='<p class="list-group-item-text">';
				$categories.='<div class="media">';
					$categories.='<span class="media-left"><img class="img-thumbnail side_menu_gallery pull-left" src="media/'.$rm2['thumb'].'"></span>';
					$categories.='<meta itemprop="datePublished" content="'.date('Y-m-d',$r['ti']).'"/>';
					$categories.='<div class="media-body">';
						$categories.='<h5 class="media-heading">'.$rm2['title'].'</h5>';
						if($rm2['caption']){
							$categories.='<small>'.substr($rm2['caption'],0,100);
							if(strlen($rm2['caption'])>100)$categories.='...';
							$categories.='</small>';
						}elseif($rm2['notes']){
							$rm2['notes']=strip_tags($rm2['notes']);
							$categories.='<small>'.substr($rm2['notes'],0,100);
							if(strlen($rm2['notes'])>100)$categories.='...';
							$categories.='</small>';
						}
					$categories.='</div>';
				$categories.='</div>';
			$categories.='</p>';
		$categories.='</a>';
					}else continue;
				}else{
		$categories.='<a class="list-group-item" href="'.$rm2['contentType'].'/'.strtolower(str_replace(' ','-',$rm2['title'])).'"  itemscope itemtype="http://schema.org/'.$rm2['schemaType'].'">';
			$categories.='<p class="list-group-item-text">';
				$categories.='<meta itemprop="datePublished" content="'.date('Y-m-d',$r['ti']).'"/>';
				$categories.='<small>'.substr($rm2['title'],0,19).'</small>';
					if(strlen($rm2['title'])>19)$categories.='...';
			$categories.='</p>';
		$categories.='</a>';
				}
			}
		}
	}
	$categories.='</div>';
}
$side_menu=str_replace('<sideMenu content>',$categories,$side_menu);
$side_menu.='</nav>';
$html=str_replace('<inc file=side_menu>',$side_menu,$html);
