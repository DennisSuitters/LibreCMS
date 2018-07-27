<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Content Settings</h4>
    <div class="btn-group pull-right">
      <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/content';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
      <?php if($help['content_settings_text']!='')echo'<a target="_blank" class="btn btn-default info" href="'.$help['content_settings_text'].'" data-toggle="tooltip" data-placement="left" title="Help">'.svg2('libre-gui-help').'</a>';if($help['content_settings_video']!='')echo'<span><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['content_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help">'.svg2('libre-gui-video').'</a>';?>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label for="showItems" class="control-label col-xs-5 col-sm-3 col-lg-2">Item Count</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <?php echo$user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="showItems">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
        <input type="text" id="showItems" class="form-control textinput" value="<?php echo$config['showItems'];?>" data-dbid="1" data-dbt="config" data-dbc="showItems" placeholder="Enter Number of Items to Display..." data-toggle="tooltip" title="Number of Items to Display.">
      </div>
    </div>
  </div>
</div>
