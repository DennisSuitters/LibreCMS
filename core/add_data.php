<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$getcfg=true;
require'db.php';
echo'<script>/*<![CDATA[*/';
require'zebra_image.php';
require'sanitise.php';
define('THEME','..'.DS.'layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
function svg($svg,$color=null,$class=null,$size=null){
	echo'<i class="libre';
	if($size!=null)echo' libre-'.$size;
	if($color==true)$svg='col'.DS.$svg;
	elseif($color!= null)echo' libre-'.$color;
  if($class!=null)echo' '.$class;
	echo'">';
	include'svg'.DS.$svg.'.svg';
	echo'</i>';
}
function svg2 ($svg, $color = null, $class = null,$size=null){
	$svgout='<i class="libre';
	if($size!=null)$svgout.=' libre-'.$size;
	if($color==true)$svg='col'.DS.$svg;
	elseif($color!=null)$svgout.=' libre-'.$color;
  if($class!=null)$svgout.=' ' .$class;
	$svgout.='">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
	return$svgout;
}
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
if($act!=''){
  $uid=isset($_SESSION['uid'])?(int)$_SESSION['uid']:0;
  $ip=$_SERVER['REMOTE_ADDR'];
  $error=0;
  $ti=time();
  switch($act){
		case'add_reward':
			$code=    filter_input(INPUT_POST,'code',    FILTER_SANITIZE_STRING);
			$title=   filter_input(INPUT_POST,'title',   FILTER_SANITIZE_STRING);
			$method=  filter_input(INPUT_POST,'method',  FILTER_SANITIZE_NUMBER_INT);
			$value=   filter_input(INPUT_POST,'value',   FILTER_SANITIZE_NUMBER_INT);
			$quantity=filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_NUMBER_INT);
			$tis=     filter_input(INPUT_POST,'tis',     FILTER_SANITIZE_STRING);
			$tie=     filter_input(INPUT_POST,'tie',     FILTER_SANITIZE_STRING);
			$tis=($tis!=''?strtotime($tis):0);
			$tie=($tie!=''?strtotime($tie):0);
			$q=$db->prepare("INSERT INTO rewards (code,title,method,value,quantity,tis,tie,ti) VALUES (:code,:title,:method,:value,:quantity,:tis,:tie,:ti)");
			$q->execute(
        array(
          ':code'    =>$code,
          ':title'   =>$title,
          ':method'  =>$method,
          ':value'   =>$value,
          ':quantity'=>$quantity,
          ':tis'     =>$tis,
          ':tie'     =>$tie,
          ':ti'      =>$ti
        )
      );
			$id=$db->lastInsertId();
			$e=$db->errorInfo();
			if(is_null($e[2])){?>
	window.top.window.$('#rewards').append('<?php
echo'<tr id="l_'.$id.'">'.
			'<td class="col-xs-1 text-center"><small>'.$code.'</small></td>'.
			'<td class="col-xs-4 text-center"><small>'.$title.'</small></td>'.
			'<td class="col-xs-1 text-center"><small>'.($method==0?'% Off':'$ Off').'</small></td>'.
			'<td class="col-xs-1 text-center"><small>'.$value.'</small></td>'.
			'<td class="col-xs-1 text-center"><small>'.$quantity.'</small></td>'.
			'<td class="col-xs-2 text-center"><small>'.($tis!=0?date($config['dateFormat'],$tis):'').'</small></td>'.
			'<td class="col-xs-2 text-center"><small>'.($tie!=0?date($config['dateFormat'],$tie):'').'</small></td>'.
			'<td>'.
				'<form target="sp" action="core/purge.php">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="rewards">'.
					'<button class="btn btn-default btn-sm trash">'.svg2('libre-gui-trash',($config['iconsColor']==1?true:null)).'</button>'.
				'</form>'.
			'</td>'.
		'</tr>';?>
');
<?php	}else{?>
  window.top.window.$.notify({type:'danger',icon:'',message:'There was an issue adding the Reward'});
<?php }
			break;
    case'add_dashrss':
      $url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL);
      if(filter_var($url,FILTER_VALIDATE_URL)){
        $q=$db->prepare("INSERT INTO choices (uid,contentType,url,ti) VALUES (:uid,'dashrss',:url,'0')");
        $q->execute(
          array(
            ':uid'=>$uid,
            ':url'=>$url
          )
        );
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){?>
  window.top.window.$('#rss').append('<?php
echo'<div id="l_'.$id.'" class="form-group">'.
			'<div class="input-group col-xs-12">'.
				'<div class="input-group-addon">URL</div>'.
				'<form target="sp" method="post" action="core/update.php">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="url">'.
					'<input type="text"class="form-control" name="da" value="'.$url.'" placeholder="Enter a URL...">'.
				'</form>'.
				'<div class="input-group-btn">'.
					'<form target="sp" action="core/purge.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-default trash">'.svg2('libre-gui-trash',($config['iconsColor']==1?true:null)).'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
  window.top.window.$.notify({type:'danger',icon:'',message:'There was an issue adding the RSS URL'});
<?php   }
      }
      break;
    case'add_social':
      $user=filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT);
      $icon=filter_input(INPUT_POST,'icon',FILTER_SANITIZE_STRING);
      $url =filter_input(INPUT_POST,'url', FILTER_SANITIZE_URL);
      if(filter_var($url,FILTER_VALIDATE_URL)){
        if($icon=='none'||$url==''){?>
  window.top.window.$.notify({type:'danger',icon:'',message:{text:'Data not Entirely Entered'}}).show();
<?php   }else{
          $q=$db->prepare("INSERT INTO choices (uid,contentType,icon,url) VALUES (:uid,'social',:icon,:url)");
          $q->execute(
            array(
              ':uid' =>kses($user,array()),
              ':icon'=>$icon,
              ':url' =>kses($url,array())
            )
          );
          $id=$db->lastInsertId();
          $e=$db->errorInfo();
          if(is_null($e[2])){?>
  window.top.window.$('#social').append('<?php
echo'<div id="l_'.$id.'" class="form-group">'.
			'<div class="input-group col-xs-12">'.
				'<div class="input-group-addon">'.
					'<span class="libre-social">'.svg2('libre-social-'.$icon,($config['iconsColor']==1?true:null)).'</span>'.
				'</div>'.
				'<form target="sp" method="post" action="core/update.php">'.
					'<input type="hidden" name="t" value="social">'.
					'<input type="hidden" name="c" value="url">'.
					'<input type="text"class="form-control" name="da" value="'.$url.'" placeholder="Enter a URL...">'.
				'</form>'.
				'<div class="input-group-btn">'.
					'<form target="sp" action="core/purge.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-default trash">'.svg2('libre-gui-trash',($config['iconsColor']==1?true:null)).'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php     }else{?>
  window.top.window.$.notify({type:'danger',icon:'',message:'There was an issue adding the Social Networking Link'});
<?php     }
      	}
      }else{?>
  window.top.window.$.notify({type:'danger',icon:'',message:'The URL entered is not valid'});
<?php }
      break;
		case'add_option':
      $rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
      $ttl=filter_input(INPUT_POST,'ttl',FILTER_SANITIZE_STRING);
			$qty=filter_input(INPUT_POST,'qty',FILTER_SANITIZE_NUMBER_INT);
      if($ttl==''){?>
	window.top.window.$.notify({type:'danger',icon:'',message:'Data not Entirely Entered'});
<?php }else{
        $q=$db->prepare("INSERT INTO choices (uid,rid,contentType,title,ti) VALUES (:uid,:rid,'option',:title,:ti)");
        $q->execute(
          array(
            ':uid'  =>$uid,
            ':rid'  =>$rid,
            ':title'=>kses($ttl,array()),
            ':ti'   =>$qty
          )
        );
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){?>
	window.top.window.$('#itemoptions').append('<?php
echo'<div id="l_'.$id.'" class="form-group">'.
			'<div class="input-group col-xs-12">'.
				'<span class="input-group-addon">Option</span>'.
				'<form target="sp" method="post">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="title">'.
					'<input type="text" class="form-control" name="da" value="'.$ttl.'" placeholder="Enter an Option Title...">'.
				'</form>'.
				'<span class="input-group-addon">Quantity</span>'.
				'<form target="sp" method="post">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="ti">'.
					'<input type="text" class="form-control" name="da" value="'.$qty.'" placeholder="Quantity">'.
				'</form>'.
				'<div class="input-group-btn">'.
					'<form target="sp" action="core/purge.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-default trash">'.svg2('libre-gui-trash',($config['iconsColor']==1?true:null)).'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
	window.top.window.$.notify({type:'danger',icon:'',message:'There was an issue adding the Social Networking Link'});
<?php   }
      }
      break;
    case'add_subject':
      $sub=filter_input(INPUT_POST,'sub',FILTER_SANITIZE_STRING);
      $eml=filter_input(INPUT_POST,'eml',FILTER_SANITIZE_STRING);
      if($sub==''){?>
  window.top.window.$.notify({type:'danger',icon:'',message:'Data not Entirely Entered'});
<?php }else{
        $q=$db->prepare("INSERT INTO choices (contentType,title,url) VALUES ('subject',:title,:url)");
        $q->execute(
          array(
            ':title'=>kses($sub,array()),
            ':url'  =>kses($eml,array())
          )
        );
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){?>
  window.top.window.$('#subjects').append('<?php
echo'<div id="l_'.$id.'" class="form-group">'.
			'<div class="input-group col-xs-12">'.
				'<div class="input-group-addon">Subject</div>'.
				'<form target="sp" method="post">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="title">'.
					'<input type="text" class="form-control" name="da" value="'.$sub.'" placeholder="Enter a Subject...">'.
				'</form>'.
				'<div class="input-group-addon">Email</div>'.
				'<form target="sp" method="post">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="url">'.
					'<input type="text" class="form-control" name="da" value="'.$eml.'" placeholder="Enter an Email...">'.
				'</form>'.
				'<div class="input-group-btn">'.
					'<form target="sp" action="core/purge.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-default trash">'.svg2('libre-gui-trash',($config['iconsColor']==1?true:null)).'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
  window.top.window.$.notify({type:'danger',icon:'',message:'There was an issue adding the Social Networking Link'});
<?php   }
      }
      break;
    case'make_client':
      $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
      $q=$db->prepare("SELECT name,email,phone FROM messages WHERE id=:id");
      $q->execute(array(':id'=>$id));
      $r=$q->fetch(PDO::FETCH_ASSOC);
      $q=$db->prepare("INSERT INTO login (name,email,phone,ti) VALUES (:name,:email,:phone,:ti)");
      $q->execute(
        array(
          ':name' =>$r['name'],
          ':email'=>$r['email'],
          ':phone'=>$r['phone'],
          ':ti'   =>$ti
        )
      );
      $e=$db->errorInfo();
      if(is_null($e[2])){?>
  window.top.window.$.notify({type:'success',icon:'',message:'Contact added as Client'});
<?php }else{?>
  window.top.window.$.notify({type:'danger',icon:'',message:'There was an issue Adding new Client'});
<?php }
      break;
    case'add_comment':
      $rid  =filter_input(INPUT_POST,'rid',  FILTER_SANITIZE_NUMBER_INT);
      $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
      if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $q=$db->prepare("SELECT * FROM login WHERE email=:email");
        $q->execute(array(':email'=>$email));
        $c=$q->fetch(PDO::FETCH_ASSOC);
        $cid=($c['id']!=0?$c['id']:0);
        $name       =filter_input(INPUT_POST,'name',       FILTER_SANITIZE_STRING);
        $contentType=filter_input(INPUT_POST,'contentType',FILTER_SANITIZE_STRING);
        $da         =filter_input(INPUT_POST,'da',         FILTER_SANITIZE_STRING);
        $status     ='approved';
        $q=$db->prepare("INSERT INTO comments (contentType,rid,uid,cid,ip,name,email,notes,status,ti) VALUES (:contentType,:rid,:uid,:cid,:ip,:name,:email,:notes,:status,:ti)");
        $q->execute(
          array(
            ':contentType'=>$contentType,
            ':rid'        =>$rid,
            ':uid'        =>$uid,
            ':cid'        =>$cid,
            ':ip'         =>$ip,
            ':name'       =>$name,
            ':email'      =>$email,
            ':notes'      =>$da,
            ':status'     =>$status,
            ':ti'         =>$ti
          )
        );
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){
					$avatar='core'.DS.'images'.DS.'noavatar.jpg';
          if($c['avatar']!=''&&file_exists('..'.DS.'media'.DS.$c['avatar']))
            $avatar='media'.DS.'avatar'.DS.$c['avatar'];
          elseif($c['gravatar']!=''){
            if(stristr($c['gravatar'],'@'))
							$avatar='http://gravatar.com/avatar/'.md5($c['gravatar']);
            elseif(stristr($c['gravatar'],'gravatar.com/avatar/'))
							$avatar=$c['gravatar'];
					}?>
	  window.top.window.$('#comments').append('<?php
echo'<div id="l_'.$id.'" class="media animated zoomIn">'.
			'<div class="media-left img-rounded col-xs-1" style="margin:10px 15px;">'.
				'<img class="media-object img-responsive" alt="User" src="'.$avatar.'">'.
			'</div>'.
			'<div class="media-body">'.
				'<div class="well">'.
					'<div id="controls-'.$id.'" class="btn-group btn-comments">'.
						'<button class="btn btn-default btn-sm trash" onclick="purge(`'.$id.'`,`comments`);">'.svg2('libre-gui-trash',($config['iconsColor']==1?true:null)).'</button>'.
					'</div>'.
					'<h6 class="media-heading">'.$name.'</h6>'.
					'<time><small class="text-muted">'.date($config['dateFormat'],$ti).'</small></time><br>'.
					$da.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
  window.top.window.$.notify({type:'danger',icon:'',message:'There was an issue adding your Comment'});
<?php   }
      }else{?>
  window.top.window.$.notify({type:'danger',icon:'',message:'The Email entered is not valid'});
<?php }
      break;
    case'add_avatar':
		case'add_tstavatar':
      $id =filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
      $tbl=filter_input(INPUT_POST,'t', FILTER_SANITIZE_STRING);
      $tbl=kses($tbl,array());
      $col=filter_input(INPUT_POST,'c', FILTER_SANITIZE_STRING);
      $col=kses($col,array());
      $exif='none';
      $fu=$_FILES['fu'];
      if(isset($_FILES['fu'])){
        $ft=$_FILES['fu']['type'];
        if($ft=="image/jpeg"||$ft=="image/pjpeg"||$ft=="image/png"||$ft=="image/gif"){
          $tp='..'.DS.'media'.DS.basename($_FILES['fu']['name']);
          if(move_uploaded_file($_FILES['fu']['tmp_name'],$tp)){
            if($ft=="image/jpeg"||$ft=="image/pjpeg")$fn=$col.'_'.$id.'.jpg';
            if($ft=="image/png")$fn=$col.'_'.$id.'.png';
            if($ft=="image/gif")$fn=$col.'_'.$id.'.gif';
						if($act=='add_tstavatar'){
							$fn='tst'.$fn;
							$q=$db->prepare("UPDATE content SET file=:avatar WHERE id=:id");
						}else$q=$db->prepare("UPDATE login SET avatar=:avatar WHERE id=:id");
						$q->execute(
							array(
								':avatar'=>'avatar'.$fn,
								':id'    =>$id
							)
						);
            $image=new Zebra_image();
            $image->source_path=$tp;
            $image->target_path='..'.DS.'media'.DS.'avatar'.DS.'avatar'.$fn;
            $image->resize(150,150,ZEBRA_IMAGE_CROP_CENTER);
            rename($tp,'..'.DS.'media'.DS.'avatar'.DS.'avatar'.$fn);
						if($act=='add_tstavatar'){?>
	window.top.window.$('#tstavatar').attr('src','media/avatar/avatar<?php echo$fn.'?'.time();?>');
	window.top.window.Pace.stop();
<?php 			}else{?>
  window.top.window.$('#avatar').attr('src','media/avatar/avatar<?php echo$fn.'?'.time();?>');
  window.top.window.$('#menu_avatar').attr('src','media/avatar/avatar<?php echo $fn.'?'.time();?>');
	window.top.window.Pace.stop();
<?php 			}
					}
        }
      }?>
  window.top.window.Pace.stop();
<?php break;
    case'add_media':
      $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
      $t =filter_input(INPUT_POST,'t', FILTER_SANITIZE_STRING);
      $fu=filter_input(INPUT_POST,'fu',FILTER_SANITIZE_STRING);
      if($fu!=''){
        if($t=='pages'||$t=='content'){
          $q=$db->prepare("INSERT INTO media (rid,pid,file,ti) VALUES (0,:pid,:file,:ti)");
          $q->execute(
            array(
              ':pid' =>$id,
              ':file'=>$fu,
              ':ti'  =>time()
            )
          );
          $iid=$db->lastInsertId();
          $q=$db->prepare("UPDATE media SET ord=:ord WHERE id=:id");
          $q->execute(
            array(
              ':id' =>$iid,
              ':ord'=>$iid+1
            )
          );?>
  window.top.window.$('#media_items').append('<?php
echo'<li id="media_items_'.$iid.'" class="col-xs-6 col-sm-3 animated zoomIn">'.
			'<div class="panel panel-default media">'.
				'<div class="controls btn-group">'.
					'<span class="handle btn btn-default btn-xs">'.svg2('libre-gui-drag',($config['iconsColor']==1?true:null)).'</span>'.
					'<button class="btn btn-default btn-xs media-edit" data-dbid="'.$iid.'">'.svg2('libre-gui-edit',($config['iconsColor']==1?true:null)).'</button>'.
					'<button class="btn btn-default trash btn-xs" onclick="purge(`'.$iid.'`,`media`)">'.svg2('libre-gui-trash',($config['iconsColor']==1?true:null)).'</button>'.
				'</div>'.
				'<div class="panel-body">'.
					'<img src="'.$fu.'">'.
					'<div id="media-title'.$iid.'" class="panel-footer"></div>'.
				'</div>'.
			'</div>'.
		'</li>';?>
');
  setTimeout(function(){window.top.window.$('#media_items_<?php echo $iid;?>').removeClass('animated zoomIn');},800);
  window.top.window.Pace.stop();
<?php   }
      }
      break;
    case'add_orderitem':
      $oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
      $iid=filter_input(INPUT_GET,'iid',FILTER_SANITIZE_NUMBER_INT);
      if($iid!=0){
        $q=$db->prepare("SELECT title,cost FROM content WHERE id=:id");
        $q->execute(array(':id'=>$iid));
        $r=$q->fetch(PDO::FETCH_ASSOC);
				if($r['cost']==''||!is_numeric($r['cost']))$r['cost']=0;
      }else{
        $r=array(
          'title'=>'',
          'cost' =>0
        );
      }
      $q=$db->prepare("INSERT INTO orderitems (oid,iid,title,quantity,cost,ti) VALUES (:oid,:iid,:title,'1',:cost,:ti)");
      $q->execute(
        array(
          ':oid'  =>$oid,
          ':iid'  =>$iid,
          ':title'=>$r['title'],
          ':cost' =>$r['cost'],
          ':ti'   =>time()
        )
      );
      $total=0;
      $html='';
      $q=$db->prepare("SELECT * FROM orderitems WHERE oid=:oid ORDER BY ti ASC,title ASC");
      $q->execute(array(':oid'=>$oid));?>
  window.top.window.$('#updateorder').html('<?php
      while($oi=$q->fetch(PDO::FETCH_ASSOC)){
        $s=$db->prepare("SELECT * FROM content WHERE id=:id");
        $s->execute(array(':id'=>$oi['iid']));
        $i=$s->fetch(PDO::FETCH_ASSOC);
        echo'<tr>'.
							'<td class="text-left">'.$i['code'].'<div class="visible-xs">'.$i['title'].'</div></td>'.
							'<td class="text-left hidden-xs">'.$i['title'].'</td>'.
							'<td class="col-md-1 text-center">'.($oi['iid']!=0?'<form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="quantity"><input class="form-control text-center" name="da" value="'.$oi['quantity'].'"></form>':'').'</td>'.
							'<td class="col-md-1 text-right">'.($oi['iid']!=0?'<form target="sp" action="core/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="cost"><input class="form-control text-center" name="da" value="'.$oi['cost'].'"></form>':'').'</td>'.
							'<td class="text-right">'.($oi['iid']!=0?$oi['cost']*$oi['quantity']:'').'</td>'.
							'<td class="text-right">'.
								'<form target="sp" action="core/update.php">'.
									'<input type="hidden" name="id" value="'.$oi['id'].'">'.
									'<input type="hidden" name="t" value="orderitems">'.
									'<input type="hidden" name="c" value="quantity">'.
									'<input type="hidden" name="da" value="0">'.
									'<button class="btn btn-default trash">'.svg2('libre-gui-trash',($config['iconsColor']==1?true:null)).'</button>'.
								'</form>'.
							'</td>'.
						'</tr>';
        $total=$total+($oi['cost']*$oi['quantity']);
      }
      echo'<tr><td colspan="3">&nbsp;</td><td class="text-right"><strong>Total</strong></td><td class="text-right"><strong>'.$total.'</strong></td><td></td></tr>';
  ?>');
<?php break;
  }
}
echo '/*]]>*/</script>';
