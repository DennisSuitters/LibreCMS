<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Activity</h4>
    <div class="pull-right">
      <div class="btn-group">
        <button class="btn btn-default trash" onclick="purge('0','logs')" data-tooltip="tooltip" data-placement="left" title="Purge All"><?php svg('libre-gui-purge');?></button>
        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" data-placement="left" title="Show Items"><?php svg('libre-gui-view');?></button>
        <ul class="dropdown-menu pull-right">
          <li><a href="<?php echo URL.$settings['system']['admin'].'/activity';?>">All</a></li>
          <?php $st=$db->query("SELECT DISTINCT action FROM logs ORDER BY action ASC");while($sr=$st->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.$settings['system']['admin'].'/activity/action/'.$sr['action'].'">'.ucfirst($sr['action']).'</a></li>';?>
        </ul>
        <?php if($help['activity_text']!='')echo'<a target="_blank" class="btn btn-default info" href="'.$help['activity_text'].'" data-toggle="tooltip" data-placement="left" title="Help">'.svg2('libre-gui-help').'</a>';if($help['activity_video']!='')echo'<a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['activity_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <section id="timeline" class="timeline-container">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."logs` ORDER BY ti DESC");
$s->execute();
$i=1;
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $action='';
  if($r['refTable']=='content'){
    $sql=$db->prepare("SELECT * FROM ".$prefix.$r['refTable']." WHERE id=:rid");
    $sql->execute(array(':rid'=>$r['rid']));
    $c=$sql->fetch(PDO::FETCH_ASSOC);
  }
  if($r['uid']!=0){
    $su=$db->prepare("SELECT id,username,avatar,gravatar,name,rank FROM `".$prefix."login` WHERE id=:id");
    $su->execute(array(':id'=>$r['uid']));
    $u=$su->fetch(PDO::FETCH_ASSOC);
  }else{
    $u=[
      'id'=>0,
      'username'=>'Anonymous',
      'avatar'=>'',
      'gravatar'=>'',
      'name'=>'Anonymous',
      'rank'=>1000
    ];
  }
  if($r['action']=='create')$action.=' Created<br>';
  if($r['action']=='update')$action.=' Updated<br>';
  if($r['action']=='purge')$action.=' Purged<br>';
  if(isset($c['title'])&&$c['title']!=''){
    $action.='<strong>Title:</strong> '.$c['title'].'<br>'.
              ($r['action']=='update'?'<strong>Table:</strong> '.$r['refTable'].'<br>':'').
              '<strong>Column:</strong> '.$r['refColumn'].'<br>'.
              '<strong>Data:</strong>'.strip_tags(rawurldecode(substr($r['oldda'],0,300))).'<br>'.
              '<strong>Changed To:</strong>'.strip_tags(rawurldecode(substr($r['newda'],0,300))).'<br>';
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
        <div class="timeline-content<?php echo($i>3?' hidden':'');?>">
          <p><?php echo $action;?></p>
          <span class="read-more">
            <div class="btn-group">
              <button class="btn btn-default" onclick="activitySpy('<?php echo$r['id'];?>');" data-toggle="tooltip" title="View Details"><?php svg('libre-gui-fingerprint');?></button>
              <?php echo$r['action']=='update'?'<button class="btn btn-default" onclick="restore(\''.$r['id'].'\');" data-toggle="tooltip" title="Restore">'.svg2('libre-gui-undo').'</button>':'';?>
              <button class="btn btn-default trash" onclick="purge('<?php echo$r['id'];?>','logs')" data-toggle="tooltip" title="Purge"><?php svg('libre-gui-trash');?></button>
            </div>
          </span>
          <span class="date"><?php echo _ago($r['ti']);?></span>
        </div>
      </div>
<?php $i++;
}?>
    </section>
  </div>
</div>
<script>/*<![CDATA[*/
  $(window).scroll(function(){
  	$('.timeline-block').each(function(){
  		if($(this).offset().top<=$(window).scrollTop()+$(window).height()*.75&&$(this).find('.timeline-img').hasClass('hidden')){
  			$(this).find('.timeline-img,.timeline-content').removeClass('hidden').addClass('animated zoomIn');
  		}
  	});
  });
/*]]>*/</script>
