<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Newsletters Settings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#newsletters-settings"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label for="newslettersEmbedImages" class="control-label check col-xs-5 col-sm-3 col-lg-2">Embed Images</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <div class="checkbox checkbox-success">
          <input type="checkbox" id="newslettersEmbedImages" data-dbid="1" data-dbt="config" data-dbc="newslettersEmbedImages" data-dbb="0"<?php if($config['newslettersEmbedImages']{0}==1)echo' checked';?>>
          <label for="newslettersEmbedImages"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Embed Images in Emails."';?>/>
        </div>
        <small class="help-block text-right">Enable if your hosting doesn't support remote image access.</small>
      </div>
    </div>
    <div class="form-group">
      <label for="newslettersSendMax" class="control-label col-xs-5 col-sm-3 col-lg-2">Send Max</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="newslettersSendMax"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="newslettersSendMax" class="form-control textinput" value="<?php echo$config['newslettersSendMax'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendMax">
      </div>
      <small class="help-block text-right">Maximum Emails to Send in one Instance. '0' uses the Default of '50'.</small>
    </div>
    <div class="form-group">
      <label for="newslettersSendDelay" class="control-label col-xs-5 col-sm-3 col-lg-2">Send Delay</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="newslettersSendDelay"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="newslettersSendDelay" class="form-control textinput" value="<?php echo$config['newslettersSendDelay'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendDelay">
      </div>
      <small class="help-block text-right">Seconds to Delay between Sends. '0' uses the Default of '1' second.</small>
    </div>
    <h4 class="page-header">Opt Out Message Layout</h4>
    <div class="form-group clearfix">
      <div class="col-xs-5 col-sm-3 col-lg-2"></div>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="nool"><?php svg('fingerprint');?></button>
        </div>
        <div id="nool" data-dbid="1" data-dbt="config" data-dbc="newslettersOptOutLayout"></div>
<?php }?>
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="t" value="config">
          <input type="hidden" name="c" value="newslettersOptOutLayout">
          <textarea class="form-control summernote" name="da"><?php echo rawurldecode($config['newslettersOptOutLayout']);?></textarea>
        </form>
      </div>
      <small class="help-block text-right">You can use the following tokens: {optOutLink}</small>
    </div>
  </div>
</div>
