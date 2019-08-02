<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Edit Content
 *
 * edit_content.php version 2.0.3
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Content - Edit
 * @package    core/layout/edit_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.3
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Fix Media Item Layouts
 * @changes    v2.0.1 Add Dropdown for Breadcrumb for other Content Access
 * @changes    v2.0.2 Add Category 3 & 4 Editing.
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix Sortable items for Media breaking other scripts.
 * @changes    v2.0.2 Fix ARIA Attributes.
 * @changes    v2.0.2 Fix Media Display, adding and removal.
 * @changes    v2.0.3 Add Image ALT.
 * @changes    v2.0.3 Add Category Choice Selection.
 * @changes    v2.0.5 Fix Media Display in Pages and Content Tabs.
 */
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php echo localize('Content');?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content/type/'.$r['contentType'];?>"><?php echo ucfirst($r['contentType']).(in_array($r['contentType'],array('article'))?'s':'');?></a></li>
    <li class="breadcrumb-item active">
      <span id="titleupdate"><?php echo$r['title'];?></span>
<?php $so=$db->prepare("SELECT id,title FROM content WHERE lower(contentType) LIKE lower(:contentType) AND id!=:id ORDER BY title ASC");
$so->execute([
  ':contentType'=>$r['contentType'],
  ':id'=>$r['id']
]);
if($so->rowCount()>0){
      echo'<a class="btn btn-ghost-normal dropdown-toggle m-0 p-0 pl-2 pr-2 text-white" data-toggle="dropdown" href="'.URL.$settings['system']['admin'].'/content/type/'.$r['contentType'].'" role="button" aria-label="'.localize('aria_quick_content').'" aria-haspopup="true" aria-expanded="false"></a><div class="dropdown-menu">';
  while($ro=$so->fetch(PDO::FETCH_ASSOC)){
      echo'<a class="dropdown-item" href="'.URL.$settings['system']['admin'].'/content/edit/'.$ro['id'].'">'.$ro['title'].'</a>';
  }
    echo'</div>';
}?>
    </li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/add/'.$r['contentType'];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Back');?>" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <?php if($help['content_edit_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['content_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['content_edit_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['content_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li id="nav-content-content" class="nav-item" role="presentation"><a class="nav-link active" href="#tab-content-content" aria-controls="tab-content-content" role="tab" data-toggle="tab"><?php echo localize('Content');?></a></li>
          <li id="nav-content-images" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-images" aria-controls="tab-content-images" role="tab" data-toggle="tab"><?php echo localize('Images');?></a></li>
          <li id="nav-content-media" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-media" aria-controls="tab-content-media" role="tab" data-toggle="tab"><?php echo localize('Media');?></a></li>
          <li id="nav-content-options" class="nav-item<?php echo$r['contentType']!='inventory'?' hidden':'';?>" role="presentation"><a class="nav-link" href="#tab-content-options" aria-controls="tab-content-options" role="tab" data-toggle="tab"><?php echo localize('Options');?></a></li>
          <li id="nav-content-comments" class="nav-item<?php echo$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'';?>" role="presentation"><a class="nav-link" href="#tab-content-comments" aria-controls="tab-content-comments" role="tab" data-toggle="tab"><?php echo localize('Comments');?></a></li>
          <li id="nav-content-reviews" class="nav-item<?php echo$r['contentType']=='testimonials'||$r['contentType']=='event'||$r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='news'||$r['contentType']=='portfolio'||$r['contentType']=='proof'?' hidden':'';?>" role="presentation"><a class="nav-link" href="#tab-content-reviews" aria-controls="tab-content-reviews" role="tab" data-toggle="tab"><?php echo localize('Reviews');?></a></li>
          <li id="nav-content-seo" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-seo" aria-controls="tab-content-seo" role="tab" data-toggle="tab"><?php echo localize('SEO');?></a></li>
          <li id="nav-content-settings" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-settings" aria-controls="tab-content-settings" role="tab" data-toggle="tab"><?php echo localize('Settings');?></a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-content-content" class="tab-pane active" role="tabpanel">
            <div class="help-block small text-right"><?php echo localize('help_notitle');?></div>
            <div id="nav-content-content-1" class="form-group row">
              <label for="title" class="col-form-label col-sm-2"><?php echo localize('Title');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="title" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'title']);
                    echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="title" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title" data-bs="btn-danger" placeholder="<?php echo localize('help_notitle');?>..." onkeyup="genurl();$('#titleupdate').text($(this).val());" role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-btn" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="title" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savetitle" class="btn btn-secondary save" data-dbid="title" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
              <script>
                function genurl(){
                  var data=$('#title').val().toLowerCase();
                  var url="<?php echo URL.$r['contentType'];?>/"+slugify(data);
                  $('#genurl').attr('href',url);
                  $('#genurl').html(url);
                }
                function slugify(str){
                  str=str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
                  str=str.replace(/^\s+|\s+$/gm,'');
                  str=str.replace(/\s+/g, '-');	
                  return str;
                }
              </script>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-2"><?php echo localize('URL Slug');?></label>
              <div class="input-group col-sm-10">
                <div class="input-group-text text-truncate col-sm-12">
                  <a id="genurl" target="_blank" href="<?php echo URL.$r['contentType'].'/'.$r['urlSlug'];?>"><?php echo URL.$r['contentType'].'/'.$r['urlSlug'];?></a>
                </div>
              </div>
            </div>
            <div id="nav-content-content-2" class="form-group row">
              <label for="ti" class="col-form-label col-sm-2"><?php echo localize('Created');?></label>
              <div class="input-group col-sm-10"><input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly role="textbox"></div>
            </div>
            <div id="nav-content-content-3" class="form-group row<?php echo$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="pti" class="col-form-label col-sm-2"><?php echo localize('Published On');?></label>
              <div class="input-group col-sm-10">
                <input type="text" id="pti" class="form-control textinput" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="pti" value="<?php echo date('M n, Y g:i A',$r['pti']);?>" role="textbox">
                <input type="hidden" id="ptix" value="<?php echo$r['pti'];?>">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savepti" class="btn btn-secondary save" data-dbid="pti" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-4" class="form-group row">
              <label for="eti" class="col-form-label col-sm-2"><?php echo localize('Edited');?></label>
              <div class="input-group col-sm-10"><input type="text" id="eti" class="form-control" value="<?php echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?>" readonly role="textbox"></div>
            </div>
            <div id="nav-content-content-5" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="cid" class="col-form-label col-sm-2"><?php echo localize('Client');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="cid" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="cid" class="form-control"<?php echo$user['options']{1}==0?' disabled':'';?> onchange="update('<?php echo$r['id'];?>','content','cid',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid" role="listbox">
                  <option value="0"><?php echo localize('Select a ').' '.localize('Client');?></option>
                  <?php $cs=$db->query("SELECT * FROM `".$prefix."login` ORDER BY name ASC, username ASC");while($cr=$cs->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$cr['id'].'"'.($r['cid']==$cr['id']?' selected':'').'>'.$cr['username'].':'.$cr['name'].'</option>';?>
                </select>
              </div>
            </div>
            <div id="nav-content-content-6" class="form-group row<?php echo$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'?' hidden':'';?>">
              <label for="author" class="col-form-label col-sm-2"><?php echo localize('Author');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="uid" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-lebel="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="uid" class="form-control"<?php echo$user['options']{1}==0?' disabled':'';?> onchange="update('<?php echo$r['id'];?>','content','uid',$(this).val());" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="uid" role="listbox">
                  <?php $su=$db->query("SELECT id,username,name FROM `".$prefix."login` WHERE username!='' AND status!='delete' ORDER BY username ASC, name ASC");while($ru=$su->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$ru['id'].'"'.($ru['id']==$r['uid']?' selected':'').'>'.$ru['username'].':'.$ru['name'].'</option>';?>
                </select>
              </div>
            </div>
            <div id="nav-content-content-7" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="code" class="col-form-label col-sm-2"><?php echo localize('Code');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="code" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="code" class="form-control textinput" value="<?php echo$r['code'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="code" placeholder="<?php echo localize('Enter a ').' '.localize('Code');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savecode" class="btn btn-secondary save" data-dbid="code" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-8" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="barcode" class="col-form-label col-sm-2"><?php echo localize('Barcode');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-toggle="popover" data-dbgid="barcode" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="barcode" class="form-control textinput" value="<?php echo$r['barcode'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="barcode" placeholder="<?php echo localize('Enter a ').' '.localize('Barcode');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savebarcode" class="btn btn-secondary save" data-dbid="barcode" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-right"><a target="_blank" href="https://fccid.io/">fccid.io</a><?php echo localize('help_fcc');?></div>
            <div id="nav-content-content-9" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="fccid" class="col-form-label col-sm-2"><?php echo localize('FCCID');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="fccid" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="fccid" class="form-control textinput" value="<?php echo$r['fccid'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fccid" placeholder="<?php echo localize('Enter an ').' '.localize('FCCID');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savefccid" class="btn btn-secondary save" data-dbid="fccid" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-10" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="brand" class="col-form-label col-sm-2"><?php echo localize('Brand');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="brand" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="brand" list="brand_options" class="form-control textinput" value="<?php echo$r['brand'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="brand" placeholder="<?php echo localize('Enter a ').' '.localize('Brand');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <datalist id="brand_options">
                  <?php $s=$db->query("SELECT DISTINCT brand FROM `".$prefix."content` WHERE brand!='' ORDER BY brand ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['brand'].'"/>';?>
                </datalist>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savebrand" class="btn btn-secondary save" data-dbid="brand" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-11" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="tis" class="col-form-label col-sm-2"><?php echo localize('Event').' '.localize('Start');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="tis" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="tis" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" data-datetime="<?php echo date($config['dateFormat'],$r['tis']);?>" autocomplete="off"<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <input type="hidden" id="tisx" value="<?php echo$r['tis'];?>">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savetis" class="btn btn-secondary save" data-dbid="tis" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-12" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="tie" class="col-form-label col-sm-2"><?php echo localize('Event').' '.localize('End');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="tie" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="tie" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" data-datetime="<?php echo date($config['dateFormat'],$r['tie']);?>" autocomplete="off"<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <input type="hidden" id="tiex" value="<?php echo$r['tie'];?>">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savetie" class="btn btn-secondary save" data-dbid="tie" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
<?php echo$r['ip']!=''?'<div class="help-block small text-right">'.$r['ip'].'</div>':'';?>
            <div id="nav-content-content-13" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="email" class="col-form-label col-sm-2"><?php echo localize('Email');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="email" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="<?php echo localize('Enter an ').' '.localize('Email');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-14" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="name" class="col-form-label col-sm-2"><?php echo localize('Name');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="name" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="name" list="name_options" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="<?php echo localize('Enter a ').' '.localize('Name');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <datalist id="name_options">
<?php $s=$db->query("SELECT DISTINCT name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."login` ORDER BY name ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['name'].'"/>';?>
                </datalist>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savename" class="btn btn-secondary save" data-dbid="name" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-15" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="url" class="col-form-label col-sm-2"><?php echo localize('URL');?></label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-toggle="popover" data-dbgid="url" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="url" placeholder="<?php echo localize('Enter a ').' '.localize('URL');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveurl" class="btn btn-secondary save" data-dbid="url" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-16" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="business" class="col-form-label col-sm-2"><?php echo localize('Business');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-toggle="popover" data-dbgid="business" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="<?php echo localize('Enter a ').' '.localize('Business');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-17" class="form-group row<?php echo$r['contentType']=='testimonials'?' hidden':'';?>">
              <label for="category_1" class="col-form-label col-sm-2"><?php echo localize('Category').' '.localize('One');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="category_1" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input id="category_1" list="category_1_options" type="text" class="form-control textinput" value="<?php echo$r['category_1'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_1" placeholder="<?php echo localize('Enter a ').' '.localize('Category').'/'.localize('Select from List');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <datalist id="category_1_options">
<?php $s=$db->prepare("SELECT DISTINCT (title) as category FROM `".$prefix."choices` WHERE contentType='category' AND url=:contentType AND title!='' ORDER BY title ASC");
$s->execute([':contentType'=>$r['contentType']]);
while($rs=$s->fetch(PDO::FETCH_ASSOC))
echo'<option value="'.$rs['category'].'"/>';?>
                </datalist>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savecategory_1" class="btn btn-secondary save" data-dbid="category_1" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-18" class="form-group row<?php echo$r['contentType']=='testimonials'?' hidden':'';?>">
              <label for="category_2" class="col-form-label col-sm-2"><?php echo localize('Category').' '.localize('Two');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="category_2" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input id="category_2" list="category_2_options" type="text" class="form-control textinput" value="<?php echo$r['category_2'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_2" placeholder="<?php echo localize('Enter a ').' '.localize('Category').'/'.localize('Select from List');?>..."<?php echo($user['options']{1}==0?' readonly':'');?> role="textbox">
                <datalist id="category_2_options">
                  <?php $s=$db->query("SELECT DISTINCT category_2 FROM `".$prefix."content` WHERE category_2!='' ORDER BY category_2 ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_2'].'"/>';?>
                </datalist>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savecategory_2" class="btn btn-secondary save" data-dbid="category_2" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-19" class="form-group row<?php echo$r['contentType']=='testimonials'?' hidden':'';?>">
              <label for="category_3" class="col-form-label col-sm-2"><?php echo localize('Category').' '.localize('Three');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="category_3" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input id="category_3" list="category_3_options" type="text" class="form-control textinput" value="<?php echo$r['category_3'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_3" placeholder="<?php echo localize('Enter a ').' '.localize('Category').'/'.localize('Select from List');?>..."<?php echo($user['options']{1}==0?' readonly':'');?> role="textbox">
                <datalist id="category_3_options">
                  <?php $s=$db->query("SELECT DISTINCT category_3 FROM `".$prefix."content` WHERE category_3!='' ORDER BY category_3 ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_3'].'"/>';?>
                </datalist>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savecategory_3" class="btn btn-secondary save" data-dbid="category_3" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-20" class="form-group row<?php echo$r['contentType']=='testimonials'?' hidden':'';?>">
              <label for="category_4" class="col-form-label col-sm-2"><?php echo localize('Category').' '.localize('Four');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="category_4" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input id="category_4" list="category_4_options" type="text" class="form-control textinput" value="<?php echo$r['category_4'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_4" placeholder="<?php echo localize('Enter a ').' '.localize('Category').'/'.localize('Select from List');?>..."<?php echo($user['options']{1}==0?' readonly':'');?> role="textbox">
                <datalist id="category_4_options">
                  <?php $s=$db->query("SELECT DISTINCT category_2 FROM `".$prefix."content` WHERE category_4!='' ORDER BY category_4 ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['category_4'].'"/>';?>
                </datalist>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savecategory_4" class="btn btn-secondary save" data-dbid="category_4" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-21" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="cost" class="col-form-label col-sm-2"><?php echo localize('Cost');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="cost" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <div class="input-group-text"><?php echo localize('currency');?></div>
                <input type="text" id="cost" class="form-control textinput" value="<?php echo$r['cost'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cost" placeholder="<?php echo localize('Enter a ').' '.localize('Cost');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savecost" class="btn btn-secondary save" data-dbid="cost" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-22" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="options0" class="col-form-label col-sm-2"><?php echo localize('Show').' '.localize('Cost');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0" role="checkbox"<?php echo($r['options']{0}==1?' checked aria-checked="true"':' aria-checked="false"');?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
              </div>
            </div>
            <div id="nav-content-content-23" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="quantity" class="col-form-label col-sm-2"><?php echo localize('Quantity');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="quantity" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="quantity" class="form-control textinput" value="<?php echo $r['quantity'];?>" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="quantity" placeholder="<?php echo localize('Enter a ').' '.localize('Quantity');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savequantity" class="btn btn-secondary save" data-dbid="quantity" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-24" class="form-group">
              <div class="card-header col-sm-12 position-relative p-0">
                <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="notesda" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button>':'';
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'notes']);
                  echo$ss->rowCount()>0?'<div data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-dbgid="notesda" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }
                echo$user['rank']>899?'<div class="float-right" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary btn-sm addsuggestion" data-dbgid="notesda" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes"></div>
                <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php" role="form">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="t" value="content">
                  <input type="hidden" name="c" value="notes">
                  <textarea id="notes" class="summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes" name="da" role="textbox"><?php echo rawurldecode($r['notes']);?></textarea>
                </form>
              </div>
            </div>
            <fieldset id="nav-content-content-25" class="control-fieldset<?php echo$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <legend class="control-legend"><?php echo localize('Content Attribution');?></legend>
              <div id="nav-content-content-26" class="form-group row">
                <label for="attributionContentName" class="col-form-label col-sm-2"><?php echo localize('Name');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionContentName" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionContentName" list="attributionContentName_option" class="form-control textinput" value="<?php echo$r['attributionContentName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionContentName" placeholder="<?php echo localize('Enter a ').' '.localize('Name');?>..." role="textbox">
                  <datalist id="attributionContentName_option">
                    <?php $s=$db->query("SELECT DISTINCT attributionContentName AS name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."login` ORDER BY name ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveattributionContentName" class="btn btn-secondary save" data-dbid="attributionContentName" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="nav-content-content-27" class="form-group row">
                <label for="attributionContentURL" class="col-form-label col-sm-2"><?php echo localize('URL');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionContentURL" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionContentURL" list="attributionContentURL_option" class="form-control textinput" value="<?php echo$r['attributionContentURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionContentURL" placeholder="<?php echo localize('Enter a ').' '.localize('URL');?>..." role="textbox">
                  <datalist id="attributionContentURL_option">
                    <?php $s=$db->query("SELECT DISTINCT attributionContentUrl as url FROM `".$prefix."content` ORDER BY attributionContentURL ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveattributionContentURL" class="btn btn-secondary save" data-dbid="attributionContentURL" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            </fieldset>
          </div>
<?php /* Images */ ?>
          <div id="tab-content-images" class="tab-pane" role="tabpanel">
            <div id="error"></div>
            <fieldset id="tab-content-images-1" class="control-fieldset<?php echo$r['contentType']!='testimonials'?' hidden':'';?>">
              <div id="tstavinfo" class="alert alert-info<?php echo$r['cid']==0?' hidden':'';?>" role="alert"><?php echo localize('help_avatar');?></div>
              <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php" onsubmit="Pace,restart();" role="form">
                <div class="form-group row">
                  <label for="avatar" class="col-form-label col-sm-2"><?php echo localize('Avatar');?></label>
                  <div class="input-group col-sm-10">
                    <input type="text" id="av" class="form-control" value="<?php echo$r['file'];?>" readonly data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="avatar" role="textbox">
                    <div class="input-group-append">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <input type="hidden" name="act" value="add_tstavatar">
                      <div class="btn btn-secondary custom-file" data-tooltip="tooltip" title="<?php echo localize('Browse Computer for Image');?>" role="button" aria-label="<?php echo localize('aria_file_browse');?>">
                        <input id="avatarfu" type="file" class="custom-file-input hidden" name="fu" onchange="form.submit()" role="textbox">
                        <label for="avatarfu"><?php svg('libre-gui-browse-computer');?></label>
                      </div>
                    </div>
                    <div class="input-group-append img"><img id="tstavatar" src="<?php echo$r['file']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['file']))?'media'.DS.'avatar'.DS.basename($r['file']):ADMINNOAVATAR;?>" alt="Avatar"></div>
                    <div class="input-group-append"><button class="btn btn-secondary trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','file','');" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button></div>
                  </div>
                </div>
              </form>
            </fieldset>
            <fieldset id="tab-content-images-2" class="control-fieldset<?php echo$r['contentType']=='testimonials'?' hidden':'';?>">
              <div id="tab-content-images-3" class="form-group row">
                <label for="file" class="col-form-label col-sm-2"><?php echo localize('URL');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="fileURL" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="fileURL" class="form-control textinput" value="<?php echo$r['fileURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fileURL" placeholder="<?php echo localize('Enter a ').' '.localize('URL');?>..." role="textbox">
                  <div class="input-group-append img">
                    <?php echo$r['fileURL']!=''?'<a href="'.$r['fileURL'].'" data-lightbox="lightbox" data-max-width="700"><img id="thumbimage" src="'.$r['fileURL'].'"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                  </div>
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savefileURL" class="btn btn-secondary save" data-dbid="fileURL" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-4" class="form-group row">
                <label fore="file" class="col-form-label col-sm-2"><?php echo localize('Image');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="file" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input id="file" type="text" class="form-control textinput" value="<?php echo$r['file'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="file" readonly role="textbox">
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','content','file');" data-tooltip="tooltip" title="<?php echo localize('Open Media Manager');?>" role="button" aria-label="<?php echo localize('aria_file_mediamanager');?>"><?php svg('libre-gui-browse-media');?></button></div>
                  <form target="sp" method="post" action="core/magicimage.php" role="form">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="act" value="file">
                    <div class="input-group-append"><button class="btn btn-secondary" data-tooltip="tooltip" title="<?php echo localize('Resize Image');?> (<?php echo$config['mediaMaxWidth'].'x'.$config['mediaMaxHeight'];?>)" role="button" aria-label="<?php echo localize('aria_resize');?>"><?php svg('libre-gui-magic');?></button></div>
                  </form>
                  <div class="input-group-append img">
                    <?php echo$r['file']!=''?'<a href="'.$r['file'].'" data-lightbox="lightbox"><img id="thumbimage" src="'.$r['file'].'" alt="Thumbnail"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                  </div>
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','file');" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button></div>
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savefile" class="btn btn-secondary save" data-dbid="file" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-5" class="form-group row">
                <label for="thumb" class="col-form-label col-sm-2"><?php echo localize('Thumbnail');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="thumb" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input id="thumb" type="text" class="form-control textinput" value="<?php echo$r['thumb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="thumb" readonly role="textbox">
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','content','thumb');"data-tooltip="tooltip" title="<?php echo localize('Open Media Manager');?>" role="button" aria-label="<?php echo localize('aria_file_mediamanager');?>"><?php svg('libre-gui-browse-media');?></button></div>
                  <form target="sp" method="post" action="core/magicimage.php" role="form">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="act" value="thumb">
                    <div class="input-group-append"><button class="btn btn-secondary" data-tooltip="tooltip" title="<?php echo localize('Create Thumbnail From Above Image');?> (<?php echo$config['mediaMaxWidthThumb'].'x'.$config['mediaMaxHeightThumb'];?>)" role="button" aria-label="<?php echo localize('aria_image_thumb');?>"><?php svg('libre-gui-magic');?></button></div>
                  </form>
                  <div class="input-group-append img">
                    <?php echo$r['thumb']!=''?'<a href="'.$r['thumb'].'" data-lightbox="lightbox"><img id="thumbimage" src="'.$r['thumb'].'" alt="Thumbnail"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'" alt="No Image">';?>
                  </div>
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','thumb');" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button></div>
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savethumb" class="btn btn-secondary save" data-dbid="thumb" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-7" class="form-group row">
                <label for="exifFilename" class="col-form-label col-sm-2"><?php echo localize('Image ALT');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="fileALT" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="fileALT" class="form-control textinput" value="<?php echo$r['fileALT'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fileALT" placeholder="<?php echo localize('Enter an ').localize('Image ALT');?>..." role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>" role="button" aria-label="<?php echo localize('aria_save');?>"><button id="savefileALT" class="btn btn-secondary save" data-dbid="fileALT" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            </fieldset>
            <script>
              $(document).ready(function(){
                $('[data-lightbox="lightbox"]').simpleLightbox();
              });
            </script>
            <fieldset id="tab-content-images-6" class="control-fieldset">
              <legend class="control-legend"><?php echo localize('EXIF Information');?></legend>
              <div class="help-block small text-right"><?php echo localize('help_exif');?></div>
              <div id="tab-content-images-7" class="form-group row">
                <label for="exifFilename" class="col-form-label col-sm-2"><?php echo localize('Original Filename');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifFilename" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifFilename');" role="button" aria-label="<?php echo localize('aria_exif');?>"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifFilename" class="form-control textinput" value="<?php echo$r['exifFilename'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFilename" placeholder="<?php echo localize('Original Filename');?>..." role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>" role="button" aria-label="<?php echo localize('aria_save');?>"><button id="saveexifFilename" class="btn btn-secondary save" data-dbid="exifFilename" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-8" class="form-group row">
                <label for="exifCamera" class="col-form-label col-sm-2"><?php echo localize('Camera');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifCamera" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifCamera');" role="button" aria-label="<?php echo localize('aria_exif');?>"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifCamera" class="form-control textinput" value="<?php echo$r['exifCamera'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifCamera" placeholder="<?php echo localize('Enter a ').' '.localize('Camera');?>..." role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveexifCamera" class="btn btn-secondary save" data-dbid="exifCamera" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-9" class="form-group row">
                <label for="exifLens" class="col-form-label col-sm-2"><?php echo localize('Lens');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifLens" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifLens');" role="button" aria-label="<?php echo localize('aria_exif');?>"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifLens" class="form-control textinput" value="<?php echo$r['exifLens'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifLens" placeholder="<?php echo localize('Enter a ').' '.localize('Lens');?>..." role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveexifLens" class="btn btn-secondary save" data-dbid="exifLens" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-10" class="form-group row">
                <label for="exifAperture" class="col-form-label col-sm-2"><?php echo localize('Aperture');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifAperture" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifAperture');" role="button" aria-label="<?php echo localize('aria_exif');?>"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button></div>
                  <input type="text" id="exifAperture" class="form-control textinput" value="<?php echo$r['exifAperture'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifAperture" placeholder="<?php echo localize('Enter an ').' '.localize('Aperture');?>..." role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveexifAperture" class="btn btn-secondary save" data-dbid="exifAperture" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-11" class="form-group row">
                <label for="exifFocalLength" class="col-form-label col-sm-2"><?php echo localize('Focal Length');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifFocalLength" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifFocalLength');" role="button" aria-label="<?php echo localize('aria_exif');?>"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifFocalLength" class="form-control textinput" value="<?php echo$r['exifFocalLength'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFocalLength" placeholder="<?php echo localize('Enter a ').' '.localize('Focal Length');?>..." role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveexifFocalLength" class="btn btn-secondary save" data-dbid="exifFocalLength" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-12" class="form-group row">
                <label for="exifShutterSpeed" class="col-form-label col-sm-2"><?php echo localize('Shutter Speed');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifShutterSpeed" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifShutterSpeed');" role="button" aria-label="<?php echo localize('aria_exif');?>"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifShutterSpeed" class="form-control textinput" value="<?php echo$r['exifShutterSpeed'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifShutterSpeed" placeholder="<?php echo localize('Enter a ').' '.localize('Shutter Speed');?>..." role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveexifShutterSpeed" class="btn btn-secondary save" data-dbid="exifShutterSpeed" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-13" class="form-group row">
                <label for="exifISO" class="col-form-label col-sm-2"><?php echo localize('ISO');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifISO" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifISO');" role="button" aria-label="<?php echo localize('aria_exif');?>"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifISO" class="form-control textinput" value="<?php echo$r['exifISO'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifISO" placeholder="<?php echo localize('Enter an ').' '.localize('ISO');?>..." role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveexifISO" class="btn btn-secondary save" data-dbid="exifISO" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-14" class="form-group row">
                <label for="exifti" class="col-form-label col-sm-2"><?php echo localize('Taken');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifti" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-btn"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifti');" role="button" aria-label="<?php echo localize('aria_exif');?>"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifti" class="form-control textinput" value="<?php echo$r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'';?>" placeholder="Select the Date/Time Image was Taken... (fix)" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifti" role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveexifti" class="btn btn-secondary save" data-dbid="exifti" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            </fieldset>
            <fieldset id="tab-content-images-15" class="control-fieldset">
              <legend class="control-legend"><?php echo localize('Image Attribution');?></legend>
              <div id="tab-content-images-16" class="form-group row">
                <label for="attributionImageTitle" class="col-form-label col-sm-2"><?php echo localize('Title');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageTitle" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageTitle" placeholder="<?php echo localize('Enter a ').' '.localize('Title');?>..." role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveattributionImageTitle" class="btn btn-secondary save" data-dbid="attributionImageTitle" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-17" class="form-group row">
                <label for="attributionImageName" class="col-form-label col-sm-2"><?php echo localize('Name');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageName" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageName" list="attributionImageName_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageName" placeholder="<?php echo localize('Enter a ').' '.localize('Name');?>..." role="textbox">
                  <datalist id="attributionImageName_option">
                    <?php $s=$db->query("SELECT DISTINCT attributionImageName AS name FROM `".$prefix."content` UNION SELECT DISTINCT name AS name FROM content UNION SELECT DISTINCT name AS name FROM login ORDER BY name ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveattributionImageName" class="btn btn-secondary save" data-dbid="attributionImageName" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-18" class="form-group row">
                <label for="attributionImageURL" class="col-form-label col-sm-2"><?php echo localize('URL');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageURL" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageURL" placeholder="<?php echo localize('Enter a ').' '.localize('URL');?>..." role="textbox">
                  <datalist id="attributionImageURL_option">
                    <?php $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM `".$prefix."content` ORDER BY attributionImageURL ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveattributionImageURL" class="btn btn-secondary save" data-dbid="attributionImageURL" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            </fieldset>
          </div>
<?php /* Media */ ?>
          <div id="tab-content-media" class="tab-pane" role="tabpanel">
            <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php" role="form">
              <input type="hidden" name="act" value="add_media">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="content">
              <div class="form-group">
                <div class="input-group">
                  <input id="mediafile" type="text" class="form-control" name="fu" value="" placeholder="<?php echo localize('placeholder_media');?>..." role="textbox">
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','media','mediafile');return false;" data-tooltip="tooltip" title="<?php echo localize('Open Media Manager');?>" role="button" aria-label="<?php echo localize('aria_file_mediamanager');?>"><?php svg('libre-gui-browse-media');?></button></div>
                  <div class="input-group-append"><button type="submit" class="btn btn-secondary add" onclick="" data-tooltip="tooltip" title="<?php echo localize('Add');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button></div>
                </div>
              </div>
            </form>
            <div class="container">
              <div id="mi" class="row">
<?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE file!='' AND pid=:id ORDER BY ord ASC");
$sm->execute([':id'=>$r['id']]);
if($sm->rowCount()>0){
  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
    if(file_exists('media/thumbs/'.substr(basename($rm['file']),0,-4).'.png'))
      $thumb='media/thumbs/'.substr(basename($rm['file']),0,-4).'.png';
    else
      $thumb=$rm['file'];?>
                <div id="mi_<?php echo$rm['id'];?>" class="media-gallery d-inline-block col-6 col-sm-2 position-relative p-0 m-1 mt-0">
                  <a class="card bg-dark m-0" href="<?php echo$rm['file'];?>" data-lightbox="media">
                    <img src="<?php echo$thumb;?>" class="card-img" alt="Media <?php echo$rm['id'];?>">
                  </a>
                  <div class="btn-group float-right">
                    <div class="handle btn btn-secondary btn-sm" onclick="return false;" data-tooltip="tooltip" title="<?php echo localize('Drag to ReOrder this item');?>" aria-label="<?php echo localize('aria_drag');?>"><?php svg('libre-gui-drag');?></div>
                    <button class="btn btn-secondary trash btn-sm" onclick="purge('<?php echo$rm['id'];?>','media')" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                  </div>
                </div>
<?php }?>
                <script>
                  $('#mi').sortable({
                    items:".media-gallery",
                    placeholder:".ghost",
                    helper:fixWidthHelper,
                    update:function(e,ui){
                      var order=$("#mi").sortable("serialize");
                      $.ajax({
                        type:"POST",
                        dataType:"json",
                        url:"core/reordermedia.php",
                        data:order
                      });
                    }
                  }).disableSelection();
                  function fixWidthHelper(e,ui){
                    ui.children().each(function(){
                      $(this).width($(this).width());
                    });
                    return ui;
                  }
                  $('[data-lightbox="media"]').simpleLightbox();
                </script>
<?php }?>
              </div>
            </div>
          </div>
<?php /* Options */ ?>
          <div id="tab-content-options" class="tab-pane<?php echo($r['contentType']!='inventory'?' hidden':'');?>" role="tabpanel">
            <fieldset class="control-fieldset">
              <div class="form-group">
                <form target="sp" method="post" action="core/add_data.php" role="form">
                  <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="act" value="add_option">
                  <div class="input-group">
                    <div class="input-group-text"><?php echo localize('Option');?></div>
                    <input type="text" class="form-control" name="ttl" value="" placeholder="<?php echo localize('Enter a ').' '.localize('Title');?>..." role="textbox">
                    <div class="input-group-text"><?php echo localize('Quantity');?></div>
                    <input type="text" class="form-control" name="qty" value="" placeholder="<?php echo localize('Quantity');?>" role="textbox">
                    <div class="input-group-append"><button class="btn btn-secondary add" data-tooltip="tooltip" title="<?php echo localize('Add');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button></div>
                  </div>
                </form>
              </div>
              <div id="itemoptions">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE rid=:rid ORDER BY title ASC");
$ss->execute([':rid'=>$r['id']]);
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div id="l_<?php echo $rs['id'];?>" class="form-group row">
                  <div class="input-group col-xs-12">
                    <div class="input-group-text"><?php echo localize('Option');?></div>
                    <input type="text" class="form-control" value="<?php echo$rs['title'];?>" onchange="update('<?php echo$rs['id'];?>','choices,'title',$(this).val());" placeholder="<?php echo localize('Enter a ').' '.localize('Title');?>..." role="textbox">
                    <div class="input-group-text"><?php echo localize('Quantity');?></div>
                    <input type="text" class="form-control" value="<?php echo$rs['ti'];?>" onchange="update('<?php echo$rs['id'];?>','choices,'ti',$(this).val());" placeholder="<?php echo localize('Quantity');?>..." role="textbox">
                    <div class="input-group-append">
                      <form target="sp" action="core/purge.php" role="form">
                        <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                        <input type="hidden" name="t" value="choices">
                        <button class="btn btn-secondary trash" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                      </form>
                    </div>
                  </div>
                </div>
<?php }?>
              </div>
            </fieldset>
          </div>
<?php /* Comments */ ?>
          <div id="tab-content-comments" class="tab-pane<?php echo($r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'');?>" role="tabpanel">
            <div class="form-group row">
              <label for="options1" class="col-form-label col-sm-2"><?php echo localize('Enable Comments');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options1" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="1" role="checkbox"<?php echo$r['options']{1}==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
              </div>
            </div>
            <div id="comments" class="clearfix">
<?php $sc=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE contentType=:contentType AND rid=:rid ORDER BY ti ASC");
$sc->execute([':contentType'=>$r['contentType'],':rid'=>$r['id']]);
while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
              <div id="l_<?php echo$rc['id'];?>" class="media mb-3 p-3 border-bottom border-dark<?php echo$rc['status']=='unapproved'?' danger':'';?>">
<?php $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
  $su->execute([':id'=>$rc['uid']]);
  $ru=$su->fetch(PDO::FETCH_ASSOC);?>
                <img class="align-self-start mr-3 bg-white img-circle" style="max-width:64px;height:64px;" src="<?php if($ru['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$ru['avatar']))echo'media'.DS.'avatar'.DS.$ru['avatar'];elseif($ru['gravatar']!='')echo md5($ru['gravatar']);else echo ADMINNOAVATAR;?>" alt="<?php echo$rc['name'];?>">
                <div class="media-body">
                  <div id="controls-<?php echo$rc['id'];?>" class="btn-group float-right">
<?php $scc=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");
  $scc->execute([':ip'=>$rc['ip']]);
  if($scc->rowCount()<1){?>
                    <form id="blacklist<?php echo$rc['id'];?>" class="d-inline-block" target="sp" method="post" action="core/add_commentblacklist.php" role="form">
                      <input type="hidden" name="id" value="<?php echo$rc['id'];?>">
                      <button class="btn btn-secondary btn-sm" data-tooltip="tooltip" title="<?php echo localize('Add IP to Blacklist');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php echo svg2('libre-gui-security');?></button>
                    </form>
<?php }?>
                    <button id="approve_<?php echo$rc['id'];?>" class="btn btn-secondary btn-sm add<?php echo$rc['status']!='unapproved'?' hidden':'';?>" onclick="update('<?php echo$rc['id'];?>','comments','status','approved')" data-tooltip="tooltip" title="<?php echo localize('Approve');?>" role="button" aria-label="<?php echo localize('aria_approve');?>"><?php svg('libre-gui-approve');?></button>
                    <button class="btn btn-secondary btn-sm trash" onclick="purge('<?php echo$rc['id'];?>','comments')" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                  </div>
                  <h6 class="media-heading"><?php echo localize('Name');?>: <?php echo$rc['name']==''?'Anonymous':$rc['name'].' &lt;'.$rc['email'].'&gt;';?></h6>
                  <time class="small"><?php echo date($config['dateFormat'],$rc['ti']);?></time><br>
                  <?php echo strip_tags($rc['notes']);?>
                </div>
              </div>
<?php }?>
            </div>
            <iframe name="comments" id="comments" class="hidden"></iframe>
            <form role="form" target="comments" method="post" action="core/add_data.php" role="form">
              <input type="hidden" name="act" value="add_comment">
              <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
              <input type="hidden" name="contentType" value="<?php echo$r['contentType'];?>">
              <div class="form-group row">
                <label for="commentemail" class="col-form-label col-sm-2"><?php echo localize('Email');?></label>
                <div class="input-group col-sm-10"><input type="text" id="commentemail" class="form-control" name="email" value="<?php echo$user['email'];?>" role="textbox"></div>
              </div>
              <div class="form-group row">
                <label for="commentname" class="col-form-label col-sm-2"><?php echo localize('Name');?></label>
                <div class="input-group col-sm-10"><input type="text" id="commentname" class="form-control" name="name" value="<?php echo$user['name'];?>" role="textbox"></div>
              </div>
              <div class="form-group row">
                <label for="commentda" class="col-form-label col-sm-2"><?php echo localize('Comment');?></label>
                <div class="input-group col-sm-10">
                  <textarea id="commentda" class="form-control" name="da" placeholder="<?php echo localize('Enter a ').' '.localize('Comment');?>..." required role="textbox"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-2"></label>
                <div class="input-group col-sm-10">
                  <button class="btn btn-secondary btn-block add" role="button" aria-label="<?php echo localize('aria_add');?>"><?php echo localize('Add Comment');?></button>
                </div>
              </div>
            </form>
          </div>
<?php /* Reviews */ ?>
          <div id="tab-content-reviews" class="tab-pane<?php echo($r['contentType']=='testimonials'||$r['contentType']=='event'||$r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='news'||$r['contentType']=='portfolio'||$r['contentType']=='proof'?' hidden':'');?>" role="tabpanel">
<?php $sr=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE contentType='review' AND rid=:rid ORDER BY ti DESC");
$sr->execute([':rid'=>$r['id']]);
while($rr=$sr->fetch(PDO::FETCH_ASSOC)){?>
            <div id="l_<?php echo$rr['id'];?>" class="media<?php echo$rr['status']=='unapproved'?' danger':'';?>">
              <div class="media-body well p-1 p-sm-3 border-top border-dark">
                <div id="controls-<?php echo$rr['id'];?>" class="btn-group float-right" role="group">
                  <button id="approve_<?php echo$rr['id'];?>" class="btn btn-secondary btn-sm<?php echo$rr['status']=='approved'?' hidden':'';?>" onclick="update('<?php echo$rr['id'];?>','comments','status','approved')" data-tooltip="tooltip" title="<?php echo localize('Approve');?>" role="button" aria-label="<?php echo localize('aria_approve');?>"><?php svg('libre-gui-approve');?></button>
                  <button class="btn btn-secondary btn-sm trash" onclick="purge('<?php echo$rr['id'];?>','comments')" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                </div>
                <h6 class="media-heading" role="heading">
                  <span class="rat d-block d-sm-inline-block">
                    <span<?php echo($rr['cid']>=1?' class="set"':'');?>></span>
                    <span<?php echo($rr['cid']>=2?' class="set"':'');?>></span>
                    <span<?php echo($rr['cid']>=3?' class="set"':'');?>></span>
                    <span<?php echo($rr['cid']>=4?' class="set"':'');?>></span>
                    <span<?php echo($rr['cid']==5?' class="set"':'');?>></span>
                  </span>
                  <?php echo$rr['name']==''?'Anonymous':$rr['name'].' &lt;'.$rr['email'].'&gt; on '.date($config['dateFormat'],$rr['ti']);?>
                </h6>
                <p><?php echo$rr['notes'];?></p>
              </div>
            </div>
<?php }?>
          </div>
<?php /* SEO */ ?>
          <div id="tab-content-seo" class="tab-pane" role="tabpanel">
            <div id="tab-content-seo-1" class="form-group row">
              <label for="views" class="col-form-label col-sm-2"><?php echo localize('Views');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="views" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="views"<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <div class="input-group-append"><button class="btn btn-secondary trash" onclick="$('#views').val('0');update('<?php echo$r['id'];?>','content','views','0');" data-tooltip="tooltip" title="<?php echo localize('Clear');?>" role="button" aria-label="<?php echo localize('aria_clear');?>"><?php svg('libre-gui-eraser');?></button></div>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveviews" class="btn btn-secondary save" data-dbid="views" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-right"><?php echo localize('help_metarobots');?></div>
            <div class="form-group row">
              <label for="metaRobots" class="col-form-label col-sm-2"><?php echo localize('Meta Robots');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="metaRobots" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'metaRobots']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="metaRobots" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-gui-lightbulb','','green').'</button></div>':'';}?>
                <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="metaRobots" placeholder="<?php echo localize('Enter a ').' '.localize('Robots Option as Below');?>..." role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="metaRobots" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savemetaRobots" class="btn btn-secondary save" data-dbid="metaRobots" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="tab-content-seo-2" class="form-group row<?php echo($r['contentType']=='proofs'?' hidden':'');?>">
              <label for="schemaType" class="col-form-label col-sm-2"><?php echo localize('Schema Type');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="schemaType" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="schemaType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','schemaType',$(this).val());"<?php echo$user['options']{1}==0?' disabled':'';?> data-tooltip="tooltip" title="<?php echo localize('Schema for Microdata Content');?>" role="listbox">
                  <option value="blogPosting"<?php echo$r['schemaType']=='blogPosting'?' selected':'';?>><?php echo localize('schema_blogposting');?></option>
                  <option value="Offer"<?php echo$r['schemaType']=='Offer'?' selected':'';?>><?php echo localize('schema_product');?> (Product/Inventory)</option>
                  <option value="Service"<?php echo$r['schemaType']=='Service'?' selected':'';?>><?php echo localize('schema_service');?></option>
                  <option value="ImageGallery"<?php echo$r['schemaType']=='ImageGallery'?' selected':'';?>><?php echo localize('schema_imagegallery');?></option>
                  <option value="Review"<?php echo$r['schemaType']=='Review'?' selected':'';?>><?php echo localize('schema_review');?></option>
                  <option value="NewsArticle"<?php echo$r['schemaType']=='NewsArticle'?' selected':'';?>><?php echo localize('schema_newsarticle');?></option>
                  <option value="Event"<?php echo$r['schemaType']=='Event'?' selected':'';?>><?php echo localize('schema_event');?></option>
                  <option value="CreativeWork"<?php echo$r['schemaType']=='CreativeWork'?' selected':'';?>><?php echo localize('schema_creativework');?></option>
                </select>
              </div>
            </div>
            <div class="help-block small text-right"><?php echo localize('help_seotitle');?></div>
            <div class="form-group row">
              <label for="seoTitle" class="col-form-label col-sm-2"><?php echo localize('SEO Title');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoTitle" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=70-strlen($r['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-text"><span id="seoTitlecnt" class="text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span></div>
                <div class="input-group-prepend"><button class="btn btn-secondary" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-tooltip="tooltip" title="<?php echo localize('Remove Stop Words');?>" role="button" aria-label="<?php echo localize('aria_seo_stopwords');?>"><?php svg('libre-gui-magic');?></button></div>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoTitle']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-dbgid="seoTitle" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoTitle" placeholder="<?php echo localize('Enter an ').' '.localize('SEO Title');?>..." role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-dbgid="seoTitle" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoTitle" class="btn btn-secondary save" data-dbid="seoTitle" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-right"><?php echo localize('help_seocaption');?></div>
            <div id="tab-content-seo-3" class="form-group row">
              <label for="seoCaption" class="col-form-label col-sm-2"><?php echo localize('Caption');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoCaption" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($r['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-text"><span id="seoCaptioncnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></span></div>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoCaption']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-dbgid="seoCaption" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoCaption" placeholder="<?php echo localize('Enter a ').' '.localize('Caption');?>..."<?php echo($user['options']{1}==0?' readonly':'');?> role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-dbgid="seoCaption" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoCaption" class="btn btn-secondary save" data-dbid="seoCaption" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-right"><?php echo localize('help_seodescription');?></div>
            <div id="tab-content-seo-4" class="form-group row">
              <label for="seoDescription" class="col-form-label col-sm-2"><?php echo localize('Description');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoDescription" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($r['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-text"><span id="seoDescriptioncnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></span></div>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoDescription']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-dbgid="seoDescription" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoDescription" placeholder="<?php echo localize('Enter a ').' '.localize('Description');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-dbgid="seoDescription" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoDescription" class="btn btn-secondary save" data-dbid="seoDescription" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="tab-content-seo-5" class="form-group row<?php echo$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="seoKeywords" class="col-form-label col-sm-2"><?php echo localize('Keywords');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoKeywords" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoKeywords']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-dbgid="seoKeywords" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoKeywords" placeholder="<?php echo localize('Enter ').' '.localize('Keywords');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-dbgid="seoKeywords" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoKeywords" class="btn btn-secondary save" data-dbid="seoKeywords" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="tab-content-seo-6" class="form-group row">
              <label for="tags" class="col-form-label col-sm-2"><?php echo localize('Tags');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="tags" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="Tags Fingerprint Analysis" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'tags']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-dbgid="tags" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';
                }?>
                <input type="text" id="tags" class="form-control textinput" value="<?php echo$r['tags'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tags" placeholder="<?php echo localize('Enter ').' '.localize('Tags');?>..."<?php echo$user['options']{1}==0?' readonly':'';?> role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-dbgid="tags" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savetags" class="btn btn-secondary save" data-dbid="tags" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
          </div>
<?php /* Settings */ ?>
          <div id="tab-content-settings" class="tab-pane" role="tabpanel">
            <div id="tab-content-settings-1" class="form-group row">
              <label for="status" class="col-form-label col-sm-2"><?php echo localize('Status');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="status" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php echo$user['options']{1}==0?' readonly':'';?> data-tooltip="tooltip" title="Change Status" role="listbox">
                  <option value="unpublished"<?php echo$r['status']=='unpublished'?' selected':'';?>><?php echo localize('Unpublished');?></option>
                  <option value="published"<?php echo$r['status']=='published'?' selected':'';?>><?php echo localize('Published');?></option>
                  <option value="delete"<?php echo$r['status']=='delete'?' selected':'';?>><?php echo localize('Delete');?></option>
                </select>
              </div>
            </div>
            <div id="tab-content-settings-2" class="form-group row">
              <label for="stockStatus" class="col-form-label col-sm-2"><?php echo localize('Stock').' '.localize('Status');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="stockStatus" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="stockStatus" class="form-control" onchange="update('<?php echo$r['id'];?>','content','stockStatus',$(this).val());"<?php echo$user['options']{1}==0?' readonly':'';?> data-tooltip="tooltip" title="<?php echo localize('Change Stock Status');?>" role="listbox">
                  <option value="quantity"<?php echo$r['stockStatus']=='quantity'?' selected':''?>><?php echo localize('stock_quantity');?></option>
                  <option value="in stock"<?php echo$r['stockStatus']=='in stock'?' selected':'';?>><?php echo localize('stock_instock');?></option>
                  <option value="out of stock"<?php echo$r['status']=='out of stock'?' selected':'';?>><?php echo localize('stock_outofstock');?></option>
                  <option value="pre-order"<?php echo$r['status']=='pre-order'?' selected':'';?>><?php echo localize('stock_preorder');?></option>
                  <option value="available"<?php echo$r['stockStatus']=='available'?' selected':'';?>><?php echo localize('stock_available');?></option>
                  <option value="none"<?php echo($r['stockStatus']=='none'||$r['stockStatus']=='')?' selected':'';?>><?php echo localize('stock_none');?></option>
                </select>
              </div>
            </div>
            <div id="tab-content-settings-3" class="form-group row">
              <label for="contentType" class="col-form-label col-sm-2"><?php echo localize('contentType');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="contentType" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="contentType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','contentType',$(this).val());"<?php echo$user['options']{1}==0?' disabled':'';?> data-tooltip="tooltip" title="<?php echo localize('Change the Type of Content this Item belongs to');?>" role="listbox">
                  <option value="article"<?php echo$r['contentType']=='article'?' selected':'';?>><?php echo localize('Article');?></option>
                  <option value="portfolio"<?php echo$r['contentType']=='portfolio'?' selected':'';?>><?php echo localize('Portfolio');?></option>
                  <option value="events"<?php echo$r['contentType']=='events'?' selected':'';?>><?php echo localize('Event');?></option>
                  <option value="news"<?php echo$r['contentType']=='news'?' selected':'';?>><?php echo localize('News');?></option>
                  <option value="testimonials"<?php echo$r['contentType']=='testimonials'?' selected':'';?>><?php echo localize('Testimonial');?></option>
                  <option value="inventory"<?php echo$r['contentType']=='inventory'?' selected':'';?>><?php echo localize('Inventory');?></option>
                  <option value="service"<?php echo$r['contentType']=='service'?' selected':'';?>><?php echo localize('Service');?></option>
                  <option value="gallery"<?php echo$r['contentType']=='gallery'?' selected':'';?>><?php echo localize('Gallery');?></option>
                  <option value="proofs"<?php echo$r['contentType']=='proofs'?' selected':'';?>><?php echo localize('Proof');?></option>
                </select>
              </div>
            </div>
            <div id="tab-content-settings-4" class="form-group row<?php echo$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="featured0" class="col-form-label col-sm-2"><?php echo localize('Featured');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="featured0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0" role="checkbox"<?php echo($r['featured']{0}==1?' checked aria-checked="true"':' aria-checked="false"');?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
              </div>
            </div>
            <div id="tab-content-settings-5" class="form-group row<?php echo$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="internal0" class="col-form-label check col-sm-2"><?php echo localize('Internal');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="internal0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0" role="checkbox"<?php echo$r['internal']==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
              </div>
            </div>
            <div id="tab-content-settings-6" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='gallery'||$r['contentType'] == 'proofs'?' hidden':'';?>">
              <label for="bookable0" class="col-form-label col-sm-2"><?php echo localize('Bookable');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="bookable0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="bookable" data-dbb="0" role="checkbox"<?php echo$r['bookable']==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
              </div>
            </div>
<?php /*
            <div class="form-group row">
              <label for="mid" class="col-form-label col-sm-2">SubMenu</label>
              <div class="input-group col-sm-10">
                <select id="mid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','mid',$(this).val());" role="listbox">
                  <option value="0"<?php if($r['mid']==0)echo' selected';?>>None</option>
                  <?php $sm=$db->prepare("SELECT id,title from menu WHERE mid=0 AND mid!=:mid AND active=1 ORDER BY ord ASC, title ASC");$sm->execute([':mid'=>$r['id']]);while($rm=$sm->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rm['id'].'"'.($r['mid']==$rm['id']?' selected':'').'>'.$rm['title'].'</option>';?>
                </select>
              </div>
            </div>
*/ ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  $('#menu-<?php echo$r['contentType'];?>').addClass('active');
</script>
