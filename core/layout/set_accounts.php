<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Accounts Settings
 *
 * set_accounts.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Settings - Accounts
 * @package    core/layout/set_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"><?php echo localize('Accounts');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Settings');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Back');?>" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <?php if($help['accounts_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['accounts_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['accounts_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['accounts_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label for="options3" class="col-form-label col-8 col-sm-2" data-tooltip="tooltip" title="<?php echo localize('tooltip_allowaccounts');?>"><?php echo localize('Account Sign Ups');?></label>
          <div class="input-group col-4 col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options3" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3" role="checkbox"<?php echo$config['options']{3}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
          </div>
        </div>
        <hr/>
        <legend><?php echo localize('Password Reset Email Layout');?></legend>
        <div class="col-12 text-right"><small><?php echo localize('Tokens');?>:</small> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('passwordResetSubject','{<?php echo localize('business');?>}');return false;">{<?php echo localize('business');?>}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('passwordResetSubject','{<?php echo localize('date');?>}');return false;">{<?php echo localize('date');?>}</a></div>
        <div class="form-group row">
          <label for="passwordResetSubject" class="col-form-label col-sm-2"><?php echo localize('Subject');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="passwordResetSubject" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="passwordResetSubject" class="form-control textinput" value="<?php echo$config['passwordResetSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="passwordResetSubject" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savepasswordResetSubject" class="btn btn-secondary save" data-dbid="passwordResetSubject" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="passwordResetLayout" class="col-form-label col-sm-2"><?php echo localize('Layout');?></label>
          <div class="input-group card-header col-sm-10 p-0">
            <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-toggle="popover" data-dbgid="prl" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button><div id="prl" data-dbid="1" data-dbt="config" data-dbc="passwordResetLayout"></div>':'';?>
            <div class="col text-right"><small><?php echo localize('Tokens');?>:</small> 
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{<?php echo localize('business');?>}');return false;">{<?php echo localize('business');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{<?php echo localize('name');?>}');return false;">{<?php echo localize('name');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{<?php echo localize('first');?>}');return false;">{<?php echo localize('first');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{<?php echo localize('last');?>}');return false;">{<?php echo localize('last');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{<?php echo localize('date');?>}');return false;">{<?php echo localize('date');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#passwordResetLayout').summernote('insertText','{<?php echo localize('password');?>}');return false;">{<?php echo localize('password');?>}</a>
            </div>
            <form method="post" target="sp" action="core/update.php" role="form">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="passwordResetLayout">
              <textarea id="passwordResetLayout" class="form-control summernote" name="da" role="textbox"><?php echo rawurldecode($config['passwordResetLayout']);?></textarea>
            </form>
          </div>
        </div>
        <hr/>
        <legend><?php echo localize('Sign Up Emails');?></legend>
        <div class="col-12 text-right"><small><?php echo localize('Tokens');?>:</small> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('accountActivationSubject','{<?php echo localize('username');?>}');return false;">{<?php echo localize('username');?>}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('accountActivationSubject','{<?php echo localize('site');?>}');return false;">{<?php echo localize('site');?>}</a></div>
        <div class="form-group row">
          <label for="accountActivationSubject" class="col-form-label col-sm-2"><?php echo localize('Subject');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="accountActivationSubject" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="accountActivationSubject" class="form-control textinput" value="<?php echo$config['accountActivationSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="accountActivationSubject" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveaccountActivationSubject" class="btn btn-secondary save" data-dbid="accountActivationSubject" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="accountActivationLayout" class="col-form-label col-sm-2"><?php echo localize('Layout');?></label>
          <div class="input-group card-header col-sm-10 p-0">
            <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="aal" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="Layout Fingerprint Analysis" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button><div id="aal" data-dbid="1" data-dbt="config" data-dbc="accountActivationLayout"></div>':'';?>
            <div class="col text-right"><small><?php echo localize('Tokens');?>:</small> 
              <a class="badge badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{<?php echo localize('username');?>}');return false;">{<?php echo localize('username');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{<?php echo localize('password');?>}');return false;">{<?php echo localize('password');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{<?php echo localize('site');?>}');return false;">{<?php echo localize('site');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#accountActivationLayout').summernote('insertText','{<?php echo localize('activation_link');?>}');return false;">{<?php echo localize('activation_link');?>}</a>
            </div>
            <form method="post" target="sp" action="core/update.php" role="form">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="accountActivationLayout">
              <textarea id="accountActivationLayout" class="form-control summernote" name="da" role="textbox"><?php echo rawurldecode($config['accountActivationLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
