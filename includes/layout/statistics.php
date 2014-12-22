<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-comments fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
<?php $s=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE status='unapproved'");
$r=$s->fetch(PDO::FETCH_ASSOC);
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
			<div id="newcomments"></div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-envelope fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
<?php $s=$db->query("SELECT COUNT(status) AS cnt FROM content WHERE contentType='message_primary' AND status='unread'");
$r=$s->fetch(PDO::FETCH_ASSOC);
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
			<div id="newmessages"></div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-shopping-cart fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
<?php $s=$db->query("SELECT COUNT(status) AS cnt FROM orders WHERE status='pending'");
$r=$s->fetch(PDO::FETCH_ASSOC);
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
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-calendar fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">13</div>
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
