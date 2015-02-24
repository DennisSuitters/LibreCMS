<?php if(isset($args[0])&&$args[0]=='view'){
	$q=$db->prepare("UPDATE messages SET status='read' WHERE id=:id");
	$q->execute(array(':id'=>$args[1]));
	$q=$db->prepare("SELECT * FROM messages WHERE id=:id");
	$q->execute(array(':id'=>$args[1]));
	$r=$q->fetch(PDO::FETCH_ASSOC);?>
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
<?php }else{
$folder="INBOX";
if(isset($args[0])){
	if($args[0]=='deleted')$folder='DELETE';
	if($args[0]=='starred')$folder='starred';
	if($args[0]=='important')$folder='important';
	if($args[0]=='sent')$folder='sent';
}
function decode_imap_text($str){
	$result = '';
	$decode_header = imap_mime_header_decode($str);
	foreach ($decode_header AS $obj) {
		$result .= htmlspecialchars(rtrim($obj->text, "\t"));
	}
	return $result;
}
function human_filesize($bytes, $dec = 2){
    $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}
function getFileExtension($fileName){
   $parts=explode(".",$fileName);
   return $parts[count($parts)-1];
}
$chk=$db->query("SELECT email_check,email_interval FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
if(time()>($chk['email_check']+$chk['email_interval'])){
	$s=$db->prepare("UPDATE config SET email_check=:email_check WHERE id='1'");
	$s->execute(array(':email_check'=>time()));
	$mailboxes=array(
		array(
			'label'     => 'Another mail account',
			'mailbox'   => '{mail.studiojunkyard.com:143/notls}INBOX',
			'username'  => 'dennis@studiojunkyard.com',
			'password'  => 'barnibus!2014'
		)
	);
	foreach($mailboxes as $current_mailbox) {
// Open an IMAP stream to our mailbox
		$stream = @imap_open($current_mailbox['mailbox'], $current_mailbox['username'], $current_mailbox['password']);
		if (!$stream){?>
					<p>Could not connect to: <?php echo $current_mailbox['label']?>. Error: <?php echo imap_last_error()?></p>
<?php 	}else{
			if($chk['email_check']==0){
				$emails = imap_search($stream,'ALL');
			}else{
				$count=$db->query("SELECT MAX(email_date) as email_date FROM messages")->fetch(PDO::FETCH_ASSOC);
				$since=date('d-M-Y G\:i',$count['email_date']+1);
				$emails=imap_search($stream,'SINCE "'.$since.'"');
			}
			if (count($emails)){
				rsort($emails);
				foreach($emails as $email_id){
					$overview=imap_fetch_overview($stream,$email_id,0);
					$to_email=explode('&lt;',decode_imap_text($overview[0]->to));
					$to_name=trim($to_email[0]);
					if(isset($to_email[1]))$to_email=rtrim($to_email[1],'&gt;');
					else $to_email=rtrim($to_email[0],'&gt;');
					$from_email=explode('&lt;',decode_imap_text($overview[0]->from));
					$from_name=trim($from_email[0]);
					if(isset($from_email[1]))$from_email=rtrim($from_email[1],'&gt;');
					else $from_email=rtrim($from_email[0],'&gt;');
					$body_mime=imap_fetchmime($stream,$email_id,1);
					$st=imap_fetchstructure($stream, $email_id);
					if(!empty($st->parts)){
						for($i=0,$j=count($st->parts);$i<$j;$i++){
							$part=$st->parts[$i];
							if($part->subtype=='PLAIN'){
								$body=imap_fetchbody($stream,$email_id,$i+1,FT_INTERNAL);
							}
						}
					}else{
						$body=imap_body($stream,$email_id);
					}
					$size=$overview[0]->size;
					$structure=imap_fetchstructure($stream,$email_id);
				    $attachments=array();
					if(isset($structure->parts)&& count($structure->parts)){
						for($i=0;$i<count($structure->parts);$i++){
							$attachments[$i]=array(
								'is_attachment'=>false,
								'filename'=>'',
								'name'=>'',
								'attachment'=>''
							);
							if($structure->parts[$i]->ifdparameters){
								foreach($structure->parts[$i]->dparameters as $object){
									if(strtolower($object->attribute)=='filename'){
										$attachments[$i]['is_attachment']=true;
										$attachments[$i]['filename']=$object->value;
									}
								}
							}
							if($structure->parts[$i]->ifparameters) {
								foreach($structure->parts[$i]->parameters as $object) {
									if(strtolower($object->attribute) == 'name') {
										$attachments[$i]['is_attachment'] = true;
										$attachments[$i]['name'] = $object->value;
									}
								}
							}
							if($attachments[$i]['is_attachment']) {
								$attachments[$i]['attachment'] = imap_fetchbody($stream, $email_id, $i+1);
								if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
								$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
							}elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
								$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
							}
							}
						}
					}
					$att='';
					foreach($attachments as $key => $attachment) {
						if($attachment['name']!=''){
							$name = $attachment['name'];
							$contents = $attachment['attachment'];
							if(!file_exists('media/attachments/'.$email_id.'/'.$name)){
								mkdir('media/attachments/'.$email_id,0755);
								file_put_contents('media/attachments/'.$email_id.'/'.$name, $contents);
								$att.=$name.',';
							}
						}
					}
					$sc=$db->prepare("SELECT mid FROM messages WHERE mid=:mid");
					$sc->execute(array(':mid'=>$email_id));
					if($sc->rowCount()<1){
						$s=$db->prepare("INSERT INTO messages (uid,mid,folder,to_email,to_name,from_email,from_name,subject,status,notes_raw,notes_raw_mime,attachments,email_date,size,ti) VALUES (:uid,:mid,:folder,:to_email,:to_name,:from_email,:from_name,:subject,:status,:notes_raw,:notes_raw_mime,:attachments,:email_date,:size,:ti)");
						$s->execute(array(
							':uid'=>$user['id'],
							':mid'=>$email_id,
							':folder'=>'INBOX',
							':to_email'=>$to_email,
							':to_name'=>$to_name,
							':from_email'=>$from_email,
							':from_name'=>$from_name,
							':subject'=>decode_imap_text($overview[0]->subject),
							':status'=>'unread',
							':notes_raw'=>$body,
							':notes_raw_mime'=>$body_mime,
							':attachments'=>$att,
							':email_date'=>strtotime($overview[0]->date),
							':size'=>$size,
							':ti'=>time()
							));
					}
				}
			} 
			imap_close($stream); 
		}
	}
}


?>
<div class="row">
	<div class="col-sm-3 col-md-2">
		<div class="btn-group">
			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				Mail <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#">Mail</a></li>
				<li><a href="#">Contacts</a></li>
			</ul>
		</div>
	</div>
	<div class="col-sm-9 col-md-10">
		<div class="btn-group">
			<button type="button" class="btn btn-default">
				<div class="checkbox" style="margin: 0;">
					<label>
						<input type="checkbox">
					</label>
				</div>
			</button>
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
				<span class="sr-only">Toggle Dropdown</span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#">All</a></li>
				<li><a href="#">None</a></li>
				<li><a href="#">Read</a></li>
				<li><a href="#">Unread</a></li>
				<li><a href="#">Starred</a></li>
				<li><a href="#">Unstarred</a></li>
			</ul>
		</div>
		<button type="button" class="btn btn-default" data-toggle="tooltip" title="Refresh">
			   <i class="fa fa-refresh"></i>
		</button>
		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				More <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#">Mark all as read</a></li>
				<li class="divider"></li>
				<li class="text-center"><small class="text-muted">Select messages to see more actions</small></li>
			</ul>
		</div>
		<div class="pull-right">
			<span class="text-muted"><b>1</b>–<b>50</b> of <b>277</b></span>
			<div class="btn-group btn-group-sm">
				<button type="button" class="btn btn-default">
					<i class="fa fa-chevron-left"></i>
				</button>
				<button type="button" class="btn btn-default">
					<i class="fa fa-chevron-right"></i>
				</button>
			</div>
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-sm-3 col-md-2">
		<a href="#" class="btn btn-danger btn-sm btn-block" role="button">COMPOSE</a>
		<hr>
		<ul class="nav nav-pills nav-stacked">
<?php $s=$db->prepare("SELECT COUNT(id) as cnt FROM messages WHERE folder='INBOX' AND status='unread' AND uid=:uid");
$s->execute(array(':uid'=>$user['id']));
$cnt=$s->fetch(PDO::FETCH_ASSOC);?>
			<li class="<?php if($folder=='INBOX')echo'active';?>"><a href="<?php echo URL.'admin/messages';?>"><?php if($cnt['cnt']>0)echo'<span class="badge pull-right">'.$cnt['cnt'].'</span>';?> Inbox </a></li>
<?php $s=$db->prepare("SELECT COUNT(id) as cnt FROM messages WHERE starred='1' AND uid=:uid");
$s->execute(array(':uid'=>$user['id']));
$cnt=$s->fetch(PDO::FETCH_ASSOC);?>
			<li class="<?php if($folder=='starred')echo'active';?>"><a href="<?php echo URL.'admin/messages/starred';?>"><?php if($cnt['cnt']>0)echo'<span class="badge pull-right">'.$cnt['cnt'].'</span>';?> Starred </a></li>
<?php $s=$db->prepare("SELECT COUNT(id) as cnt FROM messages WHERE folder='DELETE' AND uid=:uid");
$s->execute(array(':uid'=>$user['id']));
$cnt=$s->fetch(PDO::FETCH_ASSOC);?>
			<li class="<?php if($folder=='DELETE')echo'active';?>"><a href="<?php echo URL.'admin/messages/deleted';?>"><?php if($cnt['cnt']>0)echo'<span class="badge pull-right">'.$cnt['cnt'].'</span>';?> Deleted </a></li>
<?php $s=$db->prepare("SELECT COUNT(id) as cnt FROM messages WHERE important='1' AND uid=:uid");
$s->execute(array(':uid'=>$user['id']));
$cnt=$s->fetch(PDO::FETCH_ASSOC);?>
			<li class="<?php if($folder=='important')echo'active';?>"><a href="<?php echo URL.'admin/messages/important';?>"><?php if($cnt['cnt']>0)echo'<span class="badge pull-right">'.$cnt['cnt'].'</span>';?> Important </a></li>
			<li class="<?php if($folder=='sent')echo'active';?>"><a href="<?php echo URL.'admin/messages/sent';?>">Sent Mail</a></li>
		</ul>
	</div>
	<div class="col-sm-9 col-md-10">
		<ul class="nav nav-tabs">
			<li<?php if($config['email']!=''&&$user['email']!='')echo' class="active"';?>><a href="#home" data-toggle="tab"><span class="fa fa-inbox"></span>Your Inbox</a></li>
			<li<?php if($config['email']==''&&$user['email']=='')echo' class="active"';?>><a href="#settings" data-toggle="tab"><span class="fa fa-cogs"></span>Settings</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade in<?php if($user['email']!='')echo' active';?>" id="home">
				<div class="list-group">
<?php
switch($folder){
	case'starred':
		$s=$db->prepare("SELECT * FROM messages WHERE uid=:uid AND starred='1' ORDER BY email_date DESC, subject ASC");
		$s->execute(array(':uid'=>$user['id']));
		break;
	case'important':
		$s=$db->prepare("SELECT * FROM messages WHERE uid=:uid AND important='1' ORDER BY email_date DESC, subject ASC");
		$s->execute(array(':uid'=>$user['id']));
		break;
	default:
		$s=$db->prepare("SELECT * FROM messages WHERE uid=:uid AND folder=:folder ORDER BY email_date DESC, subject ASC");
		$s->execute(array(':uid'=>$user['id'],':folder'=>$folder));
}
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
					<div id="l_<?php echo$r['id'];?>" class="list-group-item list-group-item-<?php if($r['folder']=='DELETE')echo'danger';else echo'default';?>">
						<input type="checkbox">
						<span class="starred text-muted" data-dbid="<?php echo$r['id'];?>" data-starred="<?php echo$r['starred'];?>"><i class="fa fa-star<?php if($r['starred']!=1)echo'-o';?>"></i></span>
						<span class="important text-muted" data-dbid="<?php echo$r['id'];?>" data-important="<?php echo$r['important'];?>"><i class="fa fa-circle<?php if($r['important']!=1)echo'-o';?>"></i></span>
						<span class="text-muted"><i class="fa <?php if($r['attachments']!='')echo'fa-paperclip';?> fa-fw"></i></span>
						<small>
							<a href="<?php echo URL.'admin/messages/view/'.$r['id'];?>">
<?php if($r['status']=='unread')echo'<strong>';?>
								<span class="name" style="min-width:250px;display:inline-block;text-overflow:ellipsis;" title="<?php echo'&lt;'.$r['from_email'].'&gt;';?>"><?php echo $r['from_name'];?></span> 
								<span class="name" style="min-width:200px;display:inline-block;text-overflow:ellipsis;"><?php echo $r['subject'];?></span>
<?php if($r['status']=='unread')echo'</strong>';?>
								<span class="pull-right"><?php echo date('M j \a\t G:i',$r['email_date']);?></span> 
							</a>
						</small>
						<small class="pull-right">
							<span class="text-muted"><?php echo human_filesize($r['size']);?></span>&nbsp;
						</small> 
					</div>
<?php }?>
				</div>
			</div>
			<div class="tab-pane fade in<?php if($config['email']==''&&$user['email']=='')echo' active';?>" id="settings">
				<div class="well">
					<h4>Personal Email Settings</h4>
					<div class="form-group">
						<label for="email" class="control-label col-xs-4 col-sm-2 col-md-2 col-lg-1">Email</label>
						<div class="input-group col-xs-8 col-sm-10 col-md-10 col-lg-11">
							<input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="Enter an Email...">
						</div>
					</div>
				</div>
				<div class="well">
					<h4>System Email Settings</h4>
					<div class="form-group">
						<label for="email" class="control-label col-xs-4 col-sm-2 col-md-2 col-lg-1">Email</label>
						<div class="input-group col-xs-8 col-sm-10 col-md-10 col-lg-11">
							<input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="Enter an Email...">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
}
