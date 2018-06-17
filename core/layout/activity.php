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
      <div class="btn-group" data-toggle="tooltip" data-placement="left" title="Purge All">
        <button class="btn btn-default trash" onclick="purge('0','logs')"><?php svg('libre-gui-purge',($config['iconsColor']==1?true:null));?></button>
      </div>
      <div class="btn-group" data-toggle="tooltip" data-placement="left" title="Show Items">
        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php svg('libre-gui-view',($config['iconsColor']==1?true:null));?></button>
        <ul class="dropdown-menu pull-right">
          <li><a href="<?php echo URL.$settings['system']['admin'].'/activity';?>">All</a></li>
<?php $st=$db->query("SELECT DISTINCT action FROM logs ORDER BY action ASC");
while($sr=$st->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.$settings['system']['admin'].'/activity/action/'.$sr['action'].'">'.ucfirst($sr['action']).'</a></li>';?>
        </ul>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#activity" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <section id="timeline" class="timeline-container">
<?php $s=$db->prepare("SELECT * FROM logs ORDER BY ti DESC");
$s->execute();
$i=1;
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $action='';
  if($r['refTable']=='content'){
    $sql=$db->prepare("SELECT * FROM ".$r['refTable']." WHERE id=:rid");
    $sql->execute(array(':rid'=>$r['rid']));
    $c=$sql->fetch(PDO::FETCH_ASSOC);
  }
  if($r['uid']!=0){
    $su=$db->prepare("SELECT id,username,avatar,gravatar,name,rank FROM login WHERE id=:id");
    $su->execute(array(':id'=>$r['uid']));
    $u=$su->fetch(PDO::FETCH_ASSOC);
  }else{
    $u=[
      'id'       => 0,
      'username' => 'Anonymous',
      'avatar'   => '',
      'gravatar' => '',
      'name'     => 'Anonymous',
      'rank'     => 1000
    ];
  }
  if($r['action']=='create')$action.=' Created<br>';
  if($r['action']=='update')$action.=' Updated<br>';
  if($r['action']=='purge')$action.=' Purged<br>';
  if(isset($c['title'])&&$c['title']!=''){
    $action.='<strong>Title:</strong> '.$c['title'].'<br>';
    $action.=($r['action']=='update'?'<strong>Table:</strong> '.$r['refTable'].'<br>':'');
    $action.='<strong>Column:</strong> '.$r['refColumn'].'<br>';
    $action.='<strong>Data:</strong>'.strip_tags(rawurldecode(substr($r['oldda'],0,300))).'<br>';
    $action.='<strong>Changed To:</strong>'.strip_tags(rawurldecode(substr($r['newda'],0,300))).'<br>';
  }
  $action.='<strong>by</strong> '.$u['username'].':'.$u['name'];
  if(isset($u['avatar'])&&$u['avatar']!=''){
    $image=(file_exists('media'.DS.'avatar'.DS.basename($u['avatar']))?'media'.DS.'avatar'.DS.basename($u['avatar']):NOAVATAR);
  }elseif(isset($u['gravatar'])&&$u['gravatar']!='')
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
            <button class="btn btn-default" onclick="activitySpy('<?php echo$r['id'];?>');" data-toggle="tooltip" title="View Details"><?php svg('libre-gui-fingerprint',($config['iconsColor']==1?true:null));?></button>
<?php echo($r['action']=='update'?'<button class="btn btn-default" onclick="restore(\''.$r['id'].'\');" data-toggle="tooltip" title="Restore">'.svg2('libre-gui-undo',($config['iconsColor']==1?true:null)).'</button>':'');?>
            <button class="btn btn-default trash" onclick="purge('<?php echo$r['id'];?>','logs')" data-toggle="tooltip" title="Purge"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
          </span>
          <span class="date"><?php echo _ago($r['ti']);?></span>
        </div>
      </div>
<?php
$i++;
}?>
    </section>
  </div>
</div>
<script>
  $(window).scroll(function () {
  	$('.timeline-block').each(function () {
  		if ($(this).offset().top <= $(window).scrollTop() + $(window).height() * 0.75 &&$ (this).find('.timeline-img').hasClass('hidden')) {
  			$(this).find('.timeline-img,.timeline-content').removeClass('hidden').addClass('animated zoomIn');
  		}
  	});
  });
</script>
