<?php
session_start();
include'db.php';
if(isset($_SESSION['uid'])){
	$uid=(int)$_SESSION['uid'];
	$s=$db->prepare("SELECT options,rank FROM login WHERE id=:id");
	$s->execute(array(':id'=>$uid));
	$user=$s->fetch(PDO::FETCH_ASSOC);
}else{

}
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
if($user['rank']>399&&$user['options']{6}!=1){
	$s=$db->prepare("UPDATE seo SET views=views+1 WHERE id=:id");
	$s->execute(array(':id'=>$id));
}
$s=$db->prepare("SELECT * FROM seo WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
$config=$db->query("SELECT dateFormat FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
define('YANDEX','trnsl.1.1.20151010T141347Z.abb6d53e6280191b.5decd3b201ae911048617d1869e766124de2023d');?>
<div class="modal-header clearfix">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<?php if($user['rank']>399&&$user['options']{6}==1){?>
	<div class="form-group">
		<label for="seo_title" class="control-label text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">Title</label>
		<div class="input-group col-lg-9 col-md-9 col-sm-9 col-xs-9">
			<input type="text" id="seo_title" class="form-control" name="seo_title" value="<?php echo$r['seo_title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="seo" data-dbc="seo_title" placeholder="Enter a Title...">
			<div id="seo_titlesave" class="input-group-btn hidden"><button class="btn btn-danger"><i class="fa fa-save"></i></button></div>
		</div>
	</div>
<?php }else{?>
	<h4 class="modal-title"><?php echo$r['seo_title'];?></h4>
<?php }?>
</div>
<div class="modal-body">
<?php if($user['rank']>399&&$user['options']{6}==1){?>
	<div class="form-group">
		<label for="seo_notes" class="control-label text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">Notes</label>
		<div class="input-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<form method="post" target="sp" action="core/update.php">
				<input type="hidden" name="id" value="<?php echo$r['id'];?>">
				<input type="hidden" name="t" value="seo">
				<input type="hidden" name="c" value="notes">
				<textarea id="seo_notes" class="form-control seosummernote" name="da"><?php echo$r['notes'];?></textarea>
			</form>
		</div>
	</div>
<?php }else{
	echo $r['notes'];
}?>
</div>
<div class="modal-footer">
	<small class="help-block text-right">
		Edited: <?php if($r['eti']==0)echo'Never';else echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?>
	</small>
<?php if($user['rank']>399&&$user['options']{6}==1){?>
	<small class="help-block text-right">
		Viewed: <?php echo$r['views'];?> times
	</small>
	<div class="form-group">
		<label for="seo_name" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Name</label>
		<div class="input-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<input type="text" id="seo_name" class="form-control" list="seo_name_list" value="<?php echo$r['seo_name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="seo" data-dbc="seo_name" placeholder="Enter a Name...">
			<div id="seo_namesave" class="input-group-btn hidden"><button class="btn btn-danger"><i class="fa fa-save"></i></button></div>
			<datalist id="seo_name_list">
<?php	$s2=$db->query("SELECT DISTINCT seo_name FROM seo WHERE seo_name!='' ORDER BY seo_name ASC");
		while($rs=$s2->fetch(PDO::FETCH_ASSOC)){?>
				<option value="<?php echo$rs['seo_name'];?>"/>
<?php	}?>
			</datalist>
		</div>
	</div>
	<div class="form-group">
		<label for="seo_name" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">URL</label>
		<div class="input-group col-lg-10 col-md-10 col-sm-10 col-xs-10">
			<input type="text" id="seo_url" class="form-control" list="seo_url_list" value="<?php echo$r['seo_url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="seo" data-dbc="seo_url" placeholder="Enter a URL...">
			<div id="seo_urlsave" class="input-group-btn hidden"><button class="btn btn-danger"><i class="fa fa-save"></i></button></div>
			<datalist id="seo_url_list">
<?php	$s2=$db->query("SELECT DISTINCT seo_url FROM seo WHERE seo_url!='' ORDER BY seo_url ASC");
		while($rs=$s2->fetch(PDO::FETCH_ASSOC)){?>
				<option value="<?php echo$rs['seo_url'];?>"/>
<?php	}?>
			</datalist>
		</div>
	</div>
<?php }else{
	if($r['seo_url']!=''){?>
	<small class="help-block text-right">SEO Information by <a target="_blank" href="<?php echo$r['seo_url'];?>"><?php if($r['seo_name']!='')echo$r['seo_name'];else echo$r['seo_url'];?></a></small>
<?php }
}?>
</div>
<?php if($user['rank']>399&&$user['options']{6}==1){?>
<script src="js/summernote.js"></script>
<script>/*<![CDATA[*/
	$('.seosummernote').summernote({toolbar:[['style',['save','bold','italic','underline','clear','link','codeview']]]});
	$(".modal-header input[type=text],.modal-footer input[type=text]").on({
		keydown:function(event){
			var id=$(this).data("dbid");
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var da=$(this).val();
			if(event.keyCode==46||event.keyCode==8){
				$(this).trigger('keypress');
			}
		},
		keyup:function(event){
			if(event.which==9){
				var id=$(this).data("dbid");
				var t=$(this).data("dbt");
				var c=$(this).data("dbc");
				var da=$(this).val();
				update(id,t,c,da);
				$(this).next("input").focus();
			}
		},
		keypress:function(event){
			var id=$(this).data("dbid");
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var da=$(this).val();
			$('#'+c+'save').removeClass('hidden');
			if(event.which==13){
				update(id,t,c,da);
				event.preventDefault();
			}
		},
		change:function(event){
			var id=$(this).data("dbid");
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var da=$(this).val();
			update(id,t,c,da);
		}
	});
	function update(id,t,c,da){
		$('#'+c).before('<i id="'+c+'" class="busy libre libre-cog libre-spin"></i>');
		$.ajax({
			type:"GET",
			url:"core/update.php",
			data:{
				id:id,
				t:t,
				c:c,
				da:da
			}
		}).done(function(msg){
			$('#'+c).remove();
			$('#'+c+'save').addClass('hidden')
		})
	}
	function updateButtons(id,t,c,da){
		$('#sp').load('core/update.php?id='+id+'&t='+t+'&c='+c+'&da='+escape(da));
	}
/*]]>*/</script>
<?php }
