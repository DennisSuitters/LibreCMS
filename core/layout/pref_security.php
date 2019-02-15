<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active" aria-current="page"><strong>Security</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <?php if($help['security_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['security_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['security_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['security_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card col-sm-12">
      <div id="update" class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li id="nav-security-settings" class="nav-item"><a class="nav-link active" href="#tab-security-settings" aria-controls="tab-security-settings" role="tab" data-toggle="tab">Settings</a></li>
          <li id="nav-security-filters" class="nav-item"><a class="nav-link" href="#tab-security-filters" aria-controls="tab-security-filter" role="tab" data-toggle="tab">Filters</a></li>
          <li id="nav-security-blacklist" class="nav-item"><a class="nav-link" href="#tab-security-blacklist" aria-controls="tab-security-blacklist" role="tab" data-toggle="tab">Blacklist</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-security-settings" name="tab-security-settings" class="tab-pane active">
            <h4>Administration Access Page</h4>
            <form target="sp" method="post" action="core/change_adminaccess.php">
              <div class="form-group row">
                <label for="php_APIkey" class="col-form-label col-sm-2">Access Folder</label>
                <div class="input-group col-sm-10">
                  <div id="adminaccess" class="input-group-text">
                    <a href="<?php echo URL.$settings['system']['admin'];?>"><?php echo URL;?></a>
                  </div>
                  <input type="text" id="adminfolder" class="form-control" name="adminfolder" value="<?php echo$settings['system']['admin'];?>" placeholder="This entry must NOT be blank..." require aria-required="true">
                  <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Update Access Folder">
                    <button type="submit" class="btn btn-secondary">Update</button>
                  </div>
                  <div class="help-block col small text-muted">Changing the access folder for the Administration area may log you out.</div>
                </div>
              </div>
            </form>
            <div class="form-group row">
              <label for="php_options5" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Project Honey Pot.">Wordpress Attacks</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options5" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="5"<?php echo$config['php_options']{5}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                <div class="help-block col small text-muted text-right">Enabling Wordpress Attacks will allow LibreCMS to look out for known Wordpres attack vectors such as the "xmlrpc.php" and "?author=" brute force attempts and Auto Blacklist the origin IP.</div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options6" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Project Honey Pot.">30 Day Blacklist</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options6" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="6"<?php echo$config['php_options']{6}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                <div class="help-block col small text-muted text-right">Enabling 30 Day Blacklist, removes Blacklisted IP's after 30 Days.</div>
              </div>
            </div>
            <h4>Project Honey Pot</h4>
<?php if($config['php_APIkey']==''){?>
            <div class="form-group">
              <div class="well" style="height:80px;background-image:url(core/images/target.png);background-repeat:no-repeat;background-position:top right;">We recommend signing up to Project Honey Pot to take full advantage of protecting your website from spammers, and in turn help Project Honey Pot protect other sites. You can find more information at <a target="_blank" href="http://www.projecthoneypot.org?rf=113735">Project Honey Pot.</a>
              </div>
            </div>
<?php }?>
            <div class="form-group row">
              <label for="php_options0" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Project Honey Pot.">Enable Monitoring</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="0"<?php echo$config['php_options']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options3" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Project Honey Pot.">Auto Blacklist</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options3" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="3"<?php echo$config['php_options']{3}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></label>
                <div class="help-block col small text-muted text-right">Auto Blacklisting requires an API Key to be entered below.<br>Auto Blacklisting filters IP's against Project Honey Pot's http:BL for public facing pages with data entry.</div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options4" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Project Honey Pot.">Block Blacklisted IP's</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options4" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="4"<?php echo$config['php_options']{4}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></label>
                <div class="help-block col small text-muted text-right">Note: This does NOT query the Project Honey Pot http:BL.</div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_APIkey" class="col-form-label col-sm-2">API Key</label>
              <div class="input-group col-sm-10">
                <input type="text" id="php_APIkey" class="form-control textinput" value="<?php echo$config['php_APIkey'];?>" data-dbid="1" data-dbt="config" data-dbc="php_APIkey" placeholder="Enter a Project Honey Pot API Key...">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savephp_APIkey" class="btn btn-secondary save" data-dbid="php_APIkey" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_honeypot" class="col-form-label col-sm-2">Honey Pot</label>
              <div class="input-group col-sm-10">
                <div id="php_honeypot_link" class="input-group-text col">
                  <?php echo$config['php_honeypot']!=''?'<a target="_blank" href="'.$config['php_honeypot'].'">'.$config['php_honeypot'].'</a>':'Honey Pot File Not Uploaded.';?>
                </div>
                <div class="input-group-append">
                  <button class="btn btn-secondary" onclick="elfinderDialog('1','config','php_honeypot');" data-tooltip="tooltip" title="Browse Media"><?php svg('libre-gui-browse-media');?></button>
                </div>
                <div class="input-group-append">
                  <button class="btn btn-secondary trash" onclick="updateButtons('1','config','php_honeypot','');" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="php_options2" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Quick Link.">Quick Link</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="php_options2" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="2"<?php echo$config['php_options']{2}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></label>
              </div>
            </div>
            <div class="form-group row text-right">
              <div class="col-form-label col-sm-2"></div>
              <div class="col-12 col-sm-10">
                <form target="sp" method="post" action="core/update.php" onsubmit="Pace.restart();$('#php_quicklink_save').removeClass('btn-danger');">
                  <input type="hidden" name="id" value="1">
                  <input type="hidden" name="t" value="config">
                  <input type="hidden" name="c" value="php_quicklink">
                  <div class="input-group card-header p-2 mb-0">
                    <button type="submit" id="php_quicklink_save" class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-placement="bottom" title="Save"><?php svg('libre-gui-save');?></button>
                  </div>
                  <div class="input-group">
                    <textarea id="php_quicklink" class="form-control" style="height:100px" name="da" onkeyup="$('#php_quicklink_save').addClass('btn-danger');"><?php echo $config['php_quicklink'];?></textarea>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div id="tab-security-filters" name="tab-security-filters" class="tab-pane">
            <legend>Filter Settings</legend>
            <div class="form-group row">
              <label for="spamfilter0" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Quick Link.">Filter Forms</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="spamfilter0" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="0"<?php echo$config['spamfilter']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="spamfilter1" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle Quick Link.">Auto Blacklist</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="spamfilter1" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="1"<?php echo$config['spamfilter']{1}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <legend>Filters</legend>
            <div class="card-body">
              <div class="help-block small text-muted text-right">Any regular expression syntax can be used here (without the delimiters). All keywords are case insensitive. Lines starting with '#' are ignored.</div>
              <form target="sp" method="post" action="core/updateblacklist.php">
                <div class="input-group">
                  <div class="input-group-text">File:</div>
                  <select id="filesEditSelect" class="form-control" name="file">
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
                    <button id="filesEditLoad" class="btn btn-secondary" onclick="Pace.restart();">Load</button>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group card-header p-2 mb-0">
                    <button id="codeSave" class="btn btn-secondary btn-sm" onclick="populateTextarea();" data-tooltip="tooltip" data-placement="bottom" title="Save"><?php svg('libre-gui-save');?></button>
                  </div>
                </div>
                <div class="form-group" style="margin-top:-15px">
<?php $code=file_get_contents($fileDefault);?>
                  <textarea id="code" name="code"><?php echo$code;?></textarea>
                </div>
              </form>
            </div>
            <script src="<?php echo URL.'core'.DS.'js'.DS.'codemirror.js';?>"></script>
            <script src="<?php echo URL.'core'.DS.'js'.DS.'xml.js';?>"></script>
            <script src="<?php echo URL.'core'.DS.'js'.DS.'autorefresh.js';?>"></script>
            <script src="<?php echo URL.'core'.DS.'js'.DS.'htmlmixed.js';?>"></script>
            <script src="<?php echo URL.'core'.DS.'js'.DS.'matchbrackets.js';?>"></script>
            <script src="<?php echo URL.'core'.DS.'js'.DS.'matchtags.js';?>"></script>
            <script src="<?php echo URL.'core'.DS.'js'.DS.'hardwrap.js';?>"></script>
            <script>/*<![CDATA[*/
              $(document).ready(function (){
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
            /*]]>*/</script>
          </div>
          <div id="tab-security-blacklist" name="tab-security-blacklist" class="tab-pane">
            <div class="table-responsive">
              <table class="table table-condensed table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-xs-3 text-center">Date Blacklisted</th>
                    <th class="col-xs-3 text-center">Date Captured</th>
                    <th class="col-xs-3 text-center">IP</th>
                    <th class="col-xs-3">
                      <div class="btn-group float-right">
                        <button class="btn btn-secondary btn-sm trash" onclick="purge('0','iplist');return false;" data-tooltip="tooltip" data-placement="left" title="Purge All"><?php svg('libre-gui-purge');?></button>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody id="l_iplist">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."iplist` ORDER BY ti DESC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                  <tr id="l_<?php echo$r['id'];?>">
                    <td class="text-center"><small><?php echo date($config['dateFormat'],$r['ti']);?></small></td>
                    <td class="text-center"><small><?php echo date($config['dateFormat'],$r['oti']);?></small></td>
                    <td class="text-center"><small><?php echo'<strong>'.$r['ip'].'</strong>';?></small></td>
                    <td id="controls_<?php echo$r['id'];?>">
                      <div class="btn-group float-right">
                        <a class="btn btn-secondary" target="_blank" href="https://www.projecthoneypot.org/ip_<?php echo$r['ip'];?>"><?php echo svg2('libre-brand-projecthoneypot');?></a>
                        <a class="btn btn-secondary" target="_blank" href="http://www.ipaddress-finder.com/?ip=<?php echo$r['ip'];?>"><?php echo svg2('libre-gui-search');?></a>
                        <button class="btn btn-secondary trash" onclick="purge('<?php echo$r['id'];?>','iplist');return false;" data-toggle="tooltip" title="Purge"><?php svg('libre-gui-purge');?></button>
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
