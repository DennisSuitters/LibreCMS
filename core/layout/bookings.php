<?php
if($view=='add'){
	$ti=time();
	$q=$db->prepare("INSERT INTO content (uid,contentType,status,ti,tis) VALUES (:uid,'booking','unconfirmed',:ti,:tis)");
	$q->execute(array(':uid'=>$user['id'],':ti'=>$ti,':tis'=>$ti));
	$id=$db->lastInsertId();
	$view='bookings';
	$s=$db->prepare("INSERT INTO logs (
		uid,rid,view,contentType,refTable,refColumn,oldda,newda,action,ti
	) VALUES (
		:uid,:rid,:view,:contentType,:refTable,:refColumn,:oldda,:newda,:action,:ti)");
	$s->execute(array(
		':uid'=>$user['id'],
		':rid'=>$id,
		':view'=>$view,
		':contentType'=>'booking',
		':refTable'=>'content',
		':refColumn'=>'all',
		':oldda'=>'',
		':newda'=>'',
		':action'=>'create',
		':ti'=>$ti
	));
}?>
<div class="row col-xs-12 text-right">
	<div class="btn-group" data-toggle="buttons">
		<label class="btn btn-default<?php if($config['layoutBookings']=='calendar')echo' active';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Content as Calendar."';?>><input type="radio" name="options" id="option1" autocomplete="off" onchange="update('1','config','layoutBookings','calendar');reload('bookings');"<?php if($config['layoutBookings']=='calendar')echo' checked';if($config['buttonType']=='text')echo'>Calendar';else echo'><i class="libre libre-calendar"></i>';?></label>
		<label class="btn btn-default<?php if($config['layoutBookings']=='table')echo' active';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Content as Table."';?>><input type="radio" name="options" id="option2" autocomplete="off" onchange="update('1','config','layoutBookings','table');reload('bookings');"<?php if($config['layoutBookings']=='table')echo' checked';if($config['buttonType']=='text')echo'>Table';else echo'><i class="libre libre-table"></i>';?></label>
	</div>
<?php if($user['rank']==1000||$user['options']{0}==1){?>
	<a class="btn btn-default" href="<?php echo URL;?>admin/add/bookings"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Add Booking."';if($config['buttonType']=='text')echo'>Add';else echo'><i class="libre libre-plus color-success"></i>';?></a>
<?php }?>
</div>
<div class="col-lg-10 col-md-9">
	<link rel="stylesheet" type="text/css" href="core/css/fullcalendar.min.css">
<?php if($config['layoutBookings']=='calendar'){?>
	<div id="calendar"></div>
<?php }else{?>
	<table id="stupidtable" class="table table-condensed table-hover">
		<thead>
			<tr>
				<th class="text-center hidden-xs" data-sort="string">Created</th>
				<th class="text-center hidden-xs" data-sort="string">For</th>
				<th class="text-center" data-sort="string">Name/Business</th>
				<th class="text-center hidden-xs" data-sort="string">Status</th>
				<th class="col-xs-2 text-right"></th>
			</tr>
		</thead>
		<tbody>
<?php $s=$db->query("SELECT * FROM content WHERE contentType='booking'");
	while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
			<tr>
				<td><?php echo date($config['dateFormat'],$r['ti']);?></td>
				<td><?php echo date($config['dateFormat'],$r['tis']);?></td>
				<td><?php echo$r['business'].'/'.$r['name'];?></td>
				<td><?php echo$r['status'];?></td>
				<td></td>
			</tr>
<?php }?>
		</tbody>
	</table>
<?php }?>
</div>
<div class="col-lg-2 col-md-3 hidden-xs">
	<br>
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
