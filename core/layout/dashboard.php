<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Displays some Statistics and is the Gateway to Greatness.
 *
 * dashboard.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Dashboard
 * @package    core/layout/dashboard.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Add Changelog Viewing.
 * @changes    v2.0.1 Replace Alexa count with 30 Blacklist and fix typos.
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_dashboard.php';
else{?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active"><?php echo localize('Dashboard');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <?php if($help['dashboard_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['dashboard_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['dashboard_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['dashboard_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
<?php echo$config['maintenance']{0}==1?'<div class="alert alert-info" role="alert">'.localize('alert_all_warning_maintenancemode').' <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/interface#maintenance">'.localize('Set Now').'</a></div>':'';
  echo$config['comingsoon']{0}==1?'<div class="alert alert-info" role="alert">'.localize('alert_all_warning_comingsoonmode').' <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/interface#comingsoon">'.localize('Set Now').'</a></div>':'';
  if(!file_exists('layout'.DS.$config['theme'].DS.'theme.ini'))
    echo'<div class="alert alert-danger" role="alert">'.localize('alert_theme_danger_notheme').'</div>';
  $tid=$ti-2592000;
  echo$config['business']==''?'<div class="alert alert-danger" role="alert">'.localize('alert_all_warning_nobusinessname').' <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences/contact#business">'.localize('Set Now').'</a></div>':'';
  echo$config['email']==''?'<div class="alert alert-danger" role="alert">'.localize('alert_all_warning_noemail').' <a class="alert-link"   href="'.URL.$settings['system']['admin'].'/preferences/contact#email">'.localize('Set Now').'</a></div>':'';?>
    <div class="row">
      <div class="card col-12 p-0">
        <div class="card-header"><?php echo localize('Search Engine Visits');?></div>
        <div class="card-body">
          <div class="row">
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-blacklist">0</span> <?php echo localize('Added');?></div>
                <small><?php echo localize('Blacklist');?> <small><?php echo localize('Last 7 Days');?></small></small>
                <div class="browser"><?php svg('libre-gui-security','libre-5x');?></div>
              </div>
            </div>
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-google">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Google');?></small>
                <div class="browser"><?php svg('libre-brand-google','libre-5x');?></div>
              </div>
            </div>
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-yahoo">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Yahoo');?></small>
                <div class="browser"><?php svg('libre-social-yahoo','libre-5x');?></div>
              </div>
            </div>
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-bing">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Bing');?></small>
                <div class="browser"><?php svg('libre-brand-bing','libre-5x');?></div>
              </div>
            </div>
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-duckduckgo">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Duck Duck Go');?></small>
                <div class="browser"><?php svg('libre-brand-duckduckgo','libre-5x');?></div>
              </div>
            </div>
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-facebook">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Facebook');?></small>
                <div class="browser"><?php svg('libre-social-facebook','libre-5x');?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="card col-12 p-0">
        <div class="card-header"><?php echo localize('Browser Views');?></div>
        <div class="card-body">
          <div class="row">
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-chrome">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Chrome');?></small>
                <div class="browser"><?php svg('libre-browser-chrome','libre-5x');?></div>
              </div>
            </div>
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-edge">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Edge');?></small>
                <div class="browser"><?php svg('libre-browser-edge','libre-5x');?></div>
              </div>
            </div>
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-explorer">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Explorer');?></small>
                <div class="browser"><?php svg('libre-browser-explorer','libre-5x');?></div>
              </div>
            </div>
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-firefox">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Firefox');?></small>
                <div class="browser"><?php svg('libre-browser-firefox','libre-5x');?></div>
              </div>
            </div>
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-opera">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Opera');?></small>
                <div class="browser"><?php svg('libre-browser-opera','libre-5x');?></div>
              </div>
            </div>
            <div class="col-6 col-sm-2">
              <div class="card browser-stats">
                <div class="text-value"><span id="browser-safari">0</span> <?php echo localize('Views');?></div>
                <small><?php echo localize('Safari');?></small>
                <div class="browser"><?php svg('libre-browser-safari','libre-5x');?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
<?php
  $ss=$db->prepare("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."iplist` WHERE ti >= :ti");
  $ss->execute(['ti'=>time()-604800]);
  $sa=$ss->fetch(PDO::FETCH_ASSOC);
  $bc=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Chrome'")->fetch(PDO::FETCH_ASSOC);
  $bie=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Explorer'")->fetch(PDO::FETCH_ASSOC);
  $be=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Edge'")->fetch(PDO::FETCH_ASSOC);
  $bf=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Firefox'")->fetch(PDO::FETCH_ASSOC);
  $bo=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Opera'")->fetch(PDO::FETCH_ASSOC);
  $bs=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM `".$prefix."tracker` WHERE browser='Safari'")->fetch(PDO::FETCH_ASSOC);
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
        $('#browser-bing').countTo({from:0,to:<?php echo $sb['cnt'];?>});
        $('#browser-duckduckgo').countTo({from:0,to:<?php echo $sd['cnt'];?>});
        $('#browesr-google').countTo({from:0,to:<?php echo $sg['cnt'];?>});
        $('#browser-yahoo').countTo({from:0,to:<?php echo $sy['cnt'];?>});
        $('#browser-facebook').countTo({from:0,to:<?php echo $sf['cnt'];?>});
        $('#browser-blacklist').countTo({from:0,to:<?php echo $sa['cnt'];?>});
      });
    </script>
    <div class="row">
      <div class="card col-sm-6 p-0 d-none d-sm-block">
        <div class="card-header"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>"><?php echo localize('Recent Admin Activity');?></a></div>
        <div id="seostats-activity" class="card-body">
          <table class="table table-responsive-sm table-stripe table-sm table-hover" role="table">
            <thead>
              <tr role="row">
                <th role="columnheader"><?php echo localize('Date');?></th>
                <th role="columnheader"><?php echo localize('User');?></th>
                <th role="columnheader"><?php echo localize('Activity');?></th>
              </tr>
            </thead>
            <tbody>
<?php $s=$db->query("SELECT * FROM `".$prefix."logs` ORDER BY ti DESC LIMIT 10");
  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr role="row">
                <td class="small" role="cell"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                <td class="small" role="cell"><?php echo$r['username'].':'.$r['name'];?></td>
                <td class="small" role="cell"><?php echo$r['action'].' > '.$r['refTable'].' > '.$r['refColumn'];?></td>
              </tr>
<?php }?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card col-sm-6 p-0 d-none d-sm-block">
        <div class="card-header"><a href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker';?>"><?php echo localize('Highest Viewed Pages');?></a></div>
        <div id="seostats-pageviews" class="card-body">
<?php $s=$db->query("SELECT urlDest,count(*) count FROM `".$prefix."tracker` GROUP BY urlDest ORDER BY count DESC LIMIT 10");?>
          <table class="table table-responsive-sm table-striped table-sm table-hover" role="table">
            <thead>
              <tr role="row">
                <th role="columnheader"><?php echo localize('Page');?></th>
                <th class="col text-center" role="columnheader"><?php echo localize('Tracked Views');?></th>
              </tr>
            </thead>
            <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $sc=$db->prepare("SELECT COUNT(urlDest) AS cnt FROM `".$prefix."tracker` WHERE urlDest=:urlDest");
  $sc->execute([':urlDest'=>$r['urlDest']]);
  $c=$sc->fetch(PDO::FETCH_ASSOC);?>
              <tr role="row">
                <td class="small text-truncated" role="cell"><?php echo$r['urlDest'];?></td>
                <td class="text-center" role="cell"><?php echo$c['cnt'];?></td>
              </tr>
<?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
<?php if(file_exists('CHANGELOG.md')){?>
    <div class="row">
      <div class="card col-sm-6 p-0">
        <div class="card-header"><a target="_blank" href="https://github.com/DiemenDesign/LibreCMS"><?php echo localize('Latest Github Project Updates');?></a></div>
        <div class="card-body">
          <pre>
<?php include'CHANGELOG.md';?>
          </pre>
        </div>
      </div>
<?php }?>
    </div>
  </div>
</main>
<?php }
