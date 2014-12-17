<main id="content" class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-body">
<?php if($user['rank']>699){
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
		if($error==1){?>
			<div class="alert alert-danger"><?php echo$e[0];?></div>
<?php	}else{?>
			<div class="invoice">
				<div class="row header">
					<div class="col-sm-4">
						<h2>From</h2>
						<p><strong><?php echo$config['business'];?></strong></p>
						<p>ABN: <?php echo$config['abn'];?></p>
						<p><?php echo$config['address'];?></p>
						<p><?php if($config['suburb']!=''){echo$config['suburb'].', ';}if($config['city']!=''){echo$config['city'].', ';}?></p>
						<p><?php if($config['state']!=''){echo$config['state'].', ';}if($config['postcode']!=0){echo$config['postcode'];}?></p>
						<p>Email: <?php echo$config['email'];?></p>
						<p>Phone: <?php echo$config['phone'];?></p>
					</div>
					<div class="col-sm-4">
						<h2>To</h2>
						<div id="cdetails">
							<p><strong><?php echo$client['business'];?></strong></p>
							<p><?php if($client['address']!=''){echo$client['address'];}?></p>
							<p><?php if($client['suburb']!=''){echo$client['suburb'].', ';}if($client['city']!=''){echo$client['city'];}?></p>
							<p><?php if($client['state']!=''){echo$client['state'].', ';}if($client['postcode']!=0){echo$client['postcode'];}?></p>
							<p>Email: <a href="mailto:'.$client['email'].'"><?php echo$client['email'];?></a></p>
							<p><?php if($client['phone']!=''){echo'Phone: '.$client['phone'];}?></p>
							<p><?php if($client['mobile']!=''){echo'Mobile: '.$client['mobile'];}?></p>
						</div>
<?php		if($r['status']!='archived'&&$user['rank']>699){?>
						<p>
							<select id="changeClient" class="relative form-control input-sm" onchange="changeClient($(this).val(),'<?php echo$r['id'];?>');">
								<option value="0"<?php if($r['cid']=='0'){echo' selected';}?>>None</option>
<?php			$q=$db->query("SELECT id,business,username,name FROM login WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
				while($rs=$q->fetch(PDO::FETCH_ASSOC)){?>
								<option value="<?php echo$rs['id'];?>"<?php if($r['cid']==$rs['id']){echo' selected';}echo'>'.$rs['username'];if($rs['name']!=''){echo' ['.$rs['name'].']';}if($rs['business']!=''){echo' -> '.$rs['business'];}?></option>
<?php			}?>
							</select>
						</p>
<?php		}?>
					</div>
					<div class="col-sm-4">
						<h2>Details</h2>
						<p>Order #<strong><?php echo$r['qid'].$r['iid'];?></strong></p>
						<p>Order Date: <strong><?php echo date($config['dateFormat'],$r['qid_ti'].$r['iid_ti']);?></strong></p>
						<div class="form-inline">
							<p class="form-group">
								Due Date: <strong id="due_ti"><?php echo date($config['dateFormat'],$r['due_ti']);?></strong> &nbsp;
<?php		if($r['status']!='archived'&&$user['rank']>699){?>
								<div class="btn-group">
									<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">Add <span class="caret"></span></button>
									<ul class="dropdown-menu pull-right">
										<li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+604800;?>');return false;">7 Days</a></li>
										<li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti',''<?php echo$r['due_ti']+1209600;?>');return false;">14 Days</a></li>
										<li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti',''<?php echo$r['due_ti']+1814400;?>');return false;">21 Days</a></li>
										<li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti',''<?php echo$r['due_ti']+2592000;?>');return false;">30 Days</a></li>
									</ul>
								</div>
<?php		}?>
							</p>
						</div>
						<div class="form-inline">
							<p class="form-group">Status: <?php if($r['status']=='archived'){echo'<strong>Archived</strong>';}elseif($user['rank']>699){?>
								<select id="status" class="form-control input-sm relative" onchange="update('<?php echo$r['id'];?>','orders','status',$(this).val());">
									<option value="pending"<?php if($r['status']=='pending'){echo' selected';}?>>Pending</option>
									<option value="overdue"<?php if($r['status']=='overdue'){echo' selected';}?>>Overdue</option>
									<option value="cancelled"<?php if($r['status']=='cancelled'){echo' selected';}?>>Cancelled</option>
									<option value="paid"<?php if($r['status']=='paid'){echo' selected';}?>>Paid</option>
								</select>
<?php		}else{
				echo ucfirst($r['status']);
			}?>
							</p>
						</div>
<?php		if($r['iid']!=''&&$user['rank']>699){?>
						<p>Recurring <input type="checkbox" onclick="update('<?php echo$r['id'];?>','orders','recurring','checkbox');"<?php if($r['recurring']==1){echo' checked';}?>></p>
<?php		}?>
					</div>
				</div>
				<table class="libr8 table table-striped table-responsive">
					<thead>
<?php		if($r['status']!='archived'&&$user['rank']>699){?>
						<tr class="libr8">
							<th colspan="6">
								<div class="form-group">
									<div class="input-group col-sm-12">
										<select id="addItem" class="form-control">
											<option value="0">Add Empty Entry</option>
<?php			$s=$db->query("SELECT id,contentType,code,cost,title FROM content WHERE contentType='inventory' OR contentType='service' OR contentType='events' ORDER BY code ASC");
				while($i=$s->fetch(PDO::FETCH_ASSOC)){?>
											<option value="<?php echo$i['id'];?>"><?php echo ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'];?></option>
<?php			}?>
										</select>
										<span class="input-group-btn">
											<button class="btn btn-success" onclick="addOrderItem('<?php echo$r['id'];?>',$(\'#addItem\').val());">Add</button>
										</span>
									</div>
								</div>
							</th>
						</tr>
<?php		}?>
						<tr class="libr8">
							<th>Code</th>
							<th>Title</th>
							<th class="col-sm-1 text-center">Quantity</th>
							<th class="col-sm-1 text-center">Cost</th>
							<th class="col-sm-1 text-right">Total</th>
							<th class="col-sm-1"></th>
						</tr>
					</thead>
					<tbody id="updateorder">
<?php		$s=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid ORDER BY ti DESC,title ASC");
			$s->execute(array(':oid'=>$r['id']));
			$total=0;
			while($oi=$s->fetch(PDO::FETCH_ASSOC)){
				$is=$db->prepare("SELECT id,code,title FROM content WHERE id=:id");
				$is->execute(array(':id'=>$oi['iid']));
				$i=$is->fetch(PDO::FETCH_ASSOC);?>
						<tr class="libr8">
							<td class="text-left"><?php echo$i['code'];?></td>
							<td class="text-left">
<?php			if($user['rank']>699){?>
								<form target="sp" action="includes/update.php">
									<input type="hidden" name="id" value="<?php echo$oi['id'];?>">
									<input type="hidden" name="t" value="orderitems">
									<input type="hidden" name="c" value="title">
									<input type="text" class="form-control" name="da" value="<?php if($oi['title']==''){echo$i['title'];}else{echo$oi['title'];}?>">
								</form>
<?php			}else{
					if($oi['title']==''){echo$i['title'];}else{echo$oi['title'];}
				}?>
							</td>
							<td class="col-md-1 text-center">
<?php			if($oi['iid']!=0&&$user['rank']>699){?>
								<form target="sp" action="includes/update.php">
									<input type="hidden" name="id" value="<?php echo$oi['id'];?>">
									<input type="hidden" name="t" value="orderitems">
									<input type="hidden" name="c" value="quantity">
									<input class="form-control text-center" name="da" value="<?php echo$oi['quantity'];?>"<?php if($r['status']=='archived'){echo' readonly';}?>>
								</form>
<?php			}else{
					if($oi['iid']!=0){
						echo$oi['quantity'];
					}
				}?>
							</td>
							<td class="col-md-1 text-right">
<?php			if($oi['iid']!=0&&$user['rank']>699){?>
								<form target="sp" action="includes/update.php">
									<input type="hidden" name="id" value="<?php echo$oi['id'];?>">
									<input type="hidden" name="t" value="orderitems">
									<input type="hidden" name="c" value="cost">
									<div class="input-group">
										<input class="form-control text-center" name="da" value="<?php echo$oi['cost'];?>"<?php if($r['status']=='archived'){echo' readonly';}?>>
									</div>
								</form>
<?php			}else{
					if($oi['iid']!=0){
						echo$oi['cost'];
					}
				}?>
							</td>
							<td class="text-right"><?php if($oi['iid']!=0){echo$oi['cost']*$oi['quantity'];}?></td>
							<td class="text-right">
<?php			if($user['rank']>699){?>
								<form target="sp" action="includes/update.php">
									<input type="hidden" name="id" value="<?php echo$oi['id'];?>">
									<input type="hidden" name="t" value="orderitems">
									<input type="hidden" name="c" value="quantity">
									<input type="hidden" name="da" value="0">
									<button class="btn btn-danger"><i class="fa fa-trash"></i></button>
								</form>
<?php			}?>
							</td>
						</tr>
<?php			if($oi['iid']!=0){
					$total=$total+($oi['cost']*$oi['quantity']);
				}
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
							<td colspan="2" class="text-right">
								<button class="btn btn-info" onclick="$('#sp').load('includes/email_order.php?id=<?php echo$r['id'];?>&act=print');">Print</button> 
							</td>
							<td class="text-right">
								<button class="btn btn-info" onclick="$('#sp').load('includes/email_order.php?id=<?php echo$r['id'];?>&act=');">Email</button>
							</td>
						</tr>
					</tfoot>
				</table>
				<div class="row">
					<div class="input-group col-lg-4 col-sm-5">
<?php		if($r['status']!='archived'&&$user['rank']>699){?>
						<form target="sp" action="includes/update.php">
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
		}?>
				View <div class="btn-group">
					<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"><?php echo ucfirst($args[0]);?> <i class="caret"></i></button>
					<ul class="dropdown-menu">
						<li><a href="admin/orders/all">All</a></li>
						<li><a href="admin/orders/quotes">Quotes</a></li>
						<li><a href="admin/orders/invoices">Invoices</a></li>
						<li><a href="admin/orders/archived">Archived</a></li>
					</ul>
				</div>
				<table class="table">
					<thead>
						<tr class="libr8">
							<th>Order #</th>
							<th>Client</th>
							<th>Created</th>
							<th>Due</th>
							<th>Status</th>
							<th class="col-md-3 text-right"></th>
						</tr>
					</thead>
					<tbody>
<?php	while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
						<tr id="l_<?php echo$r['id'];?>"<?php if($r['status']=='delete'){echo' class="danger"';}?>>
							<td><?php echo$r['qid'].$r['iid'];if($r['aid']!=''){echo' / '.$r['aid'];}?></td>
							<td>
<?php		$cs=$db->prepare("SELECT business,name FROM login WHERE id=:id");
			$cs->execute(array(':id'=>$r['cid']));
			$c=$cs->fetch(PDO::FETCH_ASSOC);
			echo$c['business'].':'.$c['name'];?>
							</td>
							<td><?php echo date($config['dateFormat'],$r['qid_ti'].$r['iid_ti']);?></td>
							<td><?php echo date($config['dateFormat'],$r['due_ti']);?></td>
							<td><?php echo $r['status'];?></td>
							<td id="controls_<?php echo$r['id'];?>" class="text-right">
<?php		if($r['qid']!=''&&$r['aid']==''&&$user['rank']>699){?>
								<a class="btn btn-info btn-xs<?php if($r['status']=='delete'){echo' hidden';}?>" href="admin/orders/to_invoice/<?php echo$r['id'];?>">Invoice</a> 
<?php		}
			if($r['aid']==''&&$user['rank']>699){?>
								<button class="btn btn-info btn-xs<?php if($r['status']=='delete'){echo' hidden';}?>" onclick="update('<?php echo$r['id'];?>','orders','status','archived')">Archive</button> 
<?php		}?>
								<a class="btn btn-primary btn-xs<?php if($r['status']=='delete'){echo' hidden';}?>" href="admin/orders/view/<?php echo$r['id'];?>">View</a> 
<?php		if($user['rank']>699){?>
								<button class="btn btn-primary btn-xs<?php if($r['status']!='delete'){echo' hidden';}?>" onclick="updateButtons('<?php echo$r['id'];?>','orders','status','')">Restore</button> 
								<button class="btn btn-danger btn-xs<?php if($r['status']=='delete'){echo' hidden';}?>" onclick="updateButtons('<?php echo$r['id'];?>','orders','status','delete')">Delete</button> 
								<button class="btn btn-warning btn-xs<?php if($r['status']!='delete'){echo' hidden';}?>" onclick="purge('<?php echo$r['id'];?>','orders')">Purge</button>
<?php		}?>
							</td>
						</tr>
<?php	}?>
					</tbody>
				</table>
			</div>
<?php }
}else{
	include'includes/noaccess.php';
}?>
		</div>
	</div>
</main>
