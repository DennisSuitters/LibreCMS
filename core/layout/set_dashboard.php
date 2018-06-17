<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Dashboard Settings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/dashboard';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#dashboard-settings" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <h4 class="page-header">RSS Feeds</h4>
    <div class="form-group">
      <label for="options10" class="control-label check col-xs-5 col-sm-3 col-lg-2">Enable</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <div class="checkbox checkbox-success">
          <input type="checkbox" id="options10" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="10"<?php echo($config['options']{10}==1?' checked':'');?>>
          <label for="options10"/>
        </div>
      </div>
    </div>
    <div class="form-group">
      <form target="sp" method="post" action="core/add_data.php">
        <input type="hidden" name="act" value="add_dashrss">
        <div class="input-group col-xs-12">
          <div class="input-group-addon">URL</div>
          <input type="text" class="form-control" name="url" value="" placeholder="Enter a URL...">
          <div class="input-group-btn">
            <button class="btn btn-default add" type="submit"><?php svg('libre-gui-plus',($config['iconsColor']==1?true:null));?></button>
          </div>
        </div>
      </form>
    </div>
    <div id="rss">
<?php $ss=$db->prepare("SELECT * FROM choices WHERE contentType='dashrss' ORDER BY url ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
      <div id="l_<?php echo$rs['id'];?>" class="form-group">
        <div class="input-group col-xs-12">
          <div class="input-group-addon">URL</div>
          <input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','choices','url',$(this).val());" placeholder="Enter a URL...">
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
    <h4 class="page-header">LibreCMS Git Commits</h4>
    <div class="form-group">
      <label for="options11" class="control-label check col-xs-5 col-sm-3 col-lg-2">Enable</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <div class="checkbox checkbox-success">
          <input type="checkbox" id="options11" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="11"<?php echo($config['options']{11}==1?' checked':'');?>>
          <label for="options11"/>
        </div>
      </div>
    </div>
  </div>
</div>
