<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2018
 *
 * Administration - Edit Pages
 *
 * edit_pages.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Pages - Edit
 * @package    core/layout/edit_pages.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 * @changes    v2.0.1 Fix Media
 * @changes    v2.0.1 Add Dropdown for Other Pages
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix Media Display, adding and removal.
 * @changes    v2.0.2 Fix Selection not updating.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE id=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php echo localize('Content');?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>"><?php echo localize('Pages');?></a></li>
    <li class="breadcrumb-item"><?php echo localize('Edit');?></li>
    <li class="breadcrumb-item active">
      <span id="titleupdate"><?php echo$r['title'];?></span>
<?php $so=$db->prepare("SELECT id,title FROM menu WHERE id!=:id ORDER BY ord ASC, title ASC");
$so->execute([
  ':id'=>$r['id']
]);
if($so->rowCount()>0){
      echo'<a class="btn btn-ghost-normal dropdown-toggle m-0 p-0 pl-2 pr-2 text-white" data-toggle="dropdown" href="'.URL.$settings['system']['admin'].'/pages'.'" aria-haspopup="true" aria-expanded="false"></a><div class="dropdown-menu">';
  while($ro=$so->fetch(PDO::FETCH_ASSOC)){
      echo'<a class="dropdown-item small pt-1 pb-1" href="'.URL.$settings['system']['admin'].'/pages/edit/'.$ro['id'].'">'.$ro['title'].'</a>';
  }
      echo'</div>';
}?>
    </li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="<?php echo localize('Settings');?>">
        <a class="btn btn-ghost-normal info" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Back');?>" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <?php if($help['pages_edit_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['pages_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['pages_edit_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['pages_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="nav-item"><a class="nav-link active" href="#tab-page-content" aria-controls="tab-page-content" role="tab" data-toggle="tab"><?php echo localize('Content');?></a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-images" aria-controls="tab-page-images" role="tab" data-toggle="tab"><?php echo localize('Images');?></a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-media" aria-controls="tab-page-media" role="tab" data-toggle="tab"><?php echo localize('Media');?></a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-seo" aria-controls="tab-page-seo" role="tab" data-toggle="tab"><?php echo localize('SEO');?></a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-settings" aria-controls="tab-page-settings" role="tab" data-toggle="tab"><?php echo localize('Settings');?></a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-page-content" class="tab-pane active" role="tabpanel">
            <div class="form-group row">
              <label for="title" class="col-form-label col-sm-2"><?php echo localize('Title');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="title" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
                if($r['suggestions']==1){$ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'title']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-dbgid="title" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" placeholder="<?php echo localize('Enter a ').' '.localize('Title');?>..." onkeyup="genurl();$('#titleupdate').text($(this).val());" role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion hidden-xs" data-dbgid="title" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savetitle" class="btn btn-secondary save" data-dbid="title" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
              <script>
                function genurl(){
                  var data=$('#title').val().toLowerCase();
                  var url="<?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'');?>"+data.replace(/ /g,"-");
                  $('#genurl').attr('href',url);
                  $('#genurl').html(url);
                }
              </script>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-2"><?php echo localize('URL Slug');?></label>
              <div class="input-group col-sm-10">
                <div class="input-group-text  text-truncate col-sm-12">
                  <a id="genurl" target="_blank" href="<?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?>"><?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?></a>
                </div>
              </div>
            </div>
            <div class="help-block small text-muted text-right"><?php echo localize('Edited');?>: <?php echo$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></div>
            <div class="form-group row">
              <div class="card-header col-12 position-relative p-0">
                <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="notesda" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button>':'';
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'notes']);
                  echo$ss->rowCount()>0?'<span data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary btn-sm suggestions" data-dbgid="notesda" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></span>':'';
                }
                echo$user['rank']>899?'<span class="float-right" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary btn-sm addsuggestion" data-dbgid="notesda" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></span>':'';?>
                <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
                <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php" role="form">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="t" value="menu">
                  <input type="hidden" name="c" value="notes">
                  <textarea id="notes" class="form-control summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes" name="da" readonly role="textbox"><?php echo rawurldecode($r['notes']);?></textarea>
                </form>
              </div>
            </div>
          </div>
          <div id="tab-page-images" class="tab-pane" role="tabpanel">
            <fieldset class="control-fieldset">
              <legend class="control-legend" role="heading"><?php echo localize('Cover');?></legend>
              <div class="form-group row">
                <label for="coverURL" class="col-form-label col-sm-2"><?php echo localize('URL');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="coverURL" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="coverURL" class="form-control image" value="<?php echo$r['coverURL'];?>" onchange="coverUpdate('<?php echo$r['id'];?>','menu','coverURL',$(this).val());" placeholder="<?php echo localize('Enter ').localize('Cover').' '.localize('URL');?>..." role="textbox">
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverURL','');" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="cover" class="col-form-label col-sm-2"><?php echo localize('Image');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="cover" data-tooltip="tooltip" title="Fingerprint Analysis" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="cover" class="form-control" name="feature_image" value="<?php echo$r['cover'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="cover" readonly role="textbox">
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','menu','cover');" data-tooltip="tooltip" title="<?php echo localize('Open Media Manager');?>" role="button" aria-label="<?php echo localize('aria_file_mediamanager');?>"><?php svg('libre-gui-browse-media');?></button></div>
                  <div class="input-group-append img">
                    <?php if($r['cover']!='')
                      echo'<a href="'.$r['cover'].'" data-simplelightbox="image"><img id="coverimage" class="bg-white" src="'.$r['cover'].'" alt="'.$r['title'].'"></a>';
                    elseif($r['coverURL']!='')
                      echo'<a href="'.$r['coverURL'].'" data-simplelightbox="image"><img id="coverimage" class="bg-white" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
                    elseif($r['coverURL'] != '')
                      echo'<a href="'.$r['coverURL'].'" data-simplelightbox="image"><img id="coverimage" class="bg-white" src="'.$r['coverURL'].'" alt="'.$r['title'].'"></a>';
                    else
                      echo'<img id="coverimage" class="bg-white" src="'.ADMINNOIMAGE.'" alt="'.$r['title'].'">';?>
                  </div>
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','cover','');" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button></div>
                </div>
              </div>
              <script>
                $('[data-simplelightbox="image"]').simpleLightbox();
              </script>
              <div class="form-group row">
                <label for="coverVideo" class="col-form-label col-sm-2"><?php echo localize('Video URL');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="coverVideo" data-tooltip="tooltip" title="Fingerprint Analysis" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="coverVideo" class="form-control" name="feature_image" value="<?php echo$r['coverVideo'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="coverVideo" readonly role="textbox">
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','menu','coverVideo');" data-tooltip="tooltip" title="<?php echo localize('Open Media Manager');?>" role="button" aria-label="<?php echo localize('aria_file_mediamanager');?>"><?php svg('libre-gui-browse-media');?></button></div>
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverVideo','');" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button></div>
                </div>
              </div>
            </fieldset>
            <fieldset class="control-fieldset">
              <legend class="control-legend" role="heading"><?php echo localize('Image Attribution');?></legend>
              <div class="form-group row">
                <label for="attributionImageTitle" class="col-form-label col-sm-2"><?php echo localize('Title');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageTitle" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle" placeholder="<?php echo localize('Enter a ').' '.localize('Title');?>..." role="textbox">
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveattributionImageTitle" class="btn btn-secondary save" data-dbid="attributionImageTitle" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="attributionImageName" class="col-form-label col-sm-2"><?php echo localize('Name');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageName" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageName" list="attributionImageTitle_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName" placeholder="<?php echo localize('Enter a ').' '.localize('Name');?>..." role="textbox">
                  <datalist id="attributionImageTitle_option">
                    <?php $s=$db->query("SELECT DISTINCT attributionImageTitle AS name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."login` ORDER BY name ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveattributionImageName" class="btn btn-secondary save" data-dbid="attributionImageName" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="attributionImageURL" class="col-form-label col-sm-2"><?php echo localize('URL');?></label>
                <div class="input-group col-sm-10">
                  <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageURL" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL" placeholder="<?php echo localize('Enter a ').' '.localize('URL');?>..." role="textbox">
                  <datalist id="attributionImageURL_option">
                    <?php $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM `".$prefix."content` ORDER BY url ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveattributionImageURL" class="btn btn-secondary save" data-dbid="attributionImageURL" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            </fieldset>
          </div>
          <div id="tab-page-media" class="tab-pane" role="tabpanel">
            <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php" role="form">
              <input type="hidden" name="act" value="add_media">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="pages">
              <div class="form-group">
                <div class="input-group">
                  <input id="file" type="text" class="form-control" name="fu" value="" placeholder="<?php echo localize('placeholder_media');?>..." role="textbox">
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','media','file');return false;" data-tooltip="tooltip" title="<?php echo localize('Open Media Manager');?>" role="button" aria-label="<?php echo localize('aria_file_mediamanager');?>"><?php svg('libre-gui-browse-media');?></button></div>
                  <div class="input-group-append"><button type="submit" class="btn btn-secondary add" data-tooltip="tooltip" title="<?php echo localize('Add');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button></div>
                </div>
              </div>
            </form>
            <div class="container">
              <div id="mi" class="row">
<?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE file!='' AND rid=0 AND pid=:id ORDER BY ord ASC");
$sm->execute([':id'=>$r['id']]);
if($sm->rowCount()>0){
  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
    if(file_exists('media/thumbs/'.substr(basename($rm['file']),0,-4).'.png'))
      $thumb='media/thumbs/'.substr(basename($rm['file']),0,-4).'.png';
    else
      $thumb=$rm['file'];?>
                <div id="mi_<?php echo$rm['id'];?>" class="media col-6 col-sm-3">
                  <a href="<?php echo$rm['file'];?>" data-lightbox="media"><img class="card-img" src="<?php echo$thumb;?>" alt="Media"></a>
                  <div class="card-image-overlay position-relative">
                    <div class="controls btn-group">
                      <span class="handle btn btn-secondary btn-xs" role="button" aria-label="<?php echo localize('aria_drag');?>"><?php svg('libre-gui-drag');?></span>
                      <button class="btn btn-secondary trash btn-xs" onclick="purge('<?php echo$rm['id'];?>','media')" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                    </div>
                  </div>
                </div>
<?php }?>
                <script>
                  $('#mi').sortable({
                    items:".media",
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
          <div id="tab-page-seo" class="tab-pane" role="tabpanel">
            <div class="form-group row">
              <label for="views" class="col-form-label col-sm-2"><?php echo localize('Views');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="views" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="number" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="views" role="textbox">
                <div class="input-group-addon"><button class="btn btn-secondary trash" onclick="$('#views').val('0');update('<?php echo$r['id'];?>','menu','views','0');" data-tooltip="tooltip" title="<?php echo localize('Clear');?>" role="button" aria-label="<?php echo localize('aria_clear');?>"><?php svg('libre-gui-eraser');?></button></div>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveviews" class="btn btn-secondary save" data-dbid="views" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right"><?php echo localize('help_metarobots');?></div>
            <div class="form-group row">
              <label for="metaRobots" class="col-form-label col-sm-2"><?php echo localize('Meta Robots');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-append"><button class="btn btn-secondary fingerprint" data-dbgid="metaRobots" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'metaRobots']);
                  echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-dbgid="metaRobots" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="metaRobots" placeholder="<?php echo localize('Enter ').' '.localize('Meta Robots').' '.localize('Options');?>..." role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-dbgid="metaRobots" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savemetaRobots" class="btn btn-secondary save" data-dbid="metaRobots" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right"><?php echo localize('help_seotitle');?></div>
            <div class="form-group row">
              <label for="seoTitle" class="col-form-label col-sm-2"><?php echo localize('SEO Title');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoTitle" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=70-strlen($r['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-prepend"><span id="seoTitlecnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span></div>
                <div class="input-group-prepend"><button class="btn btn-secondary" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-tooltip="tooltip" title="<?php echo localize('Remove Stop Words');?>" role="button" aria-label="<?php echo localize('aria_seo_stopwords');?>"><?php svg('libre-gui-magic');?></button></div>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoTitle']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-dbgid="seoTitle" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" placeholder="<?php echo localize('Enter an ').' '.localize('SEO Title');?>..." role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="seoTitle" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoTitle" class="btn btn-secondary save" data-dbid="seoTitle" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right"><?php echo localize('help_seodescription');?></div>
            <div class="form-group row">
              <label for="seoDescription" class="col-form-label col-sm-2"><?php echo localize('SEO').' '.localize('Description');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoDescription" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($r['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-prepend"><span id="seoDescriptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span></div>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoDescription']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="seoDescription" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" placeholder="<?php echo localize('Enter a ').' '.localize('Description');?>..." role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="seoDescription" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoDescription" class="btn btn-secondary save" data-dbid="seoDescription" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right"><?php echo localize('help_seocaption');?></div>
            <div class="form-group row">
              <label for="seoCaption" class="col-form-label col-sm-2"><?php echo localize('SEO').' '.localize('Caption');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoCaption" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($r['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-prepend"><span id="seoCaptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span></div>
                <?php if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoCaption']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="seoCaption" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" placeholder="<?php echo localize('Enter a ').' '.localize('Caption');?>..." role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-btn" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoCaption" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoCaption" class="btn btn-secondary save" data-dbid="seoCaption" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="seoKeywords" class="col-form-label col-sm-2"><?php echo localize('SEO').' '.localize('Keywords');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoKeywords" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
                if($r['suggestions']==1){
                  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
                  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoKewords']);
                  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Editing Suggestions').'"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="seoKeywords" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb').'</button></div>':'';
                }?>
                <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" placeholder="<?php echo localize('Enter').' '.localize('Keywords');?>..." role="textbox">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="seoKeywords" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoKeywords" class="btn btn-secondary save" data-dbid="seoKeywords" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
          </div>
          <div id="tab-page-settings" class="tab-pane" role="tabpanel">
<?php if($r['contentType']!='index'){?>
            <div class="form-group row">
              <label for="active" class="col-form-label col-sm-2"><?php echo localize('Active');?></label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="active<?php echo$r['id'];?>" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0" role="checkbox"<?php echo$r['active']==1?' checked aria-checked="true"':' aria-checked="false"';?>><span class="switch-slider" data-checked="<?php echo localize('on');?>" data-unchecked="<?php echo localize('off');?>"></span></label>
              </div>
            </div>
            <div class="help-block small text-muted text-right"><?php echo localize('help_urltype-1');?><code class="click" style="cursor:pointer;" onclick="$('#url').val('#<?php echo$r['contentType'];?>');update('<?php echo$r['id'];?>','menu','url',$('#url').val());pace.start();">#<?php echo$r['contentType'];?></code> <?php echo localize('help_urltype-2');?></div>
            <div class="form-group row">
              <label for="url" class="col-form-label col-sm-2"><?php echo localize('URL Type');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="url" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="textbox" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="url" placeholder="" role="textbox">
                <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveurl" class="btn btn-secondary save" data-dbid="url" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
<?php }?>
            <div class="form-group row">
              <label for="menu" class="col-form-label col-sm-2"><?php echo localize('Menu');?></label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="menu" data-tooltip="tooltip" title="Fingerprint Analysis" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="menu" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','menu',$(this).val());" role="listbox">
                  <option value="head"<?php echo$r['menu']=='head'?' selected':'';?>><?php echo localize('Head');?></option>
                  <option value="other"<?php echo$r['menu']=='other'?' selected':'';?>><?php echo localize('Other');?></option>
                  <option value="footer"<?php echo$r['menu']=='footer'?' selected':'';?>><?php echo localize('Footer');?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="mid" class="col-form-label col-sm-2"><?php echo localize('SubMenu');?></label>
              <div class="input-group col-sm-10">
                <select id="mid" class="form-control" onchange="update('<?php echo$r['id'];?>','mid','menu',$(this).val());" role="listbox">
                  <option value="0"<?php echo$r['mid']==0?' selected':'';?>><?php echo localize('None');?></option>
<?php $sm=$db->prepare("SELECT id,title from `".$prefix."menu` WHERE mid=0 AND mid!=:mid AND active=1 ORDER BY ord ASC, title ASC");
$sm->execute([':mid'=>$r['id']]);
while($rm=$sm->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rm['id'].'"'.($r['mid']==$rm['id']?' selected':'').'>'.$rm['title'].'</option>';?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
