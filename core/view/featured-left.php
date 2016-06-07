<?php
if(stristr($html,'<categories')){
	preg_match('/<categories>([\w\W]*?)<\/categories>/',$html,$matches);
	$cat=$matches[1];
	$s=$db->prepare("SELECT DISTINCT category_1 FROM content WHERE contentType LIKE 'inventory' AND internal!='1' AND status='published' ORDER BY category_1 ASC");
	$s->execute();
	$output='';
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$cat;
		$items=str_replace('<print content=link>',URL.'inventory/'.urlencode(str_replace(' ','-',$r['category_1'])),$items);
        $items=str_replace('<print content="category_1">',$r['category_1'],$items);
		$output.=$items;
	}
	$cats=preg_replace('~<categories>.*?<\/categories>~is',$output,$html,1);
}else$cats='';
$content.=$cats;
