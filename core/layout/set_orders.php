<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Orders Settings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/orders';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#orders-settings" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <h4 class="page-header">Banking</h4>
    <div class="form-group">
      <label for="bank" class="control-label col-xs-5 col-sm-3 col-lg-2">Bank</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <input type="text" id="bank" class="form-control textinput" value="<?php echo$config['bank'];?>" data-dbid="1" data-dbt="config" data-dbc="bank" placeholder="Enter Bank Name...">
      </div>
    </div>
    <div class="form-group">
      <label for="bankAccountName" class="control-label col-xs-5 col-sm-3 col-lg-2">Account Name</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="bankAccountName">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="bankAccountName" class="form-control textinput" value="<?php echo$config['bankAccountName'];?>"data-dbid="1" data-dbt="config" data-dbc="bankAccountName" placeholder="Enter an Account Name...">
      </div>
    </div>
    <div class="form-group">
      <label for="bankAccountNumber" class="control-label col-xs-5 col-sm-3 col-lg-2">Account Number</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="bankAccountNumber">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="bankAccountNumber" class="form-control textinput" value="<?php echo$config['bankAccountNumber'];?>" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" placeholder="Enter an Account Number...">
      </div>
    </div>
    <div class="form-group">
      <label for="bankBSB" class="control-label col-xs-5 col-sm-3 col-lg-2">BSB</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="bankBSB">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="bankBSB" class="form-control textinput" value="<?php echo$config['bankBSB'];?>" data-dbid="1" data-dbt="config" data-dbc="bankBSB" placeholder="Enter a BSB...">
      </div>
    </div>
    <h4 class="page-header">PayPal</h4>
    <div class="form-group">
      <label for="bankPayPal" class="control-label col-xs-5 col-sm-3 col-lg-2">Account</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="bankPayPal">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="bankPayPal" class="form-control textinput" value="<?php echo$config['bankPayPal'];?>" data-dbid="1" data-dbt="config" data-dbc="bankPayPal" placeholder="Enter a PayPal Account...">
      </div>
    </div>
    <div class="form-group">
      <label for="ipn" class="control-label col-xs-5 col-sm-3 col-lg-2">IPN</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <input type="text" id="ipn" class="form-control" value="Not Yet Implemented" readonly data-toggle="tooltip" title="">
      </div>
    </div>
    <h4 class="page-header">Order Processing</h4>
    <div class="form-group">
      <label for="orderPayti" class="control-label col-xs-5 col-sm-3 col-lg-2">Allow</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="orderPayti">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <select id="orderPayti" class="form-control" onchange="update('1','config','orderPayti',$(this).val());" data-dbid="1" data-dbt="congig" data-dbc="orderPayti">
          <option value="0"<?php echo($config['orderPayti']==0?' selected':'');?>>0 Days</option>
          <option value="604800"<?php echo($config['orderPayti']==604800?' selected':'');?>>7 Days</option>
          <option value="1209600"<?php echo($config['orderPayti']==1209600?' selected':'');?>>14 Days</option>
          <option value="1814400"<?php echo($config['orderPayti']==1814400?' selected':'');?>>21 Days</option>
          <option value="2592000"<?php echo($config['orderPayti']==2592000?' selected':'');?>>30 Days</option>
        </select>
        <div class="input-group-addon">for Payments</div>
      </div>
    </div>
    <div class="form-group clearfix">
      <label for="orderEmailNotes" class="control-label col-xs-5 col-sm-3 col-lg-2">Order Notes</label>
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs" style="background-color:#f5f5f5;border:1px solid #ccc;border-bottom:0;"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="oen">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div><div id="oen" data-dbid="1" data-dbt="config" data-dbc="orderEmailNotes"></div>':'');?>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="t" value="config">
          <input type="hidden" name="c" value="orderEmailNotes">
          <textarea id="orderEmailNotes" class="form-control summernote" name="da"><?php echo rawurldecode($config['orderEmailNotes']);?></textarea>
          <small class="help-block text-right">You can use the following Tokens: {name} {first} {last} {date} {order_number} {notes}</small>
        </form>
      </div>
    </div>
    <h4 class="page-header">Email Layout</h4>
    <div class="form-group">
      <label for="orderEmailReadNotification" class="control-label col-xs-5 col-sm-3 col-lg-2">Read Reciept</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <div class="checkbox checkbox-success">
          <input type="checkbox" id="orderEmailReadNotification" data-dbid="1" data-dbt="config" data-dbc="orderEmailReadNotification" data-dbb="0"<?php echo($config['orderEmailReadNotification']{0}==1?' checked':'');?>>
          <label for="orderEmailReadNotification"/>
        </div>
      </div>
    </div>
    <div class="form-group clearfix">
      <label for="orderEmailSubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="orderEmailSubject">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="orderEmailSubject" class="form-control textinput" value="<?php echo$config['orderEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="orderEmailSubject">
      </div>
      <small class="help-block text-right">Tokens: {name} {first} {last} {date} {order_number}</small>
    </div>
    <div class="form-group clearfix">
      <label for="orderEmailLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs" style="background-color:#f5f5f5;border:1px solid #ccc;border-bottom:0;"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="oel">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div><div id="oel" data-dbid="1" data-dbt="config" data-dbc="orderEmailLayout"></div>':'');?>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="t" value="config">
          <input type="hidden" name="c" value="orderEmailLayout">
          <textarea id="orderEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['orderEmailLayout']);?></textarea>
          <small class="help-block text-right">Tokens: {name} {first} {last} {date} {order_number} {notes}</small>
        </form>
      </div>
    </div>
  </div>
</div>
