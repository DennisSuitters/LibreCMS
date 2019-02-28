<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Preferences Page
 *
 * preferences.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Preferences
 * @package    core/layout/preferences.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if($args[0]==''){?>
  <main id="content" class="main">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">Preferences</li>
      <li class="breadcrumb-menu">
        <div class="btn-group" role="group" aria-label="Settings">
<?php if($help['dashboard_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['dashboard_text'].'" data-tooltip="tooltip" data-placement="left" title="Read Text Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['dashboard_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['dashboard_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
        </div>
      </li>
    </ol>
    <div class="container-fluid">
      <noscript><div class="alert alert-danger">Javascript MUST BE ENABLED for LibreCMS to function correctly!</div></noscript>
      <div class="alert alert-warning d-sm-block d-md-none">The Administration works better on larger displays, such as Laptop or Desktop screen sizes. On smaller screens some Elements may be truncated or cut off, making usage difficult.</div>
      <div class="row">
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/theme';?>">
          <span class="card">
            <span class="card-header h3">Theme</span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-theme','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/contact';?>">
          <span class="card">
            <span class="card-header h3">Contact</span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-address-card','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/social';?>">
          <span class="card">
            <span class="card-header h3">Social</span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-user-group','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/interface';?>">
          <span class="card">
            <span class="card-header h3">Interface</span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-sliders','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/seo';?>">
          <span class="card">
            <span class="card-header h3">SEO</span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-plugin-seo','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>">
          <span class="card">
            <span class="card-header h3">Activity</span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-activity','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker';?>">
          <span class="card">
            <span class="card-header h3">Tracker</span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-tracker','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/security';?>">
          <span class="card">
            <span class="card-header h3">Security</span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-security','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/database';?>">
          <span class="card">
            <span class="card-header h3">Database</span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-database','libre-5x');?></span>
          </span>
        </a>
      </div>
    </div>
  </main>
<?php }else
  include'core'.DS.'layout'.DS.'pref_'.$args[0].'.php';
