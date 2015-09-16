<div class="page-toolbar"></div>
<div class="panel panel-default">
	<div class="panel-body">
		<h4 class="page-header col-xs-6">In Site Analytics</h4>
		<div class="row col-xs-12">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE status='unapproved'")->fetch(PDO::FETCH_ASSOC);?>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-body bg-<?php if($cnt>0)echo'danger';else echo'info';?>">
						<a class="text-black" href="<?php echo URL;?>admin/content">
							<i class="libre libre-comments libre-5x"></i>
							<span class="libre-2x pull-right"><?php echo$r['cnt'];?></span>
							<div class="clearfix text-right">New Comments!</div>
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
							<div class="clearfix text-right">New Messages!</div>
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
							<div class="clearfix text-right">Pending Orders!</div>
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
							<div class="clearfix text-right">New Bookings!</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row col-xs-12">
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-body bg-info text-black">
						<i class="libre libre-seo-performance libre-5x"></i>
						<span class="libre-2x pull-right"><?php $r=$db->query("SELECT COUNT(DISTINCT vid) as cnt FROM tracker")->fetch(PDO::FETCH_ASSOC);echo$r['cnt'];?></span>
						<div class="clearfix text-right">Total Visits!</div>
						<div class="clearfix">
							<span class="pull-left">Today</span>
							<span class="pull-right">
<?php $tis=strtotime("midnight",time());
$tie=strtotime("tomorrow",$tis)-1;
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
							</span>
						</div>
						<div class="clearfix">
							<span class="pull-left">Yesterday</span>
							<span class="pull-right">
<?php $tis=strtotime("midnight",time())-84600;
$tie=strtotime("tomorrow",$tis)-84601;
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
							</span>
						</div>
						<div class="clearfix">
							<span class="pull-left">Last 7 days</span>
							<span class="pull-right">
<?php $tis=strtotime("midnight",time())-strtotime("-1 week");
$tie=strtotime("tomorrow",$tis)-1-strtotime("-1 week");
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
							</span>
						</div>
						<div class="clearfix">
							<span class="pull-left">Last 30 days</span>
							<span class="pull-right">
<?php $tis=strtotime("midnight",time())-strtotime("-30 days");
$tie=strtotime("tomorrow",$tis)-1-strtotime("-30 days");
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-body bg-info text-black">
						<i class="libre libre-browser-general libre-5x"></i>
						<span class="libre-2x pull-right">
<?php $r=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE browser!='Unknown'")->fetch(PDO::FETCH_ASSOC);echo$r['cnt'];?>
						</span>
						<div class="clearfix text-right">Unique Browser Visitors!</div>
<?php	$s=$db->query("SELECT browser,COUNT(DISTINCT ip) as cnt FROM tracker WHERE browser IN ('Chrome','Firefox','Safari','Explorer') GROUP BY browser ORDER BY browser DESC");
		while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
						<div class="clearfix" title="<?php echo ucfirst($r['browser']);?>">
							<span class="pull-left"><i class="libre libre-browser-<?php echo strtolower($r['browser']);?>"></i></span>
							<span class="pull-right"><?php echo$r['cnt'];?></span>
						</div>
<?php	}?>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-body bg-info text-black">
						<i class="libre libre-os-general libre-5x"></i>
						<span class="libre-2x pull-right">
<?php $r=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE os!='Unknown'")->fetch(PDO::FETCH_ASSOC);echo$r['cnt'];?>
						</span>
						<div class="clearfix text-right">Operating Systems!</div>
<?php $s=$db->query("SELECT os,COUNT(DISTINCT ip) as cnt FROM tracker WHERE os IN ('linux','apple','windows','Explorer') GROUP BY os ORDER BY os DESC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
						<div class="clearfix" title="<?php echo ucfirst($r['os']);?>">
							<span class="pull-left"><i class="libre libre-os-<?php echo strtolower($r['os']);?>"></i></span>
							<span class="pull-right"><?php echo$r['cnt'];?></span>
						</div>
<?php }?>
					</div>
				</div>
			</div>
<?php if($config['options']{8}==1&&$config['gaClientID']!=''){?>
		<hr>
		<div class="row col-xs-12">
			<h4 class="page-header col-xs-6">Google Analytics</h4>
			<div id="auth-container" class="alert alert-info">Authorising!</div>
			<div id="view-selector" class="hidden"></div>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
				<div class="panel panel-default">
					<div class="panel-body ga">
						<div class="btn-group pull-right">
							<button class="btn btn-default sessions" onclick="fullscreen('sessions');"><i class="libre libre-fullscreen"></i></button>
						</div>
						<div class="panel-title">Sessions!<br><small class="text-muted">Last 30 Days</small></div>
						<div id="sessions"></div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
				<div class="panel panel-default">
					<div class="panel-body ga">
						<div class="btn-group pull-right">
							<button class="btn btn-default" onclick="fullscreen('sessionbycountry');"><i class="libre libre-fullscreen"></i></button>
						</div>
						<div class="panel-title">Top Sessions by Country!<br><small class="text-muted">Last 30 Days</small></div>
						<div id="sessionbycountry"></div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
				<div class="panel panel-default">
					<div class="panel-body ga">
						<div class="btn-group pull-right">
							<button class="btn btn-default" onclick="fullscreen('topbrowsers');"><i class="libre libre-fullscreen"></i></button>
						</div>
						<div class="panel-title">Top Browsers!<br><small class="text-muted">Last 30 Days</small></div>
						<div id="topbrowsers"></div>
					</div>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-body ga">
						<div class="btn-group pull-right">
							<button class="btn btn-default" onclick="fullscreen('topbrowsers');"><i class="libre libre-fullscreen"></i></button>
						</div>
						<div class="panel-title">Traffic Sources!<br><small class="text-muted">Last 30 Days</small></div>
						<div id="trafficsources"></div>
					</div>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-body ga">
						<div class="btn-group pull-right">
							<button class="btn btn-default" onclick="fullscreen('topbrowsers');"><i class="libre libre-fullscreen"></i></button>
						</div>
						<div class="panel-title">User Flow!<br><small class="text-muted">Last 30 Days</small></div>
						<div id="userflow"></div>
					</div>
				</div>
			</div>
		</div>
<?php }?>
	</div>
</div>
