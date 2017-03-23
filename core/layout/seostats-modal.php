<?php
require_once realpath('../SEOstats/bootstrap.php');
# require_once realpath(__DIR__ . '/vendor/autoload.php');
$u=$_GET['u'];
use \SEOstats\Services\Google as Google;
$pagerank = Google::getPageRank($u);
echo "The current Google PageRank for {$u} is {$pagerank}.<br>";
$pagespeed = Google::getPagespeedAnalysis($u);
print_r($pagespeed);echo'<br>';
echo'Indexed: ';
print Google::getSiteindexTotal();echo'<br>';
echo'BackLinks: ';
print Google::getBacklinksTotal();echo'<br>';

    $serps = Google::getSerps('hosting tasmania');
    print_r($serps);
    echo'<br>';

