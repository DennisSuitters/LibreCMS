<?php
$rank=0;
$show='pages';
if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_pages.php';
else{
  if($args[0]=='edit')$show='item';
  if($show=='pages'){?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Pages</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/pages/settings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Settings"';?>><?php svg('cogs');?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#pages"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <small class="text-muted">Pages can be dragged to change their order.</small>
    <div class="table-responsive">
      <table class="table table-condensed table-striped table-hover">
        <thead>
          <tr>
            <th class="col-xs-10 col-sm-6">Title</th>
            <th class="col-sm-1 text-center hidden-xs">Menu</th>
            <th class="col-sm-2 text-center hidden-xs">Views</th>
            <th class="col-sm-1 text-center hidden-xs">Active</th>
            <th class="col-xs-2 col-sm-2"></th>
          </tr>
        </thead>
        <tbody id="sortable">
<?php $s=$db->prepare("SELECT * FROM menu ORDER BY ord ASC");
$s->execute();
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
          <tr id="l_<?php echo$r['id'];?>" class="item">
            <td><a href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"><?php echo$r['title'];?></a></td>
            <td class="text-center hidden-xs"><?php echo ucfirst($r['menu']);?></td>
            <td class="text-center hidden-xs">
              <button class="btn btn-default trash" onclick="$('#views<?php echo$r['id'];?>').text('0');update('<?php echo$r['id'];?>','menu','views','0');"><?php svg('eraser');?> <span id="views<?php echo$r['id'];?>"><?php echo$r['views'];?></span></button>
            </td>
            <td class="text-center hidden-xs">
<?php if($r['contentType']!='index'){?>
              <div class="checkbox checkbox-success">
                <input type="checkbox" id="active<?php echo$r['id'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php if($r['active']==1)echo' checked';?>>
                <label for="active<?php echo$r['id'];?>"/>
              </div>
<?php }?>
            </td>
            <td id="controls_<?php echo$r['id'];?>" class="text-right">
              <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><?php svg('edit');?></a>
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
  $s=$db->prepare("SELECT * FROM menu WHERE id=:id");
  $s->execute(array(':id'=>$args[1]));
  $r=$s->fetch(PDO::FETCH_ASSOC);?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">
      <ol class="breadcrumb">
        <li><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
        <li class="active relative">
<?php $so=$db->prepare("SELECT * FROM menu WHERE active='1' AND id NOT LIKE :id ORDER BY ord ASC,menu ASC");
$so->execute(array(':id'=>$r['id']));?>
          <a class="dropdown-toggle" data-toggle="dropdown"><?php echo$r['title'];?> <i class="caret"></i></a>
          <ul class="dropdown-menu">
<?php while($ro=$so->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.$settings['system']['admin'].'/pages/edit/'.$ro['id'].'">'.$ro['title'].'</a></li>';?>
          </ul>
        </li>
      </ol>
    </h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/pages';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#pages-edit-content"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
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
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="title"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" data-bs="btn-danger" placeholder="Enter a Title...">
          </div>
        </div>
        <div class="form-group">
<?php if($user['rank']>899){?>
          <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="notesda"><?php svg('fingerprint');?></button>
          <div id="notesda" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="notes"></div>
<?php }?>
          <form id="summernote" enctype="multipart/form-data" method="post" target="sp" action="core/update.php">
            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
            <input type="hidden" name="t" value="menu">
            <input type="hidden" name="c" value="notes">
            <textarea id="notes" class="form-control summernote" name="da" readonly><?php echo rawurldecode($r['notes']);?></textarea>
          </form>
          <small class="help-block text-right">Edited: <?php if($r['eti']==0)echo'Never';else echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></small>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="page-images">
        <fieldset class="control-fieldset">
          <legend class="control-legend">Cover</legend>
          <div class="form-group">
            <label for="cover" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
              <div class="input-group-btn">
                <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="coverURL"><?php svg('fingerprint');?></button>
              </div>
<?php }?>
              <input type="text" id="coverURL" class="form-control image" value="<?php echo$r['coverURL'];?>" onchange="coverUpdate('<?php echo$r['id'];?>','menu','coverURL',$(this).val());" placeholder="Enter Cover URL...">
              <div class="input-group-btn">
                <button class="btn btn-default trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverURL','');"><?php svg('trash');?></button>
              </div>
            </div>
            <small class="help-block text-right">Editing a URL Image will retreive the image to the server for Editing.</small>
          </div>
          <div class="form-group clearfix">
            <div class="col-xs-5 col-sm-3 col-lg-2"></div>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
              <div class="input-group-btn">
                <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="cover"><?php svg('fingerprint');?></button>
              </div>
<?php }?>
              <input type="text" id="cover" class="form-control" name="feature_image" value="<?php echo$r['cover'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="cover" readonly>
              <div class="input-group-btn">
                <button class="btn btn-default" onclick="mediaDialog('<?php echo$r['id'];?>','menu','cover');"><?php svg('browse-media');?></button>
              </div>
              <div class="input-group-addon img">
<?php if($r['cover']!='')
  echo'<a href="media/'.$r['cover'].'" data-featherlight="image"><img id="coverimage" src="'.$r['cover'].'"></a>';
elseif($r['coverURL']!='')
  echo'<a href="media/'.$r['coverURL'].'" data-featherlight="image"><img id="coverimage" src="media/'.$r['coverURL'].'"></a>';
elseif($r['coverURL']!='')
  echo'<a href="'.$r['coverURL'].'" data-featherlight="image"><img id="coverimage" src="'.$r['coverURL'].'"></a>';
else
  echo'<img id="coverimage" src="">';?>
              </div>
              <div class="input-group-btn">
                <button class="btn btn-default trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','cover','');"><?php svg('trash');?></button>
              </div>
            </div>
            <small class="help-block text-right">Uploaded Images take Precedence over URL's.</small>
          </div>
        </fieldset>
        <fieldset class="control-fieldset">
          <legend class="control-legend">Image Attribution</legend>
          <div class="form-group">
            <label for="attributionImageTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">Title</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
              <div class="input-group-btn">
                <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="attributionImageTitle"><?php svg('fingerprint');?></button>
              </div>
<?php }?>
              <input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle" placeholder="Enter a Title...">
            </div>
          </div>
          <div class="form-group">
            <label for="attributionImageName" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
              <div class="input-group-btn">
                <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="attributionImageName"><?php svg('fingerprint');?></button>
              </div>
<?php }?>
              <input type="text" id="attributionImageName" list="attributionImageTitle_option" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName" placeholder="Enter a Name...">
              <datalist id="attributionImageTitle_option">
<?php $s=$db->query("SELECT DISTINCT attributionImageTitle AS name FROM content UNION SELECT DISTINCT name FROM content UNION SELECT DISTINCT name FROM login ORDER BY name ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['name'].'"/>';?>
              </datalist>
            </div>
          </div>
          <div class="form-group">
            <label for="attributionImageURL" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
              <div class="input-group-btn">
                <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="attributionImageURL"><?php svg('fingerprint');?></button>
              </div>
<?php }?>
              <input type="text" id="attributionImageURL" list="attributionImageURL_option" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL" placeholder="Enter a URL...">
              <datalist id="attributionImageURL_option">
<?php $s=$db->query("SELECT DISTINCT attributionImageURL AS url FROM content ORDER BY url ASC");
while($rs=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['url'].'"/>';?>
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
                <button class="btn btn-default" onclick="mediaDialog('<?php echo$r['id'];?>','media','file');return false;"><?php svg('browse-media');?></button>
              </div>
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default add" onclick=""><?php svg('plus');?></button>
              </div>
            </div>
          </div>
        </form>
        <ul id="media_items">
<?php $sm=$db->prepare("SELECT * FROM media WHERE file!='' AND rid=0 AND pid=:id ORDER BY ord ASC");
$sm->execute(array(':id'=>$r['id']));
while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
  list($width,$height)=getimagesize($rm['file']);?>
          <li id="media_items_<?php echo$rm['id'];?>" class="col-xs-6 col-sm-3">
            <div class="panel panel-default media">
              <div class="controls btn-group">
                <span class="handle btn btn-default btn-xs"><?php svg('drag');?></span>
                <button class="btn btn-default btn-xs media-edit" data-dbid="<?php echo$rm['id'];?>"><?php svg('edit');?></button>
                <button class="btn btn-default trash btn-xs" onclick="purge('<?php echo$rm['id'];?>','media')"><?php svg('trash');?></button>
              </div>
              <div class="panel-body">
                <a href="<?php echo$rm['file'];?>"
                  data-srcset="<?php echo$rm['file'];?> <?php echo$width;?>w"
                  data-fancybox="gallery"
                  data-width="<?php echo$width;?>"
                  data-height="<?php echo$height;?>"
                  data-caption="<?php echo$rm['title'];if($rm['seoCaption'])echo' - '.$rm['seoCaption'];?>"
                >
                  <img src="<?php echo$rm['file'];?>" alt="">
                </a></div>
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
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="menu" data-u="<?php echo URL.$r['contentType'];?>" data-analytics="social"><?php svg('seo-social');?> Social</button>
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="menu" data-u="<?php echo URL.$r['contentType'];?>" data-analytics="google"><?php svg('seo-google');?> Google</button>
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="menu" data-u="<?php echo URL.$r['contentType'];?>" data-analytics="alexa"><?php svg('seo-alexa');?> Alexa</button>
              <button class="btn btn-default analytics hidden-xs" data-toggle="analytics" data-id="<?php echo$r['id'];?>" data-t="menu" data-u="<?php echo URL.$r['contentType'];?>" data-analytics="moz"><?php svg('seo-moz');?> Moz</button>
            </div>
          </div>
        </div>
        <script>
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
        </script>
        <div class="form-group">
          <label for="views" class="control-label col-xs-5 col-sm-3 col-lg-2">Views</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="views"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="number" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="views">
            <div class="input-group-btn">
              <button class="btn btn-default trash" onclick="$('#views').val('0');update('<?php echo$r['id'];?>','menu','views','0');"><?php svg('eraser');?></button>
            </div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="metaRobots" class="control-label col-xs-5 col-sm-3 col-lg-2">Meta Robots</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="metaRobots"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$r['metaRobots'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="metaRobots" placeholder="Enter a Robots Option as Below...">
          </div>
          <small class="help-block text-right">Options for Meta Robots: <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Allow search engines robots to index the page, you don’t have to add this to your pages, as it’s the default."';?>>index</span>, <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Disallow search engines from showing this page in their results."';?>>noindex</span>, <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Disallow search engines from spidering images on that page. Of course if images are linked to directly from elsewhere, Google can still index them, so using an X-Robots-Tag HTTP header is a better idea."';?>>noimageIndex</span>, <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="This is a shortcut for noindex,nofollow, or basically saying to search engines: don’t do anything with this page at all."';?>>none</span>, <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Tells the search engines robots to follow the links on the page, whether it can index it or not."';?>>follow</span>,<span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Tells the search engines robots to not follow any links on the page at all."';?>>nofollow</span>, <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Prevents the search engines from showing a cached copy of this page."';?>>noarchive</span>, <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Same as noarchive, but only used by MSN/Live."';?>>nocache</span>, <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Prevents the search engines from showing a snippet of this page in the search results and prevents them from caching the page."';?>>nosnippet</span>, <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Blocks search engines from using the description for this page in DMOZ (aka ODP) as the snippet for your page in the search results."';?>>noodp</span>, <span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Blocks Yahoo! from using the description for this page in the Yahoo! directory as the snippet for your page in the search results. No other search engines use the Yahoo! directory for this purpose, so they don’t support the tag."';?>>noydir</span></small>
        </div>
        <div class="form-group clearfix">
          <label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Title</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="seoTitle"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
<?php $cntc=70-strlen($r['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div class="input-group-addon">
              <span id="seoTitlecnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
            </div>
            <div class="input-group-btn">
              <button class="btn btn-default" onclick="removeStopWords('seoTitle',$('#seoTitle').val());"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Remove Stop Words."';?>><?php svg('magic');?></button>
            </div>
            <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
          </div>
          <small class="help-block text-right">The recommended character count for Title's is 70.</small>
        </div>
        <div class="form-group clearfix">
          <label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Caption</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="seoCaption"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
<?php $cntc=160-strlen($r['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
          <div class="input-group-addon">
            <span id="seoCaptioncnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
          </div>
          <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" placeholder="Enter a Caption...">
        </div>
        <small class="help-block text-right">The recommended character count for Captions is 160, as sometime Captions may be used in Descriptions.</small>
      </div>
      <div class="form-group clearfix">
        <label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Description</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
          <div class="input-group-btn">
            <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="seoDescription"><?php svg('fingerprint');?></button>
          </div>
<?php }?>
<?php $cntc=160-strlen($r['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
          <div class="input-group-addon">
            <span id="seoDescriptioncnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
          </div>
          <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" placeholder="Enter a Description...">
        </div>
        <small class="help-block text-right">The recommended character count for Descriptions is 160.</small>
      </div>
      <div class="form-group">
        <label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Keywords</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
          <div class="input-group-btn">
            <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="seoKeywords"><?php svg('fingerprint');?></button>
          </div>
<?php }?>
          <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" placeholder="Enter Keywords...">
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="page-settings">
<?php if($r['contentType']!='index'){?>
      <div class="form-group">
        <label for="active" class="control-label check col-xs-5 col-sm-3 col-lg-2">Active</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
          <div class="checkbox checkbox-success">
            <input type="checkbox" id="active" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php if($r['active']==1)echo' checked';?>>
            <label for="active"/>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="url" class="control-label col-xs-5 col-sm-3 col-lg-2">URL Type</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
          <div class="input-group-btn">
            <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="url"><?php svg('fingerprint');?></button>
          </div>
<?php }?>
          <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="url" placeholder="">
        </div>
        <small class="help-block text-right">Leave Blank for in site menu URL's.<br>Enter a URL to link to another service.<br>
        Or use <code class="click" onclick="$('#url').val('#<?php echo$r['contentType'];?>');update('<?php echo$r['id'];?>','menu','url',$('#url').val());pace.start();">#<?php echo$r['contentType'];?></code> to have menu item link to Anchor with same name on same page.</small>
      </div>
<?php }?>
      <div class="form-group">
        <label for="menu" class="control-label col-xs-5 col-sm-3 col-lg-2">Menu</label>
        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
          <div class="input-group-btn">
            <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="menu"><?php svg('fingerprint');?></button>
          </div>
<?php }?>
          <select id="menu" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','menu',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="menu">
            <option value="head"<?php if($r['menu']=='head')echo' selected';?>>Head</option>
            <option value="other"<?php if($r['menu']=='other')echo' selected';?>>Other</option>
            <option value="footer"<?php if($r['menu']=='footer')echo' selected';?>>Footer</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</div>
<?php }
