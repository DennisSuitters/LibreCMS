<script>/*<![CDATA[*/
<?php
session_start();
require'db.php';
require'zebra_image.php';
require'sanitise.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)
    define('PROTOCOL','https://');
else
    define('PROTOCOL','http://');
define('SESSIONID',session_id());
define('DS',DIRECTORY_SEPARATOR);
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
define('THEME','..'.DS.'layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
function svg($svg,$size=null,$color=null){
	echo'<i class="libre';
	if($size!=null)echo' libre-'.$size;
	if($color!=null)echo' libre-'.$color;
	echo'">';
	include'svg/libre-'.$svg.'.svg';
	echo'</i>';
}
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
if($act!=''){
    $uid=isset($_SESSION['uid'])?(int)$_SESSION['uid']:0;
    $ip=$_SERVER['REMOTE_ADDR'];
    $error=0;
    $ti=time();
    switch($act){
        case'add_dashrss':
            $url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL);
            if(filter_var($url,FILTER_VALIDATE_URL)){
                $q=$db->prepare("INSERT INTO choices (uid,contentType,url,ti) VALUES (:uid,'dashrss',:url,'0')");
                $q->execute(array(':uid'=>$uid,':url'=>$url));
                $id=$db->lastInsertId();
                $e=$db->errorInfo();
                if(is_null($e[2])){?>
window.top.window.$('#rss').append('<div id="l_<?php echo$id;?>" class="form-group"><label class="control-label hidden-xs col-sm-3 col-md-3 col-lg-2">&nbsp;</label><div class="input-group col-xs-12 col-sm-9 col-md-9 col-lg-10"><form target="sp" method="post" action="core/update.php"><input type="hidden" name="t" value="choices"><input type="hidden" name="c" value="url"><input type="text"class="form-control" name="da" value="<?php echo$url;?>" placeholder="Enter a URL..."></form><div class="input-group-btn"><form target="sp" action="core/purge.php"><input type="hidden" name="id" value="<?php echo$id;?>"><input type="hidden" name="t" value="choices"><button class="btn btn-default trash"><?php svg('trash');?></button></form></div></div></div>');
<?php           }else{?>
window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'There was an issue adding the RSS URL'}}).show();
<?php           }
            }
            break;
        case'add_social':
            $user=filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT);
            $icon=filter_input(INPUT_POST,'icon',FILTER_SANITIZE_STRING);
            $url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL);
            if(filter_var($url,FILTER_VALIDATE_URL)){
                if($icon=='none'||$url==''){?>
    window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'Data not Entirely Entered'}}).show();
<?php           }else{
                    $user=kses($user,array());
                    $url=kses($url,array());
                    $q=$db->prepare("INSERT INTO choices (uid,contentType,icon,url) VALUES (:uid,'social',:icon,:url)");
                    $q->execute(array(':uid'=>$user,':icon'=>$icon,':url'=>$url));
                    $id=$db->lastInsertId();
                    $e=$db->errorInfo();
                    if(is_null($e[2])){?>
    window.top.window.$('#social').append('<div id="l_<?php echo$id;?>" class="form-group"><label class="control-label hidden-xs col-sm-3 col-md-3 col-lg-2">&nbsp;</label><div class="input-group col-xs-12 col-sm-9 col-md-9 col-lg-10"><div class="input-group-addon"><span class="libre-social"><?php svg('social-'.$icon);?></span></div><form target="sp" method="post" action="core/update.php"><input type="hidden" name="t" value="social"><input type="hidden" name="c" value="url"><input type="text"class="form-control" name="da" value="<?php echo$url;?>" placeholder="Enter a URL..."></form><div class="input-group-btn"><form target="sp" action="core/purge.php"><input type="hidden" name="id" value="<?php echo$id;?>"><input type="hidden" name="t" value="choices"><button class="btn btn-default trash"><?php svg('trash');?></button></form></div></div></div>');
<?php               }else{?>
    window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'There was an issue adding the Social Networking Link'}}).show();
<?php               }
                }
            }else{?>
    window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'The URL entered is not valid'}}).show();
<?php       }
            break;
        case'add_subject':
            $sub=filter_input(INPUT_POST,'sub',FILTER_SANITIZE_STRING);
            $eml=filter_input(INPUT_POST,'eml',FILTER_SANITIZE_STRING);
            if($sub==''){?>
    window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'Data not Entirely Entered'}}).show();
<?php       }else{
                $sub=kses($sub,array());
                $eml=kses($eml,array());
                $q=$db->prepare("INSERT INTO choices (contentType,title,url) VALUES ('subject',:title,:url)");
                $q->execute(array(':title'=>$sub,':url'=>$eml));
                $id=$db->lastInsertId();
                $e=$db->errorInfo();
                if(is_null($e[2])){?>
    window.top.window.$('#subjects').append('<div id="l_<?php echo$id;?>" class="form-group"><label class="control-label col-xs-5 col-sm-3 col-lg-2">&nbsp;</label><div class="input-group col-xs-12 col-sm-9 col-lg-10"><div class="input-group-addon">Subject</div><form target="sp" method="post"><input type="hidden" name="id" value="<?php echo$id;?>"><input type="hidden" name="t" value="choices"><input type="hidden" name="c" value="title"><input type="text" class="form-control" name="da" value="<?php echo$sub;?>" placeholder="Enter a Subject..."></form><div class="input-group-addon">Email</div><form target="sp" method="post"><input type="hidden" name="id" value="<?php echo$id;?>"><input type="hidden" name="t" value="choices"><input type="hidden" name="c" value="url"><input type="text" class="form-control" name="da" value="<?php echo$eml;?>" placeholder="Enter an Email..."></form><div class="input-group-btn"><form target="sp" action="core/purge.php"><input type="hidden" name="id" value="<?php echo$id;?>"><input type="hidden" name="t" value="choices"><button class="btn btn-default trash"><?php svg('trash');?></button></form></div></div></div>');
<?php           }else{?>
    window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'There was an issue adding the Social Networking Link'}}).show();
<?php           }
            }
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
<?php       }else{?>
    window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'There was an issue Adding new Client'}}).show();
<?php       }
            break;
        case'add_comment':
            $rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
            $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                $q=$db->prepare("SELECT * FROM login WHERE email=:email");
                $q->execute(array(':email'=>$email));
                $c=$q->fetch(PDO::FETCH_ASSOC);
                if($c['id']!=0)$cid=$c['id'];else$cid=0;
                $name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
                $name=kses($name,array());
                $contentType=filter_input(INPUT_POST,'contentType',FILTER_SANITIZE_STRING);
                $da=filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING);
                $da=kses($da,array());
                $status='unapproved';
                $q=$db->prepare("INSERT INTO comments (contentType,rid,uid,cid,ip,name,email,notes,status,ti) VALUES (:contentType,:rid,:uid,:cid,:ip,:name,:email,:notes,:status,:ti)");
                $q->execute(array(':contentType'=>$contentType,':rid'=>$rid,':uid'=>$uid,':cid'=>$cid,':ip'=>$ip,':name'=>$name,':email'=>$email,':notes'=>$da,':status'=>$status,':ti'=>$ti));
                $id=$db->lastInsertId();
                $e=$db->errorInfo();
                if(is_null($e[2])){
                    if($c['avatar']!=''&&file_exists('..'.DS.'media'.DS.$c['avatar']))
                        $avatar='media'.DS.'avatar'.DS.$c['avatar'];
                    elseif($c['gravatar']!=''){
                        if(stristr($c['gravatar'],'@'))
                            $avatar='http://gravatar.com/avatar/'.md5($c['gravatar']);
                        elseif(stristr($c['gravatar'],'gravatar.com/avatar/'))
                            $avatar=$c['gravatar'];
                        else
                            $avatar='core'.DS.'images'.DS.'noavatar.jpg';
                    }else
                        $avatar='core'.DS.'images'.DS.'noavatar.jpg';
                    $html='<div id="l_'.$id.'" class="media bg-danger"><div class="media-object pull-left"><img class="commentavatar img-thumbnail" alt="User" src="'.$avatar.'"></div><div class="media-body"><h4 class="media-heading">Name</h4>'.$da.'</div><hr></div>';?>
    window.top.window.$('.notifications').notify({type:'success',icon:'',message:{text:'New comment Added, Awaiting Approval'}}).show();
    window.top.window.$('#comments').append('<?php echo$html;?>');
<?php           }else{?>
    window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'There was an issue adding your Comment'}}).show();
<?php           }
            }else{?>
    window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'The Email entered is not valid'}}).show();
<?php       }
            break;
        case'add_avatar':
            $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
            $tbl=filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING);
            $tbl=kses($tbl,array());
            $col=filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING);
            $col=kses($col,array());
            $exif='none';
            $fu=$_FILES['fu'];
            if(isset($_FILES['fu'])){
                $ft=$_FILES['fu']['type'];
                if($ft=="image/jpeg"||$ft=="image/pjpeg"||$ft=="image/png"||$ft=="image/gif"){
                    $tp="../media/".basename($_FILES['fu']['name']);
                    if(move_uploaded_file($_FILES['fu']['tmp_name'],$tp)){
                        if($ft=="image/jpeg"||$ft=="image/pjpeg")$fn=$col.'_'.$id.'.jpg';
                        if($ft=="image/png")$fn=$col.'_'.$id.'.png';
                        if($ft=="image/gif")$fn=$col.'_'.$id.'.gif';
                        $q=$db->prepare("UPDATE login SET avatar=:avatar WHERE id=:id");
                        $q->execute(array(':avatar'=>'avatar'.$fn,':id'=>$id));
                        $image=new Zebra_image();
                        $image->source_path=$tp;
                        $image->target_path='..'.DS.'media'.DS.'avatar'.DS.'avatar'.$fn;
                        $image->resize(150,150,ZEBRA_IMAGE_CROP_CENTER);
                        rename($tp,'..'.DS.'media'.DS.'avatar'.DS.'avatar'.$fn);?>
    window.top.window.$('#avatar').attr('src','media/avatar/avatar<?php echo$fn.'?'.time();?>');
    window.top.window.$('#menu_avatar').attr('src','media/avatar/avatar<?php echo$fn.'?'.time();?>');
<?php               }
                }
            }?>
    window.top.window.$('#block').css("display","none");
<?php       break;
        case'add_orderitem':
            $oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
            $iid=filter_input(INPUT_GET,'iid',FILTER_SANITIZE_NUMBER_INT);
            if($iid!=0){
                $q=$db->prepare("SELECT title,cost FROM content WHERE id=:id");
                $q->execute(array(':id'=>$iid));
                $r=$q->fetch(PDO::FETCH_ASSOC);
            }else
                $r=array('title'=>'','cost'=>0);
            $q=$db->prepare("INSERT INTO orderitems (oid,iid,title,quantity,cost,ti) VALUES (:oid,:iid,:title,'1',:cost,:ti)");
            $q->execute(array(':oid'=>$oid,':iid'=>$iid,':title'=>$r['title'],':cost'=>$r['cost'],':ti'=>$ti));
            $total=0;
            $html='';
            $q=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid ORDER BY ti ASC,title ASC");
            $q->execute(array(':oid'=>$oid));?>
    window.top.window.$('#updateorder').html('<?php while($oi=$q->fetch(PDO::FETCH_ASSOC)){$s=$db->prepare("SELECT * FROM content WHERE id=:id");$s->execute(array(':id'=>$oi['iid']));$i=$s->fetch(PDO::FETCH_ASSOC);echo'<tr><td class="text-left">'.$i['code'].'</td><td class="text-left"><form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="title"><input type="text" class="form-control" name="da" value="';if($i['title']!='')echo$i['title'];else echo$oi['title'];echo'"></form></td><td class="col-md-1 text-center">';if($oi['iid']!=0){echo'<form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="quantity"><input class="form-control text-center" name="da" value="'.$oi['quantity'].'"></form>';}echo'</td><td class="col-md-1 text-right">';if($oi['iid']!=0){echo'<form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="cost"><input class="form-control text-center" name="da" value="'.$oi['cost'].'"></form>';}echo'</td><td class="text-right">';if($oi['iid']!=0)echo $oi['cost']*$oi['quantity'];echo'</td><td class="text-right"><form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="quantity"><input type="hidden" name="da" value="0"><button class="btn btn-default trash">';svg('trash');echo'</button></form></td></tr>';$total=$total+($oi['cost']*$oi['quantity']);}echo'<tr><td colspan="3">&nbsp;</td><td class="text-right"><strong>Total</strong></td><td class="text-right"><strong>'.$total.'</strong></td><td></td></tr>';?>');
<?php   break;
    }
}?>
/*]]>*/</script>
