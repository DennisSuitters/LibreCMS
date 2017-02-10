<?php
require_once('../SEOstats/bootstrap.php');
$u=isset($_POST['u'])?filter_input(INPUT_POST,'u',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING);
use \SEOstats\Services\Social as Social;
$seostats=new \SEOstats\SEOstats;
if($seostats->setUrl($u)){
  echo Social::getGooglePlusShares().','.Social::getTwitterShares().','.Social::getFacebookShares(3).','.Social::getPinterestShares().','.Social::getLinkedInShares().','.Social::getDeliciousShares().','.Social::getDiggShares().','.Social::getStumbleUponShares();
}
