<?php
if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_messages.php';
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
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('back');?></a>
      </div>
      <div class="btn-group">
        <a class="btn btn-default info" href="#"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="clearfix"></div>
    <div class="form-group">
      <label for="ti" class="control-label col-xs-4 col-sm-2 col-lg-1">Created</label>
      <div class="input-group col-xs-8 col-sm-10 col-lg-11">
        <input type="text" id="ti" class="form-control" value="<?php if(isset($r['ti'])){echo date($config['dateFormat'],$r['ti']);}else{echo date($config['dateFormat'],time());}?>" readonly>
      </div>
    </div>
    <div class="form-group<?php if($args[0]=='compose')echo' has-error';?>">
      <label for="subject" class="control-label col-xs-4 col-sm-2 col-lg-1">Subject</label>
      <div class="input-group col-xs-8 col-sm-10 col-lg-11">
        <input type="text" id="subject" class="form-control" name="subject" value="<?php if($args[0]!='compose'){echo$r['subject'];}?>" placeholder="Enter a Subject"<?php if($args[0]!='compose')echo' readonly';else echo' required';?>>
      </div>
    </div>
    <div class="form-group<?php if($args[0]=='compose')echo' has-error';?>">
      <label for="email" class="control-label col-xs-4 col-sm-2 col-lg-1">To</label>
      <div class="input-group col-xs-8 col-sm-10 col-lg-11">
        <input type="text" id="to_email" class="form-control" value="<?php if(isset($r)&&$r['to_name']!='')echo$r['to_name'];if($args[0]!='compose')echo' &lt;'.$r['to_email'].'&gt;';?>"<?php if($args[0]!='compose')echo' readonly';?> placeholder="Enter an Email, or Select from Contacts...">
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="control-label col-xs-4 col-sm-2 col-lg-1">From</label>
      <div class="input-group col-xs-8 col-sm-10 col-lg-11">
        <input type="text" id="email" class="form-control" value="<?php if($args[0]=='compose')echo$user['name'].' &lt;'.$user['email'].'&gt;';else echo$r['from_name'].' &lt;'.$r['from_email'].'&gt;';?>" readonly>
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
    if($args[0]=='deleted')$folder='DELETE';
    if($args[0]=='starred')$folder='starred';
    if($args[0]=='important')$folder='important';
    if($args[0]=='sent')$folder='sent';
  }?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Messages</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/messages/settings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Settings"';?>><?php svg('cogs');?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#messages"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
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
<?php $s=$db->prepare("SELECT * FROM messages ORDER BY ti DESC, subject ASC");
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
            <tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='delete')echo' danger';?>">
              <td><a href="<?php echo URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>"><?php echo $r['subject'];?></a></td>
              <td><a href="<?php echo URL.$settings['system']['admin'].'/messages/view/'.$r['id'];?>" title="<?php echo'&lt;'.$r['from_email'].'&gt;';?>"><?php if($r['from_name']!='')echo$r['from_name'];else echo'&lt;'.$r['from_email'].'&gt;';?></a></td>
              <td class="text-center"><?php echo date('M j \a\t G:i',$r['ti']);?></td>
              <td id="controls_<?php echo$r['id'];?>" class="text-right">
                <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'];?>/messages/view/<?php echo$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="View"';?>><?php svg('view');?></a>
                <button class="btn btn-default<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','messages','status','')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><?php svg('restore');?></button>
                <button class="btn btn-default trash<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','messages','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><?php svg('trash');?></button>
                <button class="btn btn-default trash<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','messages')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><?php svg('purge');?></button>
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
