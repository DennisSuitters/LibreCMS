<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require_once realpath('..'.DS.'SEOstats'.DS.'bootstrap.php');
$u=isset($_POST['u'])?filter_input(INPUT_POST,'u',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING);
use \SEOstats\Services\Alexa as Alexa;
$seostats=new \SEOstats\SEOstats;
$seostats->setUrl($u);
$gr=Alexa::getGlobalRank();
$cr=Alexa::getCountryRank();
$bl=Alexa::getBacklinkCount();
$plt=Alexa::getPageLoadTime();
echo'<div class="row"><div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Global Rank:<span id="alexa-gr" class="pull-right">'.$gr.'</span></span></div></div></div><div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Country Rank:<span id="alexa-cr" class="pull-right">'.(is_array($cr)?$cr['rank'].' (in '.$cr['country'].')':$cr).'</span></span></div></div></div><div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Back Links:<span id="moz-da" class="pull-right">'.$bl.'</span></span></div></div></div><div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Page Load Time:<span id="moz-da" class="pull-right">'.$plt.'</span></span></div></div></div></div>';
