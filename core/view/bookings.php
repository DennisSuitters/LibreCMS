<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Bookings Renderer
 *
 * bookings.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Bookings
 * @package    core/view/bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$sql=$db->query("SELECT * FROM `".$prefix."content` WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
if($sql->rowCount()>0){
	$bookable='';
	while($row=$sql->fetch(PDO::FETCH_ASSOC)){
		$bookable.='<option value="'.$row['id'].'" role="option"'.($row['id']==$args[0]?' selected':'').'>'.ucfirst(htmlspecialchars($row['contentType'],ENT_QUOTES,'UTF-8')).($row['code']!=''?':'.htmlspecialchars($row['code'],ENT_QUOTES,'UTF-8'):'').':'.htmlspecialchars($row['title'],ENT_QUOTES,'UTF-8').'</option>';
	}
	$html=str_replace([
		'<serviceoptions>',
		'<bookservices>',
		'</bookservices>'
	],[
		$bookable,
		'',
		''
	],$html);
}else$html=preg_replace('~<bookservices>.*?<\/bookservices>~is','<input type="hidden" name="service" value="0">',$html,1);
$content.=$html;
