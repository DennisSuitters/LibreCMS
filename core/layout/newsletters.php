<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if($args[0]=='add'){
  $q=$db->prepare("INSERT INTO content (contentType,status,ti) VALUES ('newsletters','unpublished',:ti)");
  $q->execute(array(':ti'=>$ti));
  $args[1]=$db->lastInsertId();
  $args[0]='edit';?>
<script>/*<![CDATA[*/
  history.replaceState('','','<?php echo URL.$settings['system']['admin'].'/newsletters/edit/'.$args[1];?>');
/*]]>*/</script>
<?php }
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_newsletters.php';
elseif($args[0]=='edit'){
  $q=$db->prepare("SELECT * FROM content WHERE id=:id");
  $q->execute(array(':id'=>$args[1]));
  $r = $q->fetch(PDO::FETCH_ASSOC);?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Newsletter: <?php echo$r['title'];?></h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <button class="btn btn-default" onclick="Pace.restart();$('#sp').load('core/newsletter.php?id=<?php echo$r['id'];?>&act=');" data-toggle="tooltip" data-placement="left" title="Send Newsletters"><?php svg('libre-gui-email-send',($config['iconsColor']==1?true:null));?></button>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#newsletters-edit" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div id="notification"></div>
    <div class="form-group">
      <label for="title" class="control-label col-xs-5 col-sm-3 col-lg-2">Subject</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="title">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title" placeholder="Enter a Subject...">
      </div>
    </div>
    <div class="form-group">
      <label for="ti" class="control-label col-xs-4 col-sm-3 col-lg-2">Created</label>
      <div class="input-group col-xs-8 col-sm-9 col-lg-10">
        <input type="text" id="ti" class="form-control" value="<?php echo date('M jS, Y g:i A',$r['ti']);?>" readonly>
      </div>
    </div>
    <div class="form-group">
      <label for="notes" class="control-label col-xs-5 col-sm-3 col-lg-2">Notes</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="da">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div><div id="da" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="notes"></div>':'');?>
        <form method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="<?php echo$r['id'];?>">
          <input type="hidden" name="t" value="content">
          <input type="hidden" name="c" value="notes">
          <textarea id="notes" class="form-control summernote" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
        </form>
      </div>
    </div>
  </div>
</div>
<?php }else{
  $s=$db->prepare("SELECT * FROM content WHERE contentType=:contentType ORDER BY ti DESC, title ASC");
  $s->execute(array(':contentType'=>'newsletters'));?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">
      <ol class="breadcrumb">
        <li><a href="<?php echo URL.$settings['system']['admin'];?>/newsletters">Newsletters</a></li>
      </ol>
    </h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default add" href="<?php echo URL.$settings['system']['admin'].'/newsletters/add';?>" data-toggle="tooltip" data-placement="left" title="Add"><?php svg('libre-gui-add',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/newsletters/settings';?>" data-toggle="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#newsletters" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#newsletters" aria-controls="newsletters" role="tab" data-toggle="tab">Newsletters</a></li>
      <li role="presentation"><a href="#subscribers" aria-controls="subscribers" role="tab" data-toggle="tab">Subscribers</a></li>
    </ul>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="newsletters">
        <div id="notification"></div>
        <div class="table-responsive">
          <table class="table table-condensed table-striped table-hover">
            <thead>
              <tr>
                <th class="col-xs-5">Subject</th>
                <th class="col-xs-2 text-center">Created</th>
                <th class="col-xs-2 text-center">Published</th>
                <th class="col-xs-3"></th>
              </tr>
            </thead>
            <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>" class="item">
                <td><a href="<?php echo$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>" data-toggle="tooltip" title="Edit"><?php echo$r['title'];?></a></td>
                <td class="text-center"><?php echo date($config['dateFormat'],$ti);?></td>
                <td class="text-center"><?php echo($r['status']=='unpublished'?'Unpublished':date($config['dateFormat'],$r['tis']));?></td>
                <td id="controls_<?php echo$r['id'];?>" class="text-right">
                  <button class="btn btn-default" onclick="Pace.restart();$('#sp').load('core/newsletter.php?id=<?php echo$r['id'];?>&act=');" data-toggle="tooltip" data-placement="left" title="Send Newsletters"><?php svg('libre-gui-email-send',($config['iconsColor']==1?true:null));?></button>
                  <a class="btn btn-default" href="<?php echo$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>" data-toggle="tooltip" title="Edit"><?php svg('libre-gui-edit',($config['iconsColor']==1?true:null));?></a>
<?php if($r['rank']!=1000){?>
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
      <div role="tabpanel" class="tab-pane" id="subscribers">
        <div role="tabpanel" class="tab-pane active" id="newsletters">
          <div class="table-responsive">
            <table class="table table-condensed table-striped table-hover">
              <thead>
                <tr>
                  <th class="col-xs-9">Email</th>
                  <th class="col-xs-3 text-right">Subscribed</th>
                </tr>
              </thead>
              <tbody>
<?php
$s=$db->prepare("SELECT id,email,newsletter FROM login WHERE newsletter=1 ORDER BY email ASC, username ASC, name ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <tr>
                  <td><?php echo$r['email'];?></td>
                  <td class="text-right">
                    <div class="checkbox checkbox-success">
                      <input type="checkbox" id="newsletter" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0"<?php echo($r['newsletter']{0}==1?' checked':'');?>>
                      <label for="newsletter"/>
                    </div>
                  </td>
                </tr>
<?php }?>
              </tbody>
            </table>
            <table class="table table-condensed table-striped table-hover">
              <thead>
                <tr>
                  <th class="col-xs-6">Email</th>
                  <th class="col-xs-3">Date Signed Up</th>
                  <th class="col-xs-3"></th>
                </tr>
              </thead>
              <tbody>
<?php $s=$db->prepare("SELECT id,email,ti FROM subscribers ORDER BY email ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                <tr id="s_<?php echo$r['id'];?>" class="item">
                  <td><?php echo$r['email'];?></td>
                  <td><?php echo date($config['dateFormat'],$r['ti']);?></td>
                  <td class="text-right">
<?php if($user['rank']>899){?>
                    <button class="btn btn-default trash" onclick="purge('<?php echo$r['id'];?>','subscribers')" data-toggle="tooltip" title="Delete"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
<?php }?>
                  </td>
                </tr>
<?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }?>
</div>
