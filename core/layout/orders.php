<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$uid=(isset($_SESSION['uid'])?$_SESSION['uid']:$uid=0);
$error=0;
$ti=time();
$oid='';
if(isset($args[1]))$id=$args[1];
if($args[0]=='duplicate'){
  $sd=$db->prepare("SELECT * FROM orders WHERE id=:id");
  $sd->execute(array(':id'=>$id));
  $rd=$sd->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("INSERT INTO orders (cid,uid,contentType,due_ti,notes,status,recurring,ti) VALUES (:cid,:uid,:contentType,:due_ti,:notes,:status,:recurring,:ti)");
  $s->execute(
    array(
      ':cid'         => $rd['cid'],
      ':uid'         => $uid,
      ':contentType' => $rd['contentType'],
      ':due_ti'      => $ti + $config['orderPayti'],
      ':notes'       => $rd['notes'],
      ':status'      => 'outstanding',
      ':recurring'   => $rd['recurring'],
      ':ti'          => $ti
    )
  );
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
  $s->execute(
    array(
      ':qid'    => $rd['qid'],
      ':qid_ti' => $qid_ti,
      ':iid'    => $rd['iid'],
      ':iid_ti' => $iid_ti,
      ':id'     => $iid
    )
  );
  $s=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid");
  $s->execute(array(':oid'=>$id));
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $so=$db->prepare("INSERT INTO orderitems (oid,iid,title,quantity,cost,status,ti) VALUES (:oid,:iid,:title,:quantity,:cost,:status,:ti)");
    $so->execute(
      array(
        ':oid'      => $iid,
        ':iid'      => $r['iid'],
        ':title'    => $r['title'],
        ':quantity' => $r['quantity'],
        ':cost'     => $r['cost'],
        ':status'   => $r['status'],
        ':ti'       => $ti
      )
    );
  }
  $aid='A'.date("ymd",$ti).sprintf("%06d",$id,6);
  $s=$db->prepare("UPDATE orders SET aid=:aid,aid_ti=:aid_ti WHERE id=:id");
  $s->execute(
    array(
      ':aid'    => $aid,
      ':aid_ti' => $ti,
      ':id'     => $id
    )
  );
  $args[0]='all';
}
if($args[0]=='addquote'||$args[0]=='addinvoice'){
  $r=$db->query("SELECT MAX(id) as id FROM orders")->fetch(PDO::FETCH_ASSOC);
  $dti=$ti+$config['orderPayti'];
  if($args[0]=='addquote'){
    $oid='Q'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
    $q=$db->prepare("INSERT INTO orders (uid,qid,qid_ti,due_ti,status) VALUES (:uid,:qid,:qid_ti,:due_ti,'pending')");
    $q->execute(
      array(
        ':uid'    => $uid,
        ':qid'    => $oid,
        ':qid_ti' => $ti,
        ':due_ti' => $dti
      )
    );
  }
  if($args[0]=='addinvoice'){
    $oid='I'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
    $s=$db->prepare("INSERT INTO orders (uid,iid,iid_ti,due_ti,status) VALUES (:uid,:iid,:iid_ti,:due_ti,'pending')");
    $s->execute(
      array(
        ':uid'    => $uid,
        ':iid'    => $oid,
        ':iid_ti' => $ti,
        ':due_ti' => $dti
      )
    );
  }
  $id=$db->lastInsertId();
  $e=$db->errorInfo();
  $args[0]='edit';?>
<script>/*<![CDATA[*/
  history.replaceState('','','<?php echo URL.$settings['system']['admin'].'/orders/edit/'.$id;?>');
/*]]>*/</script>
<?php }
if($args[0]=='to_invoice'){
  $q=$db->prepare("SELECT qid FROM orders WHERE id=:id");
  $q->execute(array(':id'=>$id));
  $r=$q->fetch(PDO::FETCH_ASSOC);
  $q=$db->prepare("UPDATE orders SET iid=:iid,iid_ti=:iid_ti,qid='',qid_ti='0' WHERE id=:id");
  $q->execute(
    array(
      ':iid'    => 'I'.date("ymd",$ti).sprintf("%06d",$id,6),
      ':iid_ti' => $ti,
      ':id'     => $id
    )
  );
  if(file_exists('..'.DS.'media'.DS.'order'.DS.$r['qid'].'.pdf'))
    unlink('..'.DS.'media'.DS.'orders'.DS.$r['qid'].'.pdf');
  $args[0]='invoices';
}
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_orders.php';
elseif($args[0]=='edit'){
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
      $q->execute(
        array(
          ':notes' => $config['orderEmailNotes'],
          ':id'    => $r['id']
        )
      );
    }
    if($error==1)
      echo'<div class="alert alert-danger">'.$e[0].'</div>';
    else{?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Order #<?php echo$r['qid'].$r['iid'];?></h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/orders';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <button class="btn btn-default" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');" data-toggle="tooltip" data-placement="left" title="Print Order"><?php svg('libre-gui-print',($config['iconsColor']==1?true:null));?></button>
      </div>
      <div class="btn-group">
        <button class="btn btn-default" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=');" data-toggle="tooltip" data-placement="left" title="Email Order"><?php svg('libre-gui-email-send',($config['iconsColor']==1?true:null));?></button>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#orders-edit" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div id="notifications"></div>
    <div class="invoice">
      <div class="row header">
        <div class="col-sm-4 border-right hidden-xs">
          <h2>From</h2>
          <div class="form-group">
            <input type="text" class="form-control" value="<?php echo$config['business'];?>" readonly>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">ABN</label>
            <div class="input-group col-sm-9">
              <input type="text" class="form-control" value="<?php echo$config['abn'];?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Address</label>
            <div class="input-group col-sm-9">
              <input type="text" class="form-control" value="<?php echo$config['address'];?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Suburb</label>
            <div class="input-group col-sm-9">
              <input type="text" class="form-control" value="<?php echo$config['suburb'];?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">City</label>
            <div class="input-group col-sm-9">
              <input type="text" class="form-control" value="<?php echo$config['city'];?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">State</label>
            <div class="input-group col-sm-9">
              <input type="text" class="form-control" value="<?php echo$config['state'];?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Postcode</label>
            <div class="input-group col-sm-9">
              <input type="text" class="form-control" value="<?php echo($config['postcode']!=0?$config['postcode']:'');?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Email</label>
            <div class="input-group col-sm-9">
              <input type="text" class="form-control" value="<?php echo$config['email'];?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Phone</label>
            <div class="input-group col-sm-9">
              <input type="text" class="form-control" value="<?php echo$config['phone'];?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Mobile</label>
            <div class="input-group col-sm-9">
              <input type="text" class="form-control" value="<?php echo$config['mobile'];?>" readonly>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 border-right">
          <h2>To</h2>
          <div class="form-group">
            <input type="text" id="client_business" class="form-control" value="<?php echo$client['username'];echo($client['name']!=''?' ['.$client['name'].']':'');echo($client['business']!=''?' -> '.$client['business']:'');?>" placeholder="Username, Business or Name..." readonly>
          </div>
          <div class="form-group form-group-xs">
            <label for="address" class="control-label col-xs-3">Address</label>
            <div class="input-group col-xs-9">
              <input type="text" id="address" class="form-control input-xs textinput" value="<?php echo$client['address'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="address" data-bs="btn-danger" placeholder="Enter an Address..."<?php echo($r['status']=='archived'?' readonly':'');?>>
            </div>
          </div>
          <div class="form-group form-group-xs">
            <label for="suburb" class="control-label col-xs-3">Suburb</label>
            <div class="input-group col-xs-9">
              <input type="text" id="suburb" class="form-control textinput" value="<?php echo$client['suburb'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="suburb" data-bs="btn-danger" placeholder="Enter a Suburb..."<?php echo($r['status']=='archived'?' readonly':'');?>>
            </div>
          </div>
          <div class="form-group form-group-xs">
            <label for="city" class="control-label col-xs-3">City</label>
            <div class="input-group col-xs-9">
              <input type="text" id="city" class="form-control textinput" value="<?php echo$client['city'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="city" data-bs="btn-danger" placeholder="Enter a City..."<?php echo($r['status']=='archived'?' readonly':'');?>>
            </div>
          </div>
          <div class="form-group form-group-xs">
            <label for="state" class="control-label col-xs-3">State</label>
            <div class="input-group col-xs-9">
              <input type="text" id="state" class="form-control textinput" value="<?php echo$client['state'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="state" data-bs="btn-danger" placeholder="Enter a State..."<?php echo($r['status']=='archived'?' readonly':'');?>>
            </div>
          </div>
          <div class="form-group form-group-xs">
            <label for="postcode" class="control-label col-xs-3">Postcode</label>
            <div class="input-group col-xs-9">
              <input type="text" id="postcode" class="form-control textinput" value="<?php echo($client['postcode']!=0?$client['postcode']:'');?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="postcode" data-bs="btn-danger" placeholder="Enter a Postcode..."<?php echo($r['status']=='archived'?' readonly':'');?>>
            </div>
          </div>
          <div class="form-group form-group-xs">
            <label for="email" class="control-label col-xs-3">Email</label>
            <div class="input-group col-xs-9">
              <input type="text" id="email" class="form-control textinput" value="<?php echo$client['email'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="email" data-bs="btn-danger" placeholder="Enter an Email..."<?php echo($r['status']=='archived'?' readonly':'');?>>
              <div class="input-group-btn">
                <a class="btn btn-default" href="mailto:<?php echo$client['email'];?>"><?php svg('libre-gui-email-send',($config['iconsColor']==1?true:null));?></a>
              </div>
            </div>
          </div>
          <div class="form-group form-group-xs">
            <label for="phone" class="control-label col-xs-3">Phone</label>
            <div class="input-group col-xs-9">
              <input type="text" id="phone" class="form-control textinput" value="<?php echo$client['phone'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="phone" data-bs="btn-danger" placeholder="Enter a Phone Number..."<?php echo($r['status']=='archived'?' readonly':'');?>>
            </div>
          </div>
          <div class="form-group form-group-xs">
            <label for="mobile" class="control-label col-xs-3">Mobile</label>
            <div class="input-group col-xs-9">
              <input type="text" id="mobile" class="form-control textinput" value="<?php echo$client['mobile'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="mobile" data-bs="btn-danger" placeholder="Enter a Mobile Number..."<?php echo($r['status']=='archived'?' readonly':'');?>>
            </div>
          </div>
<?php if($r['status']!='archived'){?>
          <div class="form-group form-group-xs">
            <label for="changeClient" class="control-label col-xs-3">Client</label>
            <div class="input-group col-xs-9">
              <select id="changeClient" class="form-control input-xs" onchange="changeClient($(this).val(),'<?php echo$r['id'];?>');">
                <option value="0"<?php echo($r['cid']=='0'?' selected':'');?>>None</option>
<?php $q=$db->query("SELECT id,business,username,name FROM login WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
while($rs=$q->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['id'].'"'.($r['cid']==$rs['id']?' selected':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business'].'</option>':'');?>
              </select>
              <small class="help-block"><small>Note: Changing values above will update the Users Account details.</small></small>
            </div>
          </div>
<?php }?>
        </div>
        <div class="col-xs-12 col-sm-4">
          <h2>Details</h2>
          <div class="form-group">
            <label class="control-label col-xs-4">Order #</label>
            <div class="input-group col-xs-8">
              <input type="text" class="form-control" value="<?php echo($r['iid']==''?$r['qid']:$r['iid']);?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-xs-4">Order Date</label>
            <div class="input-group col-xs-8">
              <input type="text" class="form-control" value="<?php echo($r['iid_ti']!=0?date($config['dateFormat'],$r['iid_ti']):date($config['dateFormat'],$r['qid_ti']));?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-xs-4">Due Date</label>
            <div class="input-group col-xs-8">
              <input type="text" id="due_ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['due_ti']);?>">
<?php if($r['status']!='archived'){?>
              <div class="input-group-btn">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php svg('libre-gui-add',($config['iconsColor']==1?true:null));?></button>
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
          <div class="form-group">
            <label class="control-label col-xs-4">Status</label>
            <div class="input-group col-xs-8">
<?php if($r['status']=='archived')
  echo'<input type="text" class="form-control" value="Archived" readonly>';
else{?>
              <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','orders','status',$(this).val());">
                <option value="pending"<?php echo($r['status']=='pending'?' selected':'');?>>Pending</option>
                <option value="overdue"<?php echo($r['status']=='overdue'?' selected':'');?>>Overdue</option>
                <option value="cancelled"<?php echo($r['status']=='cancelled'?' selected':'');?>>Cancelled</option>
                <option value="paid"<?php echo($r['status']=='paid'?' selected':'');?>>Paid</option>
              </select>
<?php }?>
            </div>
          </div>
        </div>
      </div>
<?php if($r['status']!='archived'){?>
      <form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();">
        <input type="hidden" name="act" value="additem">
        <input type="hidden" name="id" value="<?php echo$r['id'];?>">
        <input type="hidden" name="t" value="orderitems">
        <input type="hidden" name="c" value="">
        <div class="form-group">
          <div class="input-group col-xs-12">
            <select class="form-control" name="da">
              <option value="0">Add Empty Entry...</option>
<?php $s=$db->query("SELECT id,contentType,code,cost,title FROM content WHERE contentType='inventory' OR contentType='service' OR contentType='events' ORDER BY code ASC");
while($i=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$i['id'].'">'.ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'].'</option>';?>
            </select>
            <div class="input-group-btn">
              <button class="btn btn-default add"><?php svg('libre-gui-plus',($config['iconsColor']==1?true:null));?></button>
            </div>
          </div>
        </div>
      </form>
<?php }?>
      <div class="table-responsive">
        <table class="table table-striped table-responsive">
          <thead>
            <tr>
              <th>Code<span class="visible-xs">/Title</span></th>
              <th class="hidden-xs">Title</th>
              <th class="hidden-xs">Option</th>
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
  $i=$is->fetch(PDO::FETCH_ASSOC);
  $sc=$db->prepare("SELECT * FROM choices WHERE id=:id");
  $sc->execute(array(':id'=>$oi['cid']));
  $c=$sc->fetch(PDO::FETCH_ASSOC);?>
            <tr>
              <td class="text-left"><?php echo$i['code'];?></td>
              <td class="text-left">
<?php if($oi['iid']!=0)
    echo$i['title'];
  else{?>
                <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                  <input type="hidden" name="act" value="title">
                  <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                  <input type="hidden" name="t" value="orderitems">
                  <input type="hidden" name="c" value="title">
                  <input type="text" class="form-control" name="da" value="<?php echo$oi['title'];?>">
                </form>
<?php }?>
              </td>
              <td class="text-left"><?php echo$c['title'];?></td>
              <td class="col-sm-1 text-center">
<?php if($oi['iid']!=0){?>
                <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                  <input type="hidden" name="act" value="quantity">
                  <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                  <input type="hidden" name="t" value="orderitems">
                  <input type="hidden" name="c" value="quantity">
                  <input type="text" class="form-control text-center" name="da" value="<?php echo$oi['quantity'];?>"<?php echo($r['status']=='archived'?' readonly':'');?>>
                </form>
<?php }else{
  if($oi['iid']!=0)echo$oi['quantity'];
}?>
              </td>
              <td class="col-sm-1 text-right">
<?php if($oi['iid']!=0){?>
                <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                  <input type="hidden" name="act" value="cost">
                  <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                  <input type="hidden" name="t" value="orderitems">
                  <input type="hidden" name="c" value="cost">
                  <input class="form-control text-center" name="da" value="<?php echo$oi['cost'];?>"<?php echo($r['status']=='archived'?' readonly':'');?>>
                </form>
<?php }elseif($oi['iid']!=0)echo$oi['cost'];?>
              </td>
              <td class="col-sm-1 text-right"><?php echo($oi['iid']!=0?$oi['cost']*$oi['quantity']:'');?></td>
              <td class="text-right">
                <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                  <input type="hidden" name="act" value="trash">
                  <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                  <input type="hidden" name="t" value="orderitems">
                  <input type="hidden" name="c" value="quantity">
                  <input type="hidden" name="da" value="0">
                  <button class="btn btn-default trash"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
                </form>
              </td>
            </tr>
<?php if($oi['iid']!=0)$total=$total+($oi['cost']*$oi['quantity']);
}
$sr=$db->prepare("SELECT * FROM rewards WHERE id=:rid");
$sr->execute(array(':rid'=>$r['rid']));
$reward=$sr->fetch(PDO::FETCH_ASSOC);?>
            <tr>
              <td colspan="3" class="text-right"><strong>Rewards Code</strong></td>
              <td class="text-center">
                <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                  <input type="hidden" name="act" value="reward">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="t" value="orders">
                  <input type="hidden" name="c" value="rid">
                  <input type="text" class="form-control" name="da" value="<?php echo($sr->rowCount()==1?$reward['code']:'');?>">
                </form>
              </td>
              <td class="text-center">
<?php if($sr->rowCount()==1){
  if($reward['method']==1){
    echo'$';
    $total=$total-$reward['value'];
  }
  echo$reward['value'];
  if($reward['method']==0){
    echo'%';
    $total=($total*((100-$reward['value'])/100));
  }
  echo' Off';
}?>
              </td>
              <td class="text-right"><strong><?php echo$total;?></strong></td>
              <td></td>
            </tr>
            <tr>
              <td colspan="5" class="text-right"><strong>Postage</strong></td>
              <td class="postage">
                <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                  <input type="hidden" name="act" value="postage">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="t" value="orders">
                  <input type="hidden" name="c" value="postage">
                  <input type="text" class="form-control text-right" name="da" value="<?php echo$r['postage'];$total=$total+$r['postage'];?>">
                </form>
              </td>
              <td></td>
            </tr>
            <tr>
              <td colspan="5" class="text-right"><strong>Total</strong></td>
              <td class="total text-right"><strong><?php echo$total;?></strong></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-xs-12 col-sm-6">
<?php if($r['status']!='archived'&&$user['rank']>699){?>
        <form target="sp" method="POST" action="core/update.php">
          <input type="hidden" name="id" value="<?php echo$r['id'];?>">
          <input type="hidden" name="t" value="orders">
          <input type="hidden" name="c" value="notes">
          <textarea class="summernote" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
        </form>
<?php }else
        echo'<div class="well">'.$r['notes'].'</div>';?>
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
          <a class="dropdown-toggle" data-toggle="dropdown"><?php echo(isset($args[0])?ucfirst($args[0]):'All');?> <i class="caret"></i></a>
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
      <div class="btn-group" data-toggle="tooltip" data-placement="left" title="Add">
        <button class="btn btn-default add dropdown-toggle" data-toggle="dropdown" data-placement="right"><?php svg('libre-gui-plus',($config['iconsColor']==1?true:null));?></button>
        <ul class="dropdown-menu multi-level pull-right">
          <li><a href="<?php echo URL.$settings['system']['admin'].'/orders/addquote';?>">Quote</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'].'/orders/addinvoice';?>">Invoice</a></li>
        </ul>
      </div>
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/orders/settings';?>" data-toggle="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#orders" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div id="notifications"></div>
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
          <tr id="l_<?php echo$r['id'];?>"<?php echo(($ti>$r['due_ti'])||($r['status']=='overdue')?' class="danger text-danger"':'');?>>
            <td>
              <small>
                <a href="<?php echo URL.$settings['system']['admin'].'/orders/edit/'.$r['id'];?>">
<?php echo($r['aid']!=''?$r['aid'].'<br>':'');
  echo$r['qid'].$r['iid'];?>
                </a>
              </small>
              <small class="visible-xs hidden-sm hidden-md hidden-lg">
<?php echo$c['username'];
  echo($c['name']!=''?' ['.$c['name'].']':'');
  echo($c['business']!=''?' -> '.$c['business']:'');?>
              </small>
            </td>
            <td class="hidden-xs">
              <small><?php echo$c['username'].($c['name']!=''?' ['.$c['name'].']':'').($c['name']!=''&&$c['business']!=''?'<br>':'').($c['business']!=''?$c['business']:'');?></small>
            </td>
            <td class="hidden-xs">
              <small><?php echo' '.date($config['dateFormat'],$r['qid_ti'].$r['iid_ti']);?></small><br>
              <small>Due: <?php echo date($config['dateFormat'],$r['due_ti']);?></small>
            </td>
            <td class="hidden-xs">
              <small><?php echo$r['status'];?></small>
            </td>
            <td id="controls_<?php echo$r['id'];?>" class="text-right">
<?php         echo($r['qid']!=''&&$r['aid']==''?'<a class="btn btn-default'.($r['status']=='delete'?' hidden':'').'" href="'.URL.$settings['system']['admin'].'/orders/to_invoice/'.$r['id'].'" data-toggle="tooltip" title="Convert to Invoice...">'.svg2('libre-gui-order-quotetoinvoice',($config['iconsColor']==1?true:null)).'</a>':'');
              echo($r['aid']==''?'<button class="btn btn-default'.($r['status']=='delete'?' hidden':'').'" onclick="update(\''.$r['id'].'\',\'orders\',\'status\',\'archived\')" data-toggle="tooltip" title="Archive">'.svg2('libre-gui-archive',($config['iconsColor']==1?true:null)).'</button>':'');?>
              <button class="btn btn-default" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');" data-toggle="tooltip" title="Print Order"><?php svg('libre-gui-print',($config['iconsColor']==1?true:null));?></button>
<?php         echo($c['email']!=''?'<button class="btn btn-default" onclick="$(\'#sp\').load(\'core/email_order.php?id='.$r['id'].'&act=\');" data-toggle="tooltip" title="Email Order">'.svg2('libre-gui-email-send',($config['iconsColor']==1?true:null)).'</button>':'');?>
              <a class="btn btn-default<?php echo($r['status']=='delete'?' hidden':'');?>" href="<?php echo URL.$settings['system']['admin'].'/orders/duplicate/'.$r['id'];?>" data-toggle="tooltip" title="Duplicate"'><?php svg('libre-gui-copy',($config['iconsColor']==1?true:null));?></a>
              <a class="btn btn-default<?php echo($r['status']=='delete'?' hidden':'');?>" href="<?php echo URL.$settings['system']['admin'].'/orders/edit/'.$r['id'];?>" data-toggle="tooltip" title="Edit"><?php svg('libre-gui-edit',($config['iconsColor']==1?true:null));?></a>
<?php if($user['rank']>399){?>
              <button class="btn btn-default<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','orders','status','')" data-toggle="tooltip" title="Restore"><?php svg('libre-gui-email-reply',($config['iconsColor']==1?true:null));?></button>
              <button class="btn btn-default trash<?php echo($r['status']=='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','orders','status','delete')" data-toggle="tooltip" title="Delete"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
              <button class="btn btn-default trash<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="purge('<?php echo$r['id'];?>','orders')" data-toggle="tooltip" title="Purge"><?php svg('libre-gui-purge',($config['iconsColor']==1?true:null));?></button>
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
