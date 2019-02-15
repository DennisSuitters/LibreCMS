<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active" aria-current="page"><strong>Interface</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card col-sm-12">
      <div class="card-body">
<?php if($user['rank']==1000){?>
        <div class="form-group row">
          <label for="development0" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Development Mode Showing Errors.">Development Mode</label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="development0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="development" data-dbb="0"<?php echo$config['development']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
        </div>
<?php if(file_exists('media'.DS.'cache'.DS.'error.log')){?>
        <div id="l_0">
          <div class="form-group row">
            <label for="error_log" class="col-form-label col-sm-2">Error Log</label>
            <div class="input-group col-sm-10">
              <div class="input-group-btn">
                <button class="btn btn-secondary" onclick="$('#logview').toggleClass('hidden');$('#logfile').load('media/cache/error.log?<?php echo time();?>');">View Logs</button>
                <button class="btn btn-secondary trash" onclick="purge('0','errorlog')" data-tooltip="tooltip" title="This will Remove the Error Logs, there is no getting it back."><?php svg('libre-gui-purge');?></button>
              </div>
            </div>
          </div>
          <div id="logview" class="form-group hidden">
            <div class="col-xs-5 col-sm-3 col-lg-2"></div>
            <div class="input-group col-sm-10">
              <div class="well col-xs-12"><small id="logfile" style="white-space:pre"></small></div>
            </div>
          </div>
        </div>
<?php }
}?>
        <div class="form-group row">
          <label for="comingsoon0" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Coming Soon Mode.">Coming Soon Mode</label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="comingsoon0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="comingsoon" data-dbb="0"<?php echo$config['comingsoon']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
        </div>
        <div class="form-group row">
          <label for="maintenance0" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Site Maintenance Mode.">Maintenance Mode</label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="maintenance0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="maintenance" data-dbb="0"<?php echo$config['maintenance']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
        </div>
        <div class="form-group row">
          <label for="options4" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Display Administration Tooltips, like this one.">Enable Tooltips</label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options4" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4"<?php echo$config['options']{4}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
        </div>
        <div class="help-block small text-muted text-right">'0' Disables Idle Audio Notification.</div>
        <div class="form-group row">
          <label for="notification_volume" class="col-form-label col-sm-2">Notification Volume</label>
          <div class="input-group col-sm-10">
            <div id="notification_text" class="input-group-text"><?php echo$config['notification_volume'];?></div>
            <input type="range" id="notification_volume" class="form-control custom-range" min="0" max="100" step="1" value="<?php echo$config['notification_volume'];?>" oninput="$('#notification_text').text($(this).val());" onchange="update('1','config','notification_volume',$(this).val());">
          </div>
        </div>
        <div class="form-group row">
          <label for="uti_freq" class="col-form-label col-sm-2" data-tooltip="tooltip" title="How often to check for available updates.">Update Frequency</label>
          <div class="input-group col-sm-10">
            <select id="uti_freq" class="form-control" onchange="update('1','config','uti_freq',$(this).val());">
              <option value="0"<?php echo$config['uti_freq']==0?' selected':'';?>>Never</option>
              <option value="3600"<?php echo$config['uti_freq']==3600?' selected':'';?>>Hourly</option>
              <option value="84600"<?php echo$config['uti_freq']==84600?' selected':'';?>>Daily</option>
              <option value="604800"<?php echo$config['uti_freq']==604800?' selected':'';?>>Weekly</option>
              <option value="2629743"<?php echo$config['uti_freq']==2629743?' selected':'';?>>Monthly</option>
            </select>
            <div class="input-group-append">
              <button class="btn btn-secondary" onclick="$('#updatecheck').removeClass('hidden').load('core/layout/updatecheck.php');" data-tooltip="tooltip" title="Click to check for available updates.">Check Now</button>
            </div>
          </div>
        </div>
        <div id="updatecheck" class="form-group row hidden">
          <div class="col-form-label col-sm-2"></div>
          <div class="input-group col-sm-10">
            <div class="col alert alert-warning"><?php svg('libre-gui-spinner','animated spin');?> Checking for new updates!</div>
          </div>
        </div>
        <div class="form-group row">
          <label for="update_url" class="col-form-label col-sm-2" data-tooltip="tooltip" title="URL where new updates are checked and downloaded from.">Update URL</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="update_url" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="update_url" class="form-control textinput" value="<?php echo$config['update_url'];?>" data-dbid="1" data-dbt="config" data-dbc="update_url" placeholder="Enter an Update URL..." data-tooltip="tooltip" title="URL to Fetch System Updates From...">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveupdate_url" class="btn btn-secondary save" data-dbid="update_url" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">'0' Disables Idle Timeout.</div>
        <div class="form-group row">
          <label for="idleTime" class="col-form-label col-sm-2" data-tooltip="tooltip" title="How long before auto-logout occurs.">Idle Timeout</label>
          <div class="input-group col-sm-10">
            <input type="text" id="idleTime" class="form-control textinput" value="<?php echo$config['idleTime'];?>" data-dbid="1" data-dbt="config" data-dbc="idleTime" placeholder="Enter a Time in Minutes..." data-tooltip="tooltip" title="Time in Minutes for Idle Timeout for Auto Logout...">
            <div class="input-group-text">Minutes</div>
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="saveidleTime" class="btn btn-secondary save" data-dbid="idleTime" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">For information on Date Format Characters click <a target="_blank" href="http://php.net/manual/en/function.date.php#refsect1-function.date-parameters">here</a>.</div>
        <div class="form-group row">
          <label for="dateFormat" class="col-form-label col-sm-2">Date/Time Format</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="dateFormat" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="dateFormat" class="form-control textinput" value="<?php echo$config['dateFormat'];?>" data-dbid="1" data-dbt="config" data-dbc="dateFormat" placeholder="Enter a Date/Time Format..." data-tooltip="tooltip" title="Format Layout of all Dates/Times displayed.">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Save"><button id="savedateFormat" class="btn btn-secondary save" data-dbid="dateFormat" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
