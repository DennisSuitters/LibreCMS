<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-6">Preferences</h4>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#theme" data-toggle="tab">Theme</a></li>
            <li><a href="#contact" data-toggle="tab">Contact</a></li>
            <li><a href="#interface" data-toggle="tab">Interface</a></li>
            <li><a href="#seo" data-toggle="tab">SEO</a></li>
            <li><a href="#backrestore" data-toggle="tab">Backup</a></li>
        </ul>
        <div class="tab-content">
            <div id="theme" class="tab-pane fade in active">
                <div class="row theme-chooser">
<?php foreach(new DirectoryIterator('layout') as$folder){
    if($folder->isDOT())continue;
    if($folder->isDir()){
        $theme=parse_ini_file('layout/'.$folder.'/theme.ini',true);?>
                    <div class="col-xs-12 col-md-3">
                        <div class="theme-chooser-item panel<?php if($config['theme']==$folder)echo' panel-success';?>" data-theme="<?php echo$folder;?>">
                            <div class="panel-image">
                                <img class="img-responsive" src="<?php if(file_exists('layout/'.$folder.'/theme.jpg'))echo'layout/'.$folder.'/theme.jpg';elseif(file_exists('layout/'.$folder.'/theme.png'))echo'layout/'.$folder.'/theme.png';else echo'core/images/noimage.jpg';?>" alt="<?php echo$theme['title'];?>">
                            </div>
                            <div class="panel-body panel-content">
                                <h4 class="panel-title text-white text-shadow-depth-1-half"><?php if(isset($theme['title'])&&$theme['title']!='')echo$theme['title'];else echo'No Title Assigned';?></h4>
                                <p>
<?php if(isset($theme['version'])&&$theme['version']!=''){
    echo'<small class="version">Version: '.$theme['version'].'</small><br>';
}
if(isset($theme['creator'])&&$theme['creator']!=''){
    echo'<small class="creator">Creator';
    if(isset($theme['creator_url'])&&$theme['creator_url']!='')echo': <a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>';
    else echo$theme['creator'];
    echo'</small><br>';
}
if(isset($theme['framework_name'])&&$theme['framework_name']!=''){
    echo'<small class="creator">Framework';
    if(isset($theme['framework_url'])&&$theme['framework_url']!='')echo': <a target="_blank" href="'.$theme['framework_url'].'">'.$theme['framework_name'].'</a>';
    else echo$theme['framework_name'];
    echo'</small><br>';
}
if(isset($theme['description'])&&$theme['description']!='')echo'<small class="description">'.$theme['description'].'</small>';?>
                                </p>
                            </div>
                        </div>
                    </div>
<?php }
}?>
                </div>
            </div>
            <div id="contact" class="tab-pane fade in">
                <div class="form-group">
                    <label for="business" class="control-label col-xs-5 col-sm-3 col-lg-2">Business</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="business" class="form-control textinput" value="<?php echo$config['business'];?>" data-dbid="1" data-dbt="config" data-dbc="business" placeholder="Enter a Business...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="abn" class="control-label col-xs-5 col-sm-3 col-lg-2">ABN</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="abn" class="form-control textinput" value="<?php echo$config['abn'];?>" data-dbid="1" data-dbt="config" data-dbc="abn" placeholder="Enter an ABN...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label col-xs-5 col-sm-3 col-lg-2">Email</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="Enter an Email...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="control-label col-xs-5 col-sm-3 col-lg-2">Phone</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="phone" class="form-control textinput" value="<?php echo$config['phone'];?>" data-dbid="1" data-dbt="config" data-dbc="phone" placeholder="Enter a Phone Number...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="mobile" class="control-label col-xs-5 col-sm-3 col-lg-2">Mobile</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="mobile" class="form-control textinput" value="<?php echo$config['mobile'];?>" data-dbid="1" data-dbt="config" data-dbc="mobile" placeholder="Enter a Mobile Number...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="control-label col-xs-5 col-sm-3 col-lg-2">Address</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="address" class="form-control textinput" value="<?php echo$config['address'];?>" data-dbid="1" data-dbt="config" data-dbc="address" placeholder="Enter an Address...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="suburb" class="control-label col-xs-5 col-sm-3 col-lg-2">Suburb</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="suburb" class="form-control textinput" value="<?php echo$config['suburb'];?>" data-dbid="1" data-dbt="config" data-dbc="suburb" placeholder="Enter a Suburb...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="city" class="control-label col-xs-5 col-sm-3 col-lg-2">City</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="city" class="form-control textinput" value="<?php echo$config['city'];?>" data-dbid="1" data-dbt="config" data-dbc="city" placeholder="Enter a City...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="state" class="control-label col-xs-5 col-sm-3 col-lg-2">State</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="state" class="form-control textinput" value="<?php echo$config['state'];?>" data-dbid="1" data-dbt="config" data-dbc="state" placeholder="Enter a State...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="postcode" class="control-label col-xs-5 col-sm-3 col-lg-2">Postcode</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="postcode" class="form-control textinput" value="<?php if($config['postcode']!=0)echo$config['postcode'];?>" data-dbid="1" data-dbt="config" data-dbc="postcode" placeholder="Enter a Postcode...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="country" class="control-label col-xs-5 col-sm-3 col-lg-2">Country</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="country" class="form-control textinput" value="<?php echo$config['country'];?>" data-dbid="1" data-dbt="config" data-dbc="country" placeholder="Enter a Country...">
                    </div>
                </div>
            </div>
            <div id="interface" name="interface" class="tab-pane fade in">
                <div class="form-group">
                    <div class="control-label col-xs-5 col-sm-3 col-lg-2 text-right">
                        <input type="checkbox" id="maintenance0" data-dbid="1" data-dbt="config" data-dbc="maintenance" data-dbb="0"<?php if($config['maintenance']{0}==1)echo' checked';?>>
                        <label for="maintenance0">
                    </div>
                    <label for="maintenance0" class="input-group col-xs-7 col-sm-9 col-lg-10"><span<?php if($config['maintenance']{0}==1)echo' data-toggle="tooltip" title="Toggle Site Maintenance Mode."';?>>Maintenance</span></label>
                </div>
                <div class="form-group clearfix">
                    <div class="control-label col-xs-5 col-sm-3 col-lg-2 text-right">
                        <input type="checkbox" id="options4" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4"<?php if($config['options']{4}==1)echo' checked';?>>
                        <label for="options4">
                    </div>
                    <label for="options4" class="input-group col-xs-7 col-sm-9 col-lg-10"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Administration Tooltops, like this one."';?>>Enable Tooltips</span></label>
                </div>
                <div class="form-group">
                    <label for="idleTime" class="control-label col-xs-5 col-sm-3 col-lg-2">Idle Timeout</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="idleTime" class="form-control textinput" value="<?php echo$config['idleTime'];?>" data-dbid="1" data-dbt="config" data-dbc="idleTime" placeholder="Enter a Time in Minutes..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Time in Minutes for Idle Timeout for Auto Logout..."';?>>
                        <div class="input-group-addon">Minutes</div>
                    </div>
                    <div class="col-xs-7 col-sm-9 col-lg-10 pull-right">
                        <div class="help-block">'0' Disables Idle Timeout...</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label for="dateFormat" class="control-label col-xs-5 col-sm-3 col-lg-2">Date/Time Format</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="dateFormat" class="form-control textinput" value="<?php echo$config['dateFormat'];?>" data-dbid="1" data-dbt="config" data-dbc="dateFormat" placeholder="Enter a Date/Time Format..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Format Layout of all Dates/Times displayed."';?>>
                        <span class="help-block">For information on Date Format Characters click <a target="_blank" href="http://php.net/manual/en/function.date.php#refsect1-function.date-parameters">here</a>.</span>
                    </div>
                </div>
            </div>
            <div id="seo" class="tab-pane fade in">
                <h4>Default Analytics</h4>
                <div class="form-group">
                    <div class="col-xs-5 col-sm-3 col-lg-2"></div>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <span class="help-block">These will be used if Page or Content Seo Fields are empty.</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Title</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$config['seoTitle'];?>" data-dbid="1" data-dbt="config" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Caption</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$config['seoCaption'];?>" data-dbid="1" data-dbt="config" data-dbc="seoCaption" placeholder="Enter a Caption...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Description</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$config['seoDescription'];?>" data-dbid="1" data-dbt="config" data-dbc="seoDescription" placeholder="Enter a Description...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Keywords</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$config['seoKeywords'];?>" data-dbid="1" data-dbt="config" data-dbc="seoKeywords" placeholder="Enter Keywords...">
                    </div>
                </div>
            </div>
            <div id="backrestore" class="tab-pane fade in">
                <div id="backup" class="well" name="backup">
                    <h4>Database Backup/Restore</h4>
                    <div id="backup_info">
<?php $tid=$ti-2592000;
if($config['backup_ti']<$tid){
    if($config['backup_ti']==0){?>
                        <div class="alert alert-info">A Backup has yet to be performed.</div>
<?php }else{?>
                        <div class="alert alert-danger">It has been more than 30 days since a Backup has been performed.</div>
<?php }
}?>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5 col-sm-3 col-lg-2">Backup</label>
                        <form target="sp" method="post" action="core/backup.php">
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default btn-block" onclick="$('#block').css({'display':'block'});">Perform Backup</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-5 col-sm-3 col-lg-2">Restore</label>
                        <form target="sp" method="post" enctype="multipart/form-data" action="core/restorebackup.php">
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <div class="btn btn-default btn-block btn-file">
                                    Select .sql file to restore<input type="file" id="fu" class="form-control" name="fu" accept="application/sql">
                                </div>
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default" onclick="$('#block').css({'display':'block'});">Restore</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="backup" class="form-group">
<?php foreach(glob("media/backup/*")as$file){
    $fileid=str_replace('.','',$file);
    $fileid=str_replace('/','',$fileid);?>
                        <div id="l_<?php echo$fileid;?>" class="form-group">
                            <label class="control-label col-xs-5 col-sm-3 col-lg-2">&nbsp;</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <a class="btn btn-default btn-block" href="<?php echo$file;?>">Click to Download <?php echo ltrim($file,'media/backup/');?></a>
                                <div class="input-group-btn">
                                    <button class="btn btn-default trash" onclick="removeMedia('<?php echo$file;?>')"><i class="libre libre-trash"></i></button>
                                </div>
                            </div>
                        </div>
<?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
