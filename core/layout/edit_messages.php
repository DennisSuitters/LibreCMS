<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2018
 *
 * Administration - Edit Messages
 *
 * edit_messages.php version 2.0.4
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Messages - Edit
 * @package    core/layout/edit_messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.4
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 * @changes    v2.0.3 Fix Iframe display of receieved content to it's height.
 * @changes    v2.0.4 Add Emailing Abilities.
 */
if($args[0]!='compose'){
  $q=$db->prepare("UPDATE `".$prefix."messages` SET status='read' WHERE id=:id");
  $q->execute([':id'=>$args[1]]);
  $q=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE id=:id");
  $q->execute([':id'=>$args[1]]);
  $r=$q->fetch(PDO::FETCH_ASSOC);
}else{
  $r=[
    'id'=>0,
    'subject'=>'',
    'to_name'=>'',
    'to_email'=>'',
    'from_name'=>'',
    'from_email'=>'',
    'attachments'=>'',
    'notes_html'=>''
  ];
}?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php echo localize('Messages');?></a></li>
    <li class="breadcrumb-item"><?php echo$args[0]=='view'?localize('View'):localize('Compose');?></li>
    <li class="breadcrumb-item active"><strong id="titleupdate"><?php echo$r['subject'];?></strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>"><?php svg('libre-gui-back');?></a>
<?php if($help['messages_edit_text']!='')echo'<a class="btn btn-ghost-normal info" href="'.$help['messages_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
if($help['messages_edit_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['messages_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
<?php $ur=$db->query("SELECT COUNT(status) AS cnt FROM `".$prefix."messages` WHERE status='unread' AND folder='INBOX'")->fetch(PDO::FETCH_ASSOC);
$sp=$db->query("SELECT COUNT(folder) AS cnt FROM `".$prefix."messages` WHERE folder='spam' AND status='unread'")->fetch(PDO::FETCH_ASSOC);?>
        <div class="email-app mb-4">
          <nav>
            <a class="btn btn-secondary btn-block" href="<?php echo URL.$settings['system']['admin'].'/messages/compose';?>">Compose</a>
            <ul id="messagemenu" class="nav">
              <li id="nav_1" class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages';?>">
                  <?php svg('libre-gui-inbox');?> Inbox
                </a>
              </li>
              <li id="nav_2" class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/unread';?>">
                  <?php svg('libre-gui-email');?> Unread
                  <span id="unreadbadge" class="badge badge-warning"><?php echo$ur['cnt']>0?$ur['cnt']:'';?></span>
                </a>
              </li>
              <li id="nav_4" class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/sent';?>">
                  <?php svg('libre-gui-email-send');?> Sent
                </a>
              </li>
              <li id="nav_6" class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/important';?>">
                  <?php svg('libre-gui-bookmark');?> Important
                </a>
              </li>
              <li id="nav_7" class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/spam';?>">
                  <?php svg('libre-gui-email-spam');?> Spam
                  <span id="spambadge" class="badge badge-warning"><?php echo$sp['cnt']>0?$sp['cnt']:'';?></span>
                </a>
              </li>
            </ul>
          </nav>
          <div class="col">
            <form target="sp" role="form" method="POST" enctype="multipart/form-data" action="core/email_message.php">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <div class="form-group row">
                <div class="col text-right">
                  <div class="btn-group">
<?php if($args[0]!='compose'){?>
                    <button type="submit" class="btn btn-secondary" name="act" value="reply">Reply</button>
                    <button type="submit" class="btn btn-secondary" name="act" value="forward">Forward</button>
<?php }else{?>
                    <button type="submit" class="btn btn-secondary" name="act" value="compose">Send</button>
<?php }?>
                  </div>
                </div>
              </div>
<?php if($args[0]!='compose'){?>
              <div class="form-group row">
                <label for="ti" class="col-form-label col-sm-2"><?php echo localize('Created');?></label>
                <div class="input-group col-sm-10">
                  <input type="text" id="ti" class="form-control" value="<?php echo isset($r['ti'])?date($config['dateFormat'],$r['ti']):date($config['dateFormat'],time());?>" readonly role="textbox">
                </div>
              </div>
<?php }?>
              <div class="form-group row">
                <label for="subject" class="col-form-label col-sm-2"><?php echo localize('Subject');?></label>
                <div class="input-group col-sm-10">
                  <input type="text" id="subject" class="form-control" name="subject" value="<?php echo$args[0]=='reply'?'Re: ':'';echo$args[0]!='compose'?$r['subject']:'';?>" placeholder="Enter a Subject" required aria-required="true" role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="to_email" class="col-form-label col-sm-2"><?php echo localize('To');?></label>
                <div class="input-group col-sm-10">
                  <input type="text" id="to_email" class="form-control" name="to_email" value="<?php echo(isset($r)&&$r['to_email']!=''?$r['to_email']:'');?>" placeholder="<?php echo localize('Enter an ').' '.localize('Email');?>..." required aria-required="true" role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="from_email" class="col-form-label col-sm-2"><?php echo localize('From');?></label>
                <div class="input-group col-sm-10">
<?php if($args[0]=='compose'){?>
                  <select id="from_email" name="from_email" class="form-control">
<?php   if($config['email']!=''){?>
                    <option value="<?php echo$config['email'];?>"><?php echo$config['business'].' &lt;'.$config['email'].'&gt;';?></option>
<?php   }?>
                    <option value="<?php echo$user['email'];?>"><?php echo$user['name'].' &lt;'.$user['email'].'&gt;';?></option>
                  </select>
<?php }else{?>
                  <input type="text" id="from_email" class="form-control" name="from_email" value="<?php echo$args[0]=='compose'?$user['email']:$r['from_email'];?>" required aria-required="true" role="textbox">
<?php }?>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-11"><?php echo localize('Attachments');?></label>
                <div class="input-group col-sm-1 p-0 mr-0">
                  <button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','messages','attachments');return false;" data-tooltip="tooltip" title="<?php echo localize('Open Media Manager');?>" role="button" aria-label="<?php echo localize('aria_file_mediamanager');?>"><?php svg('libre-gui-browse-media');?></button>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-form-label col-sm-2">&nbsp;</div>
                <div id="attachments" class="col-sm-10 card-group">
<?php if($r['attachments']!=''){
  $atts='';
  $ti=time();
  $attachments=explode(',',$r['attachments']);
  foreach($attachments as $attachment){
    $atts.=($atts!=''?',':'').$attachment;
    $attimg='core'.DS.'svg'.DS.'libre-gui-file.svg';
    if(preg_match("/\.(gif|png|jpg|jpeg|bmp|webp|svg)$/",$attachment))$attimg=$attachment;
    if(preg_match("/\.(pdf)$/",$attachment))$attimg='core'.DS.'svg'.DS.'libre-gui-file-pdf.svg';
    if(preg_match("/\.(zip|zipx|tar|gz|rar|7zip|7z|bz2)$/",$attachment))$attimg='core'.DS.'svg'.DS.'libre-gui-file-archive.svg';
    if(preg_match("/\.(doc|docx|xls)$/",$attachment))$attimg='core'.DS.'svg'.DS.'libre-gui-file-docs.svg';?>
                  <a id="a_<?php echo$ti;?>" target="_blank" class="card col-2 p-0" href="<?php echo$attachment;?>" title="<?php echo basename($attachment);?>">
                    <img class="card-img-top bg-white" src="<?php echo$attimg;?>" alt="<?php echo basename($attachment);?>">
                    <span class="card-footer text-truncate p-0 pl-1 pr-1 small">
                      <?php echo basename($attachment);?>
                    </span>
                    <span class="attbuttons">
                      <button class="btn btn-secondary btn-xs trash" onclick="attRemove('<?php echo$ti;?>');return false;"><?php svg('libre-gui-trash');?></button>
                    </span>
                  </a>
<?php }
}?>
                </div>
                <script>
                  function attRemove(id){
                    var href=$('#a_'+id).attr('href');
                    var atts=$("#atts").val();
                    $('#atts').val(atts.replace(href,''));
                    $('#a_'+id).remove();
                  }
                </script>
              </div>
              <div class="form-group row">
                <input id="atts" type="hidden" class="form-control" name="atts" value="<?php echo$r['attachments'];?>">
              </div>
              <div class="form-group row">
                <label for="bod" class="col-form-label col-sm-2"><?php echo localize('Reply');?></label>
                <div class="input-group col-sm-10">
                  <textarea id="bod" name="bod" class="form-control" role="textbox"></textarea>
                </div>
              </div>
            </form>
            <script>
              $('#bod').summernote({
                height:100,
                tabsize:2,
                lang:'en-US',
                toolbar:
                  [
          //        ['librecms',['accessibility','findnreplace','cleaner','seo']],
                    ['style',['style']],
                    ['font',['bold','italic','underline','clear']],
                    ['fontname',['fontname']],
                    ['fontsize',['fontsize']],
                    ['color',['color']],
                    ['para',['ul','ol','paragraph']],
                    ['height',['height']],
                    ['table',['table']],
                    ['insert',['videoAttributes','elfinder','link','hr']],
                    ['view',['fullscreen','codeview']],
                    ['help',['help']]
                  ],
                  callbacks:{
                    onInit:function(){
                      $('body > .note-popover').appendTo(".note-editing-area");
                    }
                  }
              });
            </script>
<?php if($args[0]!='compose'){?>
            <div class="form-group row">
              <label for="order_notes" class="col-form-label col-sm-2"><?php echo localize('Message');?></label>
              <div class="input-group col-sm-10">
                <iframe id="order_notes" src="core/viewemail.php?id=<?php echo$r['id'];?>" width="100%" frameborder="0" scrolling="no" onload="this.style.height=this.contentDocument.body.scrollHeight+'px';" style="background:#fff;color:#000;"></iframe>
              </div>
            </div>
<?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
