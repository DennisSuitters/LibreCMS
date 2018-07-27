<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_dashboard.php';
else{?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 id="updateheading" class="col-xs-8">Dashboard</h4>
    <div class="btn-group pull-right">
      <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/dashboard/settings';?>" data-toggle="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings');?></a>
      <?php if($help['dashboard_text']!='')echo'<a target="_blank" class="btn btn-default info" href="'.$help['dashboard_text'].'" data-toggle="tooltip" data-placement="left" title="Read Text Help">'.svg2('libre-gui-help').'</a>';if($help['dashboard_video']!='')echo'<span><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['dashboard_video'].'" data-toggle="tooltip" data-placement="left" title="Watch Video Help">'.svg2('libre-gui-video').'</a>';?>
    </div>
  </div>
  <div id="update" class="panel-body">
    <noscript><div class="alert alert-danger">Javascript MUST BE ENABLED for LibreCMS to function correctly!</div></noscript>
<?php echo$config['maintenance']{0}==1?'<div class="alert alert-warning">Note: Site is currently in <a href="'.URL.$settings['system']['admin'].'/preferences#preference-interface">Maintenance Mode</a></div>':'';
$tid=$ti-2592000;
if($config['backup_ti']<$tid)
  echo$config['backup_ti']==0?'<div class="alert alert-info" role="alert">A <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences#preference-backrestore">Backup</a> has yet to be performed.</div>':'';
else
  echo'<div class="alert alert-danger" role="alert">It has been more than 30 days since a <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences#preference-backrestore">Backup</a> has been performed.</div>';
echo$config['business']==''?'<div class="alert alert-danger" role="alert">The Site\'s <a class="alert-link" href="'.URL.$settings['system']['admin'].'/preferences#preference-contact">Business Name</a> has not been set. Some functions such as Messages, and Bookings will NOT function correctly.</div>':'';
echo$config['email']==''?'<div class="alert alert-danger" role="alert">The Site\'s <a class="alert-link"   href="'.URL.$settings['system']['admin'].'/preferences#preference-contact">Email</a> has not been set. Some functions such as Messages, and Bookings will NOT function correctly.</div>':'';?>
    <div class="row visible-xs">
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/pages';?>"><?php svg('libre-gui-content');?><br>Pages</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php svg('libre-gui-content');?><br>Content</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>"><?php svg('libre-gui-calendar');?><br>Bookings</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/orders/all';?>"><?php svg('libre-gui-order');?><br>Orders</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/rewards';?>"><?php svg('libre-gui-credit-card');?><br>Rewards</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/media';?>"><?php svg('libre-gui-picture');?><br>Media</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('libre-gui-envelope');?><br>Messages</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>"><?php svg('libre-gui-email-read');?><br>Newsletters</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"><?php svg('libre-gui-users');?><br>Accounts</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php svg('libre-gui-settings');?><br>Preferences</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/activity';?>"><?php svg('libre-gui-activity');?><br>Activity</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/search';?>"><?php svg('libre-gui-search');?><br>Search</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-body">
        <h4 class="panel-title">Browser Views</h4>
        <div class="row">
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats chrome">
              <div class="panel-body">
                <span id="browser-chrome">0</span>
                <small>Chrome</small>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats edge">
              <div class="panel-body">
                <span id="browser-edge">0</span>
                <small>Edge</small>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats explorer">
              <div class="panel-body">
                <span id="browser-explorer">0</span>
                <small>Explorer</small>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats firefox">
              <div class="panel-body">
                <span id="browser-firefox">0</span>
                <small>Firefox</small>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats opera">
              <div class="panel-body">
                <span id="browser-opera">0</span>
                <small>Opera</small>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats safari">
              <div class="panel-body">
                <span id="browser-safari">0</span>
                <small>Safari</small>
              </div>
            </div>
          </div>
        </div>
        <h4 class="panel-title">Search Engine Visits</h4>
        <div class="row">
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats alexa">
              <div class="panel-body">
                <span id="search-alexa">0</span>
                <small>Alexa</small>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats bing">
              <div class="panel-body">
                <span id="search-bing">0</span>
                <small>Bing</small>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats duckduckgo">
              <div class="panel-body">
                <span id="search-duckduckgo">0</span>
                <small>Duck Duck Go</small>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats facebook">
              <div class="panel-body">
                <span id="search-facebook">0</span>
                <small>Facebook</small>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats google">
              <div class="panel-body">
                <span id="search-google">0</span>
                <small>Google</small>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default browser-stats yahoo">
              <div class="panel-body">
                <span id="search-yahoo">0</span>
                <small>Yahoo</small>
              </div>
            </div>
          </div>
        </div>
        <script>/*<![CDATA[*/
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
        /*]]>*/</script>
        <h4 class="panel-header">Highest Viewed Pages</h4>
        <div id="seostats-pageviews">
<?php $s=$db->query("SELECT urlDest,count(*) count FROM `".$prefix."tracker` GROUP BY urlDest ORDER BY count DESC LIMIT 10");?>
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Page</th>
                <th class="col-xs-2 text-center">Tracked Views</th>
              </tr>
            </thead>
            <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $sc=$db->prepare("SELECT COUNT(urlDest) AS cnt FROM `".$prefix."tracker` WHERE urlDest=:urlDest");
  $sc->execute(array(':urlDest'=>$r['urlDest']));
  $c=$sc->fetch(PDO::FETCH_ASSOC);?>
              <tr>
                <td><small><?php echo$r['urlDest'];?></small></td>
                <td class="text-center"><?php echo$c['cnt'];?></td>
              </tr>
<?php }?>
            </tbody>
          </table>
        </div>
        <h4 class="page-header">Handy Links to help with SEO</h4>
        <div class="media">
          <div class="media-body">
            <h4 class="media-heading"><a target="_blank" href="https://static.googleusercontent.com/media/www.google.com/en/us/webmasters/docs/search-engine-optimization-starter-guide.pdf">Google Search Engine Optimisation Starter Guide.</a></h4>
            <small><small class="text-muted">From: <a target="_blank" href="https://www.google.com/">Google</a></small></small>
          </div>
          <hr>
        </div>
        <div class="media">
          <div class="media-body">
            <h4 class="media-heading"><a target="_blank" href="https://www.grammarly.com/">Free Grammar Checker.</a></h4>
            <small><small class="text-muted">From: <a target="_blank" href="https://www.grammarly.com/">Grammarly.com</a></small></small><br>
            Instantly check for 250 types of grammatical, spelling, and punctuation mistakes. Recommended by PCMag, Gizmodo, and Forbes. Trusted by millions of users.
          </div>
          <hr>
        </div>
        <div class="media">
          <div class="media-body">
            <h4 class="media-heading"><a target="_blank" href="https://moz.com/beginners-guide-to-seo">The Beginner Guide to Search Engine Optimization.</a></h4>
            <small><small class="text-muted">From: <a target="_blank" href="https://moz.com/">Moz.com</a></small></small><br>
            New to SEO? Need to polish up your knowledge? The Beginner Guide to SEO has been read over 3 million times and provides the information you need to get on the road to professional quality SEO.
          </div>
          <hr>
        </div>
        <div class="media">
          <div class="media-body">
            <h4 class="media-heading"><a target="_blank" href="http://backlinko.com/link-building">Link Building for SEO (The Definitive Guide).</a></h4>
            <small><small class="text-muted">From: <a target="_blank" href="http://backlinko.com/">BackLinko.com</a></small></small><br>
            The complete guide to link building (yes, really). This expert-written guide covers email outreach, content marketing and more.
          </div>
          <hr>
        </div>
      </div>
    </div>
    <div class="row">
<?php if($config['options']{10}==1){?>
      <div class="panel panel-body">
        <h4 class="page-header">RSS Feeds</h4>
        <div id="rssfeeds">
          <?php svg('spinner-13','animated spin');?>
        </div>
      </div>
      <script>/*<![CDATA[*/
        $('#rssfeeds').load('core/layout/rss_feeds.php');
      /*]]>*/</script>
<?php }
if($config['options']{11}==1){?>
      <div class="panel panel-body">
        <h4 class="page-header">Latest Github Commits</h4>
        <div class="table-responsive">
          <table class="table table-condensed table-striped table-hover">
            <thead>
              <tr>
                <th class="hidden-xs"></th>
                <th class="col-xs-2 text-center hidden-xs">Date</th>
                <th class="col-xs-2 text-center hidden-xs">User</th>
                <th>Commit</th>
              </tr>
            </thead>
            <tbody id="commits">
              <tr>
                <td colspan="4"><?php svg('spinner-13','animated spin');?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <script>/*<![CDATA[*/
        $('#commits').load('core/layout/git_commits.php');
      /*]]>*/</script>
<?php }?>
    </div>
  </div>
</div>
<?php
}
