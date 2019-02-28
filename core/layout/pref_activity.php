<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Activity Viewer
 *
 * pref_activity.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Preferences - Activity
 * @package    core/layout/pref_activity.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active" aria-current="page">Activity</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a href="#" class="btn btn-ghost-normal trash" onclick="purge('0','logs');return false;" data-tooltip="tooltip" data-placement="left" title="Purge All"><?php svg('libre-gui-purge');?></a>
        <a href="#" class="btn btn-ghost-normal dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" data-placement="left" title="Show Items"><?php svg('libre-gui-view');?></a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>">All</a>
<?php $st=$db->query("SELECT DISTINCT action FROM `".$prefix."logs` ORDER BY action ASC");
while($sr=$st->fetch(PDO::FETCH_ASSOC))
  echo'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/preferences/activity/action/'.$sr['action'].'">'.ucfirst($sr['action']).'</a>';?>
        </div>
<?php if($help['activity_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['activity_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['activity_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['activity_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <section id="l_logs" class="timeline-container">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."logs` ORDER BY ti DESC");
  $s->execute();
  $i=1;
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $action='';
    if($r['refTable']=='content'){
      $sql=$db->prepare("SELECT * FROM ".$prefix.$r['refTable']." WHERE id=:rid");
      $sql->execute([':rid'=>$r['rid']]);
      $c=$sql->fetch(PDO::FETCH_ASSOC);
    }
    if($r['uid']!=0){
      $su=$db->prepare("SELECT id,username,avatar,gravatar,name,rank FROM `".$prefix."login` WHERE id=:id");
      $su->execute([':id'=>$r['uid']]);
      $u=$su->fetch(PDO::FETCH_ASSOC);
    }else{
      $u=['id'=>0,'username'=>'Anonymous','avatar'=>'','gravatar'=>'','name'=>'Anonymous','rank'=>1000];
    }
    if($r['action']=='create')$action.=' Created<br>';
    if($r['action']=='update')$action.=' Updated<br>';
    if($r['action']=='purge')$action.=' Purged<br>';
    if(isset($c['title'])&&$c['title']!=''){
      $action.='<strong>Title:</strong> '.$c['title'].'<br>'.($r['action']=='update'?'<strong>Table:</strong> '.$r['refTable'].'<br>':'').'<strong>Column:</strong> '.$r['refColumn'].'<br>'.'<strong>Data:</strong>'.strip_tags(rawurldecode(substr($r['oldda'],0,300))).'<br>'.'<strong>Changed To:</strong>'.strip_tags(rawurldecode(substr($r['newda'],0,300))).'<br>';
    }
    $action.='<strong>by</strong> '.$u['username'].':'.$u['name'];
    if(isset($u['avatar'])&&$u['avatar']!='')
      $image=file_exists('media'.DS.'avatar'.DS.basename($u['avatar']))?'media'.DS.'avatar'.DS.basename($u['avatar']):NOAVATAR;
    elseif(isset($u['gravatar'])&&$u['gravatar']!='')
      $image=$u['gravatar'];
    else
      $image=NOAVATAR;?>
      <div id="l_<?php echo$r['id'];?>" class="timeline-block">
        <div class="timeline-img <?php echo$r['action'];?><?php echo($i>3?' hidden':'');?>">
          <img class="img-circle" src="<?php echo$image;?>" alt="Picture">
        </div>
        <div class="timeline-content card<?php echo($i>3?' hidden':'');?>">
          <p><?php echo $action;?></p>
          <span class="read-more">
            <div class="btn-group">
              <button class="btn btn-secondary" onclick="activitySpy('<?php echo$r['id'];?>');" data-tooltip="tooltip" title="View Details"><?php svg('libre-gui-fingerprint');?></button>
<?php echo$r['action']=='update'?'<button class="btn btn-secondary" onclick="restore(\''.$r['id'].'\');" data-tooltip="tooltip" title="Restore">'.svg2('libre-gui-undo').'</button>':'';?>
              <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','logs')" data-tooltip="tooltip" title="Purge"><?php svg('libre-gui-trash');?></button>
            </div>
          </span>
          <span class="date"><?php echo _ago($r['ti']);?></span>
        </div>
      </div>
<?php $i++;
}?>
    </section>
  </div>
</main>
<script>
  $(window).scroll(function(){
  	$('.timeline-block').each(function(){
  		if($(this).offset().top<=$(window).scrollTop()+$(window).height()*.75&&$(this).find('.timeline-img').hasClass('hidden')){
  			$(this).find('.timeline-img,.timeline-content').removeClass('hidden').addClass('animated zoomIn');
  		}
  	});
  });
</script>
