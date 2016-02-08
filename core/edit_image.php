<?php
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
require'db.php';
$s=$db->prepare("SELECT ".$c." as img FROM ".$t." WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
if($c=='cover'||$c=='file'||$c=='thumb')$r['img']='media/'.$r['img'];
if($c=='coverURL'||$c=='fileURL'){
	if(file_exists('../media/'.$r['img']))$r['img']='media/'.$r['img'];
	else{
		$img=substr($r['img'],strrpos($r['img'],'/')+1);
		copy($r['img'],'../media/'.$img);
		$s=$db->prepare("UPDATE ".$t." SET ".$c."=:img WHERE id=:id");
		$s->execute(array(':img'=>$img,':id'=>$id));
		$r['img']='media/'.$img;
	}
}?>
<div class="modal-header clearfix">
	<button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4>Edit Image</h4>
</div>
<div class="modal-body" style="overflow-y:auto;">
	<div class="col-lg-8">
		<div class="img-container" style="width:550px;height:400px;">
			<img id="crop" src="<?php echo$r['img'];?>" alt="Picture">
		</div>
	</div>
	<div class="col-lg-4">
		<fieldset class="control-fieldset fieldset-sm">
			<legend class="control-legend legend-sm">Crop</legend>
			<div class="img-preview preview-lg"></div>
			<form target="sp" method="post" action="core/crop.php">
				<input type="hidden" name="id" value="<?php echo$id;?>">
				<input type="hidden" name="t" value="<?php echo$t;?>">
				<input type="hidden" name="c" value="<?php echo$c;?>">
				<input type="hidden" id="x" name="x" value="">
				<input type="hidden" id="y" name="y" value="">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Width</div>
						<input type="text" id="w" class="form-control input-sm" name="w" value="">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Height</div>
						<input type="text" id="h" class="form-control input-sm" name="h" value="">
					</div>
				</div>
				<div class="form-group">
					<div class="pull-right">
						<button class="btn btn-default btn-sm" onclick="$('#block').css({'display':'block'});">Crop</button>
					</div>
				</div>
			</form>
		</fieldset>
		<div class="clearfix"></div>
<?php /*
		<fieldset class="control-fieldset fieldset-sm">
			<legend class="control-legend legend-sm">Resize</legend>
<?php list($width, $height) = getimagesize('../'.$r['img']);?>
			<form target="sp" method="post" action="core/resize.php">
				<input type="hidden" name="id" value="<?php echo$r['id'];?>">
				<input type="hidden" name="t" value="<?php echo$t;?>">
				<input type="hidden" name="c" value="<?php echo$c;?>">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Width</div>
						<input type="text" id="resizeWidth" class="form-control input-sm" name="w" value="<?php echo$width;?>" onchange="GetWidth($('#resizeHeight').val(),<?php echo$width;?>,<?php echo$height;?>);">
						<div class="input-group-btn">
							<button class="btn btn-default btn-sm" onclick="$('#resizeWidth').val('<?php echo$width;?>');"><i class="libre libre-recycle"></i></button>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Height</div>
						<input type="text" id="resizeHeight" class="form-control input-sm" name="h" value="<?php echo$height;?>" onchange="GetWidth($(this).val(),<?php echo$width;?>,<?php echo$height;?>);">
						<div class="input-group-btn">
							<button class="btn btn-default btn-sm" onclick="$('#resizeHeight').val('<?php echo$height;?>');"><i class="libre libre-recycle"></i></button>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="pull-right">
						<button class="btn btn-default btn-sm" onclick="$('#block').css({'display':'block'});">Resize</button>
					</div>
				</div>
			</form>
		</fieldset>
*/ ?>
	</div>
</div>
<script>/*<![CDATA[*/
function GetWidth(newHeight,orginalWidth,originalHeight){
	if(currentHeight==0)return newHeight;
	var aspectRatio=currentWidth/currentHeight;
	alert(newHeight*aspectRatio)
}
$('#crop').load(function(){
	$('.img-container > img').cropper({
		aspectRatio:16/9,
		modal:true,
		responsive:true,
		checkImageOrigin:true,
		preview:".img-preview",
		crop:function(data){
			$("#x").val(Math.round(data.x));
			$("#y").val(Math.round(data.y));
			$("#h").val(Math.round(data.height));
			$("#w").val(Math.round(data.width));
  		}
	});
});
/*]]>*/</script>
