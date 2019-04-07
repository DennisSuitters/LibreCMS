<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Messages Settings
 *
 * set_messages.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Settings - Messages
 * @package    core/layout/set_messages.php
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
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php echo localize('Messages');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Settings');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Back');?>" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <?php if($help['messages_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['messages_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['messages_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['messages_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <div class="help-block small text-muted text-right"><?php echo localize('help_messages');?><a href="<?php echo URL.$settings['system']['admin'];?>/preferences/contact#email"><?php echo localize('Preferences');?></a>.</div>
        <form target="sp" method="post" action="core/add_data.php" role="form">
          <input type="hidden" name="act" value="add_subject">
          <div class="form-group row">
            <div class="input-group col-lg">
              <label for="sub" class="input-group-text"><?php echo localize('Subject');?></label>
              <input type="text" id="sub" class="form-control" name="sub" value="" placeholder="<?php echo localize('Enter a').' '.localize('Subject');?>..." role="textbox">
              <label for="eml" class="input-group-text"><?php echo localize('Email');?></label>
              <input type="text" id="eml" class="form-control" name="eml" value="" placeholder="<?php echo localize('Enter an').' '.localize('Email');?>..." role="textbox">
              <div class="input-group-append"><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="<?php echo localize('Add');?>" role="textbox" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button></div>
            </div>
          </div>
        </form>
        <div id="subjects">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='subject' ORDER BY title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group row">
            <div class="input-group">
              <label for="sub<?php echo$r['id'];?>" class="input-group-text"><?php echo localize('Subject');?></label>
              <input type="text" id="sub<?php echo$r['id'];?>" class="form-control" value="<?php echo$rs['title'];?>" onchange="update('<?php echo$rs['id'];?>','subject','title',$(this).val());" placeholder="<?php echo localize('Enter a').' '.localize('Subject');?>..." role="textbox">
              <label for="eml<?php echo$r['id'];?>" class="input-group-text"><?php echo localize('Email');?></label>
              <input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','subject','url',$(this).val());" placeholder="<?php echo localize('Enter an').' '.localize('Email');?>..." role="textbox">
              <div class="input-group-append">
                <form target="sp" action="core/purge.php" role="form">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr/>
        <legend><?php echo localize('AutoReply Email');?></legend>
        <div class="col-12 text-right"><small><?php echo localize('Tokens');?>:</small> 
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('contactAutoReplySubject','{<?php echo localize('business');?>}');return false;">{<?php echo localize('business');?>}</a> 
          <a class="badge badge-secondary" href="#" onclick="insertAtCaret('contactAutoReplySubject','{<?php echo localize('date');?>}');return false;">{<?php echo localize('date');?>}</a>
        </div>
        <div class="form-group row">
          <label for="contactAutoReplySubject" class="col-form-label col-sm-2"><?php echo localize('Subject');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-toggle="popover" data-dbgid="contactAutoReplySubject" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="contactAutoReplySubject" class="form-control textinput" value="<?php echo$config['contactAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplySubject" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savecontactAutoReplySubject" class="btn btn-secondary save" data-dbid="contactAutoReplySubject" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="contactAutoReplyLayout" class="col-form-label col-sm-2"><?php echo localize('Layout');?></label>
          <div class="input-group card-header col-sm-10 p-0">
            <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-toggle="popover" data-dbgid="carl" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button><div id="carl" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplyLayout"></div>':'';?>
            <div class="col text-right"><small><?php echo localize('Tokens');?>:</small> 
              <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{<?php echo localize('business');?>}');return false;">{<?php echo localize('business');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{<?php echo localize('date');?>}');return false;">{<?php echo localize('date');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{<?php echo localize('name');?>}');return false;">{<?php echo localize('name');?>}</a> 
              <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{<?php echo localize('subject');?>}');return false;">{<?php echo localize('subject');?>}</a>
            </div>
            <form method="post" target="sp" action="core/update.php" role="form">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="contactAutoReplyLayout">
              <textarea id="contactAutoReplyLayout" class="form-control summernote" name="da" role="textbox"><?php echo rawurldecode($config['contactAutoReplyLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
