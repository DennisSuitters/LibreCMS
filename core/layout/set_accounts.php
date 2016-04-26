<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-6">Accounts Settings</h4>
        <div class="pull-right">
            <div class="btn-group">
                <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <div class="control-label col-xs-5 col-sm-3 col-lg-2 text-right">
                <input type="checkbox" id="options3" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3"<?php if($config['options']{3}==1)echo' checked';?>>
                <label for="options3">
            </div>
            <label for="options3" class="input-group col-xs-7 col-sm-9 col-lg-10"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Allow Users to Create Accounts."';?>>Enable Account Sign Ups</span></label>
        </div>
        <h4 class="page-header">Password Reset Email Layout</h4>
        <div class="form-group clearfix">
            <label for="passwordResetSubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <input type="text" id="passwordResetSubject" class="form-control textinput" value="<?php echo$config['passwordResetSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="passwordResetSubject">
            </div>
            <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Tokens: {name} {first} {last} {date}</div>
        </div>
        <div class="form-group clearfix">
            <label for="passwordResetLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <form method="post" target="sp" action="core/update.php">
                    <input type="hidden" name="id" value="1">
                    <input type="hidden" name="t" value="config">
                    <input type="hidden" name="c" value="passwordResetLayout">
                    <textarea id="passwordResetLayout" class="form-control summernote" name="da"><?php echo$config['passwordResetLayout'];?></textarea>
                </form>
            </div>
            <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Tokens: {name} {first} {last} {password}</div>
        </div>
        <h4 class="page-header">Sign Up Emails</h4>
        <div class="form-group clearfix">
            <label for="accountActivationSubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <input type="text" id="accountActivationSubject" class="form-control textinput" value="<?php echo$config['accountActivationSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="accountActivationSubject">
            </div>
            <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Tokens: {name} {first} {last} {date}</div>
        </div>
        <div class="form-group clearfix">
            <label for="accountActivationLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <form method="post" target="sp" action="core/update.php">
                    <input type="hidden" name="id" value="1">
                    <input type="hidden" name="t" value="config">
                    <input type="hidden" name="c" value="accountActivationLayout">
                    <textarea id="accountActivationLayout" class="form-control summernote" name="da"><?php echo$config['accountActivationLayout'];?></textarea>
                </form>
            </div>
            <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Tokens: {username} {activation_link} {password}</div>
        </div>
    </div>
</div>
