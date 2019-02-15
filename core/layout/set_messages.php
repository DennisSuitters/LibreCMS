<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Messages</li>
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
              <div class="input-group-append"><button class="btn btn-secondary add" type="submit"><?php svg('libre-gui-plus');?></button></div>
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
                  <button class="btn btn-secondary trash"><?php svg('libre-gui-trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr/>
        <legend>AutoReply Email Layout</legend>
        <div class="help-block small text-muted text-right">Tokens: {business} {date}</div>
        <div class="form-group row">
          <label for="contactAutoReplySubject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-toggle="popover" data-dbgid="contactAutoReplySubject">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="contactAutoReplySubject" class="form-control textinput" value="<?php echo$config['contactAutoReplySubject'];?>" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplySubject">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savecontactAutoReplySubject" class="btn btn-secondary save" data-dbid="contactAutoReplySubject" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">Tokens: {business} {date} {name} {subject}</div>
        <div class="form-group row">
          <label for="contactAutoReplyLayout" class="col-form-label col-sm-2">Layout</label>
          <div class="input-group card-header col-sm-10" style="padding:0;">
            <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-tooltip="popover" data-dbgid="carl">'.svg2('libre-gui-fingerprint').'</button><div id="carl" data-dbid="1" data-dbt="config" data-dbc="contactAutoReplyLayout"></div>':'';?>
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
