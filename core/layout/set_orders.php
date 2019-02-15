<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Orders</li>
    <li class="breadcrumb-item active"><strong>Settings</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/orders';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
        <?php if($help['orders_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['orders_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['orders_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['orders_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <legend>Banking</legend>
        <div class="form-group row">
          <label for="bank" class="col-form-label col-sm-2">Bank</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bank">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bank" class="form-control textinput" value="<?php echo$config['bank'];?>" data-dbid="1" data-dbt="config" data-dbc="bank" placeholder="Enter Bank Name...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savebank" class="btn btn-secondary save" data-dbid="bank" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bankAccountName" class="col-form-label col-sm-2">Account Name</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankAccountName">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankAccountName" class="form-control textinput" value="<?php echo$config['bankAccountName'];?>"data-dbid="1" data-dbt="config" data-dbc="bankAccountName" placeholder="Enter an Account Name...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savebankAccountName" class="btn btn-secondary save" data-dbid="bankAccountName" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bankAccountNumber" class="col-form-label col-sm-2">Account Number</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankAccountNumber">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankAccountNumber" class="form-control textinput" value="<?php echo$config['bankAccountNumber'];?>" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" placeholder="Enter an Account Number...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savebankAccountNumber" class="btn btn-secondary save" data-dbid="bankAccountNumber" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bankBSB" class="col-form-label col-sm-2">BSB</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankBSB">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankBSB" class="form-control textinput" value="<?php echo$config['bankBSB'];?>" data-dbid="1" data-dbt="config" data-dbc="bankBSB" placeholder="Enter a BSB...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savebankBSB" class="btn btn-secondary save" data-dbid="bankBSB" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <hr/>
        <legend>PayPal</legend>
        <div class="form-group row">
          <label for="bankPayPal" class="col-form-label col-sm-2">Account</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankPayPal">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankPayPal" class="form-control textinput" value="<?php echo$config['bankPayPal'];?>" data-dbid="1" data-dbt="config" data-dbc="bankPayPal" placeholder="Enter a PayPal Account...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savebankPayPal" class="btn btn-secondary save" data-dbid="bankPayPal" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="ipn" class="col-form-label col-sm-2">IPN</label>
          <div class="input-group col-sm-10">
            <input type="text" id="ipn" class="form-control" value="Not Yet Implemented" readonly data-toggle="tooltip" title="">
          </div>
        </div>
        <hr/>
        <legend>Order Processing</legend>
        <div class="form-group row">
          <label for="orderPayti" class="col-form-label col-sm-2">Allow</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="orderPayti">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <select id="orderPayti" class="form-control" onchange="update('1','config','orderPayti',$(this).val());" data-dbid="1" data-dbt="congig" data-dbc="orderPayti">
              <option value="0"<?php echo$config['orderPayti']==0?' selected':'';?>>0 Days</option>
              <option value="604800"<?php echo$config['orderPayti']==604800?' selected':'';?>>7 Days</option>
              <option value="1209600"<?php echo$config['orderPayti']==1209600?' selected':'';?>>14 Days</option>
              <option value="1814400"<?php echo$config['orderPayti']==1814400?' selected':'';?>>21 Days</option>
              <option value="2592000"<?php echo$config['orderPayti']==2592000?' selected':'';?>>30 Days</option>
            </select>
            <div class="input-group-text">for Payments</div>
          </div>
        </div>
        <div class="form-group row">
          <label for="orderEmailNotes" class="col-form-label col-sm-2">Order Notes</label>
          <div class="input-group card-header col-sm-10 p-0">
            <?php echo($user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="oen">'.svg2('libre-gui-fingerprint').'</button>':'');
            echo$user['rank']>899?'<div id="oen" data-dbid="1" data-dbt="config" data-dbc="orderEmailNotes"></div>':'';?>
            <small class="text-muted p-2">You can use the following Tokens: {name} {first} {last} {date} {order_number} {notes}</small>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="orderEmailNotes">
              <textarea id="orderEmailNotes" class="form-control summernote" name="da"><?php echo rawurldecode($config['orderEmailNotes']);?></textarea>
            </form>
          </div>
        </div>
        <hr/>
        <h4>Email Layout</h4>
        <div class="form-group row">
          <label for="orderEmailReadNotification" class="col-form-label col-sm-2">Read Reciept</label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="orderEmailReadNotification" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="orderEmailReadNotification" data-dbb="0"<?php echo$config['orderEmailReadNotification']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
        </div>
        <div class="help-block small text-muted text-right">Tokens: {name} {first} {last} {date} {order_number}</div>
        <div class="form-group row">
          <label for="orderEmailSubject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="orderEmailSubject">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="orderEmailSubject" class="form-control textinput" value="<?php echo$config['orderEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="orderEmailSubject">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveorderEmailSubject" class="btn btn-secondary save" data-dbid="orderEmailSubject" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="orderEmailLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="input-group card-header col-sm-10 p-0">
            <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="oel">'.svg2('libre-gui-fingerprint').'</button>':'';
            echo$user['rank']>899?'<div id="oel" data-dbid="1" data-dbt="config" data-dbc="orderEmailLayout"></div>':'';?>
            <small class="text-muted p-2">Tokens: {name} {first} {last} {date} {order_number} {notes}</small>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="orderEmailLayout">
              <textarea id="orderEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['orderEmailLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
