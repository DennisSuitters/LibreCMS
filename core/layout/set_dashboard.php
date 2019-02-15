<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal info" href="<?php echo URL.$settings['system']['admin'].'/dashboard';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
<?php if($help['dashboard_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['dashboard_settings_text'].'" data-toggle="tooltip" data-placement="left" title="Read Text Help">'.svg2('libre-gui-help').'</a>';
if($help['dashboard_settings_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['dashboard_settings_video'].'" data-toggle="tooltip" data-placement="left" title="Watch Video Help">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div id="ui-view">
      
    </div>
  </div>
</main>

