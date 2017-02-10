<?php
require_once realpath('../SEOstats/bootstrap.php');
require'../db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$u=isset($_POST['u'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'u',FILTER_SANITIZE_STRING);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$config=$db->query("SELECT seoKeywords FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
if($t=='menu'){
  $s=$db->prepare("SELECT seoKeywords FROM menu WHERE id=:id");
  $s->execute(array(':id'=>$id));
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $k=$r['seoKeywords'];
}elseif($t=='content'){
  $s=$db->prepare("SELECT seoKeywords FROM content WHERE id=:id");
  $s->execute(array(':id'=>$id));
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $k=$r['seoKeywords'];
}else{
  $k=$config['seoKeywords'];
}
$k=str_replace(',',' ',$k);
use \SEOstats\Services\Google as Google;
$pr=Google::getPageRank($u);
echo'<div class="row">';
  echo'<div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Page Rank:<span id="google-pagerank" class="pull-right">'.$pr.'</span></span></div></div></div>';
$ps=Google::getPagespeedAnalysis($u);
//print_r($pagespeed);echo'<br>';
  echo'<div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Page Speed:<span id="google-pagespeed" class="pull-right">'.$ps.'</span></span></div></div></div>';
$si=Google::getSiteindexTotal($u);
  echo'<div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1">Pages Indexed:<span id="google-indexed" class="pull-right">'.$si.'</span></span></div></div></div>';
$bl=Google::getBacklinksTotal($u);
  echo'<div class="col-xs-12 col-sm-3"><div class="panel panel-default"><div class="panel-body"><span class="text-black" style="font-size:1em">Total Back Links:<span id="google-indexed" class="pull-right">'.$bl.'</span></span></div></div></div>';
echo'</div>';
if($k!=''){
echo'<legend class="control-legend">Keywords used for the below results:<small> '.str_replace($k).'</small></legend>';
echo'<table class="table table-condensed">';
    echo'<thead>';
        echo'<tr>';
            echo'<th class="col-xs-2 text-center">Result Order</th>';
            echo'<th>Site</th>';
        echo'</tr>';
    echo'</thead>';
    echo'<tbody>';
  $serps=Google::getSerps($k);
  $i=1;
  foreach($serps as $seo){
        echo'<tr';if($u==$seo['url'])echo' class="bg-success"';echo'>';
            echo'<td class="text-center">'.$i.'</td>';
            echo'<td><a target="_blank" href="'.$seo['url'].'" rel="nofollow">'.$seo['headline'].'</a></td>';
        echo'</tr>';
    $i++;
  }
    echo'</tbody>';
echo'</table>';
}else{
  echo'<legend class="control-legend">No Keywords provided for Search Results</legend>';
}
