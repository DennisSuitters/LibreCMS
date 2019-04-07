<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Preferences Page
 *
 * preferences.php version 2.0.2
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
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
if($args[0]==''){?>
  <main id="content" class="main">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active"><?php echo localize('Preferences');?></li>
      <li class="breadcrumb-menu">
        <div class="btn-group" role="group">
          <?php if($help['dashboard_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['dashboard_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
          if($help['dashboard_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['dashboard_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
        </div>
      </li>
    </ol>
    <div class="container-fluid">
      <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
      <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
      <div class="row">
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/theme';?>" aria-label="Go to Theme Preferences">
          <span class="card">
            <span class="card-header h3"><?php echo localize('Theme');?></span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-theme','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/contact';?>" aria-label="Go to Contact Preferences">
          <span class="card">
            <span class="card-header h3"><?php echo localize('Contact');?></span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-address-card','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/social';?>" aria-label="Go to Social Preferences">
          <span class="card">
            <span class="card-header h3"><?php echo localize('Social');?></span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-user-group','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/interface';?>" aria-label="Go to Interface Preferences">
          <span class="card">
            <span class="card-header h3"><?php echo localize('Interface');?></span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-sliders','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/seo';?>" aria-label="Go to SEO Preferences">
          <span class="card">
            <span class="card-header h3"><?php echo localize('SEO');?></span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-plugin-seo','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/activity';?>" aria-label="Go to Activity">
          <span class="card">
            <span class="card-header h3"><?php echo localize('Activity');?></span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-activity','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/tracker';?>" aria-label="Go to Tracker">
          <span class="card">
            <span class="card-header h3"><?php echo localize('Tracker');?></span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-tracker','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/security';?>" aria-label="Go to Security Preferences">
          <span class="card">
            <span class="card-header h3"><?php echo localize('Security');?></span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-security','libre-5x');?></span>
          </span>
        </a>
        <a class="preferences col-6 col-sm-2 p-0 m-0" href="<?php echo URL.$settings['system']['admin'].'/preferences/database';?>" aria-label="Go to Database Preferences">
          <span class="card">
            <span class="card-header h3"><?php echo localize('Database');?></span>
            <span class="card-body card-text text-center"><?php svg('libre-gui-database','libre-5x');?></span>
          </span>
        </a>
      </div>
    </div>
  </main>
<?php }else
  include'core'.DS.'layout'.DS.'pref_'.$args[0].'.php';
