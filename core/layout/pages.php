<?php
$rank=0;
$show='pages';
if($args[0]=='edit')$show='item';
if($show=='pages'){?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Pages</h4>
    </div>
    <div class="panel-body">
        <h4 class="page-header">Active Pages</h4>
        <small class="text-muted">Active pages can be dragged to change their order.</small>
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-xs-8">Title</th>
                        <th class="col-xs-1 text-center">Menu</th>
                        <th class="col-xs-1 text-center">Views</th>
                        <th class="col-xs-1 text-center">Active</th>
                        <th class="col-xs-2"></th>
                    </tr>
                </thead>
                <tbody id="sortable">
<?php $s=$db->prepare("SELECT * FROM menu WHERE active='1' ORDER BY ord ASC");
    $s->execute();
    while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                    <tr id="l_<?php echo$r['id'];?>" class="item">
                        <td><a href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"><?php echo$r['title'];?></a></td>
                        <td class="text-center"><?php echo ucfirst($r['menu']);?></td>
                        <td class="text-center"><?php echo$r['views'];?></td>
                        <td class="text-center">
                          <input type="checkbox" id="active<?php echo$r['id'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0" data-dba="1"<?php if($r['active']==1)echo' checked';?>>
                          <label for="active<?php echo$r['id'];?>"></label>
                        </td>
                        <td id="controls_<?php echo$r['id'];?>" class="text-right">
                            <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><?php svg('edit');?></a>
                        </td>
                    </tr>
<?php }?>
                    <tr class="ghost hidden"><td colspan="3">&nbsp;</td></tr>
                </tbody>
            </table>
<?php $s=$db->prepare("SELECT * FROM menu WHERE active!='1' ORDER BY ord ASC");
    $s->execute();
    if($s->rowCount()>0){?>
            <h4 class="page-header">Inactive Pages</h4>
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-xs-8">Title</th>
                        <th class="col-xs-1 text-center">Menu</th>
                        <th class="col-xs-1 text-center">Views</th>
                        <th class="col-xs-1 text-center">Active</th>
                        <th class="col-xs-2"></th>
                    </tr>
                </thead>
                <tbody id="inactive">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                    <tr id="l_<?php echo$r['id'];?>">
                        <td><a href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"><?php echo$r['title'];?></a></td>
                        <td class="text-center"><?php echo ucfirst($r['menu']);?></td>
                        <td class="text-center"><?php echo$r['views'];?></td>
                        <td class="text-center">
                            <input type="checkbox" id="active<?php echo$r['id'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0" data-dba="0"<?php if($r['active']==1)echo' checked';?>>
                            <label for="active<?php echo$r['id'];?>"></label>
                        </td>
                        <td id="controls_<?php echo$r['id'];?>" class="text-right">
                            <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><?php svg('edit');?></a>
                        </td>
                    </tr>
<?php }?>

                </tbody>
            </table>
<?php }?>
        </div>
    </div>
</div>
<script>
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
</script>
<?php }
if($show=='item'){
    $s=$db->prepare("SELECT * FROM menu WHERE id=:id");
    $s->execute(array(':id'=>$args[1]));
    $r=$s->fetch(PDO::FETCH_ASSOC);?>
<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-6">
            <ol class="breadcrumb">
                <li><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>">Pages</a></li>
                <li class="active"><?php echo$r['title'];?></li>
            </ol>
        </h4>
        <a class="btn btn-default pull-right" href="<?php echo URL.$settings['system']['admin'].'/pages';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#page-content" aria-controls="page-content" role="tab" data-toggle="tab">Content</a></li>
            <li role="presentation"><a href="#page-images" aria-controls="page-images" role="tab" data-toggle="tab">Images</a></li>
            <li role="presentation"><a href="#page-seo" aria-controls="page-seo" role="tab" data-toggle="tab">SEO</a></li>
            <li role="presentation"><a href="#page-settings" aria-controls="page-settings" role="tab" data-toggle="tab">Settings</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="page-content">
                <div class="form-group">
                    <label for="title" class="control-label col-xs-5 col-sm-3 col-lg-2">Title</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" data-bs="btn-danger" placeholder="Enter a Title...">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group col-xs-12">
                        <form id="summernote" method="post" target="sp" action="core/update.php">
                            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                            <input type="hidden" name="t" value="menu">
                            <input type="hidden" name="c" value="notes">
                            <textarea id="notes" class="form-control summernote" name="da" readonly><?php echo$r['notes'];?></textarea>
                        </form>
                    </div>
                    <small class="help-block text-right">
                        Edited: <?php if($r['eti']==0)echo'Never';else echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?>
                    </small>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="page-images">
                <fieldset class="control-fieldset">
                    <legend class="control-legend">Cover</legend>
                    <div class="form-group">
                        <label for="cover" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                            <input type="text" id="coverURL" class="form-control image" value="<?php echo$r['coverURL'];?>" onchange="coverUpdate('<?php echo$r['id'];?>','menu','coverURL',$(this).val());" placeholder="Enter Cover URL...">
                            <div class="input-group-btn">
                                <button class="btn btn-default trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverURL','');"><?php svg('trash');?></button>
                            </div>
                        </div>
                        <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Editing a URL Image will retreive the image to the server for Editing.</div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
                            <input type="text" id="cover" class="form-control" name="feature_image" value="<?php echo$r['cover'];?>" readonly />
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
else echo'<img id="coverimage" src="core/images/nocover.jpg">';?>
                            </div>
                            <div class="input-group-btn">
                                <button class="btn btn-default trash" onclick="coverUpdate('<?php echo$r['id'];?>','menu','cover','');"><?php svg('trash');?></button>
                            </div>
                        </div>
                        <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Uploaded Images take Precedence over URL's.</div>
                </fieldset>
                <fieldset class="control-fieldset">
                    <legend class="control-legend">Image Attribution</legend>
                    <div class="form-group">
                        <label for="attributionImageTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">Title</label>
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                            <input type="text" id="attributionImageTitle" class="form-control textinput" value="<?php echo$r['attributionImageTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageTitle" placeholder="Enter a Title...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="attributionImageName" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                            <input type="text" id="attributionImageName" class="form-control textinput" value="<?php echo$r['attributionImageName'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageName" placeholder="Enter a Name...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="attributionImageURL" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                            <input type="text" id="attributionImageURL" class="form-control textinput" value="<?php echo$r['attributionImageURL'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="attributionImageURL" placeholder="Enter a URL...">
                        </div>
                    </div>
                </fieldset>
            </div>
            <div role="tabpanel" class="tab-pane" id="page-seo">
                <div class="form-group">
                    <label for="views" class="control-label col-xs-5 col-sm-3 col-lg-2">Views</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="number" id="views" class="form-control textinput" value="<?php echo$r['views'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="views">
                    </div>
                </div>
                <div class="form-group">
                    <label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Title</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Caption</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" placeholder="Enter a Caption...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Description</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="seoDescription<?php echo$r['id'];?>" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" placeholder="Enter a Description...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Keywords</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" placeholder="Enter Keywords...">
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="page-settings">
                <div class="form-group">
                    <label for="active" class="control-label col-xs-5 col-sm-3 col-lg-2">Active</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="checkbox" id="active" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php if($r['active']==1)echo' checked';?>>
                        <label for="active">
                    </div>
                </div>
                <div class="form-group">
                    <label for="menu" class="control-label col-xs-5 col-sm-3 col-lg-2">Menu</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <select id="menu" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','menu',$(this).val());">
                            <option value="head"<?php if($r['menu']=='head')echo' selected';?>>Head</option>
                            <option value="other"<?php if($r['menu']=='other')echo' selected';?>>Other</option>
                            <option value="footer"<?php if($r['menu']=='footer')echo' selected';?>>Footer</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="file" class="control-label col-xs-5 col-sm-3 col-lg-2">Template File</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="file" class="form-control textinput" value="<?php echo$r['file'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="file" placeholder="Enter HTML Template File...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
