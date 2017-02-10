<?php
if($args[0]=='add'){
  $type=filter_input(INPUT_GET,'type',FILTER_SANITIZE_STRING);
  $q=$db->prepare("INSERT INTO login (options,active,ti) VALUES ('00000000','1',:ti)");
  $q->execute(array(':ti'=>time()));
  $args[1]=$db->lastInsertId();
  $q=$db->prepare("UPDATE login SET username=:username WHERE id=:id");
  $q->execute(array(':username'=>'User '.$args[1],':id'=>$args[1]));
  $args[0]='edit';?>
<script>/*<![CDATA[*/
  history.replaceState('','','<?php echo URL.$settings['system']['admin'].'/accounts/edit/'.$args[1];?>');
/*]]>*/</script>
<?php }
if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_accounts.php';
elseif($args[0]=='edit'){
  $q=$db->prepare("SELECT * FROM login WHERE id=:id");
  $q->execute(array(':id'=>$args[1]));
  $r=$q->fetch(PDO::FETCH_ASSOC);?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Account: <?php echo$r['username'];if($r['name']!='')echo':'.$r['name'];?></h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><?php svg('back');?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#accounts-edit"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#account-general" aria-controls="account-general" role="tab" data-toggle="tab">General</a></li>
      <li role="presentation"><a href="#account-images" aria-controls="account-images" role="tab" data-toggle="tab">Images</a></li>
      <li role="presentation"><a href="#account-social" aria-controls="account-social" role="tab" data-toggle="tab">Social</a></li>
      <li role="presentation"><a href="#account-settings" aria-controls="account-settings" role="tab" data-toggle="tab">Settings</a></li>
    </ul>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="account-general">
        <div class="form-group">
          <label for="ti" class="control-label col-xs-4 col-sm-3 col-lg-2">Created</label>
          <div class="input-group col-xs-8 col-sm-9 col-lg-10">
            <input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
          </div>
        </div>
        <div class="form-group">
          <label for="lti" class="control-label col-xs-4 col-sm-3 col-lg-2">Last Login</label>
          <div class="input-group col-xs-8 col-sm-9 col-lg-10">
            <input type="text" id="lti" class="form-control" value="<?php echo _ago($r['lti']);?>" readonly>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="username" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Username</label>
          <div class="input-group col-xs-8 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="username"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="username" class="form-control textinput" value="<?php echo$r['username'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="username" placeholder="Enter a Username...">
          </div>
          <div id="uerror" class="alert alert-danger col-xs-8 col-sm-9 col-lg-10 pull-right hidden">Username already exists!</div>
        </div>
        <div class="form-group">
          <label for="email" class="control-label col-xs-5 col-sm-3 col-lg-2">Email</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="email"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="email" placeholder="Enter an Email...">
          </div>
        </div>
        <div class="form-group">
          <label for="newsletter" class="control-label check col-xs-5 col-sm-3 col-lg-2"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Toggle Newsletter Subscription."';?>>Subscriber</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="newsletter" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0"<?php if($r['newsletter']{0}==1)echo' checked';?>>
              <label for="newsletter"/>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="name" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="name"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="name" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="name" placeholder="Enter a Name...">
          </div>
        </div>
        <div class="form-group">
          <label for="url" class="control-label col-xs-5 col-sm-3 col-lg-2">URL</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="url"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="url" placeholder="Enter a URL...">
          </div>
        </div>
        <div class="form-group">
          <label for="business" class="control-label col-xs-5 col-sm-3 col-lg-2">Business</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="business"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="business" placeholder="Enter a Business...">
          </div>
        </div>
        <div class="form-group">
          <label for="phone" class="control-label col-xs-5 col-sm-3 col-lg-2">Phone</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="phone"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="phone" class="form-control textinput" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="phone" placeholder="Enter a Phone Number...">
          </div>
        </div>
        <div class="form-group">
          <label for="mobile" class="control-label col-xs-5 col-sm-3 col-lg-2">Mobile</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="mobile"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="mobile" class="form-control textinput" value="<?php echo$r['mobile'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="mobile" placeholder="Enter a Mobile Number...">
          </div>
        </div>
        <div class="form-group">
          <label for="address" class="control-label col-xs-5 col-sm-3 col-lg-2">Address</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="address"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="address" placeholder="Enter an Address...">
          </div>
        </div>
        <div class="form-group">
          <label for="suburb" class="control-label col-xs-5 col-sm-3 col-lg-2">Suburb</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="suburb"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="suburb" placeholder="Enter a Suburb...">
          </div>
        </div>
        <div class="form-group">
          <label for="city" class="control-label col-xs-5 col-sm-3 col-lg-2">City</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="city"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="city" placeholder="Enter a City...">
          </div>
        </div>
        <div class="form-group">
          <label for="state" class="control-label col-xs-5 col-sm-3 col-lg-2">State</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="state"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="state" placeholder="Enter a State...">
          </div>
        </div>
        <div class="form-group">
          <label for="postcode" class="control-label col-xs-5 col-sm-3 col-lg-2">Postcode</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="postcode"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php if($r['postcode']!=0)echo$r['postcode'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="postcode" placeholder="Enter a Postcode...">
          </div>
        </div>
        <div class="form-group">
          <label for="country" class="control-label col-xs-5 col-sm-3 col-lg-2">Country</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn">
              <button class="btn btn-default fingerprint hidden-xs" data-toggle="popover" data-dbgid="country"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="country" class="form-control textinput" name="country" value="<?php echo$r['country'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="country" placeholder="Enter a Country...">
          </div>
        </div>
        <div class="form-group">
          <label for="notes" class="control-label col-xs-5 col-sm-3 col-lg-2">About</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="da"><?php svg('fingerprint');?></button>
            </div>
            <div id="da" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="notes"></div>
<?php }?>
            <form method="post" target="sp" action="core/update.php">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="login">
              <input type="hidden" name="c" value="notes">
              <textarea id="notes" class="form-control summernote" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
            </form>
          </div>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="account-images">
        <div class="form-group">
          <label for="avatar" class="control-label col-xs-5 col-sm-3 col-lg-2">Avatar</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <input type="text" class="form-control" value="<?php echo$r['avatar'];?>" readonly>
            <div class="input-group-btn">
              <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php" onsubmit="Pace.restart();">
                <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                <input type="hidden" name="act" value="add_avatar">
                <div class="btn btn-default btn-file"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Browse Computer for Image."';?>>
                  <?php svg('browse-computer');?>
                  <input type="file" name="fu">
                </div>
                <button class="btn btn-default" type="submit"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Upload Selected Image."';?>><?php svg('upload');?></button>
              </form>
            </div>
            <div class="input-group-addon avatar">
              <img id="avatar" src="<?php if($r['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.$r['avatar']))echo'media/avatar/'.$r['avatar'];?>">
            </div>
            <div class="input-group-btn">
              <button class="btn btn-default trash" onclick="imageUpdate('<?php echo$r['id'];?>','login','avatar','');"><?php svg('trash');?></button>
            </div>
          </div>
        </div>
        <div class="form-group clearfix">
          <label for="gravatar" class="control-label col-xs-5 col-sm-3 col-lg-2">Gravatar</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="gravatar"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <input type="text" id="gravatar" class="form-control textinput" value="<?php echo$r['gravatar'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="gravatar" placeholder="Enter Gravatar Link...">
          </div>
          <small class="help-block text-right"><a target="_blank" href="http://www.gravatar.com/">Gravatar</a> Link will override any image uploaded as your Avatar.</small>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="account-social">
        <div class="form-group">
          <form target="sp" method="post" action="core/add_data.php">
            <input type="hidden" name="user" value="<?php echo$r['id'];?>">
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
<?php $ss=$db->prepare("SELECT * FROM choices WHERE contentType='social' AND uid=:uid ORDER BY icon ASC");
$ss->execute(array(':uid'=>$r['id']));
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
      <div role="tabpanel" class="tab-pane" id="account-settings">
        <div class="form-group">
          <label for="password" class="control-label col-xs-4 col-sm-3 col-lg-2">Password</label>
          <form target="sp" method="post" action="core/update.php" onsubmit="Pace.restart();">
            <div class="input-group col-xs-8 col-sm-9 col-lg-10">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="login">
              <input type="hidden" name="c" value="password">
              <input type="password" id="password" class="form-control" name="da" value="" placeholder="Enter a New Password...">
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default">Update Password</button>
              </div>
            </div>
          </form>
        </div>
        <div class="form-group">
          <label for="active" class="control-label check col-xs-5 col-sm-3 col-lg-2">Active</label>
          <div class="input-group col-xs-7 col-sm-9 col-lg-10">
            <div class="checkbox checkbox-success">
              <input type="checkbox" id="active" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="active" data-dbb="0"<?php if($r['active']{0}==1)echo' checked';?>>
              <label for="active"/>
            </div>
          </div>
        </div>
<?php if($user['rank']>899){?>
        <div class="form-group">
          <label for="rank" class="control-label col-xs-4 col-sm-3 col-lg-2">Rank</label>
          <div class="input-group col-xs-8 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
            <div class="input-group-btn hidden-xs">
              <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="rank"><?php svg('fingerprint');?></button>
            </div>
<?php }?>
            <select id="rank" class="form-control" onchange="update('<?php echo$r['id'];?>','login','rank',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="rank">
              <option value="0"<?php if($r['rank']==0)echo' selected';?>>Visitor</option>
              <option value="100"<?php if($r['rank']==100)echo' selected';?>>Subscriber</option>
              <option value="200"<?php if($r['rank']==200)echo' selected';?>>Member</option>
              <option value="300"<?php if($r['rank']==300)echo' selected';?>>Client</option>
              <option value="400"<?php if($r['rank']==400)echo' selected';?>>Contributor</option>
              <option value="500"<?php if($r['rank']==500)echo' selected';?>>Author</option>
              <option value="600"<?php if($r['rank']==600)echo' selected';?>>Editor</option>
              <option value="700"<?php if($r['rank']==700)echo' selected';?>>Moderator</option>
              <option value="800"<?php if($r['rank']==800)echo' selected';?>>Manager</option>
              <option value="900"<?php if($r['rank']==900)echo' selected';?>>Administrator</option>
<?php if($user['rank']==1000){?><option value="1000"<?php if($r['rank']==1000)echo' selected';?>>Developer</option><?php }?>
            </select>
          </div>
        </div>
<?php }
if($user['rank']>899){?>
        <div class="well">
          <h4>Account Permissions</h4>
          <div class="form-group clearfix">
            <label for="options0" class="control-label check col-xs-6 col-sm-4 col-lg-3">Add/Remove Content</label>
            <div class="input-group col-xs-6 col-sm-8 col-lg-9">
              <div class="checkbox checkbox-success">
                <input type="checkbox" id="options0" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="0"<?php if($r['options']{0}==1)echo' checked';?>>
                <label for="options0"/>
              </div>
            </div>
          </div>
          <div class="form-group clearfix">
            <label for="options1" class="control-label check col-xs-6 col-sm-4 col-lg-3">Edit Content</label>
            <div class="input-group col-xs-6 col-sm-8 col-lg-9">
              <div class="checkbox checkbox-success">
                <input type="checkbox" id="options1" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="1"<?php if($r['options']{1}==1)echo' checked';?>>
                <label for="options1"/>
              </div>
            </div>
          </div>
          <div class="form-group clearfix">
            <label for="options2" class="control-label check col-xs-6 col-sm-4 col-lg-3">Add/Edit Bookings</label>
            <div class="input-group col-xs-6 col-sm-8 col-lg-9">
              <div class="checkbox checkbox-success">
                <input type="checkbox" id="options2" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="2"<?php if($r['options']{2}==1)echo' checked';?>>
                <label for="options2"/>
              </div>
            </div>
          </div>
          <div class="form-group clearfix">
            <label for="options3" class="control-label check col-xs-6 col-sm-4 col-lg-3">Message Viewing/Editing</label>
            <div class="input-group col-xs-6 col-sm-8 col-lg-9">
              <div class="checkbox checkbox-success">
                <input type="checkbox" id="options3" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="3"<?php if($r['options']{3}==1)echo' checked';?>>
                <label for="options3"/>
              </div>
            </div>
          </div>
          <div class="form-group clearfix">
            <label for="options4" class="control-label check col-xs-6 col-sm-4 col-lg-3">Orders Viewing/Editing</label>
            <div class="input-group col-xs-6 col-sm-8 col-lg-9">
              <div class="checkbox checkbox-success">
                <input type="checkbox" id="options4" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="4"<?php if($r['options']{4}==1)echo' checked';?>>
                <label for="options4"/>
              </div>
            </div>
          </div>
          <div class="form-group clearfix">
            <label for="options5" class="control-label check col-xs-6 col-sm-4 col-lg-3">User Accounts Viewing/Editing</label>
            <div class="input-group col-xs-6 col-sm-8 col-lg-9">
              <div class="checkbox checkbox-success">
                <input type="checkbox" id="options5" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="5"<?php if($r['options']{5}==1)echo' checked';?>>
                <label for="options5"/>
              </div>
            </div>
          </div>
          <div class="form-group clearfix">
            <label for="options6" class="control-label check col-xs-6 col-sm-4 col-lg-3">SEO Viewing/Editing</label>
            <div class="input-group col-xs-6 col-sm-8 col-lg-9">
              <div class="checkbox checkbox-success">
                <input type="checkbox" id="options6" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="6"<?php if($r['options']{6}==1)echo' checked';?>>
                <label for="options6"/>
              </div>
            </div>
          </div>
          <div class="form-group clearfix">
            <label for="options7" class="control-label check col-xs-6 col-sm-4 col-lg-3">Preferences Viewing/Editing</label>
            <div class="input-group col-xs-6 col-sm-8 col-lg-9">
              <div class="checkbox checkbox-success">
                <input type="checkbox" id="options7" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="7"<?php if($r['options']{7}==1)echo' checked';?>>
                <label for="options7"/>
              </div>
            </div>
          </div>
        </div>
<?php }?>
<div class="form-group">
  <label for="adminTheme" class="control-label col-xs-4 col-sm-3 col-lg-2">Admin Theme</label>
  <div class="input-group col-xs-8 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
    <div class="input-group-btn hidden-xs">
      <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="adminTheme"><?php svg('fingerprint');?></button>
    </div>
<?php }?>
    <select id="adminTheme" class="form-control" onchange="update('<?php echo$r['id'];?>','login','adminTheme',$(this).val());adminTheme($(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="adminTheme">
<?php $folders=preg_grep('/^([^.])/',scandir("core/css/theme"));
foreach($folders as$folder){
echo'<option value="'.$folder.'"';if($folder==$r['adminTheme'])echo' selected';echo'>'.ucfirst($folder).'</option>';
}?>
    </select>
  </div>
  <script>
    function adminTheme(theme){
      var expires=new Date();
      expires.setTime(expires.getTime()+(30*24*60*60*1000));
      document.cookie='admintheme'+'='+theme+';expires='+expires.toUTCString();
    }
  </script>
</div>
      </div>

    </div>
  </div>
</div>
<?php }else{
  if($args[0]=='type'){
    if(isset($args[1])){
      $rank=0;
      if($args[1]=='subscriber')$rank=100;
      if($args[1]=='member')$rank=200;
      if($args[1]=='client')$rank==300;
      if($args[1]=='contributor')$rank=400;
      if($args[1]=='author')$rank=500;
      if($args[1]=='editor')$rank=600;
      if($args[1]=='moderator')$rank=700;
      if($args[1]=='manager')$rank=800;
      if($args[1]=='administrator')$rank=900;
      if($args[1]=='developer')$rank=1000;
    }
    $s=$db->prepare("SELECT * FROM login WHERE rank=:rank ORDER BY ti DESC");
    $s->execute(array(':rank'=>$rank));
  }else{
    $s=$db->prepare("SELECT * FROM login WHERE rank<:rank ORDER BY ti DESC");
    $s->execute(array(':rank'=>$_SESSION['rank']+1));
  }?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">
      <ol class="breadcrumb">
        <li><a href="<?php echo URL.$settings['system']['admin'];?>/accounts">Accounts</a></li>
        <li>
          <a class="dropdown-toggle" data-toggle="dropdown"><?php if(isset($args[1])&&$args[1]!='')echo ucfirst($args[1]);else echo'All';?> <i class="caret"></i></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts';?>">All</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/visitor';?>">Visitor</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/subscriber';?>">Subscriber</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/member';?>">Member</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/client';?>">Client</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/contributor';?>">Contributor</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/author';?>">Author</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/editor';?>">Editor</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/moderator';?>">Moderator</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/manager';?>">Manager</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/administrator';?>">Administrator</a></li>
            <li><a href="<?php echo URL.$settings['system']['admin'].'/accounts/type/developer';?>">Developer</a></li>
          </ul>
        </li>
      </ol>
    </h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default add" href="<?php echo URL.$settings['system']['admin'].'/accounts/add';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Add"';?>><?php svg('add');?></a>
      </div>
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/accounts/settings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Settings"';?>><?php svg('cogs');?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#accounts"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-condensed table-striped table-hover">
        <thead>
          <tr>
            <th class="col-xs-5">Username/Name</th>
            <th class="col-xs-2 text-center">Last Login</th>
            <th class="col-xs-1 text-center">Rank</th>
            <th class="col-xs-1 text-center">Status</th>
            <th class="col-xs-3"></th>
          </tr>
        </thead>
        <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
          <tr id="l_<?php echo$r['id'];?>" class="item">
            <td>
              <a href="<?php echo$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><?php echo$r['username'].':'.$r['name'];?></a>
<?php if($user['rank']==1000)echo'<br><small class="text-muted">IP: '.$r['userIP'].'<br>'.$r['userAgent'].'</small';?>
            </td>
            <td class="text-center"><?php echo _ago($r['lti']);if($r['lti']!=0&&$user['rank']==1000)echo'<br><small class="text-muted">'.date($config['dateFormat'],$r['lti']).'</small>';?></td>
            <td class="text-center"><?php echo rank($r['rank']);?></td>
            <td class="text-center"><?php echo$r['status'];?></td>
            <td id="controls_<?php echo$r['id'];?>" class="text-right">
              <a class="btn btn-default" href="<?php echo$settings['system']['admin'].'/accounts/edit/'.$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><?php svg('edit');?></a>
<?php if($r['rank']!=1000){?>
              <button class="btn btn-default<?php if($r['status']!='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','login','status','unpublished')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><?php svg('restore');?></button>
              <button class="btn btn-default trash<?php if($r['status']=='delete')echo' hidden';?>" onclick="updateButtons('<?php echo$r['id'];?>','login','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><?php svg('trash');?></button>
              <button class="btn btn-default trash<?php if($r['status']!='delete')echo' hidden';?>" onclick="purge('<?php echo$r['id'];?>','login')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><?php svg('purge');?></button>
<?php }?>
            </td>
          </tr>
<?php }?>
        </tbody>
      </table>
    </div>
  </div>
<?php }?>
</div>
