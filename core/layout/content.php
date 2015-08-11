<?php
$rank=0;
$show='categories';
if($view=='add'){
	$ti=time();
	$schema='';
	$comments=0;
	if($args[0]=='article')$schema='blogPost';
	if($args[0]=='inventory')$schema='Product';
	if($args[0]=='service')$schema='Service';
	if($args[0]=='gallery')$schema='ImageGallery';
	if($args[0]=='testimonial')$schema='Review';
	if($args[0]=='news')$schema='NewsArticle';
	if($args[0]=='event')$schema='Event';
	if($args[0]=='portfolio')$schema='CreativeWork';
	if($args[0]=='proof')$schema='CreativeWork';$comments=1;
	$q=$db->prepare("INSERT INTO content (options,uid,login_user,contentType,schemaType,status,active,ti,eti) VALUES ('00000000',:uid,:login_user,:contentType,:schemaType,'unpublished','1',:ti,:ti)");
	if(isset($user['id']))$uid=$user['id'];else$uid=0;
	if($user['name']!='')$login_user=$user['name'];
	else$login_user=$user['username'];
	$q->execute(array(':contentType'=>$args[0],':uid'=>$uid,':login_user'=>$login_user,':schemaType'=>$schema,':ti'=>$ti));
	$id=$db->lastInsertId();
	$args[0]=ucfirst($args[0]).' '.$id;
	$s=$db->prepare("UPDATE content SET title=:title WHERE id=:id");
	$s->execute(array(':title'=>$args[0],':id'=>$id));
	if($view!='bookings')$show='item';
	$rank=0;
	$args[0]='edit';
	$args[1]=$id;
}
if($args[0]=='edit'){
	$s=$db->prepare("SELECT * FROM content WHERE id=:id");
	$s->execute(array(':id'=>$args[1]));
	$show='item';
}
if($show=='categories'){
	if($args[0]=='type'){
		$s=$db->prepare("SELECT * FROM content WHERE contentType=:contentType AND contentType!='message_primary' ORDER BY pin DESC,ti ASC,title ASC");
		$s->execute(array(':contentType'=>$args[1]));
	}else{
		if(isset($args[1])){
			$s=$db->prepare("SELECT * FROM content WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND contentType!='message_primary' ORDER BY pin DESC,ti ASC,title ASC");
			$s->execute(array(':category_1'=>str_replace('-',' ',$args[0]),':category_2'=>str_replace('-',' ',$args[1])));
		}elseif(isset($args[0])){
			$s=$db->prepare("SELECT * FROM content WHERE LOWER(category_1) LIKE LOWER(:category_1) AND contentType!='message_primary' ORDER BY pin DESC,ti ASC,title ASC");
			$s->execute(array(':category_1'=>str_replace('-',' ',$args[0])));
		}else{
			$s=$db->prepare("SELECT * FROM content WHERE contentType!='booking' AND contentType!='message_primary' ORDER BY pin DESC,ti ASC,title ASC");
			$s->execute();
		}
	}?>
<h1 class="page-header">
	Content
	<div class="pull-right">
		<div class="btn-group" data-toggle="buttons">
			<label class="btn btn-default<?php if($config['layoutContent']=='cards')echo' active';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Display Content as Cards."';?>><input type="radio" name="options" id="option1" autocomplete="off" onchange="update('1','config','layoutContent','cards');reload('content');"<?php if($config['layoutContent']=='calendar')echo' checked';if($config['buttonType']=='text')echo'>Cards';else echo'><i class="libre libre-display-layout-blocks"></i>';?></label>
			<label class="btn btn-default<?php if($config['layoutContent']=='table')echo' active';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Display Content as Table."';?>><input type="radio" name="options" id="option2" autocomplete="off" onchange="update('1','config','layoutContent','table');reload('content');"<?php if($config['layoutContent']=='table')echo' checked';if($config['buttonType']=='text')echo'>Table';else echo'><i class="libre libre-display-layout-table"></i>';?></label>
		</div>
		<div class="btn-group">
			<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Show Items by Content Type."';?>><i class="libre libre-view visible-xs"></i><span class="hidden-xs">Show</i> <i class="caret"></i></span></a>
			<ul class="dropdown-menu pull-right">
				<li><a href="<?php echo URL.'admin/content';?>">All</a></li>
<?php	$st=$db->query("SELECT DISTINCT contentType FROM content WHERE contentType!='booking' AND contentType!='message' AND contentType!='message_primary' ORDER BY contentType ASC");
		while($sr=$st->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.'admin/content/type/'.$sr['contentType'].'">'.ucfirst($sr['contentType']).'</a></li>';?>
			</ul>
		</div>
<?php if($user['rank']==1000||$user['options']{0}==1){?>
		<div class="btn-group">
			<a class="btn btn-success dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Show Items by Content Type."';?>>Add <i class="caret"></i></span></a>
			<ul class="dropdown-menu pull-right">
				<li><a href="<?php echo URL;?>admin/add/article">Article</a></li>
				<li><a href="<?php echo URL;?>admin/add/portfolio">Portfolio</a></li>
				<li><a href="<?php echo URL;?>admin/add/event">Event</a></li>
				<li><a href="<?php echo URL;?>admin/add/news">News</a></li>
				<li><a href="<?php echo URL;?>admin/add/testimonial">Testimonial</a></li>
				<li><a href="<?php echo URL;?>admin/add/inventory">Inventory</a></li>
				<li><a href="<?php echo URL;?>admin/add/service">Service</a></li>
				<li><a href="<?php echo URL;?>admin/add/gallery">Gallery</a></li>
				<li><a href="<?php echo URL;?>admin/add/proof">Proofs</a></li>
			</ul>
		</div>
<?php }?>
	</div>
</h1>
<div class="panel panel-default">
	<div class="panel-body">
<?php if($config['layoutContent']=='table'){?>
		<div class="table-responsive col-xs-12">
			<table id="stupidtable" class="table table-condensed table-hover">
				<thead>
					<tr>
						<th class="text-center" data-sort="string">contentType</th>
						<th class="text-center hidden-xs" data-sort="string">Created</th>
						<th class="text-center hidden-xs" data-sort="string">Edited</th>
						<th class="text-center" data-sort="string">Title</th>
						<th class="text-center hidden-xs" data-sort="string">Status</th>
						<th class="text-center hidden-xs" data-sort="int">Views</th>
						<th class="text-center hidden-xs">Featured</th>
						<th class="text-center hidden-xs">Internal</th>
						<th class="col-xs-2">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
<?php	while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
					<tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='delete')echo'danger';?>">
						<td class="text-center"><?php echo'<a class="btn btn-default btn-xs" href="'.URL.'/admin/content/type/'.$r['contentType'].'">'.ucfirst($r['contentType']).'</a>';?></td>
						<td class="text-center hidden-xs"><small><?php echo date($config['dateFormat'],$r['ti']);?></small></td>
						<td class="text-center hidden-xs"><small><?php echo date($config['dateFormat'],$r['eti']);?></small></td>
						<td><small><?php echo$r['title'];?></small></td>
						<td class="text-center hidden-xs">
							<div class="btn-group">
<?php		if($r['contentType']!='proofs'){?>
								<select id="status" class="btn btn-default btn-xs" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php if($user['options']{1}==0)echo' readonly';?>>
									<option value="unpublished"<?php if($r['status']=='unpublished')echo' selected';?>>Unpublished</option>
									<option value="published"<?php if($r['status']=='published')echo' selected';?>>Published</option>
									<option value="delete"<?php if($r['status']=='delete')echo' selected';?>>Delete</option>
								</select>
<?php		}?>
							</div>
						</td>
						<td class="text-center hidden-xs">
							<small><?php echo$r['views'];?></small>
						</td>
						<td class="text-center hidden-xs">
							<div class="btn-group">
<?php		if($r['contentType']!='proofs'){
				echo'<input type="checkbox" id="featured'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="featured" data-dbb="0"';if($r['featured']{0}==1)echo' checked';if($user['options']{1}==0)echo' readonly';echo'><label for="featured'.$r['id'].'">';
			}?>
							</div>
						</td>
						<td class="text-center hidden-xs">
							<div class="btn-group">
<?php		if($r['contentType']!='proofs'){
				echo'<input type="checkbox" id="internal'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="internal" data-dbb="0"';if($r['internal']==1)echo' checked';if($user['options']{1}==0)echo' readonly';echo'><label for="internal'.$r['id'].'">';
			}?>
							</div>
						</td>
						<td>
							<div id="controls_<?php echo$r['id'];?>" class="btn-group pull-right">
								<a id="pin<?php echo$r['id'];?>" class="btn btn-default btn-xs<?php if($r['pin']{0}==1)echo' btn-success';?>" onclick="pinToggle('<?php echo$r['id'];?>','content','pin','0')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Pin/Unpin to Top"';?>><i class="libre libre-pin"></i></a>
								<a class="btn btn-info btn-xs<?php if($r['status']=='delete')echo' hidden';?>" href="admin/content/edit/<?php echo$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><i class="libre libre-edit visible-xs"></i><span class="hidden-xs">Edit</span></a>
<?php		if($user['rank']==1000||$user['options']{0}==1){?>
								<button class="btn btn-warning btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><i class="libre libre-restore visible-xs"></i><span class="hidden-xs">Restore</span></button> 
								<button class="btn btn-danger btn-xs<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><i class="libre libre-trash visible-xs"></i><span class="hidden-xs">Delete</span></button> 
								<button class="btn btn-danger btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','content')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><i class="libre libre-purge visible-xs"></i><span class="hidden-xs">Purge</span></button>
<?php		}?>
							</div>
						</td>
					</tr>
<?php	}?>
				</tbody>
			</table>
		</div>
<?php }else{
	while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
		<div id="l_<?php echo$r['id'];?>" class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<div class="panel panel-default">
				<div class="badger badger-left text-shadow-depth-1" href="#" data-status="<?php echo$r['status'];?>" data-contenttype="<?php echo$r['contentType'];?>"></div>
				<div class="panel-image" data-status="<?php echo$r['status'];?>">
					<a href="admin/content/edit/<?php echo$r['id'];?>"><img src="<?php if($r['file']&&file_exists('media/'.$r['file']))echo'media/'.$r['file'];elseif($r['thumb']&&file_exists('media/'.$r['thumb']))echo'media'.$r['thumb'];elseif($r['fileURL']!=''&&file_exists('media/'.$r['fileURL']))echo'media/'.$r['fileURL'];elseif($r['fileURL']!='')echo$r['fileURL'];?>"></a>
					<h4 class="panel-title text-white"><?php echo$r['title'];?></h4>
				</div>
				<div class="panel-body panel-content">
					<p><?php echo strip_tags(substr($r['notes'],0,200));?></p>
				</div>
				<div class="panel-footer text-right">
<?php if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){
	$cnt=0;
	$sc=$db->prepare("SELECT COUNT(id) as cnt FROM comments WHERE rid=:id AND status='unapproved'");
	$sc->execute(array(':id'=>$r['id']));
	$cnt=$sc->fetch(PDO::FETCH_ASSOC);?>
					<a class="btn btn-default btn-xs" href="admin/content/edit/<?php echo$r['id'];?>#comments"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Comments"';?>><i class="libre libre-comments"></i> <?php echo$cnt['cnt'];?></a>
					<span class="btn btn-default btn-xs"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Views"';?>><i class="libre libre-view"></i> <?php echo$r['views'];?></span>
<?php	}else echo'&nbsp;';?>
				</div>
				<div id="controls_<?php echo$r['id'];?>" class="btn-group panel-controls">
					<a id="pin<?php echo$r['id'];?>" class="btn btn-default btn-xs<?php if($r['pin']{0}==1)echo' btn-success';?>" onclick="pinToggle('<?php echo$r['id'];?>','content','pin','0')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Pin/Unpin to Top"';?>><i class="libre libre-pin"></i></a>
					<a class="btn btn-info btn-xs" href="admin/content/edit/<?php echo$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><i class="libre libre-edit"></i></a>
<?php		if($user['rank']==1000||$user['options']{0}==1){?>
					<button class="btn btn-warning btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><i class="libre libre-restore"></i></button>
					<button class="btn btn-danger btn-xs<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><i class="libre libre-trash"></i></button>
					<button class="btn btn-danger btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','content')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><i class="libre libre-purge"></i></button>
<?php		}?>
				</div>
			</div>
		</div>
<?php	}
	}?>
	</div>
</div>
<?php }
	if($show=='item'){
		$r=$s->fetch(PDO::FETCH_ASSOC);?>
<h1 class="page-header">
	Content
	<div class="btn-group pull-right">
		<a class="btn btn-success" href="<?php echo URL.'admin/content/type/'.$r['contentType'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><i class="libre libre-back visible-xs"></i><span class="hidden-xs">Back<span></a>
	</div>
</div>
</h1>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-group">
			<label for="title" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Title</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=1"><i class="libre libre-help text-danger"></i></a></div>';?>
				<input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title"<?php if($user['options']{1}==0)echo' readonly';if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
			</div>
		</div>
<?php if($r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='inventory'||$r['contentType']=='services'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'){?>
		<div class="form-group">
			<label for="published" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Status</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php if($user['options']{1}==0)echo' readonly';if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
					<option value="unpublished"<?php if($r['status']=='unpublished')echo' selected';?>>Unpublished</option>
					<option value="published"<?php if($r['status']=='published')echo' selected';?>>Published</option>
					<option value="delete"<?php if($r['status']=='delete')echo' selected';?>>Delete</option>
				</select>
			</div>
		</div>
<?php }?>
		<div class="form-group">
			<label for="ti" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Created</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
			</div>
		</div>
		<div class="form-group">
			<label for="eti" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Edited</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="eti" class="form-control" value="<?php echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?>" readonly>
			</div>
		</div>
		<div class="form-group">
			<label for="views" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Views</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="views"<?php if($user['options']{1}==0)echo' readonly';if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
			</div>
		</div>
		<div class="form-group">
			<label for="contentType" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">contentType</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<select id="contentType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','contentType',$(this).val());"<?php if($user['options']{1}==0)echo' disabled';if($config['options']{4}==1)echo' data-toggle="tooltip" title="Change the Type of Content this Item belongs to."';?>>
					<option value="article"<?php if($r['contentType']=='article')echo' selected';?>>Article</option>
					<option value="portfolio"<?php if($r['contentType']=='portfolio')echo' selected';?>>Portfolio</option>
					<option value="booking"<?php if($r['contentType']=='booking')echo' selected';?>>Booking</option>
					<option value="events"<?php if($r['contentType']=='events')echo' selected';?>>Event</option>
					<option value="news"<?php if($r['contentType']=='news')echo' selected';?>>News</option>
					<option value="testimonials"<?php if($r['contentType']=='testimonials')echo' selected';?>>Testimonial</option>
					<option value="inventory"<?php if($r['contentType']=='inventory')echo' selected';?>>Inventory</option>
					<option value="service"<?php if($r['contentType']=='service')echo' selected';?>>Service</option>
					<option value="gallery"<?php if($r['contentType']=='gallery')echo' selected';?>>Gallery</option>
					<option value="proofs"<?php if($r['contentType']=='proofs')echo' selected';?>>Proofs</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="schemaType" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">schemaType</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=2"><i class="libre libre-help text-danger"></i></a></div>';?>
				<select id="schemaType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','schemaType',$(this).val());"<?php if($user['options']{1}==0)echo' disabled';if($config['options']{4}==1)echo' data-toggle="tooltip" title="Schema for Microdata Content"';?>>
					<option value="blogPost"<?php if($r['schemaType']=='blogPost')echo' selected';?>>blogPost -> for Articles</option>
					<option value="Product"<?php if($r['schemaType']=='Product')echo' selected';?>>Product -> for Inventory</option>
					<option value="Service"<?php if($r['schemaType']=='Service')echo' selected';?>>Service -> for Services</option>
					<option value="ImageGallery"<?php if($r['schemaType']=='ImageGallery')echo' selected';?>>ImageGallery -> for Gallery Images</option>
					<option value="Review"<?php if($r['schemaType']=='Review')echo' selected';?>>Review -> for Testimonials</option>
					<option value="NewsArticle"<?php if($r['schemaType']=='NewsArticle')echo' selected';?>>NewsArticle -> for News</option>
					<option value="Event"<?php if($r['schemaType']=='Event')echo' selected';?>>Event -> for Events</option>
					<option value="CreativeWork"<?php if($r['schemaType']=='CreativeWork')echo' selected';?>>CreativeWork -> for Portfolio/Proofs</option>
				</select>
			</div>
		</div>
<?php if($r['contentType']=='proofs'){?>
		<div class="form-group">
			<label for="cid" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Client</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<select id="cid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','cid',$(this).val());"<?php if($user['options']{1}==0)echo' disabled';?>>
					<option value="0">Select a Client...</option>
<?php	$cs=$db->query("SELECT * FROM login ORDER BY name ASC, username ASC");
		while($cr=$cs->fetch(PDO::FETCH_ASSOC)){?>
					<option value="<?php echo$cr['id'];?>"<?php if($r['cid']==$cr['id'])echo' selected';?>><?php echo$cr['username'].':'.$cr['name'];?></option>
<?php	}?>
				</select>
			</div>
		</div>
<?php }
	if($r['contentType']=='article'){?>
		<div class="form-group">
			<label for="author" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Author</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=3"><i class="libre libre-help text-danger"></i></a></div>';?>
				<select id="uid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','uid',$(this).val());"<?php if($user['options']{1}==0)echo' disabled';?>>
<?php	$su=$db->query("SELECT id,username,name FROM login WHERE username!='' AND status!='delete' ORDER BY username ASC, name ASC");
		while($ru=$su->fetch(PDO::FETCH_ASSOC)){?>
					<option value="<?php echo$ru['id'];?>"<?php if($ru['id']==$r['uid'])echo' selected';echo'>'.$ru['username'].':'.$ru['name'];?></option>
<?php	}?>
				</select>
			</div>
		</div>
<?php }
	if($r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='inventory'||$r['contentType']=='portfolio'||$r['contentType']=='proofs'||$r['contentType']=='services'){?>
		<fieldset class="control-fieldset">
			<legend class="control-legend">Image</legend>
			<div class="form-group">
				<label for="file" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Image</label>
				<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=4"><i class="libre libre-help text-danger"></i></a></div>';?>
					<div class="input-group-addon">URL</div>
					<input type="text" id="fileURL" class="form-control textinput" value="<?php echo$r['fileURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fileURL" placeholder="Enter File URL...">
					<div class="input-group-btn">
						<a class="btn btn-info" data-toggle="modal" data-target="#media" href="core/edit_image.php?id=<?php echo$r['id'];?>&t=content&c=fileURL"><i class="libre libre-edit visible-xs"></i><span class="hidden-xs">Edit<span></a>
						<button class="btn btn-danger" onclick="imageUpdate('<?php echo$r['id'];?>','content','fileURL');"><i class="libre libre-trash visible-xs"></i><span class="hidden-xs">Delete</span></button>
					</div>
				</div>
				<div class="help-block col-xs-10 pull-right">
					Editing a URL Image will retreive the image to the server for Editing.
				</div>
				<form method="post" target="sp" enctype="multipart/form-data" action="core/add_data.php">
					<div class="input-group col-xs-10 pull-right">
						<input type="text" class="form-control" value="<?php echo$r['file'];?>" disabled>
						<input type="hidden" name="id" value="<?php echo$r['id'];?>">
						<input type="hidden" name="act" value="add_image">
						<input type="hidden" name="t" value="content">
						<input type="hidden" name="c" value="file">
						<div class="input-group-btn">
							<span class="btn btn-default btn-file"><i class="libre libre-browse-media visible-xs"></i><span class="hidden-xs">Browse for Images</span><input type="file" name="fu"<?php if($user['options']{1}==0)echo' disabled';?>></span>
							<button class="btn btn-success<?php if($user['options']{1}==0)echo' disabled';?>" onclick="$('#block').css({'display':'block'});"><i class="libre libre-upload visible-xs"></i><span class="hidden-xs">Upload</span></button>
							<a class="btn btn-default" data-toggle="modal" data-target="#media" href="core/browse_media.php?id=<?php echo$r['id'];?>&t=content&c=file"><i class="libre libre-browse-media visible-xs"></i><span class="hidden-xs">Browse Uploaded Media</span></a>
						</div>
						<div id="file" class="input-group-addon">
<?php	if($r['file']!=''&&file_exists('media/'.$r['file']))echo'<a href="media/'.$r['file'].'" data-featherlight="image"><img src="media/'.$r['file'].'"></a>';
		elseif($r['fileURL']!=''&&file_exists('media/'.$r['fileURL']))echo'<a href="media/'.$r['fileURL'].'" data-featherlight="image"><img src="media/'.$r['fileURL'].'"></a>';
		elseif($r['fileURL']!='')echo'<a href="'.$r['fileURL'].'" data-featherlight="image"><img src="'.$r['fileURL'].'"></a>';
		else echo'<img src="core/images/noimage.jpg">';?>
						</div>
						<div class="input-group-btn">
							<a class="btn btn-info" data-toggle="modal" data-target="#media" href="core/edit_image.php?id=<?php echo$r['id'];?>&t=content&c=file"><i class="libre libre-edit visible-xs"></i><span class="hidden-xs">Edit</span></a>
							<button class="btn btn-danger" onclick="imageUpdate('<?php echo$r['id'];?>','content','file');"><i class="libre libre-trash visible-xs"></i><span class="hidden-xs">Delete</span></button>
						</div>
					</div>
				</form>
			</div>
			<div class="clearfix"></div>
			<br>
			<div class="form-group">
				<label for="thumb" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Thumb</label>
				<form method="post" target="sp" enctype="multipart/form-data" action="core/add_data.php">
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" class="form-control" value="<?php echo$r['thumb'];?>" disabled>
						<input type="hidden" name="id" value="<?php echo$r['id'];?>">
						<input type="hidden" name="act" value="add_image">
						<input type="hidden" name="t" value="content">
						<input type="hidden" name="c" value="thumb">
						<div class="input-group-btn">
							<span class="btn btn-default btn-file"><i class="libre libre-browse-media visible-xs"></i><span class="hidden-xs">Browse for Images</span><input type="file" name="fu"<?php if($user['options']{1}==0)echo' disabled';?>></span>
							<button class="btn btn-success<?php if($user['options']{1}==0)echo' disabled';?>" onclick="$('#block').css({'display':'block'});"><i class="libre libre-upload visible-xs"></i><span class="hidden-xs">Upload</span></button>
						</div>
						<div class="input-group-btn">
							<a class="btn btn-default" data-toggle="modal" data-target="#media" href="core/browse_media.php?id=<?php echo$r['id'];?>&t=content&c=thumb"><i class="libre libre-browse-media visible-xs"></i><span class="hidden-xs">Browse Uploaded Images</span></a>
						</div>
						<div id="thumb" class="input-group-addon">
<?php	if($r['thumb']!=''&&file_exists('media/'.$r['thumb']))echo'<a href="media/'.$r['thumb'].'" data-featherlight="image"><img src="media/'.$r['thumb'].'"></a>';
		else echo'<img src="core/images/noimage.jpg">';?>
						</div>
						<div class="input-group-btn">
							<a class="btn btn-info" data-toggle="modal" data-target="#media" href="core/edit_image.php?id=<?php echo$r['id'];?>&t=content&c=thumb"><i class="libre libre-edit visible-xs"></i><span class="hidden-xs">Edit</span></a>
							<button class="btn btn-danger" onclick="imageUpdate('<?php echo$r['id'];?>','content','thumb');"><i class="libre libre-trash visible-xs"></i><span class="hidden-xs">Delete</span></button>
						</div>
					</div>
				</form>
				<div class="help-block col-xs-7 col-sm-9 col-md-9 col-lg-10 pull-right">
					Uploading an Image will also create a Thumbnail.<br>
					Uploaded Images take Precedence over URL's.
				</div>
			</div>
			<div class="well col-xs-10 pull-right">
				<h4>Image Attribution</h4>
				<div class="form-group">
					<label for="attributionImageTitle" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Title</label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageTitle" placeholder="Enter Image Title...">
					</div>
				</div>
				<div class="form-group">
					<label for="attributionImageName" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Name</label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="attributionImageName" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageName" placeholder="Enter Image Author's Name...">
					</div>
				</div>
				<div class="form-group">
					<label for="attributionImageURL" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">URL</label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="attributionImageURL" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageURL" placeholder="Enter Image Author's URL...">
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</fieldset>
<?php }
	if($r['contentType']=='inventory'||$r['contentType']=='services'||$r['contentType']=='events'||$r['contentType']=='news'){?>
		<div class="form-group">
			<label for="code" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Code</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="code" class="form-control textinput" value="<?php echo$r['code'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="code" placeholder="Enter a Code..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
<?php }
	if($r['contentType']=='inventory'){?>
		<div class="form-group">
			<label for="brand" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Brand</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="brand" class="form-control textinput" value="<?php echo$r['brand'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="brand" placeholder="Enter a Brand..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
<?php }
	if($r['contentType']=='events'){?>
		<div class="form-group">
			<label for="tis" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Event Start</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="tis" class="form-control"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title=';if($r['tis']==0)echo'"Select a Date..."';else echo'"'.date($config['dateFormat'],$r['tis']).'"';}?> value="<?php if($r['tis']!=0)echo date('Y-m-d h:m',$r['tis']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" placeholder="Select a Date..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
		<div class="form-group">
			<label for="tie" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Event End</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="tie" class="form-control"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title=';if($r['tie']==''||$r['tie']==0)echo'"Select a Date..."';else echo'"'.date($config['dateFormat'],$r['tie']).'"';}?> value="<?php if($r['tie']!=0)echo date('Y-m-d h:m',$r['tie']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" placeholder="Select a Date..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
<?php }
	if($r['contentType']=='testimonials'){?>
		<div class="form-group">
			<label for="email" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Email</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="Enter an Email..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
<?php }
	if($r['contentType']=='testimonials'||$r['contentType']=='news'){?>
		<div class="form-group">
			<label for="name" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Name</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="name" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="Enter a Name..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
<?php }
	if($r['contentType']=='testimonials'||$r['contentType']=='news'){?>
		<div class="form-group">
			<label for="url" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">URL</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="url" placeholder="Enter a URL..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
<?php }
	if($r['contentType']=='news'||$r['contentType']=='proofs'){?>
		<div class="form-group">
			<label for="business" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Business</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="Enter a Business..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
<?php }
	if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='gallery'||$r['contentType']=='inventory'||$r['contentType']=='services'||$r['contentType']=='events'||$r['contentType']=='news'){?>
		<div class="form-group">
			<label for="category_1" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Category 1</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=5"><i class="libre libre-help text-danger"></i></a></div>';?>
				<input id="category_1" list="category_1_options" type="text" class="form-control textinput" value="<?php echo$r['category_1'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_1" placeholder="Enter a Category..."<?php if($user['options']{1}==0)echo' readonly';?>>
				<datalist id="category_1_options">
<?php	$s=$db->query("SELECT DISTINCT category_1 FROM content WHERE category_1!='' ORDER BY category_1 ASC");
		while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_1'].'"/>';?>
				</datalist>
			</div>
		</div>
<?php }
	if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='gallery'||$r['contentType']=='inventory'||$r['contentType']=='services'||$r['contentType']=='events'||$r['contentType']=='news'){?>
		<div class="form-group">
			<label for="category_2" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Category 2</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input id="category_2" list="category_2_options" type="text" class="form-control textinput" value="<?php echo$r['category_2'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_2" placeholder="Enter a Category..."<?php if($user['options']{1}==0)echo' readonly';?>>
				<datalist id="category_2_options">
<?php	$s=$db->query("SELECT DISTINCT category_2 FROM content WHERE category_2!='' ORDER BY category_2 ASC");
		while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_2'].'"/>';?>
				</datalist>
			</div>
		</div>
<?php }
	if($r['contentType']=='inventory'||$r['contentType']=='services'){?>
		<div class="form-group">
			<label for="cost" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Cost</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help text-danger"></i></button></div>';?>
				<div class="input-group-addon">$</div>
				<input type="text" id="cost" class="form-control textinput" value="<?php echo$r['cost'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cost" placeholder="Enter a Cost..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
		<div class="form-group clearfix">
			<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Show Cost</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help text-danger"></i></button></div>';?>
				<input type="checkbox" id="options0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0"<?php if($r['options']{0}==1)echo' checked';if($user['options']{1}==0)echo' readonly';?>><label for="options0">
			</div>
		</div>
<?php }
	if($r['contentType']=='inventory'){?>
		<div class="form-group">
			<label for="quantity" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Quantity</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help text-danger"></i></button></div>';?>
				<input type="text" id="quantity" class="form-control textinput" value="<?php echo$r['quantity'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="quantity" placeholder="Enter a Quantity..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
<?php }?>
		<div class="form-group clearfix">
			<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Featured</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="checkbox" id="featured0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0"<?php if($r['featured']{0}==1)echo' checked';if($user['options']{1}==0)echo' readonly';?>><label for="featured0">
			</div>
		</div>
<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='inventory'||$r['contentType']=='services'||$r['contentType']=='gallery'||$r['contentType']=='events'||$r['contentType']=='news'){?>
		<div class="form-group">
			<label for="content_keywords" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Keywords</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=6"><i class="libre libre-help text-danger"></i></a></div>';?>
				<input type="text" id="content_keywords" class="form-control textinput" value="<?php echo$r['keywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="keywords" placeholder="Enter Keywords.."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
		<div class="form-group">
			<label for="tags" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Tags</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=7"><i class="libre libre-help text-danger"></i></a></div>';?>
				<input type="text" id="tags" class="form-control textinput" value="<?php echo$r['tags'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tags" placeholder="Enter Tags..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
<?php }?>
		<div class="form-group clearfix">
			<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Internal</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="checkbox" id="internal0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0"<?php if($r['internal']==1)echo' checked';?><?php if($user['options']{1}==0)echo' readonly';?>><label for="internal0">
			</div>
		</div>
<?php if($r['contentType']=='events'||$r['contentType']=='services'){?>
		<div class="form-group clearfix">
			<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Bookable</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help text-danger"></i></button></div>';?>
				<input type="checkbox" id="bookable0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="bookable" data-dbb="0"<?php if($r['bookable']==1)echo' checked';?><?php if($user['options']{1}==0)echo' readonly';?>><label for="bookable0">
			</div>
		</div>
<?php }
	if($r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='services'||$r['contentType']=='inventory'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'){?>
		<div class="form-group">
			<label for="caption" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Caption</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn"><a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=8"><i class="libre libre-help text-danger"></i></a></div>';?>
				<input type="text" id="caption" class="form-control textinput" value="<?php echo$r['caption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="caption" placeholder="Enter a Caption..."<?php if($user['options']{1}==0)echo' readonly';?>>
			</div>
		</div>
<?php }?>
		<div class="form-group">
			<label for="notes" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Notes</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($config['options']{5}==1)echo'<div class="input-group-btn" style="vertical-align:top;"><a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=10"><i class="libre libre-help text-danger"></i></a></div>';?>
<?php if($user['options']{1}==1){?>
				<form method="post" target="sp" action="core/update.php">
					<input type="hidden" name="id" value="<?php echo$r['id'];?>">
					<input type="hidden" name="t" value="content">
					<input type="hidden" name="c" value="notes">
					<textarea id="notes" class="form-control summernote" name="da" readonly><?php echo$r['notes'];?></textarea>
				</form>
<?php }else{?>
				<div class="panel panel-default">
					<div class="panel-body"><?php echo$r['notes'];?></div>
				</div>
<?php }?>
			</div>
		</div>
		<div class="well col-xs-10 pull-right">
			<h4>Content Attribution</h4>
			<div class="form-group">
				<label for="attributionContentName" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Name</label>
				<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
					<input type="text" id="attributionContentName" class="form-control textinput" value="<?php echo$r['attributionContentName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionContentName" placeholder="Enter Content Author's Name...">
				</div>
			</div>
			<div class="form-group">
				<label for="attributionContentURL" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">URL</label>
				<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
					<input type="text" id="attributionContentURL" class="form-control textinput" value="<?php echo$r['attributionContentURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionContentURL" placeholder="Enter Content Author's URL...">
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
<?php if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){?>
		<div class="form-group clearfix">
			<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Comments<?php if($config['options']{5}==1)echo'<div class="pull-right hidden-xs"><a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=9"><i class="libre libre-help text-danger"></i></a></div>';?></label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="checkbox" id="options1" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="1"<?php if($r['options']{1}==1)echo' checked';?>><label for="options1">
			</div>
		</div>
		<div id="comments">
			<h3>Discussion</h3>
<?php $sc=$db->prepare("SELECT * FROM comments WHERE contentType=:contentType AND rid=:rid ORDER BY ti ASC");
$sc->execute(array(':contentType'=>$r['contentType'],':rid'=>$r['id']));
while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
			<div id="l_<?php echo$rc['id'];?>" class="media clearfix<?php if($rc['status']=='delete')echo' danger';if($rc['status']=='unapproved')echo' warning';?>">
				<div class="media-object pull-left">
<?php $su=$db->prepare("SELECT * FROM login WHERE id=:id");
	$su->execute(array(':id'=>$rc['uid']));
	$ru=$su->fetch(PDO::FETCH_ASSOC);?>
					<img class="commentavatar img-thumbnail" src="<?php if($ru['gravatar']!='')echo$ru['gravatar'];elseif($ru['avatar']!=''&&file_exists('media/avatar/'.$ru['avatar']))echo'media/avatar/'.$ru['avatar'];else echo$noavatar;?>">
				</div>
				<div class="media-body">
					<div class="well">
						<h5 class="media-heading">Name: <?php echo$rc['name'];?></h5>
						<time><small class="text-muted"><?php echo date($config['dateFormat'],$rc['ti']);?></small></time>
<?php echo strip_tags($rc['notes']);?>
						<div id="controls-<?php echo$rc['id'];?>" class="pull-right">
							<button id="approve_<?php echo$rc['id'];?>" class="btn btn-default btn-xs<?php if($rc['status']!='unapproved')echo' hidden';?>" onclick="update('<?php echo$rc['id'];?>','comments','status','approved')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Approve"';if($config['buttonType']=='text')echo'><span class="color-success">Approve</span>';else echo'><i class="libre libre-approve text-success"></i>';?></button> 
							<button class="btn btn-default btn-xs" onclick="purge('<?php echo$rc['id'];?>','comments')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';if($config['buttonType']=='text')echo'><span class="color-danger">Delete</span>';else echo'><i class="libre libre-trash text-danger"></i>';?></button>
						</div>
					</div>
				</div>
<?php }?>
			</div>
			<iframe name="comments" id="comments" class="hidden"></iframe>
			<div class="form-group">
				<form role="form" target="comments" method="post" action="core/add_data.php">
					<input type="hidden" name="act" value="add_comment">
					<input type="hidden" name="rid" value="<?php echo$r['id'];?>">
					<input type="hidden" name="contentType" value="<?php echo$r['contentType'];?>">
					<label for="email" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Email</label>
					<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
						<input type="text" class="form-control" name="email" value="<?php echo$user['email'];?>" readonly>
					</div>
					<label for="name" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Name</label>
					<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
						<input type="text" class="form-control" name="name" value="<?php echo$user['name'];?>" readonly>
					</div>
					<label for="da" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Comment</label>
					<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
						<textarea id="da" class="form-control" name="da" placeholder="Enter a Comment..." required></textarea>
					</div>
					<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">&nbsp;</label>
					<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
						<button class="btn btn-default btn-block color-success">Add Comment</button>
					</div>
				</form>
			</div>
		</div>
<?php }?>
	</div>
</div>
<?php }
