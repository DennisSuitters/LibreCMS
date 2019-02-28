<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Messages Settings
 *
 * set_messages.php version 2.0.0
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
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/messages';?>">Messages</a></li>
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Setting">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/messages';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
<?php if($help['messages_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['messages_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['messages_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['messages_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="help-block small text-muted text-right">If no entries are made, an input text box will be used instead of a dropdown. If email's are left blank, the messages will be sent to the site email set in <a href="<?php echo URL.$settings['system']['admin'];?>/preferences/contact#email">Preferences</a>.</div>
        <form target="sp" method="post" action="core/add_data.php">
          <input type="hidden" name="act" value="add_subject">
          <div class="form-group row">
            <div class="input-group col-lg">
              <div class="input-group-text">Subject</div>
              <input type="text" class="form-control" name="sub" value="" placeholder="Enter a Subject...">
              <div class="input-group-text">Email</div>
              <input type="text" class="form-control" name="eml" value="" placeholder="Enter an Email...">
              <div class="input-group-append"><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="Add"><?php svg('libre-gui-plus');?></button></div>
            </div>
          </div>
        </form>
        <div id="subjects">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='subject' ORDER BY title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group row">
            <div class="input-group">
              <div class="input-group-text">Subject</div>
              <input type="text" class="form-control" value="<?php echo$rs['title'];?>" onchange="update('<?php echo$rs['id'];?>','subject','title',$(this).val());" placeholder="Enter a Subject...">
              <div class="input-group-text">Email</div>
              <input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','subject','url',$(this).val());" placeholder="Enter an Email...">
              <div class="input-group-append">
                <form target="sp" action="core/purge.php">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr/>
        <legend>AutoReply Email Layout</legend>
        <div class="col-12 text-right"><small class="text-muted">Tokens:</small> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('contactAutoReplySubject','{business}');return false;">{business}</a> <a class="badge badge-secondary" href="#" onclick="insertAtCaret('contactAutoReplySubject','{date}');return false;">{date}</a></div>
        <div class="form-group row">
          <label for="contactAutoReplySubject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-toggle="popover" data-dbgid="contactAutoReplySubject" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="contactAutoReplySubject" class="form-control textinput" value="<?php echo$config['contactAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplySubject">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savecontactAutoReplySubject" class="btn btn-secondary save" data-dbid="contactAutoReplySubject" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="contactAutoReplyLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="input-group card-header col-sm-10 p-0">
<?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-toggle="popover" data-dbgid="carl" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button><div id="carl" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplyLayout"></div>':'';?>
            <div class="col text-right"><small class="text-muted">Tokens:</small> <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{business}');return false;">{business}</a> <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{date}');return false;">{date}</a> <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{name}');return false;">{name}</a> <a class="badge badge-secondary" href="#" onclick="$('#contactAutoReplyLayout').summernote('insertText','{subject}');return false;">{subject}</a></div>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="contactAutoReplyLayout">
              <textarea id="contactAutoReplyLayout" class="form-control summernote" name="da"><?php echo rawurldecode($config['contactAutoReplyLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
