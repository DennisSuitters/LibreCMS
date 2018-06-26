<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$rank=0;
$show='categories';
if($view=='add'){
  $ti=time();
  $schema='';
  $comments=0;
  if($args[0]=='article')     $schema='blogPosting';
  if($args[0]=='inventory')   $schema='Product';
  if($args[0]=='service')     $schema='Service';
  if($args[0]=='gallery')     $schema='ImageGallery';
  if($args[0]=='testimonial') $schema='Review';
  if($args[0]=='news')        $schema='NewsArticle';
  if($args[0]=='event')       $schema='Event';
  if($args[0]=='portfolio')   $schema='CreativeWork';
  if($args[0]=='proof'){
    $schema='CreativeWork';
    $comments=1;
  }
  $q=$db->prepare("INSERT INTO content (options,uid,login_user,contentType,schemaType,status,active,ti,eti,pti) VALUES ('00000000',:uid,:login_user,:contentType,:schemaType,'unpublished','1',:ti,:ti,:ti)");
  $uid=(isset($user['id'])?$user['id']:0);
  $login_user=($user['name']!=''?$user['name']:$user['username']);
  $q->execute(
    array(
      ':contentType' => $args[0],
      ':uid'         => $uid,
      ':login_user'  => $login_user,
      ':schemaType'  => $schema,
      ':ti'          => $ti
    )
  );
  $id=$db->lastInsertId();
  $args[0]=ucfirst($args[0]).' '.$id;
  $s=$db->prepare("UPDATE content SET title=:title WHERE id=:id");
  $s->execute(
    array(
      ':title' => $args[0],
      ':id'    => $id
    )
  );
  if($view!='bookings')$show='item';
  $rank=0;
  $args[0]='edit';
  $args[1]=$id;?>
<script>/*<![CDATA[*/
  history.replaceState('','','<?php echo URL.$settings['system']['admin'].'/content/edit/'.$args[1];?>');
/*]]>*/</script>
<?php
}
if($args[0]=='edit'){
  $s=$db->prepare("SELECT * FROM content WHERE id=:id");
  $s->execute(array(':id'=>$args[1]));
  $show='item';
}
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_content.php';
else{
  if($show=='categories'){
    if($args[0]=='type'){
      $s=$db->prepare("SELECT * FROM content WHERE contentType=:contentType AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
      $s->execute(array(':contentType'=>$args[1]));
    }else{
      if(isset($args[1])){
        $s=$db->prepare("SELECT * FROM content WHERE LOWER(category_1) LIKE LOWER(:category_1) AND LOWER(category_2) LIKE LOWER(:category_2) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
        $s->execute(
          array(
            ':category_1'=>str_replace('-',' ',$args[0]),
            ':category_2'=>str_replace('-',' ',$args[1])
          )
        );
      }elseif(isset($args[0])){
        $s=$db->prepare("SELECT * FROM content WHERE LOWER(category_1) LIKE LOWER(:category_1) AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti ASC,title ASC");
        $s->execute(array(':category_1' => str_replace('-',' ',$args[0])));
      }else{
        $s=$db->prepare("SELECT * FROM content WHERE contentType!='booking' AND contentType!='message_primary' AND contentType!='newsletters' ORDER BY pin DESC,ti DESC,title ASC");
        $s->execute();
      }
    }?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">
      <ol class="breadcrumb">
        <li><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
        <li class="active relative">
          <a class="dropdown-toggle" data-toggle="dropdown"><?php echo(isset($args[1])&&$args[1]!=''?ucfirst($args[1]):'All');?> <i class="caret"></i></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo URL.$settings['system']['admin'].'/content';?>">All</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/article">Article</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/portfolio">Portfolio</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/events">Event</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/news">News</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/testimonials">Testimonial</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/inventory">Inventory</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/service">Service</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/gallery">Gallery</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/proofs">Proof</a></li>
          </ul>
        </li>
      </ol>
    </h4>
    <div class="pull-right">
<?php if($user['rank']==1000||$user['options']{0}==1){?>
      <div class="btn-group" data-toggle="tooltip" data-placement="left" title="Add">
        <button class="btn btn-default add dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php svg('libre-gui-add',($config['iconsColor']==1?true:null));?></button>
        <ul class="dropdown-menu pull-right">
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/article">Article</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/portfolio">Portfolio</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/events">Event</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/news">News</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/testimonials">Testimonial</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/inventory">Inventory</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/service">Service</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/gallery">Gallery</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/proofs">Proof</a></li>
        </ul>
      </div>
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/content/settings';?>" data-toggle="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings',($config['iconsColor']==1?true:null));?></a>
      </div>
<?php }?>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#content" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-striped table-hover">
        <thead>
          <tr>
            <th class="hidden-xs"></th>
            <th class="col-xs-5">Title</th>
            <th class="col-xs-1 hidden-xs"></th>
            <th class="col-xs-1 text-center hidden-xs">Comments</th>
            <th class="col-xs-1 text-center hidden-xs" data-toggle="tooltip" title="Reviews/score">Reviews</th>
            <th class="col-xs-1 text-center hidden-xs">Views</th>
            <th class="col-xs-3"></th>
          </tr>
        </thead>
        <tbody id="listtype" class="list" data-t="menu" data-c="ord">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
          <tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='delete')echo' danger';elseif($r['status']!='published')echo' warning';?>">
            <td class="hidden-xs">
<?php 
if($r['thumb']!='')
  echo'<img class="img-responsive img-rounded" style="max-width:32px;" src="'.$r['thumb'].'">';
elseif($r['file']!='')
  echo'<img class="img-responsive img-rounded" style="max-width:32px;" src="'.$r['file'].'">';
elseif($r['fileURL']!='')
  echo'<img class="img-responsive img-rounded" style="max-width:32px;" src="'.$r['fileURL'].'">';
else
  echo'';
  ?>
            </td>
            <td>
              <div class="visible-xs"><small><?php echo ucfirst($r['contentType']);?></small></div>
              <a href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$r['id'];?>"><?php echo($r['thumb']!=''&&file_exists($r['thumb'])?'<img class="table-thumb" src="'.$r['thumb'].'"> ':'');echo$r['title'];?></a>
<?php echo($r['suggestions']==1?'<span data-toggle="tooltip" data-placement="top" title="Editing suggestions.">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</span>':'');?>
<?php if($r['contentType']=='proofs'){
$sp=$db->prepare("SELECT * FROM login WHERE id=:id");
$sp->execute(array(':id'=>$r['uid']));
$sr=$sp->fetch(PDO::FETCH_ASSOC);?>
              <div class="small"><small><small>Belongs to <a href="<?php echo URL.$settings['system']['admin'].'/accounts/edit/'.$sr['id'].'#account-proofs';?>"><?php echo$sr['username'].($sr['name']!=''?':'.$sr['name']:'');?></a></small></small></div>
<?php }?>
            </td>
            <td class="text-center hidden-xs"><?php echo ucfirst($r['contentType']);?></td>
            <td class="text-center hidden-xs">
<?php if($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='proofs'){
  $sc=$db->prepare("SELECT COUNT(id) as cnt FROM comments WHERE rid=:id AND contentType=:contentType");
  $sc->execute(array(':id'=>$r['id'],':contentType'=>$r['contentType']));
  $cnt=$sc->fetch(PDO::FETCH_ASSOC);
  $scc=$db->prepare("SELECT id FROM comments WHERE rid=:id AND contentType=:contentType AND status='unapproved'");
  $scc->execute(array(':id'=>$r['id'],'contentType'=>$r['contentType']));
  $sccc=$scc->rowCount($scc);
  echo'<a class="btn btn-default'.($sccc>0?' btn-success':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#d43"'.($sccc>0?' data-toggle="tooltip" title="'.$sccc.' New Comments"':'').'>'.svg2('libre-gui-comments',($config['iconsColor']==1?true:null)).$cnt['cnt'].'</a>';
}?>
            </td>
            <td class="text-center hidden-xs">
<?php $sr=$db->prepare("SELECT COUNT(id) as num,SUM(cid) as cnt FROM comments WHERE contentType='review' AND rid=:rid");
$sr->execute(array(':rid'=>$r['id']));
$rr=$sr->fetch(PDO::FETCH_ASSOC);
$srr=$db->prepare("SELECT id FROM comments WHERE contentType='review' AND rid=:rid AND status!='approved'");
$srr->execute(array(':rid'=>$r['id']));
$src=$srr->rowCount($srr);
echo($rr['num'] > 0?'<a class="btn btn-default'.($src>0?' btn-success':'').'" href="'.URL.$settings['system']['admin'].'/content/edit/'.$r['id'].'#d60"'.($src>0?' data-toggle="tooltip" title="'.$src.' New Reviews"':'').'>'.$rr['num'] .'/'.$rr['cnt'].'</a>':'');?>
            </td>
            <td class="text-center hidden-xs">
              <button class="btn btn-default trash" onclick="$('#views<?php echo$r['id'];?>').text('0');update('<?php echo$r['id'];?>','content','views','0');"><?php svg('libre-gui-eraser',($config['iconsColor']==1?true:null));?> <span id="views<?php echo$r['id'];?>"><?php echo$r['views'];?></span></button>
            </td>
            <td id="controls_<?php echo$r['id'];?>" class="text-right">
              <a id="pin<?php echo$r['id'];?>" class="btn btn-default<?php echo($r['pin']{0}==1?' btn-success':'');?> hidden-xs" onclick="pinToggle('<?php echo$r['id'];?>','content','pin','0')" data-toggle="tooltip" title="Pin"><?php svg('libre-gui-pin',($config['iconsColor']==1?true:null));?></a>
              <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'];?>/content/edit/<?php echo$r['id'];?>" data-toggle="tooltip" title="Edit"><?php svg('libre-gui-edit',($config['iconsColor']==1?true:null));?></a>
<?php if($user['rank']==1000||$user['options']{0}==1){?>
              <button class="btn btn-default<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-toggle="tooltip" title="Restore"><?php svg('libre-gui-restore',($config['iconsColor']==1?true:null));?></button>
              <button class="btn btn-default trash<?php echo($r['status']=='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-toggle="tooltip" title="Delete"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
              <button class="btn btn-default trash<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="purge('<?php echo$r['id'];?>','content')" data-toggle="tooltip" title="Purge"><?php svg('libre-gui-purge',($config['iconsColor']==1?true:null));?></button>
<?php }?>
            </td>
          </tr>
<?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php }
if($show=='item'){
  $r=$s->fetch(PDO::FETCH_ASSOC);?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">
      <ol class="breadcrumb">
        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/">Content</a></li>
        <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/<?php echo$r['contentType'];?>"><?php echo ucfirst($r['contentType']);?></a></li>
        <li class="active relative">
<?php $so=$db->prepare("SELECT id,contentType,title FROM content WHERE contentType LIKE :contentType AND id NOT LIKE :id ORDER BY title ASC, ti DESC");
  $so->execute(
    array(
      ':id'          => $r['id'],
      ':contentType' => $r['contentType'].'%'
    )
  );?>
          <a class="dropdown-toggle" data-toggle="dropdown"><?php echo$r['title'];echo($so->rowCount()>0?' <i class="caret"></i>':'');?></a>
<?php if($so->rowCount()>0){?>
          <ul class="dropdown-menu">
<?php     while($ro=$so->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.$settings['system']['admin'].'/content/edit/'.$ro['id'].'">'.$ro['title'].'</a></li>';?>
          </ul>
<?php }?>
        </li>
      </ol>
    </h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo($r['contentType']=='proofs'?URL.$settings['system']['admin'].'/accounts/edit/'.$r['uid'].'#account-proofs':URL.$settings['system']['admin'].'/content/type/'.$r['contentType']);?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
<?php if($user['rank']==1000||$user['options']{0}==1){?>
      <div class="btn-group" data-toggle="tooltip" data-placement="left" title="Add">
        <button class="btn btn-default add dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php svg('libre-gui-add',($config['iconsColor']==1?true:null));?></button>
        <ul class="dropdown-menu pull-right">
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/article">Article</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/portfolio">Portfolio</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/events">Event</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/news">News</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/testimonials">Testimonial</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/inventory">Inventory</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/service">Service</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/gallery">Gallery</a></li>
          <li><a href="<?php echo URL.$settings['system']['admin'];?>/add/proofs">Proof</a></li>
        </ul>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#content-edit" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
<?php }?>
  <div class="panel-body">
    <div id="notification"></div>
    <ul class="nav nav-tabs" role="tablist">
      <li id="d000" role="presentation" class="active"><a href="#d0" aria-controls="d0" role="tab" data-toggle="tab">Content</a></li>
      <li id="d026" class="" role="presentation"><a href="#d26" aria-controls="d26" role="tab" data-toggle="tab">Images</a></li>
      <li role="presentation"><a href="#content-media" aria-controls="content-media" role="tab" data-toggle="tab">Media</a></li>
      <li id="o0pts" class="<?php echo($r['contentType']!='inventory'?'hidden':'');?>" role="presentation"><a href="#opts" aria-controls="opts" role="tab" data-toggle="tab">Options</a></li>
      <li id="d043" class="<?php echo($r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?'hidden':'');?>" role="presentation"><a href="#d43" aria-controls="d43" role="tab" data-toggle="tab">Comments</a></li>
      <li id="d060" class="<?php echo($r['contentType']=='testimonials'||$r['contentType']=='event'||$r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='news'||$r['contentType']=='portfolio'||$r['contentType']=='proof'?'hidden':'');?>" role="presentation"><a href="#d60" aria-controls="d60" role="tab" data-toggle="tab">Reviews</a></li>
      <li id="d044" role="presentation"><a href="#d44" aria-controls="d44" role="tab" data-toggle="tab">SEO</a></li>
      <li id="d050" role="presentation"><a href="#d50" aria-controls="d50" role="tab" data-toggle="tab">Settings</a></li>
    </ul>
    <div class="tab-content">
      <div id="d0" role="tabpanel" class="tab-pane active">
        <div id="d1" class="form-group clearfix">
          <label for="title" class="control-label col-xs-5 col-sm-3 col-lg-2">Title</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="title">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(
    array(
      ':rid' => $r['id'],
      ':t'   => 'content',
      ':c'   => 'title'
    )
  );
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="title">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title" data-bs="btn-danger" placeholder="Content MUST contain a title or it won't be accessible...">
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="title">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
          <small class="help-block text-right">Content MUST contain a Title, or it won't be accessible.</small>
        </div>
        <div id="d2" class="form-group">
          <label for="ti" class="control-label col-xs-5 col-sm-3 col-lg-2">Created</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
          </div>
        </div>
        <div id="d3" class="form-group<?php echo($r['contentType']=='proofs'?' hidden':'');?>">
          <label for="pti" class="control-label col-xs-5 col-sm-3 col-lg-2">Published On</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10 clearfix">
            <input type="text" id="pti" class="form-control" data-dbid="<?php echo$r['id'];?>" data-datetime="<?php echo($r['pti']>0?date($config['dateFormat'],$r['pti']):'');?>">
          </div>
        </div>
        <div id="d4" class="form-group">
          <label for="eti" class="control-label col-xs-5 col-sm-3 col-lg-2">Edited</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <input type="text" id="eti" class="form-control" value="<?php echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?>" readonly>
          </div>
        </div>
        <div id="d5" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service' || $r['contentType']=='gallery'?' hidden':'');?>">
          <label for="cid" class="control-label col-xs-5 col-sm-3 col-lg-2">Client</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="cid">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <select id="cid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','cid',$(this).val());$('#tstavinfo').toggleClass('hidden');"<?php echo($user['options']{1}==0?' disabled':'');?> data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid">
              <option value="0">Select Client</option>
<?php $cs=$db->query("SELECT * FROM login ORDER BY name ASC, username ASC");
while($cr=$cs->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$cr['id'].'"'.($r['cid']==$cr['id']?' selected':'').'>'.$cr['username'].':'.$cr['name'].'</option>';?>
            </select>
          </div>
        </div>
        <div id="d6" class="form-group<?php echo($r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'?' hidden':'');?>">
          <label for="author" class="control-label col-xs-5 col-sm-3 col-lg-2">Author</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="uid">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <select id="uid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','uid',$(this).val());"<?php echo($user['options']{1}==0?' disabled':'');?> data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="uid">
<?php $su=$db->query("SELECT id,username,name FROM login WHERE username!='' AND status!='delete' ORDER BY username ASC, name ASC");
while($ru=$su->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$ru['id'].'"'.($ru['id']==$r['uid']?' selected':'').'>'.$ru['username'].':'.$ru['name'].'</option>';?>
            </select>
          </div>
        </div>
        <div id="d7" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'');?>">
          <label for="code" class="control-label col-xs-5 col-sm-3 col-lg-2">Code</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="code">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="code" class="form-control textinput" value="<?php echo$r['code'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="code" placeholder="Enter a Code..."<?php echo($user['options']{1}==0?' readonly':'');?>>
          </div>
        </div>
        <div id="d8" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'');?>">
          <label for="barcode" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Barcode</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="barcode">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="barcode" class="form-control textinput" value="<?php echo$r['barcode'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="barcode" placeholder="Enter a Barcode..."<?php echo($user['options']{1}==0?' readonly':'');?>>
          </div>
        </div>
        <div id="d9" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'');?> clearfix">
          <label for="fccid" class="control-label col-xs-5 col-sm-3 col-lg-2">FCCID</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="fccid">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="fccid" class="form-control textinput" value="<?php echo$r['fccid'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fccid" placeholder="Enter an FCC ID..."<?php echo($user['options']{1}==0?' readonly':'');?>>
          </div>
          <small class="help-block text-right"><a target="_blank" href="https://fccid.io/">fccid.io</a> for more information or to look up an FCC ID.</small>
        </div>
        <div id="d10" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'');?>">
          <label for="brand" class="control-label col-xs-5 col-sm-3 col-lg-2">Brand</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="brand">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="brand" list="brand_options" class="form-control textinput" value="<?php echo$r['brand'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="brand" placeholder="Enter a Brand..."<?php echo($user['options']{1}==0?' readonly':'');?>>
            <datalist id="brand_options">
<?php $s=$db->query("SELECT DISTINCT brand FROM content WHERE brand!='' ORDER BY brand ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['brand'].'"/>';?>
            </datalist>
          </div>
        </div>
        <div id="d11" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'');?>">
          <label for="tis" class="control-label col-xs-5 col-sm-3 col-lg-2">Event Start</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="tis">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="tis" class="form-control" data-dbid="<?php echo$r['id'];?>" data-datetime="<?php echo date($config['dateFormat'],$r['tis']);?>"<?php echo($user['options']{1}==0?' readonly':'');?>>
          </div>
        </div>
        <div id="d12" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'');?>">
          <label for="tie" class="control-label col-xs-5 col-sm-3 col-lg-2">Event End</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="tie">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="tie" class="form-control" data-dbid="<?php echo$r['id'];?>" data-datetime="<?php echo date($config['dateFormat'], $r['tie']);?>"<?php echo($user['options']{1}==0?' readonly':'');?>>
          </div>
        </div>
        <div id="d13" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'');?> clearfix">
          <label for="email" class="control-label col-xs-5 col-sm-3 col-lg-2">Email</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="email">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="Enter an Email..."<?php echo($user['options']{1}==0?' readonly':'');?>>
          </div>
<?php echo($r['ip']!=''?'<div class="help-block text-right">'.$r['ip'].'</div>':'');?>
        </div>
        <div id="d14" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'');?>">
          <label for="name" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="name">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="name" list="name_options" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="Enter a Name..."<?php echo($user['options']{1}==0?' readonly':'');?>>
            <datalist id="name_options">
<?php $s=$db->query("SELECT DISTINCT name FROM content UNION SELECT DISTINCT name FROM login ORDER BY name ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
            </datalist>
          </div>
        </div>
        <div id="d15" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'');?>">
          <label for="url" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs">
<button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="url">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button>
</div>':'');?>
            <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="url" placeholder="Enter a URL..."<?php echo($user['options']{1}==0?' readonly':'');?>>
          </div>
        </div>
        <div id="d16" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'');?>">
          <label for="business" class="control-label col-xs-5 col-sm-3 col-lg-2">Business</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs">
<button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="business">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button>
</div>':'');?>
            <input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="Enter a Business..."<?php echo($user['options']{1}==0?' readonly':'');?>>
          </div>
        </div>
        <div id="d17" class="form-group<?php echo($r['contentType']=='testimonials'?' hidden':'');?>">
          <label for="category_1" class="control-label col-xs-5 col-sm-3 col-lg-2">Category Primary</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="category_1">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input id="category_1" list="category_1_options" type="text" class="form-control textinput" value="<?php echo$r['category_1'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_1" placeholder="Enter a Category/Select from List..."<?php echo($user['options']{1}==0?' readonly':'');?>>
            <datalist id="category_1_options">
<?php $s=$db->query("SELECT DISTINCT category_1 FROM content WHERE category_1!='' ORDER BY category_1 ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_1'].'"/>';?>
            </datalist>
          </div>
        </div>
        <div id="d18" class="form-group<?php echo($r['contentType']=='testimonials'?' hidden':'');?>">
          <label for="category_2" class="control-label col-xs-5 col-sm-3 col-lg-2">Category Secondary</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="category_2">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input id="category_2" list="category_2_options" type="text" class="form-control textinput" value="<?php echo$r['category_2'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_2" placeholder="Enter a Category/Select from List..."<?php echo($user['options']{1}==0?' readonly':'');?>>
            <datalist id="category_2_options">
<?php $s=$db->query("SELECT DISTINCT category_2 FROM content WHERE category_2!='' ORDER BY category_2 ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_2'].'"/>';?>
            </datalist>
          </div>
        </div>
        <div id="d19" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'');?>">
          <label for="cost" class="control-label col-xs-5 col-sm-3 col-lg-2">Cost</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="cost">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <div class="input-group-addon">$</div>
            <input type="text" id="cost" class="form-control textinput" value="<?php echo$r['cost'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cost" placeholder="Enter a Cost..."<?php echo($user['options']{1}==0?' readonly':'');?>>
          </div>
        </div>
        <div id="d20" class="form-group clearfix<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'');?>">
          <label for="options0" class="control-label check col-xs-5 col-sm-3 col-lg-2">Show Cost</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="options0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0"<?php echo($r['options']{0}==1?' checked':'').($user['options']{1}==0?' readonly':'');?>>
              <label for="options0"/>
            </div>
          </div>
        </div>
        <div id="d21" class="form-group<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'');?>">
          <label for="quantity" class="control-label col-xs-5 col-sm-3 col-lg-2">Quantity</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="quantity">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="quantity" class="form-control textinput" value="<?php echo $r['quantity'];?>" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="quantity" placeholder="Enter a Quantity..."<?php echo($user['options']{1}==0?' readonly':'');?>>
          </div>
        </div>
        <div id="d23" class="form-group">
          <div class="input-group col-xs-12" style="background-color:#f5f5f5;border-top:1px solid #a9a9a9">
            <div class="input-group-btn">
<?php echo($user['rank']>899?'<button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="notesda">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button>':'');
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(
    array(
      ':rid' => $r['id'],
      ':t'   => 'content',
      ':c'   => 'notes'
    )
  );
  echo($ss->rowCount()>0?'<span data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="notesda">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></span>':'');
}
echo($user['rank']>899?'<span class="pull-right" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion pull-right hidden-xs" data-toggle="popover" data-dbgid="notesda">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></span>':'');?>
            </div>
          </div>
          <div id="accessibility"></div>
          <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes"></div>
          <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
            <input type="hidden" name="t" value="content">
            <input type="hidden" name="c" value="notes">
            <textarea id="notes" class="form-control summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
          </form>
        </div>
        <fieldset id="d24" class="control-fieldset<?php echo($r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'');?>">
          <legend class="control-legend">Content Attribution</legend>
          <div id="d25" class="form-group">
            <label for="attributionContentName" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="attributionContentName">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
              <input type="text" id="attributionContentName" list="attributionContentName_option" class="form-control textinput" value="<?php echo$r['attributionContentName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionContentName" placeholder="Enter a Name...">
              <datalist id="attributionContentName_option">
<?php $s=$db->query("SELECT DISTINCT attributionContentName AS name FROM content UNION SELECT DISTINCT name FROM content UNION SELECT DISTINCT name FROM login ORDER BY name ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
              </datalist>
            </div>
          </div>
          <div id="d25" class="form-group">
            <label for="attributionContentURL" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="attributionContentURL">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
              <input type="text" id="attributionContentURL" list="attributionContentURL_option" class="form-control textinput" value="<?php echo$r['attributionContentURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionContentURL" placeholder="Enter a URL...">
              <datalist id="attributionContentURL_option">
<?php $s=$db->query("SELECT DISTINCT attributionContentUrl as url FROM content ORDER BY attributionContentURL ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
              </datalist>
            </div>
          </div>
        </fieldset>
      </div>
      <div id="d26" role="tabpanel" class="tab-pane">
        <div id="error"></div>
        <fieldset id="d26t" class="control-fieldset<?php echo($r['contentType']!='testimonials'?' hidden':'');?>">
          <div class="form-group">
            <div id="tstavinfo" class="alert alert-info<?php echo($r['cid']==0?' hidden':'');?>">Currently using the Avatar associated with the chosen Client Account.</div>
            <label for="avatar" class="control-label col-xs-5 col-sm-3 col-lg-2">Avatar</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="av">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
              <input type="text" id="av" class="form-control" value="<?php echo$r['file'];?>" readonly data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="avatar">
              <div class="input-group-btn">
                <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="act" value="add_tstavatar">
                  <div class="btn btn-default btn-file">
                    <?php svg('libre-gui-browse-computer');?>
                    <input type="file" name="fu">
                  </div>
                  <button class="btn btn-default" type="submit"><?php svg('libre-gui-upload',($config['iconsColor']==1?true:null));?></button>
                </form>
              </div>
              <div class="input-group-addon img">
                <img id="tstavatar" src="<?php echo($r['file']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['file']))?'media' . DS .'avatar'.DS.basename($r['file']):NOAVATAR);?>">
              </div>
              <div class="input-group-btn">
                <button class="btn btn-default trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','file','');"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
              </div>
            </div>
          </div>
        </fieldset>
        <fieldset id="d26nt" class="control-fieldset<?php echo($r['contentType']=='testimonials'?' hidden':'');?>">
          <div id="d27" class="form-group">
            <label for="file" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="fileURL">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
              <input type="text" id="fileURL" class="form-control textinput" value="<?php echo$r['fileURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fileURL" placeholder="Enter a URL...">
              <div class="input-group-btn">
                <button class="btn btn-default trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','fileURL');"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
              </div>
            </div>
          </div>
          <div id="d28" class="form-group clearfix">
            <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="file">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
              <input id="file" type="text" class="form-control" value="<?php echo$r['file'];?>" readonly>
              <div class="input-group-btn">
                <button class="btn btn-default" onclick="elfinderDialog('<?php echo$r['id'];?>','content','file');"><?php svg('libre-gui-browse-media');?></button>
              </div>
              <div class="input-group-btn">
                <form target="sp" method="post" action="core/magicimage.php">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="act" value="file">
                  <button class="btn btn-default"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
                </form>
              </div>
              <div class="input-group-addon img">
<?php echo($r['file']!=''?'<a href="'.$r['file'].'" data-featherlight="image"><img id="thumbimage" src="'.$r['file'].'"></a>':'<img id="thumbimage" src="'.NOIMAGE.'">');?>
              </div>
              <div class="input-group-btn">
                <button class="btn btn-default trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','file');"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
              </div>
            </div>
            <small class="help-block pull-right">Using the <span class="btn btn-default btn-xs"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></span> button will resize the uploaded image. (<?php echo$config['mediaMaxWidth'].'x'.$config['mediaMaxHeight'];?>)</small>
          </div>
          <div id="d29" class="form-group clearfix">
            <label for="thumb" class="control-label col-xs-5 col-sm-3 col-lg-2">Thumbnail</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="thumb">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
              <input id="thumb" type="text" class="form-control" value="<?php echo$r['thumb'];?>" readonly>
              <div class="input-group-btn">
                <button class="btn btn-default" onclick="elfinderDialog('<?php echo$r['id'];?>','content','thumb');"><?php svg('libre-gui-browse-media');?></button>
              </div>
              <div class="input-group-btn">
                <form target="sp" method="post" action="core/magicimage.php">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="act" value="thumb">
                  <button class="btn btn-default"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
                </form>
              </div>
              <div class="input-group-addon img">
<?php echo($r['thumb']!=''?'<a href="'.$r['thumb'].'" data-featherlight="image"><img id="thumbimage" src="'.$r['thumb'].'"></a>':'<img id="thumbimage" src="'.NOIMAGE.'">');?>
              </div>
              <div class="input-group-btn">
                <button class="btn btn-default trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','thumb');"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
              </div>
            </div>
            <small class="help-block pull-right">Using the <span class="btn btn-default btn-xs"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></span> button will create a Thumbnail from the Center of the above uploaded image. (<?php echo$config['mediaMaxWidthThumb'].'x'.$config['mediaMaxHeightThumb'];?>). Uploaded Images take Precedence over URL's.</small>
          </div>
          <fieldset id="d30" class="control-fieldset">
            <legend class="control-legend">Exif Information</legend>
            <div class="clearfix">
              <small class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right text-right">
                Using the <span class="btn btn-default btn-xs"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></span> will attempt to get the EXIF Information embedded in the Uploaded Image.
              </small>
            </div>
            <div id="d31" class="form-group">
              <label for="exifFilename" class="control-label col-xs-5 col-sm-3 col-lg-2">Original Filename</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="exifFilename">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <div class="input-group-btn">
                  <button class="btn btn-default" onclick="getExif('<?php echo$r['id'];?>','content','exifFilename');"><?php svg('libre-gui-magic');?></button>
                </div>
                <input type="text" id="exifFilename" class="form-control textinput" value="<?php echo$r['exifFilename'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFilename" placeholder="Original Filename...">
              </div>
            </div>
            <div id="d32" class="form-group">
              <label for="exifCamera" class="control-label col-xs-5 col-sm-3 col-lg-2">Camera</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="exifCamera">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <div class="input-group-btn">
                  <button class="btn btn-default" onclick="getExif('<?php echo$r['id'];?>','content','exifCamera');"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
                </div>
                <input type="text" id="exifCamera" class="form-control textinput" value="<?php echo$r['exifCamera'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifCamera" placeholder="Enter Camera Brand...">
              </div>
            </div>
            <div id="d33" class="form-group">
              <label for="exifLens" class="control-label col-xs-5 col-sm-3 col-lg-2">Lens</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="exifLens">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <div class="input-group-btn">
                  <button class="btn btn-default" onclick="getExif('<?php echo$r['id'];?>','content','exifLens');"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
                </div>
                <input type="text" id="exifLens" class="form-control textinput" value="<?php echo$r['exifLens'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifLens" placeholder="Enter Lens...">
              </div>
            </div>
            <div id="d34" class="form-group">
              <label for="exifAperture" class="control-label col-xs-5 col-sm-3 col-lg-2">Aperture</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="exifAperture">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <div class="input-group-btn">
                  <button class="btn btn-default" onclick="getExif('<?php echo$r['id'];?>','content','exifAperture');"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
                </div>
                <input type="text" id="exifAperture" class="form-control textinput" value="<?php echo$r['exifAperture'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifAperture" placeholder="Enter Aperture/FStop...">
              </div>
            </div>
            <div id="d35" class="form-group">
              <label for="exifFocalLength" class="control-label col-xs-5 col-sm-3 col-lg-2">Focal Length</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="exifFocalLength">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <div class="input-group-btn">
                  <button class="btn btn-default" onclick="getExif('<?php echo$r['id'];?>','content','exifFocalLength');"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
                </div>
                <input type="text" id="exifFocalLength" class="form-control textinput" value="<?php echo$r['exifFocalLength'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFocalLength" placeholder="Enter Focal Length...">
              </div>
            </div>
            <div id="d36" class="form-group">
              <label for="exifShutterSpeed" class="control-label col-xs-5 col-sm-3 col-lg-2">Shutter Speed</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="exifShutterSpeed">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <div class="input-group-btn">
                  <button class="btn btn-default" onclick="getExif('<?php echo$r['id'];?>','content','exifShutterSpeed');"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
                </div>
                <input type="text" id="exifShutterSpeed" class="form-control textinput" value="<?php echo$r['exifShutterSpeed'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifShutterSpeed" placeholder="Enter Shutter Speed...">
              </div>
            </div>
            <div id="d37" class="form-group">
              <label for="exifISO" class="control-label col-xs-5 col-sm-3 col-lg-2">ISO</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="exifISO">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <div class="input-group-btn">
                  <button class="btn btn-default" onclick="getExif('<?php echo$r['id'];?>','content','exifISO');"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
                </div>
                <input type="text" id="exifISO" class="form-control textinput" value="<?php echo$r['exifISO'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifISO" placeholder="Enter ISO...">
              </div>
            </div>
            <div id="d38" class="form-group">
              <label for="exifti" class="control-label col-xs-5 col-sm-3 col-lg-2">Taken</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <div class="input-group-btn">
                  <button class="btn btn-default" onclick="getExif('<?php echo$r['id'];?>','content','exifti');"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
                </div>
                <input type="text" id="exifti" class="form-control textinput" value="<?php echo($r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'');?>" placeholder="Select the Date/Time Image was Taken..." data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifti">
              </div>
            </div>
          </fieldset>
          <fieldset id="d39" class="control-fieldset">
            <legend class="control-legend">Image Attribution</legend>
            <div id="d40" class="form-group">
              <label for="attributionImageTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">Title</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="attributionImageTitle">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <input type="text" id="attributionImageTitle" list="attributionImageTitle_option" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageTitle" placeholder="Enter a Title...">
                <datalist id="attributionImageTitle_option">
<?php $s=$db->query("SELECT DISTINCT attributionImageTitle FROM content ORDER BY attributionImageTitle ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['attributionImageTitle'].'"/>';?>
                </datalist>
              </div>
            </div>
            <div id="d41" class="form-group">
              <label for="attributionImageName" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="attributionImageName">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <input type="text" id="attributionImageName" list="attributionImageName_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageName" placeholder="Enter a Name...">
                <datalist id="attributionImageName_option">
<?php $s=$db->query("SELECT DISTINCT attributionImageName AS name FROM content UNION SELECT DISTINCT name AS name FROM content UNION SELECT DISTINCT name AS name FROM login ORDER BY name ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
                </datalist>
              </div>
            </div>
            <div id="d42" class="form-group">
              <label for="attributionImageURL" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="attributionImageURL">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
                <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageURL" placeholder="Enter a URL...">
                <datalist id="attributionImageURL_option">
<?php $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM content ORDER BY attributionImageURL ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
                </datalist>
              </div>
            </div>
          </fieldset>
        </fieldset>
      </div>
      <div role="tabpanel" class="tab-pane" id="content-media">
        <small class="help-block text-right">Media uploaded can be used for Image Gallery's, Featured Content, or depending on how they are used in the Theme's Template.</small>
        <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
          <input type="hidden" name="act" value="add_media">
          <input type="hidden" name="id" value="<?php echo$r['id'];?>">
          <input type="hidden" name="t" value="content">
          <div class="form-group">
            <div class="input-group">
              <input id="mediafile" type="text" class="form-control" name="fu" value="" placeholder="Enter a URL, or Select Images using the Browse Media Button...">
              <div class="input-group-btn">
                <button class="btn btn-default" onclick="elfinderDialog('<?php echo$r['id'];?>','media','mediafile');return false;"><?php svg('libre-gui-browse-media',($config['iconsColor']==1?true:null));?></button>
              </div>
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default add" onclick=""><?php svg('libre-gui-plus',($config['iconsColor']==1?true:null));?></button>
              </div>
            </div>
          </div>
        </form>
        <ul id="media_items">
<?php $sm=$db->prepare("SELECT * FROM media WHERE file!='' AND pid=0 AND rid=:id ORDER BY ord ASC");
$sm->execute(array(':id'=>$r['id']));
while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
  list($width,$height)=getimagesize($rm['file']);?>
          <li id="media_items_<?php echo$rm['id'];?>" class="col-xs-6 col-sm-3">
            <div class="panel panel-default media">
              <div class="controls btn-group">
                <span class="handle btn btn-default btn-xs"><?php svg('libre-gui-drag');?></span>
                <button class="btn btn-default btn-xs media-edit" data-dbid="<?php echo$rm['id'];?>"><?php svg('libre-gui-edit');?></button>
                <button class="btn btn-default trash btn-xs" onclick="purge('<?php echo$rm['id'];?>','media')"><?php svg('libre-gui-trash');?></button>
              </div>
              <div class="panel-body">
                <a href="<?php echo$rm['file'];?>"
                  data-srcset="<?php echo$rm['file'];?> <?php echo$width;?>w"
                  data-fancybox="gallery"
                  data-width="<?php echo$width;?>"
                  data-height="<?php echo$height;?>"
                  data-caption="<?php echo$rm['title'].($rm['seoCaption']!=''?' - '.$rm['seoCaption']:'');?>"
                >
                  <img src="<?php echo$rm['file'];?>" alt="">
                </a></div>
              <div id="media-title<?php echo$rm['id'];?>" class="panel-footer"><?php echo$rm['title'];?></div>
            </div>
          </li>
<?php }?>
        </ul>
      </div>
      <div id="opts" role="tabpanel" class="tab-pane<?php echo($r['contentType']!='inventory'?' hidden':'');?>">
        <fieldset class="control-fieldset">
          <div class="form-group">
            <form target="sp" method="post" action="core/add_data.php">
              <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
              <input type="hidden" name="act" value="add_option">
              <div class="input-group col-xs-12">
                <span class="input-group-addon">Option</span>
                <input type="text" class="form-control" name="ttl" value="" placeholder="Enter an Option Title...">
                <span class="input-group-addon">Quantity</span>
                <input type="text" class="form-control" name="qty" value="" placeholder="Quantity">
                <div class="input-group-btn">
                  <button class="btn btn-default add"><?php svg('libre-gui-plus',($config['iconsColor']==1?true:null));?></button>
                </div>
              </div>
            </form>
          </div>
          <div id="itemoptions">
<?php $ss=$db->prepare("SELECT * FROM choices WHERE rid=:rid ORDER BY title ASC");
$ss->execute(array(':rid'=>$r['id']));
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo $rs['id'];?>" class="form-group">
              <div class="input-group col-xs-12">
                <span class="input-group-addon">Option</span>
                <input type="text" class="form-control" value="<?php echo$rs['title'];?>" onchange="update('<?php echo$rs['id'];?>','choices,'title',$(this).val());" placeholder="Enter an Option Title...">
                <span class="input-group-addon">Quantity</span>
                <input type="text" class="form-control" value="<?php echo$rs['ti'];?>" onchange="update('<?php echo$rs['id'];?>','choices,'ti',$(this).val());" placeholder="Quantity...">
                <div class="input-group-btn">
                  <form target="sp" action="core/purge.php">
                    <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                    <input type="hidden" name="t" value="choices">
                    <button class="btn btn-default trash"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
                  </form>
                </div>
              </div>
            </div>
<?php }?>
          </div>
        </fieldset>
      </div>
      <div id="d43" role="tabpanel" class="tab-pane<?php echo($r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'');?>">
        <div class="form-group clearfix">
          <label for="options1" class="control-label check col-xs-5 col-sm-3 col-lg-2">Enable Comments</label>
          <div class="input-group col-xs-7 col-md-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="options1" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="1"<?php echo($r['options']{1}==1?' checked':'');?>>
              <label for="options1"/>
            </div>
          </div>
        </div>
        <div id="comments" class="clearfix">
<?php $sc=$db->prepare("SELECT * FROM comments WHERE contentType=:contentType AND rid=:rid ORDER BY ti ASC");
$sc->execute(
  array(
    ':contentType' => $r['contentType'],
    ':rid'         => $r['id']
  )
);
while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rc['id'];?>" class="media<?php echo($rc['status']=='unapproved'?' danger':'');?>">
            <div class="media-left img-rounded col-xs-1" style="margin:10px 15px;">
<?php $su=$db->prepare("SELECT * FROM login WHERE id=:id");
$su->execute(array(':id'=>$rc['uid']));
$ru=$su->fetch(PDO::FETCH_ASSOC);?>
              <img class="media-object img-responsive" src="<?php if($ru['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$ru['avatar']))echo'media'.DS.'avatar'.DS.$ru['avatar'];elseif($ru['gravatar']!='')echo md5($ru['gravatar']);else echo NOAVATAR;?>">
            </div>
            <div class="media-body">
              <div class="well">
                <div id="controls-<?php echo$rc['id'];?>" class="btn-group btn-comments">
                  <button id="approve_<?php echo$rc['id'];?>" class="btn btn-default btn-sm add<?php echo($rc['status']!='unapproved'?' hidden':'');?>" onclick="update('<?php echo$rc['id'];?>','comments','status','approved')" data-toggle="tooltip" title="Approve"><?php svg('libre-gui-approve',($config['iconsColor']==1?true:null));?></button>
                  <button class="btn btn-default btn-sm trash" onclick="purge('<?php echo$rc['id'];?>','comments')" data-toggle="tooltip" title="Delete"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
                </div>
                <h6 class="media-heading">Name: <?php echo$rc['name'];?></h6>
                <time><small class="text-muted"><?php echo date($config['dateFormat'],$rc['ti']);?></small></time><br>
                <?php echo strip_tags($rc['notes']);?>
              </div>
            </div>
          </div>
<?php }?>
        </div>
        <iframe name="comments" id="comments" class="hidden"></iframe>
        <div class="form-group" style="margin-top:20px;">
          <form role="form" target="comments" method="post" action="core/add_data.php">
            <input type="hidden" name="act" value="add_comment">
            <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
            <input type="hidden" name="contentType" value="<?php echo$r['contentType'];?>">
            <label for="email" class="control-label col-xs-4 col-md-3 col-lg-2">Email</label>
            <div class="input-group col-xs-8 col-md-9 col-lg-10">
              <input type="text" class="form-control" name="email" value="<?php echo$user['email'];?>">
            </div>
            <label for="name" class="control-label col-xs-4 col-md-3 col-lg-2">Name</label>
            <div class="input-group col-xs-8 col-md-9 col-lg-10">
              <input type="text" class="form-control" name="name" value="<?php echo$user['name'];?>"></div>
              <label for="da" class="control-label col-xs-4 col-md-3 col-lg-2">Comment</label>
              <div class="input-group col-xs-8 col-md-9 col-lg-10">
                <textarea id="da" class="form-control" name="da" placeholder="Enter a Comment..." required></textarea>
              </div>
              <div class="col-xs-4 col-md-3 col-lg-2"></div>
              <div class="input-group col-xs-8 col-md-9 col-lg-10">
                <button class="btn btn-default btn-block">Add Comment</button>
              </div>
            </form>
          </div>
        </div>
        <div id="d60" role="tabpanel" class="tab-pane<?php echo($r['contentType']=='testimonials'||$r['contentType']=='event'||$r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='news'||$r['contentType']=='portfolio'||$r['contentType']=='proof'?' hidden':'');?>">
<?php $sr=$db->prepare("SELECT * FROM comments WHERE contentType='review' AND rid=:rid ORDER BY ti DESC");
$sr->execute(array(':rid'=>$r['id']));
while($rr=$sr->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rr['id'];?>" class="media<?php echo($rr['status']=='unapproved'?' danger':'');?>">
          <div class="media-body well">
            <span class="rat">
              <span<?php echo($rr['cid']==5?' class="set"':'');?>>☆</span>
              <span<?php echo($rr['cid']==4?' class="set"':'');?>>☆</span>
              <span<?php echo($rr['cid']==3?' class="set"':'');?>>☆</span>
              <span<?php echo($rr['cid']==2?' class="set"':'');?>>☆</span>
              <span<?php echo($rr['cid']==1?' class="set"':'');?>>☆</span>
            </span>
            <div id="controls-<?php echo$rr['id'];?>" class="btn-group pull-right">
              <button id="approve_<?php echo$rr['id'];?>" class="btn btn-default btn-sm<?php echo($rr['status']=='approved'?' hidden':'');?>" onclick="update('<?php echo$rr['id'];?>','comments','status','approved')" data-toggle="tooltip" title="Approve"><?php svg('libre-gui-approve',($config['iconsColor']==1?true:null));?></button>
              <button class="btn btn-default btn-sm trash" onclick="purge('<?php echo$rr['id'];?>','comments')" data-toggle="tooltip" title="Delete"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
            </div>
            <h6 class="media-heading"><?php echo$rr['name'].', '.date($config['dateFormat'],$rr['ti']);?></h6>
            <p><?php echo$rr['notes'];?></p>
          </div>
        </div>
<?php }?>
      </div>
      <div id="d44" role="tabpanel" class="tab-pane">
        <div class="form-group">
          <label for="analytics" class="control-label col-xs-5 col-sm-3 col-lg-2">Analytics</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="input-group-btn">
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="content" data-u="<?php echo URL.$r['contentType'].'/'.strtolower(str_replace(' ','-',$r['title']));?>" data-analytics="social"><?php svg('libre-seo-social',($config['iconsColor']==1?true:null));?> Social</button>
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="content" data-u="<?php echo URL.$r['contentType'].'/'.strtolower(str_replace(' ','-',$r['title']));?>" data-analytics="google"><?php svg('libre-seo-google',($config['iconsColor']==1?true:null));?> Google</button>
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="content" data-u="<?php echo URL.$r['contentType'].'/'.strtolower(str_replace(' ','-',$r['title']));?>" data-analytics="alexa"><?php svg('libre-seo-alexa',($config['iconsColor']==1?true:null));?> Alexa</button>
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="content" data-u="<?php echo URL.$r['contentType'].'/'.strtolower(str_replace(' ','-',$r['title']));?>" data-analytics="moz"><?php svg('libre-seo-moz',($config['iconsColor']==1?true:null));?> Moz</button>
            </div>
          </div>
        </div>
        <script>
          $('.analytics').popover({
            html: true,
            trigger: 'click',
            title: 'Analytics <button type="button" id="close" class="close" data-dismiss="popover">&times;</button>',
            container: 'body',
            placement: 'auto',
            template: '<div class="popover analytics role="tooltip"><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
            content: function () {
              var id = $(this).data("id"),
                  t  = $(this).data("t"),
                  u  = $(this).data("u"),
                  a  = $(this).data("analytics");
              return $.ajax({
                url:      'core/layout/seostats-content.php',
                dataType: 'html',
                async:    false,
                data: {
                  id: id,
                  t:  t,
                  u:  u,
                  a:  a
                }
              }).responseText;
            }
          });
        </script>
        <div id="d45" class="form-group">
          <label for="views" class="control-label col-xs-5 col-sm-3 col-lg-2">Views</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="views">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="views"<?php echo($user['options']{1}==0?' readonly':'');?>>
            <div class="input-group-btn">
              <button class="btn btn-default trash" onclick="$('#views').val('0');update('<?php echo$r['id'];?>','content','views','0');"><?php svg('libre-gui-eraser',($config['iconsColor']==1?true:null));?></button>
            </div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="metaRobots" class="control-label col-xs-5 col-sm-3 col-lg-2">Meta Robots</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="metaRobots">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(array(':rid'=>$r['id'],':t'=>'content',':c'=>'metaRobots'));
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="metaRobots">'.svg2('libre-gui-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="metaRobots" placeholder="Enter a Robots Option as Below...">
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="metaRobots">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
          <small class="help-block text-right">Options for Meta Robots:
            <span data-toggle="tooltip" title="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-toggle="tooltip" title="Disallow search engines from showing this page in their results.">noindex</span>, <span data-toggle="tooltip" title="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-toggle="tooltip" title="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-toggle="tooltip" title="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-toggle="tooltip" title="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-toggle="tooltip" title="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-toggle="tooltip" title="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-toggle="tooltip" title="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-toggle="tooltip" title="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-toggle="tooltip" title="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span>
          </small>
        </div>
        <div id="d46" class="form-group<?php echo($r['contentType']=='proofs'?' hidden':'');?>">
          <label for="schemaType" class="control-label col-xs-5 col-sm-3 col-lg-2">Schema Type</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="schemaType">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <select id="schemaType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','schemaType',$(this).val());"<?php echo($user['options']{1}==0?' disabled':'');?> data-toggle="tooltip" title="Schema for Microdata Content." data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="schemaType">
              <option value="blogPosting"<?php echo($r['schemaType']=='blogPosting'?' selected':'');?>>blogPosting for Articles</option>
              <option value="Product"<?php echo($r['schemaType']=='Product'?' selected':'');?>>Product for Inventory</option>
              <option value="Service"<?php echo($r['schemaType']=='Service'?' selected':'');?>>Service for Services</option>
              <option value="ImageGallery"<?php echo($r['schemaType']=='ImageGallery'?' selected':'');?>>ImageGallery for Gallery Images</option>
              <option value="Review"<?php echo($r['schemaType']=='Review'?' selected':'');?>>Review for Testimonials</option>
              <option value="NewsArticle"<?php echo($r['schemaType']=='NewsArticle'?' selected':'');?>>NewsArticle for News</option>
              <option value="Event"<?php echo($r['schemaType']=='Event'?' selected':'');?>>Event for Events</option>
              <option value="CreativeWork"<?php echo($r['schemaType']=='CreativeWork'?' selected':'');?>>CreativeWork for Portfolio/Proofs</option>
            </select>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Title</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoTitle">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
$cntc=70-strlen($r['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else
  $cnt=number_format($cntc);?>
            <div class="input-group-addon">
              <span id="seoTitlecnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></span>
            </div>
            <div class="input-group-btn">
              <button class="btn btn-default" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-toggle="tooltip" title="Remove Stop Words."><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
            </div>
<?php if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(array(':rid'=>$r['id'],':t'=>'content',':c'=>'seoTitle'));
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoTitle">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoTitle">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
          <small class="help-block pull-right">The recommended character count for Title's is 70.</small>
        </div>
        <div id="d49" class="form-group clearfix">
          <label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-lg-2">Caption</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
$cntc=160-strlen($r['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else
  $cnt=number_format($cntc);?>
            <div class="input-group-addon">
              <span id="seoCaptioncnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo $cnt;?></span>
            </div>
<?php if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(array(':rid'=>$r['id'],':t'=>'content',':c'=>'seoCaption'));
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoCaption" placeholder="Enter a Caption..."<?php echo($user['options']{1}==0?' readonly':'');?>>
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
          <small class="help-block pull-right">The recommended character count for Captions is 160, as sometime Captions may be used in Descriptions.</small>
        </div>
        <div id="d49a" class="form-group clearfix">
          <label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-lg-2">Description</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
$cntc=160-strlen($r['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else
  $cnt=number_format($cntc);?>
            <div class="input-group-addon">
              <span id="seoDescriptioncnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></span>
            </div>
<?php if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(array(':rid'=>$r['id'],':t'=>'content',':c'=>'seoDescription'));
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoDescription" placeholder="Enter a Description..."<?php echo($user['options']{1}==0?' readonly':'');?>>
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
          <small class="help-block pull-right">The recommended character count for Descriptions is 160.</small>
        </div>
        <div id="d47" class="form-group<?php echo($r['contentType']=='proofs'?' hidden':'');?>">
          <label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-lg-2">Keywords</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(array(':rid'=>$r['id'],':t'=>'content',':c'=>'seoKeywords'));
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoKeywords" placeholder="Enter Keywords..."<?php echo($user['options']{1}==0?' readonly':'');?>>
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
        </div>
        <div id="d48" class="form-group">
          <label for="tags" class="control-label col-xs-5 col-sm-3 col-lg-2">Tags</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="tags">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(array(':rid'=>$r['id'],':t'=>'content',':c'=>'tags'));
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="tags">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="tags" class="form-control textinput" value="<?php echo$r['tags'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tags" placeholder="Enter Tags..."<?php echo($user['options']{1}==0?' readonly':'');?>>
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="tags">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
        </div>
      </div>
      <div id="d50" role="tabpanel" class="tab-pane">
        <div id="d51" class="form-group">
          <label for="published" class="control-label col-xs-5 col-sm-3 col-lg-2">Status</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="status">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php echo($user['options']{1}==0?' readonly':'');?> data-toggle="tooltip" title="" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="status">
              <option value="unpublished"<?php echo($r['status']=='unpublished'?' selected':'');?>>Unpublished</option>
              <option value="published"<?php echo($r['status']=='published'?' selected':'');?>>Published</option>
              <option value="delete"<?php echo($r['status']=='delete'?' selected':'');?>>Delete</option>
            </select>
          </div>
        </div>
        <div id="d52" class="form-group">
          <label for="contentType" class="control-label col-xs-5 col-sm-3 col-lg-2">Content Type</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="contentType">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <select id="contentType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','contentType',$(this).val());"<?php echo($user['options']{1}==0?' disabled':'');?> data-toggle="tooltip" title="Change the Type of Content this Item belongs to." data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="contentType">
              <option value="article"<?php echo($r['contentType']=='article'?' selected':'');?>>Article</option>
              <option value="portfolio"<?php echo($r['contentType']=='portfolio'?' selected':'');?>>Portfolio</option>
              <option value="events"<?php echo($r['contentType']=='events'?' selected':'');?>>Event</option>
              <option value="news"<?php echo($r['contentType']=='news'?' selected':'');?>>News</option>
              <option value="testimonials"<?php echo($r['contentType']=='testimonials'?' selected':'');?>>Testimonial</option>
              <option value="inventory"<?php echo($r['contentType']=='inventory'?' selected':'');?>>Inventory</option>
              <option value="service"<?php echo($r['contentType']=='service'?' selected':'');?>>Service</option>
              <option value="gallery"<?php echo($r['contentType']=='gallery'?' selected':'');?>>Gallery</option>
              <option value="proofs"<?php echo($r['contentType']=='proofs'?' selected':'');?>>Proof</option>
            </select>
          </div>
        </div>
        <div id="d22" class="form-group clearfix<?php echo($r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='proofs'?' hidden':'');?>">
          <label for="featured0" class="control-label check col-xs-5 col-sm-3 col-lg-2">Featured</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="featured0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0"<?php echo($r['featured']{0}==1?' checked':'').($user['options']{1}==0?' readonly':'');?>>
              <label for="featured0"/>
            </div>
          </div>
        </div>
        <div id="d53" class="form-group clearfix<?php echo($r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'?' hidden':'');?>">
          <label for="internal0" class="control-label check col-xs-5 col-sm-3 col-lg-2">Internal</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="internal0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0"<?php echo($r['internal']==1?' checked':'');?><?php echo($user['options']{1}==0?' readonly':'');?>>
              <label for="internal0"/>
            </div>
          </div>
        </div>
        <div id="d54" class="form-group clearfix<?php echo($r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='gallery'||$r['contentType'] == 'proofs'?' hidden':'');?>">
          <label for="bookable0" class="control-label check col-xs-5 col-sm-3 col-lg-2">Bookable</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="bookable0" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="bookable" data-dbb="0"<?php echo($r['bookable']==1?' checked':'');?><?php echo($user['options']{1}==0?' readonly':'');?>>
              <label for="bookable0"/>
            </div>
          </div>
        </div>
<?php /*
        <div class="form-group">
          <label for="mid" class="control-label col-xs-5 col-sm-3 col-lg-2">SubMenu</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <select id="mid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','mid',$(this).val());" data-dbid-"<?php echo$r['id'];?>" data-dbt="menu" data-dbc="mid">
              <option value="0"<?php if($r['mid']==0)echo' selected';?>>None</option>
  <?php $sm=$db->prepare("SELECT id,title from menu WHERE mid=0 AND mid!=:mid AND active=1 ORDER BY ord ASC, title ASC");
  $sm->execute(array(':mid'=>$r['id']));
  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
    echo'<option value="'.$rm['id'].'"';if($r['mid']==$rm['id'])echo' selected';echo'>'.$rm['title'].'</option>';
  }?>
            </select>
          </div>
        </div> */ ?>
      </div>
    </div>
  </div>
</div>
<?php }
}
