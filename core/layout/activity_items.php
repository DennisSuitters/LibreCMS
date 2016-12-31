<?php
if(isset($_GET['is'])){
  session_start();
  require'../db.php';
  $config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
  $su=$db->prepare("SELECT * FROM login WHERE id=:id");
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
  function svg($svg,$size=null,$color=null){
    echo'<i class="libre';
    if($size!=null)echo' libre-'.$size;
    if($color!=null)echo' libre-'.$color;echo'">';
    include'../svg/libre-'.$svg.'.svg';
    echo'</i>';
  }
}
if($action!=''){
  $s=$db->prepare("SELECT * FROM logs WHERE action=:action ORDER BY ti DESC LIMIT ".$is.",".$ie);
  $s->execute(array(':action'=>$action));
}else{
  $s=$db->prepare("SELECT * FROM logs ORDER BY ti DESC LIMIT ".$is.",".$ie);
  $s->execute();
}
$cnt=$s->rowCount();
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  if($r['refTable']=='content'){
    $sql=$db->prepare("SELECT * FROM ".$r['refTable']." WHERE id=:id");
    $sql->execute(array(':id'=>$r['id']));
    $c=$sql->fetch(PDO::FETCH_ASSOC);
  }
  $su=$db->prepare("SELECT id,username,name,rank FROM login WHERE id=:id");
  $su->execute(array(':id'=>$r['uid']));
  $u=$su->fetch(PDO::FETCH_ASSOC);
  $action='<strong>Action:</strong> '.ucfirst($r['contentType']);
  if($r['action']=='create')$action.=' Created<Br>';
  if($r['action']=='update')$action.=' Updated<br>';
  if($r['action']=='purge')$action.=' Purged<br>';
  if(isset($c['title'])&&$c['title']!=''){
    $action.='<strong>Title:</strong> '.$c['title'].'<br>';
    if($r['action']=='update')$action.='<strong>Table:</strong> '.$r['refTable'].'<br>';
    $action.='<strong>Column:</strong> '.$r['refColumn'].'<br>';
    $action.='<strong>Data:</strong>'.strip_tags(substr($r['oldda'],0,300)).'<br>';
    $action.='<strong>Changed To:</strong>'.strip_tags(substr($r['newda'],0,300)).'<br>';
  }
  $action.='<strong>by</strong> '.$u['username'].':'.$u['name'];?>
<tr id="l_<?php echo$r['id'];?>">
  <td>
    <small><?php echo date($config['dateFormat'],$r['ti']);?></small><br>
    <small><?php echo _ago($r['ti']);?></small>
    <div class="visible-xs"><?php echo$action;?></div>
  </td>
  <td class="break-word hidden-xs"><?php echo$action;?></td>
  <td id="controls_<?php echo$r['id'];?>" class="text-right">
<?php if($r['action']=='update'){?>
    <button class="btn btn-default" onclick="restore('<?php echo$r['id'];?>');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><?php svg('restore');?></button>
<?php }?>
    <button class="btn btn-default trash" onclick="purge('<?php echo$r['id'];?>','logs')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><?php svg('trash');?></button>
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
