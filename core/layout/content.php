<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$rank=0;
$show='categories';
if($args[0]=='scheduler'){
  include'core'.DS.'layout'.DS.'scheduler.php';
}else{
if($view=='add'){
  $ti=time();
  $schema='';
  $comments=0;
  if($args[0]=='article')$schema='blogPosting';
  if($args[0]=='inventory')$schema='Product';
  if($args[0]=='service')$schema='Service';
  if($args[0]=='gallery')$schema='ImageGallery';
  if($args[0]=='testimonial')$schema='Review';
  if($args[0]=='news')$schema='NewsArticle';
  if($args[0]=='event')$schema='Event';
  if($args[0]=='portfolio')$schema='CreativeWork';
  if($args[0]=='proof'){
    $schema='CreativeWork';
    $comments=1;
  }
  $q=$db->prepare("INSERT INTO `".$prefix."content` (options,uid,login_user,contentType,schemaType,status,active,ti,eti,pti) VALUES ('00000000',:uid,:login_user,:contentType,:schemaType,'unpublished','1',:ti,:ti,:ti)");
  $uid=isset($user['id'])?$user['id']:0;
  $login_user=$user['name']!=''?$user['name']:$user['username'];
  $q->execute(
    array(
      ':contentType'=>$args[0],
      ':uid'=>$uid,
      ':login_user'=>$login_user,
      ':schemaType'=>$schema,
      ':ti'=>$ti
    )
  );
  $id=$db->lastInsertId();
  $args[0]=ucfirst($args[0]).' '.$id;
  $s=$db->prepare("UPDATE `".$prefix."content` SET title=:title WHERE id=:id");
  $s->execute(
    array(
      ':title'=>$args[0],
      ':id'=>$id
    )
  );
  if($view!='bookings')$show='item';
  $rank=0;
  $args[0]='edit';
  $args[1]=$id;
  echo'<script>/*<![CDATA[*/history.replaceState("","","'.URL.$settings['system']['admin'].'/content/edit/'.$args[1].'");/*]]>*/</script>';
}
if($args[0]=='edit'){
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
  $s->execute(array(':id'=>$args[1]));
  $show='item';
}
if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_content.php';
else{
  if($show=='categories'){
    if($args[0]=='type'){
      $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType=:contentType AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
      $s->execute(array(':contentType'=>$args[1]));
    }else{
      if(isset($args[1])){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
        $s->execute(
          array(
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1])
          )
        );
      }elseif(isset($args[0])){
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE LOWER(category_1) LIKE LOWER(:category_1) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti ASC,title ASC");
        $s->execute(array(':category_1' => str_replace('-',' ',$args[0])));
      }else{
        $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType!='booking' AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
        $s->execute();
      }
    }?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Content</li>
<?php if($args[1]!=''){?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst($args[1]).(in_array($args[1],array('article','service'))?'s':'');?></li>
<?php }?>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'];?>/add/<?php echo$args[1];?>" data-tooltip="tooltip" data-placement="left" title="Add New <?php echo ucfirst($args[1]);?>"><?php svg('libre-gui-add');?></a>
        <a class="btn btn-ghost-normal info" href="<?php echo URL.$settings['system']['admin'].'/content/settings';?>" data-toggle="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings');?></a>
        <?php if($help['content_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['content_text'].'" data-toggle="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['content_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['content_video'].'" data-toggle="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <table class="table table-condensed table-striped table-hover">
          <thead>
            <tr>
              <th class=""></th>
              <th class="col">Title</th>
              <th class="col-sm-1 text-center">Comments</th>
              <th class="col-sm-1 text-center" data-tooltip="tooltip" title="Reviews/score">Reviews</th>
              <th class="col-3 text-center">
                Views
                <button type="button" class="btn btn-ghost-dark dropdown-toggle p-0" data-toggle="dropdown" aria-haspop="true" aria-expanded="false"></button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="#" onclick="$('[data-views=\'views\']').text('0');purge('0','contentviews','<?php echo$args[1];?>');return false;">Clear All</a>
                </div>
              </th>
              <th class="col-sm-2"></th>
            </tr>
          </thead>
          <tbody id="listtype" class="list" data-t="menu" data-c="ord">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='delete')echo' danger';elseif($r['status']!='published')echo' warning';?>">
              <td class="">
<?php if($r['thumb']!='')
                echo'<img class="img-responsive img-rounded" style="max-width:32px;" src="'.$r['thumb'].'">';
elseif($r['file']!='')
                echo'<img class="img-responsive img-rounded" style="max-width:32px;" src="'.$r['file'].'">';
elseif($r['fileURL']!='')
                echo'<img class="img-responsive img-rounded" style="max-width:32px;" src="'.$r['fileURL'].'">';
else
                echo'';?>
              </td>
              <td>
                <a href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>"><?php echo $r['thumb']!=''&&file_exists($r['thumb'])?'<img class="table-thumb" src="'.$r['thumb'].'"> ':'';echo$r['title'];?></a>
                <?php echo$r['suggestions']==1?'<span data-tooltip="tooltip" data-placement="top" title="Editing suggestions.">'.svg2('libre-gui-lightbulb').'</span>':'';?>
<?php if($r['contentType']=='proofs'){
$sp=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$sp->execute(array(':id'=>$r['uid']));
$sr=$sp->fetch(PDO::FETCH_ASSOC);?>
                <div class="small"><small><small>Belongs to <a href="<?php echo URL.$settings['system']['admin'].'/accounts/edit/'.$sr['id'].'#account-proofs';?>"><?php echo$sr['username'].$sr['name']!=''?':'.$sr['name']:'';?></a></small></small></div>
<?php }?>
              </td>
              <td class="text-center">
<?php if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){
  $sc=$db->prepare("SELECT COUNT(id) as cnt FROM `".$prefix."comments` WHERE rid=:id AND contentType=:contentType");
  $sc->execute(
    array(
      ':id'=>$r['id'],
      ':contentType'=>$r['contentType']
    )
  );
  $cnt=$sc->fetch(PDO::FETCH_ASSOC);
  $scc=$db->prepare("SELECT id FROM `".$prefix."comments` WHERE rid=:id AND contentType=:contentType AND status='unapproved'");
  $scc->execute(
    array(
      ':id'=>$r['id'],
      'contentType'=>$r['contentType']
    )
  );
  $sccc=$scc->rowCount($scc);
                echo'<a class="btn btn-secondary'.($sccc>0?' btn-success':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#d43"'.($sccc>0?' data-tooltip="tooltip" title="'.$sccc.' New Comments"':'').'>'.svg2('libre-gui-comments').'&nbsp;&nbsp;'.$cnt['cnt'].'</a>';
}?>
              </td>
              <td class="text-center">
<?php $sr=$db->prepare("SELECT COUNT(id) as num,SUM(cid) as cnt FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid");
$sr->execute(array(':rid'=>$r['id']));
$rr=$sr->fetch(PDO::FETCH_ASSOC);
$srr=$db->prepare("SELECT id FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid AND status!='approved'");
$srr->execute(array(':rid'=>$r['id']));
$src=$srr->rowCount($srr);
                echo$rr['num']>0?'<a class="btn btn-secondary'.($src>0?' btn-success':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#d60"'.($src>0?' data-toggle="tooltip" title="'.$src.' New Reviews"':'').'>'.$rr['num'] .'/'.$rr['cnt'].'</a>':'';?>
              </td>
              <td class="text-center">
                <button class="btn btn-secondary trash" onclick="$('#views<?php echo$r['id'];?>').text('0');updateButtons('<?php echo$r['id'];?>','content','views','0');"><?php svg('libre-gui-eraser');?>&nbsp;&nbsp;<span id="views<?php echo$r['id'];?>" data-views="views"><?php echo$r['views'];?></span></button>
              </td>
              <td id="controls_<?php echo$r['id'];?>">
                <div class="btn-group float-right">
                  <a id="pin<?php echo$r['id'];?>" class="btn btn-secondary<?php echo$r['pin']{0}==1?' btn-success':'';?>" onclick="pinToggle('<?php echo$r['id'];?>','content','pin','0')" data-tooltip="tooltip" title="Pin"><?php svg('libre-gui-pin');?></a>
                  <a class="btn btn-secondary" href="<?php echo URL.$settings['system']['admin'];?>/content/edit/<?php echo$r['id'];?>" data-tooltip="tooltip" title="Edit"><?php svg('libre-gui-edit');?></a>
<?php if($user['rank']==1000||$user['options']{0}==1){?>
                  <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-tooltip="tooltip" title="Restore"><?php svg('libre-gui-untrash');?></button>
                  <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                  <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo$r['id'];?>','content')" data-toggle="tooltip" title="Purge"><?php svg('libre-gui-purge');?></button>
<?php }?>
                </div>
              </td>
            </tr>
<?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<?php }
    if($show=='item'){
      include'core'.DS.'layout'.DS.'edit_content.php';
    }
  }
}