<?php
$action=isset($_GET['action'])?filter_input(INPUT_GET,'action',FILTER_SANITIZE_STRING):'';
$sid=isset($_POST['sid'])?filter_input(INPUT_POST,'sid',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'sid',FILTER_SANITIZE_STRING);
if(isset($_GET['is'])){
  session_start();
  require'../db.php';
  $config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
  $su=$db->prepare("SELECT * FROM login WHERE id=:id");
  $su->execute(array(':id'=>$_SESSION['uid']));
  $user=$su->fetch(PDO::FETCH_ASSOC);
  if(isset($_GET['is']))$is=filter_input(INPUT_GET,'is',FILTER_SANITIZE_STRING);
  if(isset($_GET['ie']))$ie=filter_input(INPUT_GET,'ie',FILTER_SANITIZE_STRING);
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
  $s=$db->prepare("SELECT * FROM tracker WHERE sid=:sid ORDER BY ti ASC");
  $s->execute(array(':sid'=>$sid));
}else{
  $s=$db->prepare("SELECT * FROM tracker ORDER BY ti DESC LIMIT ".$is.",".$ie);
  $s->execute();
}
$cnt=$s->rowCount();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
<tr id="l_<?php echo$r['id'];?>">
  <td class="text-nooverflow"><small><a href="<?php echo URL.$settings['system']['admin'].'/tracker?action=view&sid='.$r['sid'];?>"><?php echo$r['urlDest'];?></a></small></td>
  <td class="text-nooverflow"><small><?php if($r['urlFrom']!='')echo'<a target="_blank" href="'.$r['urlFrom'].'">'.$r['urlFrom'].'</a>';?></small></td>
  <td class="text-center"><small><a target="_blank" href="http://www.ipaddress-finder.com/?ip=<?php echo$r['ip'];?>"><?php echo$r['ip'];?></a></small></td>
  <td class="text-center"><small><?php echo ucfirst($r['browser']);?></small></td>
  <td class="text-center"><small><?php echo ucfirst($r['os']);?></small></td>
  <td class="text-center"><small><?php echo date($config['dateFormat'],$r['ti']);?></small></td>
</tr>
<?php }
if($cnt==$ie){?>
<tr id="more_<?php echo$is+$ie+1;?>">
  <td colspan="5">
    <button class="btn btn-default btn-block" onclick="loadMore('tracker_items','<?php echo$is+$ie+1;?>','<?php echo$ie;?>','<?php echo$action;?>');">More</button>
  </td>
</tr>
<?php }
