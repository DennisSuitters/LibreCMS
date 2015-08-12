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
	$args[0]='edit';
}else{
	$id=$args[0];
}
if($args[0]=='edit'){
	$s=$db->prepare("SELECT * FROM content WHERE id=:id");
	$s->execute(array(':id'=>$id));
	$r=$s->fetch(PDO::FETCH_ASSOC);
	$sr=$db->prepare("SELECT contentType FROM content where id=:id");
	$sr->execute(array(':id'=>$r['rid']));
	$rs=$sr->fetch(PDO::FETCH_ASSOC);?>
<h1 class="page-header">
	Bookings
</h1>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-inline">
			<div class="form-group">
				<label for="tis" class="control-label">Booked For</label>
				<div class="input-group half">
<?php if($rs['contentType']=='events'){?>
					<input type="text" id="tis" class="form-control" value="<?php echo date($config['dateFormat'],$r['tis']);?>" readonly>
<?php }else{?>
					<input type="text" id="tis" class="form-control" data-tooltip data-original-title="<?php if($r['tis']==0){echo'Select a Date...';}else{echo date($config['dateFormat'],$r['tis']);}?>" value="<?php if($r['tis']!=0){echo date('Y-m-d h:m',$r['tis']);}?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" placeholder="Select a Date...">
<?php }?>
				</div>
			</div>
			<div class="form-group">
				<label for="tie" class="control-label">Booking End</label>
				<div class="input-group half">
<?php if($rs['contentType']=='events'){?>
					<input type="text" id="tie" class="form-control" value="<?php echo date($config['dateFormat'],$r['tie']);?>" readonly>
<?php }else{?>
					<input type="text" id="tie" class="form-control" data-tooltip data-original-title="<?php if($r['tie']==''||$r['tie']==0){echo'Select a Date...';}else{echo date($config['dateFormat'],$r['tie']);}?>" value="<?php if($r['tie']!=0){echo date('Y-m-d h:m',$r['tie']);}?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" placeholder="Select a Date...">
<?php }?>
				</div>
			</div>
		</div>
		<div class="form-inline">
			<label for="status" class="control-label">Status</label>
			<div class="input-group col=md-8">
				<input type="text" id="status" class="form-control" value="<?php echo ucfirst($r['status']);?>" readonly>
			</div>
		</div>
		<div class="form-inline">
			<div class="form-group">
				<label for="email" class="control-label">Email</label>
				<div class="input-group half">
					<input type="text" id="email" class="form-control" name="email" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="Enter an Email...">
					<div id="emailsave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="control-label">Phone</label>
				<div class="input-group half">
					<input type="text" id="phone" class="form-control" name="phone" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone" placeholder="Enter a Phone Number...">
					<div id="phonesave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
				</div>
			</div>
		</div>
		<div class="form-inline">
			<div class="form-group">
				<label for="name" class="control-label">Name</label>
				<div class="input-group">
					<input type="text" id="name" class="form-control" name="name" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="Enter a Name...">
					<div id="namesave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
				</div>
			</div>
		</div>
		<div class="form-inline">
			<div class="form-group">
				<label for="business" class="control-label">Business</label>
				<div class="input-group">
					<input type="text" id="business" class="form-control" name="business" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="Enter a Business...">
					<div id="businesssave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
				</div>
			</div>
		</div>
		<div class="form-inline">
			<div class="form-group">
				<label for="address" class="control-label">Address</label>
				<div class="input-group">
					<input type="text" id="address" class="form-control" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="address" placeholder="Enter an Address...">
					<div id="addresssave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
				</div>
			</div>
		</div>
		<div class="form-inline">
			<div class="form-group">
				<label for="suburb" class="control-label">Suburb</label>
				<div class="input-group half">
					<input type="text" id="suburb" class="form-control" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="suburb" placeholder="Enter a Suburb...">
					<div id="suburbsave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
				</div>
			</div>
			<div class="form-group">
				<label for="city" class="control-label">City</label>
				<div class="input-group half">
					<input type="text" id="city" class="form-control" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="city" placeholder="Enter a City...">
					<div id="citysave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
				</div>
			</div>
		</div>
		<div class="form-inline">
			<div class="form-group">
				<label for="state" class="control-label">State</label>
				<div class="input-group half">
					<input type="text" id="state" class="form-control" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="state" placeholder="Enter a State...">
					<div id="statesave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
				</div>
			</div>
			<div class="form-group">
				<label for="postcode" class="control-label">Postcode</label>
				<div class="input-group half">
					<input type="text" id="postcode" class="form-control" name="postcode" value="<?php if($r['postcode']!=0){echo$r['postcode'];}?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="postcode" placeholder="Enter a Postcode...">
					<div id="postcodesave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
				</div>
			</div>
		</div>
<?php $sql=$db->query("SELECT id,contentType,code,title,assoc FROM content WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
	if($sql->rowCount()>0){?>
		<div class="form-inline">
			<div class="form-group">
				<label for="rid" class="control-label">Booked</label>
				<div class="input-group">
					<select id="rid" class="form-control" name="rid" onchange="update('<?php echo$r['id'];?>','content','rid',$(this).val());">
						<option value="0">Select an Item...</option>
<?php	while($row=$sql->fetch(PDO::FETCH_ASSOC)){?>
						<option value="<?php echo$row['id'];?>"<?php if($r['rid']==$row['id']){echo' selected';}?>><?php echo ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'];?></option>
<?php	}?>
					</select>
				</div>
			</div>
		</div>
<?php }?>
		<div class="form-inline">
			<div class="form-group">
				<label for="notes" class="control-label">Notes</label>
				<div class="input-group" style="width:708px;">
					<form method="post" target="sp" action="core/update.php">
						<input type="hidden" name="id" value="<?php echo$r['id'];?>">
						<input type="hidden" name="t" value="content">
						<input type="hidden" name="c" value="notes">
						<textarea id="notes" class="summernote2" name="da"><?php echo$r['notes'];?></textarea>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }else{?>
<h1 class="page-header">
	Bookings
	<div class="pull-right">
		<div class="btn-group" data-toggle="buttons">
			<label class="btn btn-default<?php if($config['layoutBookings']=='calendar')echo' active';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Display Content as Calendar."';?>><input type="radio" name="options" id="option1" autocomplete="off" onchange="update('1','config','layoutBookings','calendar');reload('bookings');"<?php if($config['layoutBookings']=='calendar')echo' checked';if($config['buttonType']=='text')echo'>Calendar';else echo'><i class="libre libre-calendar"></i>';?></label>
			<label class="btn btn-default<?php if($config['layoutBookings']=='table')echo' active';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Display Content as Table."';?>><input type="radio" name="options" id="option2" autocomplete="off" onchange="update('1','config','layoutBookings','table');reload('bookings');"<?php if($config['layoutBookings']=='table')echo' checked';if($config['buttonType']=='text')echo'>Table';else echo'><i class="libre libre-table"></i>';?></label>
		</div>
<?php if($user['rank']==1000||$user['options']{0}==1){?>
		<a class="btn btn-success" href="<?php echo URL;?>admin/add/bookings"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Add Booking."';?>><i class="libre libre-plus visible-xs"></i><span class="hidden-xs">Add</span></a>
<?php }?>
	</div>
</h1>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="col-xs-12">
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
						<th></th>
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
						<td>
							<div id="controls_<?php echo$r['id'];?>" class="btn-group pull-right">
								<a class="btn btn-info btn-xs<?php if($r['status']=='delete')echo' hidden';?>" href="admin/bookings/edit"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><i class="libre libre-edit visible-xs"></i><span class="hidden-xs">Edit</span></a>
<?php		if($user['rank']==1000||$user['options']{0}==1){?>
								<button class="btn btn-warning btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><i class="libre libre-restore visible-xs"></i><span class="hidden-xs">Restore</span></button> 
								<button class="btn btn-danger btn-xs<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><i class="libre libre-trash visible-xs"></i><span class="hidden-xs">Delete</span></button> 
								<button class="btn btn-danger btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','content')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><i class="libre libre-purge visible-xs"></i><span class="hidden-xs">Purge</span></button>
<?php		}?>

							</div>
						</td>
					</tr>
<?php }?>
				</tbody>
			</table>
<?php }?>
		</div>
	</div>
</div>
<?php }
