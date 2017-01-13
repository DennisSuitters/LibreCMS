<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Rewards</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#messages-settings"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-striped table-hover">
        <thead>
          <tr>
            <th class="col-xs-1 text-center">Code</th>
            <th class="col-xs-5 text-center">Title</th>
            <th class="text-center">Method</th>
            <th class="col-xs-1 text-center">Value</th>
            <th class="col-xs-1 text-center">Quantity</th>
            <th class="col-xs-1 text-center">Start Date</th>
            <th class="col-xs-1 text-center">End Date</th>
            <th class=""></th>
          </tr>
        </thead>
        <form target="sp" method="post" action="core/add_data.php">
          <input type="hidden" name="act" value="add_reward">
          <thead>
            <tr>
              <td><input type="text" class="form-control" name="code" value="" placeholder="Code..."></td>
              <td><input type="text" class="form-control" name="title" value="" placeholder="Title..."></td>
              <td>
                <select class="form-control" name="method">
                  <option value="0">% Off</option>
                  <option value="1">$ Off</option>
                </select>
              </td>
              <td><input type="text" class="form-control" name="value" value="" placeholder="Value..."></td>
              <td><input type="text" class="form-control" name="quantity" value="" placeholder="Quantity..."></td>
              <td><input type="text" id="tis" class="form-control" name="tis" value=""></td>
              <td><input type="text" id="tie" class="form-control" name="tie" value=""></td>
              <td><button class="btn btn-default add" type="submit"><?php svg('plus');?></button></td>
            </tr>
          </thead>
        </form>
        <tbody id="rewards">
<?php $s=$db->prepare("SELECT * FROM rewards ORDER BY ti ASC, code ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
          <tr id="l_<?php echo$r['id'];?>">
            <td class="col-xs-1 text-center"><?php echo$r['code'];?></td>
            <td class="col-xs-5 text-center"><?php echo$r['title'];?></td>
            <td class="text-center"><?php if($r['method']==0)echo'% Off';else echo'$ Off';?></td>
            <td class="col-xs-1 text-center"><?php echo$r['value'];?></td>
            <td class="col-xs-1 text-center"><?php echo$r['quantity'];?></td>
            <td class="col-xs-1 text-center"><small><?php if($r['tis']!=0)echo date($config['dateFormat'],$r['tis']);?></small></td>
            <td class="col-xs-1 text-center"><small><?php if($r['tie']!=0)echo date($config['dateFormat'],$r['tie']);?></small></td>
            <td class="">
              <form target="sp" action="core/purge.php">
                <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                <input type="hidden" name="t" value="rewards">
                <button class="btn btn-default trash"><?php svg('trash');?></button>
              </form>
            </td>
          </tr>
<?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
