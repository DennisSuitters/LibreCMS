<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/accounts';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
        <?php if($help['accounts_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['accounts_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['accounts_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['accounts_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label for="options3" class="col-form-label col-8 col-sm-2" data-toggle="tooltip" title="Allow Users to Create Accounts.">Account Sign Ups</label>
          <div class="input-group col-4 col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options3" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3"<?php echo$config['options']{3}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
        </div>
        <hr/>
        <h4>Password Reset Email Layout</h4>
        <div class="help-block small text-muted text-right">Tokens: {business} {date}</div>
        <div class="form-group row">
          <label for="passwordResetSubject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="passwordResetSubject">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="passwordResetSubject" class="form-control textinput" value="<?php echo$config['passwordResetSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="passwordResetSubject">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savepasswordResetSubject" class="btn btn-secondary save" data-dbid="passwordResetSubject" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">Tokens: {business} {name} {first} {last} {date} {password}</div>
        <div class="form-group row">
          <label for="passwordResetLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="col-sm-10">
            <div class="card-header p-0">
              <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-toggle="popover" data-dbgid="prl">'.svg2('libre-gui-fingerprint').'</button>':'';?>
              <div id="prl" data-dbid="1" data-dbt="config" data-dbc="passwordResetLayout"></div>
              <form method="post" target="sp" action="core/update.php">
                <input type="hidden" name="id" value="1">
                <input type="hidden" name="t" value="config">
                <input type="hidden" name="c" value="passwordResetLayout">
                <textarea id="passwordResetLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['passwordResetLayout']);?></textarea>
              </form>
            </div>
          </div>
        </div>
        <hr/>
        <h4>Sign Up Emails</h4>
        <div class="help-block small text-muted text-right">Tokens: {username} {site}</div>
        <div class="form-group row">
          <label for="accountActivationSubject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="accountActivationSubject">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="accountActivationSubject" class="form-control textinput" value="<?php echo$config['accountActivationSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="accountActivationSubject">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveaccountActivationSubject" class="btn btn-secondary save" data-dbid="accountActivationSubject" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">Tokens: {username} {password} {site} {activation_link}</div>
        <div class="form-group row">
          <label for="accountActivationLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="col-sm-10">
            <div class="card-header p-0">
              <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="aal">'.svg2('libre-gui-fingerprint').'</button>':'';?>
              <div id="aal" data-dbid="1" data-dbt="config" data-dbc="accountActivationLayout"></div>
              <form method="post" target="sp" action="core/update.php">
                <input type="hidden" name="id" value="1">
                <input type="hidden" name="t" value="config">
                <input type="hidden" name="c" value="accountActivationLayout">
                <textarea id="accountActivationLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['accountActivationLayout']);?></textarea>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
