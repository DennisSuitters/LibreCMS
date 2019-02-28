<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Rewards
 *
 * rewards.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Rewards
 * @package    core/layout/rewards.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item active" aria-current="page">Rewards</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
<?php if($help['rewards_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['rewards_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['rewards_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['rewards_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
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
                  <td><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="Add"><?php svg('libre-gui-plus');?></button></td>
                </tr>
              </thead>
            </form>
            <tbody id="rewards">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY ti ASC, code ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>">
                <td class="col-xs-1 text-center"><small><?php echo$r['code'];?></small></td>
                <td class="col-xs-4 text-center"><small><?php echo$r['title'];?></small></td>
                <td class="col-xs-1 text-center"><small><?php echo$r['method']==0?'% Off':'$ Off';?></small></td>
                <td class="col-xs-1 text-center"><small><?php echo $r['value'];?></small></td>
                <td class="col-xs-1 text-center"><small><?php echo $r['quantity'];?></small></td>
                <td class="col-xs-2 text-center"><small><?php echo$r['tis']!=0?date($config['dateFormat'],$r['tis']):'';?></small></td>
                <td class="col-xs-2 text-center"><small><?php echo$r['tie']!=0?date($config['dateFormat'],$r['tie']):'';?></small></td>
                <td class="">
                  <form target="sp" action="core/purge.php">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="t" value="rewards">
                    <button class="btn btn-secondary trash" data-tooltop="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                  </form>
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
