<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Bookings Settings
 *
 * set_bookings.php version 2.0.1
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Settings - Bookings
 * @package    core/layout/set_bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.1
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 */?>
<main id="content" class="main position-relative">
    <ol class="breadcrumb shadow">
      <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>">Bookings</a></li>
      <li class="breadcrumb-item active" aria-current="page">Settings</li>
      <li class="breadcrumb-menu">
        <div class="btn-group" role="group" aria-label="Settings">
          <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
<?php if($help['bookings_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['bookings_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['bookings_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['bookings_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
        </div>
      </li>
    </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h4>Email Layout</h4>
        <div class="form-group row">
          <label for="bookingEmailReadNotification" class="col-form-label col-sm-2">Read Reciept</label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="bookingEmailReadNotification" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="bookingEmailReadNotification" data-dbb="0"<?php echo$config['bookingEmailReadNotification']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
            <div class="help-block small text-muted align-middle pl-2">This is the Email that is sent when a Bookings Details are Changed or Confirmed.</div>
          </div>
        </div>
        <div class="help-block text-right"><small class="text-muted">Tokens:</small> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{business}');return false;">{business}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{name}');return false;">{name}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{first}');return false;">{first}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{last}');return false;">{last}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingEmailSubject','{date}');return false;">{date}</a></div>
        <div class="form-group row">
          <label for="bookingEmailSubject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bookingEmailSubject" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bookingEmailSubject" class="form-control textinput" value="<?php echo$config['bookingEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingEmailSubject">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savebookingEmailSubject" class="btn btn-secondary save" data-dbid="bookingEmailSubject" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bookingEmailLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="input-group card-header col-sm-10 p-0">
<?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="bel" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button><div id="bel" data-dbid="1" data-dbt="config" data-dbc="bookingEmailLayout"></div>':'';?>
            <div class="col text-right"><small class="text-muted">Tokens:</small> <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{business}');return false;">{business}</a> <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{name}');return false;">{name}</a> <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{first}');return false;">{first}</a> <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{last}');return false;">{last}</a> <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{date}');return false;">{date}</a> <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{booking_date}');return false;">{booking_date}</a> <a class="badge badge-secondary" href="#" onclick="$('#bookingEmailLayout').summernote('insertText','{service}');return false;">{service}</a></div>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="bookingEmailLayout">
              <textarea id="bookingEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['bookingEmailLayout']);?></textarea>
            </form>
          </div>
        </div>
        <hr/>
        <h4>AutoReply Email Layout</h4>
        <div class="help-block small text-muted text-right">This is the Email that is sent to the person making the Booking when a Booking is created.</div>
        <div class="help-block text-right"><small class="text-muted">Tokens:</small> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{business}');return false;">{business}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{name}');return false;">{name}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{first}');return false;">{first}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{last}');return false;">{last}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('bookingAutoReplySubject','{date}');return false;">{date}</a></div>
        <div class="form-group row">
          <label for="bookingAutoReplySubject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bookingAutoReplySubject">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bookingAutoReplySubject" class="form-control textinput" value="<?php echo$config['bookingAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplySubject">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savebookingAutoReplySubject" class="btn btn-secondary save" data-dbid="bookingAutoReplySubject" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">Select a File such as a PDF or DOC to send to client's when they create a Booking.</div>
        <div class="form-group row">
          <label for="bookingAttachment" class="col-form-label col-sm-2">File Attachment</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bookingAttachment" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bookingAttachment" class="form-control" name="feature_image" value="<?php echo$config['bookingAttachment'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingsAttachment" readonly>
            <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('1','config','bookingAttachment');" data-tooltip="tooltip" title="Open Media Manager"><?php svg('libre-gui-browse-media');?></button></div>
            <div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate('1','config','bookingAttachment','');" data-tooltip"tooltip" title="Delete"><?php svg('libre-gui-trash');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="bookingAutoReplyLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="input-group card-header col-sm-10 p-0">
<?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="barl" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button> <div id="barl" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplyLayout"></div>':'';?>
            <div class="col text-right"><small class="text-muted">Tokens:</small> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{business}');return false;">{business}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{name}');return false;">{name}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{first}');return false;">{first}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{last}');return false;">{last}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{date}');return false;">{date}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{booking_date}');return false;">{booking_date}</a> <a class="badge badge-secondary" href="#" onclick="$('#orderEmailLayout').summernote('insertText','{service}');return false;">{service}</a></div>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="bookingAutoReplyLayout">
              <textarea id="orderEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['bookingAutoReplyLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
