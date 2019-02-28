<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Edit Content
 *
 * edit_content.php version 2.0.0
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
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/content/type/'.$r['contentType'];?>"><?php echo ucfirst($r['contentType']).(in_array($r['contentType'],array('article'))?'s':'');?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><span id="titleupdate"><?php echo$r['title'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
<?php if($help['content_edit_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['content_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['content_edit_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['content_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li id="nav-content-content" class="nav-item" role="presentation"><a class="nav-link active" href="#tab-content-content" aria-controls="tab-content-content" role="tab" data-toggle="tab">Content</a></li>
          <li id="nav-content-images" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-images" aria-controls="tab-content-images" role="tab" data-toggle="tab">Images</a></li>
          <li id="nav-content-media" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-media" aria-controls="tab-content-media" role="tab" data-toggle="tab">Media</a></li>
          <li id="nav-content-options" class="nav-item<?php echo$r['contentType']!='inventory'?' hidden':'';?>" role="presentation"><a class="nav-link" href="#tab-content-options" aria-controls="tab-content-options" role="tab" data-toggle="tab">Options</a></li>
          <li id="nav-content-comments" class="nav-item<?php echo$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'';?>" role="presentation"><a class="nav-link" href="#tab-content-comments" aria-controls="tab-content-comments" role="tab" data-toggle="tab">Comments</a></li>
          <li id="nav-content-reviews" class="nav-item<?php echo$r['contentType']=='testimonials'||$r['contentType']=='event'||$r['contentType']=='article'||$r['contentType']=='gallery'||$r['contentType']=='news'||$r['contentType']=='portfolio'||$r['contentType']=='proof'?' hidden':'';?>" role="presentation"><a class="nav-link" href="#tab-content-reviews" aria-controls="tab-content-reviews" role="tab" data-toggle="tab">Reviews</a></li>
          <li id="nav-content-seo" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-seo" aria-controls="tab-content-seo" role="tab" data-toggle="tab">SEO</a></li>
          <li id="nav-content-settings" class="nav-item" role="presentation"><a class="nav-link" href="#tab-content-settings" aria-controls="tab-content-settings" role="tab" data-toggle="tab">Settings</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-content-content" class="tab-pane active" role="tabpanel">
            <div class="help-block small text-muted text-right">Content MUST contain a Title, or it won't be accessible.</div>
            <div id="nav-content-content-1" class="form-group row">
              <label for="title" class="col-form-label col-sm-2">Title</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="title" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'title']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="title">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="title" data-bs="btn-danger" placeholder="Content MUST contain a title or it won't be accessible..." onkeyup="genurl();$('#titleupdate').text($(this).val());">
                <?php echo$user['rank']>899?'<div class="input-group-btn" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="title">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savetitle" class="btn btn-secondary save" data-dbid="title" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
              <script>
                function genurl(){
                  var data=$('#title').val().toLowerCase();
                  var url="<?php echo URL.$r['contentType'];?>/"+data.replace(/ /g,"-");
                  $('#genurl').attr('href',url);
                  $('#genurl').html(url);
                }
              </script>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-2">Generated URL</label>
              <div class="input-group col-sm-10">
                <div class="input-group-text text-truncate col-sm-12">
                  <a id="genurl" target="_blank" href="<?php echo URL.$r['contentType'].'/'.strtolower(str_replace(' ','-',$r['title']));?>"><?php echo URL.$r['contentType'].'/'.strtolower(str_replace(' ','-',$r['title']));?></a>
                </div>
              </div>
            </div>
            <div id="nav-content-content-2" class="form-group row">
              <label for="ti" class="col-form-label col-sm-2">Created</label>
              <div class="input-group col-sm-10"><input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly></div>
            </div>
            <div id="nav-content-content-3" class="form-group row<?php echo$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="pti" class="col-form-label col-sm-2">Published On</label>
              <div class="input-group col-sm-10">
                <input type="text" id="pti" class="form-control textinput" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="pti" value="<?php echo date('M n, Y g:i A',$r['pti']);?>">
                <input type="hidden" id="ptix" value="<?php echo$r['pti'];?>">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savepti" class="btn btn-secondary save" data-dbid="pti" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-4" class="form-group row">
              <label for="eti" class="col-form-label col-sm-2">Edited</label>
              <div class="input-group col-sm-10"><input type="text" id="eti" class="form-control" value="<?php echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?>" readonly></div>
            </div>
            <div id="nav-content-content-5" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="cid" class="col-form-label col-sm-2">Client</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="cid" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="cid" class="form-control"<?php echo$user['options']{1}==0?' disabled':'';?> onchange="update('<?php echo$r['id'];?>','content','cid',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid">
                  <option value="0">Select Client</option>
<?php $cs=$db->query("SELECT * FROM `".$prefix."login` ORDER BY name ASC, username ASC");
while($cr=$cs->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$cr['id'].'"'.($r['cid']==$cr['id']?' selected':'').'>'.$cr['username'].':'.$cr['name'].'</option>';?>
                </select>
              </div>
            </div>
            <div id="nav-content-content-6" class="form-group row<?php echo$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'?' hidden':'';?>">
              <label for="author" class="col-form-label col-sm-2">Author</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="uid" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="uid" class="form-control"<?php echo$user['options']{1}==0?' disabled':'';?> onchange="update('<?php echo$r['id'];?>','content','uid',$(this).val());" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="uid">
<?php $su=$db->query("SELECT id,username,name FROM `".$prefix."login` WHERE username!='' AND status!='delete' ORDER BY username ASC, name ASC");
while($ru=$su->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$ru['id'].'"'.($ru['id']==$r['uid']?' selected':'').'>'.$ru['username'].':'.$ru['name'].'</option>';?>
                </select>
              </div>
            </div>
            <div id="nav-content-content-7" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="code" class="col-form-label col-sm-2">Code</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="code" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="code" class="form-control textinput" value="<?php echo$r['code'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="code" placeholder="Enter a Code..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savecode" class="btn btn-secondary save" data-dbid="code" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-8" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="barcode" class="col-form-label col-sm-2">Barcode</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-toggle="popover" data-dbgid="barcode" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="barcode" class="form-control textinput" value="<?php echo$r['barcode'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="barcode" placeholder="Enter a Barcode..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savebarcode" class="btn btn-secondary save" data-dbid="barcode" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right"><a target="_blank" href="https://fccid.io/">fccid.io</a> for more information or to look up an FCC ID.</div>
            <div id="nav-content-content-9" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="fccid" class="col-form-label col-sm-2">FCCID</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="fccid" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="fccid" class="form-control textinput" value="<?php echo$r['fccid'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fccid" placeholder="Enter an FCC ID..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savefccid" class="btn btn-secondary save" data-dbid="fccid" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-10" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="brand" class="col-form-label col-sm-2">Brand</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="brand" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="brand" list="brand_options" class="form-control textinput" value="<?php echo$r['brand'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="brand" placeholder="Enter a Brand..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <datalist id="brand_options">
<?php $s=$db->query("SELECT DISTINCT brand FROM `".$prefix."content` WHERE brand!='' ORDER BY brand ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['brand'].'"/>';?>
                </datalist>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savebrand" class="btn btn-secondary save" data-dbid="brand" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-11" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="tis" class="col-form-label col-sm-2">Event Start</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="tis" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="tis" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" data-datetime="<?php echo date($config['dateFormat'],$r['tis']);?>" autocomplete="off"<?php echo$user['options']{1}==0?' readonly':'';?>>
                <input type="hidden" id="tisx" value="<?php echo$r['tis'];?>">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savetis" class="btn btn-secondary save" data-dbid="tis" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-12" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="tie" class="col-form-label col-sm-2">Event End</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="tie" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="tie" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" data-datetime="<?php echo date($config['dateFormat'],$r['tie']);?>" autocomplete="off"<?php echo$user['options']{1}==0?' readonly':'';?>>
                <input type="hidden" id="tiex" value="<?php echo$r['tie'];?>">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savetie" class="btn btn-secondary save" data-dbid="tie" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
<?php echo$r['ip']!=''?'<div class="help-block small text-muted text-right">'.$r['ip'].'</div>':'';?>
            <div id="nav-content-content-13" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="email" class="col-form-label col-sm-2">Email</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="email" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="Enter an Email..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-14" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="name" class="col-form-label col-sm-2">Name</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="name" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="name" list="name_options" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="Enter a Name..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <datalist id="name_options">
<?php $s=$db->query("SELECT DISTINCT name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."login` ORDER BY name ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['name'].'"/>';?>
                </datalist>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savename" class="btn btn-secondary save" data-dbid="name" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-15" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="url" class="col-form-label col-sm-2">URL</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-toggle="popover" data-dbgid="url" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="url" placeholder="Enter a URL..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveurl" class="btn btn-secondary save" data-dbid="url" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-16" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='news'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="business" class="col-form-label col-sm-2">Business</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-toggle="popover" data-dbgid="business" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="Enter a Business..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-17" class="form-group row<?php echo$r['contentType']=='testimonials'?' hidden':'';?>">
              <label for="category_1" class="col-form-label col-sm-2">Category Primary</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="category_1" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input id="category_1" list="category_1_options" type="text" class="form-control textinput" value="<?php echo$r['category_1'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_1" placeholder="Enter a Category/Select from List..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <datalist id="category_1_options">
<?php $s=$db->query("SELECT DISTINCT category_1 FROM `".$prefix."content` WHERE category_1!='' ORDER BY category_1 ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['category_1'].'"/>';?>
                </datalist>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savecategory_1" class="btn btn-secondary save" data-dbid="category_1" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-18" class="form-group row<?php echo$r['contentType']=='testimonials'?' hidden':'';?>">
              <label for="category_2" class="col-form-label col-sm-2">Category Secondary</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="category_2" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input id="category_2" list="category_2_options" type="text" class="form-control textinput" value="<?php echo$r['category_2'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="category_2" placeholder="Enter a Category/Select from List..."<?php echo($user['options']{1}==0?' readonly':'');?>>
                <datalist id="category_2_options">
<?php $s=$db->query("SELECT DISTINCT category_2 FROM `".$prefix."content` WHERE category_2!='' ORDER BY category_2 ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['category_2'].'"/>';?>
                </datalist>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savecategory_2" class="btn btn-secondary save" data-dbid="category_2" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-19" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="cost" class="col-form-label col-sm-2">Cost</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="cost" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <div class="input-group-text">$</div>
                <input type="text" id="cost" class="form-control textinput" value="<?php echo$r['cost'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cost" placeholder="Enter a Cost..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savecost" class="btn btn-secondary save" data-dbid="cost" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-20" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="options0" class="col-form-label col-sm-2">Show Cost</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="0"<?php echo($r['options']{0}==1?' checked':'');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div id="nav-content-content-21" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="quantity" class="col-form-label col-sm-2">Quantity</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="quantity" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="quantity" class="form-control textinput" value="<?php echo $r['quantity'];?>" data-dbid="<?php echo $r['id'];?>" data-dbt="content" data-dbc="quantity" placeholder="Enter a Quantity..."<?php echo$user['options']{1}==0?' readonly':'';?>>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savequantity" class="btn btn-secondary save" data-dbid="quantity" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="nav-content-content-22" class="form-group">
              <div class="card-header col-sm-12 position-relative" style="padding:0;">
                <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="notesda" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button>':'';
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'notes']);
  echo$ss->rowCount()>0?'<div data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="notesda">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}
echo$user['rank']>899?'<div class="float-right" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary btn-sm addsuggestion" data-dbgid="notesda">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes"></div>
                <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="t" value="content">
                  <input type="hidden" name="c" value="notes">
                  <textarea id="notes" class="summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
                </form>
              </div>
            </div>
            <fieldset id="nav-content-content-23" class="control-fieldset<?php echo$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='service'||$r['contentType']=='gallery'||$r['contentType']=='proofs'?' hidden':'';?>">
              <legend class="control-legend">Content Attribution</legend>
              <div id="nav-content-content-24" class="form-group row">
                <label for="attributionContentName" class="col-form-label col-sm-2">Name</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionContentName" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionContentName" list="attributionContentName_option" class="form-control textinput" value="<?php echo$r['attributionContentName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionContentName" placeholder="Enter a Name...">
                  <datalist id="attributionContentName_option">
<?php $s=$db->query("SELECT DISTINCT attributionContentName AS name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."login` ORDER BY name ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['name'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionContentName" class="btn btn-secondary save" data-dbid="attributionContentName" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="nav-content-content-25" class="form-group row">
                <label for="attributionContentURL" class="col-form-label col-sm-2">URL</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionContentURL" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionContentURL" list="attributionContentURL_option" class="form-control textinput" value="<?php echo$r['attributionContentURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionContentURL" placeholder="Enter a URL...">
                  <datalist id="attributionContentURL_option">
<?php $s=$db->query("SELECT DISTINCT attributionContentUrl as url FROM `".$prefix."content` ORDER BY attributionContentURL ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['url'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionContentURL" class="btn btn-secondary save" data-dbid="attributionContentURL" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            </fieldset>
          </div>
<?php /* Images */ ?>
          <div id="tab-content-images" class="tab-pane" role="tabpanel">
            <div id="error"></div>
            <fieldset id="tab-content-images-1" class="control-fieldset<?php echo$r['contentType']!='testimonials'?' hidden':'';?>">
              <div id="tstavinfo" class="alert alert-info<?php echo$r['cid']==0?' hidden':'';?>">Currently using the Avatar associated with the chosen Client Account.</div>
              <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php" onsubmit="Pace,restart();">
                <div class="form-group row">
                  <label for="avatar" class="col-form-label col-sm-2">Avatar</label>
                  <div class="input-group col-sm-10">
                    <input type="text" id="av" class="form-control" value="<?php echo$r['file'];?>" readonly data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="avatar">
                    <div class="input-group-append">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <input type="hidden" name="act" value="add_tstavatar">
                      <div class="btn btn-secondary custom-file" data-tooltip="tooltip" title="Browse Computer for Image.">
                        <input id="avatarfu" type="file" class="custom-file-input hidden" name="fu" onchange="form.submit()">
                        <label for="avatarfu"><?php svg('libre-gui-browse-computer');?></label>
                      </div>
                    </div>
                    <div class="input-group-append img"><img id="tstavatar" src="<?php echo$r['file']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['file']))?'media'.DS.'avatar'.DS.basename($r['file']):ADMINNOAVATAR;?>"></div>
                    <div class="input-group-append"><button class="btn btn-secondary trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','file','');" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button></div>
                  </div>
                </div>
              </form>
            </fieldset>
            <fieldset id="tab-content-images-2" class="control-fieldset<?php echo$r['contentType']=='testimonials'?' hidden':'';?>">
              <div id="tab-content-images-3" class="form-group row">
                <label for="file" class="col-form-label col-sm-2">URL</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="fileURL" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="fileURL" class="form-control textinput" value="<?php echo$r['fileURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="fileURL" placeholder="Enter a URL...">
                  <div class="input-group-append img"><?php echo$r['fileURL']!=''?'<a href="'.$r['fileURL'].'" data-featherlight="image"><img id="thumbimage" src="'.$r['fileURL'].'"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'">';?></div>
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savefileURL" class="btn btn-secondary save" data-dbid="fileURL" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-4" class="form-group row">
                <label class="col-form-label col-sm-2"></label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="file" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input id="file" type="text" class="form-control" value="<?php echo$r['file'];?>" readonly>
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','content','file');" data-tooltip="tooltip" title="Open Media Manager"><?php svg('libre-gui-browse-media');?></button></div>
                  <form target="sp" method="post" action="core/magicimage.php">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="act" value="file">
                    <div class="input-group-append"><button class="btn btn-secondary" data-tooltip="tooltip" title="Resize Image (<?php echo$config['mediaMaxWidth'].'x'.$config['mediaMaxHeight'];?>)"><?php svg('libre-gui-magic');?></button></div>
                  </form>
                  <div class="input-group-append img"><?php echo$r['file']!=''?'<a href="'.$r['file'].'" data-featherlight="image"><img id="thumbimage" src="'.$r['file'].'"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'">';?></div>
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','file');" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-5" class="form-group row">
                <label for="thumb" class="col-form-label col-sm-2">Thumbnail</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="thumb" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input id="thumb" type="text" class="form-control" value="<?php echo$r['thumb'];?>" readonly>
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','content','thumb');"data-tooltip="tooltip" title="Open Media Manager"><?php svg('libre-gui-browse-media');?></button></div>
                  <form target="sp" method="post" action="core/magicimage.php">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="act" value="thumb">
                    <div class="input-group-append"><button class="btn btn-secondary" data-tooltip="tooltip" title="Create Thumnbail From Above Image (<?php echo$config['mediaMaxWidthThumb'].'x'.$config['mediaMaxHeightThumb'];?>)"><?php svg('libre-gui-magic');?></button></div>
                  </form>
                  <div class="input-group-append img"><?php echo$r['thumb']!=''?'<a href="'.$r['thumb'].'" data-featherlight="image"><img id="thumbimage" src="'.$r['thumb'].'"></a>':'<img id="thumbimage" src="'.ADMINNOIMAGE.'">';?></div>
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="imageUpdate('<?php echo$r['id'];?>','content','thumb');" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button></div>
                </div>
              </div>
            </fieldset>
            <fieldset id="tab-content-images-6" class="control-fieldset">
              <legend class="control-legend">Exif Information</legend>
              <div class="help-block small text-muted text-right">Using the <span class="btn btn-secondary btn-sm"><?php svg('libre-gui-magic');?></span> will attempt to get the EXIF Information embedded in the Uploaded Image.</div>
              <div id="tab-content-images-7" class="form-group row">
                <label for="exifFilename" class="col-form-label col-sm-2">Original Filename</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifFilename" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifFilename');"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifFilename" class="form-control textinput" value="<?php echo$r['exifFilename'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFilename" placeholder="Original Filename...">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveexifFilename" class="btn btn-secondary save" data-dbid="exifFilename" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-8" class="form-group row">
                <label for="exifCamera" class="col-form-label col-sm-2">Camera</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifCamera" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifCamera');"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifCamera" class="form-control textinput" value="<?php echo$r['exifCamera'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifCamera" placeholder="Enter Camera Brand...">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveexifCamera" class="btn btn-secondary save" data-dbid="exifCamera" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-9" class="form-group row">
                <label for="exifLens" class="col-form-label col-sm-2">Lens</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifLens" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifLens');"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifLens" class="form-control textinput" value="<?php echo$r['exifLens'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifLens" placeholder="Enter Lens...">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveexifLens" class="btn btn-secondary save" data-dbid="exifLens" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-10" class="form-group row">
                <label for="exifAperture" class="col-form-label col-sm-2">Aperture</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifAperture" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifAperture');"><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button></div>
                  <input type="text" id="exifAperture" class="form-control textinput" value="<?php echo$r['exifAperture'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifAperture" placeholder="Enter Aperture/FStop...">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveexifAperture" class="btn btn-secondary save" data-dbid="exifAperture" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-11" class="form-group row">
                <label for="exifFocalLength" class="col-form-label col-sm-2">Focal Length</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifFocalLength" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifFocalLength');"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifFocalLength" class="form-control textinput" value="<?php echo$r['exifFocalLength'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifFocalLength" placeholder="Enter Focal Length...">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveexifFocalLength" class="btn btn-secondary save" data-dbid="exifFocalLength" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-12" class="form-group row">
                <label for="exifShutterSpeed" class="col-form-label col-sm-2">Shutter Speed</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifShutterSpeed" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifShutterSpeed');"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifShutterSpeed" class="form-control textinput" value="<?php echo$r['exifShutterSpeed'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifShutterSpeed" placeholder="Enter Shutter Speed...">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveexifShutterSpeed" class="btn btn-secondary save" data-dbid="exifShutterSpeed" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-13" class="form-group row">
                <label for="exifISO" class="col-form-label col-sm-2">ISO</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifISO" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-prepend"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifISO');"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifISO" class="form-control textinput" value="<?php echo$r['exifISO'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifISO" placeholder="Enter ISO...">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveexifISO" class="btn btn-secondary save" data-dbid="exifISO" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-14" class="form-group row">
                <label for="exifti" class="col-form-label col-sm-2">Taken</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="exifti" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <div class="input-group-btn"><button class="btn btn-secondary" onclick="getExif('<?php echo$r['id'];?>','content','exifti');"><?php svg('libre-gui-magic');?></button></div>
                  <input type="text" id="exifti" class="form-control textinput" value="<?php echo$r['exifti']!=0?date($config['dateFormat'],$r['exifti']):'';?>" placeholder="Select the Date/Time Image was Taken..." data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="exifti">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveexifti" class="btn btn-secondary save" data-dbid="exifti" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            </fieldset>
            <fieldset id="tab-content-images-15" class="control-fieldset">
              <legend class="control-legend">Image Attribution</legend>
              <div id="tab-content-images-16" class="form-group row">
                <label for="attributionImageTitle" class="col-form-label col-sm-2">Title</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageTitle" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageTitle" list="attributionImageTitle_option" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageTitle" placeholder="Enter a Title...">
                  <datalist id="attributionImageTitle_option">
<?php $s=$db->query("SELECT DISTINCT attributionImageTitle FROM `".$prefix."content` ORDER BY attributionImageTitle ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['attributionImageTitle'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionImageTitle" class="btn btn-secondary save" data-dbid="attributionImageTitle" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-17" class="form-group row">
                <label for="attributionImageName" class="col-form-label col-sm-2">Name</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageName" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageName" list="attributionImageName_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageName" placeholder="Enter a Name...">
                  <datalist id="attributionImageName_option">
<?php $s=$db->query("SELECT DISTINCT attributionImageName AS name FROM `".$prefix."content` UNION SELECT DISTINCT name AS name FROM content UNION SELECT DISTINCT name AS name FROM login ORDER BY name ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['name'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionImageName" class="btn btn-secondary save" data-dbid="attributionImageName" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div id="tab-content-images-18" class="form-group row">
                <label for="attributionImageURL" class="col-form-label col-sm-2">URL</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageURL" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="attributionImageURL" placeholder="Enter a URL...">
                  <datalist id="attributionImageURL_option">
<?php $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM `".$prefix."content` ORDER BY attributionImageURL ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['url'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionImageURL" class="btn btn-secondary save" data-dbid="attributionImageURL" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            </fieldset>
          </div>
<?php /* Media */ ?>
          <div id="tab-content-media" class="tab-pane" role="tabpanel">
            <div class="help-block small text-muted text-right">Media uploaded can be used for Image Gallery's, Featured Content, or depending on how they are used in the Theme's Template.</div>
            <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
              <input type="hidden" name="act" value="add_media">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="content">
              <div class="form-group">
                <div class="input-group">
                  <input id="mediafile" type="text" class="form-control" name="fu" value="" placeholder="Enter a URL, or Select Images using the Browse Media Button...">
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','media','mediafile');return false;" data-tooltip="tooltip" title="Open Media Manager"><?php svg('libre-gui-browse-media');?></button></div>
                  <div class="input-group-append"><button type="submit" class="btn btn-secondary add" onclick="" data-tooltip="tooltip" title="Add"><?php svg('libre-gui-plus');?></button></div>
                </div>
              </div>
            </form>
            <ul id="media_items">
<?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE file!='' AND pid=0 AND rid=:id ORDER BY ord ASC");
$sm->execute([':id'=>$r['id']]);
while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
  list($width,$height)=getimagesize($rm['file']);?>
              <li id="media_items_<?php echo$rm['id'];?>" class="col-xs-6 col-sm-3">
                <div class="panel panel-default media">
                  <div class="controls btn-group">
                    <span class="handle btn btn-default btn-xs"><?php svg('libre-gui-drag');?></span>
                    <button class="btn btn-default btn-xs media-edit" data-dbid="<?php echo$rm['id'];?>" data-tooltip="tooltip" title="Edit"><?php svg('libre-gui-edit');?></button>
                    <button class="btn btn-default trash btn-xs" onclick="purge('<?php echo$rm['id'];?>','media')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                  </div>
                  <div class="panel-body">
                    <a href="<?php echo$rm['file'];?>" data-srcset="<?php echo$rm['file'];?> <?php echo$width;?>w" data-fancybox="gallery" data-width="<?php echo$width;?>" data-height="<?php echo$height;?>" data-caption="<?php echo$rm['title'].($rm['seoCaption']!=''?' - '.$rm['seoCaption']:'');?>"><img src="<?php echo$rm['file'];?>" alt=""></a>
                  </div>
                  <div id="media-title<?php echo$rm['id'];?>" class="panel-footer"><?php echo$rm['title'];?></div>
                </div>
              </li>
<?php }?>
            </ul>
          </div>
<?php /* Options */ ?>
          <div id="tab-content-options" class="tab-pane<?php echo($r['contentType']!='inventory'?' hidden':'');?>" role="tabpanel">
            <fieldset class="control-fieldset">
              <div class="form-group">
                <form target="sp" method="post" action="core/add_data.php">
                  <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="act" value="add_option">
                  <div class="input-group">
                    <div class="input-group-text">Option</div>
                    <input type="text" class="form-control" name="ttl" value="" placeholder="Enter an Option Title...">
                    <div class="input-group-text">Quantity</div>
                    <input type="text" class="form-control" name="qty" value="" placeholder="Quantity">
                    <div class="input-group-append"><button class="btn btn-secondary add" data-tooltip="tooltip" title="Add"><?php svg('libre-gui-plus');?></button></div>
                  </div>
                </form>
              </div>
              <div id="itemoptions">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE rid=:rid ORDER BY title ASC");
$ss->execute([':rid'=>$r['id']]);
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                <div id="l_<?php echo $rs['id'];?>" class="form-group row">
                  <div class="input-group col-xs-12">
                    <div class="input-group-text">Option</div>
                    <input type="text" class="form-control" value="<?php echo$rs['title'];?>" onchange="update('<?php echo$rs['id'];?>','choices,'title',$(this).val());" placeholder="Enter an Option Title...">
                    <div class="input-group-text">Quantity</div>
                    <input type="text" class="form-control" value="<?php echo$rs['ti'];?>" onchange="update('<?php echo$rs['id'];?>','choices,'ti',$(this).val());" placeholder="Quantity...">
                    <div class="input-group-append">
                      <form target="sp" action="core/purge.php">
                        <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                        <input type="hidden" name="t" value="choices">
                        <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
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
              <label for="options1" class="col-form-label col-sm-2">Enable Comments</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options1" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="options" data-dbb="1"<?php echo$r['options']{1}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div id="comments" class="clearfix">
<?php $sc=$db->prepare("SELECT * FROM `".$prefix."comments` WHERE contentType=:contentType AND rid=:rid ORDER BY ti ASC");
$sc->execute([':contentType'=>$r['contentType'],':rid'=>$r['id']]);
while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
              <div id="l_<?php echo$rc['id'];?>" class="media mb-3 p-3 border-bottom<?php echo$rc['status']=='unapproved'?' danger':'';?>">
<?php $su=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
  $su->execute([':id'=>$rc['uid']]);
  $ru=$su->fetch(PDO::FETCH_ASSOC);?>
                <img class="align-self-start mr-3 bg-white img-circle" style="max-width:64px;height:64px;" src="<?php if($ru['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$ru['avatar']))echo'media'.DS.'avatar'.DS.$ru['avatar'];elseif($ru['gravatar']!='')echo md5($ru['gravatar']);else echo ADMINNOAVATAR;?>">
                <div class="media-body">
                  <div id="controls-<?php echo$rc['id'];?>" class="btn-group float-right">
<?php $scc=$db->prepare("SELECT ip FROM `".$prefix."iplist` WHERE ip=:ip");
  $scc->execute([':ip'=>$rc['ip']]);
  if($scc->rowCount()<1){?>
                    <form id="blacklist<?php echo$rc['id'];?>" class="d-inline-block" target="sp" method="post" action="core/add_commentblacklist.php">
                      <input type="hidden" name="id" value="<?php echo$rc['id'];?>">
                      <button class="btn btn-secondary btn-sm" data-tooltip="tooltip" title="Add this Commenters IP to the Blacklist."><?php echo svg2('libre-gui-security');?></button>
                    </form>
<?php }?>
                    <button id="approve_<?php echo$rc['id'];?>" class="btn btn-secondary btn-sm add<?php echo$rc['status']!='unapproved'?' hidden':'';?>" onclick="update('<?php echo$rc['id'];?>','comments','status','approved')" data-tooltip="tooltip" title="Approve"><?php svg('libre-gui-approve');?></button>
                    <button class="btn btn-secondary btn-sm trash" onclick="purge('<?php echo$rc['id'];?>','comments')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                  </div>
                  <h6 class="media-heading">Name: <?php echo$rc['name'];?></h6>
                  <time><small class="text-muted"><?php echo date($config['dateFormat'],$rc['ti']);?></small></time><br>
                  <?php echo strip_tags($rc['notes']);?>
                </div>
              </div>
<?php }?>
            </div>
            <iframe name="comments" id="comments" class="hidden"></iframe>
            <form role="form" target="comments" method="post" action="core/add_data.php">
              <input type="hidden" name="act" value="add_comment">
              <input type="hidden" name="rid" value="<?php echo$r['id'];?>">
              <input type="hidden" name="contentType" value="<?php echo$r['contentType'];?>">
              <div class="form-group row">
                <label for="email" class="col-form-label col-sm-2">Email</label>
                <div class="input-group col-sm-10"><input type="text" class="form-control" name="email" value="<?php echo$user['email'];?>"></div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-form-label col-sm-2">Name</label>
                <div class="input-group col-sm-10"><input type="text" class="form-control" name="name" value="<?php echo$user['name'];?>"></div>
              </div>
              <div class="form-group row">
                <label for="da" class="col-form-label col-sm-2">Comment</label>
                <div class="input-group col-sm-10">
                  <textarea id="da" class="form-control" name="da" placeholder="Enter a Comment..." required></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-2"></label>
                <div class="input-group col-sm-10">
                  <button class="btn btn-secondary btn-block add">Add Comment</button>
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
              <div class="media-body well">
                <span class="rat">
                  <span<?php echo($rr['cid']==5?' class="set"':'');?>>☆</span>
                  <span<?php echo($rr['cid']==4?' class="set"':'');?>>☆</span>
                  <span<?php echo($rr['cid']==3?' class="set"':'');?>>☆</span>
                  <span<?php echo($rr['cid']==2?' class="set"':'');?>>☆</span>
                  <span<?php echo($rr['cid']==1?' class="set"':'');?>>☆</span>
                </span>
                <div id="controls-<?php echo$rr['id'];?>" class="btn-group float-right">
                  <button id="approve_<?php echo$rr['id'];?>" class="btn btn-secondary btn-sm<?php echo$rr['status']=='approved'?' hidden':'';?>" onclick="update('<?php echo$rr['id'];?>','comments','status','approved')" data-tooltip="tooltip" title="Approve"><?php svg('libre-gui-approve');?></button>
                  <button class="btn btn-secondary btn-sm trash" onclick="purge('<?php echo$rr['id'];?>','comments')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                </div>
                <h6 class="media-heading"><?php echo$rr['name'].', '.date($config['dateFormat'],$rr['ti']);?></h6>
                <p><?php echo$rr['notes'];?></p>
              </div>
            </div>
<?php }?>
          </div>
<?php /* SEO */ ?>
          <div id="tab-content-seo" class="tab-pane" role="tabpanel">
            <div id="tab-content-seo-1" class="form-group row">
              <label for="views" class="col-form-label col-sm-2">Views</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="views" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="views"<?php echo$user['options']{1}==0?' readonly':'';?>>
                <div class="input-group-append"><button class="btn btn-secondary trash" onclick="$('#views').val('0');update('<?php echo$r['id'];?>','content','views','0');" data-tooltip="tooltip" title="Clear"><?php svg('libre-gui-eraser');?></button></div>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveviews" class="btn btn-secondary save" data-dbid="views" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">Options for Meta Robots: <span data-tooltip="tooltip" title="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="tooltip" title="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="tooltip" title="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="tooltip" title="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="tooltip" title="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>, <span data-tooltip="tooltip" title="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="tooltip" title="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="tooltip" title="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="tooltip" title="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="tooltip" title="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="tooltip" title="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></div>
            <div class="form-group row">
              <label for="metaRobots" class="col-form-label col-sm-2">Meta Robots</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="metaRobots" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'metaRobots']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="metaRobots">'.svg2('libre-gui-gui-lightbulb','','green').'</button></div>':'';}?>
                <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="metaRobots" placeholder="Enter a Robots Option as Below...">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="metaRobots">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savemetaRobots" class="btn btn-secondary save" data-dbid="metaRobots" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="tab-content-seo-2" class="form-group row<?php echo($r['contentType']=='proofs'?' hidden':'');?>">
              <label for="schemaType" class="col-form-label col-sm-2">Schema Type</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="schemaType" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="schemaType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','schemaType',$(this).val());"<?php echo$user['options']{1}==0?' disabled':'';?> data-tooltip="tooltip" title="Schema for Microdata Content." data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="schemaType">
                  <option value="blogPosting"<?php echo$r['schemaType']=='blogPosting'?' selected':'';?>>blogPosting for Articles</option>
                  <option value="Product"<?php echo$r['schemaType']=='Product'?' selected':'';?>>Product for Inventory</option>
                  <option value="Service"<?php echo$r['schemaType']=='Service'?' selected':'';?>>Service for Services</option>
                  <option value="ImageGallery"<?php echo$r['schemaType']=='ImageGallery'?' selected':'';?>>ImageGallery for Gallery Images</option>
                  <option value="Review"<?php echo$r['schemaType']=='Review'?' selected':'';?>>Review for Testimonials</option>
                  <option value="NewsArticle"<?php echo$r['schemaType']=='NewsArticle'?' selected':'';?>>NewsArticle for News</option>
                  <option value="Event"<?php echo$r['schemaType']=='Event'?' selected':'';?>>Event for Events</option>
                  <option value="CreativeWork"<?php echo$r['schemaType']=='CreativeWork'?' selected':'';?>>CreativeWork for Portfolio/Proofs</option>
                </select>
              </div>
            </div>
            <div class="help-block small text-muted text-right">The recommended character count for Title's is 70.</div>
            <div class="form-group row">
              <label for="seoTitle" class="col-form-label col-sm-2">SEO Title</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoTitle" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=70-strlen($r['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-text"><span id="seoTitlecnt" class="text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span></div>
                <div class="input-group-prepend"><button class="btn btn-secondary" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-tooltip="tooltip" title="Remove Stop Words."><?php svg('libre-gui-magic');?></button></div>
<?php if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoTitle']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="seoTitle">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoTitle">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoTitle" class="btn btn-secondary save" data-dbid="seoTitle" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">The recommended character count for Captions is 160, as sometime Captions may be used in Descriptions.</div>
            <div id="tab-content-seo-3" class="form-group row">
              <label for="seoCaption" class="col-form-label col-sm-2">Caption</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoCaption" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($r['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-text"><span id="seoCaptioncnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></span></div>
<?php if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoCaption']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="seoCaption">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoCaption" placeholder="Enter a Caption..."<?php echo($user['options']{1}==0?' readonly':'');?>>
<?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoCaption">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoCaption" class="btn btn-secondary save" data-dbid="seoCaption" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">The recommended character count for Descriptions is 160.</div>
            <div id="tab-content-seo-4" class="form-group row">
              <label for="seoDescription" class="col-form-label col-sm-2">Description</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoDescription" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($r['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-text"><span id="seoDescriptioncnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></span></div>
<?php if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoDescription']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="seoDescription">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoDescription" placeholder="Enter a Description..."<?php echo$user['options']{1}==0?' readonly':'';?>>
<?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoDescription">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoDescription" class="btn btn-secondary save" data-dbid="seoDescription" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="tab-content-seo-5" class="form-group row<?php echo$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="seoKeywords" class="col-form-label col-sm-2">Keywords</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoKeywords" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'seoKeywords']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="seoKeywords">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="seoKeywords" placeholder="Enter Keywords..."<?php echo$user['options']{1}==0?' readonly':'';?>>
<?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoKeywords">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoKeywords" class="btn btn-secondary save" data-dbid="seoKeywords" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div id="tab-content-seo-6" class="form-group row">
              <label for="tags" class="col-form-label col-sm-2">Tags</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="tags" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'content',':c'=>'tags']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="tags">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';
}?>
                <input type="text" id="tags" class="form-control textinput" value="<?php echo$r['tags'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tags" placeholder="Enter Tags..."<?php echo$user['options']{1}==0?' readonly':'';?>>
<?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="tags">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savetags" class="btn btn-secondary save" data-dbid="tags" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
          </div>
<?php /* Settings */ ?>
          <div id="tab-content-settings" class="tab-pane" role="tabpanel">
            <div id="tab-content-settings-1" class="form-group row">
              <label for="status" class="col-form-label col-sm-2">Status</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="status" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php echo$user['options']{1}==0?' readonly':'';?> data-tooltip="tooltip" title="Change Status" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="status">
                  <option value="unpublished"<?php echo$r['status']=='unpublished'?' selected':'';?>>Unpublished</option>
                  <option value="published"<?php echo$r['status']=='published'?' selected':'';?>>Published</option>
                  <option value="delete"<?php echo$r['status']=='delete'?' selected':'';?>>Delete</option>
                </select>
              </div>
            </div>
            <div id="tab-content-settings-2" class="form-group row">
              <label for="stockStatus" class="col-form-label col-sm-2">Stock Status</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="stockStatus" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="stockStatus" class="form-control" onchange="update('<?php echo$r['id'];?>','content','stockStatus',$(this).val());"<?php echo$user['options']{1}==0?' readonly':'';?> data-tooltip="tooltip" title="Change Stock Status" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="stockStatus">
                  <option value="quantity"<?php echo$r['stockStatus']=='quantity'?' selected':''?>>Dependant on Quantity (In Stock/Out Of Stock)</option>
                  <option value="in stock"<?php echo$r['stockStatus']=='in stock'?' selected':'';?>>In Stock</option>
                  <option value="out of stock"<?php echo$r['status']=='out of stock'?' selected':'';?>>Out Of Stock</option>
                  <option value="pre-order"<?php echo$r['status']=='pre-order'?' selected':'';?>>Pre-Order</option>
                  <option value="available"<?php echo$r['stockStatus']=='available'?' selected':'';?>>Available</option>
                  <option value="none"<?php echo($r['stockStatus']=='none'||$r['stockStatus']=='')?' selected':'';?>>No Display</option>
                </select>
              </div>
            </div>
            <div id="tab-content-settings-3" class="form-group row">
              <label for="contentType" class="col-form-label col-sm-2">Content Type</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="contentType" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="contentType" class="form-control" onchange="update('<?php echo$r['id'];?>','content','contentType',$(this).val());"<?php echo$user['options']{1}==0?' disabled':'';?> data-tooltip="tooltip" title="Change the Type of Content this Item belongs to." data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="contentType">
                  <option value="article"<?php echo$r['contentType']=='article'?' selected':'';?>>Article</option>
                  <option value="portfolio"<?php echo$r['contentType']=='portfolio'?' selected':'';?>>Portfolio</option>
                  <option value="events"<?php echo$r['contentType']=='events'?' selected':'';?>>Event</option>
                  <option value="news"<?php echo$r['contentType']=='news'?' selected':'';?>>News</option>
                  <option value="testimonials"<?php echo$r['contentType']=='testimonials'?' selected':'';?>>Testimonial</option>
                  <option value="inventory"<?php echo$r['contentType']=='inventory'?' selected':'';?>>Inventory</option>
                  <option value="service"<?php echo$r['contentType']=='service'?' selected':'';?>>Service</option>
                  <option value="gallery"<?php echo$r['contentType']=='gallery'?' selected':'';?>>Gallery</option>
                  <option value="proofs"<?php echo$r['contentType']=='proofs'?' selected':'';?>>Proof</option>
                </select>
              </div>
            </div>
            <div id="tab-content-settings-4" class="form-group row<?php echo$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='proofs'?' hidden':'';?>">
              <label for="featured0" class="col-form-label col-sm-2">Featured</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="featured0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="featured" data-dbb="0"<?php echo($r['featured']{0}==1?' checked':'');?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div id="tab-content-settings-5" class="form-group row<?php echo$r['contentType']=='portfolio'||$r['contentType']=='events'||$r['contentType']=='testimonials'||$r['contentType']=='gallery'?' hidden':'';?>">
              <label for="internal0" class="col-form-label check col-sm-2">Internal</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="internal0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="internal" data-dbb="0"<?php echo$r['internal']==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div id="tab-content-settings-6" class="form-group row<?php echo$r['contentType']=='article'||$r['contentType']=='portfolio'||$r['contentType']=='news'||$r['contentType']=='testimonials'||$r['contentType']=='inventory'||$r['contentType']=='gallery'||$r['contentType'] == 'proofs'?' hidden':'';?>">
              <label for="bookable0" class="col-form-label col-sm-2">Bookable</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="bookable0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="bookable" data-dbb="0"<?php echo$r['bookable']==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <?php /*
            <div class="form-group">
              <label for="mid" class="control-label col-xs-5 col-sm-3 col-lg-2">SubMenu</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <select id="mid" class="form-control" onchange="update('<?php echo$r['id'];?>','content','mid',$(this).val());" data-dbid-"<?php echo$r['id'];?>" data-dbt="menu" data-dbc="mid">
                  <option value="0"<?php if($r['mid']==0)echo' selected';?>>None</option>
<?php $sm=$db->prepare("SELECT id,title from menu WHERE mid=0 AND mid!=:mid AND active=1 ORDER BY ord ASC, title ASC");
$sm->execute([':mid'=>$r['id']]);
while($rm=$sm->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rm['id'].'"';if($r['mid']==$rm['id'])echo' selected';echo'>'.$rm['title'].'</option>';?>
                </select>
              </div>
            </div> */ ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  $('#menu-<?php echo$r['contentType'];?>').addClass('active');
</script>
