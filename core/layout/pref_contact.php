<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active" aria-current="page"><strong>Contact</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div id="businessErrorBlock" class="help-block small text-muted text-right<?php echo$config['business']!=''?' hidden':'';?>">Enter a Business Name, otherwise some functions such as Messages, and Bookings will NOT function correctly.</div>
        <div id="businessHasError" class="form-group row<?php echo($config['business']==''?' has-error':'');?>">
          <label for="business" class="col-form-label col-sm-2">Business</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="business" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="business" class="form-control textinput" value="<?php echo$config['business'];?>" data-dbid="1" data-dbt="config" data-dbc="business" placeholder="Enter a Business...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="abn" class="col-form-label col-sm-2">ABN</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="abn" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="abn" class="form-control textinput" value="<?php echo$config['abn'];?>" data-dbid="1" data-dbt="config" data-dbc="abn" placeholder="Enter an ABN...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveabn" class="btn btn-secondary save" data-dbid="abn" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div id="emailErrorBlock" class="help-block small text-muted text-right<?php echo$config['email']!=''?' hidden':'';?>">Enter an Email, otherwise some functions such as Messages, and Bookings will NOT function correctly.</div>
        <div id="emailHasError" class="form-group row<?php echo$config['email']==''?' has-error':'';?>">
          <label for="email" class="col-form-label col-sm-2">Email</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="email" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="Enter an Email...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-form-label col-sm-2">Phone</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="phone" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="phone" class="form-control textinput" value="<?php echo$config['phone'];?>" data-dbid="1" data-dbt="config" data-dbc="phone" placeholder="Enter a Phone Number...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savephone" class="btn btn-secondary save" data-dbid="phone" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mobile" class="col-form-label col-sm-2">Mobile</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="mobile" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="mobile" class="form-control textinput" value="<?php echo$config['mobile'];?>" data-dbid="1" data-dbt="config" data-dbc="mobile" placeholder="Enter a Mobile Number...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savemobile" class="btn btn-secondary save" data-dbid="mobile" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-form-label col-sm-2">Address</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="address" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="address" class="form-control textinput" value="<?php echo$config['address'];?>" data-dbid="1" data-dbt="config" data-dbc="address" placeholder="Enter an Address...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveaddress" class="btn btn-secondary save" data-dbid="address" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="suburb" class="col-form-label col-sm-2">Suburb</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="suburb" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="suburb" class="form-control textinput" value="<?php echo$config['suburb'];?>" data-dbid="1" data-dbt="config" data-dbc="suburb" placeholder="Enter a Suburb...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savesuburb" class="btn btn-secondary save" data-dbid="suburb" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="city" class="col-form-label col-sm-2">City</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="city" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="city" class="form-control textinput" value="<?php echo$config['city'];?>" data-dbid="1" data-dbt="config" data-dbc="city" placeholder="Enter a City...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savecity" class="btn btn-secondary save" data-dbid="city" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="state" class="col-form-label col-sm-2">State</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="state" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="state" class="form-control textinput" value="<?php echo$config['state'];?>" data-dbid="1" data-dbt="config" data-dbc="state" placeholder="Enter a State...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savestate" class="btn btn-secondary save" data-dbid="state" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="postcode" class="col-form-label col-sm-2">Postcode</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="postcode" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="postcode" class="form-control textinput" value="<?php echo$config['postcode']!=0?$config['postcode']:'';?>" data-dbid="1" data-dbt="config" data-dbc="postcode" placeholder="Enter a Postcode...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savepostcode" class="btn btn-secondary save" data-dbid="postcode" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="country" class="col-form-label col-sm-2">Country</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="country" data-tooltip="tooltip" data-placement="top" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="country" class="form-control textinput" value="<?php echo$config['country'];?>" data-dbid="1" data-dbt="config" data-dbc="country" placeholder="Enter a Country...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savecountry" class="btn btn-secondary save" data-dbid="country" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
