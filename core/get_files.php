<?php
$path='media/';
$upload_dir='../media/';
$handle=opendir($upload_dir);
while($file=readdir($handle)){
	if(!is_dir($upload_dir.$file)&&!is_link($upload_dir.$file)){
		$finfo=new finfo(FILEINFO_MIME_TYPE);
		$type=$finfo->file($upload_dir.$file);
		if($type=='application/x-troff-msvideo'||$type=='video/avi'||$type=='video/msvideo'||$type=='video/x-msvideo'||$type=='application/msword'||$type=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'||$type=='application/vnd.openxmlformats-officedocument.wordprocessingml.template'||$type=='application/x-debian-package'||$type=='application/acad'||$type=='image/vnd.dwg'||$type=='image/x-dwg'||$type=='audio/mpeg3'||$type=='audio/x-mpeg-3'||$type=='video/mp4'||$type=='image/vnd.dxf'||$type=='video/mpeg'||$type=='audio/mpeg'||$type=='application/pdf'||$type=='application/mspowerpoint'||$type=='application/powerpoint'||$type=='application/vnd.ms-powerpoint'||$type=='application/x-mspowerpoint'||$type=='application/vnd.openxmlformats-officedocument.presentationml.template'||$type=='application/vnd.openxmlformats-officedocument.presentationml.slideshow'||$type=='application/vnd.openxmlformats-officedocument.presentationml.presentation'||$type=='application/vnd.openxmlformats-officedocument.presentationml.slide'||$type=='application/octet-stream'||$type=='application/x-rar-compressed'||$type=='application/rtf'||$type=='application/x-rtf'||$type=='text/richtext'||$type=='application/rtf'||$type=='text/richtext'||$type=='application/gnutar'||$type=='application/x-compressed'||$type=='application/x-bittorrent'||$type=='text/plain'||$type=='application/excel'||$type=='application/vnd.ms-excel'||$type=='application/x-excel'||$type=='application/x-msexcel'||$type=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'||$type=='application/vnd.openxmlformats-officedocument.spreadsheetml.template'||$type=='application/vnd.ms-excel.addin.macroEnabled.12'||$type=='application/vnd.ms-excel.sheet.binary.macroEnabled.12'||$type=='application/x-compressed'||$type=='application/x-zip-compressed'||$type=='application/zip'||$type=='multipart/x-zip'){
			$docs[]=$file;
		}
	}
}
if($docs){
	sort($docs);
	foreach($docs as $key=>$file){
			$array[]=array(
				'file'=>$upload_dir.$file,
				'title'=>$file
			);
	}
	echo stripslashes(json_encode($array));
}
