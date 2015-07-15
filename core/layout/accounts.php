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
	<label for="ti" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Created</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="ti" class="form-control textinput" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
	</div>
</div>
<div class="form-group">
	<label for="username" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Username</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="username" class="form-control textinput" value="<?php echo$r['username'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="username" placeholder="Enter a Username...">
	</div>
</div>
<div class="form-group">
	<label for="password" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Password</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="password" id="password" class="form-control textinput" value="<?php echo$r['password'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="password" placeholder="Enter a Password...">
	</div>
</div>
<div class="form-group">
	<label for="rank" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Rank</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
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
		<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
			<input type="checkbox" id="options0" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="0"<?php if($r['options']{0}==1)echo' checked';?>><label for="options0">
		</div>
		<label for="options0" div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<strong>Add/Remove Content</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
			<input type="checkbox" id="options1" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="1"<?php if($r['options']{1}==1)echo' checked';?>><label for="options1">
		</div>
		<label for="options1" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<strong>Edit Content</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
			<input type="checkbox" id="options2" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="2"<?php if($r['options']{2}==1)echo' checked';?>><label for="options2">
		</div>
		<label for="options2" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<strong>Add/Edit Bookings</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
			<input type="checkbox" id="options3" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="3"<?php if($r['options']{3}==1)echo' checked';?>><label for="options3">
		</div>
		<label for="options3" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<strong>Message Viewing/Editing</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
			<input type="checkbox" id="options4" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="4"<?php if($r['options']{4}==1)echo' checked';?>><label for="options4">
		</div>
		<label for="options4" div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<strong>Orders Viewing/Editing</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
			<input type="checkbox" id="options5" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="options" data-dbb="5"<?php if($r['options']{5}==1)echo' checked';?>><label for="options5">
		</div>
		<label for="options5" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<strong>User Accounts Viewing/Editing</strong>
		</label>
	</div>
	<div class="form-group">
		<div for="options6" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
			<input type="checkbox" id="options6" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="6"<?php if($r['options']{6}==1)echo' checked';?>><label for="options6">
		</div>
		<label for="options6" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<strong>SEO Viewing/Editing</strong>
		</label>
	</div>
	<div class="form-group">
		<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
			<input type="checkbox" id="options7" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="7"<?php if($r['options']{7}==1)echo' checked';?>><label for="options7">
		</div>
		<label for="options7" div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<strong>Preferences Viewing/Editing</strong>
		</label>
	</div>
</div>
<?php }?>
<fieldset class="control-fieldset">
	<legend class="control-legend">Cover and Avatar</legend>
	<div id="coverimg" class="col-xs-7 col-sm-9 col-md-9 col-lg-10 no-padding pull-right"><?php if($r['cover']!=''&&file_exists('media/'.$r['cover']))echo'<img src="media/'.$r['cover'].'">';elseif(file_exists('media/'.$r['coverURL']))echo'<img src="media/'.$r['coverURL'].'">';elseif($r['coverURL']!='')echo'<img src="'.$r['coverURL'].'">';?></div>
	<div class="clearfix"></div>
	<div class="form-group">
		<label for="cover" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Cover</label>
		<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<div class="input-group-addon">URL</div>
			<input type="text" id="coverURL" class="form-control" value="<?php echo$r['coverURL'];?>" onchange="coverUpdate('<?php echo$r['id'];?>','login','coverURL',$(this).val());" placeholder="Enter Cover URL...">
			<div class="input-group-btn">
				<a class="btn btn-default" data-toggle="modal" data-target="#media" href="core/edit_image.php?id=<?php echo$r['id'];?>&t=login&c=coverURL">Edit</a>
				<button class="btn btn-default color-danger" onclick="coverUpdate('<?php echo$r['id'];?>','login','coverURL','');">Delete</button>
			</div>
		</div>
		<div class="help-block col-xs-10 pull-right">
			Editing a URL Image will retreive the image to the server for Editing.
		</div>
		<div class="input-group col-xs-10 pull-right">
			<input type="text" id="cover" class="form-control" value="<?php echo$r['cover'];?>" disabled>
			<div class="input-group-btn">
				<form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
					<input type="hidden" name="id" value="<?php echo$r['id'];?>">
					<input type="hidden" name="act" value="add_cover">
					<input type="hidden" name="t" value="login">
					<input type="hidden" name="c" value="cover">
					<span class="btn btn-default btn-file">Browse for Images<input type="file" name="fu"<?php if($user['options']{1}==0)echo' disabled';?>></span>
					<button class="btn btn-default<?php if($user['options']{1}==0)echo' disabled';?>" onclick="$('#block').css({'display':'block'});">Upload</button>
				</form>
			</div>
			<div class="input-group-btn">
				<a class="btn btn-default" data-toggle="modal" data-target="#media" href="core/browse_media.php?id=<?php echo$r['id'];?>&t=login&c=cover">Browse Uploaded Images</a>
				<a class="btn btn-default" data-toggle="modal" data-target="#media" href="core/edit_image.php?id=<?php echo$r['id'];?>&t=login&c=cover">Edit</a>
				<button class="btn btn-default color-danger" onclick="coverUpdate('<?php echo$r['id'];?>','login','cover','');">Delete</button>
			</div>
		</div>
	</div>
	<div class="help-block col-xs-7 col-sm-9 col-md-9 col-lg-10 pull-right">
		Uploaded Images take Precedence over URL's.
	</div>
	<div class="clearfix"></div>
	<div class="well col-xs-10 pull-right">
		<h4>Image Attribution</h4>
		<div class="form-group">
			<label for="attributionImageTitle" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Title</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="attributionImageTitle" placeholder="Enter Image Title...">
			</div>
		</div>
		<div class="form-group">
			<label for="attributionImageName" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Name</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="attributionImageName" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="attributionImageName" placeholder="Enter Image Author's Name...">
			</div>
		</div>
		<div class="form-group">
			<label for="attributionImageURL" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">URL</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="attributionImageURL" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="attributionImageURL" placeholder="Enter Image Author's URL...">
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="form-group">
		<label for="avatar" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Avatar</label>
		<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<input type="text" class="form-control" value="<?php echo$r['avatar'];?>" disabled>
			<div class="input-group-btn">
				<form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
					<input type="hidden" name="id" value="<?php echo$r['id'];?>">
					<input type="hidden" name="act" value="add_avatar">
					<span class="btn btn-default btn-file">Browse for Images<input type="file" name="fu"<?php if($user['options']{1}==0)echo' disabled';?>></span>
					<button class="btn btn-default" type="submit">Upload</button>
				</form>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="gravatar" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Gravatar</label>
		<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
			<input type="text" id="gravatar" class="form-control textinput" value="<?php echo$r['gravatar'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="gravatar" placeholder="Enter Gravatar Link...">
		</div>
		<div class="help-block col-xs-7 col-sm-9 col-md-9 col-lg-10 pull-right">
			<a target="_blank" href="http://www.gravatar.com/">Gravatar</a> Link will override any image uploaded as your Avatar.
		</div>
	</div>
</fieldset>
<div class="form-group">
	<label for="email" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Email</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="email" placeholder="Enter an Email...">
	</div>
</div>
<div class="form-group">
	<label for="name" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Name</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="name" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="name" placeholder="Enter a Name...">
	</div>
</div>
<div class="form-group">
	<label for="url" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">URL</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="url" placeholder="Enter a URL...">
	</div>
</div>
<div class="form-group">
	<label for="business" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Business</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="business" placeholder="Enter a Business...">
	</div>
</div>
<div class="form-group">
	<label for="phone" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Phone</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="phone" class="form-control textinput" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="phone" placeholder="Enter a Phone Number...">
	</div>
</div>
<div class="form-group">
	<label for="mobile" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Mobile</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="mobile" class="form-control textinput" value="<?php echo$r['mobile'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="mobile" placeholder="Enter a Mobile Number...">
	</div>
</div>
<div class="form-group">
	<label for="address" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Address</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="address" placeholder="Enter an Address...">
	</div>
</div>
<div class="form-group">
	<label for="suburb" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Suburb</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="suburb" placeholder="Enter a Suburb...">
	</div>
</div>
<div class="form-group">
	<label for="city" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">City</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="city" placeholder="Enter a City...">
	</div>
</div>
<div class="form-group">
	<label for="state" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">State</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="state" placeholder="Enter a State...">
	</div>
</div>
<div class="form-group">
	<label for="postcode" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Postcode</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
		<input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php if($r['postcode']!=0)echo$r['postcode'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="postcode" placeholder="Enter a Postcode...">
	</div>
</div>
<div class="form-group">
	<label for="order_notes" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">About</label>
	<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
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
		<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">&nbsp;</label>
		<form target="sp" method="post" action="core/add_data.php">
			<input type="hidden" name="user" value="<?php echo$r['id'];?>">
			<input type="hidden" name="act" value="add_social">
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<span class="input-group-addon">Network</span>
				<select class="form-control" name="icon">
					<option value="">None</option>
					<option value="500px">500px</option>
					<option value="delicious">Delcicious</option>
					<option value="deviantart">DeviantArt</option>
					<option value="facebook">Facebook</option>
					<option value="github">GitHub</option>
					<option value="google-plus">Google+</option>
					<option value="instagram">Instagram</option>
					<option value="lastfm">LastFM</option>
					<option value="linkedin">Linkedin</option>
					<option value="livejournal">LiveJournal</option>
					<option value="myspace">MySpace</option>
					<option value="pinterest">Pinterest</option>
					<option value="skype">Skype</option>
					<option value="stack-overflow">StackOverflow</option>
					<option value="stumbleupon">StumbleUpon</option>
					<option value="tumblr">Tumblr</option>
					<option value="twitter">Twitter</option>
					<option value="vimeo">Vimeo</option>
					<option value="youtube">YouTube</option>
				</select>
				<div class="input-group-addon">URL</div>
				<input type="text" class="form-control" name="url" value="" placeholder="Enter a URL...">
				<div class="input-group-btn">
					<button class="btn btn-default color-success"><?php if($config['buttonType']=='text')echo'Add';else echo'<i class="libre libre-plus"></i>';?></button>
				</div>
			</div>
		</form>
	</div>
	<div id="social">
<?php $ss=$db->prepare("SELECT * FROM choices WHERE contentType='social' AND uid=:uid ORDER BY icon ASC");
	$ss->execute(array(':uid'=>$r['id']));
	while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
		<div id="l_<?php echo$rs['id'];?>" class="form-group">
			<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">&nbsp;</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<div class="input-group-addon">Network:</div>
				<div class="input-group-addon"><?php if($config['buttonType']=='text')echo ucfirst($rs['icon']);else echo'<i class="libre libre-brand-'.$rs['icon'].'"></i>';?></div>
				<div class="input-group-addon">URL:</div>
				<input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','social','url',$(this).val());" placeholder="Enter a Social Network URL...">
				<div class="input-group-btn">
					<form target="sp" action="core/purge.php">
						<input type="hidden" name="id" value="<?php echo$rs['id'];?>">
						<input type="hidden" name="t" value="choices">
						<button class="btn btn-default color-danger"><?php if($config['buttonType']=='text')echo'Delete';else echo'<i class="libre libre-trash color-danger"></i>';?></button>
					</form>
				</div>
			</div>
		</div>
<?php }?>
	</div>
</div>
<?php }else{?>
<div class="text-right">
	<div class="btn-group" data-toggle="buttons">
		<label class="btn btn-default<?php if($config['layoutAccounts']=='cards')echo' active';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Users as Cards."';?>><input type="radio" name="options" id="option1" autocomplete="off" onchange="update('1','config','layoutAccounts','cards');reload('content');"<?php if($config['layoutAccounts']=='cards')echo' checked';if($config['buttonType']=='text')echo'>Cards';else echo'><i class="libre libre-display-layout-blocks"></i>';?></label>
		<label class="btn btn-default<?php if($config['layoutAccounts']=='table')echo' active';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Users as Table."';?>><input type="radio" name="options" id="option2" autocomplete="off" onchange="update('1','config','layoutAccounts','table');reload('content');"<?php if($config['layoutAccounts']=='table')echo' checked';if($config['buttonType']=='text')echo'>Table';else echo'><i class="libre libre-display-layout-table"></i>';?></label>
	</div>
<?php if($user['rank']==1000||$user['options']{0}==1){?>
	<div class="dropdown pull-right">
		<a class="btn btn-default" href="<?php echo URL;?>admin/accounts/add"><?php if($config['buttonType']=='text')echo'<small>Add</small>';else echo'<i class="libre libre-plus color-success"></i>';?></a>
	</div>
<?php }?>
</div>
<?php if($args[0]=='type'){
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
	if($config['layoutAccounts']=='table'){?>
<div class="table-responsive">
	<table id="stupidtable" class="table table-condensed table-hover">
		<thead>
			<tr>
				<th data-sort="string">Username</th>
				<th data-sort="string">Name</th>
				<th class="hidden-xs" data-sort="string">Email</th>
				<th class="col-sm-2 hidden-xs" data-sort="string">Rank</th>
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
<?php	while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
			<tr id="l_<?php echo$r['id'];?>" class="placeholder<?php if($r['status']=='delete')echo' danger';?>">
				<td><?php echo$r['username'];?></td>
				<td><?php echo$r['name'];?></td>
				<td class="hidden-xs"><a href="mailto:<?php echo$r['email'];?>"><?php echo$r['email'];?></a></td>
				<td class="hidden-xs">
<?php		if($r['rank']==100)echo'Subscriber';
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
<?php		if($_SESSION['rank']>399&&$user['options']{5}==1){?>
					<button class="btn btn-default btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','login')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';if($config['buttonType']=='text')echo'>Purge';else echo'><i class="libre libre-email-forward color-danger"></i>';?></button>
<?php		}?>
				</td>
			</tr>
<?php	}?>
		</tbody>
	</table>
</div>
<?php }else{?>
<div class="row col-xs-12">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
	<div id="l_<?php echo$r['id'];?>" class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<div class="panel panel-default">
			<div class="badger badger-right" data-status="<?php if($r['active']==1)echo'active';else echo'inactive';?>" data-contenttype="<?php if($r['active']==1)echo'active';else echo'inactive';?>"></div>
			<div class="panel-image" data-status="<?php if($r['active']==1)echo'success';else echo'danger';?>">
				<img src="<?php if($r['cover']!=''&&file_exists('media/'.$r['cover']))echo'media/'.$r['cover'];elseif($r['coverURL']!=''&&file_exists('media/'.$r['coverURL']))echo'media/'.$r['coverURL'];elseif($r['coverURL']!='')echo$r['coverURL'];?>">
				<img class="avatar img-thumbnail" src="<?php if($r['gravatar']!='')echo$r['gravatar'];elseif($r['avatar']!=''&&file_exists('media/avatar/'.$r['avatar']))echo'media/avatar/'.$r['avatar'];else echo$noavatar;?>">
				<div class="panel-title text-right"><small class="color-white"><?php echo$r['username'].':'.$r['name'];?></small></div>
			</div>
			<div id="controls_<?php echo$r['id'];?>" class="panel-footer text-right">
				<a class="btn btn-default btn-xs" href="admin/accounts/edit/<?php echo$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';if($config['buttonType']=='text')echo'>Edit';else echo'><i class="libre libre-edit"></i>';echo'</a>';
			if($user['rank']==1000||$user['options']{0}==1){?>
				<button class="btn btn-default btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','login','status','unpublished')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';if($config['buttonType']=='text')echo'>Restore';else echo'><i class="libre libre-email-reply color-success"></i>';?></button> 
				<button class="btn btn-default btn-xs<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','login','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';if($config['buttonType']=='text')echo'>Delete';else echo'><i class="libre libre-trash color-danger"></i>';?></button> 
				<button class="btn btn-default btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','login')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';if($config['buttonType']=='text')echo'>Purge';else echo'><i class="libre libre-email-forward color-danger"></i>';?></button>
<?php		}?>
			</div>
		</div>
	</div>
<?php	}
	}?>
</div>
<?php }
