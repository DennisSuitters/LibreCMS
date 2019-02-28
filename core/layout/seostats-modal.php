<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - SEO Stats Modal
 *
 * seostats-modal.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - SEO Stats Modal
 * @package    core/layout/seostats-modal.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require_once realpath('..'.DS.'SEOstats'.DS.'bootstrap.php');
# require_once realpath(__DIR__ . '/vendor/autoload.php');
$u=$_GET['u'];
use \SEOstats\Services\Google as Google;
$pagerank=Google::getPageRank($u);
echo"The current Google PageRank for {$u} is {$pagerank}.<br>";
$pagespeed = Google::getPagespeedAnalysis($u);
print_r($pagespeed);echo'<br>';
echo'Indexed: ';
print Google::getSiteindexTotal();echo'<br>';
echo'BackLinks: ';
print Google::getBacklinksTotal();echo'<br>';
$serps=Google::getSerps('hosting tasmania');
print_r($serps);echo'<br>';
