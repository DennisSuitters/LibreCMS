<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Visitor Tracker</h4>
    <div class="pull-right">
      <div class="btn-group"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Purge All"';?>>
        <button class="btn btn-default trash" onclick="purge('0','tracker')"><?php svg('purge');?></button>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#activity"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-striped table-hover">
        <thead>
          <tr>
            <th class="col-xs-3"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="top" title="Clicking on Links will show the History of that Page in Date Order."';?>>Page</th>
            <th class="col-xs-2"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="top" title="Clicking on Origin Links will open that URL in a new window."';?>>Origin</th>
            <th class="col-xs-1 text-center"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="top" title="Clicking on IP Links will Do a WhoIs on that IP in a new window."';?>>IP</th>
            <th class="col-xs-1 text-center">Browser</th>
            <th class="col-xs-1 text-center">OS</th>
            <th class="col-xs-4 text-center">Date</th>
          </tr>
        </thead>
        <tbody id="l_tracker">
<?php $is=0;$ie=50;if(isset($args[1]))$action=$args[1];else$action='';
include('core'.DS.'layout'.DS.'tracker_items.php');?>
        </tbody>
      </table>
    </div>
  </div>
</div>
