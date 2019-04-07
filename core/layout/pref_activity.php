<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Activity Viewer
 *
 * pref_activity.php version 2.0.2
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
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php echo localize('Preferences');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Activity');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a href="#" class="btn btn-ghost-normal trash" onclick="purge('0','logs');return false;" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Purge All');?>" role="button" aria-label="<?php echo localize('aria_purge');?>"><?php svg('libre-gui-purge');?></a>
        <a href="#" class="btn btn-ghost-normal dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Show Items');?>" role="button" aria-label="<?php echo localize('aria_show');?>"><?php svg('libre-gui-view');?></a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>"><?php echo localize('All');?></a>
<?php $st=$db->query("SELECT DISTINCT action FROM `".$prefix."logs` ORDER BY action ASC");
while($sr=$st->fetch(PDO::FETCH_ASSOC))
  echo'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/preferences/activity/action/'.$sr['action'].'">'.localize(ucfirst($sr['action'])).'</a>';?>
        </div>
        <?php if($help['activity_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['activity_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['activity_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['activity_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
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
    if($r['action']=='create')$action.=' '.localize('Created').'<br>';
    if($r['action']=='update')$action.=' '.localize('Updated').'<br>';
    if($r['action']=='purge')$action.=' '.localize('Purged').'<br>';
    if(isset($c['title'])&&$c['title']!=''){
      $action.='<strong>'.localize('Title').':</strong> '.$c['title'].'<br>'.($r['action']=='update'?'<strong>'.localize('Table').':</strong> '.$r['refTable'].'<br>':'').'<strong>'.localize('Column').':</strong> '.$r['refColumn'].'<br>'.'<strong>'.localize('Data').':</strong>'.strip_tags(rawurldecode(substr($r['oldda'],0,300))).'<br>'.'<strong>'.localize('Changed To').':</strong>'.strip_tags(rawurldecode(substr($r['newda'],0,300))).'<br>';
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
              <button class="btn btn-secondary" onclick="activitySpy('<?php echo$r['id'];?>');" data-tooltip="tooltip" title="View Details" role="button" aria-label="<?php echo localize('aria_view');?>"><?php svg('libre-gui-fingerprint');?></button>
              <?php echo$r['action']=='update'?'<button class="btn btn-secondary" onclick="restore(\''.$r['id'].'\');" data-tooltip="tooltip" title="'.localize('Restore').'" role="button" aria-label="'.localize('aria_restore').'">'.svg2('libre-gui-undo').'</button>':'';?>
              <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','logs')" data-tooltip="tooltip" title="<?php echo localize('Purge');?>" role="button" aria-label="<?php echo localize('aria_purge');?>"><?php svg('libre-gui-trash');?></button>
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
