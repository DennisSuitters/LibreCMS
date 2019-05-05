<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2018
 *
 * Administration - Edit Messages
 *
 * edit_messages.php version 2.0.3
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
 * @version    2.0.3
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 * @changes    v2.0.3 Fix Iframe display of receieved content to it's height.
 */
if($args[0]=='view'){
  $q=$db->prepare("UPDATE `".$prefix."messages` SET status='read' WHERE id=:id");
  $q->execute([':id'=>$args[1]]);
  $q=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE id=:id");
  $q->execute([':id'=>$args[1]]);
  $r=$q->fetch(PDO::FETCH_ASSOC);
}?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php echo localize('Messages');?></a></li>
    <li class="breadcrumb-item"><?php echo$args[0]=='view'?localize('View'):localize('Compose');?></li>
    <li class="breadcrumb-item active"><strong id="titleupdate"><?php echo$r['subject'];?></strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>"><?php svg('libre-gui-back');?></a>
<?php $scc=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");$scc->execute([':ip'=>$r['ip']]);
if($scc->rowCount()<1){?>
        <form id="blacklist<?php echo$r['id'];?>" target="sp" method="post" action="core/add_messageblacklist.php" style="display:inline-block;" role="form"><input type="hidden" name="id" value="<?php echo$r['id'];?>"><button class="btn btn-ghost-normal info" style="background-color:transparent;" data-tooltip="tooltip" title="<?php echo localize('Add IP to Blacklist');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php echo svg2('libre-gui-security');?></button></form>
<?php }
        if($help['messages_edit_text']!='')echo'<a class="btn btn-ghost-normal info" href="'.$help['messages_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['messages_edit_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['messages_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="alert alert-info">At this time only reading email has been built, sending, replying will be in a future version of LibreCMS (Hopefully the next).</div>
    <div class="card col-sm-12">
      <div class="card-body">
        <div class="form-group row">
          <label for="ti" class="col-form-label col-sm-2"><?php echo localize('Created');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="ti" class="form-control" value="<?php echo isset($r['ti'])?date($config['dateFormat'],$r['ti']):date($config['dateFormat'],time());?>" readonly role="textbox">
          </div>
        </div>
        <div class="form-group row<?php echo$args[0]=='compose'?' has-error':'';?>">
          <label for="subject" class="col-form-label col-sm-2"><?php echo localize('Subject');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="subject" class="form-control" name="subject" value="<?php echo$args[0]!='compose'?$r['subject']:'';?>" placeholder="Enter a Subject"<?php echo$args[0]!='compose'?' readonly':' required';?> role="textbox">
          </div>
        </div>
        <div class="form-group row<?php echo$args[0]=='compose'?' has-error':'';?>">
          <label for="email" class="col-form-label col-sm-2"><?php echo localize('To');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="to_email" class="form-control" value="<?php echo(isset($r)&&$r['to_name']!=''?$r['to_name']:'').($args[0]!='compose'?' &lt;'.$r['to_email'].'&gt;':'');?>"<?php echo($args[0]!='compose'?' readonly':'');?> placeholder="<?php echo localize('Enter an ').' '.localize('Email');?>..." role="textbox">
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-form-label col-sm-2"><?php echo localize('From');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="email" class="form-control" value="<?php echo$args[0]=='compose'?$user['name'].' &lt;'.$user['email'].'&gt;':$r['from_name'].' &lt;'.$r['from_email'].'&gt;';?>" readonly role="textbox">
          </div>
        </div>
        <form target="sp" role="form">
          <div class="form-group row">
            <label for="order_notes" class="col-form-label col-sm-2"><?php echo localize('Reply');?></label>
            <div class="input-group col-sm-10">
                <textarea name="da" class="form-control" role="textbox"></textarea>
            </div>
          </div>
        </form>
        <div class="form-group row">
          <label for="order_notes" class="col-form-label col-sm-2"><?php echo localize('Message');?></label>
          <div class="input-group col-sm-10">
            <iframe src="core/viewemail.php?id=<?php echo$r['id'];?>" width="100%" frameborder="0" scrolling="no" onload="this.style.height=this.contentDocument.body.scrollHeight +'px';" style="background:#fff;color:#000;"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
