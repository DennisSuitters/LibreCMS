<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - SEO Stats for Google
 *
 * seostats-alexa.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - SEO Stats for Google
 * @package    core/layout/seostats-google.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS', DIRECTORY_SEPARATOR);
require_once realpath('..'.DS.'SEOstats'.DS.'bootstrap.php');
require'..'.DS.'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$u=isset($_POST['u'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$config=$db->query("SELECT seoKeywords FROM `".$prefix."config` WHERE id=1")->fetch(PDO::FETCH_ASSOC);
if($t=='menu'){
  $s=$db->prepare("SELECT seoKeywords FROM `".$prefix."menu` WHERE id=:id");
  $s->execute(array(':id'=>$id));
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $k=$r['seoKeywords'];
}elseif($t=='content'){
  $s=$db->prepare("SELECT seoKeywords FROM `".$prefix."content` WHERE id=:id");
  $s->execute(array(':id'=>$id));
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $k=$r['seoKeywords'];
}else$k=$config['seoKeywords'];
$k=str_replace(',',' ',$k);
use \SEOstats\Services\Google as Google;
$pr=Google::getPageRank($u);
$ps=Google::getPagespeedAnalysis($u);
$si=Google::getSiteindexTotal($u);
$bl=Google::getBacklinksTotal($u);
echo'<div class="row"><div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Page Rank:<span id="google-pagerank" class="pull-right">'.$pr.'</span></span></div></div></div><div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Page Speed:<span id="google-pagespeed" class="pull-right">'.$ps.'</span></span></div></div></div><div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Pages Indexed:<span id="google-indexed" class="pull-right">'.$si.'</span></span></div></div></div><div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1em">Total Back Links:<span id="google-indexed" class="pull-right">'.$bl.'</span></span></div></div></div></div>';
if($k!=''){
echo'<legend class="control-legend">Keywords used for the below results:<small> '.str_replace($k).'</small></legend><table class="table table-condensed"><thead><tr><th class="col-xs-2 text-center">Result Order</th><th>Site</th></tr></thead><tbody>';
$serps=Google::getSerps($k);
$i=1;
foreach($serps as$seo){
  echo'<tr'.($u==$seo['url']?' class="bg-success"':'').'><td class="text-center">'.$i.'</td><td><a target="_blank" href="'.$seo['url'].'" rel="nofollow">'.$seo['headline'].'</a></td></tr>';
  $i++;
}
echo'</tbody></table>';
}else
echo'<legend class="control-legend">No Keywords provided for Search Results</legend>';
