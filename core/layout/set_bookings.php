<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Bookings Settings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#bookings-settings" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <h4 class="page-header">Email Layout</h4>
    <small class="help-block text-right">This is the Email that is sent when a Bookings Details are Changed or Confirmed.</small>
    <div class="form-group">
      <label for="bookingEmailReadNotification" class="control-label col-xs-5 col-sm-3 col-lg-2">Read Reciept</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <div class="checkbox checkbox-success">
          <input type="checkbox" id="bookingEmailReadNotification" data-dbid="1" data-dbt="config" data-dbc="bookingEmailReadNotification" data-dbb="0"<?php echo($config['bookingEmailReadNotification']{0}==1?' checked':'');?>>
          <label for="bookingEmailReadNotification"/>
        </div>
      </div>
    </div>
    <div class="form-group clearfix">
      <label for="bookingEmailSubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="bookingEmailSubject">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="bookingEmailSubject" class="form-control textinput" value="<?php echo$config['bookingEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingEmailSubject">
      </div>
      <small class="help-block text-right">Tokens: {business} {name} {first} {last} {date}</small>
    </div>
    <div class="form-group clearfix">
      <label for="bookingEmailLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs" style="background-color:#f5f5f5;border:1px solid #ccc;border-bottom:0;"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="bel">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div><div id="bel" data-dbid="1" data-dbt="config" data-dbc="bookingEmailLayout"></div>':'');?>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="t" value="config">
          <input type="hidden" name="c" value="bookingEmailLayout">
          <textarea id="bookingEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['bookingEmailLayout']);?></textarea>
          <small class="help-block text-right">Tokens: {business} {name} {first} {last} {date} {booking_date} {service}</small>
        </form>
      </div>
    </div>
    <h4 class="page-header">AutoReply Email Layout</h4>
    <small class="help-block text-right">This is the Email that is sent to the person making the Booking when a Booking is created.</small>
    <div class="form-group clearfix">
      <label for="bookingAutoReplySubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="bookingAutoReplySubject">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="bookingAutoReplySubject" class="form-control textinput" value="<?php echo$config['bookingAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplySubject">
      </div>
      <small class="help-block text-right">Tokens: {business} {name} {first} {last} {date}</small>
    </div>
    <div class="form-group clearfix">
      <label for="bookingAutoReplyLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs" style="background-color:#f5f5f5;border:1px solid #ccc;border-bottom:0;"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="barl">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div><div id="barl" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplyLayout"></div>':'');?>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="t" value="config">
          <input type="hidden" name="c" value="bookingAutoReplyLayout">
          <textarea id="orderEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['bookingAutoReplyLayout']);?></textarea>
          <small class="help-block text-right">Tokens: {business} {name} {first} {last} {date} {booking_date} {service}</small>
        </form>
      </div>
    </div>
  </div>
</div>
