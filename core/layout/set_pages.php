<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Content</li>
    <li class="breadcrumb-item">Pages</li>
    <li class="breadcrumb-item active" aria-current="page"><strong>Settings</strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal info" href="<?php echo URL.$settings['system']['admin'].'/pages';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
        <?php if($help['pages_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['pages_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="Read Text Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['pages_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['pages_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
<?php if(!file_exists('layout'.DS.$config['theme'].DS.'theme.ini')){
        echo'<div class="alert alert-danger">A Website Theme has not been set...</div>';
}else{?>
        
        <form target="sp" method="post" action="core/updatetheme.php">
          <div class="input-group">
            <label for="fileEditSelect" class="input-group-text">File:</label>
            <select id="filesEditSelect" class="custom-select" name="file">
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
            <div class="input-group-append">
              <button id="filesEditLoad" class="btn btn-secondary" onclick="Pace.restart();">Load</button>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group card-header p-2 mb-0">
              <button id="codeSave" class="btn btn-secondary" onclick="populateTextarea();" data-tooltip="tooltip" data-placement="bottom" title="Save"><?php svg('libre-gui-save');?></button>
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
                  editor.setValue(data);
                }
              });
            }
          });
        });
        function populateTextarea(){
          Pace.restart();
        }
      /*]]>*/</script>
<?php }?>
    </div>
  </div>
</main>
<iframe id="sp" name="sp" class="d-none"></iframe>
