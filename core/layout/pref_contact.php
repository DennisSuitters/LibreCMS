<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Contacts Preferences
 *
 * pref_contact.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Preferences - Contact
 * @package    core/layout/pref_contact.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php echo localize('Preferences');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Contact');?></li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <div id="businessErrorBlock" class="help-block small text-muted text-right<?php echo$config['business']!=''?' hidden':'';?>" role="alert"><?php echo localize('warning_nobusinessname');?></div>
        <div id="businessHasError" class="form-group row<?php echo($config['business']==''?' has-error':'');?>">
          <label for="business" class="col-form-label col-sm-2"><?php echo localize('Business');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="business" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="business" class="form-control textinput" value="<?php echo$config['business'];?>" data-dbid="1" data-dbt="config" data-dbc="business" placeholder="<?php echo localize('Enter a ').' '.localize('Business');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="abn" class="col-form-label col-sm-2"><?php echo localize('ABN');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="abn" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="abn" class="form-control textinput" value="<?php echo$config['abn'];?>" data-dbid="1" data-dbt="config" data-dbc="abn" placeholder="<?php echo localize('Enter an ').' '.localize('ABN');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveabn" class="btn btn-secondary save" data-dbid="abn" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div id="emailErrorBlock" class="help-block small text-right<?php echo$config['email']!=''?' hidden':'';?>" role="alert"><?php echo localize('alert_all_warning_noemail');?></div>
        <div id="emailHasError" class="form-group row<?php echo$config['email']==''?' has-error':'';?>">
          <label for="email" class="col-form-label col-sm-2"><?php echo localize('Email');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="email" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="<?php echo localize('Enter an ').' '.localize('Email');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-form-label col-sm-2"><?php echo localize('Phone');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="phone" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="phone" class="form-control textinput" value="<?php echo$config['phone'];?>" data-dbid="1" data-dbt="config" data-dbc="phone" placeholder="<?php echo localize('Enter a ').' '.localize('Phone');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savephone" class="btn btn-secondary save" data-dbid="phone" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mobile" class="col-form-label col-sm-2"><?php echo localize('Mobile');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="mobile" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="mobile" class="form-control textinput" value="<?php echo$config['mobile'];?>" data-dbid="1" data-dbt="config" data-dbc="mobile" placeholder="<?php echo localize('Enter a ').' '.localize('Mobile');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savemobile" class="btn btn-secondary save" data-dbid="mobile" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-form-label col-sm-2"><?php echo localize('Address');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="address" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="address" class="form-control textinput" value="<?php echo$config['address'];?>" data-dbid="1" data-dbt="config" data-dbc="address" placeholder="<?php echo localize('Enter an ').' '.localize('Address');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveaddress" class="btn btn-secondary save" data-dbid="address" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="suburb" class="col-form-label col-sm-2"><?php echo localize('Suburb');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="suburb" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="suburb" class="form-control textinput" value="<?php echo$config['suburb'];?>" data-dbid="1" data-dbt="config" data-dbc="suburb" placeholder="<?php echo localize('Enter a ').' '.localize('Suburb');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savesuburb" class="btn btn-secondary save" data-dbid="suburb" data-style="zoom-in" role="button" aria-label="Save Suburb"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="city" class="col-form-label col-sm-2"><?php echo localize('City');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="city" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="city" class="form-control textinput" value="<?php echo$config['city'];?>" data-dbid="1" data-dbt="config" data-dbc="city" placeholder="<?php echo localize('Enter a ').' '.localize('City');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savecity" class="btn btn-secondary save" data-dbid="city" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="state" class="col-form-label col-sm-2"><?php echo localize('State');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="state" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="state" class="form-control textinput" value="<?php echo$config['state'];?>" data-dbid="1" data-dbt="config" data-dbc="state" placeholder="<?php echo localize('Enter a ').' '.localize('State');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savestate" class="btn btn-secondary save" data-dbid="state" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="postcode" class="col-form-label col-sm-2"><?php echo localize('Postcode');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="postcode" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="postcode" class="form-control textinput" value="<?php echo$config['postcode']!=0?$config['postcode']:'';?>" data-dbid="1" data-dbt="config" data-dbc="postcode" placeholder="<?php echo localize('Enter a ').' '.localize('Postcode');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savepostcode" class="btn btn-secondary save" data-dbid="postcode" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="country" class="col-form-label col-sm-2"><?php echo localize('Country');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="country" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="country" class="form-control textinput" value="<?php echo$config['country'];?>" data-dbid="1" data-dbt="config" data-dbc="country" placeholder="<?php echo localize('Enter a ').' '.localize('Country');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savecountry" class="btn btn-secondary save" data-dbid="country" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
