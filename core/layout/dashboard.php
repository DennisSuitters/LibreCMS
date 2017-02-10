<?php
if($args[0]=='settings'){
  include'core'.DS.'layout'.DS.'set_dashboard.php';
}else{?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 id="updateheading" class="col-xs-8">Dashboard</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/dashboard/settings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Settings"';?>><?php svg('cogs');?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#dashboard"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div id="update" class="panel-body">
    <noscript><div class="alert alert-danger">Javascript MUST BE ENABLED for LibreCMS to function correctly!</div></noscript>
<?php
if($config['uti_freq']!=0&&$config['development']==0){
  $uti=time()-$config['uti_freq'];
  if($config['uti']<$uti){?>
    <div id="updatecheck">
      <div class="alert alert-warning"><?php svg('spinner-13','animated spin');?> Checking for new updates!</div>
    </div>
    <script>/*<![CDATA[*/
      $('#updatecheck').load('core/layout/updatecheck.php');
    /*]]>*/</script>
<?php }
}
if($config['maintenance']{0}==1){?>
    <div class="alert alert-warning">Note: Site is currently in <a href="<?php echo URL.$settings['system']['admin'].'/preferences#preference-interface';?>">Maintenance Mode</a></div>
<?php }
$tid=$ti-2592000;
if($config['backup_ti']<$tid){
  if($config['backup_ti']==0){?>
    <div class="alert alert-info" role="alert">A <a class="alert-link" href="<?php echo URL.$settings['system']['admin'].'/preferences#preference-backrestore';?>">Backup</a> has yet to be performed.</div>
<?php }else{?>
    <div class="alert alert-danger" role="alert">It has been more than 30 days since a <a class="alert-link" href="<?php echo URL.$settings['system']['admin'].'/preferences#preference-backrestore';?>">Backup</a> has been performed.</div>
<?php }
}
if($config['business']==''){?>
    <div class="alert alert-danger" role="alert">The Site's <a class="alert-link"   href="http://localhost/LibreCMS/admin/preferences#preference-contact">Business Name</a> has not been set. Some functions such as Messages, and Bookings will NOT function correctly.</div>
<?php }
if($config['email']==''){?>
    <div class="alert alert-danger" role="alert">The Site's <a class="alert-link"   href="http://localhost/LibreCMS/admin/preferences#preference-contact">Email</a> has not been set. Some functions such as Messages, and Bookings will NOT function correctly.</div>
<?php }?>
    <div class="row visible-xs">
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/pages';?>"><?php svg('content');?><br>Pages</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php svg('content');?><br>Content</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>"><?php svg('calendar');?><br>Bookings</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/orders/all';?>"><?php svg('order');?><br>Orders</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/rewards';?>"><?php svg('credit-card');?><br>Rewards</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/media';?>"><?php svg('picture');?><br>Media</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('envelope');?><br>Messages</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>"><?php svg('email-read');?><br>Newsletters</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"><?php svg('users');?><br>Accounts</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php svg('settings');?><br>Preferences</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/activity';?>"><?php svg('activity');?><br>Activity</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default text-center">
          <a class="panel-body dash" href="<?php echo URL.$settings['system']['admin'].'/search';?>"><?php svg('search');?><br>Search</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="panel panel-body">
        <h3 class="page-header">LibreCMS Tracking Results</h3>
        <h4 class="panel-title">Browser Views</h4>
        <div class="row">
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default">
              <div class="panel-body">
                <span class="text-black" style="font-size:1.5em">
                  <?php svg('browser-chrome');?>
                  <span id="browser-chrome" class="pull-right">0</span>
                </span>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default">
              <div class="panel-body">
                <span class="text-black" style="font-size:1.5em">
                  <?php svg('browser-edge');?>
                  <span id="browser-edge" class="pull-right">0</span>
                </span>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default">
              <div class="panel-body">
                <span class="text-black" style="font-size:1.5em">
                  <?php svg('browser-explorer');?>
                  <span id="browser-explorer" class="pull-right">0</span>
                </span>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default">
              <div class="panel-body">
                <span class="text-black" style="font-size:1.5em">
                  <?php svg('browser-firefox');?>
                  <span id="browser-firefox" class="pull-right">0</span>
                </span>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default">
              <div class="panel-body">
                <span class="text-black" style="font-size:1.5em">
                  <?php svg('browser-opera');?>
                  <span id="browser-opera" class="pull-right">0</span>
                </span>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-2">
            <div class="panel panel-default">
              <div class="panel-body">
                <span class="text-black" style="font-size:1.5em">
                  <?php svg('browser-safari');?>
                  <span id="browser-safari" class="pull-right">0</span>
                </span>
              </div>
            </div>
          </div>
          <script>/*<![CDATA[*/
<?php
$bc=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE browser='Chrome'")->fetch(PDO::FETCH_ASSOC);
$bie=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE browser='Explorer'")->fetch(PDO::FETCH_ASSOC);
$be=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE browser='Edge'")->fetch(PDO::FETCH_ASSOC);
$bf=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE browser='Firefox'")->fetch(PDO::FETCH_ASSOC);
$bo=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE browser='Opera'")->fetch(PDO::FETCH_ASSOC);
$bs=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE browser='Safari'")->fetch(PDO::FETCH_ASSOC);?>
            $('#browser-chrome').countTo({from:0,to:<?php echo$bc['cnt'];?>});
            $('#browser-explorer').countTo({from:0,to:<?php echo$bie['cnt'];?>});
            $('#browser-edge').countTo({from:0,to:<?php echo$be['cnt'];?>});
            $('#browser-firefox').countTo({from:0,to:<?php echo$bf['cnt'];?>});
            $('#browser-opera').countTo({from:0,to:<?php echo$bo['cnt'];?>});
            $('#browser-safari').countTo({from:0,to:<?php echo$bs['cnt'];?>});
          /*]]>*/</script>
        </div>
        <h4 class="panel-header">Highest Viewed Pages</h4>
        <div id="seostats-pageviews">
<?php $s=$db->query("SELECT pid,urlDest,count(*) count FROM tracker GROUP BY urlDest ORDER BY count DESC,ti DESC LIMIT 10");?>
          <table class="table table-condensed">
            <thead>
              <tr>
                <th class="col-xs-1 hidden-xs"></th>
                <th>Page</th>
                <th class="col-xs-2 text-center">Tracked Views</th>
              </tr>
            </thead>
            <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $sc=$db->prepare("SELECT COUNT(urlDest) AS cnt FROM tracker WHERE urlDest=:urlDest");
  $sc->execute(array(':urlDest'=>$r['urlDest']));
  $c=$sc->fetch(PDO::FETCH_ASSOC);?>
              <tr>
                <td class="hidden-xs"><button class="btn btn-default btn-xs"><?php svg('fingerprint');?></button></td>
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
            <h4 class="media-heading"><a target="_blank" href="https://static.googleusercontent.com/media/www.google.com/en/us/webmasters/docs/search-engine-optimization-starter-guide.pdf">Google\'s Search Engine Optimisation Starter Guide.</a></h4>
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
            <h4 class="media-heading"><a target="_blank" href="https://moz.com/beginners-guide-to-seo">The Beginner's Guide to Search Engine Optimization.</a></h4>
            <small><small class="text-muted">From: <a target="_blank" href="https://moz.com/">Moz.com</a></small></small><br>
            New to SEO? Need to polish up your knowledge? The Beginner&#039;s Guide to SEO has been read over 3 million times and provides the information you need to get on the road to professional quality SEO.
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
<?php }
