<?php if(isset($args[0])&&$args[0]=='view'){
	$q=$db->prepare("UPDATE messages SET status='read' WHERE id=:id");
	$q->execute(array(':id'=>$args[1]));
	$q=$db->prepare("SELECT * FROM messages WHERE id=:id");
	$q->execute(array(':id'=>$args[1]));
	$r=$q->fetch(PDO::FETCH_ASSOC);?>
<div class="page-toolbar"></div>
<div class="panel panel-default">
	<div class="panel-body">
<div class="form-group clearfix">
	<div class="input-group pull-left">
		<a class="btn btn-default" href="<?php echo URL.'admin/messages';?>">Back</a>
	</div>
	<div class="input-group pull-right">
		<button class="btn btn-default" onclick="$('#reply').toggle('slow');">Reply</button>
		<a class="btn btn-default" href="#">Forward</a>
		<a class="btn btn-danger" hreaf="#">Delete</a>
	</div>
</div>
<div class="form-group">
	<label for="ti" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Created</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['email_date']);?>" readonly>
	</div>
</div>
<div class="form-group">
	<label for="subject" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Subject</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="subject" class="form-control" value="<?php echo$r['subject'];?>" readonly>
	</div>
</div>
<div class="form-group">
	<label for="email" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">To</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="email" class="form-control" value="<?php echo$r['to_name'].' &lt;'.$r['to_email'].'&gt;';?>" readonly>
	</div>
</div>
<div class="form-group">
	<label for="email" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">From</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="email" class="form-control" value="<?php echo$r['from_name'].' &lt;'.$r['from_email'].'&gt;';?>" readonly>
	</div>
</div>
<?php if($r['attachments']!=''){
	$attachments=explode(',',$r['attachments']);?>
<div class="form-group">
	<label for="email" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Attachments</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
<?php foreach($attachments as $attachment){
		if($attachment!=''){
			echo'<a target="_blank" href="'.URL.'media/attachments/'.$r['mid'].'/'.$attachment.'">'.$attachment.'</a><br>';
	 	}
	}?>
	</div>
</div>
<?php }?>
<div id="reply" style="display:none;">
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
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<div class="row-fluid">
			<iframe class="container well" style="min-height:500px" src="core/viewemail.php?id=<?php echo$r['id'];?>"></iframe>
		</div>
	</div>
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
<?php /*		<a href="#" class="btn btn-danger btn-sm btn-block" role="button">COMPOSE</a> */?>
			<hr>
			<ul class="nav nav-pills nav-stacked">
<?php $s=$db->prepare("SELECT COUNT(id) as cnt FROM messages WHERE folder='INBOX'");
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
		<div class="col-sm-9 col-md-10">
			<div class="tab-pane fade in<?php if($user['email']!='')echo' active';?>" id="home">
				<div class="list-group">
<?php
switch($folder){
	case'starred':
		$s=$db->prepare("SELECT * FROM messages WHERE starred='1' ORDER BY email_date DESC, subject ASC");
		$s->execute();
		break;
	case'important':
		$s=$db->prepare("SELECT * FROM messages WHERE important='1' ORDER BY email_date DESC, subject ASC");
		$s->execute();
		break;
	default:
		$s=$db->prepare("SELECT * FROM messages WHERE folder=:folder ORDER BY email_date DESC, subject ASC");
		$s->execute(array(':folder'=>$folder));
}?>
					<div class="list-group-item list-group-item-default">
						<span data-toggle="tooltip" title="Select Toggle">
							<input type="checkbox" data-dbid="checkboxtoggle" name="checkboxtoggle">
						</span>
						<span class="starred text-muted" data-toggle="tooltip" title="Starred Toggle"><i class="libre libre-star"></i></span>
						<span class="important text-muted" data-toggle="tooltip" title="Important Toggle"><i class="libre libre-empty-circle"></i></span>
						<span class="text-muted" data-toggle="tooltip" title="Attachment Toggle"><i class="libre libre-paperclip libre-fw"></i></span>
					</div>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
					<div id="l_<?php echo$r['id'];?>" class="list-group-item list-group-item-<?php if($r['folder']=='DELETE')echo'danger';else echo'default';?>">
						<input type="checkbox" data-dbid="null" class="checkboxtoggle" name="selected[]">
						<span class="starred text-muted" data-dbid="<?php echo$r['id'];?>" data-starred="<?php echo$r['starred'];?>"><i class="libre libre-star<?php if($r['starred']!=1)echo'-o';?>"></i></span>
						<span class="important text-muted" data-dbid="<?php echo$r['id'];?>" data-important="<?php echo$r['important'];?>"><i class="libre libre-empty-circle<?php if($r['important']!=1)echo'-o';?>"></i></span>
						<small>
							<a href="<?php echo URL.'admin/messages/view/'.$r['id'];?>">
<?php if($r['status']=='unread')echo'<strong>';?>
								<span class="name" style="min-width:250px;display:inline-block;text-overflow:ellipsis;" title="<?php echo'&lt;'.$r['from_email'].'&gt;';?>"><?php echo $r['from_name'];?></span>
								<span class="name" style="min-width:200px;display:inline-block;text-overflow:ellipsis;"><?php echo $r['subject'];?></span>
<?php if($r['status']=='unread')echo'</strong>';?>
								<span class="pull-right"><?php echo date('M j \a\t G:i',$r['ti']);?></span>
							</a>
						</small>
					</div>
<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

</script>
<?php
}
