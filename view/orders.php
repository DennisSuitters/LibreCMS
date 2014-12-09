<?php
$content.='<main id="content" class="libr8-col-md-12">';
	$content.='<div class="libr8-panel libr8-panel-default">';
		$content.='<div class="libr8-panel-body">';
if($user['rank']>299){
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
		if($error==1){
			$content.='<div class="libr8-alert libr8-alert-danger">'.$e[0].'</div>';
		}else{
			$content.='<div class="invoice">';
				$content.='<div class="libr8-row libr8-header">';
					$content.='<div class="libr8-col-sm-4">';
						$content.='<h2>From</h2>';
						$content.='<p><strong>'.$config['business'].'</strong></p>';
						$content.='<p>ABN: '.$config['abn'].'</p>';
						$content.='<p>'.$config['address'].'</p>';
						$content.='<p>';if($config['suburb']!=''){$content.=$config['suburb'].', ';}if($config['city']!=''){$content.=$config['city'].', ';}$content.='</p>';
						$content.='<p>';if($config['state']!=''){$content.=$config['state'].', ';}if($config['postcode']!=0){$content.=$config['postcode'];}$content.='</p>';
						$content.='<p>Email: '.$config['email'].'</p>';
						$content.='<p>Phone: '.$config['phone'].'</p>';
					$content.='</div>';
					$content.='<div class="libr8-col-sm-4">';
						$content.='<h2>To</h2>';
						$content.='<div id="cdetails">';
							$content.='<p><strong>'.$client['business'].'</strong></p>';
							$content.='<p>';if($client['address']!=''){$content.=$client['address'];}$content.='</p>';
							$content.='<p>';if($client['suburb']!=''){$content.=$client['suburb'].', ';}if($client['city']!=''){$content.=$client['city'];}$content.='</p>';
							$content.='<p>';if($client['state']!=''){$content.=$client['state'].', ';}if($client['postcode']!=0){$content.=$client['postcode'];}$content.='</p>';
							$content.='<p>Email: <a href="mailto:'.$client['email'].'">'.$client['email'].'</a></p>';
							$content.='<p>';if($client['phone']!=''){$content.='Phone: '.$client['phone'];}$content.='</p>';
							$content.='<p>';if($client['mobile']!=''){$content.='Mobile: '.$client['mobile'];}$content.='</p>';
						$content.='</div>';
			if($r['status']!='archived'&&$user['rank']>699){
						$content.='<p>';
							$content.='<select id="changeClient" class="relative libr8-form-control libr8-input-sm" onchange="changeClient($(this).val(),\''.$r['id'].'\');">';
								$content.='<option value="0"';if($r['cid']=='0'){$content.=' selected';}$content.='None</option>';
				$q=$db->query("SELECT id,business,username,name FROM login WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
				while($rs=$q->fetch(PDO::FETCH_ASSOC)){
					$content.='<option value="'.$rs['id'].'"';if($r['cid']==$rs['id']){$content.=' selected';}$content.='>'.$rs['username'];if($rs['name']!=''){$content.=' ['.$rs['name'].']';}if($rs['business']!=''){$content.=' -> '.$rs['business'];}$content.='</option>';
				}
							$content.='</select>';
						$content.='</p>';
			}
					$content.='</div>';
					$content.='<div class="libr8-col-sm-4">';
						$content.='<h2>Details</h2>';
						$content.='<p>Order #<strong>'.$r['qid'].$r['iid'].'</strong></p>';
						$content.='<p>Order Date: <strong>'.date($config['dateFormat'],$r['qid_ti'].$r['iid_ti']).'</strong></p>';
						$content.='<div class="libr8-form-inline">';
							$content.='<p class="libr8-form-group">';
								$content.='Due Date: <strong id="due_ti">'.date($config['dateFormat'],$r['due_ti']).'</strong> &nbsp;';
			if($r['status']!='archived'&&$user['rank']>699){
								$content.='<div class="libr8-btn-group">';
									$content.='<button class="libr8-btn libr8-btn-default libr8-btn-xs libr8-dropdown-toggle" data-toggle="dropdown">Add <span class="caret"></span></button>';
									$content.='<ul class="libr8-dropdown-menu libr8-pull-right">';
										$content.='<li><a href="#" onclick="update(\''.$r['id'].'\',\'orders\',\'due_ti\',\'';$content.=$r['due_ti']+604800;$content.='\');return false;">7 Days</a></li>';
										$content.='<li><a href="#" onclick="update(\''.$r['id'].'\',\'orders\',\'due_ti\',\'';$content.=$r['due_ti']+1209600;$content.='\');return false;">14 Days</a></li>';
										$content.='<li><a href="#" onclick="update(\''.$r['id'].'\',\'orders\',\'due_ti\',\'';$content.=$r['due_ti']+1814400;$content.='\');return false;">21 Days</a></li>';
										$content.='<li><a href="#" onclick="update(\''.$r['id'].'\',\'orders\',\'due_ti\',\'';$content.=$r['due_ti']+2592000;$content.='\');return false;">30 Days</a></li>';
									$content.='</ul>';
								$content.='</div>';
			}
							$content.='</p>';
						$content.='</div>';
						$content.='<div class="libr8-form-inline">';
							$content.='<p class="libr8-form-group">Status: ';
			if($r['status']=='archived'){
								$content.='<strong>Archived</strong>';
			}elseif($user['rank']>699){
								$content.='<select id="status" class="libr8-form-control libr8-input-sm relative" onchange="update(\''.$r['id'].'\',\'orders\',\'status\',$(this).val());">';
									$content.='<option value="pending"';if($r['status']=='pending'){$content.=' selected';}$content.='>Pending</option>';
									$content.='<option value="overdue"';if($r['status']=='overdue'){$content.=' selected';}$content.='>Overdue</option>';
									$content.='<option value="cancelled"';if($r['status']=='cancelled'){$content.=' selected';}$content.='>Cancelled</option>';
									$content.='<option value="paid"';if($r['status']=='paid'){$content.=' selected';}$content.='>Paid</option>';
								$content.='</select>';
			}else{
				$content.=ucfirst($r['status']);
			}
							$content.='</p>';
						$content.='</div>';
			if($r['iid']!=''&&$user['rank']>699){
						$content.='<p>Recurring <input type="checkbox" onclick="update(\''.$r['id'].'\',\'orders\',\'recurring\',\'checkbox\');"';if($r['recurring']==1){$content.=' checked';}$content.='></p>';
			}
					$content.='</div>';
				$content.='</div>';
				$content.='<table class="libr8-table libr8-table-striped libr8-table-responsive">';
					$content.='<thead>';
			if($r['status']!='archived'&&$user['rank']>699){
						$content.='<tr>';
							$content.='<th colspan="6">';
								$content.='<div class="libr8-form-group">';
									$content.='<div class="libr8-input-group libr8-col-sm-12">';
										$content.='<select id="addItem" class="libr8-form-control">';
											$content.='<option value="0">Add Empty Entry</option>';
				$s=$db->query("SELECT id,contentType,code,cost,title FROM content WHERE contentType='inventory' OR contentType='service' OR contentType='events' ORDER BY code ASC");
				while($i=$s->fetch(PDO::FETCH_ASSOC)){
					$content.='<option value="'.$i['id'].'">'.ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'].'</option>';
				}
										$content.='</select>';
										$content.='<span class="libr8-input-group-btn">';
											$content.='<button class="libr8-btn libr8-btn-success" onclick="addOrderItem(\''.$r['id'].'\',$(\'#addItem\').val());">Add</button>';
										$content.='</span>';
									$content.='</div>';
								$content.='</div>';
							$content.='</th>';
						$content.='</tr>';
			}
						$content.='<tr>';
							$content.='<th>Code</th>';
							$content.='<th>Title</th>';
							$content.='<th class="libr8-col-sm-1 libr8-text-center">Quantity</th>';
							$content.='<th class="libr8-col-sm-1 libr8-text-center">Cost</th>';
							$content.='<th class="libr8-col-sm-1 libr8-text-right">Total</th>';
							$content.='<th class="libr8-col-sm-1"></th>';
						$content.='</tr>';
					$content.='</thead>';
					$content.='<tbody id="updateorder">';
			$s=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid ORDER BY ti DESC,title ASC");
			$s->execute(array(':oid'=>$r['id']));
			$total=0;
			while($oi=$s->fetch(PDO::FETCH_ASSOC)){
				$is=$db->prepare("SELECT id,code,title FROM content WHERE id=:id");
				$is->execute(array(':id'=>$oi['iid']));
				$i=$is->fetch(PDO::FETCH_ASSOC);
						$content.='<tr>';
							$content.='<td class="libr8-text-left">'.$i['code'].'</td>';
							$content.='<td class="libr8-text-left">';
				if($user['rank']>699){
								$content.='<form target="sp" action="includes/update.php">';
									$content.='<input type="hidden" name="id" value="'.$oi['id'].'">';
									$content.='<input type="hidden" name="t" value="orderitems">';
									$content.='<input type="hidden" name="c" value="title">';
									$content.='<input type="text" class="libr8-form-control" name="da" value="';
										if($oi['title']==''){
											$content.=$i['title'];
										}else{
											$content.=$oi['title'];
										}
										$content.='">';
								$content.='</form>';
				}else{
					if($oi['title']==''){$content.=$i['title'];}else{$content.=$oi['title'];}
				}
							$content.='</td>';
							$content.='<td class="libr8-col-md-1 libr8-text-center">';
				if($oi['iid']!=0&&$user['rank']>699){
								$content.='<form target="sp" action="includes/update.php">';
									$content.='<input type="hidden" name="id" value="'.$oi['id'].'">';
									$content.='<input type="hidden" name="t" value="orderitems">';
									$content.='<input type="hidden" name="c" value="quantity">';
									$content.='<input class="libr8-form-control libr8-text-center" name="da" value="'.$oi['quantity'].'"';if($r['status']=='archived'){$content.=' readonly';}$content.='>';
								$content.='</form>';
				}else{
					if($oi['iid']!=0){
						$content.=$oi['quantity'];
					}
				}
							$content.='</td>';
							$content.='<td class="libr8-col-md-1 libr8-text-right">';
				if($oi['iid']!=0&&$user['rank']>699){
								$content.='<form target="sp" action="includes/update.php">';
									$content.='<input type="hidden" name="id" value="'.$oi['id'].'">';
									$content.='<input type="hidden" name="t" value="orderitems">';
									$content.='<input type="hidden" name="c" value="cost">';
									$content.='<div class="libr8-input-group">';
										$content.='<input class="libr8-form-control libr8-text-center" name="da" value="'.$oi['cost'].'"';if($r['status']=='archived'){$content.=' readonly';}$content.='>';
									$content.='</div>';
								$content.='</form>';
				}else{
					if($oi['iid']!=0){
						$content.=$oi['cost'];
					}
				}
							$content.='</td>';
							$content.='<td class="libr8-text-right">';
				if($oi['iid']!=0){$content.=$oi['cost']*$oi['quantity'];}
							$content.='</td>';
							$content.='<td class="libr8-text-right">';
				if($user['rank']>699){
                                $content.='<form target="sp" action="includes/update.php">';
                                    $content.='<input type="hidden" name="id" value="'.$oi['id'].'">';
                                    $content.='<input type="hidden" name="t" value="orderitems">';
                                    $content.='<input type="hidden" name="c" value="quantity">';
                                    $content.='<input type="hidden" name="da" value="0">';
                                    $content.='<button class="libr8-btn libr8-btn-danger"><i class="fa fa-trash"></i></button>';
                                $content.='</form>';
				}
							$content.='</td>';
						$content.='</tr>';
				if($oi['iid']!=0){
					$total=$total+($oi['cost']*$oi['quantity']);
				}
			}
						$content.='<tr>';
							$content.='<td colspan="3">&nbsp;</td>';
							$content.='<td class="libr8-text-right"><strong>Total</strong></td>';
							$content.='<td class="libr8-text-right"><strong>'.$total.'</strong></td>';
							$content.='<td></td>';
						$content.='</tr>';
					$content.='</tbody>';
					$content.='<tfoot>';
						$content.='<tr>';
							$content.='<td colspan="3">&nbsp;</td>';
							$content.='<td colspan="2" class="libr8-text-right">';
								$content.='<button class="libr8-btn libr8-btn-info" onclick="$(\'#sp\').load(\'includes/email_order.php?id='.$r['id'].'&act=print\');">Print</button> ';
							$content.='</td>';
							$content.='<td class="libr8-text-right">';
								$content.='<button class="libr8-btn libr8-btn-info" onclick="$(\'#sp\').load(\'includes/email_order.php?id='.$r['id'].'&act=\');">Email</button>';
							$content.='</td>';
						$content.='</tr>';
					$content.='</tfoot>';
				$content.='</table>';
				$content.='<div class="libr8-row">';
					$content.='<div class="libr8-input-group libr8-col-lg-4 libr8-col-sm-5">';
			if($r['status']!='archived'&&$user['rank']>699){
						$content.='<form target="sp" action="includes/update.php">';
							$content.='<input type="hidden" name="id" value="'.$r['id'].'">';
							$content.='<input type="hidden" name="t" value="orders">';
							$content.='<input type="hidden" name="c" value="notes">';
							$content.='<textarea class="summernote" name="da">'.$r['notes'].'</textarea>';
						$content.='</form>';
			}else{
						$content.='<div class="libr8-well">'.$r['notes'].'</div>';
			}
					$content.='</div>';
				$content.='</div>';
			$content.='</div>';
		}
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
				$content.='View <div class="libr8-btn-group">';
					$content.='<button class="libr8-btn libr8-btn-default libr8-btn-xs libr8-dropdown-toggle" data-toggle="dropdown">'.ucfirst($args[0]).' <i class="libr8-caret"></i></button>';
					$content.='<ul class="libr8-dropdown-menu">';
						$content.='<li><a href="admin/orders/all">All</a></li>';
						$content.='<li><a href="admin/orders/quotes">Quotes</a></li>';
						$content.='<li><a href="admin/orders/invoices">Invoices</a></li>';
						$content.='<li><a href="admin/orders/archived">Archived</a></li>';
					$content.='</ul>';
				$content.='</div>';
				$content.='<table class="libr8-table">';
					$content.='<thead>';
						$content.='<tr>';
							$content.='<th>Order #</th>';
							$content.='<th>Client</th>';
							$content.='<th>Created</th>';
							$content.='<th>Due</th>';
							$content.='<th>Status</th>';
							$content.='<th class="libr8-col-md-3 libr8-text-right"></th>';
						$content.='</tr>';
					$content.='</thead>';
					$content.='<tbody>';
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
						$content.='<tr id="l_'.$r['id'].'"';if($r['status']=='delete'){$content.=' class="libr8-danger"';}$content.='>';
							$content.='<td>'.$r['qid'].$r['iid'];if($r['aid']!=''){$content.=' / '.$r['aid'];}$content.='</td>';
							$content.='<td>';
			$cs=$db->prepare("SELECT business,name FROM login WHERE id=:id");
			$cs->execute(array(':id'=>$r['cid']));
			$c=$cs->fetch(PDO::FETCH_ASSOC);
			$content.=$c['business'].':'.$c['name'];
							$content.='</td>';
							$content.='<td>'.date($config['dateFormat'],$r['qid_ti'].$r['iid_ti']).'</td>';
							$content.='<td>'.date($config['dateFormat'],$r['due_ti']).'</td>';
							$content.='<td>'.$r['status'].'</td>';
							$content.='<td id="controls_'.$r['id'].'" class="libr8-text-right">';
			if($r['qid']!=''&&$r['aid']==''&&$user['rank']>699){
								$content.='<a class="libr8-btn libr8-btn-info libr8-btn-xs';if($r['status']=='delete'){$content.=' libr8-hidden';}$content.='" href="admin/orders/to_invoice/'.$r['id'].'">Invoice</a> ';
			}
			if($r['aid']==''&&$user['rank']>699){
								$content.='<button class="libr8-btn libr8-btn-info libr8-btn-xs';if($r['status']=='delete'){$content.=' libr8-hidden';}$content.='" onclick="update(\''.$r['id'].'\',\'orders\',\'status\',\'archived\')">Archive</button> ';
			}
								$content.='<a class="libr8-btn libr8-btn-primary libr8-btn-xs';if($r['status']=='delete'){$content.=' libr8-hidden';}$content.='" href="admin/orders/view/'.$r['id'].'">View</a> ';
			if($user['rank']>699){
								$content.='<button class="libr8-btn libr8-btn-primary libr8-btn-xs';if($r['status']!='delete'){$content.=' libr8-hidden';}$content.='" onclick="updateButtons(\''.$r['id'].'\',\'orders\',\'status\',\'\')">Restore</button> ';
								$content.='<button class="libr8-btn libr8-btn-danger libr8-btn-xs';if($r['status']=='delete'){$content.=' libr8-hidden';}$content.='" onclick="updateButtons(\''.$r['id'].'\',\'orders\',\'status\',\'delete\')">Delete</button> ';
								$content.='<button class="libr8-btn libr8-btn-warning libr8-btn-xs';if($r['status']!='delete'){$content.=' libr8-hidden';}$content.='" onclick="purge(\''.$r['id'].'\',\'orders\')">Purge</button>';
			}
							$content.='</td>';
						$content.='</tr>';
		}
					$content.='</tbody>';
				$content.='</table>';
			$content.='</div>';
	}
}else{
	include'includes/noaccess.php';
}
		$content.='</div>';
	$content.='</div>';
$content.='</main>';
