<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Page Settings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/pages';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#pages-settings" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <form target="sp" method="post" action="core/updatetheme.php">
      <div class="form-group">
        <div class="input-group col-xs-12">
          <div class="input-group-addon">File:</div>
          <select id="filesEditSelect" class="form-control" name="file">
<?php $fileDefault=($user['rank']==1000?'meta_head.html':'meta_head.html');
$files=array();
foreach(glob("layout".DS.$config['theme'].DS."*.{html}",GLOB_BRACE)as$file){
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
        <div class="input-group-btn hidden-xs" style="background-color:#f5f5f5;padding:5px;border:1px solid #ccc;margin-bottom:0;">
          <button id="codeSave" class="btn btn-default btn-xs" onclick="populateTextarea();" data-toggle="tooltip" data-placement="bottom" title="Save"><?php svg('libre-gui-save',($config['iconsColor']==1?true:null));?></button>
        </div>
      </div>
      <div class="form-group" style="margin-top:-15px;border:1px solid #ccc;">
<?php $code=file_get_contents($fileDefault);?>
        <textarea id="code" name="code"><?php echo$code;?></textarea>
      </div>
    </form>
  </div>
</div>
<script>/*<![CDATA[*/
  $(document).ready( function () {
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
      lineNumbers:  true,
      lineWrapping: true,
      mode:         "text/html",
      autoRefresh:  true
    });
    var charWidth = editor.defaultCharWidth(), basePadding = 4;
    editor.refresh();
    $('#filesEditLoad').on({
      click: function (event) {
        event.preventDefault();
        var url = $('#filesEditSelect').val();
        $.ajax({
          url:      url + '?<?php echo time();?>',
          dataType: "text",
          success: function (data) {
            Pace.restart();
            editor.setValue(data).refresh();
          }
        });
      }
    });
  });
  function populateTextarea () {
    $('#block').css({'display':'block'});
  }
/*]]>*/</script>
