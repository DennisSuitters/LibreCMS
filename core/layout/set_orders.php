<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Orders Settings
 *
 * set_orders.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Settings - Orders
 * @package    core/layout/set_orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/orders';?>">Orders</a></li>
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
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bank" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bank" class="form-control textinput" value="<?php echo$config['bank'];?>" data-dbid="1" data-dbt="config" data-dbc="bank" placeholder="Enter Bank Name...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savebank" class="btn btn-secondary save" data-dbid="bank" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bankAccountName" class="col-form-label col-sm-2">Account Name</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankAccountName" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankAccountName" class="form-control textinput" value="<?php echo$config['bankAccountName'];?>"data-dbid="1" data-dbt="config" data-dbc="bankAccountName" placeholder="Enter an Account Name...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savebankAccountName" class="btn btn-secondary save" data-dbid="bankAccountName" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bankAccountNumber" class="col-form-label col-sm-2">Account Number</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankAccountNumber" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankAccountNumber" class="form-control textinput" value="<?php echo$config['bankAccountNumber'];?>" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" placeholder="Enter an Account Number...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savebankAccountNumber" class="btn btn-secondary save" data-dbid="bankAccountNumber" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bankBSB" class="col-form-label col-sm-2">BSB</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankBSB" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankBSB" class="form-control textinput" value="<?php echo$config['bankBSB'];?>" data-dbid="1" data-dbt="config" data-dbc="bankBSB" placeholder="Enter a BSB...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savebankBSB" class="btn btn-secondary save" data-dbid="bankBSB" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <hr/>
        <legend>PayPal</legend>
        <div class="form-group row">
          <label for="bankPayPal" class="col-form-label col-sm-2">Account</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankPayPal" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankPayPal" class="form-control textinput" value="<?php echo$config['bankPayPal'];?>" data-dbid="1" data-dbt="config" data-dbc="bankPayPal" placeholder="Enter a PayPal Account...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savebankPayPal" class="btn btn-secondary save" data-dbid="bankPayPal" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="ipn" class="col-form-label col-sm-2">IPN</label>
          <div class="input-group col-sm-10">
            <input type="text" id="ipn" class="form-control" value="Not Yet Implemented" readonly data-tooltip="tooltip" title="">
          </div>
        </div>
        <hr/>
        <legend>Order Processing</legend>
        <div class="form-group row">
          <label for="orderPayti" class="col-form-label col-sm-2">Allow</label>
          <div class="input-group col-sm-10">
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
<?php echo($user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="oen" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button><div id="oen" data-dbid="1" data-dbt="config" data-dbc="orderEmailNotes"></div>':'');?>
            <div class="col text-right"><small class="text-muted">Tokens:</small> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{name}');return false;">{name}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{first}');return false;">{first}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{last}');return false;">{last}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{date}');return false;">{date}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{order_number}');return false;">{order_number}</a></div>
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
        <div class="col-12 text-right"><smal class="text-muted">Tokens:</small> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{name}');return false;">{name}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{first}');return false;">{first}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{last}');return false;">{last}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{date}');return false;">{date}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{order_number}');return false;">{order_number}</a></div>
        <div class="form-group row">
          <label for="orderEmailSubject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="orderEmailSubject" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="orderEmailSubject" class="form-control textinput" value="<?php echo$config['orderEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="orderEmailSubject">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveorderEmailSubject" class="btn btn-secondary save" data-dbid="orderEmailSubject" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="orderEmailLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="input-group card-header col-sm-10 p-0">
<?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="oel" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button><div id="oel" data-dbid="1" data-dbt="config" data-dbc="orderEmailLayout"></div>':'';?>
            <div class="col text-right"><small class="text-muted">Tokens:</small> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{name}');return false;">{name}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{first}');return false;">{first}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{last}');return false;">{last}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{date}');return false;">{date}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{order_number}');return false;">{order_number}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{notes}');return false;">{notes}</a></div>
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
