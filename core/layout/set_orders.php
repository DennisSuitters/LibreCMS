<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-6">Orders Settings</h4>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/orders';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <h4 class="page-header">
            Banking
            <button class="btn btn-link pull-right" onclick="$('#orders0').toggleClass('hidden');"><?php svg('unfold');?></button>
        </h4>
        <div id="orders0" class="hidden">
            <div class="form-group">
                <label for="bank" class="control-label col-xs-5 col-sm-3 col-lg-2">Bank</label>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <input type="text" id="bank" class="form-control textinput" value="<?php echo$config['bank'];?>" data-dbid="1" data-dbt="config" data-dbc="bank" placeholder="Enter Bank Name...">
                </div>
            </div>
            <div class="form-group">
                <label for="bankAccountName" class="control-label col-xs-5 col-sm-3 col-lg-2">Account Name</label>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <input type="text" id="bankAccountName" class="form-control textinput" value="<?php echo$config['bankAccountName'];?>"data-dbid="1" data-dbt="config" data-dbc="bankAccountName" placeholder="Enter an Account Name...">
                </div>
            </div>
            <div class="form-group">
                <label for="bankAccountNumber" class="control-label col-xs-5 col-sm-3 col-lg-2">Account Number</label>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <input type="text" id="bankAccountNumber" class="form-control textinput" value="<?php echo$config['bankAccountNumber'];?>" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" placeholder="Enter an Account Number...">
                </div>
            </div>
            <div class="form-group">
                <label for="bankBSB" class="control-label col-xs-5 col-sm-3 col-lg-2">BSB</label>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <input type="text" id="bankBSB" class="form-control textinput" value="<?php echo$config['bankBSB'];?>" data-dbid="1" data-dbt="config" data-dbc="bankBSB" placeholder="Enter a BSB...">
                </div>
            </div>
        </div>
        <h4 class="page-header">
            PayPal
            <button class="btn btn-link pull-right" onclick="$('#orders1').toggleClass('hidden');"><?php svg('unfold');?></button>
        </h4>
        <div id="orders1" class="hidden">
            <div class="form-group">
                <label for="bankPayPal" class="control-label col-xs-5 col-sm-3 col-lg-2">Account</label>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <input type="text" id="bankPayPal" class="form-control textinput" value="<?php echo$config['bankPayPal'];?>" data-dbid="1" data-dbt="config" data-dbc="bankPayPal" placeholder="Enter a PayPal Account...">
                </div>
            </div>
            <div class="form-group">
                <label for="ipn" class="control-label col-xs-5 col-sm-3 col-lg-2">IPN</label>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <input type="text" id="ipn" class="form-control" value="" readonly<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
                </div>
            </div>
        </div>
        <h4 class="page-header">
            Order Processing
            <button class="btn btn-link pull-right" onclick="$('#orders2').toggleClass('hidden');"><?php svg('unfold');?></button>
        </h4>
        <div id="orders2" class="hidden">
            <div class="form-group">
                <label for="orderPayti" class="control-label col-xs-5 col-sm-3 col-lg-2">Allow</label>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <select id="orderPayti" class="form-control" onchange="update('1','config','orderPayti',$(this).val());">
                        <option value="0"<?php if($config['orderPayti']==0)echo' selected';?>>0 Days</option>
                        <option value="604800"<?php if($config['orderPayti']==604800)echo' selected';?>>7 Days</option>
                        <option value="1209600"<?php if($config['orderPayti']==1209600)echo' selected';?>>14 Days</option>
                        <option value="1814400"<?php if($config['orderPayti']==1814400)echo' selected';?>>21 Days</option>
                        <option value="2592000"<?php if($config['orderPayti']==2592000)echo' selected';?>>30 Days</option>
                    </select>
                    <div class="input-group-addon">for Payments</div>
                </div>
            </div>
            <div class="form-group clearfix">
                <label for="orderEmailNotes" class="control-label col-xs-5 col-sm-3 col-lg-2">Order Notes</label>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <form method="post" target="sp" action="core/update.php">
                        <input type="hidden" name="id" value="1">
                        <input type="hidden" name="t" value="config">
                        <input type="hidden" name="c" value="orderEmailNotes">
                        <textarea id="orderEmailNotes" class="form-control summernote" name="da"><?php echo$config['orderEmailNotes'];?></textarea>
                    </form>
                </div>
                <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">You can use the following Tokens: {name} {first} {last} {date} {order_number} {notes}</div>
            </div>
        </div>
        <h4 class="page-header">
            Email Layout
            <button class="btn btn-link pull-right" onclick="$('#orders3').toggleClass('hidden');"><?php svg('unfold');?></button>
        </h4>
        <div id="orders3" class="hidden">
            <div class="form-group clearfix">
                <label for="orderEmailSubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <input type="text" id="orderEmailSubject" class="form-control textinput" value="<?php echo$config['orderEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="orderEmailSubject">
                </div>
                <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Tokens: {name} {first} {last} {date} {order_number}</div>
            </div>
            <div class="form-group clearfix">
                <label for="orderEmailLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <form method="post" target="sp" action="core/update.php">
                        <input type="hidden" name="id" value="1">
                        <input type="hidden" name="t" value="config">
                        <input type="hidden" name="c" value="orderEmailLayout">
                        <textarea id="orderEmailLayout" class="form-control summernote" name="da"><?php echo$config['orderEmailLayout'];?></textarea>
                    </form>
                </div>
                <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Tokens: {name} {first} {last} {date} {order_number} {notes}</div>
            </div>
        </div>
    </div>
</div>
