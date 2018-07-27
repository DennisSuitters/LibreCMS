<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$rank=0;
$show='pages';
if($args[0]=='add'){
  $ti=time();
  $q=$db->prepare("INSERT INTO `".$prefix."menu` (uid,mid,login_user,title,seoTitle,file,contentType,schemaType,menu,active,ord,eti) VALUES (:uid,'0',:login_user,:title,'','page','page','Article','other','0',:ord,:eti)");
  $q->execute(
    array(
      ':uid'=>$user['id'],
      ':login_user'=>(isset($user['name'])?$user['name']:$user['username']),
      ':title'=>'New Page '.$ti.'',
      ':ord'=>$ti,
      ':eti'=>$ti
    )
  );
  $id=$db->lastInsertId();
  $rank=0;
  $args[0]='edit';
  $args[1]=$id;?>
<script>/*<![CDATA[*/
  history.replaceState('','','<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$args[1];?>');
/*]]>*/</script>
<?php
}
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_pages.php';
else{
  if($args[0]=='edit')$show='item';
  if($show=='pages'){?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Pages</h4>
    <div class="btn-group pull-right">
      <a class="btn btn-default add" href="<?php echo URL.$settings['system']['admin'].'/pages/add';?>" data-toggle="tooltip" data-placement="left" title="Add"><?php svg('libre-gui-add');?></a>
      <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/pages/settings';?>" data-toggle="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings');?></a>
      <?php if($help['pages_text']!='')echo'<a target="_blank" class="btn btn-default info" href="'.$help['pages_text'].'" data-toggle="tooltip" data-placement="left" title="Help">'.svg2('libre-gui-help').'</a>';if($help['pages_video']!='')echo'<a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['pages_video'].'" data-toggle="tooltip" data-placement="left" title="Watch Video Help">'.svg2('libre-gui-video').'</a>';?>
    </div>
  </div>
  <div class="panel-body">
    <small class="help-block text-muted text-right">Pages can be dragged to change their order.</small>
    <div class="table-responsive">
      <table class="table table-condensed table-striped table-hover">
        <thead>
          <tr>
            <th class="col-xs-10 col-sm-6">
              Title
              <small class="text-muted pull-right"><span class="small">Submenu Title</span></small>
            </th>
            <th class="col-sm-1 text-center hidden-xs">Menu</th>
            <th class="col-sm-2 text-center hidden-xs">Views</th>
            <th class="col-sm-1 text-center hidden-xs">Active</th>
            <th class="col-xs-2 col-sm-2"></th>
          </tr>
        </thead>
        <tbody id="sortable">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE mid=0 ORDER BY ord ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
          <tr id="l_<?php echo$r['id'];?>" class="item subsortable">
            <td>
              <a href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"><?php echo$r['title'];?></a>
<?php echo$r['suggestions']==1?'<span data-toggle="tooltip" data-placement="top" title="Editing suggestions.">'.svg2('libre-gui-lightbulb','','green').'</span>':'';
$sm=$db->prepare("SELECT id,title,contentType,views FROM `".$prefix."menu` WHERE mid!=0 AND mid=:mid ORDER BY ord ASC");
  $sm->execute(array(':mid'=>$r['id']));
  while($rm=$sm->fetch(PDO::FETCH_ASSOC)){?>
              <small id="s_<?php echo$rm['id'];?>" class="sub help-block zebra text-right">
                <a href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$rm['id'];?>"><?php echo$rm['title'];?></a>
                <span id="controls_<?php echo$rm['id'];?>" class="text-right">
                  <button class="btn btn-default btn-xs trash" onclick="$('#views<?php echo$rm['id'];?>').text('0');update('<?php echo$rm['id'];?>','menu','views','0');"><?php svg('libre-gui-eraser');?> <span id="views<?php echo$rm['id'];?>"><?php echo$rm['views'];?></span></button>
                  <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$rm['id'];?>" data-toggle="tooltip" title="Edit"><?php svg('libre-gui-edit');?></a>
                  <?php echo$rm['contentType']=='page'?'<button class="btn btn-default btn-xs trash" onclick="purge(\''.$rm['id'].'\',\'menu\')" data-toggle="tooltip" title="Delete">'.svg2('libre-gui-trash').'</button>':'';?>
                </span>
              </small>
              <script>/*<![CDATA[*/
                $('#l_<?php echo$r['id'];?>').sortable({
                  items:"small",
                  placeholder:".ghost",
                  helper:fixWidthHelper,
                  axis:"y",
                  update:function(e,ui){
                    var order=$("#l_<?php echo$r['id'];?>").sortable("serialize");
                    $.ajax({
                      type:"POST",
                      dataType:"json",
                      url:"core/reordersub.php",
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
              </*]]>*/</script>
<?php }?>
            </td>
            <td class="text-center hidden-xs"><?php echo ucfirst($r['menu']);?></td>
            <td class="text-center hidden-xs">
              <button class="btn btn-default trash" onclick="$('#views<?php echo$r['id'];?>').text('0');update('<?php echo$r['id'];?>','menu','views','0');"><?php svg('libre-gui-eraser');?> <span id="views<?php echo$r['id'];?>"><?php echo$r['views'];?></span></button>
            </td>
            <td class="text-center hidden-xs">
              <?php echo$r['contentType']!='index'?'<div class="checkbox checkbox-success"><input type="checkbox" id="active'.$r['id'].'" data-dbid="'.$r['id'].'" data-dbt="menu" data-dbc="active" data-dbb="0"'.($r['active']==1?' checked':'').'><label for="active'.$r['id'].'"/></div>':'';?>
            </td>
            <td id="controls_<?php echo$r['id'];?>">
              <div class="btn-group pull-right">
                <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>" data-toggle="tooltip" title="Edit"><?php svg('libre-gui-edit');?></a>
                <?php echo$r['contentType']=='page'?'<button class="btn btn-default trash" onclick="purge(\''.$r['id'].'\',\'menu\')" data-toggle="tooltip" title="Delete">'.svg2('libre-gui-trash').'</button>':'';?>
              </div>
            </td>
          </tr>
<?php }?>
          <tr class="ghost hidden">
            <td colspan="3">&nbsp;</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>/*<![CDATA[*/
  $('#sortable').sortable({
    items:"tr",
    placeholder:".ghost",
    helper:fixWidthHelper,
    axis:"y",
    update:function(e,ui){
      var order=$("#sortable").sortable("serialize");
      $.ajax({
        type:"POST",
        dataType:"json",
        url:"core/reorder.php",
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
/*]]>*/</script>
<?php }
}
if($show=='item'){
  $s=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE id=:id");
  $s->execute(array(':id'=>$args[1]));
  $r=$s->fetch(PDO::FETCH_ASSOC);?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">
      <ol class="breadcrumb">
        <li><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
        <li class="active relative">
<?php $so=$db->prepare("SELECT * FROM `".$prefix."menu` WHERE active='1' AND id NOT LIKE :id ORDER BY ord ASC,menu ASC");
$so->execute(array(':id'=>$r['id']));?>
          <a class="dropdown-toggle" data-toggle="dropdown"><?php echo$r['title'];?> <i class="caret"></i></a>
          <ul class="dropdown-menu">
<?php while($ro=$so->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$ro['id'].'">'.$ro['title'].'</a></li>';?>
          </ul>
        </li>
      </ol>
    </h4>
    <div class="btn-group pull-right">
      <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/pages';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
      <?php if($help['pages_edit_text']!='')echo'<a target="_blank" class="btn btn-default info" href="'.$help['pages_edit_text'].'" data-toggle="tooltip" data-placement="left" title="Help">'.svg2('libre-gui-help').'</a>';if($help['pages_edit_video']!='')echo'<a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['pages_edit_video'].'" data-toggle="tooltip" data-placement="left" title="Watch Video Help">'.svg2('libre-gui-video').'</a>';?>
    </div>
  </div>
  <div class="panel-body">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#page-content" aria-controls="page-content" role="tab" data-toggle="tab">Content</a></li>
      <li role="presentation"><a href="#page-images" aria-controls="page-images" role="tab" data-toggle="tab">Images</a></li>
      <li role="presentation"><a href="#page-media" aria-controls="page-media" role="tab" data-toggle="tab">Media</a></li>
      <li role="presentation"><a href="#page-seo" aria-controls="page-seo" role="tab" data-toggle="tab">SEO</a></li>
      <li role="presentation"><a href="#page-settings" aria-controls="page-settings" role="tab" data-toggle="tab">Settings</a></li>
    </ul>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="page-content">
        <div class="form-group">
          <label for="title" class="control-label col-xs-5 col-sm-3 col-lg-2">Title</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="title">'.svg2('libre-gui-fingerprint').'</button></div>':'';
            if($r['suggestions']==1){$ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");$ss->execute(array(':rid'=>$r['id'],':t'=>'menu',':c'=>'title'));echo$ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="title">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';}?>
            <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" data-bs="btn-danger" placeholder="Enter a Title...">
            <?php echo$user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="title">'.svg2('libre-gui-idea').'</button></div>':'';?>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group col-xs-12" style="background-color:#f5f5f5;border:1px solid #ccc;border-bottom:0;">
            <div class="input-group-btn">
              <?php echo$user['rank']>899?'<button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="notesda">'.svg2('libre-gui-fingerprint').'</button>':'';
              if($r['suggestions']==1){$ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");$ss->execute(array(':rid'=>$r['id'],':t'=>'menu',':c'=>'notes'));echo$ss->rowCount()>0?'<span data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="notesda">'.svg2('libre-gui-lightbulb','','green').'</button></span>':'';}
              echo$user['rank']>899?'<span class="pull-right" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion pull-right hidden-xs" data-toggle="popover" data-dbgid="notesda">'.svg2('libre-gui-idea').'</button></span>':'';?>
            </div>
          </div>
          <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
          <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
            <input type="hidden" name="t" value="menu">
            <input type="hidden" name="c" value="notes">
            <textarea id="notes" class="form-control summernote" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes" name="da" readonly><?php echo rawurldecode($r['notes']);?></textarea>
          </form>
          <small class="help-block text-right">Edited: <?php echo$r['eti']==0?'Never':date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></small>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="page-images">
        <fieldset class="control-fieldset">
          <legend class="control-legend">Cover</legend>
          <div class="form-group">
            <label for="cover" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
              <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="coverURL">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
              <input type="text" id="coverURL" class="form-control image" value="<?php echo$r['coverURL'];?>" onchange="coverUpdate('<?php echo$r['id'];?>','menu','coverURL',$(this).val());" placeholder="Enter Cover URL...">
              <div class="input-group-btn">
                <button class="btn btn-default trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverURL','');"><?php svg('libre-gui-trash');?></button>
              </div>
            </div>
            <small class="help-block text-right">Editing a URL Image will retreive the image to the server for Editing.</small>
          </div>
          <div class="form-group clearfix">
            <div class="col-xs-5 col-sm-3 col-lg-2"></div>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
              <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="cover">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
              <input type="text" id="cover" class="form-control" name="feature_image" value="<?php echo$r['cover'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="cover" readonly>
              <div class="input-group-btn">
                <button class="btn btn-default" onclick="elfinderDialog('<?php echo$r['id'];?>','menu','cover');"><?php svg('libre-gui-browse-media');?></button>
              </div>
              <div class="input-group-addon img">
                <?php if($r['cover']!='')echo'<a href="'.$r['cover'].'" data-featherlight="image"><img id="coverimage" src="'.$r['cover'].'"></a>';elseif($r['coverURL']!='')echo'<a href="'.$r['coverURL'].'" data-featherlight="image"><img id="coverimage" src="'.$r['coverURL'].'"></a>';elseif($r['coverURL'] != '')echo'<a href="'.$r['coverURL'].'" data-featherlight="image"><img id="coverimage" src="'.$r['coverURL'].'"></a>';else echo'<img id="coverimage" src="'.NOIMAGE.'">';?>
              </div>
              <div class="input-group-btn">
                <button class="btn btn-default trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','cover','');"><?php svg('libre-gui-trash');?></button>
              </div>
            </div>
            <small class="help-block text-right">Uploaded Images take Precedence over URL's.</small>
          </div>
          <div class="form-group clearfix">
            <label for="coverVideo" class="col-xs-5 col-sm-3 col-lg-2">Video URL</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
              <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="coverVideo">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
              <input type="text" id="coverVideo" class="form-control" name="feature_image" value="<?php echo$r['coverVideo'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="coverVideo" readonly>
              <div class="input-group-btn">
                <button class="btn btn-default" onclick="elfinderDialog('<?php echo$r['id'];?>','menu','coverVideo');"><?php svg('libre-gui-browse-media');?></button>
              </div>
              <div class="input-group-btn">
                <button class="btn btn-default trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverVideo','');"><?php svg('libre-gui-trash');?></button>
              </div>
            </div>
            <small class="help-block text-right">Video's take Precedence over Cover Images but will appear of Video's are broken.</small>
          </div>
        </fieldset>
        <fieldset class="control-fieldset">
          <legend class="control-legend">Image Attribution</legend>
          <div class="form-group">
            <label for="attributionImageTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">Title</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
              <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="attributionImageTitle">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
              <input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle" placeholder="Enter a Title...">
            </div>
          </div>
          <div class="form-group">
            <label for="attributionImageName" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
              <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="attributionImageName">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
              <input type="text" id="attributionImageName" list="attributionImageTitle_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName" placeholder="Enter a Name...">
              <datalist id="attributionImageTitle_option">
                <?php $s=$db->query("SELECT DISTINCT attributionImageTitle AS name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."content` UNION SELECT DISTINCT name FROM `".$prefix."login` ORDER BY name ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
              </datalist>
            </div>
          </div>
          <div class="form-group">
            <label for="attributionImageURL" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
              <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="attributionImageURL">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
              <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL" placeholder="Enter a URL...">
              <datalist id="attributionImageURL_option">
                <?php $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM `".$prefix."content` ORDER BY url ASC");while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
              </datalist>
            </div>
          </div>
        </fieldset>
      </div>
      <div role="tabpanel" class="tab-pane" id="page-media">
        <small class="help-block text-right">Media uploaded can be used for Image Gallery's, Featured Content, or depending on how they are used in the Theme's Template.</small>
        <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php">
          <input type="hidden" name="act" value="add_media">
          <input type="hidden" name="id" value="<?php echo$r['id'];?>">
          <input type="hidden" name="t" value="pages">
          <div class="form-group">
            <div class="input-group">
              <input id="file" type="text" class="form-control" name="fu" value="" placeholder="Enter a URL, or Select Images using the Browse Media Button...">
              <div class="input-group-btn">
                <button class="btn btn-default" onclick="elfinderDialog('<?php echo$r['id'];?>','media','file');return false;"><?php svg('libre-gui-browse-media');?></button>
              </div>
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default add" onclick=""><?php svg('libre-gui-plus');?></button>
              </div>
            </div>
          </div>
        </form>
        <ul id="media_items">
<?php $sm=$db->prepare("SELECT * FROM `".$prefix."media` WHERE file!='' AND rid=0 AND pid=:id ORDER BY ord ASC");
$sm->execute(array(':id'=>$r['id']));
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
      <div role="tabpanel" class="tab-pane" id="page-seo">
        <div class="form-group">
          <label for="analytics" class="control-label col-xs-5 col-sm-3 col-lg-2">Analytics <div class="pacesmall"><div class="pacesmall-activity"></div></div></label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="input-group-btn">
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="menu" data-u="<?php echo URL.$r['contentType'];?>" data-analytics="social"><?php svg('libre-seo-social');?> Social</button>
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="menu" data-u="<?php echo URL.$r['contentType'];?>" data-analytics="google"><?php svg('libre-seo-google');?> Google</button>
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="menu" data-u="<?php echo URL.$r['contentType'];?>" data-analytics="alexa"><?php svg('libre-seo-alexa');?> Alexa</button>
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="menu" data-u="<?php echo URL.$r['contentType'];?>" data-analytics="moz"><?php svg('libre-seo-moz');?> Moz</button>
            </div>
          </div>
        </div>
        <script>/*<![CDATA[*/
          $('.analytics').popover({
            html:true,
            trigger:'click',
            title:'Analytics <button type="button" id="close" class="close" data-dismiss="popover">&times;</button>',
            container:'body',
            placement:'auto',
            template:'<div class="popover analytics role="tooltip"><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
            content:function(){
              var id=$(this).data("id"),
                  t=$(this).data("t"),
                  u=$(this).data("u"),
                  a=$(this).data("analytics");
              return $.ajax({
                url:'core/layout/seostats-pages.php',
                dataType:'html',
                async:false,
                data:{
                  id:id,
                  t:t,
                  u:u,
                  a:a
                }
              }).responseText;
            }
          });
        /*]]>*/</script>
        <div class="form-group">
          <label for="views" class="control-label col-xs-5 col-sm-3 col-lg-2">Views</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="views">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="number" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="views">
            <div class="input-group-btn">
              <button class="btn btn-default trash" onclick="$('#views').val('0');update('<?php echo$r['id'];?>','menu','views','0');"><?php svg('libre-gui-eraser');?></button>
            </div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="metaRobots" class="control-label col-xs-5 col-sm-3 col-lg-2">Meta Robots</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="metaRobots">'.svg2('libre-gui-fingerprint').'</button></div>':'';
            if($r['suggestions']==1){$ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");$ss->execute(array(':rid'=>$r['id'],':t'=>'menu',':c'=>'metaRobots'));echo$ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="metaRobots">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';}?>
            <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="metaRobots" placeholder="Enter a Robots Option as Below...">
            <?php echo$user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="metaRobots">'.svg2('libre-gui-idea').'</button></div>':'';?>
          </div>
          <small class="help-block text-right">Options for Meta Robots: <span data-toggle="tooltip" title="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default.">index</span>, <span data-toggle="tooltip" title="Disallow search engines from showing this page in their results.">noindex</span>, <span data-toggle="tooltip" title="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea.">noimageIndex</span>, <span data-toggle="tooltip" title="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all.">none</span>, <span data-toggle="tooltip" title="Tells the search engines robots to follow the links on the page, whether it can index it or not.">follow</span>,<span data-toggle="tooltip" title="Tells the search engines robots to not follow any links on the page at all.">nofollow</span>, <span data-toggle="tooltip" title="Prevents the search engines from showing a cached copy of this page.">noarchive</span>, <span data-toggle="tooltip" title="Same as noarchive, but only used by MSN/Live.">nocache</span>, <span data-toggle="tooltip" title="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page.">nosnippet</span>, <span data-toggle="tooltip" title="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results.">noodp</span>, <span data-toggle="tooltip" title="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag.">noydir</span></small>
        </div>
        <div class="form-group clearfix">
          <label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Title</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="seoTitle">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=70-strlen($r['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div class="input-group-addon">
              <span id="seoTitlecnt" class="text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span>
            </div>
            <div class="input-group-btn">
              <button class="btn btn-default" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-toggle="tooltip" title="Remove Stop Words."><?php svg('libre-gui-magic');?></button>
            </div>
            <?php if($r['suggestions']==1){$ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");$ss->execute(array(':rid'=>$r['id'],':t'=>'menu',':c'=>'seoTitle'));echo$ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoTitle">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';}?>
            <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
            <?php echo$user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoTitle">'.svg2('libre-gui-idea').'</button></div>':'';?>
          </div>
          <small class="help-block text-right">The recommended character count for Title's is 70.</small>
        </div>
        <div class="form-group clearfix">
          <label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Caption</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($r['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
          <div class="input-group-addon">
            <span id="seoCaptioncnt" class="text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span>
          </div>
          <?php if($r['suggestions']==1){$ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");$ss->execute(array(':rid'=>$r['id'],':t'=>'menu',':c'=>'seoCaption'));echo$ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';}?>
          <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" placeholder="Enter a Caption...">
          <?php echo$user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-idea').'</button></div>':'';?>
        </div>
        <small class="help-block text-right">The recommended character count for Captions is 160, as sometime Captions may be used in Descriptions.</small>
      </div>
      <div class="form-group clearfix">
        <label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Description</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
          <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($r['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
          <div class="input-group-addon">
            <span id="seoDescriptioncnt" class="text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></span>
          </div>
          <?php if($r['suggestions']==1){$ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");$ss->execute(array(':rid'=>$r['id'],':t'=>'menu',':c'=>'seoDescription'));echo$ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';}?>
          <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" placeholder="Enter a Description...">
          <?php echo$user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-idea').'</button></div>':'';?>
        </div>
        <small class="help-block text-right">The recommended character count for Descriptions is 160.</small>
      </div>
      <div class="form-group">
        <label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Keywords</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
          <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-fingerprint').'</button></div>':'';
          if($r['suggestions']==1){$ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");$ss->execute(array(':rid'=>$r['id'],':t'=>'menu',':c'=>'seoKewords'));echo$ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';}?>
          <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" placeholder="Enter Keywords...">
          <?php echo$user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-idea').'</button></div>':'';?>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="page-settings">
<?php if($r['contentType']!='index'){?>
      <div class="form-group">
        <label for="active" class="control-label check col-xs-5 col-sm-3 col-lg-2">Active</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
          <div class="checkbox checkbox-success">
            <input type="checkbox" id="active" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php echo$r['active']==1?' checked':'';?>>
            <label for="active"/>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="url" class="control-label col-xs-5 col-sm-3 col-lg-2">URL Type</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
          <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="url">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
          <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="url" placeholder="">
        </div>
        <small class="help-block text-right">Leave Blank for in site menu URL's.<br>Enter a URL to link to another service.<br>
        Or use <code class="click" onclick="$('#url').val('#<?php echo$r['contentType'];?>');update('<?php echo$r['id'];?>','menu','url',$('#url').val());pace.start();">#<?php echo$r['contentType'];?></code> to have menu item link to Anchor with same name on same page.</small>
      </div>
<?php }?>
      <div class="form-group">
        <label for="menu" class="control-label col-xs-5 col-sm-3 col-lg-2">Menu</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
          <?php echo$user['rank']>899?'<div class="input-group-btn"><button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="menu">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
          <select id="menu" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','menu',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="menu">
            <option value="head"<?php echo$r['menu']=='head'?' selected':'';?>>Head</option>
            <option value="other"<?php echo$r['menu']=='other'?' selected':'';?>>Other</option>
            <option value="footer"<?php echo$r['menu']=='footer'?' selected':'';?>>Footer</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="mid" class="control-label col-xs-5 col-sm-3 col-lg-2">SubMenu</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
          <select id="mid" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','mid',$(this).val());" data-dbid-"<?php echo$r['id'];?>" data-dbt="menu" data-dbc="mid">
            <option value="0"<?php echo$r['mid']==0?' selected':'';?>>None</option>
            <?php $sm=$db->prepare("SELECT id,title from `".$prefix."menu` WHERE mid=0 AND mid!=:mid AND active=1 ORDER BY ord ASC, title ASC");$sm->execute(array(':mid'=>$r['id']));while($rm=$sm->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rm['id'].'"'.($r['mid']==$rm['id']?' selected':'').'>'.$rm['title'].'</option>';?>
          </select>
        </div>
      </div>
    </div>
  </div>
</div>
<?php }
