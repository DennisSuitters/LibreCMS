<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Content</li>
    <li class="breadcrumb-item">Newsletters</li>
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
        <?php if($help['newsletters_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['newsletters_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['newsletters_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['newsletters_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label for="newslettersEmbedImages" class="col-form-label col-sm-2">Embed Images</label>
          <div class="input-group col-sm-1">
            <label class="switch switch-label switch-success"><input type="checkbox" id="newslettersEmbedImages" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="newslettersEmbedImages" data-dbb="0"<?php echo$config['newslettersEmbedImages']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
          <div class="input-group col-sm-9">
            <div class="help-block small text-muted p-1">Enable if your hosting doesn't support remote image access.</div>
          </div>
        </div>
        <div class="form-group row">
          <label for="newslettersSendMax" class="col-form-label col-sm-2">Send Max</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="newslettersSendMax">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <div class="input-group-text"><small class="text-muted">Maximum Emails to Send in one Instance. '0' uses the Default of '50'.</small></div>
            <input type="text" id="newslettersSendMax" class="form-control textinput" value="<?php echo$config['newslettersSendMax'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendMax">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savenewslettersSendMax" class="btn btn-secondary save" data-dbid="newslettersSendMax" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="newslettersSendDelay" class="col-form-label col-sm-2">Send Delay</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="newslettersSendDelay">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <div class="input-group-text"><small class="text-muted">Seconds to Delay between Sends. '0' uses the Default of '1' second.</small></div>
            <input type="text" id="newslettersSendDelay" class="form-control textinput" value="<?php echo$config['newslettersSendDelay'];?>" data-dbid="1" data-dbt="config" data-dbc="newslettersSendDelay">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savenewslettersSendDelay" class="btn btn-secondary save" data-dbid="newslettersSendDelay" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <hr/>
        <legend>Opt Out Message Layout</legend>
        <div class="form-group row">
          <label class="col-form-label col-sm-2"></label>
          <div class="input-group card-header col-sm-10 p-0">
          <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary btn-sm fingerprint" data-dbgid="nool">'.svg2('libre-gui-fingerprint').'</button></div><div id="nool" data-dbid="1" data-dbt="config" data-dbc="newslettersOptOutLayout"></div>':'';?>
            <div class="input-group-prepend small text-muted p-2">You can use the following tokens: {optOutLink}</div>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="newslettersOptOutLayout">
              <textarea class="form-control summernote" name="da"><?php echo rawurldecode($config['newslettersOptOutLayout']);?></textarea>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
