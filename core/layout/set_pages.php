<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Pages Settings
 *
 * set_pages.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Settings - Pages
 * @package    core/layout/set_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php echo localize('Content');?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>"><?php echo localize('Pages');?></a></li>
    <li class="breadcrumb-item active"><strong><?php echo localize('Settings');?></strong></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Back');?>" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <?php if($help['pages_settings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['pages_settings_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['pages_settings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['pages_settings_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
<?php if(!file_exists('layout'.DS.$config['theme'].DS.'theme.ini')){
  echo'<div class="alert alert-danger" role="alert">'.localize('warning_notheme').'</div>';
}else{?>
        <form target="sp" method="post" action="core/updatetheme.php" role="form">
          <div class="input-group">
            <label for="fileEditSelect" class="input-group-text"><?php echo localize('File');?>:</label>
            <select id="filesEditSelect" class="custom-select" name="file" role="listbox">
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
              <button id="filesEditLoad" class="btn btn-secondary" onclick="Pace.restart();" role="button" aria-label="<?php echo localize('aria_load');?>"><?php echo localize('Load');?></button>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group card-header p-2 mb-0">
              <button id="codeSave" class="btn btn-secondary" onclick="populateTextarea();" data-tooltip="tooltip" data-placement="bottom" title="<?php echo localize('Save');?>" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button>
            </div>
          </div>
          <div class="form-group" style="margin-top:-15px">
<?php $code=file_get_contents($fileDefault);?>
            <textarea id="code" name="code" role="textbox"><?php echo$code;?></textarea>
          </div>
        </form>
      </div>
      <script>
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
      </script>
<?php }?>
    </div>
  </div>
</main>
<iframe id="sp" name="sp" class="d-none"></iframe>
