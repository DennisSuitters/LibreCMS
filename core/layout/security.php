<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Security</h4>
    <div class="btn-group pull-right">
      <?php if($help['security_text']!='')echo'<a target="_blank" class="btn btn-default info" href="'.$help['security_text'].'" data-toggle="tooltip" data-placement="left" title="Help">'.svg2('libre-gui-help').'</a>';if($help['security_video']!='')echo'<span><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['security_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help">'.svg2('libre-gui-video').'</a>';?>
    </div>
  </div>
  <div id="update" class="panel-body">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#security-settings" data-toggle="tab">Settings</a></li>
      <li><a href="#security-filters" data-toggle="tab">Filters</a></li>
      <li><a href="#security-database" data-toggle="tab">Database</a></li>
      <li><a href="#security-blacklist" data-toggle="tab">Blacklist</a></li>
    </ul>
    <div class="tab-content">
      <div id="security-settings" name="security-settings" class="tab-pane fade in active">
        <legend class="control-legend">Project Honey Pot</legend>
<?php if($config['php_APIkey']==''){?>
        <div class="form-group">
          <div class="well" style="background-image:url(core/images/target.png);background-repeat:no-repeat;background-position:top right;">
            We recommend signing up to Project Honey Pot to take full advantage of protecting your website from spammers, and in turn help Project Honey Pot protect other sites.<br>
            You can find more information at <a target="_blank" href="http://www.projecthoneypot.org?rf=113735">Project Honey Pot.</a>
          </div>
        </div>
<?php }?>
        <div class="form-group">
          <label for="php_options0" class="control-label check col-xs-5 col-sm-4 col-lg-3" data-toggle="tooltip" title="Toggle Project Honey Pot.">Enable Monitoring</label>
          <div class="input-group col-xs-7 col-sm-8 col-lg-9">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="php_options0" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="0"<?php echo$config['php_options']{0}==1?' checked':'';?>>
              <label for="php_options0"/>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="php_options3" class="control-label check col-xs-5 col-sm-4 col-lg-3" data-toggle="tooltip" title="Toggle Project Honey Pot.">Auto Blacklist</label>
          <div class="input-group col-xs-7 col-sm-8 col-lg-9">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="php_options3" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="3"<?php echo$config['php_options']{3}==1?' checked':'';?>>
              <label for="php_options3"/>
            </div>
            <small class="help-block text-right">Auto Blacklisting requires an API Key to be entered below.<br>Auto Blacklisting filters IP's against Project Honey Pot's http:BL for public facing pages with data entry.</small>
          </div>
        </div>
        <div class="form-group">
          <label for="php_options4" class="control-label check col-xs-5 col-sm-4 col-lg-3" data-toggle="tooltip" title="Toggle Project Honey Pot.">Block Blacklisted IP's</label>
          <div class="input-group col-xs-7 col-sm-8 col-lg-9">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="php_options4" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="4"<?php echo$config['php_options']{4}==1?' checked':'';?>>
              <label for="php_options4"/>
            </div>
            <small class="help-block text-right">Note: This does NOT query the Project Honey Pot http:BL.</small>
          </div>
        </div>
        <div class="form-group">
          <label for="php_APIkey" class="control-label col-xs-5 col-sm-4 col-lg-3">API Key</label>
          <div class="input-group col-xs-7 col-sm-8 col-lg-9">
            <input type="text" id="php_APIkey" class="form-control textinput" value="<?php echo$config['php_APIkey'];?>" data-dbid="1" data-dbt="config" data-dbc="php_APIkey" placeholder="Enter a Project Honey Pot API Key...">
          </div>
        </div>
        <div class="form-group">
          <label for="php_honeypot" class="control-label col-xs-5 col-sm-4 col-lg-3">Honey Pot</label>
          <div class="input-group col-xs-7 col-sm-8 col-lg-9">
            <div id="php_honeypot_link" class="form-control col-xs-5 col-sm-7 col-lg-8">
              <?php echo$config['php_honeypot']!=''?'<a target="_blank" href="'.$config['php_honeypot'].'">'.$config['php_honeypot'].'</a>':'Honey Pot File Not Uploaded.';?>
            </div>
            <div class="input-group-btn">
              <button class="btn btn-default" onclick="elfinderDialog('1','config','php_honeypot');"><?php svg('libre-gui-browse-media');?></button>
            </div>
            <div class="input-group-btn">
              <button class="btn btn-default trash" onclick="updateButtons('1','config','php_honeypot','');"><?php svg('libre-gui-trash');?></button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="php_options2" class="control-label check col-xs-5 col-sm-4 col-lg-3" data-toggle="tooltip" title="Toggle Quick Link.">Quick Link</label>
          <div class="input-group col-xs-7 col-sm-8 col-lg-9">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="php_options2" data-dbid="1" data-dbt="config" data-dbc="php_options" data-dbb="2"<?php echo$config['php_options']{2}==1?' checked':'';?>>
              <label for="php_options2"/>
            </div>
          </div>
        </div>
        <div class="form-group">
          <form target="sp" method="post" action="core/update.php" onsubmit="Pace.restart();$('#php_quicklink_save').removeClass('btn-danger');">
            <input type="hidden" name="id" value="1">
            <input type="hidden" name="t" value="config">
            <input type="hidden" name="c" value="php_quicklink">
            <div class="input-group col-xs-7 col-sm-8 col-lg-9 pull-right" style="background-color:#f5f5f5;padding:5px;border:1px solid #ccc;border-bottom:0;">
              <button type="submit" id="php_quicklink_save" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="bottom" title="Save"><?php svg('libre-gui-save');?></button>
            </div>
            <div class="input-group col-xs-7 col-sm-8 col-lg-9 pull-right">
              <textarea id="php_quicklink" class="form-control" style="height:100px" name="da" onkeyup="$('#php_quicklink_save').addClass('btn-danger');"><?php echo $config['php_quicklink'];?></textarea>
            </div>
          </form>
        </div>
      </div>
      <div id="security-filters" name="security-filters" class="tab-pane fade in">
        <legend>Filter Settings</legend>
        <div class="form-group">
          <label for="spamfilter0" class="control-label check col-xs-5 col-sm-4 col-lg-3" data-toggle="tooltip" title="Toggle Quick Link.">Filter Forms</label>
          <div class="input-group col-xs-7 col-sm-8 col-lg-9">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="spamfilter0" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="0"<?php echo$config['spamfilter']{0}==1?' checked':'';?>>
              <label for="spamfilter0"/>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="spamfilter1" class="control-label check col-xs-5 col-sm-4 col-lg-3" data-toggle="tooltip" title="Toggle Quick Link.">Auto Blacklist</label>
          <div class="input-group col-xs-7 col-sm-8 col-lg-9">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="spamfilter1" data-dbid="1" data-dbt="config" data-dbc="spamfilter" data-dbb="1"<?php echo$config['spamfilter']{1}==1?' checked':'';?>>
              <label for="spamfilter1"/>
            </div>
          </div>
        </div>
        <legend>Filters</legend>
        <div class="panel-body">
          <div class="form-group">
            <small class="help-block">
              Any regular expression syntax can be used here (without the delimiters). All keywords are case insensitive. Lines starting with '#' are ignored.
            </small>
          </div>
          <form target="sp" method="post" action="core/updateblacklist.php">
            <div class="form-group">
              <div class="input-group col-xs-12">
                <div class="input-group-addon">File:</div>
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
                <div class="input-group-btn">
                  <button id="filesEditLoad" class="btn btn-default" onclick="Pace.restart();">Load</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group-btn" style="background-color:#f5f5f5;padding:5px;border:1px solid #ccc;margin-bottom:0;">
                <button id="codeSave" class="btn btn-default btn-xs" onclick="populateTextarea();" data-toggle="tooltip" data-placement="bottom" title="Save"><?php svg('libre-gui-save');?></button>
              </div>
            </div>
            <div class="form-group" style="margin-top:-15px;border:1px solid #ccc;">
<?php $code=file_get_contents($fileDefault);?>
              <textarea id="code" name="code"><?php echo$code;?></textarea>
            </div>
          </form>
        </div>
        <script>/*<![CDATA[*/
          $(document).ready(function (){
            var editor=CodeMirror.fromTextArea(document.getElementById("code"),{
              lineNumbers:true,
              lineWrapping:true,
              mode:"text/html",
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
      <div id="security-database" name="security-database" class="tab-pane fade in">
        <legend>Database Options</legend>
        <div class="form-group">
          <label for="prefix" class="control-label col-xs-5 col-sm-3 col-lg-2">Table Prefix</label>
          <form target="sp" method="post" action="core/changeprefix.php">
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
              <input type="text" id="prefix" class="form-control textinput" name="dbprefix" value="<?php echo$prefix;?>" placeholder="Enter a Prefix...">
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default" onclick="$('body').append('<div id=blocker><div></div></div>');Pace.restart();">Update</button>
              </div>
            </div>
          </form>
        </div>
        <legend>Database Backup/Restore</legend>
        <div id="backup" name="backup">
          <div id="backup_info">
<?php $tid=$ti-2592000;
if($config['backup_ti']<$tid)
  echo$config['backup_ti']==0?'<div class="alert alert-info">A Backup has yet to be performed.</div>':'<div class="alert alert-danger">It has been more than 30 days since a Backup has been performed.</div>';?>
          </div>
          <div class="form-group">
            <label class="control-label col-xs-5 col-sm-3 col-lg-2">Backup</label>
            <form target="sp" method="post" action="core/backup.php">
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default btn-block" onclick="Pace.restart();">Perform Backup</button>
                </div>
              </div>
            </form>
          </div>
          <div id="backups" class="form-group">
<?php foreach(glob("media".DS."backup".DS."*") as$file){
  $filename=basename($file);
  $filename=rtrim($filename,'.sql.gz');?>
            <div id="l_<?php echo$filename;?>" class="form-group">
              <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <a class="btn btn-default btn-block" href="<?php echo$file;?>">Click to Download <?php echo ltrim($file,'media'.DS.'backup'.DS);?></a>
                <div class="input-group-btn">
                  <button class="btn btn-default trash" onclick="removeBackup('<?php echo$filename;?>')"><?php svg('libre-gui-trash');?></button>
                </div>
              </div>
            </div>
<?php }?>
          </div>
          <div class="form-group">
            <label class="control-label col-xs-5 col-sm-3 col-lg-2">Restore</label>
            <form target="sp" method="post" enctype="multipart/form-data" action="core/restorebackup.php">
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <div class="btn btn-default btn-block btn-file">Select .sql file to restore<input type="file" id="fu" class="form-control" name="fu" accept="application/sql"></div>
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default" onclick="Pace.restart();">Restore</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div id="security-blacklist" name="security-blacklist" class="tab-pane fade in">
        <div class="table-responsive">
          <table class="table table-condensed table-striped table-hover">
            <thead>
              <tr>
                <th class="col-xs-3 text-center">Date Blacklisted</th>
                <th class="col-xs-3 text-center">Date Captured</th>
                <th class="col-xs-3 text-center">IP</th>
                <th class="col-xs-3"></th>
              </tr>
            </thead>
            <tbody id="l_blacklist">
<?php $is=0;
$ie=50;
$action=(isset($args[1])?$args[1]:'');
include'core'.DS.'layout'.DS.'blacklist_items.php';?>
            </tbody>
          </table>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
