<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Add Various Data Items
 *
 * add_data.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Add Various Data Items
 * @package    core/add_data.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix Notifications.
 * @changes    v2.0.2 Fix Media Display, adding and removal.
 * @changes    v2.0.2 Fix Attributes.
 * @changes    v2.0.5 Fix Media Display in Pages and Content Tabs.
 */
$getcfg=true;
require'db.php';
echo'<script>';
include'zebra_image.php';
include'sanitise.php';
define('THEME','..'.DS.'layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
function svg($svg,$class=null,$size=null){
	echo'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
function svg2($svg,$class=null,$size=null){
	return'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
if($act!=''){
  $uid=isset($_SESSION['uid'])?(int)$_SESSION['uid']:0;
  $ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
  $error=0;
  $ti=time();
  switch($act){
		case'add_reward':
			$code=filter_input(INPUT_POST,'code',FILTER_SANITIZE_STRING);
			$title=filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
			$method=filter_input(INPUT_POST,'method',FILTER_SANITIZE_NUMBER_INT);
			$value=filter_input(INPUT_POST,'value',FILTER_SANITIZE_NUMBER_INT);
			$quantity=filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_NUMBER_INT);
			$tis=filter_input(INPUT_POST,'tis',FILTER_SANITIZE_STRING);
			$tie=filter_input(INPUT_POST,'tie',FILTER_SANITIZE_STRING);
			$tis=$tis!=''?strtotime($tis):0;
			$tie=$tie!=''?strtotime($tie):0;
			$q=$db->prepare("INSERT INTO `".$prefix."rewards` (code,title,method,value,quantity,tis,tie,ti) VALUES (:code,:title,:method,:value,:quantity,:tis,:tie,:ti)");
			$q->execute([
        ':code'=>$code,
        ':title'=>$title,
        ':method'=>$method,
        ':value'=>$value,
        ':quantity'=>$quantity,
        ':tis'=>$tis,
        ':tie'=>$tie,
        ':ti'=>$ti
      ]);
			$id=$db->lastInsertId();
			$e=$db->errorInfo();
			if(is_null($e[2])){?>
	window.top.window.$('#rewards').append('<?php
echo'<tr id="l_'.$id.'" role="row">'.
			'<td class="col-xs-1 small text-center" role="cell">'.$code.'</td>'.
			'<td class="col-xs-4 small text-center" role="cell">'.$title.'</td>'.
			'<td class="col-xs-1 small text-center" role="cell">'.($method==0?'% '.localize('Off'):'$ '.localize('Off')).'</td>'.
			'<td class="col-xs-1 small text-center" role="cell">'.$value.'</td>'.
			'<td class="col-xs-1 small text-center" role="cell">'.$quantity.'</td>'.
			'<td class="col-xs-2 small text-center" role="cell">'.($tis!=0?date($config['dateFormat'],$tis):'').'</td>'.
			'<td class="col-xs-2 small text-center" role="cell">'.($tie!=0?date($config['dateFormat'],$tie):'').'</td>'.
			'<td role="cell">'.
				'<form target="sp" action="core/purge.php" role="form">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="rewards">'.
					'<button class="btn btn-default btn-sm trash" data-tooltip="tooltip" title="'.localize('Delete').'" role="button" aria-label="'.localize('aria_delete').'">'.svg2('libre-gui-trash').'</button>'.
				'</form>'.
			'</td>'.
		'</tr>';?>
');
<?php	}else{?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_addreward');?>');
<?php }
			break;
    case'add_dashrss':
      $url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL);
      if(filter_var($url,FILTER_VALIDATE_URL)){
        $q=$db->prepare("INSERT INTO `".$prefix."choices` (uid,contentType,url,ti) VALUES (:uid,'dashrss',:url,'0')");
        $q->execute([
          ':uid'=>$uid,
          ':url'=>$url
        ]);
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){?>
  window.top.window.$('#rss').append('<?php
echo'<div id="l_'.$id.'" class="form-group">'.
			'<div class="input-group col-xs-12">'.
				'<div class="input-group-addon">'.localize('URL').'</div>'.
				'<form target="sp" method="post" action="core/update.php" role="form">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="url">'.
					'<input type="text"class="form-control" name="da" value="'.$url.'" placeholder="'.localize('Enter a ').' '.localize('URL').'..." role="textbox">'.
				'</form>'.
				'<div class="input-group-btn">'.
					'<form target="sp" action="core/purge.php" role="form">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-default trash" data-tooltip="tooltip" title="Delete" role="button" aria-label="'.localize('aria_delete').'">'.svg2('libre-gui-trash').'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_addrss');?>');
<?php   }
      }
      break;
    case'add_social':
      $user=filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT);
      $icon=filter_input(INPUT_POST,'icon',FILTER_SANITIZE_STRING);
      $url=filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL);
      if(filter_var($url,FILTER_VALIDATE_URL)){
        if($icon=='none'||$url==''){?>
  window.top.window.$.notify({type:'danger',icon:'',message:text:'<?php echo localize('alert_data_danger_addempty');?>'});
<?php   }else{
          $q=$db->prepare("INSERT INTO `".$prefix."choices` (uid,contentType,icon,url) VALUES (:uid,'social',:icon,:url)");
          $q->execute([
            ':uid'=>kses($user,array()),
            ':icon'=>$icon,
            ':url'=>kses($url,array())
          ]);
          $id=$db->lastInsertId();
          $e=$db->errorInfo();
          if(is_null($e[2])){?>
  window.top.window.$('#social').append(`<?php
echo'<div id="l_'.$id.'" class="form-group row">'.
			'<div class="input-group col-12">'.
				'<div class="input-group-text" data-tooltip="tooltip" title="'.ucfirst($icon).'"><span class="libre-social" aria-label="'.ucfirst($icon).'">'.svg2('libre-social-'.$icon).'</span></div>'.
				'<input type="text" class="form-control" value="'.$url.'" placeholder="'.localize('Enter a ').' '.localize('URL').'..." readonly role="textbox">'.
				'<div class="input-group-append">'.
					'<form target="sp" action="core/purge.php" role="form">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-secondary trash" data-tooltip="tooltip" title="'.localize('Delete').'" role="button" aria-label="'.localize('aria_delete').'">'.svg2('libre-gui-trash').'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>`);
<?php     }else{?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_addsocial');?>');
<?php     }
      	}
      }else{?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_badurl');?>');
<?php }
      break;
		case'add_option':
      $rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
      $ttl=filter_input(INPUT_POST,'ttl',FILTER_SANITIZE_STRING);
			$qty=filter_input(INPUT_POST,'qty',FILTER_SANITIZE_NUMBER_INT);
      if($ttl==''){?>
	window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_addempty');?>');
<?php }else{
        $q=$db->prepare("INSERT INTO `".$prefix."choices` (uid,rid,contentType,title,ti) VALUES (:uid,:rid,'option',:title,:ti)");
        $q->execute([
          ':uid'=>$uid,
          ':rid'=>$rid,
          ':title'=>kses($ttl,array()),
          ':ti'=>$qty
        ]);
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){?>
	window.top.window.$('#itemoptions').append('<?php
echo'<div id="l_'.$id.'" class="form-group">'.
			'<div class="input-group col-xs-12">'.
				'<span class="input-group-addon">'.localize('Option').'</span>'.
				'<form target="sp" method="post" role="form">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="title">'.
					'<input type="text" class="form-control" name="da" value="'.$ttl.'" placeholder="'.localize('Enter an ').' '.localize('Option').'..." role="textbox">'.
				'</form>'.
				'<span class="input-group-addon">'.localize('Quantity').'</span>'.
				'<form target="sp" method="post" role="form">'.
					'<input type="hidden" name="id" value="'.$id.'">'.
					'<input type="hidden" name="t" value="choices">'.
					'<input type="hidden" name="c" value="ti">'.
					'<input type="text" class="form-control" name="da" value="'.$qty.'" placeholder="'.localize('Quantity').'" role="textbox">'.
				'</form>'.
				'<div class="input-group-btn">'.
					'<form target="sp" action="core/purge.php" role="form">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-default trash" data-tooltip="tooltip" title="'.localize('Delete').'" role="button" aria-label="'.localize('aria_delete').'">'.svg2('libre-gui-trash').'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
	window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_error');?>');
<?php   }
      }
      break;
    case'add_subject':
      $sub=filter_input(INPUT_POST,'sub',FILTER_SANITIZE_STRING);
      $eml=filter_input(INPUT_POST,'eml',FILTER_SANITIZE_STRING);
      if($sub==''){?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_addempty');?>');
<?php }else{
        $q=$db->prepare("INSERT INTO `".$prefix."choices` (contentType,title,url) VALUES ('subject',:title,:url)");
        $q->execute([
          ':title'=>kses($sub,array()),
          ':url'=>kses($eml,array())
				]);
        $id=$db->lastInsertId();
        $e=$db->errorInfo();
        if(is_null($e[2])){?>
  window.top.window.$('#subjects').append('<?php
echo'<div id="l_'.$id.'" class="form-group row">'.
			'<div class="input-group">'.
				'<div class="input-group-text">'.localize('Subject').'</div>'.
				'<input id="sub'.$id.'" type="text" class="form-control" name="da" value="'.$sub.'">'.
				'<div class="input-group-text">'.localize('Email').'</div>'.
				'<input id="eml'.$id.'" type="text" class="form-control" name="da" value="'.$eml.'">'.
				'<div class="input-group-append">'.
					'<form target="sp" action="core/purge.php">'.
						'<input type="hidden" name="id" value="'.$id.'">'.
						'<input type="hidden" name="t" value="choices">'.
						'<button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete" aria-label="'.localize('aria_delete').'">'.svg2('libre-gui-trash').'</button>'.
					'</form>'.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_error');?>');
<?php   }
      }
      break;
    case'make_client':
      $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
      $q=$db->prepare("SELECT name,email,phone FROM `".$prefix."messages` WHERE id=:id");
      $q->execute([':id'=>$id]);
      $r=$q->fetch(PDO::FETCH_ASSOC);
      $q=$db->prepare("INSERT INTO `".$prefix."login` (name,email,phone,ti) VALUES (:name,:email,:phone,:ti)");
      $q->execute([
        ':name'=>$r['name'],
        ':email'=>$r['email'],
        ':phone'=>$r['phone'],
        ':ti'=>$ti
      ]);
      $e=$db->errorInfo();
      if(is_null($e[2])){?>
  window.top.window.toastr["success"]('<?php echo localize('alert_data_success_contacttoclient');?>');
<?php }else{?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_error');?>');
<?php }
      break;
    case'add_comment':
      $rid=filter_input(INPUT_POST,'rid',FILTER_SANITIZE_NUMBER_INT);
      $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
      if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE email=:email");
        $q->execute([':email'=>$email]);
        $c=$q->fetch(PDO::FETCH_ASSOC);
        $cid=$c['id']!=0?$c['id']:0;
        $name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
        $contentType=filter_input(INPUT_POST,'contentType',FILTER_SANITIZE_STRING);
        $da=filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING);
        $status='approved';
        $q=$db->prepare("INSERT INTO `".$prefix."comments` (contentType,rid,uid,cid,ip,name,email,notes,status,ti) VALUES (:contentType,:rid,:uid,:cid,:ip,:name,:email,:notes,:status,:ti)");
        $q->execute([
          ':contentType'=>$contentType,
          ':rid'=>$rid,
          ':uid'=>$uid,
          ':cid'=>$cid,
          ':ip'=>$ip,
          ':name'=>$name,
          ':email'=>$email,
          ':notes'=>$da,
          ':status'=>$status,
          ':ti'=>$ti
        ]);
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
						'<button class="btn btn-default btn-sm trash" onclick="purge(`'.$id.'`,`comments`);" data-tooltip="tooltip" title="Delete" role="button" aria-label="'.localize('aria_delete').'">'.svg2('libre-gui-trash').'</button>'.
					'</div>'.
					'<h6 class="media-heading">'.$name.'</h6>'.
					'<time><small>'.date($config['dateFormat'],$ti).'</small></time><br>'.
					$da.
				'</div>'.
			'</div>'.
		'</div>';?>
');
<?php   }else{?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_error');?>');
<?php   }
      }else{?>
  window.top.window.toastr["danger"]('<?php echo localize('alert_data_danger_bademail');?>');
<?php }
      break;
    case'add_avatar':
		case'add_tstavatar':
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
          $tp='..'.DS.'media'.DS.basename($_FILES['fu']['name']);
          if(move_uploaded_file($_FILES['fu']['tmp_name'],$tp)){
            if($ft=="image/jpeg"||$ft=="image/pjpeg")
							$fn=$col.'_'.$id.'.jpg';
            if($ft=="image/png")
							$fn=$col.'_'.$id.'.png';
            if($ft=="image/gif")
							$fn=$col.'_'.$id.'.gif';
						if($act=='add_tstavatar'){
							$fn='tst'.$fn;
							$q=$db->prepare("UPDATE `".$prefix."content` SET file=:avatar WHERE id=:id");
						}else
							$q=$db->prepare("UPDATE `".$prefix."login` SET avatar=:avatar WHERE id=:id");
						$q->execute([
							':avatar'=>'avatar'.$fn,
							':id'=>$id
						]);
            $image=new Zebra_image();
            $image->source_path=$tp;
            $image->target_path='..'.DS.'media'.DS.'avatar'.DS.'avatar'.$fn;
            $image->resize(150,150,ZEBRA_IMAGE_CROP_CENTER);
            rename($tp,'..'.DS.'media'.DS.'avatar'.DS.'avatar'.$fn);
						if($act=='add_tstavatar'){?>
	window.top.window.$('#tstavatar').attr('src','media/avatar/avatar<?php echo$fn.'?'.time();?>');
	window.top.window.Pace.stop();
<?php 			}else{?>
  window.top.window.$('.img-avatar').attr('src','media/avatar/avatar<?php echo$fn.'?'.time();?>');
	window.top.window.Pace.stop();
<?php 			}
					}
        }
      }?>
  window.top.window.Pace.stop();
<?php break;
    case'add_media':
      $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
      $t=filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING);
      $fu=filter_input(INPUT_POST,'fu',FILTER_SANITIZE_STRING);
      if($fu!=''){
        if($t=='pages'||$t=='content'){
          $q=$db->prepare("INSERT INTO `".$prefix."media` (rid,pid,file,ti) VALUES (0,:pid,:file,:ti)");
          $q->execute([
            ':pid'=>$id,
            ':file'=>$fu,
            ':ti'=>time()
          ]);
          $iid=$db->lastInsertId();
          $q=$db->prepare("UPDATE `".$prefix."media` SET ord=:ord WHERE id=:id");
          $q->execute([
            ':id'=>$iid,
            ':ord'=>$iid+1
          ]);?>
  window.top.window.$('#mi').append('<?php
echo'<div id="mi_'.$iid.'" class="media-gallery d-inline-block col-6 col-sm-2 position-relative p-0 m-1 mt-0 animated zoomIn">'.
			'<a class="card bg-dark m-0" href="'.$fu.'" data-lightbox="media">'.
				'<img class="card-img" src="'.$fu.'" alt="Media '.$iid.'">'.
			'</a>'.
			'<div class="btn-group float-right">'.
				'<div class="handle btn btn-secondary btn-sm" data-tooltip="tooltip" title="'.localize('Drag to ReOrder this item').'" aria-label="'.localize('aria_drag').'">'.svg2('libre-gui-drag').'</div>'.
				'<button class="btn btn-secondary trash btn-sm" onclick="purge(`'.$iid.'`,`media`)" data-tooltip="tooltip" title="'.localize('Delete').'" aria-label="'.localize('aria_drag').'">'.svg2('libre-gui-trash').'</button>'.
			'</div>'.
		'</div>';?>
');
	window.top.window.$('[data-lightbox="media"]').simpleLightbox();
  window.top.window.Pace.stop();
<?php   }
      }
      break;
    case'add_orderitem':
      $oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
      $iid=filter_input(INPUT_GET,'iid',FILTER_SANITIZE_NUMBER_INT);
      if($iid!=0){
        $q=$db->prepare("SELECT title,cost FROM `".$prefix."content` WHERE id=:id");
        $q->execute([':id'=>$iid]);
        $r=$q->fetch(PDO::FETCH_ASSOC);
				if($r['cost']==''||!is_numeric($r['cost']))$r['cost']=0;
      }else{
        $r=[
          'title'=>'',
          'cost'=>0
        ];
      }
      $q=$db->prepare("INSERT INTO `".$prefix."orderitems` (oid,iid,title,quantity,cost,ti) VALUES (:oid,:iid,:title,'1',:cost,:ti)");
      $q->execute([
        ':oid'=>$oid,
        ':iid'=>$iid,
        ':title'=>$r['title'],
        ':cost'=>$r['cost'],
        ':ti'=>time()
      ]);
      $total=0;
      $html='';
      $q=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid ORDER BY ti ASC,title ASC");
      $q->execute([':oid'=>$oid]);?>
  window.top.window.$('#updateorder').html('<?php
      while($oi=$q->fetch(PDO::FETCH_ASSOC)){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
        $s->execute([':id'=>$oi['iid']]);
        $i=$s->fetch(PDO::FETCH_ASSOC);
        echo'<tr role="cell">'.
							'<td class="text-left" role="cell">'.$i['code'].'<div class="visible-xs">'.$i['title'].'</div></td>'.
							'<td class="text-left hidden-xs" role="cell">'.$i['title'].'</td>'.
							'<td class="col-md-1 text-center" role="cell">'.($oi['iid']!=0?'<form target="sp" action="core/update.php" role="form"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="quantity"><input class="form-control text-center" name="da" value="'.$oi['quantity'].'" role="textbox"></form>':'').'</td>'.
							'<td class="col-md-1 text-right" role="cell">'.($oi['iid']!=0?'<form target="sp" action="core/update.php" role="form"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="cost"><input class="form-control text-center" name="da" value="'.$oi['cost'].'" role="textbox"></form>':'').'</td>'.
							'<td class="text-right" role="cell">'.($oi['iid']!=0?$oi['cost']*$oi['quantity']:'').'</td>'.
							'<td class="text-right" role="cell">'.
								'<form target="sp" action="core/update.php" role="form">'.
									'<input type="hidden" name="id" value="'.$oi['id'].'">'.
									'<input type="hidden" name="t" value="orderitems">'.
									'<input type="hidden" name="c" value="quantity">'.
									'<input type="hidden" name="da" value="0">'.
									'<button class="btn btn-default trash" data-tooltip="tooltip" title="'.localize('Delete').'" role="button" aria-label="'.localize('aria_delete').'">'.svg2('libre-gui-trash').'</button>'.
								'</form>'.
							'</td>'.
						'</tr>';
        $total=$total+($oi['cost']*$oi['quantity']);
      }
      echo'<tr><td colspan="3" role="cell">&nbsp;</td><td class="text-right" role="cell"><strong>'.localize('Total').'</strong></td><td class="text-right" role="cell"><strong>'.$total.'</strong></td><td role="cell">&nbsp;</td></tr>';
  ?>');
<?php break;
  }
}
echo'</script>';
