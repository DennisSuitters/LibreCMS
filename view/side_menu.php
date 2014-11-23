<?php
$side_menu=file_get_contents(THEME.'/side_menu.html');
if($view=='article'||$view=='portfolio'||$view=='gallery'||$view=='inventory'||$view=='services'){
	$categories='';
	$sc=$db->prepare("SELECT DISTINCT category_1 FROM content WHERE contentType=:contentType AND category_1!='' AND contentType!='events' AND title!='' AND status LIKE :status ORDER BY category_1 ASC");
	$sc->execute(array(':contentType'=>$view,':status'=>$status));
	if($sc->rowCount()>0){
		$categories='<ul class="well nav sidebar">';
			$categories.='<li>'.ucfirst($view).' Categories</li>';
			$categories.='<li>';
		while($rc=$sc->fetch(PDO::FETCH_ASSOC)){
				$categories.='<ul>';
					$categories.='<li><a href="'.$view.'/'.strtolower(str_replace(' ','-',$rc['category_1'])).'">'.substr($rc['category_1'],0,30);
			if(strlen($r['category_1'])>30){
						$categories.='...';
			}
					$categories.='</a>';
			$scc=$db->prepare("SELECT DISTINCT category_2 FROM content WHERE contentType=:contentType AND category_1=:category_1 AND category_2!='' AND contentType!='events' AND title!='' AND status LIKE :status ORDER BY category_2 ASC");
			$scc->execute(array(':contentType'=>$view,':category_1'=>$rc['category_1'],':status'=>$status));
			if($scc->rowCount()>0){
					$categories.='<ul>';
				while($rcc=$scc->fetch(PDO::FETCH_ASSOC)){
						$categories.='<li><a href="'.$view.'/'.strtolower(str_replace(" ","-",$rc['category_1'].'/'.$rcc['category_2']));
						$categories.='">'.substr($rcc['category_2'],0,30);
					if(strlen($rcc['category_2'])>30){
						$categories.='...';
					}
						$categories.='</a></li>';
				}
					$categories.='</ul>';
			}
				$categories.='</li></ul>';
		}
		$categories.='</li></ul>';
	}
	$side_menu=str_replace('<sideMenu categories>',$categories,$side_menu);
}
$sm=$db->prepare("SELECT id,contentType,schemaType,title,notes,tis,tie,ti FROM content WHERE contentType IN ('events','news') AND status LIKE :status AND internal!='1' AND title!='' ORDER BY ti DESC LIMIT 10");
$sm->execute(array(':status'=>$status));
$categories='';
if($sm->rowCount()>0){
	$categories.='<div class="well sidebar">Events &amp; News';
	while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
		$categories.='<div class="media" itemscope itemtype="http://schema.org/'.$r['schemaType'].'">';
			$categories.='<div class="media-body">';
				$categories.='<h5 class="media-heading" itemprop="headline"><a href="'.$rm['contentType'].'/'.strtolower(str_replace(' ','-',$rm['title'])).'">'.$rm['title'].'</a></h5>';
				$categories.='<meta itemprop="datePublished" content="'.date('Y-m-d',$r['ti']).'"/>';
		if($rm['tis']!=0){
			$start_day=date('dS',$rm['tis']);
			$start_month=date('M',$rm['tis']);
			$start_time=date('H:i',$rm['tis']);
			$categories.='<time class="text-muted"><small>'.$start_day.' '.$start_month.' '.$start_time.'</time>';
			if($rm['tie']!=0){
				$end_day=date('dS',$rm['tie']);
				$end_month=date('M',$rm['tie']);
				$end_time=date('H:i',$rm['tie']);
				$categories.=' &rarr; <time>';
				if($start_day!=$end_day){$categories.=$end_day.' ';}
				if($start_month!=$end_month){$categories.=$end_month.' ';}
				if($start_time!=$end_time){$categories.=$end_time;}
				$categories.='</small></time>';
			}
			$categories.='<br>';
		}else{
			$categories.='<time class="text-muted"><small>'.date($config['dateFormat'],$rm['ti']).'</small></time><br>';
		}
		$rm['notes']=strip_tags($rm['notes']);
		$categories.='<small>'.substr($rm['notes'],0,100).'...</small></div></div>';
	}
	$categories.='</div>';
}
$side_menu=str_replace('<sideMenu events-news>',$categories,$side_menu);
$sm=$db->prepare("SELECT DISTINCT contentType FROM content WHERE contentType IN ('article','portfolio','inventory','services','gallery') AND status LIKE :status AND internal!='1' AND title!='' ORDER BY contentType ASC");
$sm->execute(array(':status'=>$status));
$categories='';
if($sm->rowCount()>0){
	$categories.='<ul class="well nav sidebar">';
	while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
		$categories.='<li>'.ucfirst($rm['contentType']).'<span class="pull-right"><a target="_blank" href="rss/'.$rm['contentType'].'"><i class="fa fa-rss"></i></a></span><ul class="nav">';
		$sm2=$db->prepare("SELECT id,contentType,schemaType,title,category_1,category_2,thumb,file,ti FROM content WHERE contentType=:contentType AND status LIKE :status AND internal!='1' AND contentType!='events' AND contentType!='testimonialis' AND title!='' ORDER BY ti DESC LIMIT 10");
		$sm2->execute(array(':contentType'=>$rm['contentType'],':status'=>$status));
		if($sm2->rowCount()>0){
			while($rm2=$sm2->fetch(PDO::FETCH_ASSOC)){
				if($rm['contentType']=='gallery'){
					if(file_exists('files/'.$rm2['thumb'])){
						$categories.='<li class="gallery" itempscope itemtype="http://schema.org/'.$r['schemaType'].'"><meta itemprop="datePublished" content="'.date('Y-m-d',$r['ti']).'"/><a href="gallery/#'.strtolower(str_replace(' ','-',$rm2['title'])).'"><img class="img-thumbnail" src="files/'.$rm2['thumb'].'"></a></li>';
					}else continue;
				}else{
					$categories.='<li itemscope itemtype="http://schema.org/'.$rm2['schemaType'].'"><meta itemprop="datePublished" content="'.date('Y-m-d',$r['ti']).'"/><a href="'.$rm2['contentType'].'/'.strtolower(str_replace(' ','-',$rm2['title'])).'" itemprop="headline">'.substr($rm2['title'],0,19);
					if(strlen($rm2['title'])>19) $categories.='...';
					$categories.='</a></li>';
				}
			}
			$categories.='</ul></li>';
		}
	}
	$categories.='</ul>';
}
$side_menu=str_replace('<sideMenu content>',$categories,$side_menu);
$side_menu.='</nav>';
$html=str_replace('<inc file=side_menu>',$side_menu,$html);
