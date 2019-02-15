<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if($args[0]=='view'){
  $q=$db->prepare("UPDATE `".$prefix."messages` SET status='read' WHERE id=:id");
  $q->execute(array(':id'=>$args[1]));
  $q=$db->prepare("SELECT * FROM `".$prefix."messages` WHERE id=:id");
  $q->execute(array(':id'=>$args[1]));
  $r=$q->fetch(PDO::FETCH_ASSOC);
}?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/messages';?>">Messages</a></li>
    <li class="breadcrumb-item"><?php echo$args[0]=='view'?'View':'Compose';?></li>
    <li class="breadcrumb-item active" aria-current="page"><strong id="titleupdate"><?php echo$r['subject'];?></strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('libre-gui-back');?></a>
        <?php $scc=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");$scc->execute(array(':ip'=>$r['ip']));if($scc->rowCount()<1){?><form id="blacklist<?php echo$r['id'];?>" target="sp" method="post" action="core/add_messageblacklist.php" style="display:inline-block;"><input type="hidden" name="id" value="<?php echo$r['id'];?>"><button class="btn btn-ghost-normal info" data-tooltip="tooltip" title="Add Originators IP to the Blacklist."><?php echo svg2('libre-gui-security');?></button></form><?php }
        if($help['messages_edit_text']!='')echo'<a class="btn btn-ghost-normal info" href="'.$help['messages_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="Help">'.svg2('libre-gui-help').'</a>';if($help['messages_edit_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['messages_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card col-sm-12">
      <div class="card-body">
        <div class="form-group row">
          <label for="ti" class="col-form-label col-sm-2">Created</label>
          <div class="input-group col-sm-10">
            <input type="text" id="ti" class="form-control" value="<?php echo isset($r['ti'])?date($config['dateFormat'],$r['ti']):date($config['dateFormat'],time());?>" readonly>
          </div>
        </div>
        <div class="form-group row<?php echo$args[0]=='compose'?' has-error':'';?>">
          <label for="subject" class="col-form-label col-sm-2">Subject</label>
          <div class="input-group col-sm-10">
            <input type="text" id="subject" class="form-control" name="subject" value="<?php echo$args[0]!='compose'?$r['subject']:'';?>" placeholder="Enter a Subject"<?php echo$args[0]!='compose'?' readonly':' required';?>>
          </div>
        </div>
        <div class="form-group row<?php echo$args[0]=='compose'?' has-error':'';?>">
          <label for="email" class="col-form-label col-sm-2">To</label>
          <div class="input-group col-sm-10">
            <input type="text" id="to_email" class="form-control" value="<?php echo(isset($r)&&$r['to_name']!=''?$r['to_name']:'').($args[0]!='compose'?' &lt;'.$r['to_email'].'&gt;':'');?>"<?php echo($args[0]!='compose'?' readonly':'');?> placeholder="Enter an Email, or Select from Contacts...">
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-form-label col-sm-2">From</label>
          <div class="input-group col-sm-10">
            <input type="text" id="email" class="form-control" value="<?php echo$args[0]=='compose'?$user['name'].' &lt;'.$user['email'].'&gt;':$r['from_name'].' &lt;'.$r['from_email'].'&gt;';?>" readonly>
          </div>
        </div>
        <div id="reply" class="hidden">
          <div class="form-group">
            <label for="order_notes" class="col-form-label col-sm-2">Reply</label>
            <div class="input-group col-sm-10">
              <form target="sp">
                <textarea name="da" class="form-control summernote"></textarea>
              </form>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="order_notes" class="col-form-label col-sm-2">Message</label>
          <iframe class="well col-sm-10" style="" src="core/viewemail.php?id=<?php echo$r['id'];?>"></iframe>
        </div>
      </div>
    </div>
  </div>
</main>
