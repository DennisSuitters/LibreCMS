<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_messages.php';
elseif($args[0]=='view'||$args[0]=='compose'){
  if($args[0]=='view'){
    $q=$db->prepare("UPDATE messages SET status='read' WHERE id=:id");
    $q->execute(array(':id'=>$args[1]));
    $q=$db->prepare("SELECT * FROM messages WHERE id=:id");
    $q->execute(array(':id'=>$args[1]));
    $r=$q->fetch(PDO::FETCH_ASSOC);
  }?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Messages</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#messages#" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="clearfix"></div>
    <div class="form-group">
      <label for="ti" class="control-label col-xs-4 col-sm-2 col-lg-1">Created</label>
      <div class="input-group col-xs-8 col-sm-10 col-lg-11">
        <input type="text" id="ti" class="form-control" value="<?php echo(isset($r['ti'])?date($config['dateFormat'],$r['ti']):date($config['dateFormat'],time()));?>" readonly>
      </div>
    </div>
    <div class="form-group<?php if ($args[0] == 'compose') echo ' has-error';?>">
      <label for="subject" class="control-label col-xs-4 col-sm-2 col-lg-1">Subject</label>
      <div class="input-group col-xs-8 col-sm-10 col-lg-11">
        <input type="text" id="subject" class="form-control" name="subject" value="<?php echo($args[0]!='compose'?$r['subject']:'');?>" placeholder="Enter a Subject"<?php echo($args[0]!='compose'?' readonly':' required');?>>
      </div>
    </div>
    <div class="form-group<?php echo($args[0]=='compose'?' has-error':'');?>">
      <label for="email" class="control-label col-xs-4 col-sm-2 col-lg-1">To</label>
      <div class="input-group col-xs-8 col-sm-10 col-lg-11">
        <input type="text" id="to_email" class="form-control" value="<?php echo(isset($r)&&$r['to_name']!=''?$r['to_name']:'').($args[0]!='compose'?' &lt;'.$r['to_email'].'&gt;':'');?>"<?php echo($args[0]!='compose'?' readonly':'');?> placeholder="Enter an Email, or Select from Contacts...">
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="control-label col-xs-4 col-sm-2 col-lg-1">From</label>
      <div class="input-group col-xs-8 col-sm-10 col-lg-11">
        <input type="text" id="email" class="form-control" value="<?php echo($args[0]=='compose'?$user['name'].' &lt;'.$user['email'].'&gt;':$r['from_name'].' &lt;'.$r['from_email'].'&gt;');?>" readonly>
      </div>
    </div>
    <div id="reply" class="hidden">
      <div class="form-group">
        <label for="order_notes" class="control-label col-xs-4 col-sm-2 col-lg-1">Reply</label>
        <div class="input-group col-xs-8 col-sm-10 col-lg-11">
          <form target="sp">
            <textarea name="da" class="form-control summernote"></textarea>
          </form>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="order_notes" class="control-label col-xs-4 col-sm-2 col-lg-1">Message</label>
      <iframe class="well col-xs-8 col-sm-10 col-lg-11" style="" src="core/viewemail.php?id=<?php echo$r['id'];?>"></iframe>
    </div>
  </div>
</div>
<?php }else{
  $folder="INBOX";
  if(isset($args[0])){
    if($args[0]=='deleted')   $folder='DELETE';
    if($args[0]=='starred')   $folder='starred';
    if($args[0]=='important') $folder='important';
    if($args[0]=='sent')      $folder='sent';
  }?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Messages</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/messages/settings';?>" data-toggle="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#messages" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
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
$s=$db->prepare("SELECT * FROM messages ORDER BY ti DESC, subject ASC");
$s->execute(array(':folder'=>$folder));
$ur=$db->query("SELECT COUNT(status) AS cnt FROM messages WHERE status='unread'")->fetch(PDO::FETCH_ASSOC);
/*
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
*/ ?>
    <div id="emails" class="">
      <div class="table-responsive mailbox-messages">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th class="col-xs-4">Subject</th>
              <th class="col-xs-4">Name</th>
              <th class="col-xs-2 text-center">Date</th>
              <th class="col-xs-2"></th>
            </tr>
          </thead>
          <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <tr id="l_<?php echo$r['id'];?>" class="<?php echo($r['status']=='delete'?' danger':'');?>">
              <td><a href="<?php echo URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>"><?php echo$r['subject'];?></a></td>
              <td><a href="<?php echo URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>" title="<?php echo'&lt;'.$r['from_email'].'&gt;';?>"><?php echo($r['from_name']!=''?$r['from_name']:'&lt;'.$r['from_email'].'&gt;');?></a></td>
              <td class="text-center"><?php echo date('M j \a\t G:i',$r['ti']);?></td>
              <td id="controls_<?php echo$r['id'];?>" class="text-right">
                <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'];?>/messages/view/<?php echo$r['id'];?>" data-toggle="tooltip" title="View"><?php svg('libre-gui-view',($config['iconsColor']==1?true:null));?></a>
                <button class="btn btn-default<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo $r['id'];?>','messages','status','')" data-toggle="tooltip" title="Restore"><?php svg('libre-gui-restore',($config['iconsColor']==1?true:null));?></button>
                <button class="btn btn-default trash<?php echo($r['status']=='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','messages','status','delete')" data-toggle="tooltip" title="Delete"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
                <button class="btn btn-default trash<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="purge('<?php echo $r['id'];?>','messages')" data-toggle="tooltip" title="Purge"><?php svg('libre-gui-purge',($config['iconsColor']==1?true:null));?></button>
              </td>
            </tr>
<?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php }
