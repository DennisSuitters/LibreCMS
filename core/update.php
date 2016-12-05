<script>/*<![CDATA[*/
<?php
session_start();
require'db.php';
require'sanitise.php';
define('DS',DIRECTORY_SEPARATOR);
function svg($svg){
	$s=file_get_contents('svg/libre-'.$svg.'.svg');
	return '<i class="libre">'.$s.'</i>';
}
$e='';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$col=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
if($tbl=='content'||$tbl=='menu'||$tbl=='config'&&$col=='notes'||$col=='PasswordResetLayout'||$col=='orderEmailLayout'||$col=='orderEmailNotes'||$col=='passwordResetLayout'||$col=='accountActivationLayout'||$col=='bookingEmailLayout'||$col=='bookingAutoReplyLayout'||$col=='contactAutoReplyLayout'||$col=='dateFormat'){
    $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'da',FILTER_UNSAFE_RAW);
}else{
    $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'da',FILTER_SANITIZE_STRING);
    $da=kses($da,array());
}
if(strlen($da)<12&&$da=='<p><br></p>')$da=str_replace('<p><br></p>','',$da);
$si=session_id();
$ti=time();
$s=$db->prepare("SELECT * FROM ".$tbl." WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
$oldda=$r[$col];
if($col=='tis')$da=strtotime($da);
if($col=='tie')$da=strtotime($da);
if($col=='pti')$da=strtotime($da);
if($tbl=='content'&&$col=='status'&&$da=='published'){
    $q=$db->prepare("UPDATE content SET pti=:pti WHERE id=:id");
    $q->execute(array(':pti'=>$ti,':id'=>$id));
}
if($tbl=='config'||$tbl=='login'||$tbl=='orders'||$tbl=='orderitems'||$tbl=='messages')$r['contentType']='';
$log=['uid'=>0,'rid'=>$id,'view'=>$r['contentType'],'contentType'=>$r['contentType'],'refTable'=>$tbl,'refColumn'=>$col,'oldda'=>$oldda,'newda'=>$da,'action'=>'update','ti'=>$ti];
if($r['contentType']=='booking')$log['view']=$r['contentType'].'s';
if(isset($_SESSION['uid'])){
    $uid=(int)$_SESSION['uid'];
    $q=$db->prepare("SELECT rank,username,name FROM login WHERE id=:id");
    $q->execute(array(':id'=>$uid));
    $u=$q->fetch(PDO::FETCH_ASSOC);
    if($u['name']!='')
        $login_user=$u['name'];
    else
        $login_user=$u['username'];
    $log['uid']=$uid;
}else{
    $uid=0;
    $u['rank']=0;
    $login_user="Anonymous";
}
if($tbl=='login'&&$col=='password'){
    $da=password_hash($da,PASSWORD_DEFAULT);
    $log['action']='update password';
    $log['oldda']='';
    $log['newda']='';
}
if($tbl=='content'||$tbl=='menu'){
    $q=$db->prepare("UPDATE $tbl SET eti=:ti,login_user=:login_user,uid=:uid WHERE id=:id");
    $q->execute(array('ti'=>$ti,':uid'=>$uid,':login_user'=>$login_user,':id'=>$id));
}
if($tbl=='login'&&$col=='username'){
    $uc1=$db->prepare("SELECT username FROM login WHERE username=:da");
    $uc1->execute(array(':da'=>$da));
    if($uc1->rowCount()<1){
        $q=$db->prepare("UPDATE login SET username=:da WHERE id=:id");
        $q->execute(array(':da'=>$da,':id'=>$id));?>
window.top.window.$('#uerror').addClass('hidden');
<?php  }else{
        $uc2=$db->prepare("SELECT username FROM login WHERE id=:id");
        $uc2->execute(array(':id'=>$id));
        $uc=$uc2->fetch(PDO::FETCH_ASSOC);?>
window.top.window.$('#uerror').removeClass('hidden');
<?php }
}else{
    $q=$db->prepare("UPDATE $tbl SET $col=:da WHERE id=:id");
    $q->execute(array(':da'=>$da,':id'=>$id));
}
$e=$db->errorInfo();
if($tbl=='orders'&&$col=='status'&&$da=='archived'){
    $r=$db->query("SELECT MAX(id) as id FROM orders")->fetch();
    $oid=strtoupper('A').date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
    $q=$db->prepare("UPDATE orders SET aid=:aid,aid_ti=:aid_ti WHERE id=:id");
    $q->execute(array(':aid'=>$oid,':aid_ti'=>$ti,':id'=>$id));
}
if(is_null($e[2])){
if($tbl=='orders'&&$col=='due_ti'){?>
window.top.$("#due_ti").val("<?php echo date($config['dateFormat'],$da);?>");
<?php }
if($tbl=='content'&&$col=='file'&&$da==''){
    if(file_exists('..'.DS.'media'.DS.'file_'.$id.'.jpg'))unlink('..'.DS.'media'.DS.'file_'.$id.'.jpg');
    if(file_exists('..'.DS.'media'.DS.'file_'.$id.'.png'))unlink('..'.DS.'media'.DS.'file_'.$id.'.png');
    if(file_exists('..'.DS.'media'.DS.'file_'.$id.'.gif'))unlink('..'.DS.'media'.DS.'file_'.$id.'.gif');
	if(file_exists('..'.DS.'media'.DS.'file_'.$id.'.tif'))unlink('..'.DS.'media'.DS.'file_'.$id.'.tif');
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
        if($r['quantity']==0)$cnt='';?>
window.top.window.$('#cart').html('<?php echo$cnt;?>');
<?php	}
        if($tbl=='orderitems'){
            $q=$db->prepare("SELECT oid FROM orderitems WHERE id=:id");
            $q->execute(array(':id'=>$id));
            $iid=$q->fetch(PDO::FETCH_ASSOC);
        }
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
            $q=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid ORDER BY ti ASC,title ASC");
            $q->execute(array(':oid'=>$iid['oid']));
        }
        $html='';
        $total=0;
        while($oi=$q->fetch(PDO::FETCH_ASSOC)){
            $s=$db->prepare("SELECT * FROM content WHERE id=:id");
            $s->execute(array(':id'=>$oi['iid']));
            $i=$s->fetch(PDO::FETCH_ASSOC);
            $html.='<tr><td class="text-left">'.$i['code'].'</td><td class="text-left"><form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="'.$tbl.'"><input type="hidden" name="c" value="title"><input type="text" class="form-control" name="da" value="';if($oi['title']!='')$html.=$oi['title'];else$html.=$i['title'];$html.='"></form></td><td class="col-md-1 text-center">';
            if($oi['iid']!=0)$html.='<form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="quantity"><input class="form-control text-center" name="da" value="'.$oi['quantity'].'"></form>';
            $html.='</td><td class="col-md-1 text-right">';
            if($oi['iid']!=0)$html.='<form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="cost"><input class="form-control text-center" name="da" value="'.$oi['cost'].'"></form>';
            $html.='</td><td class="text-right">';
            if($oi['iid']!=0)$html.=$oi['cost']*$oi['quantity'];
            $html.='</td><td class="text-right"><form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="quantity"><input type="hidden" name="da" value="0"><button class="btn btn-default trash">'.svg('trash').'</button></form></td></tr>';
            if($oi['iid']!=0)$total=$total+($oi['cost']*$oi['quantity']);
        }
        $html.='<tr><td colspan="3">&nbsp;</td><td class="text-right"><strong>Total</strong></td><td class="text-right"><strong>'.$total.'</strong></td><td></td></tr>';?>
window.top.window.$('#updateorder').html('<?php echo$html;?>');
<?php }
    if($tbl=='login'&&$col=='gravatar'){
        if($da==''){
            $sav=$db->prepare("SELECT avatar FROM login WHERE id=:id");
            $sav->execute(array(':id'=>$id));
            $av=$sav->fetch(PDO::FETCH_ASSOC);
            if($av['avatar']!=''&&file_exists('..'.DS.'media'.DS.'avatar'.DS.$av['avatar']))$avatar='media'.DS.'avatar'.DS.$av['avatar'];else$avatar='images'.DS.'noavatar.jpg';
            }else$avatar=$da;?>
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
<?php $s=$db->prepare("INSERT INTO logs (uid,rid,view,contentType,refTable,refColumn,oldda,newda,action,ti) VALUES (:uid,:rid,:view,:contentType,:refTable,:refColumn,:oldda,:newda,:action,:ti)");
$s->execute(array(':uid'=>$log['uid'],':rid'=>$log['rid'],':view'=>$log['view'],':contentType'=>$log['contentType'],':refTable'=>$log['refTable'],':refColumn'=>$log['refColumn'],':oldda'=>$log['oldda'],':newda'=>$log['newda'],':action'=>$log['action'],':ti'=>$log['ti']));
