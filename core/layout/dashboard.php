<?php
if($args[0]=='settings'){
    include'core'.DS.'layout'.DS.'set_dashboard.php';
}else{?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-6">Dashboard</h4>
        <div class="btn-group pull-right">
            <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/dashboard/settings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Settings"';?>><?php svg('cogs');?></a>
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
}
?>
        <div class="row">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE contentType!='review' AND status='unapproved'")->fetch(PDO::FETCH_ASSOC);?>
            <div class="col-xs-12 col-sm-6 col-md-3">
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
            <div class="col-xs-12 col-sm-6 col-md-3">
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
            <div class="col-xs-12 col-sm-6 col-md-3">
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
            <div class="col-xs-12 col-sm-6 col-md-3">
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
            <div class="col-xs-12 col-sm-6 col-md-3">
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
            <div class="col-xs-12 col-sm-6 col-md-3">
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
            <div class="col-xs-12 col-sm-6 col-md-3">
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
                                <th style="width:20px;"></th>
                                <th class="col-xs-2 text-center">Date</th>
                                <th class="col-xs-2 text-center">User</th>
                                <th class="col-xs-8">Commit Message</th>
                            </tr>
                        </thead>
                        <tbody id="commits">
                            <tr>
                                <td><?php svg('spinner-9','animated spin');?></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
