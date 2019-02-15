<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
$sr=$db->prepare("SELECT contentType FROM `".$prefix."content` where id=:id");
$sr->execute(array(':id'=>$r['rid']));
$rs=$sr->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>">Bookings</a></li>
    <li class="breadcrumb-item active" aria-current="page"><span id="bookingname"><?php echo$r['name'];?></span>:<span id="bookingbusiness"><?php echo$r['business'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
        <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/email_booking.php?id=<?php echo$r['id'];?>');return false;" data-tooltip="tooltip" data-placement="left" title="Email Booking"><?php svg('libre-gui-email-send');?></a>
        <?php if($help['bookings_edit_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['bookings_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['bookings_edit_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['bookings_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label for="tis" class="col-form-label col-sm-2">Booked For</label>
          <div class="input-group col-sm-10">
            <?php echo($user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="tis" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'');?>
            <input type="text" id="tis" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" data-datetime="<?php echo date($config['dateFormat'],$r['tis']);?>"<?php echo$user['options']{2}==0?' readonly':'';?>>
            <input type="hidden" id="tisx" value="<?php echo$r['tis'];?>">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savetis" class="btn btn-secondary save" data-dbid="tis" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="tie" class="col-form-label col-sm-2">Booking End</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="tie" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="tie" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" data-datetime="<?php echo$r['tie']!=0?date($config['dateFormat'],$r['tie']):date($config['dateFormat'], $r['tis']);?>" autocomplete="off"<?php echo$user['options']{2}==0?' readonly':'';?>>
            <input type="hidden" id="tiex" value="<?php echo$r['tie'];?>">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savetie" class="btn btn-secondary save" data-dbid="tie" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="status" class="col-form-label col-sm-2">Status</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="status" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php echo$user['options']{2}==0?' readonly':'';?> data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="status">
              <option value="unconfirmed"<?php echo$r['status']=='unconfirmed'?' selected':'';?>>Unconfirmed</option>
              <option value="confirmed"<?php echo$r['status']=='confirmed'?' selected':'';?>>Confirmed</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="cid" class="col-form-label col-sm-2">Client</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="changeClient" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').' </button></div>':'';?>
            <select id="cid" class="form-control" onchange="changeClient($(this).val(),<?php echo$r['id'];?>,'booking');" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid">
              <option value="0"<?php echo$r['cid']=='0'?' selected':'';?>>Select a Client...</option>
<?php $q=$db->query("SELECT id,business,username,name FROM `".$prefix."login` WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
while($rs=$q->fetch(PDO::FETCH_ASSOC))
              echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['cid']?' selected="selected"':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business']:'').'</option>';?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-form-label col-sm-2">Email</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="email" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="email" class="form-control textinput" name="email" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="Enter an Email...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-form-label col-sm-2">Phone</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="phone" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="phone" class="form-control textinput" name="phone" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone" placeholder="Enter a Phone Number...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savephone" class="btn btn-secondary save" data-dbid="phone" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-form-label col-sm-2">Name</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="name" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="name" class="form-control textinput" name="name" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="Enter a Name..." onkeyup="$('#bookingname').html($(this).val());">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savename" class="btn btn-secondary save" data-dbid="name" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="business" class="col-form-label col-sm-2">Business</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="business" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="business" class="form-control textinput" name="business" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="Enter a Business..." onkeyup="$('#bookingbusiness').html($(this).val());">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-form-label col-sm-2">Address</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="address" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="address" placeholder="Enter an Address...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveaddress" class="btn btn-secondary save" data-dbid="address" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="suburb" class="col-form-label col-sm-2">Suburb</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="suburb" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="suburb" placeholder="Enter a Suburb...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savesuburb" class="btn btn-secondary save" data-dbid="suburb" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="city" class="col-form-label col-sm-2">City</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="city" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="city" placeholder="Enter a City...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savecity" class="btn btn-secondary save" data-dbid="city" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="state" class="col-form-label col-sm-2">State</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="state" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="state" placeholder="Enter a State...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savestate" class="btn btn-secondary save" data-dbid="state" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="postcode" class="col-form-label col-sm-2">Postcode</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="postcode" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php echo$r['postcode']!=0?$r['postcode']:'';?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="postcode" placeholder="Enter a Postcode...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savepostcode" class="btn btn-secondary save" data-dbid="postcode" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
<?php $sql=$db->query("SELECT id,contentType,code,title,assoc FROM `".$prefix."content` WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");?>
        <div class="form-group row">
          <label for="rid" class="control-label col-sm-2">Booked</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="rid" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <select id="rid" class="form-control" name="rid" onchange="update('<?php echo$r['id'];?>','content','rid',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rid">
              <option value="0">Select an Item...</option>
<?php while($row=$sql->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$row['id'].'"'.($r['rid']==$row['id']?' selected':'').'>'.ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'].'</option>';?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="notes" class="col-form-label col-sm-2">Notes</label>
          <div class="col-sm-10">
            <div class="card-header p-0">
              <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="da" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button>':'';
              echo$user['rank']>899?'<div id="da" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="notes"></div>':'';?>
              <form id="summernote" method="post" target="sp" action="core/update.php">
                <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                <input type="hidden" name="t" value="content">
                <input type="hidden" name="c" value="notes">
                <textarea id="notes" class="summernote" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
