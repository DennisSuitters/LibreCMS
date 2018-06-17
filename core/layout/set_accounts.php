<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Accounts Settings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/accounts';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#accounts-settings" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label for="options3" class="control-label check col-xs-6 col-sm-4 col-lg-3" data-toggle="tooltip" title="Allow Users to Create Accounts.">Enable Account Sign Ups</label>
      <div class="input-group col-xs-6 col-sm-8 col-lg-9">
        <div class="checkbox checkbox-success">
          <input type="checkbox" id="options3" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3"<?php echo($config['options']{3}==1?' checked':'');?>>
          <label for="options3"/>
        </div>
      </div>
    </div>
    <h4 class="page-header">Password Reset Email Layout</h4>
    <div class="form-group clearfix">
      <label for="passwordResetSubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="passwordResetSubject">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="passwordResetSubject" class="form-control textinput" value="<?php echo$config['passwordResetSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="passwordResetSubject">
      </div>
      <small class="help-block text-right">Tokens: {site} {name} {first} {last} {date}</small>
    </div>
    <div class="form-group clearfix">
      <label for="passwordResetLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs" style="background-color:#f5f5f5;border:1px solid #ccc;border-bottom:0;"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="prl">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div><div id="prl" data-dbid="1" data-dbt="config" data-dbc="passwordResetLayout"></div>':'');?>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="t" value="config">
          <input type="hidden" name="c" value="passwordResetLayout">
          <textarea id="passwordResetLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['passwordResetLayout']);?></textarea>
          <small class="help-block text-right">Tokens: {site} {name} {first} {last} {password}</small>
        </form>
      </div>
    </div>
    <h4 class="page-header">Sign Up Emails</h4>
    <div class="form-group clearfix">
      <label for="accountActivationSubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="accountActivationSubject">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="accountActivationSubject" class="form-control textinput" value="<?php echo$config['accountActivationSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="accountActivationSubject">
      </div>
      <small class="help-block text-right">Tokens: {username} {site}</small>
    </div>
    <div class="form-group clearfix">
      <label for="accountActivationLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs" style="background-color:#f5f5f5;border:1px solid #ccc;border-bottom:0;"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="aal">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div><div id="aal" data-dbid="1" data-dbt="config" data-dbc="accountActivationLayout"></div>':'');?>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="t" value="config">
          <input type="hidden" name="c" value="accountActivationLayout">
          <textarea id="accountActivationLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['accountActivationLayout']);?></textarea>
          <small class="help-block text-right">Tokens: {username} {password} {site} {activation_link}</small>
        </form>
      </div>
    </div>
  </div>
</div>
