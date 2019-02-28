<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Content Settings
 *
 * set_content.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Settings - Content
 * @package    core/layout/set_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Content</li>
    <li class="breadcrumb-item active"><strong>Settings</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal info" href="<?php echo URL.$settings['system']['admin'].'/content';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
<?php if($help['content_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['content_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['content_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['content_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card col-sm-12">
      <div class="card-body">
        <div class="form-group row">
          <label for="showItems" class="col-form-label col-sm-2">Item Count</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="showItems">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="showItems" class="form-control textinput" value="<?php echo$config['showItems'];?>" data-dbid="1" data-dbt="config" data-dbc="showItems" placeholder="Enter Number of Items to Display..." data-tooltip="tooltip" title="Number of Items to Display.">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveshowItems" class="btn btn-secondary save" data-dbid="showItems" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
