<?php if($args[0]=='add'){
	$type=filter_input(INPUT_GET,'type',FILTER_SANITIZE_STRING);
	$q=$db->prepare("INSERT INTO login (options,rank,active,ti) VALUES ('00000000','0','1',:ti)");
	$q->execute(array(':ti'=>$ti));
	$args[1]=$db->lastInsertId();
	$show="User ".$args[1];
	$q=$db->prepare("UPDATE login SET username=:username WHERE id=:id");
	$q->execute(array(':username'=>$show,':id'=>$args[1]));
	$args[0]='edit';
}
if($args[0]=='edit'){
	$q=$db->prepare("SELECT * FROM login WHERE id=:id");
	$q->execute(array(':id'=>$args[1]));
	$r=$q->fetch(PDO::FETCH_ASSOC);?>
<div class="form-group">
	<label for="ti" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Created</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="ti" class="form-control textinput" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
	</div>
</div>
<div class="form-group">
	<label for="username" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Username</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="username" class="form-control textinput" value="<?php echo$r['username'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="username" placeholder="Enter a Username...">
	</div>
</div>
<div class="form-group">
	<label for="password" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Password</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="password" id="password" class="form-control textinput" value="<?php echo$r['password'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="password" placeholder="Enter a Password...">
	</div>
</div>
<div class="form-group">
	<label for="rank" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Rank</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
<?php if($r['rank']<1000){?>
		<select id="rank" class="form-control" onchange="update('<?php echo$r['id'];?>','login','rank',$(this).val());">
			<option value="0"<?php if($r['rank']==0)echo' selected';?>>Visitor</option>
			<option value="100"<?php if($r['rank']==100)echo' selected';?>>Subscriber</option>
			<option value="200"<?php if($r['rank']==200)echo' selected';?>>Member</option>
			<option value="300"<?php if($r['rank']==300)echo' selected';?>>Client</option>
			<option value="400"<?php if($r['rank']==400)echo' selected';?>>Contributor</option>
			<option value="500"<?php if($r['rank']==500)echo' selected';?>>Author</option>
			<option value="600"<?php if($r['rank']==600)echo' selected';?>>Editor</option>
			<option value="700"<?php if($r['rank']==700)echo' selected';?>>Moderator</option>
			<option value="800"<?php if($r['rank']==800)echo' selected';?>>Manager</option>
			<option value="900"<?php if($r['rank']==900)echo' selected';?>>Administrator</option>
<?php	if($_SESSION['rank']==1000){?>
			<option value="1000"<?php if($r['rank']==1000)echo' selected';?>>Developer</option>
<?php	}?>
		</select>
<?php }else{?>
		Developer
<?php }?>
	</div>
</div>
<?php if($r['rank']<1000){?>
<div class="well">
	<h4>Editing Permissions</h4>
	<div class="form-group">
		<div class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4 text-right">
			<input type="checkbox" id="options0" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="0"<?php if($r['options']{0}==1)echo' checked';?>><label for="options0">
		</div>
		<label for="options0" div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
			<strong>Add/Remove Content</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4 text-right">
			<input type="checkbox" id="options1" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="1"<?php if($r['options']{1}==1)echo' checked';?>><label for="options1">
		</div>
		<label for="options1" class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
			<strong>Edit Content</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4 text-right">
			<input type="checkbox" id="options2" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="2"<?php if($r['options']{2}==1)echo' checked';?>><label for="options2">
		</div>
		<label for="options2" class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
			<strong>Add/Edit Bookings</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4 text-right">
			<input type="checkbox" id="options3" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="3"<?php if($r['options']{3}==1)echo' checked';?>><label for="options3">
		</div>
		<label for="options3" class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
			<strong>Message Viewing/Editing</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4 text-right">
			<input type="checkbox" id="options4" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="4"<?php if($r['options']{4}==1)echo' checked';?>><label for="options4">
		</div>
		<label for="options4" div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
			<strong>Orders Viewing/Editing</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4 text-right">
			<input type="checkbox" id="options5" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="options" data-dbb="5"<?php if($r['options']{5}==1)echo' checked';?>><label for="options5">
		</div>
		<label for="options5" class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
			<strong>User Accounts Viewing/Editing</strong>
		</label>
	</div>
	<div class="form-group">
		<div for="options6" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4 text-right">
			<input type="checkbox" id="options6" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="6"<?php if($r['options']{6}==1)echo' checked';?>><label for="options6">
		</div>
		<label for="options6" class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
			<strong>SEO Viewing/Editing</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4 text-right">
			<input type="checkbox" id="options7" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="7"<?php if($r['options']{7}==1)echo' checked';?>><label for="options7">
		</div>
		<label for="options7" div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
			<strong>Preferences Viewing/Editing</strong>
		</label>
	</div>
</div>
<?php }?>
<div class="well">
	<form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
		<input type="hidden" name="id" value="<?php echo$r['id'];?>">
		<input type="hidden" name="act" value="add_avatar">
		<div class="form-group">
			<label for="avatar" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Avatar</label>
			<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
				<input type="file" name="fu" class="form-control">
				<div class="input-group-btn">
					<button class="btn btn-default" type="submit">Upload</button>
				</div>
			</div>
		</div>
	</form>
	<div class="form-group">
		<label for="gravatar" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Gravatar</label>
		<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
			<input type="text" id="gravatar" class="form-control textinput" value="<?php echo$r['gravatar'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="gravatar" placeholder="Enter Gravatar Link...">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">&nbsp;</label>
		<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
			<div class="alert alert-info">
				<a target="_blank" href="http://www.gravatar.com/">Gravatar</a> Link will override any image uploaded as your Avatar.
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="email" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Email</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="email" placeholder="Enter an Email...">
	</div>
</div>
<div class="form-group">
	<label for="name" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Name</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="name" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="name" placeholder="Enter a Name...">
	</div>
</div>
<div class="form-group">
	<label for="url" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">URL</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="url" placeholder="Enter a URL...">
	</div>
</div>
<div class="form-group">
	<label for="business" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Business</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="business" placeholder="Enter a Business...">
	</div>
</div>
<div class="form-group">
	<label for="phone" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Phone</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="phone" class="form-control textinput" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="phone" placeholder="Enter a Phone Number...">
	</div>
</div>
<div class="form-group">
	<label for="mobile" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Mobile</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="mobile" class="form-control textinput" value="<?php echo$r['mobile'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="mobile" placeholder="Enter a Mobile Number...">
	</div>
</div>
<div class="form-group">
	<label for="address" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Address</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="address" placeholder="Enter an Address...">
	</div>
</div>
<div class="form-group">
	<label for="suburb" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Suburb</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="suburb" placeholder="Enter a Suburb...">
	</div>
</div>
<div class="form-group">
	<label for="city" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">City</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="city" placeholder="Enter a City...">
	</div>
</div>
<div class="form-group">
	<label for="state" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">State</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="state" placeholder="Enter a State...">
	</div>
</div>
<div class="form-group">
	<label for="postcode" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Postcode</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php if($r['postcode']!=0)echo$r['postcode'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="postcode" placeholder="Enter a Postcode...">
	</div>
</div>
<div class="form-group">
	<label for="order_notes" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">About</label>
	<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
		<form method="post" target="sp" action="core/update.php">
			<input type="hidden" name="id" value="<?php echo$r['id'];?>">
			<input type="hidden" name="t" value="login">
			<input type="hidden" name="c" value="notes">
			<textarea id="notes" class="form-control summernote" name="da"><?php echo$r['notes'];?></textarea>
		</form>
	</div>
</div>
<div class="well">
	<h4>Social Networking</h4>
	<div class="form-group">
		<label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">&nbsp;</label>
		<form target="sp" method="post" action="core/add_data.php">
			<input type="hidden" name="user" value="<?php echo$r['id'];?>">
			<input type="hidden" name="act" value="add_social">
			<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
				<span class="input-group-addon">Network</span>
				<select class="form-control" name="icon">
					<option value="">None</option>
					<option value="500px">500px</option>
					<option value="behance-square">Behance</option>
					<option value="blogger">Blogger</option>
					<option value="delicious">Delcicious</option>
					<option value="deviantart">DeviantArt</option>
					<option value="dribble">Dribble</option>
					<option value="facebook-square">Facebook</option>
					<option value="flickr">Flickr</option>
					<option value="forrst">Forrst</option>
					<option value="github-square">GitHub</option>
					<option value="google-plus-square">Google+</option>
					<option value="instagram">Instagram</option>
					<option value="lastfm-square">LastFM</option>
					<option value="linkedin-square">Linkedin</option>
					<option value="livejournal">LiveJournal</option>
					<option value="myspace">MySpace</option>
					<option value="pied-piper">Pied Piper</option>
					<option value="pinterest-square">Pinterest</option>
					<option value="skype">Skype</option>
					<option value="stack-overflow">StackOverflow</option>
					<option value="stumbleupon-circle">StumbleUpon</option>
					<option value="tumblr-square">Tumblr</option>
					<option value="twitter-square">Twitter</option>
					<option value="vimeo-square">Vimeo</option>
					<option value="youtube-square">YouTube</option>
				</select>
				<div class="input-group-addon">URL</div>
				<input type="text" class="form-control" name="url" value="" placeholder="Enter a URL...">
				<div class="input-group-btn">
					<button class="btn btn-default"><?php if($config['buttonType']=='text')echo'Add';else echo'<i class="libre libre-plus color-success"></i>';?></button>
				</div>
			</div>
		</form>
	</div>
	<div id="social">
<?php $ss=$db->prepare("SELECT * FROM choices WHERE uid=:uid ORDER BY icon ASC");
	$ss->execute(array(':uid'=>$r['id']));
	while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
		<div id="l_<?php echo$rs['id'];?>" class="form-group">
			<label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">&nbsp;</label>
			<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
				<div class="input-group-addon">Network:</div>
				<div class="input-group-addon"><?php if($config['buttonType']=='text')echo ucfirst($rs['icon']);else echo'<i class="libre libre-brand-'.$rs['icon'];?>"></i>';?></div>
				<div class="input-group-addon">URL:</div>
				<input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','social','url',$(this).val());" placeholder="Enter a URL...">
				<div class="input-group-btn">
					<form target="sp" action="core/purge.php">
						<input type="hidden" name="id" value="<?php echo$rs['id'];?>">
						<input type="hidden" name="t" value="choices">
						<button class="btn btn-default"><?php if($config['buttonType']=='text')echo'<span class="color-danger">Delete</span>';else echo'<i class="libre libre-trash color-danger"></i>';?></button>
					</form>
				</div>
			</div>
		</div>
<?php }?>
	</div>
</div>
<?php }else{?>
<div class="table-responsive">
	<table id="stupidtable" class="table table-condensed">
		<thead>
			<tr>
				<th data-sort="string">Username</th>
				<th data-sort="string">Name</th>
				<th class="hidden-xs" data-sort="string">Email</th>
				<th class="col-sm-2 hidden-xs">Rank</th>
				<th class="col-sm-3 text-right">
					Show <div class="btn-group">
						<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"><?php if(!isset($args[1])||$args[1]=='')echo'All';else echo ucfirst($args[1]);?> <i class="caret"></i></button>
						<ul class="dropdown-menu pull-right">
							<li><a href="<?php echo URL.'admin/accounts';?>">All</a></li>
							<li><a href="<?php echo URL.'admin/accounts/type/subscriber';?>">Subscriber</a></li>
							<li><a href="<?php echo URL.'admin/accounts/type/member';?>">Member</a></li>
							<li><a href="<?php echo URL.'admin/accounts/type/client';?>">Client</a></li>
							<li><a href="<?php echo URL.'admin/accounts/type/contributor';?>">Contributor</a></li>
							<li><a href="<?php echo URL.'admin/accounts/type/author';?>">Author</a></li>
							<li><a href="<?php echo URL.'admin/accounts/type/editor';?>">Editor</a></li>
							<li><a href="<?php echo URL.'admin/accounts/type/moderator';?>">Moderator</a></li>
							<li><a href="<?php echo URL.'admin/accounts/type/manager';?>">Manager</a></li>
							<li><a href="<?php echo URL.'admin/accounts/type/administrator';?>">Administrator</a></li>
						</ul>
					</div>
				</th>
			</tr>
		</thead>
		<tbody>
<?php 
if($args[0]=='type'){
	if(isset($args[1])){
		$rank=0;
		if($args[1]=='subscriber')$rank=100;
		if($args[1]=='member')$rank=200;
		if($args[1]=='client')$rank==300;
		if($args[1]=='contributor')$rank=400;
		if($args[1]=='author')$rank=500;
		if($args[1]=='editor')$rank=600;
		if($args[1]=='moderator')$rank=700;
		if($args[1]=='manager')$rank=800;
		if($args[1]=='administrator')$rank=900;
	}
	$s=$db->prepare("SELECT * FROM login WHERE rank=:rank ORDER BY ti ASC");
	$s->execute(array(':rank'=>$rank+1));
}else{
	$s=$db->prepare("SELECT * FROM login WHERE rank<:rank ORDER BY ti ASC");
	$s->execute(array(':rank'=>$_SESSION['rank']+1));
}
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
			<tr id="l_<?php echo$r['id'];?>" class="placeholder<?php if($r['status']=='delete')echo' danger';?>">
				<td><?php echo$r['username'];?></td>
				<td><?php echo$r['name'];?></td>
				<td class="hidden-xs"><a href="mailto:<?php echo$r['email'];?>"><?php echo$r['email'];?></a></td>
				<td class="hidden-xs">
<?php if($r['rank']==100)echo'Subscriber';
	elseif($r['rank']==200)echo'Member';
	elseif($r['rank']==300)echo'Client';
	elseif($r['rank']==400)echo'Contributor';
	elseif($r['rank']==500)echo'Author';
	elseif($r['rank']==600)echo'Editor';
	elseif($r['rank']==700)echo'Moderator';
	elseif($r['rank']==800)echo'Manager';
	elseif($r['rank']==900)echo'Administrator';
	elseif($r['rank']==1000)echo'Developer';
	else echo'Visitor';?>
				</td>
				<td id="controls_<?php echo$r['id'];?>" class="text-right">
					<a class="btn btn-default btn-xs<?php if($r['status']=='delete')echo' hidden';?>" href="admin/accounts/edit/<?php echo$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';if($config['buttonType']=='text')echo'>Edit';else echo'><i class="libre libre-edit"></i>';?></a> 
					<button class="btn btn-default btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','login','status','')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';if($config['buttonType']=='text')echo'>Restore';else echo'><i class="libre libre-email-reply color-success"></i>';?></button> 
					<button class="btn btn-default btn-xs<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','login','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';if($config['buttonType']=='text')echo'>Delete';else echo'><i class="libre libre-trash color-danger"></i>';?></button> 
<?php	if($_SESSION['rank']>399&&$user['options']{5}==1){?>
					<button class="btn btn-default btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','login')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';if($config['buttonType']=='text')echo'>Purge';else echo'><i class="libre libre-email-forward color-danger"></i>';?></button>
<?php	}?>
				</td>
			</tr>
<?php }?>
		</tbody>
	</table>
</div>
<?php }
