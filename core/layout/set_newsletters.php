<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Newsletters Settings
 *
 * set_newsletters.php version 2.0.2
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
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php echo localize('Content');?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>"><?php echo localize('Newsletters');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Settings');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Back');?>" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <?php if($help['newsletters_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['newsletters_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['newsletters_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['newsletters_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label for="newslettersEmbedImages" class="col-form-label col-sm-2"><?php echo localize('Embed Images');?></label>
          <div class="input-group col-sm-2">
            <label class="switch switch-label switch-success"><input type="checkbox" id="newslettersEmbedImages" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="newslettersEmbedImages" data-dbb="0" role="checkbox"<?php echo$config['newslettersEmbedImages']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
          </div>
          <div class="input-group col-sm-8">
            <div class="help-block small p-1"><?php echo localize('help_embedimages');?></div>
          </div>
        </div>
        <div class="form-group row">
          <div class="help-block small col-12 text-right"><?php echo localize('help_newsletters');?></div>
          <label for="newslettersSendMax" class="col-form-label col-sm-2"><?php echo localize('Send Max');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="newslettersSendMax" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="newslettersSendMax" class="form-control textinput" value="<?php echo$config['newslettersSendMax'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendMax" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savenewslettersSendMax" class="btn btn-secondary save" data-dbid="newslettersSendMax" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-12 small text-right"><?php echo localize('help_emaildelay');?></div>
          <label for="newslettersSendDelay" class="col-form-label col-sm-2"><?php echo localize('Send Delay');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="newslettersSendDelay" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="newslettersSendDelay" class="form-control textinput" value="<?php echo$config['newslettersSendDelay'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendDelay" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savenewslettersSendDelay" class="btn btn-secondary save" data-dbid="newslettersSendDelay" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <hr/>
        <legend><?php echo localize('Opt Out Message');?></legend>
        <div class="form-group row">
          <label class="col-form-label col-sm-2"></label>
          <div class="input-group card-header col-sm-10 p-0">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary btn-sm fingerprint" data-dbgid="nool" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div><div id="nool" data-dbid="1" data-dbt="config" data-dbc="newslettersOptOutLayout"></div>':'';?>
            <div class="col text-right"><small><?php echo localize('Tokens');?>:</small>
              <a class="badge badge-secondary" href="#" onclick="$('#optOutLayout').summernote('insertText','{<?php echo localize('optOutLink');?>}');return false;">{<?php echo localize('optOutLink');?>}</a>
            </div>
            <form method="post" target="sp" action="core/update.php" role="form">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="newslettersOptOutLayout">
              <textarea id="optOutLayout" class="form-control summernote" name="da" role="textbox"><?php echo rawurldecode($config['newslettersOptOutLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
