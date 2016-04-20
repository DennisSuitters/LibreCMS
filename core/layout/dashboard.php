<div class="page-toolbar"></div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Dashboard</h4>
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
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE status='unapproved'")->fetch(PDO::FETCH_ASSOC);?>
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
        </div>
    </div>
</div>
