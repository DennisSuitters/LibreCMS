<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Newsletters
 *
 * newsletters.php version 2.0.2
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
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Move Settings to Header
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
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
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php echo localize('Content');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Newsletters');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/newsletters/add';?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Add');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-add');?></a>
        <?php if($help['newsletters_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['newsletters_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['newsletters_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['newsletters_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="nav-item"><a class="nav-link active" href="#tab-newsletters-newsletters" aria-controls="tab-newsletters-newsletters" role="tab" data-toggle="tab"><?php echo localize('Newsletters');?></a></li>
          <li role="presentation" class="nat-item"><a class="nav-link" href="#tab-newsletters-subscribers" aria-controls="tab-newsletters-subscribers" role="tab" data-toggle="tab"><?php echo localize('Subscribers');?></a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-newsletters-newsletters" role="tabpanel">
            <div id="notification"></div>
            <div class="table-responsive">
              <table class="table table-condensed table-striped table-hover" role="table">
                <thead>
                  <tr role="row">
                    <th class="col-xs-5" role="columnheader"><?php echo localize('Subject');?></th>
                    <th class="col-xs-2 text-center" role="columnheader"><?php echo localize('Created');?></th>
                    <th class="col-xs-2 text-center" role="columnheader"><?php echo localize('Published');?></th>
                    <th class="col-xs-3" role="columnheader"></th>
                  </tr>
                </thead>
                <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="l_<?php echo$r['id'];?>" class="item" role="row">
                    <td role="cell"><a href="<?php echo$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>"><?php echo$r['title'];?></a></td>
                    <td class="text-center" role="cell"><?php echo date($config['dateFormat'],$ti);?></td>
                    <td class="text-center" role="cell"><?php echo$r['status']=='unpublished'?'Unpublished':date($config['dateFormat'],$r['tis']);?></td>
                    <td id="controls_<?php echo$r['id'];?>" role="cell">
                      <div class="btn-group float-right" role="group">
                        <button class="btn btn-secondary" onclick="Pace.restart();$('#sp').load('core/newsletter.php?id=<?php echo$r['id'];?>&act=');" data-tooltip="tooltip" title="<?php echo localize('Send Newsletters');?>" role="button" aria-label="<?php echo localize('aria_send');?>"><?php svg('libre-gui-email-send');?></button>
                        <a class="btn btn-secondary" href="<?php echo$settings['system']['admin'].'/newsletters/edit/'.$r['id'];?>" data-tooltip="tooltip" title="<?php echo localize('Edit');?>" role="button" aria-label="<?php echo localize('aria_edit');?>"><?php svg('libre-gui-edit');?></a>
<?php   if($r['rank']!=1000){?>
                        <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-tooltip="tooltip" title="<?php echo localize('Restore');?>" role="button" aria-label="<?php echo localize('aria_restore');?>"><?php svg('libre-gui-untrash');?></button>
                        <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                        <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo$r['id'];?>','content')" data-tooltip="tooltip" title="<?php echo localize('Purge');?>" role="button" aria-label="<?php echo localize('aria_purge');?>"><?php svg('libre-gui-purge');?></button>
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
              <table class="table table-condensed table-striped table-hover" role="table">
                <thead>
                  <tr role="row">
                    <th class="col-xs-9" role="columnheader"><?php echo localize('Email');?></th>
                    <th class="col-xs-3 text-right" role="columnheader"><?php echo localize('Subscribed');?></th>
                  </tr>
                </thead>
                <tbody>
<?php $s=$db->prepare("SELECT id,email,newsletter FROM `".$prefix."login` WHERE newsletter=1 ORDER BY email ASC, username ASC, name ASC");
  $s->execute();
  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr role="row">
                    <td role="cell"><?php echo$r['email'];?></td>
                    <td class="text-right" role="cell">
                      <div class="checkbox checkbox-success">
                        <label class="switch switch-label switch-success"><input type="checkbox" id="newsletter<?php echo$r['id'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0" role="checkbox"<?php echo$r['newsletter']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
                      </div>
                    </td>
                  </tr>
<?php }?>
                </tbody>
              </table>
              <table class="table table-condensed table-striped table-hover" role="table">
                <thead>
                  <tr role="row">
                    <th class="col-xs-6" role="columnheader"><?php echo localize('Email');?></th>
                    <th class="col-xs-3" role="columnheader"><?php echo localize('Date Signed Up');?></th>
                    <th class="col-xs-3" role="columnheader"></th>
                  </tr>
                </thead>
                <tbody>
<?php $s=$db->prepare("SELECT id,email,ti FROM `".$prefix."subscribers` ORDER BY email ASC");
  $s->execute();
  while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="s_<?php echo$r['id'];?>" class="item" role="row">
                    <td role="cell"><?php echo$r['email'];?></td>
                    <td role="cell"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                    <td class="text-right" role="cell">
<?php if($user['rank']>899){?>
                      <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','subscribers')" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
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
