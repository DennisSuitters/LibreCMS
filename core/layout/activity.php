<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Activity</h4>
    <div class="pull-right">
      <div class="btn-group"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Purge All"';?>>
        <button class="btn btn-default trash" onclick="purge('0','logs')"><?php svg('purge');?></button>
      </div>
      <div class="btn-group"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Show Items"';?>>
        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php svg('view');?></button>
        <ul class="dropdown-menu pull-right">
          <li><a href="<?php echo URL.$settings['system']['admin'].'/activity';?>">All</a></li>
<?php $st=$db->query("SELECT DISTINCT action FROM logs ORDER BY action ASC");
while($sr=$st->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.$settings['system']['admin'].'/activity/action/'.$sr['action'].'">'.ucfirst($sr['action']).'</a></li>';?>
        </ul>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#activity"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
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
    $action.='<strong>Title:</strong> '.$c['title'].'<br>';
    if($r['action']=='update')$action.='<strong>Table:</strong> '.$r['refTable'].'<br>';
    $action.='<strong>Column:</strong> '.$r['refColumn'].'<br>';
    $action.='<strong>Data:</strong>'.strip_tags(rawurldecode(substr($r['oldda'],0,300))).'<br>';
    $action.='<strong>Changed To:</strong>'.strip_tags(rawurldecode(substr($r['newda'],0,300))).'<br>';
  }
  $action.='<strong>by</strong> '.$u['username'].':'.$u['name'];
  if(isset($u['avatar'])&&$u['avatar']!=''){
    $image=basename($u['avatar']);
    if(file_exists('media/avatar/'.$image))$image='media/avatar/'.$image;else$image='core/svg/libre-activity.svg';
  }elseif(isset($u['gravatar'])&&$u['gravatar']!=''){
    $image=$u['gravatar'];
  }else{
    $image='core/svg/libre-user.svg';
  }?>
      <div id="l_<?php echo$r['id'];?>" class="timeline-block">
        <div class="timeline-img <?php echo$r['action'];?><?php if($i>3)echo' hidden';?>">
          <img src="<?php echo$image;?>" alt="Picture">
        </div>
        <div class="timeline-content<?php if($i>3)echo' hidden';?>">
          <p><?php echo$action;?></p>
          <span class="read-more">
            <button class="btn btn-default" onclick="activitySpy('<?php echo$r['id'];?>');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="View Details"';?>><?php svg('fingerprint');?></button>
<?php if($r['action']=='update'){?>
            <button class="btn btn-default" onclick="restore('<?php echo$r['id'];?>');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><?php svg('undo');?></button>
<?php }?>
            <button class="btn btn-default trash" onclick="purge('<?php echo$r['id'];?>','logs')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><?php svg('trash');?></button>
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
  $(window).scroll(function(){
  	$('.timeline-block').each(function(){
  		if($(this).offset().top<=$(window).scrollTop()+$(window).height()*0.75&&$(this).find('.timeline-img').hasClass('hidden')){
  			$(this).find('.timeline-img,.timeline-content').removeClass('hidden').addClass('animated zoomIn');
  		}
  	});
  });
</script>