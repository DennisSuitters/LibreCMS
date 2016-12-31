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
    <div class="table-responsive">
      <table class="table table-condensed table-striped table-hover">
        <thead>
          <tr>
            <th class="col-xs-9 col-sm-2"></th>
            <th class="col-xs-8 hidden-xs"></th>
            <th class="col-xs-3"></th>
          </tr>
        </thead>
        <tbody id="l_activity">
<?php $is=0;$ie=50;if(isset($args[1]))$action=$args[1];else$action='';
include('core'.DS.'layout'.DS.'activity_items.php');?>
        </tbody>
      </table>
    </div>
  </div>
</div>
