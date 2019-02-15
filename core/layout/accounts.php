<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if($args[0]=='add'){
  $type=filter_input(INPUT_GET,'type',FILTER_SANITIZE_STRING);
  $q=$db->prepare("INSERT INTO `".$prefix."login` (options,active,ti) VALUES ('00000000','1',:ti)")->execute(array(':ti'=>time()));
  $args[1]=$db->lastInsertId();
  $q=$db->prepare("UPDATE `".$prefix."login` SET username=:username WHERE id=:id");
  $q->execute(
    array(
      ':username'=>'User '.$args[1],
      ':id'=>$args[1]
    )
  );
  $args[0]='edit';
  echo'<script>/*<![CDATA[*/history.replaceState("","","'.URL.$settings['system']['admin'].'/accounts/edit/'.$args[1].'");/*]]>*/</script>';
}
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_accounts.php';
elseif($args[0]=='edit')
  include'core'.DS.'layout'.DS.'edit_accounts.php';
else{
  if($args[0]=='type'){
    if(isset($args[1])){
      $rank=0;
      if($args[1]=='subscriber')$rank=100;
      if($args[1]=='member')$rank=200;
      if($args[1]=='client')$rank=300;
      if($args[1]=='contributor')$rank=400;
      if($args[1]=='author')$rank=500;
      if($args[1]=='editor')$rank=600;
      if($args[1]=='moderator')$rank=700;
      if($args[1]=='manager')$rank=800;
      if($args[1]=='administrator')$rank=900;
      if($args[1]=='developer')$rank=1000;
    }
    $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE rank=:rank ORDER BY ti DESC");
    $s->execute(
      array(
        ':rank'=>$rank
      )
    );
  }else{
    $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE rank<:rank ORDER BY ti DESC");
    $s->execute(
      array(
        ':rank'=>$_SESSION['rank']+1
      )
    );
  }?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Accounts</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/accounts/add';?>" data-tooltip="tooltip" data-placement="left" title="Add"><?php svg('libre-gui-add');?></a>
        <a class="btn btn-ghost-normal info" href="<?php echo URL.$settings['system']['admin'].'/accounts/settings';?>" data-tooltip="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings');?></a>
        <?php if($help['accounts_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['accounts_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';if($help['accounts_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['accounts_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-striped table-hover">
            <thead>
              <tr>
                <th></th>
                <th class="">Username/Name</th>
                <th class="text-center">Last Login</th>
                <th class="text-center">Rank</th>
                <th class="text-center">Status</th>
                <th class=""></th>
              </tr>
            </thead>
            <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>">
                <td class="align-middle">
<?php if($r['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['avatar'])))
        echo'<img class="img-fluid img-circle" style="max-width:32px;max-height:32px;" src="media'.DS.'avatar'.DS.basename($r['avatar']).'">';
      elseif($r['avatar']!='')
        echo'<img class="img-fluid img-circle" style="max-width:32px;max-height:32px;" src="'.$r['avatar'].'">';
      elseif($r['gravatar']!='')
        echo'<img class="img-fluid img-circle" style="max-width:32px;max-height:32px;" src="'.$r['gravatar'].'">';
      else
        echo'<img class="img-fluid img-circle" style="max-width:32px;max-height:32px;" src="'.NOAVATAR.'">';?>
                </td>
                <td class="align-middle">
                  <small><a href="<?php echo$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" data-tooltip="tooltip" title="Edit"><?php echo$r['username'].':'.$r['name'];?></a></small>
                  <?php echo$user['rank']==1000?'<br><small class="text-muted d-none d-sm-block">IP: '.$r['userIP'].'<br>'.$r['userAgent'].'</small>':'';?>
                </td>
                <td class="text-center align-middle"><span<?php echo$r['lti']!=0&&$user['rank']==1000?' data-tooltip="tooltip" title="'.date($config['dateFormat'],$r['lti']).'""':'';?>><?php echo _ago($r['lti']);?></span></td>
                <td class="text-center align-middle"><?php echo rank($r['rank']);?></td>
                <td class="text-center align-middle"><?php echo$r['status'];?></td>
                <td id="controls_<?php echo$r['id'];?>" class="align-middle">
                  <div class="btn-group pull-right">
                    <a class="btn btn-secondary" href="<?php echo$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>" data-tooltip="tooltip" title="Edit"><?php svg('libre-gui-edit');?></a>
<?php if($r['rank']!=1000){?>
                    <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','login','status','unpublished')" data-tooltip="tooltip" title="Restore"><?php svg('libre-gui-untrash');?></button>
                    <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','login','status','delete')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                    <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo$r['id'];?>','login')" data-tooltip="tooltip" title="Purge"><?php svg('libre-gui-purge');?></button>
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
  </div>
</main>
<?php }
