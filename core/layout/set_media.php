<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Media Settings
 *
 * set_media.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Settings - Media
 * @package    core/layout/set_media.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php echo localize('Content');?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/media';?>"><?php echo localize('Media');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Settings');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Back');?>" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <?php if($help['media_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['media_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['media_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['media_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <h4 class="page-header"><?php echo localize('Image Processing');?></h4>
        <div class="form-group row">
          <label for="options2" class="col-form-label col-8 col-sm-2"><?php echo localize('Image Resizing');?></label>
          <div class="input-group col-4 col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options2" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="2" role="checkbox"<?php echo$config['options']{2}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
          </div>
        </div>
        <div class="help-block small text-right"><?php echo localize('help_imageresize');?></div>
        <div class="form-group row">
          <label for="mediaMaxWidth" class="control-label col-sm-2"><?php echo localize('Max Width');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="mediaMaxWidth" class="form-control textinput" value="<?php echo$config['mediaMaxWidth'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidth" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savemediaMaxWidth" class="btn btn-secondary save" data-dbid="mediaMaxWidth" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mediaMaxHeight" class="col-form-label col-sm-2"><?php echo localize('Max Height');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="mediaMaxHeight" class="form-control textinput" value="<?php echo$config['mediaMaxHeight'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeight" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savemediaMaxHeight" class="btn btn-secondary save" data-dbid="mediaMaxHeight" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mediaMaxWidthThumb" class="col-form-label col-sm-2"><?php echo localize('Max Thumb Width');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="mediaMaxWidthThumb" class="form-control textinput" value="<?php echo$config['mediaMaxWidthThumb'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaMaxWidthThumb" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savemediaMaxWidthThumb" class="btn btn-secondary save" data-dbid="mediaMaxWidthThumb" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mediaMaxHeightThumb" class="col-form-label col-sm-2"><?php echo localize('Max Thumb Height');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="mediaMaxHeightThumb" class="form-control textinput" value="<?php echo$config['mediaMaxHeightThumb'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaMaxHeightThumb" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savemediaMaxHeightThumb" class="btn btn-secondary save" data-dbid="mediaMaxHeightThumb" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="mediaQuality" class="col-form-label col-sm-2"><?php echo localize('Image Quality');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="mediaQuality" class="form-control textinput" value="<?php echo$config['mediaQuality'];?>" data-dbid="1" data-dbt="config" data-dbc="mediaQuality" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savemediaQuality" class="btn btn-secondary save" data-dbid="mediaQuality" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
