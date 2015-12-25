<?php if(isset($args[0])&&$args[0]=='view'||$args[0]=='compose'){
	if($args[0]=='view'){
		$q=$db->prepare("UPDATE messages SET status='read' WHERE id=:id");
		$q->execute(array(':id'=>$args[1]));
		$q=$db->prepare("SELECT * FROM messages WHERE id=:id");
		$q->execute(array(':id'=>$args[1]));
		$r=$q->fetch(PDO::FETCH_ASSOC);
	}?>
<div class="page-toolbar">
	<div class="pull-right">
		<div class="btn-group">
			<a class="btn btn-success" href="<?php echo URL.'admin/messages';?>">Back</a>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="clearfix"></div>
		<div class="form-group">
			<label for="ti" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Created</label>
			<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
				<input type="text" id="ti" class="form-control" value="<?php if(isset($r['ti'])){echo date($config['dateFormat'],$r['ti']);}else{echo date($config['dateFormat'],time());}?>" readonly>
			</div>
		</div>
		<div class="form-group<?php if($args[0]=='compose')echo' has-error';?>">
			<label for="subject" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Subject</label>
			<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
				<input type="text" id="subject" class="form-control" name="subject" value="<?php if($args[0]!='compose'){echo$r['subject'];}?>" placeholder="Enter a Subject"<?php if($args[0]!='compose')echo' readonly';else echo' required';?>>
			</div>
		</div>
		<div class="form-group<?php if($args[0]=='compose')echo' has-error';?>">
			<label for="email" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">To</label>
			<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
				<input type="text" id="to_email" class="form-control" value="<?php if(isset($r)&&$r['to_name']!='')echo$r['to_name'];if($args[0]!='compose')echo' &lt;'.$r['to_email'].'&gt;';?>"<?php if($args[0]!='compose')echo' readonly';?> placeholder="Enter an Email, or Select from Contacts...">
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">From</label>
			<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
				<input type="text" id="email" class="form-control" value="<?php if($args[0]=='compose')echo$user['name'].' &lt;'.$user['email'].'&gt;';else echo$r['from_name'].' &lt;'.$r['from_email'].'&gt;';?>" readonly>
			</div>
		</div>
		<div id="reply" class="hidden">
			<div class="form-group">
				<label for="order_notes" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Reply</label>
				<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
					<form target="sp">
						<textarea name="da" class="form-control summernote"></textarea>
					</form>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="order_notes" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Message</label>
			<iframe class="well col-lg-11 col-md-10 col-sm-10 col-xs-8" style="" src="core/viewemail.php?id=<?php echo$r['id'];?>"></iframe>
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
<div class="page-toolbar"></div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-3 col-md-2">
				<ul class="nav nav-pills nav-stacked">
<?php $s=$db->prepare("SELECT COUNT(id) as cnt FROM messages WHERE folder='INBOX' AND status!='read'");
$s->execute();
$cnt=$s->fetch(PDO::FETCH_ASSOC);?>
					<li class="<?php if($folder=='INBOX')echo'active';?>"><a href="<?php echo URL.'admin/messages';?>"><?php if($cnt['cnt']>0)echo'<span class="badge pull-right">'.$cnt['cnt'].'</span>';?> Inbox </a></li>
<?php $s=$db->prepare("SELECT COUNT(id) as cnt FROM messages WHERE starred='1'");
$s->execute();
$cnt=$s->fetch(PDO::FETCH_ASSOC);?>
					<li class="<?php if($folder=='starred')echo'active';?>"><a href="<?php echo URL.'admin/messages/starred';?>"><?php if($cnt['cnt']>0)echo'<span class="badge pull-right">'.$cnt['cnt'].'</span>';?> Starred </a></li>
<?php $s=$db->prepare("SELECT COUNT(id) as cnt FROM messages WHERE folder='DELETE'");
$s->execute();
$cnt=$s->fetch(PDO::FETCH_ASSOC);?>
					<li class="<?php if($folder=='DELETE')echo'active';?>"><a href="<?php echo URL.'admin/messages/deleted';?>"><?php if($cnt['cnt']>0)echo'<span class="badge pull-right">'.$cnt['cnt'].'</span>';?> Deleted </a></li>
<?php $s=$db->prepare("SELECT COUNT(id) as cnt FROM messages WHERE important='1'");
$s->execute();
$cnt=$s->fetch(PDO::FETCH_ASSOC);?>
					<li class="<?php if($folder=='important')echo'active';?>"><a href="<?php echo URL.'admin/messages/important';?>"><?php if($cnt['cnt']>0)echo'<span class="badge pull-right">'.$cnt['cnt'].'</span>';?> Important </a></li>
				</ul>
			</div>
<?php
switch($folder){
	case'starred':
		$s=$db->prepare("SELECT * FROM messages WHERE starred='1' ORDER BY ti DESC, subject ASC");
		$s->execute();
		break;
	case'important':
		$s=$db->prepare("SELECT * FROM messages WHERE important='1' ORDER BY ti DESC, subject ASC");
		$s->execute();
		break;
	default:
		$s=$db->prepare("SELECT * FROM messages WHERE folder=:folder ORDER BY ti DESC, subject ASC");
		$s->execute(array(':folder'=>$folder));
}?>
			<div class="table-responsive mailbox-messages col-sm-9 col-md-10">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th class="mailbox-toggle">
								<input type="checkbox" id="checktoggle" class="check" data-dbid="checkboxtoggle" name="checkboxtoggle">
								<label for="checktoggle">
							</th>
							<th class="mailbox-star">&nbsp;</th>
							<th class="mailbox-name col-xs-4 text-center">Name</th>
							<th class="mailbox-subject col-xs-4 text-center">Subject</th>
							<th class="mailbox-date col-xs-2">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
						<tr id="l_<?php echo$r['id'];?>" class="<?php if($r['folder']=='DELETE')echo'danger';if($r['status']=='unread')echo' unread';?>">
							<td class="mailbox-toggle">
								<input type="checkbox" id="check<?php echo$r['id'];?>" class="check" sdata-dbid="null" class="checkboxtoggle" name="selected[]">
								<label for="check<?php echo$r['id'];?>">
							</td>
							<td class="mailbox-star"><span class="starred text-muted" data-dbid="<?php echo$r['id'];?>" data-starred="<?php echo$r['starred'];?>"><i class="libre libre-star<?php if($r['starred']!=1)echo'-o';?>"></i></span></td>
							<td class="mailbox-name">
								<a href="<?php echo URL.'admin/messages/view/'.$r['id'];?>" title="<?php echo'&lt;'.$r['from_email'].'&gt;';?>"><?php if($r['from_name']!='')echo$r['from_name'];else echo'&lt;'.$r['from_email'].'&gt;';?></a>
							</td>
							<td class="mailbox-subject">
								<a href="<?php echo URL.'admin/messages/view/'.$r['id'];?>"><?php echo $r['subject'];?></a>
							</td>
							<td class="mailbox-date"><?php echo date('M j \a\t G:i',$r['ti']);?></td>
						</tr>
<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php
}
