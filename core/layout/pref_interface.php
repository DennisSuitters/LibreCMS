<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Interface Preferences
 *
 * pref_interface.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Preferences - Interface
 * @package    core/layout/pref_interface.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Add System Timezone Selection.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php echo localize('Preferences');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Interface');?></li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
<?php if($user['rank']==1000){?>
        <div class="form-group row">
          <label for="development0" class="col-form-label col-sm-2"><?php echo localize('Development Mode');?></label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="development0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="development" data-dbb="0" role="checkbox"<?php echo$config['development']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
          </div>
        </div>
<?php if(file_exists('media'.DS.'cache'.DS.'error.log')){?>
        <div id="l_0">
          <div class="form-group row">
            <label for="error_log" class="col-form-label col-sm-2"><?php echo localize('Error Log');?></label>
            <div class="input-group col-sm-10">
              <div class="input-group-btn">
                <button class="btn btn-secondary" onclick="$('#logview').toggleClass('hidden');$('#logfile').load('media/cache/error.log?<?php echo time();?>');" role="button" aria-label="<?php echo localize('aria_view');?>"><?php echo localize('View Logs');?></button>
                <button class="btn btn-secondary trash" onclick="purge('0','errorlog')" role="button" aria-label="<?php echo localize('aria_purge');?>"><?php svg('libre-gui-purge');?></button>
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
          <label for="comingsoon0" class="col-form-label col-sm-2"><?php echo localize('Coming Soon Mode');?></label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="comingsoon0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="comingsoon" data-dbb="0" role="checkbox"<?php echo$config['comingsoon']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
          </div>
        </div>
        <div class="form-group row">
          <label for="maintenance0" class="col-form-label col-sm-2"><?php echo localize('Maintenance Mode');?></label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="maintenance0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="maintenance" data-dbb="0" role="checkbox"<?php echo$config['maintenance']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
          </div>
        </div>
        <div class="form-group row">
          <label for="options4" class="col-form-label col-sm-2"><?php echo localize('Enable Tooltips');?></label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options4" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4" role="checkbox"<?php echo$config['options']{4}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
          </div>
        </div>
        <div class="help-block small text-right"><?php echo localize('help_notificationvolume');?></div>
        <div class="form-group row">
          <label for="notification_volume" class="col-form-label col-sm-2"><?php echo localize('Notification Volume');?></label>
          <div class="input-group col-sm-10">
            <div id="notification_text" class="input-group-text"><?php echo$config['notification_volume'];?></div>
            <input type="range" id="notification_volume" class="form-control custom-range" min="0" max="100" step="1" value="<?php echo$config['notification_volume'];?>" oninput="$('#notification_text').text($(this).val());" onchange="update('1','config','notification_volume',$(this).val());" role="textbox">
          </div>
        </div>
        <div class="form-group row">
          <label for="uti_freq" class="col-form-label col-sm-2"><?php echo localize('Update Frequency');?></label>
          <div class="input-group col-sm-10">
            <select id="uti_freq" class="form-control" onchange="update('1','config','uti_freq',$(this).val());" role="listbox">
              <option value="0"<?php echo$config['uti_freq']==0?' selected':'';?>><?php echo localize('Never');?></option>
              <option value="3600"<?php echo$config['uti_freq']==3600?' selected':'';?>><?php echo localize('Hourly');?></option>
              <option value="84600"<?php echo$config['uti_freq']==84600?' selected':'';?>><?php echo localize('Daily');?></option>
              <option value="604800"<?php echo$config['uti_freq']==604800?' selected':'';?>><?php echo localize('Weekly');?></option>
              <option value="2629743"<?php echo$config['uti_freq']==2629743?' selected':'';?>><?php echo localize('Monthly');?></option>
            </select>
            <div class="input-group-append">
              <button class="btn btn-secondary" onclick="$('#updatecheck').removeClass('hidden').load('core/layout/updatecheck.php');" role="button" aria-label="<?php echo localize('aria_check');?>"><?php echo localize('Check Now');?></button>
            </div>
          </div>
        </div>
        <div id="updatecheck" class="form-group row hidden">
          <div class="col-form-label col-sm-2"></div>
          <div class="input-group col-sm-10">
            <div class="col alert alert-warning" role="alert"><?php svg('libre-gui-spinner','animated spin').' '.localize('Checking for new updates!');?>'</div>
          </div>
        </div>
        <div class="form-group row">
          <label for="update_url" class="col-form-label col-sm-2" data-tooltip="tooltip" title="URL where new updates are checked and downloaded from."><?php echo localize('Update URL');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="update_url" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="update_url" class="form-control textinput" value="<?php echo$config['update_url'];?>" data-dbid="1" data-dbt="config" data-dbc="update_url" placeholder="<?php echo localize('Enter an ').' '.localize('Update URL');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveupdate_url" class="btn btn-secondary save" data-dbid="update_url" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-right"><?php echo localize('help_idletimeout');?></div>
        <div class="form-group row">
          <label for="idleTime" class="col-form-label col-sm-2"><?php echo localize('Idle Timeout');?></label>
          <div class="input-group col-sm-10">
            <input type="text" id="idleTime" class="form-control textinput" value="<?php echo$config['idleTime'];?>" data-dbid="1" data-dbt="config" data-dbc="idleTime" placeholder="<?php echo localize('Enter a Time in Minutes');?>..." role="textbox">
            <div class="input-group-text"><?php echo localize('Minutes');?></div>
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveidleTime" class="btn btn-secondary save" data-dbid="idleTime" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-right"><?php echo localize('help_dateformat');?></div>
        <div class="form-group row">
          <label for="dateFormat" class="col-form-label col-sm-2"><?php echo localize('Date/Time Format');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="dateFormat" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="dateFormat" class="form-control textinput" value="<?php echo$config['dateFormat'];?>" data-dbid="1" data-dbt="config" data-dbc="dateFormat" placeholder="<?php echo localize('Enter a ').' '.localize('Date/Time Format');?>..." role="textbox">
            <div class="input-group-text"><?php echo date($config['dateFormat'],time());?></div>
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savedateFormat" class="btn btn-secondary save" data-dbid="dateFormat" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="language" class="col-form-label col-sm-2"><?php echo localize('Language');?></label>
          <div class="input-group col-sm-10">
            <select id="language" class="form-control" onchange="update('1','config','language',$(this).val());" role="listbox">
              <?php $path='core'.DS.'i18n';
              $files=array_diff(scandir($path), array('.', '..'));
              foreach($files as$file){
                $filename=substr($file,0,strrpos($file,'.'));
                if($filename=='')continue;
                $lfc=file_get_contents('core'.DS.'i18n'.DS.$filename.'.txt');
                $tr=json_decode($lfc,true);
                echo'<option value="'.$filename.'"'.($filename==$config['language']?' selected="selected"':'').'>'.$tr['lang'].'</option>';
              }
              unset($lfc);
              unset($tr);?>              
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="timezone" class="col-form-label col-sm-2"><?php echo localize('Timezone');?></label>
          <div class="input-group col-sm-10">
            <select id="timezone" class="form-control" onchange="update('1','config','timezone',$(this).val());" data-dbid="1" data-dbt="config" data-dbc="timezone" role="listbox">
              <?php
              function get_timezones(){
              $o=array();
              $t_zones=timezone_identifiers_list();
              foreach($t_zones as$a){
              $t='';
              try{
                $zone=new DateTimeZone($a);
                $seconds=$zone->getOffset(new DateTime("now",$zone));
                $hours=sprintf("%+02d",intval($seconds/3600));
                $minutes=sprintf("%02d",($seconds%3600)/60);
                $t=$a." [ $hours:$minutes ]" ;
                $o[$a]=$t;
              }
              catch(Exception $e){}
              }
              ksort($o);
              return$o;
              }
              $o=get_timezones();
              foreach($o as$tz=>$label)echo'<option value="'.$tz.'"'.($tz==$config['timezone']?' selected="selected"':'').'>'.$tz.'</option>';?>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
