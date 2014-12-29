<div class="btn-add col-md-4">
	<form method="post" target="sp" enctype="multipart/form-data" action="includes/add_data.php">
		<div class="form-group">
			<div class="input-group">
				<input type="file" name="file[]" class="form-control" multiple>
				<input type="hidden" name="act" value="add_media">
				<div class="input-group-btn">
					<button class="btn btn-success" onclick="$('#block').css({'display':'block'});">Upload</button>
				</div>
			</div>
		</div>
	</form>
</div>
<ul id="media" class="sortable grid">
<?php $path='media/';
	$upload_dir='media/';
	$handle=opendir($upload_dir);
	while($file=readdir($handle)){
		if(!is_dir($upload_dir.$file)&&!is_link($upload_dir.$file)){
			$docs[]=$file;
		}
	}
	if(isset($docs)){
		sort($docs);
		$i=0;
		foreach($docs as $key=>$file){
			if($file=='.gitkeep')continue;
			$finfo=new finfo(FILEINFO_MIME_TYPE);
			$type=$finfo->file('media/'.$file);
			if($type=='application/msword'||$type=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'||$type=='application/vnd.openxmlformats-officedocument.wordprocessingml.template'||$type=='application/rtf'||$type=='application/x-rtf'||$type=='text/richtext'||$type=='application/rtf'||$type=='text/richtext'){
				$img='<span class="filetype img-thumbnail"><i class="fa fa-file-word-pdf-o fa-8x"></i></span>';
			}elseif($type=='audio/mpeg3'||$type=='audio/x-mpeg-3'||$type=='audio/mpeg'){
				$img='<span class="filetype img-thumbnail"><i class="fa fa-file-audio-o fa-8x"></i></span>';
			}elseif($type=='application/x-troff-msvideo'||$type=='video/avi'||$type=='video/msvideo'||$type=='video/x-msvideo'||$type=='video/mp4'||$type=='video/mpeg'||$type=='video/x-ms-wmv'){
				$img='<span class="filetype img-thumbnail"><i class="fa fa-file-video-o fa-8x"></i></span>';
			}elseif($type=='application/pdf'){
				$img='<span class="filetype img-thumbnail"><i class="fa fa-file-pdf-o fa-8x"></i></span>';
			}elseif($type=='application/x-rar-compressed'||$type=='application/x-compressed'||$type=='application/x-zip-compressed'||$type=='application/zip'||$type=='multipart/x-zip'||$type=='application/gnutar'||$type=='application/x-compressed'){
				$img='<span class="filetype img-thumbnail"><i class="fa fa-file-archive-o fa-8x"></i></span>';
			}elseif($type=='text/plain'){
				$img='<span class="filetype img-thumnail"><i class="fa fa-file-text-o fa-8x"></i></span>';
			}elseif($type=='image/pjpeg'||$type=='image/jpeg'||$type=='image/bmp'||$type=='image/gif'||$type=='image/png'){
				$img='<a title="'.$file.'" href="media/'.$file.'" data-lightbox-gallery="'.$view.'" rel="'.$view.'"><img src="media/'.$file.'" class="img-thumbnail"></a>';
			}else{
				$img='<span class="filetype img-thumbnail"><i class="fa fa-file-o fa-8x"></i></span>';
			}?>
	<li id="l_<?php echo str_replace('.','',$file);?>" class="gallery">
		<?php echo $img;?>
		<div id="controls_<?php echo str_replace('.','',$file);?>" class="controls">
			<button class="btn btn-danger btn-xs" onclick="removeMedia('<?php echo $file;?>')"><i class="fa fa-trash"></i></button> 
		</div>
		<div class="title"><?php echo $file;?></div>
	</li>
<?php 	}?>
</ul>
<?php }
