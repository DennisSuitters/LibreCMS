<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(isset($_GET['is'])){
  session_start();
  require_once'..'.DS.'db.php';
  $config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
  $su->execute(array(':id'=>$_SESSION['uid']));
  $user=$su->fetch(PDO::FETCH_ASSOC);
  $is=$_GET['is'];
  $ie=$_GET['ie'];
  $action=$_GET['action'];
  function _ago($time){
    $timeDiff=floor(abs(time()-$time)/60);
    if($timeDiff<2)$timeDiff='Just Now';
    elseif($timeDiff>2&&$timeDiff<60)$timeDiff=floor(abs($timeDiff)).' Minutes Ago';
    elseif($timeDiff>60&&$timeDiff<120)$timeDiff=floor(abs($timeDiff/60)).' Hour ago';
    elseif($timeDiff<1440)$timeDiff=floor(abs($timeDiff/60)).' Hours ago';
    elseif($timeDiff>1440&&$timeDiff<2880)$timeDiff=floor(abs($timeDiff/1440)).' Day Ago';
    elseif($timeDiff>2880)$timeDiff=floor(abs($timeDiff/1440)).' Days Ago';
    return$timeDiff;
  }
  function svg($svg,$class=null,$size=null){
	   echo'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('..'.DS.'svg'.DS.$svg.'.svg').'</i>';
  }
}
if($action!=''){
  $s=$db->prepare("SELECT * FROM `".$prefix."logs` WHERE action=:action ORDER BY ti DESC LIMIT ".$is."," . $ie);
  $s->execute(array(':action'=>$action));
}else{
  $s=$db->prepare("SELECT * FROM `".$prefix."logs` ORDER BY ti DESC LIMIT ".$is.",".$ie);
  $s->execute();
}
$cnt=$s->rowCount();
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  if($r['refTable']=='content'){
    $sql=$db->prepare("SELECT * FROM ".$prefix.$r['refTable']." WHERE id=:id");
    $sql->execute(array(':id'=>$r['id']));
    $c=$sql->fetch(PDO::FETCH_ASSOC);
  }
  $su=$db->prepare("SELECT id,username,name,rank FROM `".$prefix."login` WHERE id=:id");
  $su->execute(array(':id'=>$r['uid']));
  $u=$su->fetch(PDO::FETCH_ASSOC);
  $action='<strong>Action:</strong> '.ucfirst($r['contentType']);
  if($r['action']=='create')$action.=' Created<Br>';
  if($r['action']=='update')$action.=' Updated<br>';
  if($r['action']=='purge')$action.=' Purged<br>';
  if(isset($c['title'])&&$c['title']!=''){
    $action.='<strong>Title:</strong> '.$c['title'].'<br>'.
              ($r['action']=='update'?'<strong>Table:</strong> '.$r['refTable'].'<br>':'').
              '<strong>Column:</strong> '.$r['refColumn'].'<br>'.
              '<strong>Data:</strong>'.strip_tags(rawurldecode(substr($r['oldda'],0,300))).'<br>'.
              '<strong>Changed To:</strong>'.strip_tags(rawurldecode(substr($r['newda'],0,300))).'<br>';
  }
  $action.='<strong>by</strong> '.$u['username'].':'.$u['name'];?>
<tr id="l_<?php echo$r['id'];?>">
  <td>
    <small><?php echo date($config['dateFormat'],$r['ti']);?></small><br>
    <small><?php echo _ago($r['ti']);?></small>
    <div class="visible-xs"><?php echo$action;?></div>
  </td>
  <td class="break-word hidden-xs"><?php echo$action;?></td>
  <td id="controls_<?php echo$r['id'];?>">
    <div class="btn-group pull-right">
      <button class="btn btn-default" onclick="activitySpy('<?php echo$r['id'];?>');" data-toggle="tooltip" title="View Details"><?php svg('libre-gui-fingerprint');?></button>
      <?php echo$r['action']=='update'?'<button class="btn btn-default" onclick="restore(\''.$r['id'].'\');" data-toggle="tooltip" title="Restore">'.svg2('libre-gui-undo',($config['iconsColor']==1?true:null)).'</button>':'';?>
      <button class="btn btn-default trash" onclick="purge('<?php echo$r['id'];?>','logs')" data-toggle="tooltip" title="Purge"><?php svg('libre-gui-trash');?></button>
    </div>
  </td>
</tr>
<tr id="details<?php echo$r['id'];?>" class="hidden">
  <td colspan="3">
    <i class="libre animated spin"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" id="libre-spinner-13"><g id="g3341" transform="matrix(0.05331877,0,0,0.0470101,-0.19803392,13.487394)" style="stroke-width:9.81667709;stroke-miterlimit:4;stroke-dasharray:none"><ellipse style="fill:none;stroke:#000000;stroke-width:9.81667709;stroke-miterlimit:4;stroke-dasharray:none" ry="144" rx="40" cy="-138" cx="135" id="e"/><use height="100%" width="100%" y="0" x="0" id="use5" transform="matrix(0.5,0.8660254,-0.8660254,0.5,-52.011501,-185.91343)" xlink:href="#e" style="stroke-width:9.81667709;stroke-miterlimit:4;stroke-dasharray:none"/><use height="100%" width="100%" y="0" x="0" id="use7" transform="matrix(0.5,-0.8660254,0.8660254,0.5,187.0115,47.91343)" xlink:href="#e" style="stroke-width:9.81667709;stroke-miterlimit:4;stroke-dasharray:none"/></g></svg></i>
  </td>
</tr>
<?php }
if($cnt==$ie){?>
<tr id="more_<?php echo$is+$ie+1;?>">
  <td colspan="3">
    <button class="btn btn-default btn-block" onclick="loadMore('activity_items','<?php echo$is+$ie+1;?>','<?php echo$ie;?>','<?php echo$action;?>');">More</button>
  </td>
</tr>
<?php }
