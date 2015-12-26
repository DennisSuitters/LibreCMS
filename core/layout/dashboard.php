<div class="page-toolbar"></div>
<div class="panel panel-default">
	<div class="panel-body">
<?php if($config['maintenance']{0}==1){?>
		<div class="alert alert-warning">Note: Site is currently in <a href="<?php echo URL.'admin/preferences#interface';?>">Maintenance Mode</a></div>
<?php 	}
	$tid=$ti-2592000;
	if($config['backup_ti']<$tid){
		if($config['backup_ti']==0){?>
		<div class="alert alert-info">A Backup has yet to be performed.</div>
<?php 	}else{?>
		<div class="alert alert-danger">It has been more than 30 days since a Backup has been performed.</div>
<?php 	}
	}
	if($config['fiti']<$tid){
		if($config['fiti']==0){?>
		<div class="alert alert-info">A File Integrity Check has yet to be performed.</div>
<?php 	}else{?>
		<div class="alert alert-danger">It has been more than 30 days since a File Integreity Check has been performed.</div>
<?php	}
	}?>
		<h4 class="page-header col-xs-6"><?php lang('stats','title');?></h4>
		<div class="row col-xs-12">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE status='unapproved'")->fetch(PDO::FETCH_ASSOC);?>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-body bg-<?php if($cnt>0)echo'danger';else echo'info';?>">
						<a class="text-black" href="<?php echo URL;?>admin/content">
							<i class="libre libre-comments libre-5x"></i>
							<span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
							<div class="clearfix text-right"><?php lang('stats','comments');?></div>
						</a>
					</div>
				</div>
			</div>
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM messages WHERE status='unread'")->fetch(PDO::FETCH_ASSOC);?>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-body bg-<?php if($cnt>0)echo'danger';else echo'info';?>">
						<a class="text-black" href="<?php echo URL;?>admin/messages">
							<i class="libre libre-envelope libre-5x"></i>
							<span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
							<div class="clearfix text-right"><?php lang('stats','messages');?></div>
						</a>
					</div>
				</div>
			</div>
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM orders WHERE status='pending'")->fetch(PDO::FETCH_ASSOC);?>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-body bg-<?php if($cnt>0)echo'danger';else echo'info';?>">
						<a class="text-black" href="<?php echo URL;?>/admin/orders/pending">
							<i class="libre libre-shopping-cart libre-5x"></i>
							<span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
							<div class="clearfix text-right"><?php lang('stats','orders');?></div>
						</a>
					</div>
				</div>
			</div>
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM content WHERE status='unconfirmed'")->fetch(PDO::FETCH_ASSOC);?>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-body bg-<?php if($cnt>0)echo'danger';else echo'info';?>">
						<a class="text-black" href="<?php echo URL;?>/admin/bookings">
							<i class="libre libre-calendar libre-5x"></i>
							<span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
							<div class="clearfix text-right"><?php lang('stats','bookings');?></div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
