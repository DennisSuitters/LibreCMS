<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Rewards</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#messages-settings" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-striped table-hover">
        <thead>
          <tr>
            <th class="col-xs-1 text-center">Code</th>
            <th class="col-xs-4 text-center">Title</th>
            <th class="col-xs-1 text-center">Method</th>
            <th class="col-xs-1 text-center">Value</th>
            <th class="col-xs-1 text-center">Quantity</th>
            <th class="col-xs-2 text-center">Start Date</th>
            <th class="col-xs-2 text-center">End Date</th>
            <th class=""></th>
          </tr>
        </thead>
        <form target="sp" method="post" action="core/add_data.php">
          <input type="hidden" name="act" value="add_reward">
          <thead>
            <tr>
              <td><input type="text" class="form-control input-sm" name="code" value="" placeholder="Code..."></td>
              <td><input type="text" class="form-control input-sm" name="title" value="" placeholder="Title..."></td>
              <td>
                <select class="form-control input-sm" name="method">
                  <option value="0">% Off</option>
                  <option value="1">$ Off</option>
                </select>
              </td>
              <td><input type="text" class="form-control input-sm" name="value" value="" placeholder="Value..."></td>
              <td><input type="text" class="form-control input-sm" name="quantity" value="" placeholder="Quantity..."></td>
              <td><div class="input-group"><input type="text" id="tis" class="form-control input-sm" data-datetime="<?php echo date($config['dateFormat'],time());?>" name="tis" value=""></div></td>
              <td><div class="input-group"><input type="text" id="tie" class="form-control input-sm" data-datetime="<?php echo date($config['dateFormat'],time());?>" name="tie" value=""></div></td>
              <td><button class="btn btn-default btn-sm add" type="submit"><?php svg('libre-gui-plus',($config['iconsColor']==1?true:null));?></button></td>
            </tr>
          </thead>
        </form>
        <tbody id="rewards">
<?php $s=$db->prepare("SELECT * FROM rewards ORDER BY ti ASC, code ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
          <tr id="l_<?php echo$r['id'];?>">
            <td class="col-xs-1 text-center"><small><?php echo$r['code'];?></small></td>
            <td class="col-xs-4 text-center"><small><?php echo$r['title'];?></small></td>
            <td class="col-xs-1 text-center"><small><?php echo($r['method']==0?'% Off':'$ Off');?></small></td>
            <td class="col-xs-1 text-center"><small><?php echo $r['value'];?></small></td>
            <td class="col-xs-1 text-center"><small><?php echo $r['quantity'];?></small></td>
            <td class="col-xs-2 text-center"><small><?php echo($r['tis']!=0?date($config['dateFormat'],$r['tis']):'');?></small></td>
            <td class="col-xs-2 text-center"><small><?php echo($r['tie']!=0?date($config['dateFormat'],$r['tie']):'');?></small></td>
            <td class="">
              <form target="sp" action="core/purge.php">
                <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                <input type="hidden" name="t" value="rewards">
                <button class="btn btn-default btn-sm trash"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
              </form>
            </td>
          </tr>
<?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
