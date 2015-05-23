<?php
$theme=parse_ini_file(THEME.'/theme.ini',true);
if($args[0]=="confirm"){
	include"core/add_order.php";
}else{
	$total=0;
	$s=$db->prepare("SELECT * FROM cart WHERE si=:si ORDER BY ti DESC");
	$s->execute(array(':si'=>SESSIONID));
	preg_match('/<loop>([\w\W]*?)<\/loop>/',$html,$matches);
	$cartloop=$matches[1];
	$cartitems='';
	if($s->rowCount()>0){
		while($ci=$s->fetch(PDO::FETCH_ASSOC)){
			$cartitem=$cartloop;
			$si=$db->prepare("SELECT * FROM content WHERE id=:id");
			$si->execute(array(':id'=>$ci['iid']));
			$i=$si->fetch(PDO::FETCH_ASSOC);
			$cartitem=str_replace('<print content="code">',$i['code'],$cartitem);
			$cartitem=str_replace('<print content="title">',$i['title'],$cartitem);
			$cartitem=str_replace('<print cart=id>',$ci['id'],$cartitem);
			$cartitem=str_replace('<print cart=quantity>',$ci['quantity'],$cartitem);
			$cartitem=str_replace('<print cart=cost>',$ci['cost'],$cartitem);
			$cartitem=str_replace('<print itemscalculate>',$ci['cost']*$ci['quantity'],$cartitem);
			$total=$total+($ci['cost']*$ci['quantity']);
			$cartitems.=$cartitem;
		}
		$html=preg_replace('~<loop>.*?<\/loop>~is',$cartitems,$html,1);
		$total=$total+$ci['postagecost'];
		$html=str_replace('<print totalcalculate>',$total,$html);
	}else{
		$html=preg_replace('~<emptycart>.*?<\/emptycart>~is',$theme['settings']['cart_empty'],$html,1);
	}
}
$content.=$html;
