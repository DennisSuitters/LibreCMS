<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Newsletters
 *
 * newsletters.php version 2.0.1
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Newsletters
 * @package    core/layout/newsletters.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.1
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Move Settings to Header
 */
if($args[0]=='add'){
  $q=$db->prepare("INSERT INTO `".$prefix."content` (contentType,status,ti) VALUES ('newsletters','unpublished',:ti)");
  $q->execute([':ti'=>$ti]);
  $args[1]=$db->lastInsertId();
  $args[0]='edit';
  echo'<script>history.replaceState("","","'.URL.$settings['system']['admin'].'/newsletters/edit/'.$args[1].'");</script>';
}
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_newsletters.php';
elseif($args[0]=='edit')
  include'core'.DS.'layout'.DS.'edit_newsletters.php';
else{
  $s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType=:contentType ORDER BY ti DESC, title ASC");
  $s->execute([':contentType'=>'newsletters']);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item active" aria-current="page">Newsletters</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/newsletters/add';?>" data-tooltip="tooltip" data-placement="left" title="Add"><?php svg('libre-gui-add');?></a>
<?php if($help['newsletters_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['newsletters_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
  if($help['newsletters_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['newsletters_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="nav-item"><a class="nav-link active" href="#tab-newsletters-newsletters" aria-controls="tab-newsletters-newsletters" role="tab" data-toggle="tab">Newsletters</a></li>
          <li role="presentation" class="nat-item"><a class="nav-link" href="#tab-newsletters-subscribers" aria-controls="tab-newsletters-subscribers" role="tab" data-toggle="tab">Subscribers</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-newsletters-newsletters" role="tabpanel">
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
                    <td><a href="<?php echo$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>"><?php echo$r['title'];?></a></td>
                    <td class="text-center"><?php echo date($config['dateFormat'],$ti);?></td>
                    <td class="text-center"><?php echo$r['status']=='unpublished'?'Unpublished':date($config['dateFormat'],$r['tis']);?></td>
                    <td id="controls_<?php echo$r['id'];?>">
                      <div class="btn-group float-right">
                        <button class="btn btn-secondary" onclick="Pace.restart();$('#sp').load('core/newsletter.php?id=<?php echo$r['id'];?>&act=');" data-tooltip="tooltip" title="Send Newsletters"><?php svg('libre-gui-email-send');?></button>
                        <a class="btn btn-secondary" href="<?php echo$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>" data-tooltip="tooltip" title="Edit"><?php svg('libre-gui-edit');?></a>
<?php   if($r['rank']!=1000){?>
                        <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-tooltip="tooltip" title="Restore"><?php svg('libre-gui-untrash');?></button>
                        <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                        <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo$r['id'];?>','content')" data-tooltip="tooltip" title="Purge"><?php svg('libre-gui-purge');?></button>
<?php   }?>
                      </div>
                    </td>
                  </tr>
<?php }?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane" id="tab-newsletters-subscribers" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-condensed table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-xs-9">Email</th>
                    <th class="col-xs-3 text-right">Subscribed</th>
                  </tr>
                </thead>
                <tbody>
<?php $s=$db->prepare("SELECT id,email,newsletter FROM `".$prefix."login` WHERE newsletter=1 ORDER BY email ASC, username ASC, name ASC");
  $s->execute();
  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr>
                    <td><?php echo$r['email'];?></td>
                    <td class="text-right">
                      <div class="checkbox checkbox-success">
                        <label class="switch switch-label switch-success"><input type="checkbox" id="newsletter<?php echo$r['id'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0"<?php echo$r['newsletter']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
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
<?php $s=$db->prepare("SELECT id,email,ti FROM `".$prefix."subscribers` ORDER BY email ASC");
  $s->execute();
  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="s_<?php echo$r['id'];?>" class="item">
                    <td><?php echo$r['email'];?></td>
                    <td><?php echo date($config['dateFormat'],$r['ti']);?></td>
                    <td class="text-right">
<?php if($user['rank']>899){?>
                      <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','subscribers')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
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
<?php }?>
    </div>
  </div>
</main>
