<?php
$rank=0;
$show='pages';
if($args[0]=='edit')$show='item';
if($show=='pages'){
    $s=$db->prepare("SELECT * FROM menu ORDER BY menu DESC, ord ASC");
    $s->execute();?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Pages</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-xs-9">Title</th>
                        <th class="col-xs-3"></th>
                    </tr>
                </thead>
                <tbody id="sortable" class="sortable" data-t="menu" data-c="ord">
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
                    <tr id="l_<?php echo$r['id'];?>" class="item" data-id="<?php echo$r['id'];?>">
                        <td><a href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"><?php echo$r['title'];?></a></td>
                        <td id="controls_<?php echo$r['id'];?>" class="text-right">
                            <input type="checkbox" id="active<?php echo$r['id'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php if($r['active']==1)echo' checked';?>>
                            <label for="active<?php echo$r['id'];?>" class="btn btn-default btn-sm"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Toggle Active State"';?>></label>
                            <a class="btn btn-primary btn-sm" href="<?php echo URL.$settings['system']['admin'].'/pages/edit/'.$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><i class="libre libre-edit"></i></a>
                            <button class="btn btn-default btn-sm handle"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Drag to Change Order"';?>><i class="libre libre-resize-vertical"></i></button>
                        </td>
                    </tr>
<?php }?>
                    <tr class="ghost hidden"><td colspan="3">&nbsp;</td></tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
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
        <a class="btn btn-default pull-right" href="<?php echo URL.$settings['system']['admin'].'/pages';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><i class="libre libre-back"></i></a>
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
                        <input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" placeholder="Enter a Title...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="active" class="control-label col-xs-5 col-sm-3 col-lg-2">Active</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="checkbox" id="active" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php if($r['active']==1)echo' checked';?>>
                        <label for="active">
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
                            <div class="input-group-addon"><i class="libre libre-link"></i></div>
                            <input type="text" id="coverURL" class="form-control" value="<?php echo$r['coverURL'];?>" onchange="coverUpdate('<?php echo$r['id'];?>','menu','coverURL',$(this).val());" placeholder="Enter Cover URL...">
                            <div class="input-group-btn">
                                <a class="btn btn-info" data-toggle="modal" data-target="#media" href="core/edit_image.php?id=<?php echo$r['id'];?>&t=menu&c=coverURL"><i class="libre libre-edit"></i></a>
                                <button class="btn btn-danger" onclick="coverUpdate('<?php echo$r['id'];?>','menu','coverURL','');"><i class="libre libre-trash"></i></button>
                            </div>
                        </div>
                        <div class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">Editing a URL Image will retreive the image to the server for Editing.</div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
                            <input type="text" id="cover" class="form-control hidden-xs" value="<?php echo$r['cover'];?>" disabled>
                            <div class="input-group-btn">
                                <form method="post" target="sp" enctype="multipart/form-data" action="core/add_data.php">
                                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                                    <input type="hidden" name="act" value="add_cover">
                                    <input type="hidden" name="t" value="menu">
                                    <input type="hidden" name="c" value="cover">
                                    <div class="btn btn-info btn-file">
                                        <span class="libre-stack">
                                            <i class="libre libre-stack-1x libre-desktop"></i>
                                            <i class="libre libre-stack-1x libre-action text-info"></i>
                                            <i class="libre libre-stack-action libre-action-select"></i>
                                        </span>
                                        <input type="file" name="fu"<?php if($user['options']{1}==0)echo' disabled';?>>
                                    </div>
                                    <button class="btn btn-success<?php if($user['options']{1}==0)echo' disabled';?> hidden-xs" onclick="$('#block').css({'display':'block'});"><i class="libre libre-upload"></i></button>
                                </form>
                            </div>
                            <div class="input-group-btn">
                                <a class="btn btn-info" data-toggle="modal" data-target="#media" href="core/browse_media.php?id=<?php echo$r['id'];?>&t=menu&c=cover"><span class="libre-stack"><i class="libre libre-stack-1x libre-picture"></i><i class="libre libre-stack-1x libre-action text-info"></i><i class="libre libre-stack-action libre-action-select"></i></span></a>
                                <a class="btn btn-info" data-toggle="modal" data-target="#media" href="core/edit_image.php?id=<?php echo$r['id'];?>&t=menu&c=cover"><i class="libre libre-edit"></i></a>
                                <button class="btn btn-danger" onclick="coverUpdate('<?php echo$r['id'];?>','menu','cover','');"><i class="libre libre-trash"></i></button>
                            </div>
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
<?php // SEO ?>
            <div role="tabpanel" class="tab-pane" id="page-seo">
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
<?php // Settings ?>
            <div role="tabpanel" class="tab-pane" id="page-settings">
                <div class="form-group">
                    <label for="menu" class="control-label col-xs-5 col-sm-3 col-lg-2">Menu</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <select id="menu" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','menu',$(this).val());">
                            <option value="head"<?php if($r['menu']=='head')echo' selected';?>>Head</option>
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
