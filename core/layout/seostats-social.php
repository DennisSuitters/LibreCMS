<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - SEO Stats for Social
 *
 * seostats-social.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - SEO Stats for Social
 * @package    core/layout/seostats-social.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require_once'..'.DS.'SEOstats'.DS.'bootstrap.php';
$u=isset($_POST['u'])?filter_input(INPUT_POST,'u',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING);
use \SEOstats\Services\Social as Social;
$seostats=new \SEOstats\SEOstats;
if($seostats->setUrl($u)){
  echo Social::getGooglePlusShares().','.Social::getTwitterShares().','.Social::getFacebookShares(3).','.Social::getPinterestShares().','.Social::getLinkedInShares().','.Social::getDeliciousShares().','.Social::getDiggShares().','.Social::getStumbleUponShares();
}
