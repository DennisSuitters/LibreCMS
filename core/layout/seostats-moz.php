<?php
require_once realpath('../SEOstats/bootstrap.php');
$u=isset($_POST['u'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING);
use \SEOstats\Services\Mozscape as Mozscape;
$seostats=new \SEOstats\SEOstats;
$seostats->setUrl($u);
$mr=Mozscape::getMozRank();
echo'<div class="row">';
  echo'<div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Moz Rank:<span id="moz-mozrank" class="pull-right">'.round($mr).'/10</span></span></div></div></div>';
//$mozrankRaw = Mozscape::getMozRankRaw();
//echo "The current (raw) URL MozRank for {$url} is {$mozrankRaw}.<br>";
// The number of links (equity or nonequity or not, internal or external) to the URL.
$lc=Mozscape::getLinkCount();
  echo'<div class="col-xs-12 col-sm-2"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Link Count:<span id="moz-linkcount" class="pull-right">'.$lc.'</span></span></div></div></div>';
// The number of external equity links to the URL (http://apiwiki.moz.com/glossary#equity).
$el=Mozscape::getEquityLinkCount();
  echo'<div class="col-xs-12 col-sm-2"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Equity Links:<span id="moz-eqlinks" class="pull-right">'.$el.'</span></span></div></div></div>';
// A normalized 100-point score representing the likelihood
// of the URL to rank well in search engine results.
$pa=Mozscape::getPageAuthority();
  echo'<div class="col-xs-12 col-sm-2"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Page Authority:<span id="moz-pa" class="pull-right">'.round($pa).'</span></span></div></div></div>';
// A normalized 100-point score representing the likelihood
// of the domain of the URL to rank well in search engine results.
$da=Mozscape::getDomainAuthority();
  echo'<div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Domain Authority:<span id="moz-da" class="pull-right">'.round($da).'/100</span></span></div></div></div>';
echo'</div>';
