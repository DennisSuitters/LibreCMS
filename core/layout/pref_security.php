<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Security Preferences
 *
 * pref_security.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Preferences - Security
 * @package    core/layout/pref_security.php
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
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php echo localize('Preferences');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Security');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <?php if($help['security_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['security_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['security_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['security_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div id="update" class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li id="nav-security-settings" class="nav-item"><a class="nav-link active" href="#tab-security-settings" aria-controls="tab-security-settings" role="tab" data-toggle="tab"><?php echo localize('Settings');?></a></li>
          <li id="nav-security-filters" class="nav-item"><a class="nav-link" href="#tab-security-filters" aria-controls="tab-security-filter" role="tab" data-toggle="tab"><?php echo localize('Filters');?></a></li>
          <li id="nav-security-blacklist" class="nav-item"><a class="nav-link" href="#tab-security-blacklist" aria-controls="tab-security-blacklist" role="tab" data-toggle="tab"><?php echo localize('Blacklist');?></a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-security-settings" name="tab-security-settings" class="tab-pane active">
            <h4><?php echo localize('Administration Access Page');?></h4>
            <form target="sp" method="post" action="core/change_adminaccess.php" role="form">
              <div class="form-group row">
                <label for="adminfolder" class="col-form-label col-sm-2"><?php echo localize('Access Folder');?></label>
                <div class="input-group col-sm-10">
                  <div id="adminaccess" class="input-group-text">
                    <a href="<?php echo URL.$settings['system']['admin'];?>"><?php echo URL;?></a>
                  </div>
                  <input type="text" id="adminfolder" class="form-control" name="adminfolder" value="<?php echo$settings['system']['admin'];?>" placeholder="<?php echo localize('This entry must NOT be blank');?>..." require aria-required="true" role="textbox">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary" role="button" aria-label="<?php echo localize('aria_update');?>"><?php echo localize('Update');?></button>
                  </div>
                  <div class="help-block col small"><?php echo localize('help_adminfolder');?></div>
                </div>
              </div>
            </form>
            <div class="form-group row">
              <label for="php_options5" class="col-form-label col-sm-2"><?php echo localize('Wordpress Attacks');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options5" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="5"<?php echo$config['php_options']{5}==1?' checked':'';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
                <div class="help-block col small text-right"><?php echo localize('help_securitywordpress');?></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options6" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Project Honey Pot."><?php echo localize('30 Day Blacklist');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options6" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="6" role="checkbox"<?php echo$config['php_options']{6}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
                <div class="help-block col small text-right"><?php echo localize('help_security30dayblacklist');?></div>
              </div>
            </div>
            <h4><?php echo localize('Project Honey Pot');?></h4>
<?php if($config['php_APIkey']==''){?>
            <div class="form-group">
              <div class="well" style="height:80px;background-image:url(core/images/target.png);background-repeat:no-repeat;background-position:top right;"><?php echo localize('help_securityphp');?></div>
            </div>
<?php }?>
            <div class="form-group row">
              <label for="php_options0" class="col-form-label col-sm-2"><?php echo localize('Enable Monitoring');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="0" role="checkbox"<?php echo$config['php_options']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options3" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Project Honey Pot."><?php echo localize('Auto Blacklist');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options3" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="3" role="checkbox"<?php echo$config['php_options']{3}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></label>
                <div class="help-block col small text-right"><?php echo localize('help_securityphpapi');?></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options4" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Project Honey Pot."><?php echo localize("Block Blacklisted IP's");?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options4" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="4" role="checkbox"<?php echo$config['php_options']{4}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_APIkey" class="col-form-label col-sm-2"><?php echo localize('PHP API Key');?></label>
              <div class="input-group col-sm-10">
                <input type="text" id="php_APIkey" class="form-control textinput" value="<?php echo$config['php_APIkey'];?>" data-dbid="1" data-dbt="config" data-dbc="php_APIkey" placeholder="<?php echo localize('Enter a Project Honey Pot API Key');?>..." role="textbox">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savephp_APIkey" class="btn btn-secondary save" data-dbid="php_APIkey" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_honeypot" class="col-form-label col-sm-2"><?php echo localize('Honey Pot');?></label>
              <div class="input-group col-sm-10">
                <div id="php_honeypot_link" class="input-group-text col">
                  <?php echo$config['php_honeypot']!=''?'<a target="_blank" href="'.$config['php_honeypot'].'">'.$config['php_honeypot'].'</a>':localize('Honey Pot File Not Uploaded').'...';?>
                </div>
                <div class="input-group-append">
                  <button class="btn btn-secondary" onclick="elfinderDialog('1','config','php_honeypot');" data-tooltip="tooltip" title="<?php echo localize('Open Media Manager');?>" role="button" aria-label="<?php echo localize('aria_file_mediamanager');?>"><?php svg('libre-gui-browse-media');?></button>
                </div>
                <div class="input-group-append">
                  <button class="btn btn-secondary trash" onclick="updateButtons('1','config','php_honeypot','');" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options2" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Quick Link."><?php echo localize('Quick Link');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options2" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="2" role="checkbox"<?php echo$config['php_options']{2}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></label>
              </div>
            </div>
            <div class="form-group row text-right">
              <div class="col-form-label col-sm-2"></div>
              <div class="col-12 col-sm-10">
                <form target="sp" method="post" action="core/update.php" onsubmit="Pace.restart();$('#php_quicklink_save').removeClass('btn-danger');" role="form">
                  <input type="hidden" name="id" value="1">
                  <input type="hidden" name="t" value="config">
                  <input type="hidden" name="c" value="php_quicklink">
                  <div class="input-group card-header p-2 mb-0">
                    <button type="submit" id="php_quicklink_save" class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-placement="bottom" title="<?php echo localize('Save');?>" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button>
                  </div>
                  <div class="input-group">
                    <textarea id="php_quicklink" class="form-control" style="height:100px" name="da" onkeyup="$('#php_quicklink_save').addClass('btn-danger');" role="textbox"><?php echo $config['php_quicklink'];?></textarea>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div id="tab-security-filters" name="tab-security-filters" class="tab-pane">
            <legend><?php echo localize('Filter Settings');?></legend>
            <div class="form-group row">
              <label for="spamfilter0" class="col-form-label col-sm-2"><?php echo localize('Filter Forms');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="spamfilter0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="0" role="checkbox"<?php echo$config['spamfilter']{0}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="spamfilter1" class="col-form-label col-sm-2"><?php echo localize('Auto Blacklist');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="spamfilter1" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="1" role="checkbox"<?php echo$config['spamfilter']{1}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
              </div>
            </div>
            <legend><?php echo localize('Filters');?></legend>
            <div class="card-body">
              <div class="help-block small text-muted text-right"><?php echo localize('help_filters');?></div>
              <form target="sp" method="post" action="core/updateblacklist.php" role="form">
                <div class="input-group">
                  <div class="input-group-text"><?php echo localize('File');?>:</div>
                  <select id="filesEditSelect" class="form-control" name="file" role="listbox">
                    <?php $fileDefault=($user['rank']==1000?'index.txt':'index.txt');
                    $files=array();
                    foreach(glob("core".DS."blacklists".DS."*.{txt}",GLOB_BRACE)as$file){
                      echo'<option value="'.$file.'"';
                      if(stristr($file,$fileDefault)){
                        echo' selected';
                        $fileDefault=$file;
                      }
                      echo'>'.basename($file).'</option>';
                    }?>
                  </select>
                  <div class="input-group-append">
                    <button id="filesEditLoad" class="btn btn-secondary" onclick="Pace.restart();" role="button" aria-label="<?php echo localize('aria_load');?>"><?php echo localize('Load');?></button>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group card-header p-2 mb-0">
                    <button id="codeSave" class="btn btn-secondary btn-sm" onclick="populateTextarea();" data-tooltip="tooltip" data-placement="bottom" title="<?php echo localize('Save');?>" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button>
                  </div>
                </div>
                <div class="form-group" style="margin-top:-15px">
<?php $code=file_get_contents($fileDefault);?>
                  <textarea id="code" name="code" role="textbox"><?php echo$code;?></textarea>
                </div>
              </form>
            </div>
            <script>
              $(document).ready(function(){
                var editor=CodeMirror.fromTextArea(document.getElementById("code"),{
                  lineNumbers:true,
                  lineWrapping:true,
                  mode:"text/html",
                  theme:"base16-dark",
                  autoRefresh:true
                });
                var charWidth=editor.defaultCharWidth(),basePadding=4;
                editor.refresh();
                $('#filesEditLoad').on({
                  click:function(event){
                    event.preventDefault();
                    var url=$('#filesEditSelect').val();
                    $.ajax({
                      url:url+'?<?php echo time();?>',
                      dataType:"text",
                      success:function(data){
                        Pace.restart();
                        editor.setValue(data).refresh();
                      }
                    });
                  }
                });
              });
              function populateTextarea(){
                Pace.restart();
              }
            </script>
          </div>
          <div id="tab-security-blacklist" name="tab-security-blacklist" class="tab-pane">
            <div class="table-responsive">
              <table class="table table-condensed table-striped table-hover" role="table">
                <thead>
                  <tr role="row">
                    <th class="col-xs-3 text-center" role="columnheader"><?php echo localize('Date Blacklisted');?></th>
                    <th class="col-xs-3 text-center" role="columnheader"><?php echo localize('Date Captured');?></th>
                    <th class="col-xs-3 text-center" role="columnheader"><?php echo localize('IP');?></th>
                    <th class="col-xs-3" role="columnheader">
                      <div class="btn-group float-right">
                        <button class="btn btn-secondary btn-sm trash" onclick="purge('0','iplist');return false;" data-tooltip="tooltip" title="<?php echo localize('Purge All');?>" role="button" aria-label="<?php echo localize('aria_purge');?>"><?php svg('libre-gui-purge');?></button>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody id="l_iplist">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."iplist` ORDER BY ti DESC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="l_<?php echo$r['id'];?>" role="row">
                    <td class="text-center small" role="cell"><?php echo date($config['dateFormat'],$r['ti']);?></td>
                    <td class="text-center small" role="cell"><?php echo date($config['dateFormat'],$r['oti']);?></td>
                    <td class="text-center small" role="cell"><?php echo'<strong>'.$r['ip'].'</strong>';?></td>
                    <td id="controls_<?php echo$r['id'];?>" row="cell">
                      <div class="btn-group float-right">
                        <a class="btn btn-secondary" target="_blank" href="https://www.projecthoneypot.org/ip_<?php echo$r['ip'];?>" data-tooltip="tooltip" title="Lookup IP using Project Honey Pot (Opens in New Page)." role="button" aria-label="Lookup IP using Project Honey Pot (Open in New Page)"><?php echo svg2('libre-brand-projecthoneypot');?></a>
                        <a class="btn btn-secondary" target="_blank" href="http://www.ipaddress-finder.com/?ip=<?php echo$r['ip'];?>" data-tooltip="tooltip" title="Lookup IP using IP Address Finder .com (Opens in New Page)." role="button" aria-label="Lookup IP using IP Address Finder .com (Opens in New Page)"><?php echo svg2('libre-gui-search');?></a>
                        <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','iplist');return false;" data-tooltip="tooltip" title="<?php echo localize('Purge');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-purge');?></button>
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
      </div>
    </div>
  </div>
</main>
