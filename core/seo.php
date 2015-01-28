<?php
session_start();
include'db.php';
if(isset($_SESSION['uid'])){
	$uid=(int)$_SESSION['uid'];
	$s=$db->prepare("SELECT * FROM login WHERE id=:id");
	$s->execute(array(':id'=>$uid));
	$user=$s->fetch(PDO::FETCH_ASSOC);
}
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT * FROM seo WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
?>
<style>
	#seo .form-inline{
		margin-bottom:5px;
	}
	#seo .control-label{
		width:100px;
		text-align:right;
		padding-right:10px;
		vertical-align:top;
	}
	#seo .input-group{
		width:708px;
	}
	#seo input{
		width:100%;
	}
	#seo .input-group.half{
		width:300px;
	}
</style>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<?php if($user['rank']>699){?>
	<div class="form-inline">
		<div class="form-group">
			<label for="seo_title" class="control-label">Title</label>
			<div class="input-group half">
				<input type="text" id="seo_title" class="form-control" name="seo_title" value="<?php echo$r['seo_title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="seo" data-dbc="seo_title" placeholder="Enter a Title...">
				<div id="seo_titlesave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
			</div>
		</div>
	</div>
<?php }else{?>
	<h4 class="modal-title"><?php echo$r['title'];?></h4>
<?php }?>
</div>
<div class="modal-body">
<?php if($user['rank']>699){?>
	<form method="post" target="sp" action="core/update.php">
		<input type="hidden" name="id" value="<?php echo$r['id'];?>">
		<input type="hidden" name="t" value="seo">
		<input type="hidden" name="c" value="notes">
		<textarea id="notes" class="summernote2" name="da"><?php echo$r['notes'];?></textarea>
	</form>
<?php }else{
	echo$r['notes'];
}?>
</div>
<div class="modal-footer">
	<small class="help-block text-right">
		Last Update: <?php echo date($config['dateFormat'],$r['eti']);?>
	</small>
</div>
<?php if($user['rank']>699){?>}
<script src="js/summernote.js"></script>
<script>/*<![CDATA[*/
	$('.summernote2').summernote({toolbar:[['style',['save','bold','italic','underline','clear']]]});
	$(".modal-header input[type=text]").on({
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
		$('#'+c).before('<i id="'+c+'" class="busy fa fa-cog fa-spin"></i>');
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
