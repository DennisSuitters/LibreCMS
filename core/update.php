<script>/*<![CDATA[*/<?php
session_start();
require'db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$col=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
if($tbl=='content'||$tbl=='menu'||$tbl=='seo'&&$col=='notes'){
	$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'da',FILTER_UNSAFE_RAW);
}else{
	$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'da',FILTER_SANITIZE_STRING);
}
$si=session_id();
if(isset($_SESSION['uid'])){
	$uid=(int)$_SESSION['uid'];
	$q=$db->prepare("SELECT rank,username,name FROM login WHERE id=:id");
	$q->execute(array(':id'=>$uid));
	$u=$q->fetch(PDO::FETCH_ASSOC);
	if($u['name']!='')$login_user=$u['name'];else $login_user=$u['username'];
}else{
	$uid=0;
	$u['rank']=0;
	$login_user="Anonymous";
}
if($col=='tis'||$col=='tie'||$col=='due_ti'){
	if($tbl!='orders'){
		$da=strtotime($da);
	}
}
if($tbl=='login'&&$col=='password'){
	require'password.php';
	$da=password_hash($da,PASSWORD_DEFAULT);;
}
$ti=time();
if($tbl=='content'||$tbl=='menu'||$tbl=='seo'){
	$q=$db->prepare("UPDATE $tbl SET eti=:ti,login_user=:login_user,uid=:uid WHERE id=:id");
	$q->execute(array('ti'=>$ti,':uid'=>$uid,':login_user'=>$login_user,':id'=>$id));
}
$q=$db->prepare("UPDATE $tbl SET $col=:da WHERE id=:id");
$q->execute(array(':da'=>$da,':id'=>$id));
$e=$db->errorInfo();
if($tbl=='orders'&&$col=='status'&&$da=='archived'){
	$r=$db->query("SELECT MAX(id) as id FROM orders")->fetch();
	$oid=strtoupper('A').date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
	$q=$db->prepare("UPDATE orders SET aid=:aid,aid_ti=:aid_ti WHERE id=:id");
	$q->execute(array(':aid'=>$oid,':aid_ti'=>$ti,':id'=>$id));
}
if(is_null($e[2])){
	if($tbl=='orders'&&$col=='due_ti'){?>
	window.top.window.$('#due_ti').html('<?php echo date($config['dateFormat'],$da);?>');
<?php }
	if($tbl=='content'&&$col=='file'&&$da==''){
		if(file_exists('../media/file_'.$id.'.jpg')){unlink('../media/file_'.$id.'.jpg');}
		if(file_exists('../media/file_'.$id.'.png')){unlink('../media/file_'.$id.'.png');}
		if(file_exists('../media/file_'.$id.'.gif')){unlink('../media/file_'.$id.'.gif');}
	}
	if($tbl=='orderitems'||$tbl=='cart'){
		if($tbl=='cart'&&$col=='quantity'){
			if($da==0){
				$q=$db->prepare("DELETE FROM cart WHERE id=:id");
				$q->execute(array(':id'=>$id));
				$cnt='';
			}
			$q=$db->prepare("SELECT SUM(quantity) as quantity FROM cart WHERE si=:si");
			$q->execute(array(':si'=>$si));
			$r=$q->fetch(PDO::FETCH_ASSOC);
			$cnt=$r['quantity'];
			if($r['quantity']==0){
				$cnt='';
			}?>
	window.top.window.$('#cart').html('<?php echo$cnt;?>');
<?php	}
		if($tbl=='orderitems'&&$col=='quantity'&&$da==0){
            $q=$db->prepare("DELETE FROM orderitems WHERE id=:id");
            $q->execute(array(':id'=>$id));
		}
		$total=0;
		$content='';
		if($tbl=='cart'){
			$q=$db->prepare("SELECT * FROM cart WHERE si=:si ORDER BY ti DESC");
			$q->execute(array(':si'=>$si));
		}
		if($tbl=='orderitems'){
			$q=$db->prepare("SELECT oid FROM orderitems WHERE id=:id");
			$q->execute(array(':id'=>$id));
			$iid=$q->fetch(PDO::FETCH_ASSOC);
			$q=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid ORDER BY ti DESC");
			$q->execute(array(':oid'=>$iid['oid']));
		}
		if($tbl=='cart'&&$q->rowCount()==0){?>
	window.top.window.$('#content').html('<div class="alert alert-info">You have no Items in the Cart</div>');
<?php	}else{
			$total=0;?>
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
						echo'<input type="hidden" name="t" value="'.$tbl.'">';
						echo'<input type="hidden" name="c" value="title">';
						echo'<input type="text" class="form-control" name="da" value="';
							if($oi['title']!='')
								echo $oi['title'];
							else
								echo $i['title'];
						echo'">';
					echo'</form>';
				echo'</td>';
				echo'<td class="col-md-1 text-center">';
				if($oi['iid']!=0){
                    echo'<form target="sp" action="includes/update.php">';
                        echo'<input type="hidden" name="id" value="'.$oi['id'].'">';
                        echo'<input type="hidden" name="t" value="'.$tbl.'">';
                        echo'<input type="hidden" name="c" value="quantity">';
                        echo'<input class="form-control text-center" name="da" value="'.$oi['quantity'].'">';
                    echo'</form>';
				}
				echo'</td>';
				echo'<td class="col-md-1 text-right">';
				if($oi['iid']!=0){
                        echo'<form target="sp" action="includes/update.php">';
                            echo'<input type="hidden" name="id" value="'.$oi['id'].'">';
                            echo'<input type="hidden" name="t" value="'.$tbl.'">';
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
					echo'<input type="hidden" name="t" value="'.$tbl.'">';
					echo'<input type="hidden" name="c" value="quantity">';
					echo'<input type="hidden" name="da" value="0">';
					echo'<button class="btn btn-danger"><i class="fa fa-trash"></i></button>';
				echo'</form>';
			echo'</td>';
		echo'</tr>';
            if($oi['iid']!=0){
                $total=$total+($oi['cost']*$oi['quantity']);
            }
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
<?php	}
	}
		if($tbl=='login'&&$col=='gravatar'){
			if($da==''){
				$sav=$db->prepare("SELECT avatar FROM login WHERE id=:id");
				$sav->execute(array(':id'=>$id));
				$av=$sav->fetch(PDO::FETCH_ASSOC);
				if($av['avatar']!=''&&file_exists('../files/'.$av['avatar'])){
					$avatar='files/'.$av['avatar'];
				}else{
					$avatar='images/noavatar.jpg';
				}
			}else{
				$avatar=$da;
			}?>
	window.top.window.$('#avatar').attr('src','<?php echo$avatar;?>');
<?php	}
	}
if($col=='status'){
	if($da=='archived'){?>
	window.top.window.$('#l_<?php echo$id;?>').slideUp(500,function(){$(this).remove()});
<?php }
	if($tbl!='comments'||$da=='delete'||$da==''){?>
	window.top.window.$('#controls_<?php echo$id;?> button.btn').toggleClass('hidden');
<?php }
	if($da=='delete'){?>
	window.top.window.$('#l_<?php echo$id;?>').addClass('danger');
<?php }else{?>
	window.top.window.$('#l_<?php echo$id;?>').removeClass('danger');
<?php }
}?>
	window.top.window.$('#block').css("display","none");
/*]]>*/</script>
