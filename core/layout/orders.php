<?php
if(isset($_SESSION['uid'])){$uid=$_SESSION['uid'];}else{$uid=0;}
$error=0;
$oid='';
if(isset($args[1])){$id=$args[1];}
if($args[0]=='addquote'||$args[0]=='addinvoice'){
	$r=$db->query("SELECT MAX(id) as id FROM orders")->fetch(PDO::FETCH_ASSOC);
	$dti=$ti+$config['orderPayti'];
	if($args[0]=='addquote'){
		$oid='Q'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
		$q=$db->prepare("INSERT INTO orders (uid,qid,qid_ti,due_ti,status) VALUES (:uid,:qid,:qid_ti,:due_ti,'pending')");
		$q->execute(array(':uid'=>$uid,':qid'=>$oid,':qid_ti'=>$ti,':due_ti'=>$dti));
	}
	if($args[0]=='addinvoice'){
		$oid='I'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
		$s=$db->prepare("INSERT INTO orders (uid,iid,iid_ti,due_ti,status) VALUES (:uid,:iid,:iid_ti,:due_ti,'pending')");
		$s->execute(array(':uid'=>$uid,':iid'=>$oid,':iid_ti'=>$ti,':due_ti'=>$dti));
	}
	$id=$db->lastInsertId();
	$e=$db->errorInfo();
	$args[0]='view';
}
if($args[0]=='add_recurring'){
	$iid=$id;
	$r=$db->query("SELECT MAX(id) as id FROM orders")->fetch();
	$oid=strtoupper('I').date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
	$so=$db->prepare("SELECT cid,uid,order_note,da FROM orders WHERE id=:id LIMIT 0,1");
	$so->execute(array(':id'=>$id));
	$ro=$so->fetch(PDO::FETCH_ASSOC);
	$payti=$ti+$config['orderPayti'];
	$q=$db->prepare("INSERT INTO orders (cid,uid,order_note,iid,iid_ti,due_ti,da,status,ti) VALUES (:cid,:uid,:order_note,:iid,:iid_ti,:due_ti,:da','pending',:ti)");
	$q->execute(array(':cid'=>$ro['cid'],':uid'=>$ro['uid'],':order_note'=>$ro['order_note'],':iid'=>$oid,':iid_ti'=>$ti,':due_ti'=>$payti,':da'=>$ro['notes'],':ti'=>$ti));
	$id=$db->lastInsertId();
	$s=$db->prepare("SELECT iid,title,quantity,cost,status FROM orderitems WHERE oid=:oid");
	$s->execute(array(':oid'=>$iid));
	while($r=$s->fetch(PDO::FETCH_ASSOC)){
		$q=$db->prepare("INSERT INTO orderitems (oid,iid,title,quantity,cost,status,ti) VALUES (:oid,:iid,:title,:quantity,:cost,:status,:ti)");
		$q->execute(array(':oid'=>$id,':iid'=>$r['iid'],':title'=>$r['title'],':quantity'=>$r['quantity'],':cost'=>$r['cost'],':status'=>$r['status'],':ti'=>$ti));
	}
	$args[0]='view';
}
if($act=='to_invoice'){
	$oid=strtoupper('I').date("ymd",$ti).sprintf("%06d",$r['id'],6);
	$q=$db->prepare("UPDATE orders SET iid=:iid,iid_ti=:iid_ti,qid='',qid_ti='0' WHERE id=:id");
	$q->execute(array(':iid'=>$oid,':iid_ti'=>$ti,':id'=>$id));
	unlink('../files/orders/'.$r['qid'].'.pdf');
	$r['qid']='';
	$args[0]='view';
	$q=$db->prepare("SELECT * FROM order WHERE id=:id");
	$q->execute(array(':id'=>$id));
	$r=$q->fetch(PDO::FETCH_ASSOC);
}
if($args[0]=='view'){
	$q=$db->prepare("SELECT * FROM orders WHERE id=:id");
	$q->execute(array(':id'=>$id));
	$r=$q->fetch(PDO::FETCH_ASSOC);
	$q=$db->prepare("SELECT * FROM login WHERE id=:id");
	$q->execute(array(':id'=>$r['cid']));
	$client=$q->fetch(PDO::FETCH_ASSOC);
	$q=$db->prepare("SELECT * FROM login WHERE id=:id");
	$q->execute(array(':id'=>$r['uid']));
	$usr=$q->fetch(PDO::FETCH_ASSOC);
	if($r['notes']==''){
		$r['notes']=$config['orderEmailNotes'];
		$q=$db->prepare("UPDATE orders SET notes=:notes WHERE id=:id");
		$q->execute(array(':notes'=>$config['orderEmailNotes'],':id'=>$r['id']));
	}
	if($error==1)echo'<div class="alert alert-danger">'.$e[0].'</div>';
	else{?>
<div class="page-toolbar">
	Order #<?php echo$r['qid'].$r['iid'];?>
	<div class="btn-group pull-right">
		<a class="btn btn-success" href="<?php echo URL.'admin/orders';?>"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" data-placement="left" title="';lang('tooltip','back');echo'"';}?>><i class="libre libre-back visible-xs"></i><span class="hidden-xs"><?php lang('button','back');?></span></a>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="alert alert-info visible-xs"><?php lang('alert','ordersmallscreen');?></div>
		<div class="invoice">
			<div class="row header">
				<div class="col-xs-4 border-right">
					<h2><?php lang('From');?></h2>
					<div class="form-group">
						<input type="text" class="form-control input-sm text-bold" value="<?php echo$config['business'];?>" readonly>
					</div>
					<div class="form-group">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','abn');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control input-xs" value="<?php echo$config['abn'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','address');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control input-xs" value="<?php echo$config['address'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','suburb');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control input-xs" value="<?php echo$config['suburb'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','city');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control input-xs" value="<?php echo$config['city'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','state');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control input-xs" value="<?php echo$config['state'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','postcode');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control input-xs" value="<?php echo$config['postcode'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','email');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control input-xs" value="<?php echo$config['email'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','phone');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control input-xs" value="<?php echo$config['phone'];?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','mobile');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control input-xs" value="<?php echo$config['mobile'];?>" readonly>
						</div>
					</div>
				</div>
				<div class="col-xs-4 border-right">
					<h2><?php lang('To');?></h2>
					<div class="form-group">
						<input type="text" id="client_business" class="form-control input-sm text-bold" value="<?php echo$client['username'];if($client['name']!=''){echo' ['.$client['name'].']';}if($client['business']!=''){echo' -> '.$client['business'];}?>" placeholder="<?php lang('placeholder','orderclientname');?>" readonly>
					</div>
					<div class="form-group form-group-xs">
						<label for="address" class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','address');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" id="address" class="form-control input-xs textinput" value="<?php echo$client['address'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="address" data-bt="icon" data-bs="btn-danger btn-xs" placeholder="<?php lang('placeholder','address');?>"<?php if($r['status']=='archived')echo' readonly';?>>
						</div>
					</div>
					<div class="form-group form-group-xs">
						<label for="suburb" class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','suburb');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" id="suburb" class="form-control input-xs textinput" value="<?php echo$client['suburb'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="suburb" data-bt="icon" data-bs="btn-danger btn-xs" placeholder="<?php lang('placeholder','suburb');?>"<?php if($r['status']=='archived')echo' readonly';?>>
						</div>
					</div>
					<div class="form-group form-group-xs">
						<label for="city" class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','city');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" id="city" class="form-control input-xs textinput" value="<?php echo$client['city'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="city" data-bt="icon" data-bs="btn-danger btn-xs" placeholder="<?php lang('placeholder','city');?>"<?php if($r['status']=='archived')echo' readonly';?>>
						</div>
					</div>
					<div class="form-group form-group-xs">
						<label for="state" class="control-label label-xs col-xs-3 col-lg-2 textinput"><?php lang('label','state');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" id="state" class="form-control input-xs textinput" value="<?php echo$client['state'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="state" data-bt="icon" data-bs="btn-danger btn-xs" placeholder="<?php lang('placeholder','state');?>"<?php if($r['status']=='archived')echo' readonly';?>>
						</div>
					</div>
					<div class="form-group form-group-xs">
						<label for="postcode" class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','postcode');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" id="postcode" class="form-control input-xs textinput" value="<?php if($client['postcode']!=0)echo$client['postcode'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="postcode" data-bt="icon" data-bs="btn-danger btn-xs" placeholder="<?php lang('placeholder','postcode');?>"<?php if($r['status']=='archived')echo' readonly';?>>
						</div>
					</div>
					<div class="form-group form-group-xs">
					<label for="email" class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','email');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" id="email" class="form-control input-xs textinput" value="<?php echo$client['email'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="email" data-bt="icon" data-bs="btn-danger btn-xs" placeholder="<?php lang('placeholder','email');?>"<?php if($r['status']=='archived')echo' readonly';?>>
							<div class="input-group-btn">
								<a class="btn btn-info btn-xs"><i class="libre libre-email-send visible-xs"></i><span class="hidden-xs"><?php lang('button','email');?></span></a>
							</div>
						</div>
					</div>
					<div class="form-group form-group-xs">
						<label for="phone" class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','phone');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" id="phone" class="form-control input-xs textinput" value="<?php echo$client['phone'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="phone" data-bt="icon" data-bs="btn-danger btn-xs" placeholder="<?php lang('placeholder','phone');?>"<?php if($r['status']=='archived')echo' readonly';?>>
						</div>
					</div>
					<div class="form-group form-group-xs">
						<label for="mobile" class="control-label label-xs col-xs-3 col-lg-2 textinput"><?php lang('label','mobile');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" id="mobile" class="form-control input-xs textinput" value="<?php echo$client['mobile'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="mobile" data-bt="icon" data-bs="btn-danger btn-xs" placeholder="<?php lang('placeholder','mobile');?>"<?php if($r['status']=='archived')echo' readonly';?>>
						</div>
					</div>
<?php	if($r['status']!='archived'){?>
					<div class="form-group form-group-xs">
						<label for="changeClient" class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','changeclient');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<select id="changeClient" class="form-control input-xs" onchange="changeClient($(this).val(),'<?php echo$r['id'];?>');">
								<option value="0"<?php if($r['cid']=='0')echo' selected';?>>None</option>
<?php		$q=$db->query("SELECT id,business,username,name FROM login WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
			while($rs=$q->fetch(PDO::FETCH_ASSOC)){
				echo'<option value="'.$rs['id'].'"';if($r['cid']==$rs['id'])echo' selected';echo'>'.$rs['username'];if($rs['name']!='')echo' ['.$rs['name'].']';if($rs['business']!='')echo' -> '.$rs['business'].'</option>';
			}?>
							</select>
						</div>
						<small class="help-block"><?php lang('info','orderclientnote');?></small>
					</div>
<?php	}?>
				</div>
				<div class="col-xs-4">
					<h2><?php lang('title','details');?></h2>
					<div class="form-group form-group-xs">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','order#');?>'</label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control" value="<?php echo$r['qid'].$r['iid'];?>" readonly>
						</div>
					</div>
					<div class="form-group form-group-xs">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','orderdate');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" class="form-control" value="<?php echo date($config['dateFormat'],$r['qid_ti'].$r['iid_ti']);?>" readonly>
						</div>
					</div>
					<div class="form-group form-group-xs">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','duedate');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="text" id="due_ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['due_ti']);?>" readonly>
<?php	if($r['status']!='archived'){?>
							<div class="input-group-btn">
								<button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="libre libre-plus visible-xs"></i><span class="hidden-xs"><?php lang('button','add');?></span></button>
								<ul class="dropdown-menu pull-right">
									<li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+604800;?>');return false;"><?php lang('button','7days');?></a></li>
									<li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+1209600;?>');return false;"><?php lang('button','14days');?></a></li>
									<li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+1814400;?>');return false;"><?php lang('button','21days');?></a></li>
									<li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+2592000;?>');return false;"><?php lang('button','30days');?></a></li>
								</ul>
							</div>
<?php	}?>
						</div>
					</div>
					<div class="form-group form-group-xs">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','status');?></label>
						<div class="input-group col-xs-9 col-lg-10">
<?php	if($r['status']=='archived'){?>
							<input type="text" class="form-control input-xs" value="Archived" readonly>
<?php 	}else{?>
							<select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','orders','status',$(this).val());">
								<option value="pending"<?php if($r['status']=='pending')echo' selected';?>><?php lang('Pending');?></option>
								<option value="overdue"<?php if($r['status']=='overdue')echo' selected';?>><?php lang('Overdue');?></option>
								<option value="cancelled"<?php if($r['status']=='cancelled')echo' selected';?>><?php lang('Cancelled');?></option>
								<option value="paid"<?php if($r['status']=='paid')echo' selected';?>><?php lang('Paid');?></option>
							</select>
<?php	}?>
						</div>
					</div>
					<div class="form-group form-group-xs">
						<label class="control-label label-xs col-xs-3 col-lg-2"><?php lang('label','recurring');?></label>
						<div class="input-group col-xs-9 col-lg-10">
							<input type="checkbox" id="recurring0" data-dbid="<?php echo$r['id'];?>" data-dbt="orders" data-dbc="recurring" data-dbb="0"<?php if($r['recurring']==1)echo' checked';if($r['status']=='archived')echo' disabled';?>><label for="recurring0">
						</div>
					</div>
					<div class="form-group form-group-xs">
						<small class="help-block"><?php lang('info','recurring');?></small>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-responsive">
					<thead>
<?php		if($r['status']!='archived'){?>
						<tr>
							<th colspan="6">
								<div class="form-group">
									<div class="input-group col-xs-12">
										<select id="addItem" class="form-control">
											<option value="0"><?php lang('placeholder','addemptyentry');?></option>
<?php			$s=$db->query("SELECT id,contentType,code,cost,title FROM content WHERE contentType='inventory' OR contentType='service' OR contentType='events' ORDER BY code ASC");
				while($i=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$i['id'].'">'.ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'].'</option>';?>
										</select>
										<span class="input-group-btn">
											<button class="btn btn-success" onclick="addOrderItem('<?php echo$r['id'];?>',$('#addItem').val());"><i class="libre libre-plus visible-xs"></i><span class="hidden-xs">Add</span></button>
										</span>
									</div>
								</div>
							</th>
						</tr>
<?php		}?>
						<tr>
							<th>Code</th>
							<th>Title</th>
							<th class="col-sm-1 text-center">Quantity</th>
							<th class="col-sm-1 text-center">Cost</th>
							<th class="col-sm-1 text-right">Total</th>
							<th class="col-sm-1"></th>
						</tr>
					</thead>
					<tbody id="updateorder">
<?php		$s=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid ORDER BY ti ASC,title ASC");
			$s->execute(array(':oid'=>$r['id']));
			$total=0;
			while($oi=$s->fetch(PDO::FETCH_ASSOC)){
				$is=$db->prepare("SELECT id,code,title FROM content WHERE id=:id");
				$is->execute(array(':id'=>$oi['iid']));
				$i=$is->fetch(PDO::FETCH_ASSOC);?>
						<tr>
							<td class="text-left"><?php echo$i['code'];?></td>
							<td class="text-left">
								<form target="sp" action="core/update.php">
									<input type="hidden" name="id" value="<?php echo$oi['id'];?>">
									<input type="hidden" name="t" value="orderitems">
									<input type="hidden" name="c" value="title">
									<input type="text" class="form-control" name="da" value="<?php if($oi['title']=='')echo$i['title'];else echo$oi['title'];?>">
								</form>
							</td>
							<td class="col-md-1 text-center">
<?php			if($oi['iid']!=0){?>
								<form target="sp" action="core/update.php">
									<input type="hidden" name="id" value="<?php echo$oi['id'];?>">
									<input type="hidden" name="t" value="orderitems">
									<input type="hidden" name="c" value="quantity">
									<input class="form-control text-center" name="da" value="<?php echo$oi['quantity'];?>"<?php if($r['status']=='archived')echo' readonly';?>>
								</form>
<?php			}else{
					if($oi['iid']!=0)echo$oi['quantity'];
				}?>
							</td>
							<td class="col-md-1 text-right">
<?php			if($oi['iid']!=0){?>
								<form target="sp" action="core/update.php">
									<input type="hidden" name="id" value="<?php echo$oi['id'];?>">
									<input type="hidden" name="t" value="orderitems">
									<input type="hidden" name="c" value="cost">
									<div class="input-group">
										<input class="form-control text-center" name="da" value="<?php echo$oi['cost'];?>"<?php if($r['status']=='archived')echo' readonly';?>>
									</div>
								</form>
<?php			}else if($oi['iid']!=0)echo$oi['cost'];?>
							</td>
							<td class="text-right"><?php if($oi['iid']!=0)echo$oi['cost']*$oi['quantity'];?></td>
							<td class="text-right">
								<form target="sp" action="core/update.php">
									<input type="hidden" name="id" value="<?php echo$oi['id'];?>">
									<input type="hidden" name="t" value="orderitems">
									<input type="hidden" name="c" value="quantity">
									<input type="hidden" name="da" value="0">
									<button class="btn btn-default"><?php if($config['buttonType']=='text')echo'Delete';else echo'<i class="libre libre-trash text-danger"></i>';?></button>
								</form>
							</td>
						</tr>
<?php			if($oi['iid']!=0)$total=$total+($oi['cost']*$oi['quantity']);
			}?>
						<tr>
							<td colspan="3">&nbsp;</td>
							<td class="text-right"><strong>Total</strong></td>
							<td class="text-right"><strong><?php echo$total;?></strong></td>
							<td></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3">&nbsp;</td>
							<td colspan="3">
								<div class="btn-group pull-right">
									<button class="btn btn-info" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');"><i class="libre libre-print visible-xs"></i><span class="hidden-xs">Print</span></button>
									<button class="btn btn-info" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=');"><i class="libre libre-email-send visible-xs"></i><span class="hidden-xs">Email</span></button>
								</div>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="row">
				<div class="input-group col-lg-4 col-sm-5">
<?php		if($r['status']!='archived'&&$user['rank']>699){?>
					<form target="sp" action="core/update.php">
						<input type="hidden" name="id" value="<?php echo$r['id'];?>">
						<input type="hidden" name="t" value="orders">
						<input type="hidden" name="c" value="notes">
						<textarea class="summernote" name="da"><?php echo$r['notes'];?></textarea>
					</form>
<?php		}else{?>
					<div class="well"><?php echo$r['notes'];?></div>
<?php		}?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php	}
	}else{
		if($args[0]=='all'||$args[0]==''){
			$sort="all";
			if($user['rank']==300){
				$s=$db->prepare("SELECT * FROM orders WHERE aid='' AND cid=:cid ORDER BY ti DESC");
				$s->execute(array(':cid'=>$user['id']));
			}else{
				$s=$db->prepare("SELECT * FROM orders WHERE aid='' ORDER BY ti DESC");
				$s->execute();
			}
		}
		if($args[0]=='quotes'){
			$s=$db->prepare("SELECT * FROM orders WHERE qid!='' AND iid='' AND aid='' ORDER BY ti DESC");
			$s->execute();
		}
		if($args[0]=='invoices'){
			$s=$db->prepare("SELECT * FROM orders WHERE qid='' AND iid!='' ORDER BY ti DESC");
			$s->execute();
		}
		if($args[0]=='archived'){
			$s=$db->prepare("SELECT * FROM orders WHERE aid!='' ORDER BY ti DESC");
			$s->execute();
		}
		if($args[0]=='pending'){
			$s=$db->prepare("SELECT * FROM orders WHERE status='pending' ORDER BY ti DESC");
			$s->execute();
		}?>
<div class="page-toolbar">
	<div class="pull-right">
		<div class="btn-group">
			<button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><i class="libre libre-view visible-xs"></i><span class="hidden-xs">Show</span></button>
			<ul class="dropdown-menu pull-right">
				<li><a href="admin/orders/all">All</a></li>
				<li><a href="admin/orders/quotes">Quotes</a></li>
				<li><a href="admin/orders/invoices">Invoices</a></li>
				<li><a href="admin/orders/archived">Archived</a></li>
				<li><a href="admin/orders/pending">Pending</a></li>
			</ul>
		</div>
		<div class="btn-group">
			<button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-placement="right"><i class="libre libre-plus visible-xs"></i><span class="hidden-xs">Add</span></button>
			<ul class="dropdown-menu multi-level pull-right">
				<li><a href="<?php echo URL;?>admin/orders/addquote">Quote</a></li>
				<li><a href="<?php echo URL;?>admin/orders/addinvoice">Invoice</a></li>
			</ul>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive">
<?php if($user['rank']==1000||$user['options']{0}==1){?>

<?php }?>
			<table id="stupidtable" class="table table-condensed table-hover">
				<thead>
					<tr>
						<th data-sort="string">Order #</th>
						<th class="hidden-xs" data-sort="string">Client</th>
						<th class="hidden-xs" data-sort="string">Created</th>
						<th class="hidden-xs" data-sort="string">Due</th>
						<th data-sort="string">Status</th>
						<th class="col-xs-3"></th>
					</tr>
				</thead>
				<tbody>
<?php	while($r=$s->fetch(PDO::FETCH_ASSOC)){
			if($r['due_ti']<$ti){
				$us=$db->prepare("UPDATE orders SET status='overdue' WHERE id=:id");
				$us->execute(array(':id'=>$r['id']));
				$r['status']='overdue';
			}
			$cs=$db->prepare("SELECT username,name,business FROM login WHERE id=:id");
			$cs->execute(array(':id'=>$r['cid']));
			$c=$cs->fetch(PDO::FETCH_ASSOC);?>
					<tr id="l_<?php echo$r['id'];?>"<?php if($r['status']=='delete')echo' class="danger"';?>>
						<td>
							<?php echo$r['qid'].$r['iid'];if($r['aid']!='')echo' / '.$r['aid'];?>
							<small class="visible-xs hidden-sm hidden-md hidden-lg"><?php echo$c['username'];if($c['name']!='')echo' ['.$c['name'].']';if($c['business']!='')echo' -> '.$c['business'];?></span>
						</td>
						<td class="hidden-xs">
							<?php echo$c['username'];if($c['name']!='')echo' ['.$c['name'].']';if($c['business']!='')echo' -> '.$c['business'];?>
						</td>
						<td class="hidden-xs"><?php echo date($config['dateFormat'],$r['qid_ti']);?></td>
						<td class="hidden-xs"><?php echo date($config['dateFormat'],$r['due_ti']);?></td>
						<td><?php echo $r['status'];?></td>
						<td>
							<div id="controls_<?php echo$r['id'];?>" class="btn-group pull-right">
<?php		if($r['qid']!=''&&$r['aid']==''){?>
								<a class="btn btn-info btn-xs<?php if($r['status']=='delete')echo' hidden';?>" href="admin/orders/to_invoice/<?php echo$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Convert to Invoice"';?>><i class="libre libre-order-quotetoinvoice visible-xs"></i><span class="hidden-xs">to Invoice</span></a>
<?php		}
			if($r['aid']==''){?>
								<button class="btn btn-info btn-xs<?php if($r['status']=='delete')echo' hidden';?>" onclick="update('<?php echo$r['id'];?>','orders','status','archived')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Archive"';?>><i class="libre libre-archive visible-xs"></i><span class="hidden-xs">Archive</span></button>
<?php		}?>
								<button class="btn btn-info btn-xs" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Print Order"';?>><i class="libre libre-print visible-xs"></i><span class="hidden-xs">Print</span></button>
								<button class="btn btn-info btn-xs" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Email Order"';?>><i class="libre libre-email-send visible-xs"></i><span class="hidden-xs">Email</span></button>
								<a class="btn btn-info btn-xs<?php if($r['status']=='delete')echo' hidden';?>" href="admin/orders/view/<?php echo$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><i class="libre libre-edit visible-xs"></i><span class="hidden-xs">Edit</span></a>
<?php		if($user['rank']>399){?>
								<button class="btn btn-warning btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','orders','status','')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><i class="libre libre-email-reply visible-xs"></i><span class="hidden-xs">Restore</span></button>
								<button class="btn btn-danger btn-xs<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','orders','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><i class="libre libre-trash visible-xs"></i><span class="hidden-xs">Delete</span></button>
								<button class="btn btn-danger btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','orders')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><i class="libre libre-purge visible-xs"></i><span class="hidden-xs">Purge</span></button>
<?php		}?>
							</div>
						</td>
					</tr>
<?php	}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php }
