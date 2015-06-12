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
	if($args[0]=='testimonials')$schema='Review';
	if($args[0]=='news')$schema='NewsArticle';
	if($args[0]=='events')$schema='Event';
	if($args[0]=='portfolio')$schema='CreativeWork';
	if($args[0]=='proofs')$schema='CreativeWork';$comments=1;
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
		$s=$db->prepare("SELECT * FROM content WHERE contentType=:contentType AND contentType!='message_primary' ORDER BY ti DESC");
		$s->execute(array(':contentType'=>$args[1]));
	}else{
		if(isset($args[1])){
			$s=$db->prepare("SELECT * FROM content WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND contentType!='message_primary' ORDER BY ti DESC");
			$s->execute(array(':category_1'=>str_replace('-',' ',$args[0]),':category_2'=>str_replace('-',' ',$args[1])));
		}elseif(isset($args[0])){
			$s=$db->prepare("SELECT * FROM content WHERE LOWER(category_1) LIKE LOWER(:category_1) AND contentType!='message_primary' ORDER BY ti DESC");
			$s->execute(array(':category_1'=>str_replace('-',' ',$args[0])));
		}else{
			$s=$db->prepare("SELECT * FROM content WHERE contentType!='booking' AND contentType!='message_primary' ORDER BY ti DESC");
			$s->execute();
		}
	}?>
<div class="table-responsive col-lg-10 col-md-9">
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th class="text-center">contentType</th>
				<th class="text-center">Created</th>
				<th class="text-center">Edited</th>
				<th class="text-center">Title</th>
				<th class="text-center">Status</th>
				<th class="text-center">Views</th>
				<th class="text-center">Featured</th>
				<th class="text-center">Internal</th>
				<th class="col-xs-2 text-right">
					Show <div class="btn-group">
							<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"><?php if(!isset($args[1])||$args[1]=='')echo'All';else echo ucfirst($args[1]);?> <i class="caret"></i></button>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="<?php echo URL.'admin/content';?>">All</a>
								</li>
<?php	$st=$db->query("SELECT DISTINCT contentType FROM content WHERE contentType!='booking' AND contentType!='message' AND contentType!='message_primary' ORDER BY contentType ASC");
		while($sr=$st->fetch(PDO::FETCH_ASSOC)){?>
								<li>
									<a href="<?php echo URL.'admin/content/type/'.$sr['contentType'];?>"><?php echo ucfirst($sr['contentType']);?></a>
								</li>
<?php	}?>
							</ul>
						</div>
				</th>
			</tr>
		</thead>
		<tbody id="sort">
<?php	while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
			<tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='delete'){echo'danger';}?>">
				<td class="text-center">
					<a class="btn btn-default btn-xs" href="<?php echo URL.'/admin/content/type/'.$r['contentType'];?>"><?php echo ucfirst($r['contentType']);?></a>
				</td>
				<td class="text-center">
					<small><?php echo date($config['dateFormat'],$r['ti']);?></small>
				</td>
				<td class="text-center">
					<small><?php echo date($config['dateFormat'],$r['eti']);?></small>
				</td>
				<td>
					<small><?php echo$r['title'];?></small>
				</td>
				<td class="text-center">
					<div class="btn-group">
<?php		if($r['contentType']!='proofs'){?>
						<select id="status" class="btn btn-default btn-xs" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php if($user['options']{1}==0){echo' readonly';}?>>
							<option value="unpublished"<?php if($r['status']=='unpublished')echo' selected';?>>Unpublished</option>
							<option value="published"<?php if($r['status']=='published')echo' selected';?>>Published</option>
							<option value="delete"<?php if($r['status']=='delete')echo' selected';?>>Delete</option>
						</select>
<?php		}?>
					</div>
				</td>
				<td class="text-center">
					<small><?php echo$r['views'];?></small>
				</td>
				<td class="text-center">
					<div class="btn-group">
<?php		if($r['contentType']!='proofs'){?>
						<input type="checkbox" id="featured0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0"<?php if($r['featured']{0}==1)echo' checked';?><?php if($user['options']{1}==0)echo' readonly';?>>
<?php		}?>
					</div>
				</td>
				<td class="text-center">
					<div class="btn-group">
<?php		if($r['contentType']!='proofs'){?>
						<input type="checkbox" id="internal0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0"<?php if($r['internal']==1)echo' checked';?><?php if($user['options']{1}==0)echo' readonly';?>>
<?php		}?>
					</div>
				</td>
				<td id="controls_<?php echo$r['id'];?>" class="text-right">
					<a class="btn btn-default btn-xs<?php if($r['status']=='delete')echo' hidden';?>" href="admin/content/edit/<?php echo$r['id'];?>" data-toggle="tooltip" title="Edit"><?php if($config['buttonType']=='text')echo'Edit';else echo'<i class="libre libre-edit"></i>';?></a> 
<?php		if($user['rank']==1000||$user['options']{0}==1){?>
					<button class="btn btn-default btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-toggle="tooltip" title="Restore"><?php if($config['buttonType']=='text')echo'Restore';else echo'<i class="libre libre-email-reply color-success"></i>';?></button> 
					<button class="btn btn-default btn-xs<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-toggle="tooltip" title="Delete"><?php if($config['buttonType']=='text')echo'Delete';else echo'<i class="libre libre-trash color-danger"></i>';?></button> 
					<button class="btn btn-default btn-xs<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','content')" data-toggle="tooltip" title="Purge"><?php if($config['buttonType'])echo'Purge';else echo'<i class="libre libre-email-forward color-danger"></i>';?></button>
<?php		}?>
				</td>
			</tr>
<?php	}?>
		</tbody>
	</table>
</div>
<div class="col-lg-2 col-md-3">
	<div class="list-group">
		<a class="list-group-item" href="<?php echo URL.'admin/content';?>"><h4 class="list-group-item-heading">Categories</h4></a>
<?php	$sc=$db->prepare("SELECT DISTINCT category_1 FROM content WHERE category_1!='' ORDER BY category_1 ASC");
		$sc->execute();
		if($sc->rowCount()>0){
			while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
		<a class="list-group-item" href="<?php echo URL.'admin/content/'.strtolower(str_replace(' ','-',$rc['category_1']));?>">
			<h5 class="list-group-item-heading">
<?php 			echo substr($rc['category_1'],0,30);
				if(strlen($r['category_1'])>30)echo'...';?>
			</h5>
		</a>
<?php 			$scc=$db->prepare("SELECT DISTINCT category_2 FROM content WHERE category_1=:category_1 AND category_2!='' ORDER BY category_2 ASC");
				$scc->execute(array(':category_1'=>$rc['category_1']));
				if($scc->rowCount()>0){
					while($rcc=$scc->fetch(PDO::FETCH_ASSOC)){?>
		<a class="list-group-item" href="<?php echo URL.'admin/content/'.strtolower(str_replace(" ","-",$rc['category_1'].'/'.$rcc['category_2']));?>">
			<h6 class="list-group-item-heading margin-left-20">
<?php					echo substr($rcc['category_2'],0,30);
						if(strlen($rcc['category_2'])>30)echo'...';?>
			</h6>
		</a>
<?php				}
				}
			}?>
<?php	}?>
	</div>
</div>
<?php }
	if($show=='item'){
		$r=$s->fetch(PDO::FETCH_ASSOC);?>
<div class="form-group clearfix">
	<div class="input-group pull-right">
		<a class="btn btn-default" href="<?php echo URL.'admin/content/type/'.$r['contentType'];?>" data-toggle="tooltip" title="Back"><?php if($config['buttonType']=='text')echo'Back';else echo'<i class="libre libre-back"></i>';?></a>
	</div>
</div>
<div class="form-group">
	<label for="title" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Title
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=1"><i class="libre libre-help text-danger"></i></a>
		</div>
<?php 	}?>
	</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title"<?php if($user['options']{1}==0)echo' readonly';?> data-toggle="tooltip" title="">
	</div>
</div>
<?php if($r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='inventory'||$r['contentType']=='services'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'){?>
<div class="form-group">
	<label for="published" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Status</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php if($user['options']{1}==0)echo' readonly';?> data-toggle="tooltip" title="">
			<option value="unpublished"<?php if($r['status']=='unpublished')echo' selected';?>>Unpublished</option>
			<option value="published"<?php if($r['status']=='published')echo' selected';?>>Published</option>
			<option value="delete"<?php if($r['status']=='delete')echo' selected';?>>Delete</option>
		</select>
	</div>
</div>
<?php }?>
<div class="form-group">
	<label for="ti" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Created</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
	</div>
</div>
<div class="form-group">
	<label for="eti" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Edited</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="eti" class="form-control" value="<?php echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?>" readonly>
	</div>
</div>
<div class="form-group">
	<label for="views" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Views</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="views"<?php if($user['options']{1}==0)echo' readonly';?> data-toggle="tooltip" title="">
	</div>
</div>
<div class="form-group">
	<label for="contentType" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Content Type</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<select id="contentType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','contentType',$(this).val());"<?php if($user['options']{1}==0)echo' disabled';?> data-toggle="tooltip" title="Change the Type of Content this Item belongs to.">
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
	<label for="schemaType" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Schema Type
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=2"><i class="libre libre-help text-danger"></i></a>
		</div>
<?php 	}?>
	</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<select id="schemaType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','schemaType',$(this).val());"<?php if($user['options']{1}==0)echo' disabled';?> data-toggle="tooltip" title="Schema for Microdata Content">
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
	<label for="cid" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Client</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
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
	<label for="author" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Author
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=3"><i class="libre libre-help text-danger"></i></a>
		</div>
<?php 	}?>
	</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<select id="uid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','uid',$(this).val());"<?php if($user['options']{1}==0)echo' disabled';?>>
<?php	$su=$db->query("SELECT id,username,name FROM login WHERE username!='' AND status!='delete' ORDER BY username ASC, name ASC");
		while($ru=$su->fetch(PDO::FETCH_ASSOC)){?>
			<option value="<?php echo$ru['id'];?>"<?php if($ru['id']==$r['uid'])echo' selected';?>><?php echo$ru['username'].':'.$ru['name'];?></option>
<?php	}?>
		</select>
	</div>
</div>
<?php }
	if($r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='inventory'||$r['contentType']=='portfolio'||$r['contentType']=='proofs'||$r['contentType']=='services'){?>
<form method="post" target="sp" enctype="multipart/form-data" action="core/add_data.php">
	<input type="hidden" name="id" value="<?php echo$r['id'];?>">
	<input type="hidden" name="act" value="add_image">
	<input type="hidden" name="t" value="content">
	<input type="hidden" name="c" value="file">
	<div class="form-group relative">
		<label for="file" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
			Image
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=4"><i class="libre libre-help text-danger"></i></a>
		</div>
<?php 	}?>
		</label>
		<div class="input-group col-lg-9 col-md-8 col-sm-8 col-xs-6">
			<input type="file" name="fu" class="form-control"<?php if($user['options']{1}==0)echo' disabled';?>>
			<div class="input-group-btn">
				<button class="btn btn-default<?php if($user['options']{1}==0)echo' disabled';?>" onclick="$('#block').css({'display':'block'});">Upload</button>
			</div>
		</div>
		<div id="file">
<?php	if($r['file']!=''&&file_exists('media/'.$r['file'])){?>
			<a href="media/<?php echo$r['file'];?>" data-featherlight-gallery><img src="media/<?php echo$r['file'];?>"></a>
<?php	}else echo'<img src="core/images/noimage.jpg">';?>
		</div>
	</div>
</form>
<?php }
	if($r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='inventory'||$r['contentType']=='portfolio'||$r['contentType']=='proofs'||$r['contentType']=='services'){?>
<form method="post" target="sp" enctype="multipart/form-data" action="core/add_data.php">
	<input type="hidden" name="id" value="<?php echo$r['id'];?>">
	<input type="hidden" name="act" value="add_image">
	<input type="hidden" name="t" value="content">
	<input type="hidden" name="c" value="thumb">
	<div class="form-group relative">
		<label for="thumb" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Thumb</label>
		<div class="input-group col-lg-9 col-md-8 col-sm-8 col-xs-6">
			<input type="file" name="fu" class="form-control"<?php if($user['options']{1}==0)echo' disabled';?>>
			<div class="input-group-btn">
				<button class="btn btn-default<?php if($user['options']{1}==0)echo' disabled';?>" onclick="$('#block').css({'display':'block'});">Upload</button>
			</div>
		</div>
		<div id="thumb">
<?php	if($r['thumb']!=''&&file_exists('media/'.$r['thumb'])){?>
			<a href="media/<?php echo$r['thumb'];?>" data-featherlight-gallery><img src="media/<?php echo$r['thumb'];?>"></a>
<?php	}else echo'<img src="core/images/noimage.jpg">';?>
		</div>
		<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">&nbsp;</label>
		<div class="input-group col-lg-9 col-md-8 col-sm-8 col-xs-6">
			<span class="help-block">Uploading an Image will also create a Thumbnail</span>
		</div>
	</div>
</form>
<?php }
	if($r['contentType']=='inventory'||$r['contentType']=='services'||$r['contentType']=='events'||$r['contentType']=='news'){?>
<div class="form-group">
	<label for="code" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Code</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="code" class="form-control textinput" value="<?php echo$r['code'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="code" placeholder="Enter a Code..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }
	if($r['contentType']=='inventory'){?>
<div class="form-group">
	<label for="brand" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Brand</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="brand" class="form-control textinput" value="<?php echo$r['brand'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="brand" placeholder="Enter a Brand..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }
	if($r['contentType']=='events'){?>
<div class="form-group">
	<label for="tis" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Event Start</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="tis" class="form-control" data-tooltip data-original-title="<?php if($r['tis']==0)echo'Select a Date...';else echo date($config['dateFormat'],$r['tis']);?>" value="<?php if($r['tis']!=0)echo date('Y-m-d h:m',$r['tis']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" placeholder="Select a Date..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<div class="form-group">
	<label for="tie" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Event End</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="tie" class="form-control" data-tooltip data-original-title="<?php if($r['tie']==''||$r['tie']==0)echo'Select a Date...';else echo date($config['dateFormat'],$r['tie']);?>" value="<?php if($r['tie']!=0)echo date('Y-m-d h:m',$r['tie']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" placeholder="Select a Date..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }
	if($r['contentType']=='testimonials'){?>
<div class="form-group">
	<label for="email" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Email</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="Enter an Email..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }
	if($r['contentType']=='testimonials'||$r['contentType']=='news'){?>
<div class="form-group">
	<label for="name" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Name</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="name" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="Enter a Name..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }
	if($r['contentType']=='testimonials'||$r['contentType']=='news'){?>
<div class="form-group">
	<label for="url" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">URL</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="url" placeholder="Enter a URL..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }
	if($r['contentType']=='news'||$r['contentType']=='proofs'){?>
<div class="form-group">
	<label for="business" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Business</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="Enter a Business..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }
	if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='gallery'||$r['contentType']=='inventory'||$r['contentType']=='services'||$r['contentType']=='events'||$r['contentType']=='news'){?>
<div class="form-group">
	<label for="category_1" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Category 1
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=5"><i class="libre libre-help text-danger"></i></a>
		</div>
<?php 	}?>
	</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input id="category_1" list="category_1_options" type="text" class="form-control textinput" value="<?php echo$r['category_1'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_1" placeholder="Enter a Category..."<?php if($user['options']{1}==0)echo' readonly';?>>
		<datalist id="category_1_options">
<?php	$s=$db->query("SELECT DISTINCT category_1 FROM content WHERE category_1!='' ORDER BY category_1 ASC");
		while($rs=$s->fetch(PDO::FETCH_ASSOC)){?>
			<option value="<?php echo$rs['category_1'];?>"/>
<?php	}?>
		</datalist>
	</div>
</div>
<?php }
	if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='gallery'||$r['contentType']=='inventory'||$r['contentType']=='services'||$r['contentType']=='events'||$r['contentType']=='news'){?>
<div class="form-group">
	<label for="category_2" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Category 2</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input id="category_2" list="category_2_options" type="text" class="form-control textinput" value="<?php echo$r['category_2'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_2" placeholder="Enter a Category..."<?php if($user['options']{1}==0)echo' readonly';?>>
		<datalist id="category_2_options">
<?php	$s=$db->query("SELECT DISTINCT category_2 FROM content WHERE category_2!='' ORDER BY category_2 ASC");
		while($rs=$s->fetch(PDO::FETCH_ASSOC)){?>
			<option value="<?php echo$rs['category_2'];?>"><?php echo$rs['category_2'];?></option>
<?php	}?>
		</datalist>
	</div>
</div>
<?php }
	if($r['contentType']=='inventory'||$r['contentType']=='services'){?>
<div class="form-group">
	<label for="cost" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Cost</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
<?php 	if($config['options']{5}==1){?>
		<div class="input-group-btn">
			<button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help text-danger"></i></button>
		</div>
<?php 	}?>
		<div class="input-group-addon">$</div>
		<input type="text" id="cost" class="form-control textinput" value="<?php echo$r['cost'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cost" placeholder="Enter a Cost..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<div class="form-group clearfix">
	<label for="options0" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Show Cost
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help text-danger"></i></button>
		</div>
<?php 	}?>
	</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="checkbox" id="options0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0"<?php if($r['options']{0}==1)echo' checked';?><?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }
	if($r['contentType']=='inventory'){?>
<div class="form-group">
	<label for="quantity" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Quantity</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
<?php 	if($config['options']{5}==1){?>
		<div class="input-group-btn">
			<button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help text-danger"></i></button>
		</div>
<?php 	}?>
		<input type="text" id="quantity" class="form-control textinput" value="<?php echo$r['quantity'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="quantity" placeholder="Enter a Quantity..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }?>
<div class="form-group clearfix">
	<label for="featured0" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Featured</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="checkbox" id="featured0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0"<?php if($r['featured']{0}==1)echo' checked';?><?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php if($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='inventory'||$r['contentType']=='services'||$r['contentType']=='gallery'||$r['contentType']=='events'||$r['contentType']=='news'){?>
<div class="form-group">
	<label for="content_keywords" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Keywords
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=6"><i class="libre libre-help text-danger"></i></a>
		</div>
<?php 	}?>
	</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="content_keywords" class="form-control textinput" value="<?php echo$r['keywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="keywords" placeholder="Enter Keywords.."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<div class="form-group">
	<label for="tags" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Tags
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=7"><i class="libre libre-help text-danger"></i></a>
		</div>
<?php 	}?>
	</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="tags" class="form-control textinput" value="<?php echo$r['tags'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tags" placeholder="Enter Tags..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }?>
<div class="form-group clearfix">
	<label for="internal" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Internal</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="checkbox" id="internal0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0"<?php if($r['internal']==1)echo' checked';?><?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php if($r['contentType']=='events'||$r['contentType']=='services'){?>
<div class="form-group clearfix">
	<label for="bookable" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Bookable
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help text-danger"></i></button>
		</div>
<?php 	}?>
	</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="checkbox" id="bookable0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="bookable" data-dbb="0"<?php if($r['bookable']==1)echo' checked';?><?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }
	if($r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='services'||$r['contentType']=='inventory'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'){?>
<div class="form-group">
	<label for="caption" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Caption
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=8"><i class="libre libre-help text-danger"></i></a>
		</div>
<?php 	}?>
	</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="text" id="caption" class="form-control textinput" value="<?php echo$r['caption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="caption" placeholder="Enter a Caption..."<?php if($user['options']{1}==0)echo' readonly';?>>
	</div>
</div>
<?php }?>
<div class="form-group">
	<label for="notes" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Notes
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=10"><i class="libre libre-help text-danger"></i></a>
		</div>
<?php 	}?>
	</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
<?php if($user['options']{1}==1){?>
		<form method="post" target="sp" action="core/update.php">
			<input type="hidden" name="id" value="<?php echo$r['id'];?>">
			<input type="hidden" name="t" value="content">
			<input type="hidden" name="c" value="notes">
			<textarea id="notes" class="form-control summernote" name="da" readonly><?php echo$r['notes'];?></textarea>
		</form>
<?php }else{?>
		<div class="panel panel-default">
			<div class="panel-body">
<?php	echo$r['notes'];?>
			</div>
		</div>
<?php }?>
	</div>
</div>
<?php if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){?>
<div class="form-group clearfix">
	<label for="options1" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">
		Comments
<?php 	if($config['options']{5}==1){?>
		<div class="pull-right">
			<a class="btn btn-default" data-toggle="modal" data-target="#seo" href="core/seo.php?id=9"><i class="libre libre-help text-danger"></i></a>
		</div>
<?php 	}?>
	</label>
<?php	if($r['contentType']!='proofs'){?>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
		<input type="checkbox" id="options1" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="1"<?php if($r['options']{1}==1)echo' checked';?>></div>
<?php	}?>
	</div>
<?php }
	}
	if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){?>
	<div id="comments" class="clearfix"><h3>Discussion</h3>
<?php $sc=$db->prepare("SELECT * FROM comments WHERE contentType=:contentType AND rid=:rid ORDER BY ti ASC");
		$sc->execute(array(':contentType'=>$r['contentType'],':rid'=>$r['id']));
		while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
	<div id="l_<?php echo$rc['id'];?>" class="media clearfix<?php if($rc['status']=='delete')echo' danger';if($rc['status']=='unapproved')echo' warning';?>">
		<div class="media-object pull-left">
<?php		$su=$db->prepare("SELECT * FROM login WHERE id=:id");
			$su->execute(array(':id'=>$rc['uid']));
			$ru=$su->fetch(PDO::FETCH_ASSOC);
			if($ru['gravatar']!='')$avatar=$ru['gravatar'];
			elseif($ru['avatar']!=''&&file_exists('media/avatar/'.$ru['avatar']))$avatar='media/'.$ru['avatar'];
			else$avatar='core/images/noavatar.jpg';?>
			<img class="commentavatar img-thumbnail" src="<?php echo$avatar;?>">
		</div>
		<div class="media-body">
			<div class="well">
				<h5 class="media-heading">Name: <?php echo$rc['name'];?></h5>
				<time><small class="text-muted"><?php echo date($config['dateFormat'],$rc['ti']);?></small></time>
				<?php echo strip_tags($rc['notes']);?>
<?php		if($user['rank']>699){?>
				<div id="controls-<?php echo$rc['id'];?>" class="pull-right">
					<button id="approve_<?php echo$rc['id'];?>" class="btn btn-success btn-xs<?php if($rc['status']!='unapproved')echo' hidden';?>" onclick="update('<?php echo$rc['id'];?>','comments','status','')">Approve</button> 
					<button class="btn btn-danger btn-xs" onclick="purge('<?php echo$rc['id'];?>','comments')">Delete</button>
				</div>
<?php 		}?>
			</div>
		</div>
<?php 	}?>
	</div>
<?php 	if($r['options']{1}==1){?>
	<div class="media">
		<div class="media-body col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<iframe name="comments" id="comments" class="hidden"></iframe>
			<form role="form" target="comments" method="post" action="core/add_data.php">
				<input type="hidden" name="act" value="add_comment">
				<input type="hidden" name="rid" value="<?php echo$r['id'];?>">
				<input type="hidden" name="contentType" value="<?php echo$r['contentType'];?>">
					<div class="form-group">
<?php		if($user['email']!=''){?>
						<input type="hidden" name="email" value="<?php echo$user['email'];?>">
<?php		}else{?>
						<label for="email" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Email</label>
						<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
							<input type="text" class="form-control" name="email" value="" placeholder="Enter an Email..." required>
						</div>
<?php		}
			if($user['rank']>0&&$user['name']!=''){?>
						<input type="hidden" name="name" value="<?php echo$user['name'];?>">
<?php		}else{?>
						<label for="name" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Name</label>
						<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
							<input type="text" class="form-control" name="name" value="" placeholder="Enter a Name..." required>
						</div>
<?php		}?>
						<label for="da" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Comment</label>
							<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
								<textarea id="da" class="form-control" name="da" placeholder="Enter a Comment..." required></textarea>
							</div>
							<label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">&nbsp;</label>
							<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
								<button class="btn btn-success btn-block">Add Comment</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php	}?>
</div>
<?php }
