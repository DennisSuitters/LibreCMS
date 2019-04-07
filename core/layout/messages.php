<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Messages
 *
 * messages.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Messages
 * @package    core/layout/messages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Move Settings to Header
 * @changes    v2.0.2 Add i18n.
 */
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_messages.php';
elseif($args[0]=='view'||$args[0]=='compose')
  include'core'.DS.'layout'.DS.'edit_messages.php';
else{
  $folder="INBOX";
  if(isset($args[0])){
    if($args[0]=='unread')$folder='unread';
    if($args[0]=='trash')$folder='trash';
//     if($args[0]=='trash')$folder='DELETE';
    if($args[0]=='starred')$folder='starred';
    if($args[0]=='important')$folder='important';
    if($args[0]=='sent')$folder='sent';
    if($args[0]=='spam')$folder='spam';
  }?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active"><?php echo localize('Messages');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <?php if($help['messages_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['messages_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['messages_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['messages_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="alert alert-info">Not all the Messages Functions are currently working at this time, we are working on it though.</div>
    <div class="card">
      <div class="card-body">
<?php /*
    <div class="alert alert-info">
      The Webmail is currently Under Construction.<br>
      Simple Mail Reading should work fine, but other manipulation may have adverse consequences.
    </div>
// https://github.com/cnizzardini/php-imap
include_once 'core/imap.class.php';
$imap = new Imap('mail.studiojunkyard.com','info@studiojunkyard.com','barnibus!2014');
$imapObj = $imap->returnImapMailBoxmMsgInfoObj();
echo '<h3>Mailbox Stats <span class="code">imap::returnImapMailBoxmMsgInfoObj()</span></h3><p>Unread: ('.$imapObj->Unread.') Deleted: ('.$imapObj->Deleted.') Emails: ('.$imapObj->Nmsgs.') Size: ('.round($imapObj->Size/1024/1024,1).' MB)</p>';
echo '<h3>MailBoxes <span class="code">imap::returnMailboxListArr()</span></h3>';
$mailBoxArr = $imap->returnMailboxListArr();

if(is_array($mailBoxArr)){
  echo '<ul>';
  foreach($mailBoxArr as $i){
    echo '<li><a href="?mailbox='.urlencode($i).'">'.$i.'</a></li>';
  }
      echo '</ul>';
} */
?>
<?php
  if($folder=='INBOX'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE folder='INBOX' ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  if($folder=='unread'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE status='unread' ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  if($folder=='trash'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE status='trash' ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  if($folder=='starred'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE starred=1 ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  if($folder=='important'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE important=1 ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  if($folder=='sent'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE folder='sent' ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  if($folder=='spam'){
    $s=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE folder='spam' ORDER BY ti DESC, subject ASC");
    $s->execute();
  }
  $ur=$db->query("SELECT COUNT(status) AS cnt FROM `".$prefix."messages` WHERE status='unread' AND folder='INBOX'")->fetch(PDO::FETCH_ASSOC);
  $sp=$db->query("SELECT COUNT(folder) AS cnt FROM `".$prefix."messages` WHERE folder='spam' AND status='unread'")->fetch(PDO::FETCH_ASSOC);?>
        <div class="email-app mb-4">
          <nav>
            <a class="btn btn-secondary btn-block" href="#">Compose</a>
            <ul class="nav">
              <li class="nav-item<?php echo$folder=='INBOX'?' active':'';?>">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages';?>">
                  <?php svg('libre-gui-inbox');?> Inbox
                </a>
              </li>
              <li class="nav-item<?php echo$folder=='unread'?' active':'';?>">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/unread';?>">
                  <?php svg('libre-gui-email');?> Unread
                  <?php echo$ur['cnt']>0?'<span class="badge badge-danger">'.$ur['cnt'].'</span>':'';?>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/starred';?>">
                  <?php svg('libre-shape-star');?> Starred
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/sent';?>">
                  <?php svg('libre-gui-email-send');?> Sent
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/trash';?>">
                  <?php svg('libre-gui-trash');?> Trash
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/important';?>">
                  <?php svg('libre-gui-bookmark');?> Important
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo URL.$settings['system']['admin'].'/messages/spam';?>">
                  <?php svg('libre-gui-email-spam');?> Spam
                  <?php echo$sp['cnt']>0?'<span class="badge badge-danger">'.$sp['cnt'].'</span>':'';?>
                </a>
              </li>
            </ul>
          </nav>
          <main class="inbox">
            <div class="toolbar">
              <div class="btn-group" role="group">
                <button class="btn btn-secondary" type="button"><?php svg('libre-gui-email');?></button>
                <button class="btn btn-secondary" type="button"><?php svg('libre-shape-star');?></button>
                <button class="btn btn-secondary" type="button"><?php svg('libre-shape-star-o');?></button>
                <button class="btn btn-secondary" type="button"><?php svg('libre-gui-bookmark');?></button>
              </div>
              <div class="btn-group" role="group">
                <button class="btn btn-secondary" type="button"><?php svg('libre-gui-email-reply');?></button>
                <button class="btn btn-secondary" type="button"><?php svg('libre-gui-email-reply');/* reply-all */?></button>
                <button class="btn btn-secondary" type="button"><?php svg('libre-gui-email-forward');?></button>
              </div>
              <button class="btn btn-secondary" type="button"><?php svg('libre-gui-trash');?></button>
            </div>
            <ul class="messages">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <li class="message <?php echo$r['status'];?>">
                <div class="actions">
                  <div class="btn-group-vertical">
                    <div class="checkbox bg-secondary checkbox-success">
                      <input type="checkbox" id="message<?php echo$r['id'];?>">
                      <label for="message<?php echo$r['id'];?>"/>
                    </div>
<?php $scc=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");
      $scc->execute([':ip'=>$r['ip']]);
      if($scc->rowCount()<1)echo'<button class="btn btn-secondary btn-sm" data-tooltip="tooltip" title="Add Originators IP to the Blacklist.">'.svg2('libre-gui-security').'</button>';?>
                    <button class="btn btn-secondary btn-sm trash"><?php svg('libre-gui-trash');?></button>
                  </div>
                </div>
                <a href="<?php echo URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>">
                  <div class="header">
                    <span class="from"><?php echo$r['from_name']!=''?$r['from_name'].'<br><small>&lt;'.$r['from_email'].'&gt;</small>':'&lt;'.$r['from_email'].'&gt;';?></span>
                    <span class="date"><?php echo date('M j \a\t G:i',$r['ti']);?></span>
                  </div>
                  <span class="title d-block"><?php echo$r['subject'];?></span>
                  <span class="description d-block"><?php echo strip_tags(substr($r['notes_raw'],0,255));?></span>
                </a>
              </li>
<?php }?>
            </ul>
          </main>
        </div>
      </div>
    </div>
  </div>
</main>
<?php /*
?>

    <div class="nav-list col-xs-12 col-sm-2">
      <a href="" class="btn btn-default add btn-block">Compose</a>
      <br>
      <div class="list-group">
        <a href="" class="list-group-item active"><?php svg('inbox');?> Inbox<span id="email_inbox" class="badge"><?php if($ur['cnt']>0)echo$ur['cnt'];?></span></a>
        <a href="" class="list-group-item"><?php svg('email-send');?> Sent Mail<span id="email_sent" class="badge"></span></a>
        <a href="" class="list-group-item"><?php svg('star');?> Important<span id="email_important" class="badge"></span></a>
        <a href="" class="list-group-item"><?php svg('edit');?> Drafts<span id="email_drafts" class="badge"></span></a>
        <a href="" class="list-group-item"><?php svg('bug');?> Spam<span id="email_spam" class="badge"></span></a>
        <a href="" class="list-group-item"><?php svg('trash');?> Trash<span id="email_trash" class="badge"></span></a>
      </div>
    </div>
        <div id="emails" class="">
          <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
              <thead>
                <tr>
                  <th class="">From</th>
                  <th class="">Subject</th>
                  <th class="">Name</th>
                  <th class="">Date</th>
                  <th class=""></th>
                </tr>
              </thead>
              <tbody>
              

<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
  
/*?>
                <tr id="l_<?php echo$r['id'];?>" class="<?php echo$r['status']=='delete'?' danger':'';?>">
                  <td><?php echo$r['from_name'].'<br><small>&lt;'.$r['from_email'].'&gt;</small>';?></td>
                  <td><a href="<?php echo URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>"><?php echo$r['subject'];?></a></td>
                  <td><a href="<?php echo URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>" title="<?php echo'&lt;'.$r['from_email'].'&gt;';?>"><?php echo$r['from_name']!=''?$r['from_name']:'&lt;'.$r['from_email'].'&gt;';?></a></td>
                  <td class="text-center"><?php echo date('M j \a\t G:i',$r['ti']);?></td>
                  <td id="controls_<?php echo$r['id'];?>">
                    <div class="btn-group float-right">
                      <a class="btn btn-secondary" href="<?php echo URL.$settings['system']['admin'];?>/messages/view/<?php echo$r['id'];?>" data-tooltip="tooltip" title="View"><?php svg('libre-gui-view');?></a>
                      <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','messages','status','')" data-tooltip="tooltip" title="Restore"><?php svg('libre-gui-untrash');?></button>
                      <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','messages','status','delete')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                      <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo $r['id'];?>','messages')" data-tooltip="tooltip" title="Purge"><?php svg('libre-gui-purge');?></button>
                    </div>
                  </td>
                </tr>
<?php 
}

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php

 }
*/
}