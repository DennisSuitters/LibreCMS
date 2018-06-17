<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require_once'..'.DS.'SEOstats'.DS.'bootstrap.php';
$u=isset($_POST['u'])?filter_input(INPUT_POST,'u',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING);
use \SEOstats\Services\Social as Social;
$seostats=new \SEOstats\SEOstats;
if($seostats->setUrl($u)){
  echo Social::getGooglePlusShares().','.Social::getTwitterShares().','.Social::getFacebookShares(3).','.Social::getPinterestShares().','.Social::getLinkedInShares().','.Social::getDeliciousShares().','.Social::getDiggShares().','.Social::getStumbleUponShares();
}
