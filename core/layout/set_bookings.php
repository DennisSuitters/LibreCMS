<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Bookings</li>
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
        <?php if($help['bookings_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['bookings_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['bookings_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['bookings_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card col-sm-12">
      <div class="card-body">
        <h4>Email Layout</h4>
        <div class="help-block small text-muted text-right">This is the Email that is sent when a Bookings Details are Changed or Confirmed.</div>
        <div class="form-group row">
          <label for="bookingEmailReadNotification" class="col-form-label col-sm-2">Read Reciept</label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="bookingEmailReadNotification" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="bookingEmailReadNotification" data-dbb="0"<?php echo$config['bookingEmailReadNotification']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
        </div>
        <div class="help-block small text-muted text-right">Tokens: {business} {name} {first} {last} {date}</div>
        <div class="form-group row">
          <label for="bookingEmailSubject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bookingEmailSubject">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bookingEmailSubject" class="form-control textinput" value="<?php echo$config['bookingEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingEmailSubject">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savebookingEmailSubject" class="btn btn-secondary save" data-dbid="bookingEmailSubject" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">Tokens: {business} {name} {first} {last} {date} {booking_date} {service}</div>
        <div class="form-group row">
          <label for="bookingEmailLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="card-header col-sm-10" style="padding:0;">
            <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="bel">'.svg2('libre-gui-fingerprint').'</button>':'';?>
            <div id="bel" data-dbid="1" data-dbt="config" data-dbc="bookingEmailLayout"></div>
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
        <div class="help-block small text-muted text-right">Tokens: {business} {name} {first} {last} {date}</div>
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
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="bookingAttachment">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="bookingAttachment" class="form-control" name="feature_image" value="<?php echo$config['bookingAttachment'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingsAttachment" readonly>
            <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('1','config','bookingAttachment');"><?php svg('libre-gui-browse-media');?></button></div>
            <div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate('1','config','bookingAttachment','');"><?php svg('libre-gui-trash');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">Tokens: {business} {name} {first} {last} {date} {booking_date} {service}</div>
        <div class="form-group row">
          <label for="bookingAutoReplyLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="card-header col-sm-10" style="padding:0;">
            <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="barl">'.svg2('libre-gui-fingerprint').'</button>':'';?>
            <div id="barl" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplyLayout"></div>
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
