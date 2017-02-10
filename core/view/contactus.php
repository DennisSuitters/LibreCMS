<?php
if(stristr($html,'<address')){
	$html=str_replace('<print config="address">',$config['address'],$html);
	$html=str_replace('<print config="state">',$config['state'],$html);
	$html=str_replace('<print config="suburb">',$config['suburb'],$html);
	$html=str_replace('<print config="country">',$config['country'],$html);
	$html=str_replace('<print config="postcode">',$config['postcode'],$html);
	$html=str_replace('<print config=phone>',$config['phone'],$html);
	$html=str_replace('<print config="phone">',$config['phone'],$html);
	$html=str_replace('<print config=mobile>',$config['mobile'],$html);
	$html=str_replace('<print config="mobile">',$config['mobile'],$html);
}
$s=$db->prepare("SELECT * FROM choices WHERE contentType='subject' ORDER BY title ASC");
$s->execute();
if($s->rowCount()>0){
	$html=preg_replace('~<subjectText>.*?<\/subjectText>~is','',$html,1);
	$html=str_replace('<subjectSelect>','',$html);
	$html=str_replace('</subjectSelect>','',$html);
	$options='';
	while($r=$s->fetch(PDO::FETCH_ASSOC))$options.='<option value="'.$r['id'].'" role="option">'.$r['title'].'</option>';
	$html=str_replace('<subjectOptions>',$options,$html);
}else{
	$html=preg_replace('~<subjectSelect>.*?<\/subjectSelect>~is','',$html,1);
	$html=str_replace('<subjectText>','',$html);
	$html=str_replace('</subjectText>','',$html);
}
require'core'.DS.'parser.php';
$content.=$html;
