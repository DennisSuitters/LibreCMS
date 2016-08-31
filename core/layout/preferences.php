<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="col-xs-8">Preferences</h4>
        <div class="pull-right">
            <div class="btn-group">
                <a target="_blank" class="btn btn-default info btn-xs" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#preferences"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#preference-theme" data-toggle="tab">Theme</a></li>
            <li><a href="#preference-contact" data-toggle="tab">Contact</a></li>
            <li><a href="#preference-social" data-toggle="tab">Social</a></li>
            <li><a href="#preference-interface" data-toggle="tab">Interface</a></li>
            <li><a href="#preference-seo" data-toggle="tab">SEO</a></li>
            <li><a href="#preference-backrestore" data-toggle="tab">Backup</a></li>
        </ul>
        <div class="tab-content">
            <div id="preference-theme" name="preference-theme" class="tab-pane fade in active">
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
            <script>
                $("div.theme-chooser").not(".disabled").find("div.theme-chooser-item").on("click",function(){
                    $('#preference-theme .theme-chooser-item').removeClass("panel-success");
                    $(this).addClass("panel-success");
                    update("1","config","theme",escape($(this).attr("data-theme")))
                });
            </script>
            <div id="preference-contact" name="preference-contact" class="tab-pane fade in">
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
            <div id="preference-social" name="preference-social" class="tab-pane">
                <legend class="control-legend">Social Networking</legend>
                <div class="form-group">
                    <div class="control-label col-xs-5 col-sm-3 col-lg-2 text-right"></div>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" id="options9" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="9"<?php if($config['options']{9}==1)echo' checked';?>>
                            <label for="options9"<?php if($config['options']{9}==1)echo' data-toggle="tooltip" title="Toggle RSS Feed Icon."';?>>Show RSS Feed Icon</label>
                        </div>
                    </div>
                </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-lg-2">&nbsp;</label>
                        <form target="sp" method="post" action="core/add_data.php">
                            <input type="hidden" name="user" value="0">
                            <input type="hidden" name="act" value="add_social">
                            <div class="input-group col-xs-12 col-sm-9 col-lg-10">
                                <span class="input-group-addon">Network</span>
                                <select class="form-control" name="icon">
                                    <option value="">None</option>
                                    <option value="500px">500px</option>
                                    <option value="amazon">Amazon</option>
                                    <option value="behance">Behance</option>
                                    <option value="bitcoin">Bitcoin</option>
                                    <option value="blogger">Blogger</option>
                                    <option value="buffer">Buffer</option>
                                    <option value="cargo">Cargo</option>
                                    <option value="codepen">Codepen</option>
                                    <option value="coroflot">Coroflot</option>
                                    <option value="creattica">Creattica</option>
                                    <option value="delicious">Delcicious</option>
                                    <option value="deviantart">DeviantArt</option>
                                    <option value="diaspora">Diaspora</option>
                                    <option value="digg">Digg</option>
                                    <option value="dribbble">Dribbble</option>
                                    <option value="dropbox">Dropbox</option>
                                    <option value="envato">Envato</option>
                                    <option value="exposure">Exposure</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="feedburner">Feedburner</option>
                                    <option value="flickr">Flickr</option>
                                    <option value="forrst">Forrst</option>
                                    <option value="github">GitHub</option>
                                    <option value="google-plus">Google+</option>
                                    <option value="gravatar">Gravatar</option>
                                    <option value="hackernews">Hackernews</option>
                                    <option value="icq">ICQ</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="kickstarter">Kickstarter</option>
                                    <option value="last-fm">Last FM</option>
                                    <option value="lego">Lego</option>
                                    <option value="linkedin">Linkedin</option>
                                    <option value="livejournal">LiveJournal</option>
                                    <option value="lynda">Lynda</option>
                                    <option value="massroots">Massroots</option>
                                    <option value="medium">Medium</option>
                                    <option value="netlify">Netlify</option>
                                    <option value="ovh">OVH</option>
                                    <option value="paypal">Paypal</option>
                                    <option value="periscope">Periscope</option>
                                    <option value="picasa">Picasa</option>
                                    <option value="pinterest">Pinterest</option>
                                    <option value="play-store">Play Store</option>
                                    <option value="quora">Quora</option>
                                    <option value="redbubble">Red Bubble</option>
                                    <option value="reddit">Reddit</option>
                                    <option value="sharethis">Sharethis</option>
                                    <option value="skype">Skype</option>
                                    <option value="snapchat">Snapchat</option>
                                    <option value="soundcloud">Soundcloud</option>
                                    <option value="stackoverflow">Stackoverflow</option>
                                    <option value="steam">Steam</option>
                                    <option value="stumbleupon">StumbleUpon</option>
                                    <option value="tsu">TSU</option>
                                    <option value="tumblr">Tumblr</option>
                                    <option value="twitch">Twitch</option>
                                    <option value="twitter">Twitter</option>
                                    <option value="ubiquiti">Ubiquiti</option>
                                    <option value="unsplash">Unsplash</option>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="vine">Vine</option>
                                    <option value="whatsapp">Whatsapp</option>
                                    <option value="wikipedia">Wikipedia</option>
                                    <option value="windows-store">Windows Store</option>
                                    <option value="xbox-live">Xbox Live</option>
                                    <option value="yahoo">Yahoo</option>
                                    <option value="yelp">Yelp</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="zerply">Zerply</option>
                                    <option value="zune">Zune</option>
                                </select>
                                <div class="input-group-addon">URL</div>
                                <input type="text" class="form-control" name="url" value="" placeholder="Enter a URL...">
                                <div class="input-group-btn">
                                    <button class="btn btn-default add"><?php svg('plus');?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="social">
<?php $ss=$db->prepare("SELECT * FROM choices WHERE contentType='social' AND uid=0 ORDER BY icon ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
                        <div id="l_<?php echo$rs['id'];?>" class="form-group">
                            <label class="control-label hidden-xs col-sm-3 col-lg-2">&nbsp;</label>
                            <div class="input-group col-xs-12 col-sm-9 col-lg-10">
                                <div class="input-group-addon"><span class="libre-social"><?php svg('social-'.$rs['icon']);?></span></div>
                                <input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','social','url',$(this).val());" placeholder="Enter a URL...">
                                <div class="input-group-btn">
                                    <form target="sp" action="core/purge.php">
                                        <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                                        <input type="hidden" name="t" value="choices">
                                        <button class="btn btn-default trash"><?php svg('trash');?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
<?php }?>
                    </div>
            </div>
            <div id="preference-interface" name="preference-interface" class="tab-pane fade in">
                <div class="form-group">
                    <div class="control-label col-xs-5 col-sm-3 col-lg-2 text-right"></div>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" id="maintenance0" data-dbid="1" data-dbt="config" data-dbc="maintenance" data-dbb="0"<?php if($config['maintenance']{0}==1)echo' checked';?>>
                            <label for="maintenance0"<?php if($config['maintenance']{0}==1)echo' data-toggle="tooltip" title="Toggle Site Maintenance Mode."';?>>Maintenance</label>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="control-label col-xs-5 col-sm-3 col-lg-2 text-right"></div>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <div class="checkbox checkbox-success">
                            <input type="checkbox" id="options4" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4"<?php if($config['options']{4}==1)echo' checked';?>>
                            <label for="options4"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Administration Tooltops, like this one."';?>>Enable Tooltips</label>
                        </div>
                    </div>
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
            <div id="preference-seo" name="preference-seo" class="tab-pane fade in">
                <div class="form-group">
                    <div class="col-xs-5 col-sm-3 col-lg-2"></div>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <span class="help-block">These will be used if Page or Content Seo Fields are empty.</span>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Title</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php $cntc=70-strlen($config['seoTitle']);if($cntc<0){$cnt=abs($cntc);$cnt=number_format($cnt)*-1;}else{$cnt=number_format($cntc);}?>
                        <div class="input-group-addon">
                            <span id="seoTitlecnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
                        </div>
                        <div class="input-group-btn">
                            <button class="btn btn-default" onclick="removeStopWords('seoTitle',$('#seoTitle').val());"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Remove Stop Words."';?>><?php svg('magic');?></button>
                        </div>
                        <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$config['seoTitle'];?>" data-dbid="1" data-dbt="config" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
                    </div>
                    <small class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">
                        The recommended character count for Title's is 70.
                    </small>
                </div>
                <div class="form-group clearfix">
                    <label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Caption</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php $cntc=160-strlen($config['seoCaption']);if($cntc<0){$cnt=abs($cntc);$cnt=number_format($cnt)*-1;}else{$cnt=number_format($cntc);}?>
                        <div class="input-group-addon">
                            <span id="seoCaptioncnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
                        </div>
                        <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$config['seoCaption'];?>" data-dbid="1" data-dbt="config" data-dbc="seoCaption" placeholder="Enter a Caption...">
                    </div>
                    <small class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">
                        The recommended character count for Captions is 160, as sometime Captions may be used in Descriptions.
                    </small>
                </div>
                <div class="form-group clearfix">
                    <label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Description</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php $cntc=160-strlen($config['seoDescription']);if($cntc<0){$cnt=abs($cntc);$cnt=number_format($cnt)*-1;}else{$cnt=number_format($cntc);}?>
                        <div class="input-group-addon">
                            <span id="seoDescriptioncnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
                        </div>
                        <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$config['seoDescription'];?>" data-dbid="1" data-dbt="config" data-dbc="seoDescription" placeholder="Enter a Description...">
                    </div>
                    <small class="help-block col-xs-7 col-sm-9 col-lg-10 pull-right">
                        The recommended character count for Descriptions is 160.
                    </small>
                </div>
                <div class="form-group">
                    <label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Keywords</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$config['seoKeywords'];?>" data-dbid="1" data-dbt="config" data-dbc="seoKeywords" placeholder="Enter Keywords...">
                    </div>
                </div>
                <h4>Google Analytics</h4>
                <div class="form-group">
                    <label for="ga_verification" class="control-label col-xs-5 col-sm-3 col-lg-2">Site Verification</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <input type="text" id="ga_verification" class="form-control textinput" value="<?php echo$config['ga_verification'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_verification" placeholder="Enter Google Site Verification Code...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="ga_tracking" class="control-label col-xs-5 col-sm-3 col-lg-2">Tracking Code</label>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <form target="sp" method="post" action="core/update.php" onsubmit="$('#block').css({'display':'block'});$('#ga_tracking_save').removeClass('btn-danger');">
                            <input type="hidden" name="id" value="1">
                            <input type="hidden" name="t" value="config">
                            <input type="hidden" name="c" value="ga_tracking">
                            <button type="submit" id="ga_tracking_save" class="btn btn-default"><?php svg('floppy');?></button>
                            <textarea id="ga_tracking" class="form-control" style="height:100px" name="da" onkeyup="$('#ga_tracking_save').addClass('btn-danger');"><?php echo$config['ga_tracking'];?></textarea>
                        </form>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-5 col-sm-3 col-lg-2"></div>
                    <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                        <span class="help-block">
                            Go to <a target="_blank" href="https://analytics.google.com">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>
                            The <code>&lt;script&gt;&lt;/script&gt;</code> tags aren't necessary as they will be stripped from the text when saved.
                        </span>
                    </div>
                </div>
            </div>
            <div id="preference-backrestore" name="preference-backrestore" class="tab-pane fade in">
                <div id="backup" name="backup">
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
                    <div id="backups" class="form-group">
<?php foreach(glob("media/backup/*")as$file){
    $fileid=str_replace('.','',$file);
    $fileid=str_replace('/','',$fileid);
    $filename=basename($file);?>
                        <div id="l_<?php echo$fileid;?>" class="form-group">
                            <label class="control-label col-xs-5 col-sm-3 col-lg-2">&nbsp;</label>
                            <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                                <a class="btn btn-default btn-block" href="<?php echo$file;?>">Click to Download <?php echo ltrim($file,'media/backup/');?></a>
                                <div class="input-group-btn">
                                    <button class="btn btn-default trash" onclick="removeBackup('<?php echo$fileid;?>','<?php echo$filename;?>')"><?php svg('trash');?></button>
                                </div>
                            </div>
                        </div>
<?php }?>
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
                </div>
            </div>
        </div>
    </div>
</div>