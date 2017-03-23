<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Preferences</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#preferences"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div id="update" class="panel-body">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#preference-theme" data-toggle="tab">Theme</a></li>
      <li><a href="#preference-contact" data-toggle="tab">Contact</a></li>
      <li><a href="#preference-social" data-toggle="tab">Social</a></li>
      <li><a href="#preference-interface" data-toggle="tab">Interface</a></li>
      <li><a href="#preference-seo" data-toggle="tab">SEO</a></li>
      <li><a href="#preference-backrestore" data-toggle="tab">Backup</a></li>
<?php if($user['rank']>899){?>
      <li><a href="#preference-info" data-toggle="tab">Info</a></li>
<?php }?>
    </ul>
    <div class="tab-content">
      <div id="preference-theme" name="preference-theme" class="tab-pane fade in active">
        <div class="row theme-chooser">
<?php $folders=preg_grep('/^([^.])/',scandir("layout"));
foreach($folders as$folder){
  $theme=parse_ini_file('layout/'.$folder.'/theme.ini',true);?>
          <div class="col-xs-12 col-md-3">
            <div class="theme-chooser-item panel<?php if($config['theme']==$folder)echo' panel-success';?>" data-theme="<?php echo$folder;?>">
              <div class="panel-image">
                <img class="img-responsive" src="<?php if(file_exists('layout/'.$folder.'/theme.jpg'))echo'layout/'.$folder.'/theme.jpg';elseif(file_exists('layout/'.$folder.'/theme.png'))echo'layout/'.$folder.'/theme.png';else echo'core/images/noimage.jpg';?>" alt="<?php echo$theme['title'];?>">
              </div>
              <div class="panel-body panel-content">
                <h4 class="panel-title text-white text-shadow-depth-1-half"><?php if(isset($theme['title'])&&$theme['title']!='')echo$theme['title'];else echo'No Title Assigned';?></h4>
                <p>
<?php if(isset($theme['version'])&&$theme['version']!='')echo'<small class="version">Version: '.$theme['version'].'</small><br>';
  if(isset($theme['creator'])&&$theme['creator']!=''){
    echo'<small class="creator">Creator';
  if(isset($theme['creator_url'])&&$theme['creator_url']!='')
    echo': <a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>';
  else
    echo$theme['creator'];echo'</small><br>';
  }
  if(isset($theme['framework_name'])&&$theme['framework_name']!=''){
    echo'<small class="creator">Framework';
  if(isset($theme['framework_url'])&&$theme['framework_url']!='')
    echo': <a target="_blank" href="'.$theme['framework_url'].'">'.$theme['framework_name'].'</a>';
  else
   echo$theme['framework_name'];echo'</small><br>';
  }?>
                </p>
              </div>
            </div>
          </div>
<?php }?>
        </div>
      </div>
      <script>/*<![CDATA[*/
        $("div.theme-chooser").not(".disabled").find("div.theme-chooser-item").on("click",function(){
          $('#preference-theme .theme-chooser-item').removeClass("panel-success");
          $(this).addClass("panel-success");
          update("1","config","theme",escape($(this).attr("data-theme")))
        });
      /*]]>*/</script>
      <div id="preference-contact" name="preference-contact" class="tab-pane fade in">
        <div id="businessHasError" class="form-group<?php if($config['business']=='')echo' has-error';?>">
          <label for="business" class="control-label col-xs-5 col-sm-3 col-lg-2">Business</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="business"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="business" class="form-control textinput" value="<?php echo$config['business'];?>" data-dbid="1" data-dbt="config" data-dbc="business" placeholder="Enter a Business...">
          </div>
          <div id="businessErrorBlock" class="help-block text-right<?php if($config['business']!='')echo' hidden';?>">Enter a Business Name, otherwise some functions such as Messages, and Bookings will NOT function correctly.</div>
        </div>
        <div class="form-group">
          <label for="abn" class="control-label col-xs-5 col-sm-3 col-lg-2">ABN</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="abn"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="abn" class="form-control textinput" value="<?php echo$config['abn'];?>" data-dbid="1" data-dbt="config" data-dbc="abn" placeholder="Enter an ABN...">
          </div>
        </div>
        <div id="emailHasError" class="form-group<?php if($config['email']=='')echo' has-error';?>">
          <label for="email" class="control-label col-xs-5 col-sm-3 col-lg-2">Email</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="email"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="Enter an Email...">
          </div>
          <div id="emailErrorBlock" class="help-block text-right<?php if($config['email']!='')echo' hidden';?>">Enter an Email, otherwise some functions such as Messages, and Bookings will NOT function correctly.</div>
        </div>
        <div class="form-group">
          <label for="phone" class="control-label col-xs-5 col-sm-3 col-lg-2">Phone</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="phone"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="phone" class="form-control textinput" value="<?php echo$config['phone'];?>" data-dbid="1" data-dbt="config" data-dbc="phone" placeholder="Enter a Phone Number...">
          </div>
        </div>
        <div class="form-group">
          <label for="mobile" class="control-label col-xs-5 col-sm-3 col-lg-2">Mobile</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="mobile"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="mobile" class="form-control textinput" value="<?php echo$config['mobile'];?>" data-dbid="1" data-dbt="config" data-dbc="mobile" placeholder="Enter a Mobile Number...">
          </div>
        </div>
        <div class="form-group">
          <label for="address" class="control-label col-xs-5 col-sm-3 col-lg-2">Address</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="address"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="address" class="form-control textinput" value="<?php echo$config['address'];?>" data-dbid="1" data-dbt="config" data-dbc="address" placeholder="Enter an Address...">
          </div>
        </div>
        <div class="form-group">
          <label for="suburb" class="control-label col-xs-5 col-sm-3 col-lg-2">Suburb</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="suburb"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="suburb" class="form-control textinput" value="<?php echo$config['suburb'];?>" data-dbid="1" data-dbt="config" data-dbc="suburb" placeholder="Enter a Suburb...">
          </div>
        </div>
        <div class="form-group">
          <label for="city" class="control-label col-xs-5 col-sm-3 col-lg-2">City</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="city"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="city" class="form-control textinput" value="<?php echo$config['city'];?>" data-dbid="1" data-dbt="config" data-dbc="city" placeholder="Enter a City...">
          </div>
        </div>
        <div class="form-group">
          <label for="state" class="control-label col-xs-5 col-sm-3 col-lg-2">State</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="state"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="state" class="form-control textinput" value="<?php echo$config['state'];?>" data-dbid="1" data-dbt="config" data-dbc="state" placeholder="Enter a State...">
          </div>
        </div>
        <div class="form-group">
          <label for="postcode" class="control-label col-xs-5 col-sm-3 col-lg-2">Postcode</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="postcode"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="postcode" class="form-control textinput" value="<?php if($config['postcode']!=0)echo$config['postcode'];?>" data-dbid="1" data-dbt="config" data-dbc="postcode" placeholder="Enter a Postcode...">
          </div>
        </div>
        <div class="form-group">
          <label for="country" class="control-label col-xs-5 col-sm-3 col-lg-2">Country</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="country"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="country" class="form-control textinput" value="<?php echo$config['country'];?>" data-dbid="1" data-dbt="config" data-dbc="country" placeholder="Enter a Country...">
          </div>
        </div>
      </div>
      <div id="preference-social" name="preference-social" class="tab-pane">
        <legend class="control-legend">Social Networking</legend>
        <div class="form-group">
          <label for="options9" class="control-label check col-xs-5 col-sm-3 col-lg-2"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Toggle RSS Feed Icon."';?>>Show RSS Feed Icon</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="options9" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="9"<?php if($config['options']{9}==1)echo' checked';?>>
              <label for="options9"/>
            </div>
          </div>
        </div>
        <div class="form-group">
          <form target="sp" method="post" action="core/add_data.php">
            <input type="hidden" name="user" value="0">
            <input type="hidden" name="act" value="add_social">
            <div class="input-group col-xs-12">
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
            <div class="input-group col-xs-12">
              <div class="input-group-addon">
                <span class="libre-social"><?php svg('social-'.$rs['icon']);?></span>
              </div>
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
<?php if($user['rank']==1000){?>
        <div class="form-group">
          <label for="development0" class="control-label check col-xs-5 col-sm-3 col-lg-2"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Toggle Development Mode Showing Errors."';?>>Development Mode</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="development0" data-dbid="1" data-dbt="config" data-dbc="development" data-dbb="0"<?php if($config['development']{0}==1)echo' checked';?>>
              <label for="development0"/>
            </div>
          </div>
        </div>
<?php if(file_exists('media'.DS.'cache'.DS.'error.log')){?>
        <div id="l_0">
            <div class="form-group">
              <label for="error_log" class="control-label col-xs-5 col-sm-3 col-lg-2">Error Log</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <div class="input-group-btn">
                    <button class="btn btn-default" onclick="$('#logview').toggleClass('hidden');$('#logfile').load('media/cache/error.log?<?php echo time();?>');">View Logs</button>
                    <button class="btn btn-default trash" onclick="purge('0','errorlog')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="This will Remove the Error Logs, there is no getting it back."';?>><?php svg('purge');?></button>
                </div>
              </div>
            </div>
            <div id="logview" class="form-group hidden">
                <div class="col-xs-5 col-sm-3 col-lg-2"></div>
                <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                    <div class="well col-xs-12"><small id="logfile" style="white-space:pre"></small></div>
                </div>
            </div>
        </div>
<?php }
}?>
        <div class="form-group">
          <label for="maintenance0" class="control-label check col-xs-5 col-sm-3 col-lg-2"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Toggle Site Maintenance Mode."';?>>Maintenance Mode</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="maintenance0" data-dbid="1" data-dbt="config" data-dbc="maintenance" data-dbb="0"<?php if($config['maintenance']{0}==1)echo' checked';?>>
              <label for="maintenance0"/>
            </div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="options4" class="control-label check col-xs-5 col-sm-3 col-lg-2"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Administration Tooltops, like this one."';?>>Enable Tooltips</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="options4" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4"<?php if($config['options']{4}==1)echo' checked';?>>
              <label for="options4"/>
            </div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="notification_volume" class="control-label col-xs-5 col-sm-3 col-lg-2">Notification Volume</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <input type="range" id="notification_volume" class="form-control" min="0" max="100" step="1" value="<?php echo$config['notification_volume'];?>" oninput="notification_volume_output.value=value;" onchange="update('1','config','notification_volume',$(this).val());">
            <output id="notification_volume_output" class="input-group-output"><?php echo$config['notification_volume'];?></output>
          </div>
          <small class="help-block text-right">'0' Disables Idle Audio Notification.</small>
        </div>
        <div class="form-group">
          <label for="uti_freq" class="control-label col-xs-5 col-sm-3 col-lg-2">Update Frequency</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <select id="uti_freq" class="form-control" onchange="update('1','config','uti_freq',$(this).val());"<?php if($user['options']{1}==0)echo' readonly';if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
              <option value="0"<?php if($config['uti_freq']==0)echo' selected';?>>Never</option>
              <option value="3600"<?php if($config['uti_freq']==3600)echo' selected';?>>Hourly</option>
              <option value="84600"<?php if($config['uti_freq']==84600)echo' selected';?>>Daily</option>
              <option value="604800"<?php if($config['uti_freq']==604800)echo' selected';?>>Weekly</option>
              <option value="2629743"<?php if($config['uti_freq']==2629743)echo' selected';?>>Monthly</option>
            </select>
            <div class="input-group-btn">
              <button class="btn btn-default" onclick="$('#updatecheck').removeClass('hidden').load('core/layout/updatecheck.php');">Check Now</button>
            </div>
          </div>
        </div>
        <div id="updatecheck" class="col-xs-7 col-sm-9 col-lg-10 pull-right hidden">
          <div class="alert alert-warning"><?php svg('spinner-13','animated spin');?> Checking for new updates!</div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
          <label for="update_url" class="control-label col-xs-5 col-sm-3 col-lg-2">Update URL</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="update_url"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="update_url" class="form-control textinput" value="<?php echo$config['update_url'];?>" data-dbid="1" data-dbt="config" data-dbc="update_url" placeholder="Enter an Update URL..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="URL to Fetch System Updates From..."';?>>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="idleTime" class="control-label col-xs-5 col-sm-3 col-lg-2">Idle Timeout</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <input type="text" id="idleTime" class="form-control textinput" value="<?php echo$config['idleTime'];?>" data-dbid="1" data-dbt="config" data-dbc="idleTime" placeholder="Enter a Time in Minutes..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Time in Minutes for Idle Timeout for Auto Logout..."';?>>
            <div class="input-group-addon">Minutes</div>
          </div>
          <small class="help-block text-right">'0' Disables Idle Timeout.</small>
        </div>
        <div class="form-group">
          <label for="dateFormat" class="control-label col-xs-5 col-sm-3 col-lg-2">Date/Time Format</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="dateFormat"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="dateFormat" class="form-control textinput" value="<?php echo$config['dateFormat'];?>" data-dbid="1" data-dbt="config" data-dbc="dateFormat" placeholder="Enter a Date/Time Format..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Format Layout of all Dates/Times displayed."';?>>
          </div>
          <small class="help-block text-right">For information on Date Format Characters click <a target="_blank" href="http://php.net/manual/en/function.date.php#refsect1-function.date-parameters">here</a>.</small>
        </div>
        <div class="form-group">
          <small class="help-block text-right">Select a theme image to use. We'll add more from time to time. Photo's are from <a target="_blank" href="https://unsplash.com/">UnSplash</a></small>
          <div class="input-group col-xs-12">
            <div id="bg0" class="col-xs-3 col-sm-2 adminbg<?php if(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='')echo' active';?>" onclick="changeBackground('bg0');">
              <img class="img-thumbnail" src="core/images/bg0-menu.png">
<?php // https://unsplash.com/@vingtcent ?>
            </div>
            <div id="bg1" class="col-xs-3 col-sm-2 adminbg<?php if(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg1')echo' active';?>" onclick="changeBackground('bg1');">
              <img class="img-thumbnail" src="core/images/bg1-menu.jpg">
<?php // https://unsplash.com/@vingtcent ?>
            </div>
            <div id="bg2" class="col-xs-3 col-sm-2 adminbg<?php if(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg2')echo' active';?>" onclick="changeBackground('bg2');">
              <img class="img-thumbnail" src="core/images/bg2-menu.jpg">
<?php // https://unsplash.com/@alanaut24 ?>
            </div>
            <div id="bg3" class="col-xs-3 col-sm-2 adminbg<?php if(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg3')echo' active';?>" onclick="changeBackground('bg3');">
              <img class="img-thumbnail" src="core/images/bg3-menu.jpg">
<?php // https://unsplash.com/@hilesy ?>
            </div>
            <div id="bg4" class="col-xs-3 col-sm-2 adminbg<?php if(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg4')echo' active';?>" onclick="changeBackground('bg4');">
              <img class="img-thumbnail" src="core/images/bg4-menu.jpg">
<?php // https://unsplash.com/@shontzphotography ?>
            </div>
            <div id="bg5" class="col-xs-3 col-sm-2 adminbg<?php if(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg5')echo' active';?>" onclick="changeBackground('bg5');">
              <img class="img-thumbnail" src="core/images/bg5-menu.jpg">
<?php // https://unsplash.com/@adriel ?>
            </div>
            <div id="bg6" class="col-xs-3 col-sm-2 adminbg<?php if(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg6')echo' active';?>" onclick="changeBackground('bg6');">
              <img class="img-thumbnail" src="core/images/bg6-menu.jpg">
<?php // https://unsplash.com/@devel ?>
            </div>
          </div>
        </div>
      </div>
      <div id="preference-seo" name="preference-seo" class="tab-pane fade in">
        <div class="form-group">
          <label class="control-label col-xs-5 col-sm-3 col-lg-2">sitemap.xml</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <a target="_blank" href="<?php echo URL.'sitemap.xml';?>"><?php echo URL.'sitemap.xml';?></a>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-5 col-sm-3 col-lg-2">humans.txt</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <a id="humans" target="_blank" href="<?php echo URL.'humans.txt';?>"><?php echo URL.'humans.txt';?></a>
          </div>
        </div>
        <div class="form-group">
          <small class="help-block text-right">These will be used if Page or Content Seo Fields are empty.</small>
        </div>
        <div class="form-group clearfix">
          <label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Title</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoTitle"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
<?php $cntc=70-strlen($config['seoTitle']);
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
            <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$config['seoTitle'];?>" data-dbid="1" data-dbt="config" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
          </div>
          <small class="help-block text-right">The recommended character count for Title's is 70.</small>
        </div>
        <div class="form-group clearfix">
          <label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Caption</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoCaption"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
<?php $cntc=160-strlen($config['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div class="input-group-addon">
              <span id="seoCaptioncnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
            </div>
            <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$config['seoCaption'];?>" data-dbid="1" data-dbt="config" data-dbc="seoCaption" placeholder="Enter a Caption...">
          </div>
          <small class="help-block text-right">The recommended character count for Captions is 160, as sometime Captions may be used in Descriptions.</small>
        </div>
        <div class="form-group clearfix">
          <label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Description</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoDescription"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
<?php $cntc=160-strlen($config['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div class="input-group-addon">
              <span id="seoDescriptioncnt" class="text-success<?php if($cnt<0)echo' text-danger';?>"><?php echo$cnt;?></span>
            </div>
            <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$config['seoDescription'];?>" data-dbid="1" data-dbt="config" data-dbc="seoDescription" placeholder="Enter a Description...">
          </div>
          <small class="help-block text-right">The recommended character count for Descriptions is 160.</small>
        </div>
        <div class="form-group">
          <label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Keywords</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoKeywords"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$config['seoKeywords'];?>" data-dbid="1" data-dbt="config" data-dbc="seoKeywords" placeholder="Enter Keywords...">
          </div>
        </div>
        <h4>Google Analytics</h4>
        <div class="form-group">
          <label for="ga_verification" class="control-label col-xs-5 col-sm-3 col-lg-2">Site Verification</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="ga_verification"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="ga_verification" class="form-control textinput" value="<?php echo$config['ga_verification'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_verification" placeholder="Enter Google Site Verification Code...">
          </div>
        </div>
        <div class="form-group">
          <label for="ga_tracking" class="control-label col-xs-5 col-sm-3 col-lg-2">Tracking Code</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="ga_tracking"><?php svg('fingerprint');?></button>
            </div>
            <div id="da" class="hidden-xs" data-dbid="1" data-dbt="config" data-dbc="ga_tracking"></div>
<?php }?>
            <form target="sp" method="post" action="core/update.php" onsubmit="Pace.restart();$('#ga_tracking_save').removeClass('btn-danger');">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="ga_tracking">
              <button type="submit" id="ga_tracking_save" class="btn btn-default"><?php svg('floppy');?></button>
              <textarea id="ga_tracking" class="form-control" style="height:100px" name="da" onkeyup="$('#ga_tracking_save').addClass('btn-danger');"><?php echo$config['ga_tracking'];?></textarea>
            </form>
          </div>
        </div>
        <div class="form-group">
          <small class="help-block text-right">Go to <a target="_blank" href="https://analytics.google.com">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>The <code>&lt;script&gt;&lt;/script&gt;</code> tags aren't necessary as they will be stripped from the text when saved.</small>
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
                  <button type="submit" class="btn btn-default btn-block" onclick="Pace.restart();">Perform Backup</button>
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
              <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
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
                <div class="btn btn-default btn-block btn-file">Select .sql file to restore<input type="file" id="fu" class="form-control" name="fu" accept="application/sql"></div>
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default" onclick="Pace.restart();">Restore</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
<?php if($user['rank']>899){?>
      <div id="preference-info" name="preference-info" class="tab-pane fade in">
        <h4>Information</h4>
          <div class="form-group">
<?php if(version_compare(phpversion(),'7.0','<')){?>
            <div class="alert alert-info">LibreCMS is able to run on PHP 7+</div>
<?php }
ob_start();
phpinfo();
preg_match('%<style type="text/css">(.*?)</style>.*?(<body>.*</body>)%s',ob_get_clean(),$matches);
echo"<div class='phpinfodisplay'><style type='text/css'>\n",join("\n",array_map(create_function('$i','return ".phpinfodisplay ".preg_replace("/,/",",.phpinfodisplay ",$i);'),preg_split('/\n/',$matches[1]))),"</style>\n",$matches[2],"\n</div>\n";?>
          </div>
        </div>
        <style>
          .phpinfodisplay table{table-layout:fixed}
          .phpinfodisplay td,
          .phpinfodisplay th{white-space:normal;word-wrap:break-word}
        </style>
<?php }?>
      </div>
    </div>
  </div>
</div>
