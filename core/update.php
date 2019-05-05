<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Update
 *
 * update.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Update
 * @package    core/update.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Add Slugification
 * @changes    v2.0.2 Add i18n.
 */
echo'<script>';
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
include'sanitise.php';
function svg($svg,$class=null,$size=null){
	echo'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
function svg2($svg,$class=null,$size=null){
	return'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
function localize($t){
  static $tr=NULL;
  global $config;
  if(is_null($tr)){
    if(file_exists('i18n'.DS.$config['language'].'.txt'))
      $lf='core'.DS.'i18n'.DS.$config['language'].'.txt';
    else
      $lf='core'.DS.'i18n'.DS.'en-AU.txt';
    $lfc=file_get_contents($lf);
    $tr=json_decode($lfc,true);
  }
  if(is_array($tr)){
    if(!array_key_exists($t,$tr))
      echo'Error: No "'.$t,'" Key in '.$config['language'];
    else
      return$tr[$t];
  }else
    echo'Error: '.$config['language'].' is malformed';
}
function sluggify($url){
	$url=strtolower($url);
	$url=strip_tags($url);
	$url=stripslashes($url);
	$url=html_entity_decode($url);
	$url=str_replace('\'','',$url);
	$match='/[^a-z0-9]+/';
	$replace='-';
	$url=preg_replace($match,$replace,$url);
	$url=trim($url,'-');
	return$url;
}
$e='';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$col=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
if($tbl=='content'||$tbl=='menu'||$tbl=='config'||$tbl=='login'&&$col=='notes'||$col=='PasswordResetLayout'||$col=='orderEmailLayout'||$col=='orderEmailNotes'||$col=='passwordResetLayout'||$col=='accountActivationLayout'||$col=='bookingEmailLayout'||$col=='bookingAutoReplyLayout'||$col=='contactAutoReplyLayout'||$col=='dateFormat'||$col=='newslettersOptOutLayout'||$col=='php_quicklink'){
  $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_UNSAFE_RAW):filter_input(INPUT_GET,'da',FILTER_UNSAFE_RAW);
}else{
  $da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'da',FILTER_SANITIZE_STRING);
  $da=kses($da,array());
}
if(strlen($da)<12&&$da=='<p><br></p>')$da=str_replace('<p><br></p>','',$da);
if(strlen($da)<24&&$da=='%3Cp%3E%3Cbr%3E%3C/p%3E')$da=str_replace('%3Cp%3E%3Cbr%3E%3C/p%3E','',$da);
$si=session_id();
$ti=time();
$s=$db->prepare("SELECT * FROM `".$prefix.$tbl."` WHERE id=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$oldda=$r[$col];
if($tbl=='content'&&$col=='status'&&$da=='published'){
  $q=$db->prepare("UPDATE `".$prefix."content` SET pti=:pti WHERE id=:id");
  $q->execute([
    ':pti'=>$ti,
    ':id' =>$id
  ]);
}
if($tbl=='content'&&$col=='title'){
	$slug=sluggify($da);
	$ss=$db->prepare("UPDATE `".$prefix.$tbl."` SET urlSlug=:slug WHERE id=:id");
	$ss->execute([':id'=>$id,':slug'=>$slug]);
}
if($tbl=='config'||$tbl=='login'||$tbl=='orders'||$tbl=='orderitems'||$tbl=='messages')$r['contentType']='';
$log=[
  'uid'=>0,
  'rid'=>$id,
  'username'=>'',
  'name'=>'',
  'view'=>$r['contentType'],
  'contentType'=>$r['contentType'],
  'refTable'=>$tbl,
  'refColumn'=>$col,
  'oldda'=>$oldda,
  'newda'=>$da,
  'action'=>'update',
  'ti'=>$ti
];
if($r['contentType']=='booking')$log['view']=$r['contentType'].'s';
if(isset($_SESSION['uid'])){
  $uid=(int)$_SESSION['uid'];
  $q=$db->prepare("SELECT rank,username,name FROM `".$prefix."login` WHERE id=:id");
  $q->execute([':id'=>$uid]);
  $u=$q->fetch(PDO::FETCH_ASSOC);
  $login_user=$u['name']!=''?$u['name']:$u['username'];
  $log['uid']=$uid;
	$log['username']=$u['username'];
	$log['name']=$u['name'];
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
  $q=$db->prepare("UPDATE `".$prefix.$tbl."` SET eti=:ti,login_user=:login_user,uid=:uid WHERE id=:id");
  $q->execute([
    'ti'=>$ti,
    ':uid'=>$uid,
    ':login_user'=>$login_user,
    ':id'=>$id
  ]);
}
if($tbl=='login'&&$col=='username'){
  $uc1=$db->prepare("SELECT username FROM `".$prefix."login` WHERE username=:da");
  $uc1->execute([':da'=>$da]);
  if($uc1->rowCount()<1){
    $q=$db->prepare("UPDATE `".$prefix."login` SET username=:da WHERE id=:id");
    $q->execute([
      ':da'=>$da,
      ':id'=>$id
    ]);?>
	window.top.window.$('#uerror').addClass('hidden');
<?php }else{
    $uc2=$db->prepare("SELECT username FROM `".$prefix."login` WHERE id=:id");
    $uc2->execute([':id'=>$id]);
    $uc=$uc2->fetch(PDO::FETCH_ASSOC);?>
	window.top.window.$('#uerror').removeClass('hidden');
<?php }
}else{
  $q=$db->prepare("UPDATE `".$prefix.$tbl."` SET $col=:da WHERE id=:id");
  $q->execute([
    ':da'=>$da,
    ':id'=>$id
  ]);
}
if($tbl=='login'&&$col=='email'){
	$h=$db->prepare("UPDATE `".$prefix."login` SET hash=:hash WHERE id=:id");
	$h->execute([
    ':hash'=>md5($da),
    ':id'=>$id
  ]);
}
$e=$db->errorInfo();
if($tbl=='orders'&&$col=='status'&&$da=='archived'){
  $r=$db->query("SELECT MAX(id) as id FROM `".$prefix."orders`")->fetch();
  $oid=strtoupper('A').date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
  $q=$db->prepare("UPDATE `".$prefix."orders` SET aid=:aid,aid_ti=:aid_ti WHERE id=:id");
  $q->execute([
    ':aid'=>$oid,
    ':aid_ti'=>$ti,
    ':id'=>$id
  ]);
}
if(is_null($e[2])){
	if($tbl=='orders'&&$col=='due_ti'){?>
	window.top.window.$("#due_ti").val(`<?php echo date($config['dateFormat'],$da);?>`);
<?php }
	if($tbl=='content'&&$col=='file'&&$da==''){
		if(file_exists('..'.DS.'media'.DS.'file_'.$id.'.jpeg'))
			unlink('..'.DS.'media'.DS.'file_'.$id.'.jpeg');
    if(file_exists('..'.DS.'media'.DS.'file_'.$id.'.jpg'))
			unlink('..'.DS.'media'.DS.'file_'.$id.'.jpg');
    if(file_exists('..'.DS.'media'.DS.'file_'.$id.'.png'))
			unlink('..'.DS.'media'.DS.'file_'.$id.'.png');
    if(file_exists('..'.DS.'media'.DS.'file_'.$id.'.gif'))
			unlink('..'.DS.'media'.DS.'file_'.$id.'.gif');
		if(file_exists('..'.DS.'media'.DS.'file_'.$id.'.tif'))
			unlink('..'.DS.'media'.DS.'file_'.$id.'.tif');
	}
	if($tbl=='config'&&$col=='php_honeypot'){?>
	window.top.window.$('#php_honeypot_link').html('<?php echo($da!=''?'<a target="_blank" href="'.$da.'">'.$da.'</a>':localize('Honey Pot File Not Uploaded'));?>');
<?php }
	if($tbl=='orderitems'||$tbl=='cart'){
    if($tbl=='cart'&&$col=='quantity'){
      if($da==0){
        $q=$db->prepare("DELETE FROM `".$prefix."cart` WHERE id=:id");
        $q->execute([':id'=>$id]);
        $cnt='';
      }
      $q=$db->prepare("SELECT SUM(quantity) as quantity FROM `".$prefix."cart` WHERE si=:si");
      $q->execute([':si'=>$si]);
      $r=$q->fetch(PDO::FETCH_ASSOC);
      $cnt=$r['quantity'];
      if($r['quantity']==0)
				$cnt='';?>
	window.top.window.$('#cart').html('<?php echo$cnt;?>');
<?php	}
      if($tbl=='orderitems'){
        $q=$db->prepare("SELECT oid FROM `".$prefix."orderitems` WHERE id=:id");
        $q->execute([':id'=>$id]);
        $iid=$q->fetch(PDO::FETCH_ASSOC);
      }
      if($tbl=='orderitems'&&$col=='quantity'&&$da==0){
        $q=$db->prepare("DELETE FROM `".$prefix."orderitems` WHERE id=:id");
        $q->execute([':id'=>$id]);
      }
      $total=0;
      $content=$html='';
      if($tbl=='cart'){
        $q=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE si=:si ORDER BY ti DESC");
        $q->execute([':si'=>$si]);
      }
      if($tbl=='orderitems'){
        $q=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid ORDER BY ti ASC,title ASC");
        $q->execute([':oid'=>$iid['oid']]);
      }
      while($oi=$q->fetch(PDO::FETCH_ASSOC)){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
        $s->execute([':id'=>$oi['iid']]);
        $i=$s->fetch(PDO::FETCH_ASSOC);
        $html.='<tr role="row">'.
                '<td class="text-left" role="cell">'.$i['code'].'</td>'.
                '<td class="text-left" role="cell">'.
                  '<form target="sp" action="core/update.php" role="form">'.
                    '<input type="hidden" name="id" value="'.$oi['id'].'">'.
                    '<input type="hidden" name="t" value="'.$tbl.'">'.
                    '<input type="hidden" name="c" value="title">'.
                    '<input type="text" class="form-control" name="da" value="'.($oi['title']!=''?$oi['title']:$i['title']).'" role="textbox">'.
                  '</form>'.
                '</td>'.
                '<td class="col-md-1 text-center" role="cell">'.
                  ($oi['iid']!=0?'<form target="sp" action="core/update.php" role="form"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="quantity"><input class="form-control text-center" name="da" value="'.$oi['quantity'].'" role="textbox"></form>':'').
                '</td>'.
                '<td class="col-md-1 text-right" role="cell">'.
                  ($oi['iid']!=0?'<form target="sp" action="core/update.php" role="form"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="cost"><input class="form-control text-center" name="da" value="'.$oi['cost'].'" role="textbox"></form>':'').
                '</td>'.
                '<td class="text-right" role="cell">'.($oi['iid'] != 0?$oi['cost']*$oi['quantity']:'').'</td>'.
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
        if($oi['iid']!=0)$total=$total+($oi['cost']*$oi['quantity']);
      }
      $html.='<tr role="row">'.
              '<td colspan="3" role="cell">&nbsp;</td>'.
              '<td class="text-right" role="cell"><strong>'.localize('Total').'</strong></td>'.
              '<td class="text-right" role="cell"><strong>'.$total.'</strong></td>'.
              '<td role="cell"></td>'.
            '</tr>';?>
	window.top.window.$('#updateorder').html('<?php echo $html;?>');
<?php }
    	if($tbl=='login'&&$col=='gravatar'){
        if($da==''){
          $sav=$db->prepare("SELECT avatar FROM `".$prefix."login` WHERE id=:id");
          $sav->execute([':id'=>$id]);
          $av=$sav->fetch(PDO::FETCH_ASSOC);
          if($av['avatar']!=''&&file_exists('..'.DS.'media'.DS.'avatar'.DS.$av['avatar']))$avatar='media'.DS.'avatar'.DS.$av['avatar'];
					else$avatar='images'.DS.'noavatar.jpg';
        }else$avatar=$da;?>
	window.top.window.$('#avatar').attr('src','<?php echo$avatar.'?'.time();?>');
<?php	}
	}
	if($col=='notes'){?>
	window.top.window.$('.note-block').removeClass('blocked');
<?php }
	if($col=='status'){
		if($da=='archived'){?>
	window.top.window.$('#l_<?php echo$id;?>').slideUp(500,function(){$(this).remove()});
<?php }
		if($tbl!='comments'||$da=='delete'||$da==''){?>
	window.top.window.$('#controls_<?php echo$id;?> button.btn').toggleClass('hidden');
  window.top.window.$('#l_<?php echo$id;?>').removeClass('danger');
<?php }
		if($da=='delete'){?>
	window.top.window.$('#l_<?php echo$id;?>').addClass('danger');
<?php }else{?>
	window.top.window.$('#l_<?php echo$id;?>').removeClass('danger');
<?php }
	}?>
	window.top.window.Pace.stop();
<?php
echo'</script>';
$s=$db->prepare("INSERT INTO `".$prefix."logs` (uid,rid,username,name,view,contentType,refTable,refColumn,oldda,newda,action,ti) VALUES (:uid,:rid,:username,:name,:view,:contentType,:refTable,:refColumn,:oldda,:newda,:action,:ti)");
$s->execute([
  ':uid'=>$log['uid'],
  ':rid'=>$log['rid'],
  ':username'=>$log['username'],
  ':name'=>$log['name'],
  ':view'=>$log['view'],
  ':contentType'=>$log['contentType'],
  ':refTable'=>$log['refTable'],
  ':refColumn'=>$log['refColumn'],
  ':oldda'=>$log['oldda'],
  ':newda'=>$log['newda'],
  ':action'=>$log['action'],
  ':ti'=>$log['ti']
]);
