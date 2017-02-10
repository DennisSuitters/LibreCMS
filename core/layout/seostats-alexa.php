<?php
require_once realpath('../SEOstats/bootstrap.php');
$u=isset($_POST['u'])?filter_input(INPUT_POST,'u',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING);
use \SEOstats\Services\Alexa as Alexa;
$seostats=new \SEOstats\SEOstats;
$seostats->setUrl($u);
echo'<div class="row">';
$gr=Alexa::getGlobalRank();
  echo'<div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Global Rank:<span id="alexa-gr" class="pull-right">'.$gr.'</span></span></div></div></div>';
$cr=Alexa::getCountryRank();
  echo'<div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Country Rank:<span id="alexa-cr" class="pull-right">';if(is_array($cr))echo$cr['rank'].' (in '.$cr['country'].")";else echo$cr;echo'</span></span></div></div></div>';
$bl=Alexa::getBacklinkCount();
  echo'<div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Back Links:<span id="moz-da" class="pull-right">'.$bl.'</span></span></div></div></div>';
$plt=Alexa::getPageLoadTime();
  echo'<div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Page Load Time:<span id="moz-da" class="pull-right">'.$plt.'</span></span></div></div></div>';
echo'</div>';
