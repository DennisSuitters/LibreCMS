<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
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
