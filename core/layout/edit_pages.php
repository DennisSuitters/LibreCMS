<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2018
 *
 * Administration - Edit Pages
 *
 * edit_pages.php version 2.0.0
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
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE id=:id");
$s->execute([':id'=>$args[1]]);
$r=$s->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item active" aria-current="page"><span id="titleupdate"><?php echo$r['title'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="Settings">
        <a class="btn btn-ghost-normal info" href="<?php echo URL.$settings['system']['admin'].'/pages';?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
<?php if($help['pages_edit_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['pages_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="Read Text Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['pages_edit_video']!='')echo'<span><a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['pages_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="nav-item"><a class="nav-link active" href="#tab-page-content" aria-controls="tab-page-content" role="tab" data-toggle="tab">Content</a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-images" aria-controls="tab-page-images" role="tab" data-toggle="tab">Images</a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-media" aria-controls="tab-page-media" role="tab" data-toggle="tab">Media</a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-seo" aria-controls="tab-page-seo" role="tab" data-toggle="tab">SEO</a></li>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#tab-page-settings" aria-controls="tab-page-settings" role="tab" data-toggle="tab">Settings</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab-page-content" class="tab-pane active" role="tabpanel">
            <div class="form-group row">
              <label for="title" class="col-form-label col-sm-2">Title</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="title" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
if($r['suggestions']==1){$ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'title']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="title">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" placeholder="Enter a Title..." onkeyup="genurl();$('#titleupdate').text($(this).val());">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-secondary addsuggestion hidden-xs" data-dbgid="title">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savetitle" class="btn btn-secondary save" data-dbid="title" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
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
              <label class="col-form-label col-sm-2">Generated URL</label>
              <div class="input-group col-sm-10">
                <div class="input-group-text  text-truncate col-sm-12">
                  <a id="genurl" target="_blank" href="<?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?>"><?php echo URL.($r['contentType']=='page'?$r['contentType'].'/':'').strtolower(str_replace(' ','-',$r['title']));?></a>
                </div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">Edited: <?php echo$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></div>
            <div class="form-group row">
              <div class="card-header col-12 position-relative" style="padding:0;">
<?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="notesda" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button>':'';
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'notes']);
  echo$ss->rowCount()>0?'<span data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary btn-sm suggestions" data-dbgid="notesda">'.svg2('libre-gui-lightbulb').'</button></span>':'';
}
echo$user['rank']>899?'<span class="float-right" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary btn-sm addsuggestion" data-dbgid="notesda">'.svg2('libre-gui-idea').'</button></span>':'';?>
                <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
                <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="t" value="menu">
                  <input type="hidden" name="c" value="notes">
                  <textarea id="notes" class="form-control summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes" name="da" readonly><?php echo rawurldecode($r['notes']);?></textarea>
                </form>
              </div>
            </div>
          </div>
          <div id="tab-page-images" class="tab-pane" role="tabpanel">
            <fieldset class="control-fieldset">
              <legend class="control-legend">Cover</legend>
              <div class="help-block small text-muted text-right">Editing a URL Image will retreive the image to the server for Editing.</div>
              <div class="form-group row">
                <label for="cover" class="col-form-label col-sm-2">URL</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="coverURL" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="coverURL" class="form-control image" value="<?php echo$r['coverURL'];?>" onchange="coverUpdate('<?php echo$r['id'];?>','menu','coverURL',$(this).val());" placeholder="Enter Cover URL...">
                  <div class="input-group-append"><button class="btn btn-secondary trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverURL','');" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button></div>
                </div>
              </div>
              <div class="help-block small text-muted text-right">Uploaded Images take Precedence over URL's.</div>
              <div class="form-group row">
                <label class="col-form-label col-sm-2"></label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="cover" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="cover" class="form-control" name="feature_image" value="<?php echo$r['cover'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="cover" readonly>
                  <div class="input-group-append">
                    <button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','menu','cover');" data-tooltip="tooltip" title="Open Media Manager"><?php svg('libre-gui-browse-media');?></button>
                  </div>
                  <div class="input-group-append img">
<?php if($r['cover']!='')
  echo'<a href="'.$r['cover'].'" data-featherlight="image"><img id="coverimage" class="bg-white" src="'.$r['cover'].'"></a>';
elseif($r['coverURL']!='')
  echo'<a href="'.$r['coverURL'].'" data-featherlight="image"><img id="coverimage" class="bg-white" src="'.$r['coverURL'].'"></a>';
elseif($r['coverURL'] != '')
  echo'<a href="'.$r['coverURL'].'" data-featherlight="image"><img id="coverimage" class="bg-white" src="'.$r['coverURL'].'"></a>';
else
  echo'<img id="coverimage" class="bg-white" src="'.ADMINNOIMAGE.'">';?>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-secondary trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','cover','');" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                  </div>
                </div>
              </div>
              <div class="help-block small text-muted text-right">Video's take Precedence over Cover Images but will appear of Video's are broken.</div>
              <div class="form-group row">
                <label for="coverVideo" class="col-form-label col-sm-2">Video URL</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="coverVideo" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="coverVideo" class="form-control" name="feature_image" value="<?php echo$r['coverVideo'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="coverVideo" readonly>
                  <div class="input-group-append">
                    <button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','menu','coverVideo');" data-tooltip="tooltip" title="Open Media Manager"><?php svg('libre-gui-browse-media');?></button>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-secondary trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverVideo','');" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                  </div>
                </div>
              </div>
            </fieldset>
            <fieldset class="control-fieldset">
              <legend class="control-legend">Image Attribution</legend>
              <div class="form-group row">
                <label for="attributionImageTitle" class="col-form-label col-sm-2">Title</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageTitle" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle" placeholder="Enter a Title...">
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionImageTitle" class="btn btn-secondary save" data-dbid="attributionImageTitle" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="attributionImageName" class="col-form-label col-sm-2">Name</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageName" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageName" list="attributionImageTitle_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName" placeholder="Enter a Name...">
                  <datalist id="attributionImageTitle_option">
<?php $s=$db->query("SELECT DISTINCT attributionImageTitle AS name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."login` ORDER BY name ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['name'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionImageName" class="btn btn-secondary save" data-dbid="attributionImageName" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="attributionImageURL" class="col-form-label col-sm-2">URL</label>
                <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="attributionImageURL" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                  <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL" placeholder="Enter a URL...">
                  <datalist id="attributionImageURL_option">
<?php $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM `".$prefix."content` ORDER BY url ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['url'].'"/>';?>
                  </datalist>
                  <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveattributionImageURL" class="btn btn-secondary save" data-dbid="attributionImageURL" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            </fieldset>
          </div>
          <div id="tab-page-media" class="tab-pane" role="tabpanel">
            <div class="help-block small text-muted text-right">Media uploaded can be used for Image Gallery's, Featured Content, or depending on how they are used in the Theme's Template.</div>
            <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
              <input type="hidden" name="act" value="add_media">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="pages">
              <div class="form-group">
                <div class="input-group">
                  <input id="file" type="text" class="form-control" name="fu" value="" placeholder="Enter a URL, or Select Images using the Browse Media Button...">
                  <div class="input-group-append"><button class="btn btn-secondary" onclick="elfinderDialog('<?php echo$r['id'];?>','media','file');return false;" data-tooltip="tooltip" title="Open Media Manager"><?php svg('libre-gui-browse-media');?></button></div>
                  <div class="input-group-append"><button type="submit" class="btn btn-secondary add" data-tooltip="tooltip" title="Add Media Item"><?php svg('libre-gui-plus');?></button></div>
                </div>
              </div>
            </form>
            <ul id="media_items">
<?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE file!='' AND rid=0 AND pid=:id ORDER BY ord ASC");
$sm->execute([':id'=>$r['id']]);
while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
  list($width,$height)=getimagesize($rm['file']);?>
              <li id="media_items_<?php echo$rm['id'];?>" class="col-xs-6 col-sm-3">
                <div class="panel panel-default media">
                  <div class="controls btn-group">
                    <span class="handle btn btn-default btn-xs"><?php svg('libre-gui-drag');?></span>
                    <button class="btn btn-default btn-xs media-edit" data-dbid="<?php echo$rm['id'];?>"><?php svg('libre-gui-edit');?></button>
                    <button class="btn btn-default trash btn-xs" onclick="purge('<?php echo$rm['id'];?>','media')"><?php svg('libre-gui-trash');?></button>
                  </div>
                  <div class="panel-body">
                    <a href="<?php echo $rm['file'];?>" data-srcset="<?php echo$rm['file'];?> <?php echo$width;?>w" data-fancybox="gallery" data-width="<?php echo$width;?>" data-height="<?php echo$height;?>" data-caption="<?php echo $rm['title'];if($rm['seoCaption'])echo' - '.$rm['seoCaption'];?>"><img src="<?php echo$rm['file'];?>" alt=""></a>
                  </div>
                  <div id="media-title<?php echo$rm['id'];?>" class="panel-footer"><?php echo$rm['title'];?></div>
                </div>
              </li>
<?php }?>
            </ul>
          </div>
          <div id="tab-page-seo" class="tab-pane" role="tabpanel">
            <div class="form-group row">
              <label for="views" class="col-form-label col-sm-2">Views</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="views" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="number" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="views">
                <div class="input-group-addon"><button class="btn btn-secondary trash" onclick="$('#views').val('0');update('<?php echo$r['id'];?>','menu','views','0');" data-tooltip="tooltip" title="Clear Views"><?php svg('libre-gui-eraser');?></button></div>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveviews" class="btn btn-secondary save" data-dbid="views" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">Options for Meta Robots: <span data-tooltip="tooltip" title="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-tooltip="tooltip" title="Disallow search engines from showing this page in their results.">noindex</span>, <span data-tooltip="tooltip" title="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-tooltip="tooltip" title="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-tooltip="tooltip" title="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>,<span data-tooltip="tooltip" title="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-tooltip="tooltip" title="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-tooltip="tooltip" title="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-tooltip="tooltip" title="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-tooltip="tooltip" title="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-tooltip="tooltip" title="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></div>
            <div class="form-group row">
              <label for="metaRobots" class="col-form-label col-sm-2">Meta Robots</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-append"><button class="btn btn-secondary fingerprint" data-dbgid="metaRobots" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'metaRobots']);
  echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="metaRobots">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="metaRobots" placeholder="Enter a Robots Option as Below...">
                <?php echo$user['rank']>899?'<div class="input-group-prepend" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="metaRobots">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savemetaRobots" class="btn btn-secondary save" data-dbid="metaRobots" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
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
                <div class="input-group-prepend">
                  <span id="seoTitlecnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span>
                </div>
                <div class="input-group-prepend">
                  <button class="btn btn-secondary" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-tooltip="tooltip" title="Remove Stop Words."><?php svg('libre-gui-magic');?></button>
                </div>
<?php if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoTitle']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-dbgid="seoTitle">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="seoTitle">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoTitle" class="btn btn-secondary save" data-dbid="seoTitle" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">The recommended character count for Captions is 160, as sometime Captions may be used in Descriptions.</div>
            <div class="form-group row">
              <label for="seoCaption" class="col-form-label col-sm-2">SEO Caption</label>
              <div class="input-group col-sm-10">
                <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoCaption" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($r['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-prepend">
                  <span id="seoCaptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span>
                </div>
<?php if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoCaption']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" placeholder="Enter a Caption...">
                <?php echo$user['rank']>899?'<div class="input-group-btn" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoCaption" class="btn btn-secondary save" data-dbid="seoCaption" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="help-block small text-muted text-right">The recommended character count for Descriptions is 160.</div>
            <div class="form-group row">
              <label for="seoDescription" class="col-form-label col-sm-2">SEO Description</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoDescription" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($r['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
                <div class="input-group-prepend">
                  <span id="seoDescriptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span>
                </div>
<?php if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoDescription']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" placeholder="Enter a Description...">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoDescription" class="btn btn-secondary save" data-dbid="seoDescription" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="seoKeywords" class="col-form-label col-sm-2">SEO Keywords</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoKeywords" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';
if($r['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>$r['id'],':t'=>'menu',':c'=>'seoKewords']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Editing Suggestions"><button class="btn btn-secondary suggestions" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-lightbulb').'</button></div>':'';
}?>
                <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" placeholder="Enter Keywords...">
                <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-idea').'</button></div>':'';?>
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoKeywords" class="btn btn-secondary save" data-dbid="seoKeywords" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
          </div>
          <div id="tab-page-settings" class="tab-pane" role="tabpanel">
<?php if($r['contentType']!='index'){?>
            <div class="form-group row">
              <label for="active" class="col-form-label col-sm-2">Active</label>
              <div class="input-group col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="active<?php echo$r['id'];?>" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php echo$r['active']==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="help-block small text-muted text-right">Leave Blank for in site menu URL's. Enter a URL to link to another service. Or use <code class="click" style="cursor:pointer;" onclick="$('#url').val('#<?php echo$r['contentType'];?>');update('<?php echo$r['id'];?>','menu','url',$('#url').val());pace.start();">#<?php echo$r['contentType'];?></code> to have menu item link to Anchor with same name on same page.</div>
            <div class="form-group row">
              <label for="url" class="col-form-label col-sm-2">URL Type</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="url" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="url" placeholder="">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveurl" class="btn btn-secondary save" data-dbid="url" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
<?php }?>
            <div class="form-group row">
              <label for="menu" class="col-form-label col-sm-2">Menu</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="menu" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="menu" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="menu">
                  <option value="head"<?php echo$r['menu']=='head'?' selected':'';?>>Head</option>
                  <option value="other"<?php echo$r['menu']=='other'?' selected':'';?>>Other</option>
                  <option value="footer"<?php echo$r['menu']=='footer'?' selected':'';?>>Footer</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="mid" class="col-form-label col-sm-2">SubMenu</label>
              <div class="input-group col-sm-10">
                <select id="mid" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="mid">
                  <option value="0"<?php echo$r['mid']==0?' selected':'';?>>None</option>
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
