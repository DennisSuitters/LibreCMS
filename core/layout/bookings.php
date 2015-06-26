<?php
if($view=='add'){
	$ti=time();
	$q=$db->prepare("INSERT INTO content (contentType,status,ti,tis) VALUES ('booking','unconfirmed',:ti,:tis)");
	$q->execute(array(':ti'=>$ti,':tis'=>$ti));
	$view='bookings';
}?>
<link rel="stylesheet" type="text/css" href="core/css/fullcalendar.min.css" />
<div id="calendar" class="col-lg-10 col-md-9"></div>
<div class="col-lg-2 col-md-3 hidden-xs">
	<div class="list-group">
		<div class="list-group-item">
			<h4 class="list-group-item-heading">Bookings</h4>
		</div>
		<div class="list-group-item">
			<h6 class="list-group-item-heading clearfix">
<?php $r=$db->query("SELECT COUNT(id) as cnt FROM content WHERE contentType='booking'")->fetch(PDO::FETCH_ASSOC);?>
				<span class="pull-left"><?php echo$r['cnt'];?></span>
				<span class="pull-right">Total</span>
			</h6>
		</div>
		<div class="list-group-item">
			<h6 class="list-group-item-heading clearfix">
<?php $r=$db->query("SELECT COUNT(id) as cnt FROM content WHERE contentType='booking' AND status='unconfirmed'")->fetch(PDO::FETCH_ASSOC);?>
				<span class="pull-left"><?php echo$r['cnt'];?></span>
				<span class="pull-right">New</span>
			</h6>
		</div>
	</div>
</div>
