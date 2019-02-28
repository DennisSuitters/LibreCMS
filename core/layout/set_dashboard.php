<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Dashboard Settings
 *
 * set_dashboard.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Settings - Dasboard
 * @package    core/layout/set_dashboard.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal info" href="<?php echo URL.$settings['system']['admin'].'/dashboard';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
<?php if($help['dashboard_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['dashboard_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="Read Text Help">'.svg2('libre-gui-help').'</a>';
if($help['dashboard_settings_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['dashboard_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div id="ui-view">
      
    </div>
  </div>
</main>

