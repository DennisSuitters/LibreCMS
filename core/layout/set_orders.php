<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Orders Settings
 *
 * set_orders.php version 2.0.2
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
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Added ability to create Postage Options with Price
 * @changes    v2.0.1 Change Back Link to Referer
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/orders';?>"><?php echo localize('Orders');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Settings');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Back');?>" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <?php if($help['orders_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['orders_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['orders_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['orders_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <legend><?php echo localize('Postage Options');?></legend>
        <form target="sp" method="post" action="core/add_postoption.php" role="form">
          <div class="form-group row">
            <div class="input-group col">
              <label for="t" class="input-group-text"><?php echo localize('Service');?></label>
              <input type="text" id="t" class="form-control" name="t" value="" placeholder="<?php echo localize('Enter an ').' '.localize('Option');?>..." role="textbox">
              <label for="v" class="input-group-text"><?php echo localize('Cost');?></label>
              <input type="text" id="v" class="form-control" name="v" value="" placeholder="<?php echo localize('Enter ').' '.localize('Cost');?>..." role="textbox">
              <div class="input-group-append"><button class="btn btn-secondary add" data-tooltip="tooltip" title="<?php echo localize('Add');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button></div>
            </div>
          </div>
        </form>
        <div id="postoption">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='postoption' AND uid=0 ORDER BY title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group row">
            <div class="input-group col">
              <label for="t<?php echo$rs['id'];?>" class="input-group-text"><?php echo localize('Service');?></label>
              <input type="text" id="t<?php echo$rs['id'];?>" class="form-control" name="service" value="<?php echo$rs['title'];?>" readonly role="textbox">
              <label for="v<?php echo$rs['id'];?>" class="input-group-text"><?php echo localize('Cost');?></label>
              <input type="text" id="v<?php echo$rs['id'];?>" class="form-control" name="cost" value="<?php echo$rs['value']!=0?$rs['value']:'';?>" readonly role="textbox">
              <div class="input-group-append">
                <form target="sp" action="core/purge.php" role="form">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr>
        <legend><?php echo localize('Banking');?></legend>
        <div class="form-group row">
          <label for="bank" class="col-form-label col-sm-2"><?php echo localize('Bank');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bank" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bank" class="form-control textinput" value="<?php echo$config['bank'];?>" data-dbid="1" data-dbt="config" data-dbc="bank" placeholder="<?php echo localize('Enter ').' '.localize('Bank');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savebank" class="btn btn-secondary save" data-dbid="bank" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bankAccountName" class="col-form-label col-sm-2"><?php echo localize('Account Name');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankAccountName" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankAccountName" class="form-control textinput" value="<?php echo$config['bankAccountName'];?>"data-dbid="1" data-dbt="config" data-dbc="bankAccountName" placeholder="<?php echo localize('Enter an ').' '.localize('Account Name');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savebankAccountName" class="btn btn-secondary save" data-dbid="bankAccountName" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bankAccountNumber" class="col-form-label col-sm-2"><?php echo localize('Account Number');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankAccountNumber" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankAccountNumber" class="form-control textinput" value="<?php echo$config['bankAccountNumber'];?>" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" placeholder="<?php echo localize('Enter an ').' '.localize('Account Number');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savebankAccountNumber" class="btn btn-secondary save" data-dbid="bankAccountNumber" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bankBSB" class="col-form-label col-sm-2"><?php echo localize('BSB');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankBSB" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankBSB" class="form-control textinput" value="<?php echo$config['bankBSB'];?>" data-dbid="1" data-dbt="config" data-dbc="bankBSB" placeholder="<?php echo localize('Enter a ').' '.localize('BSB');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savebankBSB" class="btn btn-secondary save" data-dbid="bankBSB" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <hr/>
        <legend><?php echo localize('PayPal');?></legend>
        <div class="form-group row">
          <label for="bankPayPal" class="col-form-label col-sm-2"><?php echo localize('Account');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bankPayPal" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bankPayPal" class="form-control textinput" value="<?php echo$config['bankPayPal'];?>" data-dbid="1" data-dbt="config" data-dbc="bankPayPal" placeholder="<?php echo localize('Enter a ').' '.localize('PayPal').' '.localize('Account');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savebankPayPal" class="btn btn-secondary save" data-dbid="bankPayPal" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="ipn" class="col-form-label col-sm-2"><?php echo localize('IPN');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="ipn" class="form-control" value="<?php echo localize('Not Yet Implemented');?>" readonly data-tooltip="tooltip" title="" role="textbox">
          </div>
        </div>
        <hr/>
        <legend><?php echo localize('Order Processing');?></legend>
        <div class="form-group row">
          <label for="orderPayti" class="col-form-label col-sm-2"><?php echo localize('Allow');?></label>
          <div class="input-group col-sm-10">
            <select id="orderPayti" class="form-control" onchange="update('1','config','orderPayti',$(this).val());" data-dbid="1" data-dbt="config" data-dbc="orderPayti" role="listbox">
              <option value="0"<?php echo$config['orderPayti']==0?' selected':'';?>><?php echo localize('0 Days');?></option>
              <option value="604800"<?php echo$config['orderPayti']==604800?' selected':'';?>><?php echo localize('7 Days');?></option>
              <option value="1209600"<?php echo$config['orderPayti']==1209600?' selected':'';?>><?php echo localize('14 Days');?></option>
              <option value="1814400"<?php echo$config['orderPayti']==1814400?' selected':'';?>><?php echo localize('21 Days');?></option>
              <option value="2592000"<?php echo$config['orderPayti']==2592000?' selected':'';?>><?php echo localize('30 Days');?></option>
            </select>
            <div class="input-group-text"><?php echo localize('for Payments');?></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="orderEmailNotes" class="col-form-label col-sm-2"><?php echo localize('Order Notes');?></label>
          <div class="input-group card-header col-sm-10 p-0">
            <?php echo($user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="oen" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button><div id="oen" data-dbid="1" data-dbt="config" data-dbc="orderEmailNotes"></div>':'');?>
            <div class="col text-right"><small><?php echo localize('Tokens');?>:</small> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{<?php echo localize('name');?>}');return false;">{<?php echo localize('name');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{<?php echo localize('first');?>}');return false;">{<?php echo localize('first');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{<?php echo localize('last');?>}');return false;">{<?php echo localize('last');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{<?php echo localize('date');?>}');return false;">{<?php echo localize('date');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailNotes').summernote('insertText','{<?php echo localize('order_number');?>}');return false;">{<?php echo localize('order_number');?>}</a>
            </div>
            <form method="post" target="sp" action="core/update.php" role="form">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="orderEmailNotes">
              <textarea id="orderEmailNotes" class="form-control summernote" name="da" role="textbox"><?php echo rawurldecode($config['orderEmailNotes']);?></textarea>
            </form>
          </div>
        </div>
        <hr/>
        <legend><?php echo localize('Email Layout');?></legend>
        <div class="form-group row">
          <label for="orderEmailReadNotification" class="col-form-label col-sm-2"><?php echo localize('Read Reciept');?></label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="orderEmailReadNotification" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="orderEmailReadNotification" data-dbb="0" role="checkbox"<?php echo$config['orderEmailReadNotification']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
          </div>
        </div>
        <div class="col-12 text-right"><smal><?php echo localize('Tokens');?>:</small> 
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{<?php echo localize('name');?>}');return false;">{<?php echo localize('name');?>}</a> 
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{<?php echo localize('first');?>}');return false;">{<?php echo localize('first');?>}</a> 
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{<?php echo localize('last');?>}');return false;">{<?php echo localize('last');?>}</a> 
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{<?php echo localize('date');?>}');return false;">{<?php echo localize('date');?>}</a> 
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('orderEmailSubject','{<?php echo localize('order_number');?>}');return false;">{<?php echo localize('order_number');?>}</a>
        </div>
        <div class="form-group row">
          <label for="orderEmailSubject" class="col-form-label col-sm-2"><?php echo localize('Subject');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="orderEmailSubject" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="orderEmailSubject" class="form-control textinput" value="<?php echo$config['orderEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="orderEmailSubject" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveorderEmailSubject" class="btn btn-secondary save" data-dbid="orderEmailSubject" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="orderEmailLayout" class="col-form-label col-sm-2"><?php echo localize('Layout');?></label>
          <div class="input-group card-header col-sm-10 p-0">
            <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="oel" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button><div id="oel" data-dbid="1" data-dbt="config" data-dbc="orderEmailLayout"></div>':'';?>
            <div class="col text-right"><small><?php echo localize('Tokens');?>:</small> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{<?php echo localize('name');?>}');return false;">{<?php echo localize('name');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{<?php echo localize('first');?>}');return false;">{<?php echo localize('first');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{<?php echo localize('last');?>}');return false;">{<?php echo localize('last');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{<?php echo localize('date');?>}');return false;">{<?php echo localize('date');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{<?php echo localize('order_number');?>}');return false;">{<?php echo localize('order_number');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{<?php echo localize('notes');?>}');return false;">{<?php echo localize('notes');?>}</a>
            </div>
            <form method="post" target="sp" action="core/update.php" role="form">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="orderEmailLayout">
              <textarea id="orderEmailLayout" class="form-control summernote" name="da" role="textbox"><?php echo rawurldecode($config['orderEmailLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
