<?php
if($view=='add'){
	$ti=time();
	$q=$db->prepare("INSERT INTO content (uid,contentType,status,ti,tis) VALUES (:uid,'booking','unconfirmed',:ti,:tis)");
	$q->execute(array(':uid'=>$user['id'],':ti'=>$ti,':tis'=>$ti));
	$id=$db->lastInsertId();
	$view='bookings';
	$s=$db->prepare("INSERT INTO logs (uid,rid,view,contentType,refTable,refColumn,oldda,newda,action,ti) VALUES (:uid,:rid,:view,:contentType,:refTable,:refColumn,:oldda,:newda,:action,:ti)");
	$s->execute(array(':uid'=>$user['id'],':rid'=>$id,':view'=>$view,':contentType'=>'booking',':refTable'=>'content',':refColumn'=>'all',':oldda'=>'',':newda'=>'',':action'=>'create',':ti'=>$ti));
	$args[0]='edit';
}else{
	$id=$args[1];
}
if($args[0]=='edit'){
	$s=$db->prepare("SELECT * FROM content WHERE id=:id");
	$s->execute(array(':id'=>$id));
	$r=$s->fetch(PDO::FETCH_ASSOC);
	$sr=$db->prepare("SELECT contentType FROM content where id=:id");
	$sr->execute(array(':id'=>$r['rid']));
	$rs=$sr->fetch(PDO::FETCH_ASSOC);?>
<div class="page-toolbar">
	<div class="btn-group pull-right">
		<a class="btn btn-success" href="<?php echo URL.'/admin/bookings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><i class="libre libre-back"></i></a>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-group">
			<label for="tis" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','bookedfor');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="tis" class="form-control"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';if($r['tis']==0){lang('tooltip','selectdate');echo'"';}else{echo date($config['dateFormat'],$r['tis']).'"';}}?> value="<?php if($r['tis']!=0)echo date('y-m-d h:m',$r['tis']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" placeholder="<?php lang('placeholder','selectdate');?>"<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
		<div class="form-group">
			<label for="tie" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','bookingend');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="tie" class="form-control"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';if($r['tie']==0){lang('tooltip','selectdate');echo'"';}else{echo date($config['dateFormat'],$r['tie']).'"';}}?> value="<?php if($r['tie']!=0)echo date('y-m-d h:m',$r['tie']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" placeholder="<?php lang('placeholder','selectdate');?>"<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
		<div class="form-group">
			<label for="status" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','status');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php if($user['options']{1}==0)echo' readonly';?>>
					<option value="unconfirmed"<?php if($r['status']=='unconfirmed')echo' selected';?>><?php lang('unconfirmed');?></option>
					<option value="confirmed"<?php if($r['status']=='confirmed')echo' selected';?>><?php lang('confirmed');?></option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="changeClient" class="control-label col-xs-3 col-lg-2"><?php lang('label','client');?></label>
			<div class="input-group col-xs-9 col-lg-10">
				<select id="changeClient" class="form-control" onchange="changeClient($(this).val(),<?php echo$r['id'];?>,'booking');">
					<option value="0"<?php if($r['cid']=='0')echo' selected';?>><?php lang('placeholder','selectclient');?></option>
<?php		$q=$db->query("SELECT id,business,username,name FROM login WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
			while($rs=$q->fetch(PDO::FETCH_ASSOC)){
				echo'<option value="'.$rs['id'].'"';if($r['cid']==$rs['id'])echo' selected';echo'>'.$rs['username'];if($rs['name']!='')echo' ['.$rs['name'].']';if($rs['business']!='')echo' -> '.$rs['business'].'</option>';
			}?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','email');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="email" class="form-control textinput" name="email" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="<?php lang('placeholder','email');?>">
			</div>
		</div>
		<div class="form-group">
			<label for="phone" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','phone');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="phone" class="form-control textinput" name="phone" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone" placeholder="<?php lang('placeholder','phone');?>">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','name');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="name" class="form-control textinput" name="name" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="<?php lang('placeholder','name');?>">
			</div>
		</div>
		<div class="form-group">
			<label for="business" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','business');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="business" class="form-control textinput" name="business" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="<?php lang('placeholder','business');?>">
			</div>
		</div>
		<div class="form-group">
			<label for="address" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','address');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="address" placeholder="<?php lang('placeholder','address');?>">
			</div>
		</div>
		<div class="form-group">
			<label for="suburb" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','suburb');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="suburb" placeholder="<?php lang('placeholder','suburb');?>">
			</div>
		</div>
		<div class="form-group">
			<label for="city" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','city');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="city" placeholder="<?php lang('placeholder','city');?>">
			</div>
		</div>
		<div class="form-group">
			<label for="state" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','state');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="state" placeholder="<?php lang('placeholder','state');?>">
			</div>
		</div>
		<div class="form-group">
			<label for="postcode" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','postcode');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php if($r['postcode']!=0){echo$r['postcode'];}?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="postcode" placeholder="<?php lang('placeholder','postcode');?>">
			</div>
		</div>
<?php $sql=$db->query("SELECT id,contentType,code,title,assoc FROM content WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
	if($sql->rowCount()>0){?>
		<div class="form-group">
			<label for="rid" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','booked');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<select id="rid" class="form-control" name="rid" onchange="update('<?php echo$r['id'];?>','content','rid',$(this).val());">
					<option value="0"><?php lang('placeholder','selectitem');?></option>
<?php	while($row=$sql->fetch(PDO::FETCH_ASSOC)){?>
					<option value="<?php echo$row['id'];?>"<?php if($r['rid']==$row['id']){echo' selected';}?>><?php echo ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'];?></option>
<?php	}?>
				</select>
			</div>
		</div>
<?php }?>
		<div class="form-group">
			<label for="notes" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','notes');?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<form method="post" target="sp" action="core/update.php">
					<input type="hidden" name="id" value="<?php echo$r['id'];?>">
					<input type="hidden" name="t" value="content">
					<input type="hidden" name="c" value="notes">
					<textarea id="notes" class="summernote" name="da"><?php echo$r['notes'];?></textarea>
				</form>
			</div>
		</div>
	</div>
</div>
<?php }else{
	if($user['layoutBookings']=='')$user['layoutBookings']=$config['layoutBookings'];
	?>
<div class="page-toolbar">
	<div class="pull-right">
		<div class="btn-group" data-toggle="buttons">
			<label class="btn btn-default<?php if($user['layoutBookings']=='calendar')echo' active';?>"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" data-placement="left" title="';lang('tooltip','layout_calendar');echo'"';}?>>
				<input type="radio" name="options" id="option1" autocomplete="off" onchange="update('<?php echo$user['id'];?>','login','layoutBookings','calendar');reload('bookings');"<?php if($user['layoutBookings']=='calendar'){echo' checked';}?>><i class="libre libre-calendar"></i>
			</label>
			<label class="btn btn-default<?php if($user['layoutBookings']=='list'){echo' active';}?>"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" data-placement="left" title="';lang('tooltip','layout_list');echo'"';}?>>
				<input type="radio" name="options" id="option2" autocomplete="off" onchange="update('<?php echo$user['id'];?>','login','layoutBookings','list');reload('bookings');"<?php if($user['layoutBookings']=='list'){echo' checked';}?>><i class="libre libre-layout-list"></i>
			</label>
		</div>
<?php if($user['rank']==1000||$user['options']{0}==1){?>
		<div class="btn-group">
			<a class="btn btn-success" href="<?php echo URL;?>admin/add/bookings"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Add Booking."';?>><i class="libre libre-plus visible-xs"></i><span class="hidden-xs">Add</span></a>
		</div>
<?php }?>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="col-xs-12">
			<link rel="stylesheet" type="text/css" href="core/css/fullcalendar.min.css">
<?php if($user['layoutBookings']=='calendar'){?>
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
						<td class="text-center"><small><?php echo date($config['dateFormat'],$r['ti']);?></small></td>
						<td class="text-center"><small><?php echo date($config['dateFormat'],$r['tis']);?></small></td>
						<td class="text-center"><small><?php if($r['name']!='')echo$r['name'];if($r['name']!=''&&$r['business']!='')echo':';if($r['business']!='')echo$r['business'];?></small></td>
						<td>
							<select id="status_<?php echo$r['id'];?>" class="btn btn-default btn-xs" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php if($user['options']{1}==0)echo' readonly';?>>
								<option value="unconfirmed"<?php if($r['status']=='unconfirmed')echo' selected';?>><?php lang('unconfirmed');?></option>
								<option value="confirmed"<?php if($r['status']=='confirmed')echo' selected';?>><?php lang('confirmed');?></option>
							</select>
						</td>
						<td>
							<div id="controls_<?php echo$r['id'];?>" class="btn-group pull-right">
								<a class="btn btn-info btn-xs<?php if($r['status']=='delete')echo' hidden';?>" href="admin/bookings/edit/<?php echo$r['id'];?>"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','edit');echo'"';}?>><i class="libre libre-edit visible-xs"></i><span class="hidden-xs"><?php lang('button','edit');?></span></a>
<?php		if($user['rank']==1000||$user['options']{0}==1){?>
								<button class="btn btn-warning btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','restore');echo'"';}?>><i class="libre libre-restore visible-xs"></i><span class="hidden-xs"><?php lang('button','restore');?></span></button>
								<button class="btn btn-danger btn-xs<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','delete');echo'"';}?>><i class="libre libre-trash visible-xs"></i><span class="hidden-xs"><?php lang('button','delete');?></span></button>
								<button class="btn btn-danger btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','content')"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','purge');echo'"';}?>><i class="libre libre-purge visible-xs"></i><span class="hidden-xs"><?php lang('button','purge');?></span></button>
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
