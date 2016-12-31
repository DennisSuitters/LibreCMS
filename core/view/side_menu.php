<?php
if(file_exists(THEME.$amp.DS.'side_menu.html')){
	$sideTemp=file_get_contents(THEME.$amp.DS.'side_menu.html');
	if($show=='item'&&($view=='service'||$view=='inventory'||$view=='events')){
		$sideCost='';
		if(is_numeric($r['cost'])&&$r['cost']!=0){
			$sideCost='<meta itemprop="priceCurrency" content="AUD">';
			$sideCost.='<span class="cost" itemprop="price" content="'.$r['cost'].'">';
			if(is_numeric($r['cost']))
				$sideCost.='&#36;';
			$sideCost.=htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>';
		}else
			$sideCost='<span>'.htmlspecialchars($r['cost'],ENT_QUOTES,'UTF-8').'</span>';
		$sideTemp=str_replace('<print content="cost">',$sideCost,$sideTemp);
		$sideTemp=str_replace('<print content=id>',$r['id'],$sideTemp);
		$sideQuantity='';
		if($r['contentType']=='inventory'){
			if(is_numeric($r['quantity'])&&$r['quantity']!=0){
				$sideQuantity='<link itemprop="availability" href="http://schema.org/InStock">';
				$sideQuantity.='<div class="quantity">Quantity<br>'.htmlspecialchars($r['quantity'],ENT_QUOTES,'UTF-8').'</div>';
			}elseif(is_numeric($r['quantity'])&&$r['quantity']==0){
				$sideQuantity='<link itemprop="availability" href="http://schema.org/OutOfStock">';
				$sideQuantity.='<div class="quantity">Out of Stock</div>';
			}else$sideQuantity.='<div>Quantity<br>'.htmlspecialchars($r['quantity'],ENT_QUOTES,'UTF-8').'</div>';
			$sideTemp=str_replace('<print content="quantity">',$sideQuantity,$sideTemp);
			if(stristr($sideTemp,'<choices>')){
				$scq=$db->prepare("SELECT * FROM choices WHERE rid=:id ORDER BY title ASC");
				$scq->execute(array(':id'=>$r['id']));
				if($scq->rowCount()>0){
					$choices='<select class="choices form-control" onchange="$(\'.addCart\').data(\'cartchoice\',$(this).val());$(\'.choices\').val($(this).val());"><option value="0">Select an Option</option>';
					while($rcq=$scq->fetch(PDO::FETCH_ASSOC)){
						if($rcq['ti']==0)continue;
						$choices.='<option value="'.$rcq['id'].'">'.$rcq['title'].':'.$rcq['ti'].'</option>';
					}
					$choices.='</select>';
					$sideTemp=str_replace('<choices>',$choices,$sideTemp);
				}else
					$sideTemp=str_replace('<choices>','',$sideTemp);
			}else
				$sideTemp=str_replace('<choices>','',$sideTemp);
		}else
			$sideTemp=str_replace('<print content="quantity">','',$sideTemp);
		if($r['contentType']=='service'||$r['contentType']=='events'){
			if($r['bookable']==1){
				if(stristr($sideTemp,'<service>')){
					$sideTemp=str_replace('<print content=bookservice>',$r['id'],$sideTemp);
					$sideTemp=str_replace('<service>','',$sideTemp);
					$sideTemp=str_replace('</service>','',$sideTemp);
					$sideTemp=preg_replace('~<inventory>.*?<\/inventory>~is','',$sideTemp,1);
				}
			}else
				$sideTemp=preg_replace('~<service.*?>.*?<\/service>~is','',$sideTemp,1);
		}else
			$sideTemp=preg_replace('~<service.*?>.*?<\/service>~is','',$sideTemp,1);
		if($r['contentType']=='inventory'&&is_numeric($r['cost'])){
			if(stristr($sideTemp,'<inventory>')){
				$sideTemp=str_replace('<inventory>','',$sideTemp);
				$sideTemp=str_replace('</inventory>','',$sideTemp);
				$sideTemp=preg_replace('~<service>.*?<\/service>~is','',$sideTemp,1);
			}elseif(stristr($sideTemp,'<inventory>')&&$r['contentType']!='inventory')$sideTemp=preg_replace('~<inventory>.*?<\/inventory>~is','',$sideTemp,1);
		}else$sideTemp=preg_replace('~<inventory>.*?<\/inventory>~is','',$sideTemp,1);
		$sideTemp=str_replace('<controls>','',$sideTemp);
		$sideTemp=str_replace('</controls>','',$sideTemp);
		$sideTemp=str_replace('<review>','',$sideTemp);
		$sideTemp=str_replace('</review>','',$sideTemp);
	}else{
		$sideTemp=preg_replace('/<controls>([\w\W]*?)<\/controls>/','',$sideTemp,1);
		$sideTemp=preg_replace('/<review>([\w\W]*?)<\/review>/','',$sideTemp,1);
	}
	preg_match('/<item>([\w\W]*?)<\/item>/',$sideTemp,$matches);
	$outside=$matches[1];
	$show='';
	$contentType=$view;
	if(stristr($outside,'<heading>')){
		preg_match('/<heading>([\w\W]*?)<\/heading>/',$outside,$matches);
		if($matches[1]!=''){
			$heading=$matches[1];
			$heading=str_replace('<print viewlink>',URL.$view,$heading);
			$heading=str_replace('<print view>',ucfirst($view),$heading);
		}else$heading='';
		$outside=preg_replace('~<heading>.*?<\/heading>~is',$heading,$outside,1);
	}
	if(stristr($sideTemp,'<settings')){
		preg_match('/<settings items="(.*?)" contenttype="(.*?)">/',$outside,$matches);
		if(isset($matches[1])){
			if($matches[1]=='all'||$matches[1]=='')$show='';
			elseif($matches[1]=='limit')$show=' LIMIT '.$config['showItems'];
			else$show=' LIMIT '.$matches[1];
		}else$show='';
		if(isset($matches[2])){
			if($matches[2]=='current')$contentType=strtolower($view);
			if($matches[2]=='all'||$matches[2]==''){$contentType='';$heading='';}
		}else$contentType='';
	}
	$r=$db->query("SELECT * FROM menu WHERE id=17")->fetch(PDO::FETCH_ASSOC);
	if($r['active']{0}==1){
		$sideTemp=str_replace('<newsletters>','',$sideTemp);
		$sideTemp=str_replace('</newsletters>','',$sideTemp);
	}else{
		$sideTemp=preg_replace('/<newsletters>([\w\W]*?)<\/newsletters>/','',$sideTemp,1);
	}
	preg_match('/<items>([\w\W]*?)<\/items>/',$outside,$matches);
	$insides=$matches[1];
	$s=$db->prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND internal!='1' AND status='published' ORDER BY featured DESC, ti DESC $show");
	$s->execute(array(':contentType'=>$contentType));
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		if($r['contentType']=='gallery'){
			preg_match('/<media>([\w\W]*?)<\/media>/',$insides,$matches);
			$inside=$matches[1];
		}else$inside=preg_replace('/<media>([\w\W]*?)<\/media>/','',$insides,1);
		$items=$inside;
		$items=str_replace('<print content=thumb>',$r['thumb'],$items);
		$items=str_replace('<print link>',URL.$r['contentType'].'/'.urlencode(str_replace(' ','-',$r['title'])),$items);
		$items=str_replace('<print content=schematype>',$r['schemaType'],$items);
		$items=str_replace('<print metaDate>',date('Y-m-d',$r['ti']),$items);
		$items=str_replace('<print content=title>',$r['title'],$items);
		$items=str_replace('<print content="title">',$r['title'],$items);
		$time='<time datetime='.date('Y-m-d',$r['ti']).'">'.date($config['dateFormat'],$r['ti']).'</time>';
		if($r['contentType']=='events'||$r['contentType']=='news'){
			if($r['tis']!=0){
				$time='<time datetime="'.date('Y-m-d',$r['tis']).'">'.date('dS M H:i',$r['tis']).'</time>';
				if($r['tie']!=0){
					$time.=' &rarr; <time datetime="'.date('Y-m-d',$r['tie']).'">'.date('dS M H:i',$r['tie']).'</time>';
				}
			}
		}
		$items=str_replace('<print time>',$time,$items);
		if($r['seoCaption']!='')$items=str_replace('<print content="caption">',$r['seoCaption'],$items);
		else$items=str_replace('<print content="caption">',substr(strip_tags($r['notes']),0,100).'...',$items);
		$output.=$items;
	}
	$outside=preg_replace('~<items>.*?<\/items>~is',$output,$outside,1);
	$outside=preg_replace('~<settings.*?>~is','',$outside,1);
	$sideTemp=preg_replace('~<item>.*?<\/item>~is',$outside,$sideTemp,1);
}else$sideTemp='';
$content.=$sideTemp;
