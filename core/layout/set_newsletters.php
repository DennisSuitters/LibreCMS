<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Newsletters Settings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#newsletters-settings" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label for="newslettersEmbedImages" class="control-label check col-xs-5 col-sm-3 col-lg-2">Embed Images</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <div class="checkbox checkbox-success">
          <input type="checkbox" id="newslettersEmbedImages" data-dbid="1" data-dbt="config" data-dbc="newslettersEmbedImages" data-dbb="0"<?php echo($config['newslettersEmbedImages']{0}==1?' checked':'');?>>
          <label for="newslettersEmbedImages" data-toggle="tooltip" title="Embed Images in Emails."/>
        </div>
        <small class="help-block text-right">Enable if your hosting doesn't support remote image access.</small>
      </div>
    </div>
    <div class="form-group">
      <label for="newslettersSendMax" class="control-label col-xs-5 col-sm-3 col-lg-2">Send Max</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="newslettersSendMax">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="newslettersSendMax" class="form-control textinput" value="<?php echo$config['newslettersSendMax'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendMax">
      </div>
      <small class="help-block text-right">Maximum Emails to Send in one Instance. '0' uses the Default of '50'.</small>
    </div>
    <div class="form-group">
      <label for="newslettersSendDelay" class="control-label col-xs-5 col-sm-3 col-lg-2">Send Delay</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="newslettersSendDelay">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="newslettersSendDelay" class="form-control textinput" value="<?php echo$config['newslettersSendDelay'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendDelay">
      </div>
      <small class="help-block text-right">Seconds to Delay between Sends. '0' uses the Default of '1' second.</small>
    </div>
    <h4 class="page-header">Opt Out Message Layout</h4>
    <div class="form-group clearfix">
      <div class="col-xs-5 col-sm-3 col-lg-2"></div>
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs" style="background-color:#f5f5f5;border:1px solid #ccc;border-bottom:0;"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="nool">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div><div id="nool" data-dbid="1" data-dbt="config" data-dbc="newslettersOptOutLayout"></div>':'');?>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="1">
          <input type="hidden" name="t" value="config">
          <input type="hidden" name="c" value="newslettersOptOutLayout">
          <textarea class="form-control summernote" name="da"><?php echo rawurldecode($config['newslettersOptOutLayout']);?></textarea>
          <small class="help-block text-right">You can use the following tokens: {optOutLink}</small>
        </form>
      </div>
    </div>
  </div>
</div>
