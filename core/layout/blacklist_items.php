<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$action=isset($_GET['action'])?filter_input(INPUT_GET,'action',FILTER_SANITIZE_STRING):'';
$sid=isset($_POST['sid'])?filter_input(INPUT_POST,'sid',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'sid',FILTER_SANITIZE_STRING);
if(isset($_GET['is'])){
  session_start();
  require_once'..'.DS.'db.php';
  $config=$db->query("SELECT * FROM `".$prefix."config` WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
  $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
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
  function svg($svg,$class=null,$size=null){
  	echo'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('..'.DS.'..'.DS.'svg'.DS.$svg.'.svg').'</i>';
  }
  function svg2($svg,$class=null,$size=null){
  	return'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('..'.DS.'..'.DS.'svg'.DS.$svg.'.svg').'</i>';
  }
}
if($action!=''){
  $s=$db->prepare("SELECT * FROM `".$prefix."iplist` WHERE sid=:sid ORDER BY ti ASC");
  $s->execute(array(':sid'=>$sid));
}else{
  $s=$db->prepare("SELECT * FROM `".$prefix."iplist` ORDER BY ti DESC");
  $s->execute();
}
$cnt=$s->rowCount();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
<tr id="l_<?php echo$r['id'];?>">
  <td class="text-center"><small><?php echo date($config['dateFormat'],$r['ti']);?></small></td>
  <td class="text-center"><small><?php echo date($config['dateFormat'],$r['oti']);?></small></td>
  <td class="text-center"><small><?php echo'<strong>'.$r['ip'].'</strong>';?></small></td>
  <td id="controls_<?php echo$r['id'];?>">
    <div class="btn-group float-right">
      <a class="btn btn-secondary" target="_blank" href="https://www.projecthoneypot.org/ip_<?php echo$r['ip'];?>"><?php echo svg2('libre-brand-projecthoneypot');?></a>
      <a class="btn btn-secondary" target="_blank" href="http://www.ipaddress-finder.com/?ip=<?php echo$r['ip'];?>"><?php echo svg2('libre-gui-search');?></a>
      <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','blacklist');" data-toggle="tooltip" title="Purge"><?php svg('libre-gui-purge');?></button>
    </div>
  </td>
</tr>
<?php }
