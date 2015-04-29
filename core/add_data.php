<?php
echo'<script>/*<![CDATA[*/';
session_start();
include'db.php';
include'zebra_image.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
define('SESSIONID',session_id());
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
define('THEME','../layout/'.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$theme=parse_ini_file(THEME.'/theme.ini',true);
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
if($act!=''){
	$uid=isset($_SESSION['uid'])?(int)$_SESSION['uid']:0;
	$ip=$_SERVER['REMOTE_ADDR'];
	$error=0;
	$ti=time();
	switch($act){
		case'add_social':
			$user=filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT);
			$icon=filter_input(INPUT_POST,'icon',FILTER_SANITIZE_STRING);
			$url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL);
			if(filter_var($url,FILTER_VALIDATE_URL)){
				if($icon=='none'||$url==''){?>
	window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'Data not Entirely Entered'}}).show();
<?php			}else{
					$q=$db->prepare("INSERT INTO choices (uid,icon,url) VALUES (:uid,:icon,:url)");
					$q->execute(array(':uid'=>$user,':icon'=>$icon,':url'=>$url));
					$id=$db->lastInsertId();
					$e=$db->errorInfo();
					if(is_null($e[2])){?>
	window.top.window.$('#social').append('<div id="l_<?php echo$id;?>" class="form-group"><label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">&nbsp;</label><div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8"><div class="input-group-addon">Network</div><div class="input-group-addon"><i class="fa fa-<?php echo$icon;?>"></i></div><div class="input-group-addon">URL</div><form target="sp" method="post" action="includes/update.php"><input type="hidden" name="t" value="social"><input type="hidden" name="c" value="url"><input type="text"class="form-control" name="da" value="<?php echo$url;?>" placeholder="Enter a URL..."></form><div class="input-group-btn"><form target="sp" action="includes/purge.php"><input type="hidden" name="id" value="<?php echo$id;?>"><input type="hidden" name="t" value="choices"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></form></div></div></div>');
<?php				}else{?>
	window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'There was an issue adding the Social Networking Link'}}).show();
<?php				}
				}
			}else{?>
	window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'The URL entered is not valid'}}).show();
<?php		}
			break;
	case'make_client':
		$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
		$q=$db->prepare("SELECT name,email,phone FROM messages WHERE id=:id");
		$q->execute(array(':id'=>$id));
		$r=$q->fetch(PDO::FETCH_ASSOC);
		$q=$db->prepare("INSERT INTO login (name,email,phone,ti) VALUES (:name,:email,:phone,:ti)");
		$q->execute(array(':name'=>$r[name],':email'=>$r['email'],':phone'=>$r['phone'],':ti'=>$ti));
		$e=$db->errorInfo();
		if(is_null($e[2])){?>
	window.top.window.$('.notifications').notify({type:'success',icon:'',message:{text:'Contact added as Client'}}).show();
<?php	}else{?>
	window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'There was an issue Adding new Client'}}).show();
<?php	}
		break;
	case'add_comment':
		$rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$q=$db->prepare("SELECT * FROM login WHERE email=:email");
			$q->execute(array(':email'=>$email));
			$c=$q->fetch(PDO::FETCH_ASSOC);
			if($c['id']!=0){
				$cid=$c['id'];
			}else{
				$cid=0;
			}
			$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
			$contentType=filter_input(INPUT_POST,'contentType',FILTER_SANITIZE_STRING);
			$da=filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING);
			$status='unapproved';
			$q=$db->prepare("INSERT INTO comments (contentType,rid,uid,cid,ip,name,email,notes,status,ti) VALUES (:contentType,:rid,:uid,:cid,:ip,:name,:email,:notes,:status,:ti)");
			$q->execute(array(':contentType'=>$contentType,':rid'=>$rid,':uid'=>$uid,':cid'=>$cid,':ip'=>$ip,':name'=>$name,':email'=>$email,':notes'=>$da,':status'=>$status,':ti'=>$ti));
			$id=$db->lastInsertId();
			$e=$db->errorInfo();
			if(is_null($e[2])){
				if($c['gravatar']!=''){
					$avatar='http://www.gravatar.com/avatar/'.md5($c['gravatar']);
				}elseif($c['avatar']!=''&&file_exists('../media/'.$c['avatar'])){
					$avatar='media/'.$c['avatar'];
				}else{
					$avatar='core/images/noavatar.jpg';
				}
				$html='<div id="l_'.$id.'" class="media bg-danger"><div class="media-object pull-left"><img class="commentavatar img-thumbnail" alt="User" src="'.$avatar.'"></div><div class="media-body"><h4 class="media-heading">Name</h4>'.$da.'</div><hr></div>';?>
	window.top.window.$('.notifications').notify({type:'success',icon:'',message:{text:'New comment Added, Awaiting Approval'}}).show();
	window.top.window.$('#comments').append('<?php echo$html;?>');
<?php		}else{?>
	window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'There was an issue adding your Comment'}}).show();
<?php		}
		}else{?>
	window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'The Email entered is not valid'}}).show();
<?php	}
		break;
	case'add_image':
	case'add_cover':
	case'add_avatar':
		$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
		$col=filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING);
		$fu=$_FILES['fu'];
		if(isset($_FILES['fu'])){
			$ft=$_FILES['fu']['type'];
			if($ft=="image/jpeg"||$ft=="image/pjpeg"||$ft=="image/png"||$ft=="image/gif"){
				$tp="../media/".basename($_FILES['fu']['name']);
				if(move_uploaded_file($_FILES['fu']['tmp_name'],$tp)){
					if($ft=="image/jpeg"||$ft=="image/pjpeg"){
						$fn=$col.'_'.$id.'.jpg';
						$fn2='thumb_'.$id.'.jpg';
					}
					if($ft=="image/png"){
						$fn=$col.'_'.$id.'.png';
						$fn2='thumb_'.$id.'.png';
					}
					if($ft=="image/gif"){
						$fn=$col.'_'.$id.'.gif';
						$fn2='thumb_'.$id.'.gif';
					}
					$ord=$db->query("SELECT MAX(ord) as ord FROM content")->fetch(PDO::FETCH_ASSOC);
					$ord['ord']++;
					if($act=='add_image'&&$col=='file'){
						$q=$db->prepare("UPDATE content SET thumb=:thumb,file=:file,ord=:ord WHERE id=:id");
						$q->execute(array(':thumb'=>$fn2,':file'=>$fn,':ord'=>$ord['ord'],':id'=>$id));
						$image=new Zebra_image();
						$image->source_path=$tp;
						$image->target_path='../media/'.$fn2;
						$image->resize(150,150,ZEBRA_IMAGE_CROP_CENTER);
						rename($tp,'../media/'.$fn);
						chmod("../media/".$fn,0777);
						chmod("../media/".$fn2,0777);?>
	window.top.window.$('#file').html('<img src="media/<?php echo$fn.'?'.$ti;?>">');
	window.top.window.$('#thumb').html('<img src="media/<?php echo$fn2.'?'.$ti;?>">');
<?php				}
					if($act=='add_avatar'){
						$fn='avatar'.$fn;
						$q=$db->prepare("UPDATE login SET avatar=:avatar WHERE id=:id");
						$q->execute(array(':avatar'=>$fn,':id'=>$id));
						$image=new Zebra_image();
						$image->source_path=$tp;
						$image->target_path='../media/'.$fn;
						$image->resize(150,150,ZEBRA_IMAGE_CROP_CENTER);
						rename($tp,'../media/'.$fn);?>
	window.top.window.$('#avatar').attr('src','media/<?php echo$fn;?>');
<?php				}
					if($col=="thumb"){
						$q=$db->prepare("UPDATE content SET thumb=:thumb WHERE id=:id");
						$q->execute(array(':thumb'=>$fn2,':id'=>$id));
						$image=new Zebra_image();
						$image->source_path=$tp;
						$image->target_path='../media/'.$fn2;
						$image->resize(150,150,ZEBRA_IMAGE_CROP_CENTER);?>
	window.top.window.$('#thumb').html('<img src="media/<?php echo$fn2;?>">');
<?php				}
//					if(file_exists('../media/'.$fn)){
//						chmod("../media/".$fn,0777);
//						unlink('../media/'.$fn);
//					}
//					if(file_exists('../media/'.$fn2)){
//						chmod("../media/".$fn2,0777);
//						unlink('../media/'.$fn2);
//					}
				}
			}
		}?>
	window.top.window.$('#block').css("display","none");		
<?php	break;
	case'add_media':
		$nf=count($_FILES['file']['tmp_name']);
		for($i=0;$i<$nf;$i++){
			if($_FILES['file']['name'][$i]){
				if(!$_FILES['file']['error'][$i]){
					$file=strtolower($_FILES['file']['name'][$i]);
					$file=str_replace(' ','_',$file);
					$destination='../media/'.$file;
					$location=$_FILES["file"]["tmp_name"][$i];
					move_uploaded_file($location,$destination);
					$finfo=new finfo(FILEINFO_MIME_TYPE);
					$type=$finfo->file('../media/'.$file);
					$img='<span class="filetype img-thumbnail"><i class="fa fa-file-o fa-5x"></i></span>';
					if($type=='application/msword'||$type=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'||$type=='application/vnd.openxmlformats-officedocument.wordprocessingml.template'||$type=='application/rtf'||$type=='application/x-rtf'||$type=='text/richtext'||$type=='application/rtf'||$type=='text/richtext'){
						$img='<span class="filetype img-thumbnail"><i class="fa fa-word-pdf-o fa-5x"></i></span>';
					}elseif($type=='audio/mpeg3'||$type=='audio/x-mpeg-3'){
						$img='<span class="filetype img-thumbnail"><i class="fa fa-file-audio-o fa-5x"></i></span>';
					}elseif($type=='application/x-troff-msvideo'||$type=='video/avi'||$type=='video/msvideo'||$type=='video/x-msvideo'||$type=='video/mp4'||$type=='video/mpeg'||$type=='audio/mpeg'){
						$img='<span class="filetype img-thumbnail"><i class="fa fa-file-video-o fa-5x"></i></span>';
					}elseif($type=='application/pdf'){
						$img='<span class="filetype img-thumbnail"><i class="fa fa-file-pdf-o fa-5x"></i></span>';
					}elseif($type=='application/x-rar-compressed'||$type=='application/x-compressed'||$type=='application/x-zip-compressed'||$type=='application/zip'||$type=='multipart/x-zip'||$type=='application/gnutar'||$type=='application/x-compressed'){
						$img='<span class="filetype img-thumbnail"><i class="fa fa-archive-pdf-o fa-5x"></i></span>';
					}elseif($type=='text/plain'){
						$img='<span class="filetype img-thumbnail"><i class="fa fa-text-pdf-o fa-5x"></i></span>';
					}else{
						$img='<a title="'.$file.'" href="media/'.$file.'"><img src="media/'.$file.'" class="img-thumbnail"></a>';
					}?>
	window.top.window.$('#media').append('<li id="l_<?php echo str_replace('.','',$file);?>" class="gallery relative"><?php echo$img;?><div id="controls_<?php echo str_replace('.','',$file);?>" class="controls"><button class="btn btn-danger btn-xs" onclick="removeMedia(\'<?php echo$file;?>\');"><i class="fa fa-trash"></i></button></div><div class="title"><?php echo$file;?></div></li>');
<?php			}
			}
		}?>
	window.top.window.$('#block').css("display","none");
<?php	break;
	case'add_orderitem':
		$oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
		$iid=filter_input(INPUT_GET,'iid',FILTER_SANITIZE_NUMBER_INT);
		if($iid!=0){
			$q=$db->prepare("SELECT title,cost FROM content WHERE id=:id");
			$q->execute(array(':id'=>$iid));
			$r=$q->fetch(PDO::FETCH_ASSOC);
		}else{
			$r=array('title'=>'','cost'=>0);
		}
		$q=$db->prepare("INSERT INTO orderitems (oid,iid,title,quantity,cost,ti) VALUES (:oid,:iid,:title,'1',:cost,:ti)");
		$q->execute(array(
			':oid'=>$oid,
			':iid'=>$iid,
			':title'=>$r['title'],
			':cost'=>$r['cost'],
			':ti'=>$ti
		));
		$total=0;
		$html='';
		$q=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid ORDER BY ti DESC");
		$q->execute(array(':oid'=>$oid));?>
	window.top.window.$('#updateorder').html('<?php
		while($oi=$q->fetch(PDO::FETCH_ASSOC)){
			$s=$db->prepare("SELECT * FROM content WHERE id=:id");
			$s->execute(array(':id'=>$oi['iid']));
			$i=$s->fetch(PDO::FETCH_ASSOC);
			echo'<tr>';
				echo'<td class="text-left">'.$i['code'].'</td>';
				echo'<td class="text-left">';
					echo'<form target="sp" action="includes/update.php">';
						echo'<input type="hidden" name="id" value="'.$oi['id'].'">';
						echo'<input type="hidden" name="t" value="orderitems">';
						echo'<input type="hidden" name="c" value="title">';
						echo'<input type="text" class="form-control" name="da" value="';
							if($oi['title']!='')
								echo$oi['title'];
							else
								echo$i['title'];
						echo'">';
					echo'</form>';
				echo'</td>';
				echo'<td class="col-md-1 text-center">';
				if($oi['iid']!=0){
                    echo'<form target="sp" action="includes/update.php">';
                        echo'<input type="hidden" name="id" value="'.$oi['id'].'">';
                        echo'<input type="hidden" name="t" value="orderitems">';
                        echo'<input type="hidden" name="c" value="quantity">';
                        echo'<input class="form-control text-center" name="da" value="'.$oi['quantity'].'">';
                    echo'</form>';
				}
				echo'</td>';
				echo'<td class="col-md-1 text-right">';
				if($oi['iid']!=0){
                    echo'<form target="sp" action="includes/update.php">';
                        echo'<input type="hidden" name="id" value="'.$oi['id'].'">';
                        echo'<input type="hidden" name="t" value="orderitems">';
                        echo'<input type="hidden" name="c" value="cost">';
                        echo'<input class="form-control text-center" name="da" value="'.$oi['cost'].'">';
                    echo'</form>';
				}
				echo'</td>';
			echo'<td class="text-right">';
				if($oi['iid']!=0){
					echo $oi['cost']*$oi['quantity'];
				}
			echo'</td>';
			echo'<td class="text-right">';
				echo'<form target="sp" action="includes/update.php">';
					echo'<input type="hidden" name="id" value="'.$oi['id'].'">';
					echo'<input type="hidden" name="t" value="orderitems">';
					echo'<input type="hidden" name="c" value="quantity">';
					echo'<input type="hidden" name="da" value="0">';
					echo'<button class="btn btn-danger"><i class="fa fa-trash"></i></button>';
				echo'</form>';
			echo'</td>';
		echo'</tr>';
			$total=$total+($oi['cost']*$oi['quantity']);
		}
		echo'<tr>';
			echo'<td colspan="3">&nbsp;</td>';
			echo'<td class="text-right">';
				echo'<strong>Total</strong>';
			echo'</td>';
			echo'<td class="text-right">';
				echo'<strong>'.$total.'</strong>';
			echo'</td>';
			echo'<td></td>';
		echo'</tr>';
?>');
<?php	break;
	}
}
//	window.top.window.$('#busy').css("display","none");?>
<?php echo'/*]]>*/</script>';
