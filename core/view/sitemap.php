<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Sitemap Renderer
 *
 * sitemap.php version 2.0.1
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Sitemap
 * @package    core/view/sitemap.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.1
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes		 v2.0.1 Add Sluggification
 * @changes    v2.0.3 Remove unnecessary nested DB Query
 */
$html=preg_replace([
	'/<print page=[\"\']?notes[\"\']?>/'
],[
	rawurldecode($page['notes'])
],$html);
preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
$item=$matches[1];
$s=$db->query("SELECT * FROM `".$prefix."content` WHERE contentType!='' AND internal!='1' AND status='published' ORDER BY contentType ASC, ti DESC");
$items=$sitemapitems='';
if($s->rowCount()>0){
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$items=$item;
		$sitemaplinks='';
		$items=preg_replace('/<print content=[\"\']?contentType[\"\']?>/',ucfirst($r['contentType']),$items);
		$sitemaplinks.='<a href="'.$r['contentType'].'/'.$r['urlSlug'].'">'.htmlspecialchars($r['title'],ENT_QUOTES,'UTF-8').'</a><br>';
		$items=preg_replace([
			'/<print links>/',
		],[
			$sitemaplinks,
		],$items);
		$sitemapitems.=$items;
	}
}
$html=preg_replace('~<items>.*?<\/items>~is',$sitemapitems,$html,1);
$content.=$html;
