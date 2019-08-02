<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Messages Settings
 *
 * set_messages.php version 2.0.4
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
 * @version    2.0.4
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 * @changes    v2.0.3 Add Options for Webmail.
 * @changes    v2.0.4 Move Delete Messages option to Users rather than Config.
 * @changes    v2.0.5 Fix Subject display when adding Subjects.
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
        <form target="sp" method="post" action="core/add_data.php">
          <input type="hidden" name="act" value="add_subject">
          <div class="form-group row">
            <div class="input-group">
              <label for="sub" class="input-group-text"><?php echo localize('Subject');?></label>
              <input type="text" id="sub" class="form-control" name="sub" value="" placeholder="<?php echo localize('Enter a ').localize('Subject');?>...">
              <label for="eml" class="input-group-text"><?php echo localize('Email');?></label>
              <input type="text" id="eml" class="form-control" name="eml" value="" placeholder="<?php echo localize('Enter an ').localize('Email');?>...">
              <div class="input-group-append"><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="<?php echo localize('Add');?>" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button></div>
            </div>
          </div>
        </form>
        <div id="subjects">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='subject' ORDER BY title ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group row">
            <div class="input-group">
              <div class="input-group-text"><?php echo localize('Subject');?></div>
              <input type="text" id="sub<?php echo$r['id'];?>" class="form-control" value="<?php echo$rs['title'];?>" onchange="update('<?php echo$rs['id'];?>','subject','title',$(this).val());">
              <div class="input-group-text"><?php echo localize('Email');?></div>
              <input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','subject','url',$(this).val());">
              <div class="input-group-append">
                <form target="sp" action="core/purge.php">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr>
        <legend><?php echo localize('Webmail');?></legend>
        <div class="form-group row">
          <div class="input-group">
            <label for="message_check_interval" class="input-group-text"><?php echo localize('Check for new Messages every');?></label>
            <select id="message_check_interval" class="form-control" onchange="update('1','config','message_check_interval',$(this).val());">
              <option value="0"<?php echo$config['message_check_interval']==0?' selected="selected"':'';?>><?php echo localize('Disable Checking');?></option>
              <option value="1"<?php echo$config['message_check_interval']==1?' selected="selected"':'';?>><?php echo localize('Every time Messages is opened');?></option>
              <option value="300"<?php echo$config['message_check_interval']==300?' selected="selected"':'';?>><?php echo localize('5 Minutes');?></option>
              <option value="600"<?php echo$config['message_check_interval']==600?' selected="selected"':'';?>><?php echo localize('10 Minutes');?></option>
              <option value="900"<?php echo$config['message_check_interval']==900?' selected="selected"':'';?>><?php echo localize('15 Minutes');?></option>
              <option value="1800"<?php echo$config['message_check_interval']==1800?' selected="selected"':'';?>><?php echo localize('30 Minutes');?></option>
              <option value="3600"<?php echo$config['message_check_interval']==3600?' selected="selected"':'';?>><?php echo localize('1 Hour');?></option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="options9" class="col-form-label col-sm-3"><?php echo localize('Delete Messages When Retrieved');?></label>
          <div class="input-group col-sm-3">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options10" class="switch-input" data-dbid="1" data-dbt="user" data-dbc="options" data-dbb="9" role="checkbox"<?php echo$user['options']{9}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
          </div>
        </div>
        <h4><?php echo localize('Mailboxes');?></h4>
        <form target="sp" method="post" action="core/add_mailbox.php" role="form">
          <input type="hidden" name="uid" value="<?php echo$user['id'];?>">
          <div class="form-group row">
            <div class="input-group">
              <label for="type" class="input-group-text"><?php echo localize('Type');?></label>
              <select id="type" class="form-control" name="t" onchange="changePort($(this).val());">
                <option value="imap">IMAP</option>
                <option value="pop3">POP3</option>
              </select>
              <label for="port" class="input-group-text"><?php echo localize('Port');?></label>
              <input type="text" id="port" class="form-control" name="port" value="143" role="textbox">
              <label for="flag" class="input-group-text"><?php echo localize('Flag');?></label>
              <select id="flag" class="form-control" name="f">
                <option value="novalidate-cert">novalidate-cert</option>
                <option value="validate-cert">validate-cert</option>
                <option value="norsh">norsh</option>
                <option value="ssl">ssl</option>
                <option value="notls">notls</option>
                <option value="tls">tls</option>
              </select>
            </div>
            <div class="input-group">
              <label for="url" class="input-group-text"><?php echo localize('Server');?></label>
              <input type="text" id="url" class="form-control" name="url" value="" placeholder="<?php echo localize('Enter a ').localize('Server');?>" role="textbox">
              <label for="mailusr" class="input-group-text"><?php echo localize('Username');?></label>
              <input type="text" id="mailusr" class="form-control" name="mailusr" value="" placeholder="<?php echo localize('Enter a ').localize('Username');?>..." role="textbox">
              <label for="mailpwd" class="input-group-text"><?php echo localize('Password');?></label>
              <input type="text" id="mailpwd" class="form-control" name="mailpwd" value="" placeholder="<?php echo localize('Enter a ').localize('Password');?>" role="textbox">
              <div class="input-group-append"><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="<?php echo localize('Add');?>" role="textbox" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button></div>
            </div>
          </div>
        </form>
        <script>
          function changePort(v){
            if(v=='pop3'){
              $('#port').val('110');
            }else{
              $('#port').val('143');
            }
          }
        </script>
        <hr>
        <div id="mailboxes">
<?php $sm=$db->prepare("SELECT * FROM choices WHERE contentType='mailbox' AND uid=:uid ORDER BY url");
$sm->execute([':uid'=>$user['id']]);
while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rm['id'];?>" class="form-group row">
            <div class="input-group">
              <label for="type<?php echo$rm['id'];?>" class="input-group-text"><?php echo localize('Type');?></label>
              <select id="type<?php echo$rm['id'];?>" class="form-control" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`type`,$(this).val());">
                <option value="imap"<?php echo$rm['type']=='imap'?' selected="selected"':'';?>>IMAP</option>
                <option value="pop3"<?php echo$rm['type']=='pop3'?' selected="selected"':'';?>>POP3</option>
              </select>
              <label for="port<?php echo$rm['id'];?>" class="input-group-text"><?php echo localize('Port');?></label>
              <input type="text" id="port<?php echo$rm['id'];?>" class="form-control" value="<?php echo$rm['port'];?>" role="textbox" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`port`,$(this).val());">
              <label for="flag<?php echo$rm['id'];?>" class="input-group-text"><?php echo localize('Flag');?></label>
              <select id="flag" class="form-control" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`flag`,$(this).val());">
                <option value="novalidate-cert"<?php echo$rm['flag']=='novalidate-cert'?' selected="selected"':'';?>>novalidate-cert</option>
                <option value="validate-cert"<?php echo$rm['flag']=='validate-cert'?' selected="selected"':'';?>>validate-cert</option>
                <option value="norsh"<?php echo$rm['flag']=='norsh'?' selected="selected"':'';?>>norsh</option>
                <option value="ssl"<?php echo$rm['flag']=='ssl'?' selected="selected"':'';?>>ssl</option>
                <option value="notls"<?php echo$rm['flag']=='notls'?' selected="selected"':'';?>>notls</option>
                <option value="tls"<?php echo$rm['flag']=='tls'?' selected="selected"':'';?>>tls</option>
              </select>
            </div>
            <div class="input-group">
              <label for="url<?php echo$rm['id'];?>" class="input-group-text"><?php echo localize('Server');?></label>
              <input type="text" id="url<?php echo$rm['id'];?>" class="form-control" name="url" value="<?php echo$rm['url'];?>" placeholder="<?php echo localize('Enter a ').localize('Server');?>" role="textbox" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`url`,$(this).val());">
              <label for="mailusr<?php echo$rm['id'];?>" class="input-group-text"><?php echo localize('Username');?></label>
              <input type="text" id="mailusr<?php echo$rm['id'];?>" class="form-control" name="mailusr" value="<?php echo$rm['username'];?>" placeholder="<?php echo localize('Enter a ').localize('Username');?>..." role="textbox" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`username`,$(this).val());">
              <label for="mailpwd<?php echo$rm['id'];?>" class="input-group-text"><?php echo localize('Password');?></label>
              <input type="text" id="mailpwd<?php echo$rm['id'];?>" class="form-control" name="mailpwd" value="<?php echo$rm['password'];?>" placeholder="<?php echo localize('Enter a ').localize('Password');?>" role="textbox" onchange="update(`<?php echo$rm['id'];?>`,`choices`,`password`,$(this).val());">
              <div class="input-group-append">
                <form target="sp" action="core/purge.php" role="form">
                  <input type="hidden" name="id" value="<?php echo$rm['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                </form>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <hr>
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
        <hr>
        <legend><?php echo localize('Email Signature');?></legend>
        <div role="tabpanel" class="tab-pane" id="account-messages">
          <div class="form-group row">
            <label for="email_signature" class="col-form-label col-sm-2"><?php echo localize('Signature');?></label>
            <div class="col-sm-10">
              <div class="card-header p-0">
                <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="da" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button><div id="da" data-dbid="1" data-dbt="config" data-dbc="email_signature"></div>':'';?>
                <form method="post" target="sp" action="core/update.php" role="form">
                  <input type="hidden" name="id" value="1">
                  <input type="hidden" name="t" value="config">
                  <input type="hidden" name="c" value="email_signature">
                  <textarea id="email_signature" class="form-control summernote" name="da" role="textbox"><?php echo rawurldecode($config['email_signature']);?></textarea>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
