<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_dashboard.php';
else{?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <?php if($help['dashboard_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['dashboard_text'].'" data-tooltip="tooltip" data-placement="left" title="Read Text Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['dashboard_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['dashboard_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger">Javascript MUST BE ENABLED for LibreCMS to function correctly!</div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none">The Administration works better on larger displays, such as Laptop or Desktop screen sizes. On smaller screens some Elements may be truncated or cut off, making usage difficult.</div>
<?php echo$config['maintenance']{0}==1?'<div class="alert alert-info" role="alert">Note: Site is currently in <a href="'.URL.$settings['system']['admin'].'/preferences/interface#maintenance">Maintenance Mode</a></div>':'';
    if(!file_exists('layout'.DS.$config['theme'].DS.'theme.ini'))
      echo'<div class="alert alert-danger" role="alert">A Website Theme has not been set.</div>';
    $tid=$ti-2592000;
    if($config['backup_ti']<$tid)
      echo$config['backup_ti']==0?'<div class="alert alert-info" role="alert">A <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/database">Backup</a> has yet to be performed.</div>':'';
    else
      echo'<div class="alert alert-danger" role="alert">It has been more than 30 days since a <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/database">Backup</a> has been performed.</div>';
    echo$config['business']==''?'<div class="alert alert-danger" role="alert">The <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/contact#business">Business Name</a> has not been set. Some functions such as Messages, and Bookings will NOT function correctly.</div>':'';
    echo$config['email']==''?'<div class="alert alert-danger" role="alert">The <a class="alert-link"   href="'.URL.$settings['system']['admin'].'/preferences/contact#email">Email</a> has not been set. Some functions such as Messages, and Bookings will NOT function correctly.</div>':'';?>
    <div class="row">
      <div class="col-sm-6">
        <div class="row">
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-chrome">0</span> Views</div>
              <small>Chrome</small>
              <div class="browser"><?php svg('libre-browser-chrome','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-edge">0</span> Views</div>
              <small>Edge</small>
              <div class="browser"><?php svg('libre-browser-edge','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-explorer">0</span> Views</div>
              <small>Explorer</small>
              <div class="browser"><?php svg('libre-browser-explorer','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-firefox">0</span> Views</div>
              <small>Firefox</small>
              <div class="browser"><?php svg('libre-browser-firefox','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-opera">0</span> Views</div>
              <small>Opera</small>
              <div class="browser"><?php svg('libre-browser-opera','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-safari">0</span> Views</div>
              <small>Safari</small>
              <div class="browser"><?php svg('libre-browser-safari','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-alexa">0</span> Views</div>
              <small>Alexa</small>
              <div class="browser"><?php svg('libre-brand-alexa','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-bing">0</span> Views</div>
              <small>Bing</small>
              <div class="browser"><?php svg('libre-brand-bing','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-duckduckgo">0</span> Views</div>
              <small>Duck Duck Go</small>
              <div class="browser"><?php svg('libre-brand-duckduckgo','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-facebook">0</span> Views</div>
              <small>Facebook</small>
              <div class="browser"><?php svg('libre-social-facebook','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-google">0</span> Views</div>
              <small>Google</small>
              <div class="browser"><?php svg('libre-brand-google','libre-5x');?></div>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="card browser-stats">
              <div class="text-value"><span id="browser-yahoo">0</span> Views</div>
              <small>Yahoo</small>
              <div class="browser"><?php svg('libre-social-yahoo','libre-5x');?></div>
            </div>
          </div>
        </div>
      </div>
      <script>
<?php
$bc=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Chrome'")->fetch(PDO::FETCH_ASSOC);
$bie=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Explorer'")->fetch(PDO::FETCH_ASSOC);
$be=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Edge'")->fetch(PDO::FETCH_ASSOC);
$bf=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Firefox'")->fetch(PDO::FETCH_ASSOC);
$bo=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Opera'")->fetch(PDO::FETCH_ASSOC);
$bs=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Safari'")->fetch(PDO::FETCH_ASSOC);
$sa=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Alexa'")->fetch(PDO::FETCH_ASSOC);
$sb=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Bing'")->fetch(PDO::FETCH_ASSOC);
$sd=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='DuckDuckGo'")->fetch(PDO::FETCH_ASSOC);
$sf=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Facebook'")->fetch(PDO::FETCH_ASSOC);
$sg=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Google'")->fetch(PDO::FETCH_ASSOC);
$sy=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Yahoo'")->fetch(PDO::FETCH_ASSOC);?>
        document.addEventListener("DOMContentLoaded",function(event){
          $('#browser-chrome').countTo({from:0,to:<?php echo $bc['cnt'];?>});
          $('#browser-explorer').countTo({from:0,to:<?php echo $bie['cnt'];?>});
          $('#browser-edge').countTo({from:0,to:<?php echo $be['cnt'];?>});
          $('#browser-firefox').countTo({from:0,to:<?php echo $bf['cnt'];?>});
          $('#browser-opera').countTo({from:0,to:<?php echo $bo['cnt'];?>});
          $('#browser-safari').countTo({from:0,to:<?php echo $bs['cnt'];?>});
          $('#search-bing').countTo({from:0,to:<?php echo $sb['cnt'];?>});
          $('#search-duckduckgo').countTo({from:0,to:<?php echo $sd['cnt'];?>});
          $('#search-google').countTo({from:0,to:<?php echo $sg['cnt'];?>});
          $('#search-yahoo').countTo({from:0,to:<?php echo $sy['cnt'];?>});
          $('#search-facebook').countTo({from:0,to:<?php echo $sf['cnt'];?>});
          $('#search-alexa').countTo({from:0,to:<?php echo $sa['cnt'];?>});
        });
      </script>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>">Recent Administration Activity</a></div>
          <div id="seostats-activity" class="card-body">
            <table class="table table-responsive-sm table-stripe table-sm table-hover">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>User</th>
                  <th>Activity</th>
                </tr>
              </thead>
              <tbody>
<?php $s=$db->query("SELECT * FROM `".$prefix."logs` ORDER BY ti DESC LIMIT 10");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <tr>
                  <td><small><?php echo date($config['dateFormat'],$r['ti']);?></small></td>
                  <td><small><?php echo$r['username'].':'.$r['name'];?></small></td>
                  <td><small><?php echo$r['action'].' > '.$r['refTable'].' > '.$r['refColumn'];?></td>
                </tr>
<?php }?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker';?>">Highest Viewed Pages</a></div>
          <div id="seostats-pageviews" class="card-body">
<?php $s=$db->query("SELECT urlDest,count(*) count FROM `".$prefix."tracker` GROUP BY urlDest ORDER BY count DESC LIMIT 10");?>
            <table class="table table-responsive-sm table-striped table-sm table-hover">
              <thead>
                <tr>
                  <th>Page</th>
                  <th class="col text-center">Tracked Views</th>
                </tr>
              </thead>
              <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $sc=$db->prepare("SELECT COUNT(urlDest) AS cnt FROM `".$prefix."tracker` WHERE urlDest=:urlDest");
  $sc->execute(array(':urlDest'=>$r['urlDest']));
  $c=$sc->fetch(PDO::FETCH_ASSOC);?>
                <tr>
                  <td><small class="text-truncated"><?php echo$r['urlDest'];?></small></td>
                  <td class="text-center"><?php echo$c['cnt'];?></td>
                </tr>
<?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php }
