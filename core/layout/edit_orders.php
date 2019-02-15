<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$q=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE id=:id");
$q->execute(
  array(
    ':id'=>$id
  )
);
$r=$q->fetch(PDO::FETCH_ASSOC);
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$q->execute(
  array(
    ':id'=>$r['cid']
  )
);
$client=$q->fetch(PDO::FETCH_ASSOC);
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$q->execute(
  array(
    ':id'=>$r['uid']
  )
);
$usr=$q->fetch(PDO::FETCH_ASSOC);
if($r['notes']==''){
  $r['notes']=$config['orderEmailNotes'];
  $q=$db->prepare("UPDATE `".$prefix."orders` SET notes=:notes WHERE id=:id");
  $q->execute(
    array(
      ':notes'=>$config['orderEmailNotes'],
      ':id'=>$r['id']
    )
  );
}
if($error==1)
  echo'<div class="alert alert-danger">'.$e[0].'</div>';
else{?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span id="ordertitle"><?php echo$r['qid'].$r['iid'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/orders';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
        <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');return false;" data-tooltip="tooltip" data-placement="left" title="Print Order"><?php svg('libre-gui-print');?></a>
        <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=');return false;" data-tooltip="tooltip" data-placement="left" title="Email Order"><?php svg('libre-gui-email-send');?></a>
        <?php if($help['orders_edit_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['orders_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['orders_edit_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['orders_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="invoice">
          <div class="row">
            <div class="col-sm-4 border-right">
              <h2>From</h2>
              <div class="form-group">
                <input type="text" class="form-control" value="<?php echo$config['business'];?>" readonly>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">ABN</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$config['abn'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Address</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$config['address'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Suburb</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$config['suburb'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">City</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$config['city'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">State</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$config['state'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Postcode</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$config['postcode']!=0?$config['postcode']:'';?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Email</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$config['email'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Phone</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$config['phone'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Mobile</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$config['mobile'];?>" readonly>
                </div>
              </div>
            </div>
            <div class="col-sm-4 border-right">
              <h2>To</h2>
              <div class="form-group">
                <input type="text" id="client_business" class="form-control" value="<?php echo$client['username'];echo$client['name']!=''?' ['.$client['name'].']':'';echo$client['business']!=''?' -> '.$client['business']:'';?>" placeholder="Username, Business or Name..." readonly>
              </div>
              <div class="form-group row">
                <label for="address" class="col-form-label col-sm-3">Address</label>
                <div class="input-group col-sm-9">
                  <input type="text" id="address" class="form-control form-control-sm textinput oce" value="<?php echo$client['address'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="address" data-bs="btn-danger" placeholder="Enter an Address..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                  <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveaddress" class="btn btn-secondary btn-sm save" data-dbid="address" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="suburb" class="col-form-label col-sm-3">Suburb</label>
                <div class="input-group col-sm-9">
                  <input type="text" id="suburb" class="form-control form-control-sm textinput oce" value="<?php echo$client['suburb'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="suburb" data-bs="btn-danger" placeholder="Enter a Suburb..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                  <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savesuburb" class="btn btn-secondary btn-sm save" data-dbid="suburb" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            <div class="form-group row">
              <label for="city" class="col-form-label col-sm-3">City</label>
              <div class="input-group col-sm-9">
                <input type="text" id="city" class="form-control form-control-sm textinput oce" value="<?php echo$client['city'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="city" data-bs="btn-danger" placeholder="Enter a City..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savecity" class="btn btn-secondary btn-sm save" data-dbid="city" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="state" class="col-form-label col-sm-3">State</label>
              <div class="input-group col-sm-9">
                <input type="text" id="state" class="form-control form-control-sm textinput oce" value="<?php echo$client['state'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="state" data-bs="btn-danger" placeholder="Enter a State..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savestate" class="btn btn-secondary btn-sm save" data-dbid="state" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="postcode" class="col-form-label col-sm-3">Postcode</label>
              <div class="input-group col-sm-9">
                <input type="text" id="postcode" class="form-control form-control-sm textinput oce" value="<?php echo$client['postcode']!=0?$client['postcode']:'';?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="postcode" data-bs="btn-danger" placeholder="Enter a Postcode..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <?php if($r['status']!='archived'){?><div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savepostcode" class="btn btn-secondary btn-sm save" data-dbid="postcode" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div><?php }?>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-form-label col-sm-3">Email</label>
              <div class="input-group col-sm-9">
                <input type="text" id="email" class="form-control form-control-sm textinput oce" value="<?php echo$client['email'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="email" data-bs="btn-danger" placeholder="Enter an Email..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveemail" class="btn btn-secondary btn-sm save" data-dbid="email" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="phone" class="col-form-label col-sm-3">Phone</label>
              <div class="input-group col-sm-9">
                <input type="text" id="phone" class="form-control form-control-sm textinput oce" value="<?php echo$client['phone'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="phone" data-bs="btn-danger" placeholder="Enter a Phone Number..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savephone" class="btn btn-secondary btn-sm save" data-dbid="phone" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="mobile" class="col-form-label col-sm-3">Mobile</label>
              <div class="input-group col-sm-9">
                <input type="text" id="mobile" class="form-control form-control-sm textinput oce" value="<?php echo$client['mobile'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="mobile" data-bs="btn-danger" placeholder="Enter a Mobile Number..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?>>
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savemobile" class="btn btn-secondary btn-sm save" data-dbid="mobile" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
<?php if($r['status']!='archived'){?>
            <div class="form-group row">
              <label for="changeClient" class="col-form-label col-sm-3">Client</label>
              <div class="input-group col-sm-9">
                <select id="changeClient" class="form-control form-control-sm" onchange="changeClient($(this).val(),'<?php echo$r['id'];?>');" data-tooltip="tooltip" title="Select a Client">
                  <option value="0"<?php echo($r['cid']=='0'?' selected':'');?>>None</option>
<?php $q=$db->query("SELECT id,business,username,name FROM `".$prefix."login` WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
while($rs=$q->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['id'].'"'.($r['cid']==$rs['id']?' selected':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business'].'</option>':'');?>
                  </select>
                </div>
                <small class="alert alert-info ocehelp mt-2<?php echo$client['id']!=0?' hidden':'';?>"><small>To edit Client details here you must first create an Account for the Client or Select an already existing Client above.</small></small>
              </div>
<?php }?>
            </div>
            <div class="col-sm-4">
              <h2>Details</h2>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Order #</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$r['iid']==''?$r['qid']:$r['iid'];?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Created</label>
                <div class="input-group col-sm-9">
                  <input type="text" class="form-control form-control-sm" value="<?php echo$r['iid_ti']!=0?date($config['dateFormat'],$r['iid_ti']):date($config['dateFormat'],$r['qid_ti']);?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Due</label>
                <div class="input-group col-sm-9">
                  <input type="text" id="due_ti" class="form-control form-control-sm" data-datetime="<?php echo date($config['dateFormat'],$r['due_ti']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="orders" data-dbc="due_ti" autocomplete="off">
                  <input type="hidden" id="due_tix" value="<?php echo$r['due_ti'];?>">
<?php if($r['status']!='archived'){?>
                  <div class="input-group-append">
                    <div class="dropdown">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" title="Extend Due Date"><?php svg('libre-gui-add');?></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+604800;?>');return false;">7 Days</a>
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+1209600;?>');return false;">14 Days</a>
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+1814400;?>');return false;">21 Days</a>
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+2592000;?>');return false;">30 Days</a>
                      </div>
                    </div>
                  </div>
                  <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savedue_ti" class="btn btn-secondary btn-sm save" data-dbid="due_ti" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
<?php }?>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3">Status</label>
                <div class="input-group col-sm-9">
<?php if($r['status']=='archived')
                  echo'<input type="text" class="form-control form-control-sm" value="Archived" readonly>';
else{?>
                  <select id="status" class="form-control form-control-sm" onchange="update('<?php echo$r['id'];?>','orders','status',$(this).val());" data-tooltip="tooltip" title="Change Order Status">
                    <option value="pending"<?php echo$r['status']=='pending'?' selected':'';?>>Pending</option>
                    <option value="overdue"<?php echo$r['status']=='overdue'?' selected':'';?>>Overdue</option>
                    <option value="cancelled"<?php echo$r['status']=='cancelled'?' selected':'';?>>Cancelled</option>
                    <option value="paid"<?php echo$r['status']=='paid'?' selected':'';?>>Paid</option>
                  </select>
<?php }?>
                </div>
              </div>
            </div>
          </div>
<?php if($r['status']!='archived'){?>
          <form target="sp" method="POST" action="core/updateorder.php">
            <input type="hidden" name="act" value="additem">
            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
            <input type="hidden" name="t" value="orderitems">
            <input type="hidden" name="c" value="">
            <div class="form-group">
              <div class="input-group col-xs-12">
                <select class="form-control" name="da" data-tooltip="tooltip" title="Select Product, Service or Empty Entry">
                  <option value="0">Add Empty Entry...</option>
<?php $s=$db->query("SELECT id,contentType,code,cost,title FROM `".$prefix."content` WHERE contentType='inventory' OR contentType='service' OR contentType='events' ORDER BY code ASC");
while($i=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$i['id'].'">'.ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'].'</option>';?>
                </select>
                <div class="input-group-append">
                  <button class="btn btn-secondary add" data-tooltip="tooltip" title="Add Selected Entry"><?php svg('libre-gui-plus');?></button>
                </div>
              </div>
            </div>
          </form>
<?php }?>
          <div class="table-responsive">
            <table class="table table-condensed table-borderless">
              <thead class="thead-light">
                <tr>
                  <th></th>
                  <th>Code</th>
                  <th class="col text-left">Title</th>
                  <th class="col-sm-2">Option</th>
                  <th class="col-sm-1 text-center">Quantity</th>
                  <th class="col-sm-2 text-center">Cost</th>
                  <th class="col-sm-1 text-right">Total</th>
                  <th class="col-sm-1"></th>
                </tr>
              </thead>
              <tbody id="updateorder">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid ORDER BY ti ASC,title ASC");
$s->execute(array(':oid'=>$r['id']));
$total=0;
while($oi=$s->fetch(PDO::FETCH_ASSOC)){
$is=$db->prepare("SELECT id,thumb,file,fileURL,code,title FROM `".$prefix."content` WHERE id=:id");
$is->execute(array(':id'=>$oi['iid']));
$i=$is->fetch(PDO::FETCH_ASSOC);
$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
$sc->execute(array(':id'=>$oi['cid']));
$c=$sc->fetch(PDO::FETCH_ASSOC);?>
                <tr>
                  <td class="text-center align-middle">
<?php if($i['thumb']!=''&&file_exists('media'.DS.basename($i['thumb'])))
	echo'<img class="img-fluid" style="max-width:24px;height:24px;" src="media'.DS.basename($i['thumb']).'">"';
elseif($i['file']!=''&&file_exists('media'.DS.basename($i['file'])))
	echo'<img class="img-fluid" style="max-width:24px;height:24px;" src="media'.DS.basename($i['file']).'">';
elseif($i['fileURL']!='')
	echo'<img class="img-fluid" style="max-width:24px;height:24px;" src="'.$i['fileURL'],'">';
else
	echo'';?>
                  </td>
                  <td class="text-left align-middle"><?php echo$i['code'];?></td>
                  <td class="text-left align-middle">
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
                  <td class="text-left align-middle"><?php echo$c['title'];?></td>
                  <td class="text-center align-middle">
<?php if($oi['iid']!=0){?>
                    <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                      <input type="hidden" name="act" value="quantity">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="quantity">
                      <input type="text" class="form-control text-center" name="da" value="<?php echo$oi['quantity'];?>"<?php echo$r['status']=='archived'?' readonly':'';?>>
                    </form>
<?php }else{
if($oi['iid']!=0)echo$oi['quantity'];
}?>
                  </td>
                  <td class="text-right align-middle">
<?php if($oi['iid']!=0){?>
                    <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                      <input type="hidden" name="act" value="cost">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="cost">
                      <input class="form-control text-center" style="min-width:80px" name="da" value="<?php echo$oi['cost'];?>"<?php echo$r['status']=='archived'?' readonly':'';?>>
                    </form>
<?php }elseif($oi['iid']!=0)echo$oi['cost'];?>
                  </td>
                  <td class="text-right align-middle"><?php echo$oi['iid']!=0?$oi['cost']*$oi['quantity']:'';?></td>
                  <td class="text-right">
                    <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                      <input type="hidden" name="act" value="trash">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="quantity">
                      <input type="hidden" name="da" value="0">
                      <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                    </form>
                  </td>
                </tr>
<?php if($oi['iid']!=0)$total=$total+($oi['cost']*$oi['quantity']);
}
$sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE id=:rid");
$sr->execute(array(':rid'=>$r['rid']));
$reward=$sr->fetch(PDO::FETCH_ASSOC);?>
                <tr>
                  <td colspan="4" class="text-right align-middle"><strong>Rewards Code</strong></td>
                  <td class="text-center">
                    <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                      <input type="hidden" name="act" value="reward">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <input type="hidden" name="t" value="orders">
                      <input type="hidden" name="c" value="rid">
                      <input type="text" class="form-control" name="da" value="<?php echo$sr->rowCount()==1?$reward['code']:'';?>">
                    </form>
                  </td>
                  <td class="text-center align-middle">
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
                  <td class="text-right align-middle"><strong><?php echo$total;?></strong></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="6" class="text-right align-middle"><strong>Postage</strong></td>
                  <td class="text-right pr-0">
                    <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();">
                      <input type="hidden" name="act" value="postage">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <input type="hidden" name="t" value="orders">
                      <input type="hidden" name="c" value="postage">
                      <input type="text" class="form-control text-right" style="min-width:70px" name="da" value="<?php echo$r['postage'];$total=$total+$r['postage'];?>">
                    </form>
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="6" class="text-right"><strong>Total</strong></td>
                  <td class="total text-right border-top"><strong><?php echo$total;?></strong></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-sm-6">
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
  </div>
</main>
<?php }
