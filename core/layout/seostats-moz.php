<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - SEO Stats for Moz
 *
 * seostats-moz.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - SEO Stats for Alexa
 * @package    core/layout/seostats-moz.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require_once realpath('..'.DS.'SEOstats'.DS.'bootstrap.php');
$u=isset($_POST['u'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING);
use \SEOstats\Services\Mozscape as Mozscape;
$seostats=new \SEOstats\SEOstats;
$seostats->setUrl($u);
$mr=Mozscape::getMozRank();
$lc=Mozscape::getLinkCount();
$el=Mozscape::getEquityLinkCount();
$pa=Mozscape::getPageAuthority();
$da=Mozscape::getDomainAuthority();
echo'<div class="row"><div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Moz Rank:<span id="moz-mozrank" class="pull-right">'.round($mr).'/10</span></span></div></div></div><div class="col-xs-12 col-sm-2"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Link Count:<span id="moz-linkcount" class="pull-right">'.$lc.'</span></span></div></div></div><div class="col-xs-12 col-sm-2"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Equity Links:<span id="moz-eqlinks" class="pull-right">'.$el.'</span></span></div></div></div><div class="col-xs-12 col-sm-2"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Page Authority:<span id="moz-pa" class="pull-right">'.round($pa).'</span></span></div></div></div><div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Domain Authority:<span id="moz-da" class="pull-right">'.round($da).'/100</span></span></div></div></div></div>';
