<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Media Settings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/media';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#media-settings" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <h4 class="page-header">Automatic Image Processing</h4>
    <div class="form-group">
      <label for="options2" class="control-label check col-xs-6 col-sm-4 col-lg-2" data-toggle="tooltip" title="Enable/Disable automatic image resizing when uploading images.">Enable Image Resizing</label>
      <div class="input-group col-xs-6 col-sm-8 col-lg-10">
        <div class="checkbox checkbox-success">
          <input type="checkbox" id="options2" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="2"<?php echo($config['options']{2}==1?' checked':'');?>>
          <label for="options2"/>
        </div>
      </div>
    </div>
    <div class="form-group clearfix">
      <label for="mediaMaxWidth" class="control-label col-xs-5 col-sm-3 col-lg-2">Maximum Size</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <div class="input-group-addon">Max Width</div>
        <input type="text" id="mediaMaxWidth" class="form-control textinput" value="<?php echo$config['mediaMaxWidth'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidth">
        <div class="input-group-addon">Max Height</div>
        <input type="text" id="mediaMaxHeight" class="form-control textinput" value="<?php echo$config['mediaMaxHeight'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeight">
      </div>
      <small class="help-block text-right">
        Uploaded images larger than the above size will be resized to their long edge using the entered values.<br>
        If either value is '0', resizing will be disabled.
      </small>
    </div>
    <div class="form-group clearfix">
      <label for="mediaQuality" class="control-label col-xs-5 col-sm-3 col-lg-2">Image Quality</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <input type="text" id="mediaQuality" class="form-control textinput" value="<?php echo$config['mediaQuality'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaQuality">
      </div>
    </div>
  </div>
</div>
