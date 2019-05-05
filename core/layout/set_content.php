<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Content Settings
 *
 * set_content.php version 2.0.2
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
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 * @changes    v2.0.3 Add options for adding Categories with Images.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><?php echo localize('Content');?></li>
    <li class="breadcrumb-item active"><strong><?php echo localize('Settings');?></strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="Back" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <?php if($help['content_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['content_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['content_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['content_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label for="showItems" class="col-form-label col-sm-2"><?php echo localize('Item Count');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'"><button class="btn btn-secondary fingerprint" data-dbgid="showItems" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="showItems" class="form-control textinput" value="<?php echo$config['showItems'];?>" data-dbid="1" data-dbt="config" data-dbc="showItems" placeholder="<?php echo localize('Enter ').' '.localize('Item Count');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveshowItems" class="btn btn-secondary save" data-dbid="showItems" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <legend><?php echo localize('Categories');?></legend>
        <form target="sp" method="POST" action="core/add_category.php" role="form">
          <div class="form-group row">
            <div class="input-group col">
              <label for="cat" class="input-group-text"><?php echo localize('Category');?></label>
              <input type="text" id="cat" class="form-control" name="cat" placeholder="<?php echo localize('Enter a ').' '.localize('Category');?>..." required aria-required="true" role="textbox">
              <label for="ct" class="input-group-text"><?php echo localize('Content');?></label>
              <select id="ct" class="form-control" name="ct" role="listbox">
                <option value="inventory">Inventory</option>
                <option value="services">Service</option>
                <option value="article">Article</option>
                <option value="gallery">Gallery</option>
                <option value="portfolio">Portfolio</option>
                <option value="proof">Proof</option>
                <option value="news">News</option>
                <option value="event">Event</option>
              </select>
              <div class="input-group-text"><?php echo localize('Image');?></div>
              <input type="text" id="icon" class="form-control" name="icon" value="" readonly role="textbox">
              <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('1','category','icon');return false;" data-tooltip="tooltip" title="<?php echo localize('Open Media Manager');?>" role="button" aria-label="<?php echo localize('aria_file_mediamanager');?>"><?php svg('libre-gui-browse-media');?></button></div>
              <div class="input-group-append"><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="<?php echo localize('Add');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button></div>
            </div>
          </div>
        </form>
        <div id="category">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='category' ORDER BY url ASC, title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group row">
            <div class="input-group col">
              <label for="cat<?php echo$rs['id'];?>" class="input-group-text"><?php echo localize('Category');?></label>
              <input type="text" id="cat<?php echo$rs['id'];?>" class="form-control" value="<?php echo$rs['title'];?>" readonly role="textbox">
              <label for="ct<?php echo$rs['id'];?>" class="input-group-text"><?php echo localize('Content');?></label>
              <input type="text" id="ct<?php echo$rs['id'];?>" class="form-control" value="<?php echo$rs['url'];?>" readonly role="textbox">
              <div class="input-group-text"><?php echo localize('Image');?></div>
              <div class="input-group-append img"><?php echo$rs['icon']!=''?'<a href="'.$rs['icon'].'" data-lightbox="lightbox"><img id="thumbimage" src="'.$rs['icon'].'" alt="Thumbnail"></a>':'<img id="thumbimage" src="core/images/noimage.png" alt="No Image">';?></div>
              <div class="input-group-append">
                <form target="sp" action="core/purge.php" role="form">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button"  aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr>
  
      </div>
    </div>
  </div>
</main>
