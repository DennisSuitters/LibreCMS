<?php
if(isset($_SESSION['uid']))$uid=$_SESSION['uid'];else$uid=0;
$error=0;
$oid='';
if(isset($args[1]))$id=$args[1];
if($args[0]=='duplicate'){
    $sd=$db->prepare("SELECT * FROM orders WHERE id=:id");
    $sd->execute(array(':id'=>$id));
    $rd=$sd->fetch(PDO::FETCH_ASSOC);
    $s=$db->prepare("INSERT INTO orders (cid,uid,contentType,due_ti,notes,status,recurring,ti) VALUES (:cid,:uid,:contentType,:due_ti,:notes,:status,:recurring,:ti)");
    $s->execute(array(':cid'=>$rd['cid'],':uid'=>$uid,':contentType'=>$rd['contentType'],':due_ti'=>$ti+$config['orderPayti'],':notes'=>$rd['notes'],':status'=>'outstanding',':recurring'=>$rd['recurring'],':ti'=>$ti));
    $iid=$db->lastInsertId();
    if($rd['qid']!=''){
        $rd['qid']='Q'.date("ymd",$ti).sprintf("%06d",$iid+1,6);
        $qid_ti=$ti+$config['orderPayti'];
    }else$qid_ti=0;
    if($rd['iid']!=''){
        $rd['iid']='I'.date("ymd",$ti).sprintf("%06d",$iid+1,6);
        $iid_ti=$ti+$config['orderPayti'];
    }else$iid_ti=0;
    $s=$db->prepare("UPDATE orders SET qid=:qid,qid_ti=:qid_ti,iid=:iid,iid_ti=:iid_ti WHERE id=:id");
    $s->execute(array(':qid'=>$rd['qid'],':qid_ti'=>$qid_ti,':iid'=>$rd['iid'],':iid_ti'=>$iid_ti,':id'=>$iid));
    $s=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid");
    $s->execute(array(':oid'=>$id));
    while($r=$s->fetch(PDO::FETCH_ASSOC)){
        $so=$db->prepare("INSERT INTO orderitems (oid,iid,title,quantity,cost,status,ti) VALUES (:oid,:iid,:title,:quantity,:cost,:status,:ti)");
        $so->execute(array(':oid'=>$iid,':iid'=>$r['iid'],':title'=>$r['title'],':quantity'=>$r['quantity'],':cost'=>$r['cost'],':status'=>$r['status'],':ti'=>$ti));
    }
    $aid='A'.date("ymd",$ti).sprintf("%06d",$id,6);
    $s=$db->prepare("UPDATE orders SET aid=:aid,aid_ti=:aid_ti WHERE id=:id");
    $s->execute(array(':aid'=>$aid,':aid_ti'=>$ti,':id'=>$id));
    $args[0]='all';
}
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
    $args[0]='edit';
}
if($args[0]=='to_invoice'){
    $q=$db->prepare("SELECT qid FROM orders WHERE id=:id");
    $q->execute(array(':id'=>$id));
    $r=$q->fetch(PDO::FETCH_ASSOC);
    $q=$db->prepare("UPDATE orders SET iid=:iid,iid_ti=:iid_ti,qid='',qid_ti='0' WHERE id=:id");
    $q->execute(array(':iid'=>'I'.date("ymd",$ti).sprintf("%06d",$id,6),':iid_ti'=>$ti,':id'=>$id));
    if(file_exists('../media/orders/'.$r['qid'].'.pdf'))unlink('../media/orders/'.$r['qid'].'.pdf');
    $args[0]='invoices';
}
if($args[0]=='settings'){
    include'core'.DS.'layout'.DS.'set_orders.php';
}elseif($args[0]=='edit'){
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
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-8">Order #<?php echo$r['qid'].$r['iid'];?></h4>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'].'/orders';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
            </div>
            <div class="btn-group">
                <button class="btn btn-default btn-xs" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Print Order"';?>><?php svg('print');?></button>
            </div>
            <div class="btn-group">
                <button class="btn btn-default btn-xs" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Email Order"';?>><?php svg('email-send');?></button>
            </div>
            <div class="btn-group">
                <a target="_blank" class="btn btn-default info btn-xs" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#orders-edit"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="invoice">
            <div class="row header">
                <div class="col-xs-12 col-xs-4 border-right hidden-xs">
                    <h2>From</h2>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?php echo$config['business'];?>" readonly>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">ABN</label>
                        <div class="input-group col-xs-9">
                            <input type="text" class="form-control" value="<?php echo$config['abn'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Address</label>
                        <div class="input-group col-xs-9">
                            <input type="text" class="form-control" value="<?php echo$config['address'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label label-xs col-xs-3">Suburb</label>
                        <div class="input-group col-xs-9">
                            <input type="text" class="form-control" value="<?php echo$config['suburb'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">City</label>
                        <div class="input-group col-xs-9">
                            <input type="text" class="form-control" value="<?php echo$config['city'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">State</label>
                        <div class="input-group col-xs-9">
                            <input type="text" class="form-control" value="<?php echo$config['state'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Postcode</label>
                        <div class="input-group col-xs-9">
                            <input type="text" class="form-control" value="<?php if($config['postcode']!=0){echo$config['postcode'];}?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Email</label>
                        <div class="input-group col-xs-9">
                            <input type="text" class="form-control" value="<?php echo$config['email'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Phone</label>
                        <div class="input-group col-xs-9">
                            <input type="text" class="form-control" value="<?php echo$config['phone'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Mobile</label>
                        <div class="input-group col-xs-9">
                            <input type="text" class="form-control" value="<?php echo$config['mobile'];?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 border-right">
                    <h2>To</h2>
                    <div class="form-group">
                        <input type="text" id="client_business" class="form-control" value="<?php echo$client['username'];if($client['name']!=''){echo' ['.$client['name'].']';}if($client['business']!=''){echo' -> '.$client['business'];}?>" placeholder="Username, Business or Name..." readonly>
                    </div>
                    <div class="form-group form-group-xs">
                        <label for="address" class="control-label col-xs-3">Address</label>
                        <div class="input-group col-xs-9">
                            <input type="text" id="address" class="form-control input-xs textinput" value="<?php echo$client['address'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="address" data-bs="btn-danger" placeholder="Enter an Address..."<?php if($r['status']=='archived')echo' readonly';?>>
                        </div>
                    </div>
                    <div class="form-group form-group-xs">
                        <label for="suburb" class="control-label col-xs-3">Suburb</label>
                        <div class="input-group col-xs-9">
                            <input type="text" id="suburb" class="form-control textinput" value="<?php echo$client['suburb'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="suburb" data-bs="btn-danger" placeholder="Enter a Suburb..."<?php if($r['status']=='archived')echo' readonly';?>>
                        </div>
                    </div>
                    <div class="form-group form-group-xs">
                        <label for="city" class="control-label col-xs-3">City</label>
                        <div class="input-group col-xs-9">
                            <input type="text" id="city" class="form-control textinput" value="<?php echo$client['city'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="city" data-bs="btn-danger" placeholder="Enter a City..."<?php if($r['status']=='archived')echo' readonly';?>>
                        </div>
                    </div>
                    <div class="form-group form-group-xs">
                        <label for="state" class="control-label col-xs-3">State</label>
                        <div class="input-group col-xs-9">
                            <input type="text" id="state" class="form-control textinput" value="<?php echo$client['state'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="state" data-bs="btn-danger" placeholder="Enter a State..."<?php if($r['status']=='archived')echo' readonly';?>>
                        </div>
                    </div>
                    <div class="form-group form-group-xs">
                        <label for="postcode" class="control-label col-xs-3">Postcode</label>
                        <div class="input-group col-xs-9">
                            <input type="text" id="postcode" class="form-control textinput" value="<?php if($client['postcode']!=0)echo$client['postcode'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="postcode" data-bs="btn-danger" placeholder="Enter a Postcode..."<?php if($r['status']=='archived')echo' readonly';?>>
                        </div>
                    </div>
                    <div class="form-group form-group-xs">
                        <label for="email" class="control-label col-xs-3">Email</label>
                        <div class="input-group col-xs-9">
                            <input type="text" id="email" class="form-control textinput" value="<?php echo$client['email'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="email" data-bs="btn-danger" placeholder="Enter an Email..."<?php if($r['status']=='archived')echo' readonly';?>>
                            <div class="input-group-btn">
                                <a class="btn btn-default" href="mailto:<?php echo$client['email'];?>"><?php svg('email-send');?></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-xs">
                        <label for="phone" class="control-label col-xs-3">Phone</label>
                        <div class="input-group col-xs-9">
                            <input type="text" id="phone" class="form-control textinput" value="<?php echo$client['phone'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="phone" data-bs="btn-danger" placeholder="Enter a Phone Number..."<?php if($r['status']=='archived')echo' readonly';?>>
                        </div>
                    </div>
                    <div class="form-group form-group-xs">
                        <label for="mobile" class="control-label col-xs-3">Mobile</label>
                        <div class="input-group col-xs-9">
                            <input type="text" id="mobile" class="form-control textinput" value="<?php echo$client['mobile'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="mobile" data-bs="btn-danger" placeholder="Enter a Mobile Number..."<?php if($r['status']=='archived')echo' readonly';?>>
                        </div>
                    </div>
<?php if($r['status']!='archived'){?>
                    <div class="form-group form-group-xs">
                        <label for="changeClient" class="control-label col-xs-3">Client</label>
                        <div class="input-group col-xs-9">
                            <select id="changeClient" class="form-control input-xs" onchange="changeClient($(this).val(),'<?php echo$r['id'];?>');">
                                <option value="0"<?php if($r['cid']=='0')echo' selected';?>>None</option>
<?php $q=$db->query("SELECT id,business,username,name FROM login WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
    while($rs=$q->fetch(PDO::FETCH_ASSOC)){
        echo'<option value="'.$rs['id'].'"';if($r['cid']==$rs['id'])echo' selected';echo'>'.$rs['username'];if($rs['name']!='')echo' ['.$rs['name'].']';if($rs['business']!='')echo' -> '.$rs['business'].'</option>';
    }?>
                            </select>
                            <div class="help-block"><small><small>Note: Changing values above will update the User's Account details.</small></small></div>
                        </div>
                    </div>
<?php }?>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <h2>Details</h2>
                    <div class="form-group form-group-xs">
                        <label class="control-label col-xs-4">Order #</label>
                        <div class="input-group col-xs-8">
                            <input type="text" class="form-control" value="<?php echo$r['qid'].$r['iid'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group form-group-xs">
                        <label class="control-label col-xs-4">Order Date</label>
                        <div class="input-group col-xs-8">
                            <input type="text" class="form-control" value="<?php echo date($config['dateFormat'],$r['qid_ti'].$r['iid_ti']);?>" readonly>
                        </div>
                    </div>
                    <div class="form-group form-group-xs">
                        <label class="control-label col-xs-4">Due Date</label>
                        <div class="input-group col-xs-8">
                            <input type="text" id="due_ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['due_ti']);?>">
<?php if($r['status']!='archived'){?>
                            <div class="input-group-btn">
                                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php svg('add');?></button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+604800;?>');return false;">7 Days</a></li>
                                    <li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+1209600;?>');return false;">14 Days</a></li>
                                    <li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+1814400;?>');return false;">21 Days</a></li>
                                    <li><a href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+2592000;?>');return false;">30 Days</a></li>
                                </ul>
                            </div>
<?php }?>
                        </div>
                    </div>
                    <div class="form-group form-group-xs">
                        <label class="control-label col-xs-4">Status</label>
                        <div class="input-group col-xs-8">
<?php if($r['status']=='archived'){?>
                            <input type="text" class="form-control" value="Archived" readonly>
<?php }else{?>
                            <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','orders','status',$(this).val());">
                                <option value="pending"<?php if($r['status']=='pending')echo' selected';?>>Pending</option>
                                <option value="overdue"<?php if($r['status']=='overdue')echo' selected';?>>Overdue</option>
                                <option value="cancelled"<?php if($r['status']=='cancelled')echo' selected';?>>Cancelled</option>
                                <option value="paid"<?php if($r['status']=='paid')echo' selected';?>>Paid</option>
                            </select>
<?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-responsive">
                    <thead>
<?php if($r['status']!='archived'){?>
                        <tr>
                            <th colspan="6">
                                <div class="form-group">
                                    <div class="input-group col-xs-12">
                                        <select id="addItem" class="form-control">
                                            <option value="0">Add Empty Entry...</option>
<?php $s=$db->query("SELECT id,contentType,code,cost,title FROM content WHERE contentType='inventory' OR contentType='service' OR contentType='events' ORDER BY code ASC");
while($i=$s->fetch(PDO::FETCH_ASSOC))
echo'<option value="'.$i['id'].'">'.ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'].'</option>';?>
                                        </select>
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" onclick="addOrderItem('<?php echo$r['id'];?>',$('#addItem').val());"><?php svg('plus');?></button>
                                        </div>
                                    </div>
                                </div>
                            </th>
                        </tr>
<?php }?>
                        <tr>
                            <th>Code<span class="visible-xs">/Title</span></th>
                            <th class="hidden-xs">Title</th>
                            <th class="col-sm-1 text-center">Quantity</th>
                            <th class="col-sm-1 text-center">Cost</th>
                            <th class="col-sm-1 text-right">Total</th>
                            <th class="col-sm-1"></th>
                        </tr>
                    </thead>
                    <tbody id="updateorder">
<?php $s=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid ORDER BY ti ASC,title ASC");
$s->execute(array(':oid'=>$r['id']));
$total=0;
while($oi=$s->fetch(PDO::FETCH_ASSOC)){
    $is=$db->prepare("SELECT id,code,title FROM content WHERE id=:id");
    $is->execute(array(':id'=>$oi['iid']));
    $i=$is->fetch(PDO::FETCH_ASSOC);?>
                        <tr>
                            <td class="text-left">
                                <?php echo$i['code'];?>
                                <div class="visible-xs"><?php echo$i['title'];?></div>
                            </td>
                            <td class="text-left hidden-xs">
                                <?php echo$i['title'];?>
                            </td>
                            <td class="col-md-1 text-center">
<?php if($oi['iid']!=0){?>
                                <form target="sp" action="core/update.php">
                                    <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                                    <input type="hidden" name="t" value="orderitems">
                                    <input type="hidden" name="c" value="quantity">
                                    <input class="form-control text-center" name="da" value="<?php echo$oi['quantity'];?>"<?php if($r['status']=='archived')echo' readonly';?>>
                                </form>
<?php }else{
    if($oi['iid']!=0)echo$oi['quantity'];
}?>
                            </td>
                            <td class="col-md-1 text-right">
<?php if($oi['iid']!=0){?>
                                <form target="sp" action="core/update.php">
                                    <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                                    <input type="hidden" name="t" value="orderitems">
                                    <input type="hidden" name="c" value="cost">
                                    <div class="input-group">
                                        <input class="form-control text-center" name="da" value="<?php echo$oi['cost'];?>"<?php if($r['status']=='archived')echo' readonly';?>>
                                    </div>
                                </form>
<?php }elseif($oi['iid']!=0)echo$oi['cost'];?>
                            </td>
                            <td class="text-right">
<?php if($oi['iid']!=0)echo$oi['cost']*$oi['quantity'];?>
                            </td>
                            <td class="text-right">
                                <form target="sp" action="core/update.php">
                                    <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                                    <input type="hidden" name="t" value="orderitems">
                                    <input type="hidden" name="c" value="quantity">
                                    <input type="hidden" name="da" value="0">
                                    <button class="btn btn-default trash"><?php svg('trash');?></button>
                                </form>
                            </td>
                        </tr>
<?php if($oi['iid']!=0)$total=$total+($oi['cost']*$oi['quantity']);
}?>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong><?php echo$total;?></strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-6">
<?php if($r['status']!='archived'&&$user['rank']>699){?>
                <form target="sp" action="core/update.php">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="t" value="orders">
                    <input type="hidden" name="c" value="notes">
                    <textarea class="summernote" name="da"><?php echo$r['notes'];?></textarea>
                </form>
<?php }else{?>
                <div class="well"><?php echo$r['notes'];?></div>
<?php }?>
            </div>
        </div>
    </div>
</div>
<?php }
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
    }
    if($args[0]=='recurring'){
        $s=$db->prepare("SELECT * FROM orders WHERE recurring='1' ORDER BY ti DESC");
        $s->execute();
    }?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-8">
            <ol class="breadcrumb">
                <li><a href="<?php echo URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
                <li class="relative">
                    <a class="dropdown-toggle" data-toggle="dropdown"><?php if(isset($args[0]))echo ucfirst($args[0]);else echo'All';?> <i class="caret"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo URL.$settings['system']['admin'].'/orders';?>">All</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'].'/orders/quotes';?>">Quotes</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'].'/orders/invoices';?>">Invoices</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'].'/orders/archived';?>">Archived</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'].'/orders/pending';?>">Pending</a></li>
                        <li><a href="<?php echo URL.$settings['system']['admin'].'/orders/recurring';?>">Recurring</a></li>
                    </ul>
                </li>
            </ol>
        </h4>
        <div class="pull-right">
            <div class="btn-group"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Add"';?>>
                <button class="btn btn-default add btn-xs dropdown-toggle" data-toggle="dropdown" data-placement="right"><?php svg('plus');?></button>
                <ul class="dropdown-menu multi-level pull-right">
                    <li><a href="<?php echo URL.$settings['system']['admin'].'/orders/addquote';?>">Quote</a></li>
                    <li><a href="<?php echo URL.$settings['system']['admin'].'/orders/addinvoice';?>">Invoice</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'].'/orders/settings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Settings"';?>><?php svg('cogs');?></a>
            </div>
            <div class="btn-group">
                <a target="_blank" class="btn btn-default info btn-xs" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#orders"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table id="stupidtable" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="col-xs-1">Order #</th>
                        <th class="col-xs-1 hidden-xs">Client</th>
                        <th class="col-xs-2 hidden-xs">Date</th>
                        <th class="col-xs-1 hidden-xs">Status</th>
                        <th class="col-xs-3"></th>
                    </tr>
                </thead>
                <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
    if($r['due_ti']<$ti){
        $us=$db->prepare("UPDATE orders SET status='overdue' WHERE id=:id");
        $us->execute(array(':id'=>$r['id']));
        $r['status']='overdue';
    }
    $cs=$db->prepare("SELECT username,name,email,business FROM login WHERE id=:id");
    $cs->execute(array(':id'=>$r['cid']));
    $c=$cs->fetch(PDO::FETCH_ASSOC);?>
                    <tr id="l_<?php echo$r['id'];?>"<?php if(($ti>$r['due_ti'])||($r['status']=='overdue'))echo' class="danger text-danger"';?>>
                        <td>
                            <small><?php if($r['aid']!='')echo$r['aid'].'<br>';echo$r['qid'].$r['iid'];?></small>
                            <small class="visible-xs hidden-sm hidden-md hidden-lg"><?php echo$c['username'];if($c['name']!='')echo' ['.$c['name'].']';if($c['business']!='')echo' -> '.$c['business'];?></small>
                        </td>
                        <td class="hidden-xs">
                            <small><?php echo$c['username'];if($c['name']!='')echo' ['.$c['name'].']';if($c['name']!=''&&$c['business']!='')echo'<br>';if($c['business']!='')echo$c['business'];?></small>
                        </td>
                        <td class="hidden-xs">
                            <small><?php echo' '.date($config['dateFormat'],$r['qid_ti'].$r['iid_ti']);?></small><br>
                            <small>Due: <?php echo date($config['dateFormat'],$r['due_ti']);?></small>
                        </td>
                        <td class="hidden-xs">
                            <small><?php echo $r['status'];?></small>
                        </td>
                        <td id="controls_<?php echo$r['id'];?>" class="text-right">
<?php if($r['qid']!=''&&$r['aid']==''){?>
                            <a class="btn btn-default btn-xs<?php if($r['status']=='delete')echo' hidden';?>" href="<?php echo URL.$settings['system']['admin'].'/orders/to_invoice/'.$r['id'].'"';if($config['options']{4}==1)echo' data-toggle="tooltip" title="Convert to Invoice..."';?>><?php svg('order-quotetoinvoice');?></a>
<?php }
if($r['aid']==''){?>
                            <button class="btn btn-default btn-xs<?php if($r['status']=='delete')echo' hidden';?>" onclick="update('<?php echo$r['id'];?>','orders','status','archived')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Archive"';?>><?php svg('archive');?></button>
<?php }?>
                            <button class="btn btn-default btn-xs" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Print Order"';?>><?php svg('print');?></button>
<?php if($c['email']!=''){?>
                            <button class="btn btn-default btn-xs" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Email Order"';?>><?php svg('email-send');?></button>
<?php }?>
                            <a class="btn btn-default btn-xs<?php if($r['status']=='delete')echo' hidden';?>" href="<?php echo URL.$settings['system']['admin'].'/orders/duplicate/'.$r['id'].'"';if($config['options']{4}==1)echo' data-toggle="tooltip" title="Duplicate"';?>><?php svg('copy');?></a>
                            <a class="btn btn-default btn-xs<?php if($r['status']=='delete')echo' hidden';?>" href="<?php echo URL.$settings['system']['admin'].'/orders/edit/'.$r['id'].'"';if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><?php svg('edit');?></a>
<?php if($user['rank']>399){?>
                            <button class="btn btn-default btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','orders','status','')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><?php svg('email-reply');?></button>
                            <button class="btn btn-default btn-xs trash<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','orders','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><?php svg('trash');?></button>
                            <button class="btn btn-default btn-xs trash<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','orders')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><?php svg('purge');?></button>
<?php }?>
                        </td>
                    </tr>
<?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php }
