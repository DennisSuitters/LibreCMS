<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Tracker Preferences
 *
 * pref-tracker.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Preferences - Tracker
 * @package    core/layout/pref_tracker.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tracker</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
<?php if($help['tracker_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['tracker_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['tracker_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['tracker_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card col-sm-12">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-condensed table-striped table-hover">
            <thead>
              <tr>
                <th class="" data-tooltip="tooltip" title="Clicking on Links will show the History of that Page in Date Order.">Page</th>
                <th class="" data-tooltip="tooltip" title="Clicking on Origin Links will open that URL in a new window.">Origin</th>
                <th class="text-center" data-tooltip="tooltip" title="Clicking on IP Links will Do a WhoIs on that IP in a new window.">IP</th>
                <th class="text-center">Browser</th>
                <th class="text-center">OS</th>
                <th class="text-center">Date</th>
                <th><div class="btn-group float-right"><button class="btn btn-secondary btn-sm trash" onclick="purge('0','tracker');return false;" data-tooltip="tooltip" data-placement="left" title="Purge All"><?php svg('libre-gui-purge');?></button></th>
              </tr>
            </thead>
            <tbody id="l_tracker">
<?php  $s=$db->prepare("SELECT * FROM `".$prefix."tracker` ORDER BY ti DESC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>" class="small align-middle">
                <td class="text-nooverflow align-middle"><small><a href="<?php echo URL.$settings['system']['admin'].'/tracker?action=view&sid='.$r['sid'];?>"><?php echo$r['urlDest'];?></a></small></td>
                <td class="text-nooverflow align-middle"><small><?php if($r['urlFrom']!='')echo'<a target="_blank" href="'.$r['urlFrom'].'">'.$r['urlFrom'].'</a>';?></small></td>
                <td class="text-center align-middle"><small><a target="_blank" href="http://www.ipaddress-finder.com/?ip=<?php echo$r['ip'];?>"><?php echo$r['ip'];?></a></small></td>
                <td class="text-center align-middle"><small><?php echo ucfirst($r['browser']);?></small></td>
                <td class="text-center align-middle"><small><?php echo ucfirst($r['os']);?></small></td>
                <td class="text-center align-middle"><small><?php echo date($config['dateFormat'],$r['ti']);?></small></td>
                <td class="align-middle">
                  <div class="btn-group float-right">
                    <button class="btn btn-secondary pathviewer" data-toggle="popover" data-dbid="<?php echo$r['id'];?>"><?php svg('libre-seo-path');?></button>
<?php if($config['php_options']{0}==1){?>
                    <button class="btn btn-secondary phpviewer" data-toggle="popover" data-dbid="<?php echo$r['id'];?>" data-dbt="tracker"><?php svg('libre-brand-projecthoneypot');?></button>
<?php }?>
                    <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','tracker')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                  </div>
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
