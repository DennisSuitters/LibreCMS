<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Bookings Settings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#bookings-settings"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <h4 class="page-header">Email Layout</h4>
    <div class="form-group clearfix">
      <label for="bookingEmailSubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="bookingEmailSubject"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="bookingEmailSubject" class="form-control textinput" value="<?php echo$config['bookingEmailSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingEmailSubject">
      </div>
      <small class="help-block text-right">Tokens: {business} {name} {first} {last} {date}</small>
    </div>
    <div class="form-group clearfix">
      <label for="bookingEmailLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="bel"><?php svg('fingerprint');?></button>
        </div>
        <div id="bel" data-dbid="1" data-dbt="config" data-dbc="bookingEmailLayout"></div>
<?php }?>
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="t" value="config">
          <input type="hidden" name="c" value="bookingEmailLayout">
          <textarea id="bookingEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['bookingEmailLayout']);?></textarea>
        </form>
      </div>
      <small class="help-block text-right">Tokens: {business} {name} {first} {last} {date} {booking_date} {service}</small>
    </div>
    <h4 class="page-header">AutoReply Email Layout</h4>
    <div class="form-group clearfix">
      <label for="bookingAutoReplySubject" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="bookingAutoReplySubject"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="bookingAutoReplySubject" class="form-control textinput" value="<?php echo$config['bookingAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplySubject">
      </div>
      <small class="help-block text-right">Tokens: {business} {name} {first} {last} {date}</small>
    </div>
    <div class="form-group clearfix">
      <label for="bookingAutoReplyLayout" class="control-label col-xs-5 col-sm-3 col-lg-2">Layout</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="barl"><?php svg('fingerprint');?></button>
        </div>
        <div id="barl" data-dbid="1" data-dbt="config" data-dbc="bookingAutoReplyLayout"></div>
<?php }?>
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="t" value="config">
          <input type="hidden" name="c" value="bookingAutoReplyLayout">
          <textarea id="orderEmailLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['bookingAutoReplyLayout']);?></textarea>
        </form>
      </div>
      <small class="help-block text-right">Tokens: {business} {name} {first} {last} {date} {booking_date} {service}</small>
    </div>
  </div>
</div>
