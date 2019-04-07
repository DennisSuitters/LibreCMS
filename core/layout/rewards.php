<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Rewards
 *
 * rewards.php version 2.0.2
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
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php echo localize('Content');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Rewards');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <?php if($help['rewards_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['rewards_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['rewards_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['rewards_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-condensed table-striped table-hover" role="table">
            <form target="sp" method="post" action="core/add_data.php" role="form">
              <input type="hidden" name="act" value="add_reward">
              <thead>
                <tr role="row">
                  <th class="col-xs-1 text-center" role="columnheader"><label for="code"><?php echo localize('Code');?></label></th>
                  <th class="col-xs-4 text-center" role="columnheader"><label for="title"><?php echo localize('Title');?></label></th>
                  <th class="col-xs-1 text-center" role="columnheader"><label for="method"><?php echo localize('Method');?></label></th>
                  <th class="col-xs-1 text-center" role="columnheader"><label for="value"><?php echo localize('Value');?></label></th>
                  <th class="col-xs-1 text-center" role="columnheader"><label for="quantity"><?php echo localize('Quantity');?></label></th>
                  <th class="col-xs-2 text-center" role="columnheader"><label for="tis"><?php echo localize('Start Date');?></label></th>
                  <th class="col-xs-2 text-center" role="columnheader"><label for="tie"><?php echo localize('End Date');?></label></th>
                  <th role="columnheader"></th>
                </tr>
              </thead>
              <thead>
                <tr role="row">
                  <td role="cell"><input type="text" id="code" class="form-control input-sm" name="code" value="" placeholder="<?php echo localize('Code');?>..." role="textbox"></td>
                  <td role="cell"><input type="text" id="title" class="form-control input-sm" name="title" value="" placeholder="<?php echo localize('Title');?>..." role="textbox"></td>
                  <td role="cell">
                    <select id="method" class="form-control input-sm" name="method" role="listbox">
                      <option value="0">% <?php echo localize('Off');?></option>
                      <option value="1">$ <?php echo localize('Off');?></option>
                    </select>
                  </td>
                  <td role="cell"><input type="text" id="value" class="form-control input-sm" name="value" value="" placeholder="<?php echo localize('Value');?>..." role="textbox"></td>
                  <td role="cell"><input type="text" id="quantity" class="form-control input-sm" name="quantity" value="" placeholder="<?php echo localize('Quantity');?>..." role="textbox"></td>
                  <td role="cell"><div class="input-group"><input type="text" id="tis" class="form-control input-sm" data-datetime="<?php echo date($config['dateFormat'],time());?>" name="tis" value="" role="textbox"></div></td>
                  <td role="cell"><div class="input-group"><input type="text" id="tie" class="form-control input-sm" data-datetime="<?php echo date($config['dateFormat'],time());?>" name="tie" value="" role="textbox"></div></td>
                  <td role="cell"><button class="btn btn-secondary add" type="submit" data-tooltip="tooltip" title="<?php echo localize('Add');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button></td>
                </tr>
              </thead>
            </form>
            <tbody id="rewards">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY ti ASC, code ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>" role="row">
                <td class="col-xs-1 text-center small" role="cell"><?php echo$r['code'];?></td>
                <td class="col-xs-4 text-center small" role="cell"><?php echo$r['title'];?></td>
                <td class="col-xs-1 text-center small" role="cell"><?php echo$r['method']==0?'% Off':'$ Off';?></td>
                <td class="col-xs-1 text-center small" role="cell"><?php echo $r['value'];?></td>
                <td class="col-xs-1 text-center small" role="cell"><?php echo $r['quantity'];?></td>
                <td class="col-xs-2 text-center small" role="cell"><?php echo$r['tis']!=0?date($config['dateFormat'],$r['tis']):'';?></td>
                <td class="col-xs-2 text-center small" role="cell"><?php echo$r['tie']!=0?date($config['dateFormat'],$r['tie']):'';?></td>
                <td role="cell">
                  <form target="sp" action="core/purge.php" role="form">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="t" value="rewards">
                    <button class="btn btn-secondary trash" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
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
