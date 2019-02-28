<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - SEO Stats for Alexa
 *
 * seostats-alexa.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - SEO Stats for Alexa
 * @package    core/layout/seostats-alexa.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
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
