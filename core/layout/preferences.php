<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Preferences</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#preferences" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div id="update" class="panel-body">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#preference-theme" data-toggle="tab">Theme</a></li>
      <li><a href="#preference-contact" data-toggle="tab">Contact</a></li>
      <li><a href="#preference-social" data-toggle="tab">Social</a></li>
      <li><a href="#preference-interface" data-toggle="tab">Interface</a></li>
      <li><a href="#preference-seo" data-toggle="tab">SEO<?php echo($config['suggestions']==1?'<span data-toggle="tooltip" data-placement="top" title="Editing suggestions.">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</span>':'');?></a></li>
      <li><a href="#preference-backrestore" data-toggle="tab">Backup</a></li>
<?php echo($user['rank']>899?'<li><a href="#preference-info" data-toggle="tab">Info</a></li>':'');?>
    </ul>
    <div class="tab-content">
      <div id="preference-theme" name="preference-theme" class="tab-pane fade in active">
        <div class="row theme-chooser">
<?php $folders=preg_grep('/^([^.])/',scandir("layout"));
foreach($folders as$folder){
  $theme=parse_ini_file('layout/'.$folder.'/theme.ini',true);?>
          <div class="col-xs-12 col-md-3">
            <div class="theme-chooser-item panel<?php echo($config['theme']==$folder?' panel-success':'');?>" data-theme="<?php echo$folder;?>">
              <div class="panel-image">
                <img class="img-responsive" src="<?php if(file_exists('layout'.DS.$folder.DS.'theme.jpg'))echo'layout'.DS.$folder.DS.'theme.jpg';elseif(file_exists('layout'.DS.$folder.DS.'theme.png'))echo'layout'.DS.$folder.DS.'theme.png';else echo NOIMAGE;?>" alt="<?php echo $theme['title'];?>">
              </div>
              <div class="panel-body panel-content">
                <h4 class="panel-title text-white text-shadow-depth-1-half"><?php echo(isset($theme['title'])&&$theme['title']!=''?$theme['title']:'No Title Assigned');?></h4>
                <p>
<?php echo(isset($theme['version'])&&$theme['version']!=''?'<small class="version">Version: '.$theme['version'].'</small><br>':'');
  if(isset($theme['creator'])&&$theme['creator']!='')
    echo'<small class="creator">Creator'.(isset($theme['creator_url'])&&$theme['creator_url']!=''?': <a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>':$theme['creator']).'</small><br>';
  if(isset($theme['framework_name'])&&$theme['framework_name']!='')
    echo'<small class="creator">Framework'.(isset($theme['framework_url'])&&$theme['framework_url']!=''?': <a target="_blank" href="'.$theme['framework_url'].'">'.$theme['framework_name'].'</a>':$theme['framework_name']).'</small><br>';?>
                </p>
              </div>
            </div>
          </div>
<?php }?>
        </div>
      </div>
      <script>/*<![CDATA[*/
        $("div.theme-chooser").not(".disabled").find("div.theme-chooser-item").on("click", function () {
          $('#preference-theme .theme-chooser-item').removeClass("panel-success");
          $(this).addClass("panel-success");
          update("1","config","theme",escape($(this).attr("data-theme")))
        });
      /*]]>*/</script>
      <div id="preference-contact" name="preference-contact" class="tab-pane fade in">
        <div id="businessHasError" class="form-group<?php echo($config['business']==''?' has-error':'');?>">
          <label for="business" class="control-label col-xs-5 col-sm-3 col-lg-2">Business</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="business">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="business" class="form-control textinput" value="<?php echo$config['business'];?>" data-dbid="1" data-dbt="config" data-dbc="business" placeholder="Enter a Business...">
          </div>
          <div id="businessErrorBlock" class="help-block text-right<?php echo($config['business']!=''?' hidden':'');?>">Enter a Business Name, otherwise some functions such as Messages, and Bookings will NOT function correctly.</div>
        </div>
        <div class="form-group">
          <label for="abn" class="control-label col-xs-5 col-sm-3 col-lg-2">ABN</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="abn">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="abn" class="form-control textinput" value="<?php echo$config['abn'];?>" data-dbid="1" data-dbt="config" data-dbc="abn" placeholder="Enter an ABN...">
          </div>
        </div>
        <div id="emailHasError" class="form-group<?php echo($config['email']==''?' has-error':'');?>">
          <label for="email" class="control-label col-xs-5 col-sm-3 col-lg-2">Email</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="email">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="Enter an Email...">
          </div>
          <div id="emailErrorBlock" class="help-block text-right<?php echo($config['email']!=''?' hidden':'');?>">Enter an Email, otherwise some functions such as Messages, and Bookings will NOT function correctly.</div>
        </div>
        <div class="form-group">
          <label for="phone" class="control-label col-xs-5 col-sm-3 col-lg-2">Phone</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="phone">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="phone" class="form-control textinput" value="<?php echo$config['phone'];?>" data-dbid="1" data-dbt="config" data-dbc="phone" placeholder="Enter a Phone Number...">
          </div>
        </div>
        <div class="form-group">
          <label for="mobile" class="control-label col-xs-5 col-sm-3 col-lg-2">Mobile</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="mobile">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="mobile" class="form-control textinput" value="<?php echo$config['mobile'];?>" data-dbid="1" data-dbt="config" data-dbc="mobile" placeholder="Enter a Mobile Number...">
          </div>
        </div>
        <div class="form-group">
          <label for="address" class="control-label col-xs-5 col-sm-3 col-lg-2">Address</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="address">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="address" class="form-control textinput" value="<?php echo$config['address'];?>" data-dbid="1" data-dbt="config" data-dbc="address" placeholder="Enter an Address...">
          </div>
        </div>
        <div class="form-group">
          <label for="suburb" class="control-label col-xs-5 col-sm-3 col-lg-2">Suburb</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="suburb">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="suburb" class="form-control textinput" value="<?php echo$config['suburb'];?>" data-dbid="1" data-dbt="config" data-dbc="suburb" placeholder="Enter a Suburb...">
          </div>
        </div>
        <div class="form-group">
          <label for="city" class="control-label col-xs-5 col-sm-3 col-lg-2">City</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="city">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="city" class="form-control textinput" value="<?php echo$config['city'];?>" data-dbid="1" data-dbt="config" data-dbc="city" placeholder="Enter a City...">
          </div>
        </div>
        <div class="form-group">
          <label for="state" class="control-label col-xs-5 col-sm-3 col-lg-2">State</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="state">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="state" class="form-control textinput" value="<?php echo$config['state'];?>" data-dbid="1" data-dbt="config" data-dbc="state" placeholder="Enter a State...">
          </div>
        </div>
        <div class="form-group">
          <label for="postcode" class="control-label col-xs-5 col-sm-3 col-lg-2">Postcode</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="postcode">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="postcode" class="form-control textinput" value="<?php echo($config['postcode']!=0?$config['postcode']:'');?>" data-dbid="1" data-dbt="config" data-dbc="postcode" placeholder="Enter a Postcode...">
          </div>
        </div>
        <div class="form-group">
          <label for="country" class="control-label col-xs-5 col-sm-3 col-lg-2">Country</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="country">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="country" class="form-control textinput" value="<?php echo$config['country'];?>" data-dbid="1" data-dbt="config" data-dbc="country" placeholder="Enter a Country...">
          </div>
        </div>
      </div>
      <div id="preference-social" name="preference-social" class="tab-pane">
        <legend class="control-legend">Social Networking</legend>
        <div class="form-group">
          <label for="options9" class="control-label check col-xs-5 col-sm-3 col-lg-2" data-toggle="tooltip" title="Toggle RSS Feed Icon.">Show RSS Feed Icon</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="options9" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="9"<?php echo($config['options']{9}==1?' checked':'');?>>
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
                <button class="btn btn-default add"><?php svg('libre-gui-plus',($config['iconsColor']==1?true:null));?></button>
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
                <span class="libre-social"><?php svg('libre-social-'.$rs['icon'],($config['iconsColor']==1?true:null));?></span>
              </div>
              <input type="text" class="form-control" value="<?php echo$rs['url'];?>" onchange="update('<?php echo$rs['id'];?>','social','url',$(this).val());" placeholder="Enter a URL...">
              <div class="input-group-btn">
                <form target="sp" action="core/purge.php">
                  <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                  <input type="hidden" name="t" value="choices">
                  <button class="btn btn-default trash"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
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
          <label for="development0" class="control-label check col-xs-5 col-sm-3 col-lg-2" data-toggle="tooltip" title="Toggle Development Mode Showing Errors.">Development Mode</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="development0" data-dbid="1" data-dbt="config" data-dbc="development" data-dbb="0"<?php echo($config['development']{0}==1?' checked':'');?>>
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
                    <button class="btn btn-default trash" onclick="purge('0','errorlog')" data-toggle="tooltip" title="This will Remove the Error Logs, there is no getting it back.">><?php svg('libre-gui-purge',($config['iconsColor']==1?true:null));?></button>
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
          <label for="maintenance0" class="control-label check col-xs-5 col-sm-3 col-lg-2" data-toggle="tooltip" title="Toggle Site Maintenance Mode.">Maintenance Mode</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="maintenance0" data-dbid="1" data-dbt="config" data-dbc="maintenance" data-dbb="0"<?php echo($config['maintenance']{0}==1?' checked':'');?>>
              <label for="maintenance0"/>
            </div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="options4" class="control-label check col-xs-5 col-sm-3 col-lg-2" data-toggle="tooltip" title="Display Administration Tooltips, like this one.">Enable Tooltips</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="options4" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4"<?php echo($config['options']{4}==1?' checked':'');?>>
              <label for="options4"/>
            </div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="iconsColor0" class="control-label check col-xs-5 col-sm-3 col-lg-2" data-toggle="tooltip" title="Display Colour Icons.">Use Colour Icons</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="iconsColor0" data-dbid="1" data-dbt="config" data-dbc="iconsColor" data-dbb="0"<?php echo($config['iconsColor']{0}==1?' checked':'');?>>
              <label for="iconsColor0"/>
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
            <select id="uti_freq" class="form-control" onchange="update('1','config','uti_freq',$(this).val());"<?php echo($user['options']{1}==0?' readonly':'');?> data-toggle="tooltip" title="">
              <option value="0"<?php echo($config['uti_freq']==0?' selected':'');?>>Never</option>
              <option value="3600"<?php echo($config['uti_freq']==3600?' selected':'');?>>Hourly</option>
              <option value="84600"<?php echo($config['uti_freq']==84600?' selected':'');?>>Daily</option>
              <option value="604800"<?php echo($config['uti_freq']==604800?' selected':'');?>>Weekly</option>
              <option value="2629743"<?php echo($config['uti_freq']==2629743?' selected':'');?>>Monthly</option>
            </select>
            <div class="input-group-btn">
              <button class="btn btn-default" onclick="$('#updatecheck').removeClass('hidden').load('core/layout/updatecheck.php');">Check Now</button>
            </div>
          </div>
        </div>
        <div id="updatecheck" class="col-xs-7 col-sm-9 col-lg-10 pull-right hidden">
          <div class="alert alert-warning"><?php svg('libre-gui-spinner-13',($config['iconsColor']==1?true:null),'animated spin');?> Checking for new updates!</div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
          <label for="update_url" class="control-label col-xs-5 col-sm-3 col-lg-2">Update URL</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="update_url">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="update_url" class="form-control textinput" value="<?php echo$config['update_url'];?>" data-dbid="1" data-dbt="config" data-dbc="update_url" placeholder="Enter an Update URL..." data-toggle="tooltip" title="URL to Fetch System Updates From...">
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="idleTime" class="control-label col-xs-5 col-sm-3 col-lg-2">Idle Timeout</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <input type="text" id="idleTime" class="form-control textinput" value="<?php echo$config['idleTime'];?>" data-dbid="1" data-dbt="config" data-dbc="idleTime" placeholder="Enter a Time in Minutes..." data-toggle="tooltip" title="Time in Minutes for Idle Timeout for Auto Logout...">
            <div class="input-group-addon">Minutes</div>
          </div>
          <small class="help-block text-right">'0' Disables Idle Timeout.</small>
        </div>
        <div class="form-group">
          <label for="dateFormat" class="control-label col-xs-5 col-sm-3 col-lg-2">Date/Time Format</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="dateFormat">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="dateFormat" class="form-control textinput" value="<?php echo$config['dateFormat'];?>" data-dbid="1" data-dbt="config" data-dbc="dateFormat" placeholder="Enter a Date/Time Format..." data-toggle="tooltip" title="Format Layout of all Dates/Times displayed.">
          </div>
          <small class="help-block text-right">For information on Date Format Characters click <a target="_blank" href="http://php.net/manual/en/function.date.php#refsect1-function.date-parameters">here</a>.</small>
        </div>
        <div class="form-group">
          <small class="help-block text-right">Select a theme image to use. We'll add more from time to time. Photo's are from <a target="_blank" href="https://unsplash.com/">UnSplash</a></small>
          <div class="input-group col-xs-12">
            <div id="bg0" class="col-xs-3 col-sm-2 adminbg<?php echo(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']==''?' active':'');?>" onclick="changeBackground('bg0');">
              <img class="img-thumbnail" src="core/images/bg0-menu.png">
<?php // https://unsplash.com/@vingtcent ?>
            </div>
            <div id="bg1" class="col-xs-3 col-sm-2 adminbg<?php echo(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg1'?' active':'');?>" onclick="changeBackground('bg1');">
              <img class="img-thumbnail" src="core/images/bg1-menu.jpg">
<?php // https://unsplash.com/@vingtcent ?>
            </div>
            <div id="bg2" class="col-xs-3 col-sm-2 adminbg<?php echo(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg2'?' active':'');?>" onclick="changeBackground('bg2');">
              <img class="img-thumbnail" src="core/images/bg2-menu.jpg">
<?php // https://unsplash.com/@alanaut24 ?>
            </div>
            <div id="bg3" class="col-xs-3 col-sm-2 adminbg<?php echo(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg3'?' active':'');?>" onclick="changeBackground('bg3');">
              <img class="img-thumbnail" src="core/images/bg3-menu.jpg">
<?php // https://unsplash.com/@hilesy ?>
            </div>
            <div id="bg4" class="col-xs-3 col-sm-2 adminbg<?php echo(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg4'?' active':'');?>" onclick="changeBackground('bg4');">
              <img class="img-thumbnail" src="core/images/bg4-menu.jpg">
<?php // https://unsplash.com/@shontzphotography ?>
            </div>
            <div id="bg5" class="col-xs-3 col-sm-2 adminbg<?php echo(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg5'?' active':'');?>" onclick="changeBackground('bg5');">
              <img class="img-thumbnail" src="core/images/bg5-menu.jpg">
<?php // https://unsplash.com/@adriel ?>
            </div>
            <div id="bg6" class="col-xs-3 col-sm-2 adminbg<?php echo(isset($_COOKIE['adminbg'])&&$_COOKIE['adminbg']=='bg6'?' active':'');?>" onclick="changeBackground('bg6');">
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
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoTitle">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
$cntc=70-strlen($config['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div class="input-group-addon">
              <span id="seoTitlecnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></span>
            </div>
            <div class="input-group-btn">
              <button class="btn btn-default" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-toggle="tooltip" title="Remove Stop Words."><?php svg('libre-gui-magic',($config['iconsColor']==1?true:null));?></button>
            </div>
<?php if($config['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(array(':rid'=>1,':t'=>'config',':c'=>'seoTitle'));
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoTitle">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$config['seoTitle'];?>" data-dbid="1" data-dbt="config" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoTitle">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
          <small class="help-block text-right">The recommended character count for Title's is 70.</small>
        </div>
        <div class="form-group clearfix">
          <label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Caption</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
$cntc=160-strlen($config['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div class="input-group-addon">
              <span id="seoCaptioncnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo $cnt;?></span>
            </div>
<?php if($config['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(array(':rid'=>1,':t'=>'config',':c'=>'seoCaption'));
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$config['seoCaption'];?>" data-dbid="1" data-dbt="config" data-dbc="seoCaption" placeholder="Enter a Caption...">
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoCaption">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
          <small class="help-block text-right">The recommended character count for Captions is 160, as sometime Captions may be used in Descriptions.</small>
        </div>
        <div class="form-group clearfix">
          <label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Description</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
$cntc=160-strlen($config['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div class="input-group-addon">
              <span id="seoDescriptioncnt" class="text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></span>
            </div>
<?php if($config['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute(array(':rid'=>1,':t'=>'config',':c'=>'seoDescription'));
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$config['seoDescription'];?>" data-dbid="1" data-dbt="config" data-dbc="seoDescription" placeholder="Enter a Description...">
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoDescription">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
          <small class="help-block text-right">The recommended character count for Descriptions is 160.</small>
        </div>
        <div class="form-group">
          <label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-lg-2">SEO Keywords</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
if($config['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM suggestions WHERE rid=:rid AND t=:t AND c=:c");$ss -> execute(array(':rid'=>1,':t'=>'config',':c'=>'seoKeywords'));
  echo($ss->rowCount()>0?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Suggestions"><button class="btn btn-default suggestion hidden-xs" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-lightbulb',($config['iconsColor']==1?true:null),'','green').'</button></div>':'');
}?>
            <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$config['seoKeywords'];?>" data-dbid="1" data-dbt="config" data-dbc="seoKeywords" placeholder="Enter Keywords...">
<?php echo($user['rank']>899?'<div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Add Suggestion"><button class="btn btn-default addsuggestion hidden-xs" data-toggle="popover" data-dbgid="seoKeywords">'.svg2('libre-gui-idea',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
          </div>
        </div>
        <h4>SEO Analytics</h4>
        <div class="form-group">
          <label for="ga_verification" class="control-label col-xs-5 col-sm-3 col-lg-2">Google Verification</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="ga_verification">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="ga_verification" class="form-control textinput" value="<?php echo$config['ga_verification'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_verification" placeholder="Enter Google Site Verification Code...">
          </div>
        </div>
        <div class="form-group">
          <label for="ga_tracking" class="control-label col-xs-5 col-sm-3 col-lg-2">Tracking Code</label>
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs" style="background-color:#f5f5f5;border:1px solid #ccc;border-bottom:0;"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="ga_tracking">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div><div id="da" class="hidden-xs" data-dbid="1" data-dbt="config" data-dbc="ga_tracking"></div>':'');?>
          <form target="sp" method="post" action="core/update.php" onsubmit="Pace.restart();$('#ga_tracking_save').removeClass('btn-danger');">
            <input type="hidden" name="id" value="1">
            <input type="hidden" name="t" value="config">
            <input type="hidden" name="c" value="ga_tracking">
            <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right" style="background-color:#f5f5f5;padding:5px;border:1px solid #ccc;border-bottom:0;">
              <button type="submit" id="ga_tracking_save" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="bottom" title="Save"><?php svg('libre-gui-save',($config['iconsColor']==1?true:null));?></button>
            </div>
            <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
              <textarea id="ga_tracking" class="form-control" style="height:100px" name="da" onkeyup="$('#ga_tracking_save').addClass('btn-danger');"><?php echo $config['ga_tracking'];?></textarea>
              <small class="help-block clearfix text-right">Go to <a target="_blank" href="https://analytics.google.com">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>The <code>&lt;script&gt;&lt;/script&gt;</code> tags aren't necessary as they will be stripped from the text when saved.</small>
            </div>
          </form>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
          <label for="seo_msvalidate" class="control-label col-xs-5 col-sm-3 col-lg-2">Microsoft Validate</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seo_msvalidate">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="seo_msvalidate" class="form-control textinput" value="<?php echo$config['seo_msvalidate'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" placeholder="Enter Microsoft Site Validation Code...">
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
          <label for="seo_yandexverification" class="control-label col-xs-5 col-sm-3 col-lg-2">Yandex Verification</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seo_yandexverification">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="seo_yandexverification" class="form-control textinput" value="<?php echo$config['seo_yandexverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" placeholder="Enter Yandex Site Verification Code...">
          </div>
        </div>
        <div class="form-group">
          <label for="seo_alexaverification" class="control-label col-xs-5 col-sm-3 col-lg-2">Alexa Verification</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seo_alexaverification">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="seo_alexaverification" class="form-control textinput" value="<?php echo$config['seo_alexaverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_alexaverification" placeholder="Enter Alexa Site Verification Code...">
          </div>
        </div>
        <div class="form-group">
          <label for="seo_domainverify" class="control-label col-xs-5 col-sm-3 col-lg-2">Domain Verify</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="seo_domainverify">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="seo_domainverify" class="form-control textinput" value="<?php echo$config['seo_domainverify'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" placeholder="Enter Domain Verify Code...">
          </div>
        </div>
        <h4>GEO Location</h4>
        <div class="form-group">
          <label for="geo_region" class="control-label col-xs-5 col-sm-3 col-lg-2">Region</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="geo_region">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="geo_region" class="form-control textinput" value="<?php echo$config['geo_region'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_region" placeholder="Enter GEO Region...">
          </div>
        </div>
        <div class="form-group">
          <label for="geo_placename" class="control-label col-xs-5 col-sm-3 col-lg-2">Placename</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="geo_placename">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="geo_placename" class="form-control textinput" value="<?php echo$config['geo_placename'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_placename" placeholder="Enter GEO Placename...">
          </div>
        </div>
        <div class="form-group">
          <label for="geo_position" class="control-label col-xs-5 col-sm-3 col-lg-2">Position</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="geo_position">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
            <input type="text" id="geo_position" class="form-control textinput" value="<?php echo$config['geo_position'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_position" placeholder="Enter GEO Position...">
          </div>
        </div>
        
        
        
      </div>
      <div id="preference-backrestore" name="preference-backrestore" class="tab-pane fade in">
        <div id="backup" name="backup">
          <h4>Database Backup/Restore</h4>
          <div id="backup_info">
<?php $tid=$ti-2592000;
if($config['backup_ti']<$tid){
  if($config['backup_ti']==0){
    echo'<div class="alert alert-info">A Backup has yet to be performed.</div>';
  }else{
    echo'<div class="alert alert-danger">It has been more than 30 days since a Backup has been performed.</div>';
  }
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
<?php foreach(glob("media".DS."backup".DS."*") as$file){
  $filename=basename($file);
  $filename=rtrim($filename,'.sql.gz');?>
            <div id="l_<?php echo$filename;?>" class="form-group">
              <div class="control-label col-xs-5 col-sm-3 col-lg-2"></div>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
                <a class="btn btn-default btn-block" href="<?php echo$file;?>">Click to Download <?php echo ltrim($file,'media'.DS.'backup'.DS);?></a>
                <div class="input-group-btn">
                  <button class="btn btn-default trash" onclick="removeBackup('<?php echo$filename;?>')"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
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
echo"<div class='phpinfodisplay'><style type='text/css'>\n",join("\n",array_map(create_function('$i', 'return ".phpinfodisplay ".preg_replace("/,/",",.phpinfodisplay ",$i);'),preg_split('/\n/',$matches[1]))),"</style>\n",$matches[2],"\n</div>\n";?>
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
