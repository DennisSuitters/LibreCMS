<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Content Settings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/content';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#content-settings"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <label for="showItems" class="control-label col-xs-5 col-sm-3 col-lg-2">Item Count</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
        <input type="text" id="showItems" class="form-control textinput" value="<?php echo$config['showItems'];?>" data-dbid="1" data-dbt="config" data-dbc="showItems" placeholder="Enter Number of Items to Display..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Number of Items to Display."';?>>
      </div>
    </div>
  </div>
</div>
