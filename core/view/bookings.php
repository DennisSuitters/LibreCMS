<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$sql=$db->query("SELECT * FROM `".$prefix."content` WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
if($sql->rowCount()>0){
	$bookable='';
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$bookable.='<option value="'.$row['id'].'" role="option"'.($row['id']==$args[0]?' selected':'').'>'.ucfirst(htmlspecialchars($row['contentType'],ENT_QUOTES,'UTF-8')).($row['code']!=''?':'.htmlspecialchars($row['code'],ENT_QUOTES,'UTF-8'):'').':'.htmlspecialchars($row['title'],ENT_QUOTES,'UTF-8').'</option>';
	}
	$html=str_replace(
		array(
			'<serviceoptions>',
			'<bookservices>',
			'</bookservices>'
		),
		array(
			$bookable,
			'',
			''
		),
		$html
	);
}else
	$html=preg_replace('~<bookservices>.*?<\/bookservices>~is','<input type="hidden" name="service" value="0">',$html,1);
$content.=$html;
