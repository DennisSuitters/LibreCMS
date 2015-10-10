<?php
$rank=0;
$show='categories';
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
<div class="toolbar">
    &nbsp;
</div>
<div id="listtype" class="list">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
	<div id="l_<?php echo$r['id'];?>" class="item">
		<div class="panel panel-default">
			<div class="badger badger-left text-shadow-depth-1" href="#" data-status="<?php echo$r['status'];?>" data-contenttype="<?php echo$r['contentType'];?>"></div>
			<div class="panel-image">
<?php	if($r['thumb']!=''&&file_exists('media/'.$r['thumb'])){?>
				<a href="admin/content/edit/<?php echo$r['id'];?>"><img src="<?php echo'media/'.$r['thumb'];?>"></a>
<?php	}?>
			</div>
			<h4 class="panel-title"><?php echo$r['title'];?></h4>
			<div class="panel-body panel-content"><?php echo strip_tags(substr($r['notes'],0,200));?></div>
			<div id="controls_<?php echo$r['id'];?>" class="btn-group panel-controls shadow-depth-1">
				<a id="pin<?php echo$r['id'];?>" class="btn btn-default btn-sm<?php if($r['pin']{0}==1)echo' btn-success';?>" onclick="pinToggle('<?php echo$r['id'];?>','content','pin','0')"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','pin');echo'"';}?>><i class="libre libre-pin"></i></a>
<?php if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){
	$cnt=0;
	$sc=$db->prepare("SELECT COUNT(id) as cnt FROM comments WHERE rid=:id AND status='unapproved'");
	$sc->execute(array(':id'=>$r['id']));
	$cnt=$sc->fetch(PDO::FETCH_ASSOC);?>
				<a class="btn btn-default btn-sm" href="admin/content/edit/<?php echo$r['id'];?>#comments"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','comments');echo'"';}?>><i class="libre libre-comments"></i> <?php echo$cnt['cnt'];?></a>
<?php }?>
				<span class="btn btn-default btn-sm"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','views');echo'"';}?>><i class="libre libre-view"></i> <?php echo$r['views'];?></span>
				<a class="btn btn-info btn-sm" href="admin/content/edit/<?php echo$r['id'];?>"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','edit');echo'"';}?>><i class="libre libre-edit"></i></a>
<?php		if($user['rank']==1000||$user['options']{0}==1){?>
				<button class="btn btn-warning btn-sm<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','restore');echo'"';}?>><i class="libre libre-restore"></i></button>
				<button class="btn btn-danger btn-sm<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','delete');echo'"';}?>><i class="libre libre-trash"></i></button>
				<button class="btn btn-danger btn-sm<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','content')"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','purge');echo'"';}?>><i class="libre libre-purge"></i></button>
<?php		}?>
			</div>
		</div>
	</div>
<?php	}?>
</div>
<?php }
