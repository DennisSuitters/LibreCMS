<?php
if($args[0]=='settings'){
    include'core'.DS.'layout'.DS.'set_dashboard.php';
}else{?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-8">Dashboard</h4>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'].'/dashboard/settings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Settings"';?>><?php svg('cogs');?></a>
            </div>
            <div class="btn-group">
                <a target="_blank" class="btn btn-default info btn-xs" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#dashboard"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <noscript>
            <div class="alert alert-danger">Javascript MUST BE ENABLED for LibreCMS to function correctly!</div>
        </noscript>
<?php if($config['maintenance']{0}==1){?>
        <div class="alert alert-warning">Note: Site is currently in <a href="<?php echo URL.$settings['system']['admin'].'/preferences#interface';?>">Maintenance Mode</a></div>
<?php }
$tid=$ti-2592000;
if($config['backup_ti']<$tid){
    if($config['backup_ti']==0){?>
        <div class="alert alert-info">A Backup has yet to be performed.</div>
<?php }else{?>
        <div class="alert alert-danger">It has been more than 30 days since a Backup has been performed.</div>
<?php }
}?>
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
        </div>
        <div class="row">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE contentType!='review' AND status='unapproved'")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/content">
                            <?php svg('comments','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">New Comments!</div>
                        </a>
                    </div>
                </div>
            </div>
<?php $r=$db->query("SELECT COUNT(id) AS cnt FROM comments WHERE contentType='review' AND  status='unapproved'")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/content">
                            <?php svg('layout-timeline','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">New Reviews!</div>
                        </a>
                    </div>
                </div>
            </div>
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM messages WHERE status='unread'")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/messages">
                            <?php svg('envelope','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">New Messages!</div>
                        </a>
                    </div>
                </div>
            </div>
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM orders WHERE status='pending'")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/orders/pending">
                            <?php svg('shopping-cart','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">Pending Orders!</div>
                        </a>
                    </div>
                </div>
            </div>
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM content WHERE contentType='booking' AND status!='confirmed'")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/bookings">
                            <?php svg('calendar','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">New Bookings!</div>
                        </a>
                    </div>
                </div>
            </div>
<?php $r=$db->query("SELECT COUNT(id) AS cnt FROM login WHERE activate!='' AND active=0")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/accounts">
                            <?php svg('users','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">New Users!</div>
                        </a>
                    </div>
                </div>
            </div>
<?php $r=$db->query("SELECT COUNT(id) AS cnt FROM content WHERE contentType='testimonial' AND status!='confirmed' AND active!=1")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body bg-<?php if($r['cnt']>0)echo'danger';?>">
                        <a class="text-black" href="<?php echo URL.$settings['system']['admin'];?>/bookings">
                            <?php svg('signature','3x');?>
                            <span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
                            <div class="clearfix text-right">New Testimonials!</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-body">
                <h4 class="page-header">Handy Links to help with SEO</h4>
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading"><a target="_blank" href="https://static.googleusercontent.com/media/www.google.com/en/us/webmasters/docs/search-engine-optimization-starter-guide.pdf">Google's Search Engine Optimisation Starter Guide.</a></h4>
                        <small><small class="text-muted">From: <a target="_blank" href="https://www.google.com/">Google</a></small></small>
                    </div>
                    <hr>
                </div>
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading"><a target="_blank" href="http://www.therecipeforseosuccess.com.au/devel/26">Boost rankings, improve traffic and increase coversions with The Recipe for SEO Success eCourse.</a></h4>
                        <small><small class="text-muted">From: <a target="_blank" href="http://www.therecipeforseosuccess.com.au/devel/26">The Recipe For SEO Success</a></small></small><br>
                        <a href="http://www.therecipeforseosuccess.com.au/devel/34"><img class="img-responsive" src="http://www.therecipeforseosuccess.com.au/wp-content/uploads/2016/01/Recipe2016_728x90_NoDate_v1.jpg" width="728" height="90"></a>
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
<?php if($config['options']{12}==1){?>
            <div class="panel panel-body">
                <h4 class="page-header">Google Analytics</h4>
                <div id="ga">
                    <?php svg('spinner-9','animated spin');?>
                </div>
            </div>
            <script>
                $('#ga').load('core/layout/ga-feed.php');
            </script>
<?php }
if($config['options']{10}==1){?>
            <div class="panel panel-body">
                <h4 class="page-header">RSS Feeds</h4>
                <div id="rssfeeds">
                    <?php svg('spinner-9','animated spin');?>
                </div>
            </div>
            <script>
                $('#rssfeeds').load('core/layout/rss_feeds.php');
            </script>
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
                                <td colspan="4"><?php svg('spinner-9','animated spin');?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                $('#commits').load('core/layout/git_commits.php');
            </script>
<?php }?>
        </div>
    </div>
</div>
<?php }
