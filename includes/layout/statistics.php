<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-comments fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE status='unapproved'")->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
						</div>
						<div>New Comments!</div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<a href="<?php echo URL;?>/admin/content">
				<span class="pull-left">View Details</span>
				<a href="#" onclick="statsContent('comments');return false;">
					<span class="pull-right"><i class="fa fa-angle-down"></i></span>
				</a>
				<div class="clearfix"></div>
			</div>
			<div id="stats_comments"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-envelope fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM content WHERE contentType='message_primary' AND status='unread'")->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
						</div>
						<div>New Messages!</div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<a href="<?php echo URL;?>/admin/messages">
					<span class="pull-left">View Details</span>
				</a>
				<a href="#" onclick="statsContent('messages');return false;">
					<span class="pull-right"><i class="fa fa-angle-down"></i></span>
				</a>
				<div class="clearfix"></div>
			</div>
			<div id="stats_messages"></div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-shopping-cart fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM orders WHERE status='pending'")->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
						</div>
						<div>Pending Orders!</div>
					</div>
				</div>
			</div>
			<a href="<?php echo URL;?>/admin/orders/pending">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-calendar fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
<?php $r=$db->query("SELECT COUNT(status) AS cnt FROM content WHERE status='unconfirmed'")->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
						</div>
						<div>New Bookings!</div>
					</div>
				</div>
			</div>
			<a href="<?php echo URL;?>/admin/bookings">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-line-chart fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
<?php $r=$db->query("SELECT COUNT(DISTINCT vid) as cnt FROM tracker")->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
						</div>
						<div>Total Visits!</div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<span class="pull-left">Today</span>
				<span class="pull-right">
<?php $tis=strtotime("midnight",time());
$tie=strtotime("tomorrow",$tis)-1;
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
				</span>
				<div class="clearfix"></div>
			</div>
			<div class="panel-footer">
				<span class="pull-left">Yesterday</span>
				<span class="pull-right">
<?php $tis=strtotime("midnight",time())-84600;
$tie=strtotime("tomorrow",$tis)-84601;
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
				</span>
				<div class="clearfix"></div>
			</div>
			<div class="panel-footer">
				<span class="pull-left">Last 7 days</span>
				<span class="pull-right">
<?php $tis=strtotime("midnight",time())-strtotime("-1 week");
$tie=strtotime("tomorrow",$tis)-1-strtotime("-1 week");
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
				</span>
				<div class="clearfix"></div>
			</div>
			<div class="panel-footer">
				<span class="pull-left">Last 30 days</span>
				<span class="pull-right">
<?php $tis=strtotime("midnight",time())-strtotime("-30 days");
$tie=strtotime("tomorrow",$tis)-1-strtotime("-30 days");
$s=$db->prepare("SELECT COUNT(DISTINCT vid) as cnt FROM tracker WHERE ti>:tis AND ti<:tie");
$s->execute(array(':tis'=>$tis,':tie'=>$tie));
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
				</span>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-line-chart fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
<?php $r=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE browser!='Unknown'")->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
						</div>
						<div>Unique Browser Visitors!</div>
					</div>
				</div>
			</div>
<?php	$s=$db->query("SELECT browser,COUNT(DISTINCT ip) as cnt FROM tracker WHERE browser IN ('Chrome','Firefox','Safari','Explorer') GROUP BY browser ORDER BY browser DESC");
		while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
			<div class="panel-footer" title="<?php echo ucfirst($r['browser']);?>">
				<span class="pull-left"><?php echo$r['cnt'];?></span>
				<span class="pull-right"><i class="fa icon-<?php echo strtolower($r['browser']);?>"></i></span>
				<div class="clearfix"></div>
			</div>
<?php	}?>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-line-chart fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
<?php $s=$db->query("SELECT COUNT(DISTINCT ip) AS cnt FROM tracker WHERE os!='Unknown'");
$r=$s->fetch(PDO::FETCH_ASSOC);
echo$r['cnt'];?>
						</div>
						<div>Unique Operating System Visitors!</div>
					</div>
				</div>
			</div>
<?php $s=$db->query("SELECT os,COUNT(DISTINCT ip) as cnt FROM tracker WHERE os IN ('linux','apple','windows','Explorer') GROUP BY os ORDER BY os DESC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
			<div class="panel-footer" title="<?php echo ucfirst($r['os']);?>">
				<span class="pull-left"><?php echo$r['cnt'];?></span>
				<span class="pull-right"><i class="fa fa-<?php echo strtolower($r['os']);?>"></i></span>
				<div class="clearfix"></div>
			</div>
<?php }?>
		</div>
	</div>
</div>
