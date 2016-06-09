<?php
$content.='<main id="content" class="col-xs-12 col-md-8">';
	$content.='<div class="panel-body">';
$s=$db->query("SELECT DISTINCT contentType FROM content WHERE contentType!='' AND internal!='1' AND status='published' ORDER BY contentType ASC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$content.='<div class="form-group">';
			$content.='<label class="control-label col-xs-4">';
				$content.='<a class="text-right" target="_blank" href="rss/'.$r['contentType'].'"><i class="libre"><svg xmlns="http://www.w3.org/2000/svg" id="libre-social-rss" viewBox="0 0 14 14"><path d="m 4.2550435,11.37618 c 0,0.89683 -0.72699,1.62382 -1.623786,1.62382 -0.896797,0 -1.623816,-0.72699 -1.623816,-1.62382 0,-0.89682 0.727019,-1.62378 1.623816,-1.62378 0.896767,0 1.623786,0.72696 1.623786,1.62378 z m -3.247602,-6.28616 0,2.40562 c 3.021495,0.031 5.473282,2.48284 5.50433,5.50436 l 2.405621,0 C 8.8863125,8.64505 5.3623345,5.1211 1.0074415,5.09002 Z m 0,-1.68414 c 2.554223,0.0111 4.953903,1.01054 6.761214,2.81788 C 9.5795775,8.03462 10.57951,10.44018 10.586733,13 l 2.405826,0 C 12.9775,6.38421 7.6213345,1.02313 1.0074415,1 l 0,2.40588 z"/></svg></i></a> '.ucfirst($r['contentType']);
			$content.='</label>';
			$content.='<div class="input-group col-xs-8">';
	$ss=$db->prepare("SELECT DISTINCT id,title FROM content WHERE contentType=:content_type AND title!='' AND status='published' AND internal!='1' ORDER BY contentType ASC, ord ASC, ti DESC");
	$ss->execute(array(':content_type'=>$r['contentType']));
	while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
				$content.='<a href="'.$r['contentType'].'/'.urlencode(str_replace(' ','-',$rs['title'])).'">'.$rs['title'].'</a><br>';
	}
			$content.='</div>';
		$content.='</div>';
}
	$content.='</div>';
$content.='</main>';
