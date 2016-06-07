<?php
$content.='<main id="content" class="col-md-9 no-padding"><div class="panel-body">';
$s=$db->query("SELECT DISTINCT contentType FROM content WHERE contentType!='' AND internal!='1' AND status='published' ORDER BY contentType ASC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	$content.='<div class="form-group"><label class="control-label col-sm-2"><a class="text-right" target="_blank" href="rss/'.$r['contentType'].'"><i class="fa fa-rss"></i></a> '.ucfirst($r['contentType']).'</label><div class="input-group col-sm-10">';
	$ss=$db->prepare("SELECT DISTINCT id,title FROM content WHERE contentType=:content_type AND title!='' AND status='published' AND internal!='1' ORDER BY contentType ASC, ord ASC, ti DESC");
	$ss->execute(array(':content_type'=>$r['contentType']));
	while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
		$content.='<a href="'.$r['contentType'].'/'.urlencode(str_replace(' ','-',$rs['title'])).'">'.$rs['title'].'</a><br>';
	}
	$content.='</div></div>';
}
$content.='</div></main>';
