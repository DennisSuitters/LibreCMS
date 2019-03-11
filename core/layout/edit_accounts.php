<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Edit User Account
 *
 * edit_accounts.php version 2.0.1
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Accounts - Edit
 * @package    core/layout/edit_accounts.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.1
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 */
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$q->execute([':id'=>$args[1]]);
$r=$q->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/accounts';?>">Accounts</a></li>
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item active" aria-current="page"><span id="usersusername"><?php echo$r['username'];?></span>:<span id="usersname"><?php echo$r['name'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back');?></a>
<?php if($help['accounts_edit_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['accounts_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['accounts_edit_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['accounts_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li id="nav-account-general" class="nav-item" role="presentation"><a class="nav-link active" href="#account-general" aria-controls="account-general" role="tab" data-toggle="tab">General</a></li>
          <li id="nav-account-images" class="nav-item" role="presentation"><a class="nav-link" href="#account-images" aria-controls="account-images" role="tab" data-toggle="tab">Images</a></li>
          <li id="nav-account-proofs" class="nav-item" role="presentation"><a class="nav-link" href="#account-proofs" aria-controls="account-proofs" role="tab" data-toggle="tab">Proofs</a></li>
          <li id="nav-account-social" class="nav-item" role="presentation"><a class="nav-link" href="#account-social" aria-controls="account-social" role="tab" data-toggle="tab">Social</a></li>
          <li id="nav-account-profile" class="nav-item" role="presentation"><a class="nav-link" href="#account-profile" aria-controls="account-social" role="tab" data-toggle="tab">Profile</a></li>
          <li id="nav-account-settings" class="nav-item" role="presentation"><a class="nav-link" href="#account-settings" aria-controls="account-settings" role="tab" data-toggle="tab">Settings</a></li>
        </ul>
        <div class="tab-content">
          <div id="account-general" class="tab-pane active" role="tabpanel">
            <div class="form-group row">
              <label for="ti" class="col-form-label col-sm-2">Created</label>
              <div class="input-group col-sm-10">
                <input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="lti" class="col-form-label col-sm-2">Last Login</label>
              <div class="input-group col-sm-10">
                <input type="text" id="lti" class="form-control" value="<?php echo _ago($r['lti']);?>" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="username" class="col-form-label col-sm-2">Username</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="username" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="username" class="form-control textinput" value="<?php echo$r['username'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="username" placeholder="Enter a Username...">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveusername" class="btn btn-secondary save" data-dbid="username" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
              <div id="uerror" class="alert alert-danger col-sm-10 float-right hidden">Username already exists!</div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-form-label col-sm-2">Email</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="email" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="email" class="form-control textinput" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="email" placeholder="Enter an Email...">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="newsletter" class="col-form-label col-8 col-sm-2" data-tooltip="tooltip" title="Toggle Newsletter Subscription.">Subscriber</label>
              <div class="input-group col-4 col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="newsletter" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="newsletter" data-dbb="0"<?php echo$r['newsletter']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="account-images">
            <form target="sp" method="post" enctype="multipart/form-data" action="core/add_data.php" onsubmit="Pace.restart();">
              <div class="form-group row">
                <label for="avatar" class="col-form-label col-sm-2">Avatar</label>
                <div class="input-group col-sm-10">
                  <input type="text" class="form-control" value="<?php echo$r['avatar'];?>" readonly>
                  <div class="input-group-append">
                    <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                    <input type="hidden" name="act" value="add_avatar">
                    <div class="btn btn-secondary custom-file" data-tooltip="tooltip" title="Browse Computer for Image.">
                      <input id="avatarfu" type="file" class="custom-file-input hidden" name="fu" onchange="form.submit()">
                      <label for="avatarfu"><?php svg('libre-gui-browse-computer');?></label>
                    </div>
                  </div>
                  <div class="input-group-text p-0">
                    <img class="img-avatar img-fluid bg-white" style="width:32px;max-height:32px;border-radius:0" src="<?php if($r['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['avatar'])))echo'media'.DS.'avatar'.DS.basename($r['avatar']);elseif($r['avatar']!='')echo$r['avatar'];elseif($r['gravatar']!='')echo$r['gravatar'];else echo ADMINNOAVATAR;?>">
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-secondary trash" onclick="imageUpdate('<?php echo$r['id'];?>','login','avatar','');" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                  </div>
                </div>
              </div>
            </form>
            <div class="help-block small text-muted text-right"><a target="_blank" href="http://www.gravatar.com/">Gravatar</a> Link will override any image uploaded as your Avatar.</div>
            <div class="form-group row">
              <label for="gravatar" class="col-form-label col-sm-2">Gravatar</label>
              <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="gravatar" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <input type="text" id="gravatar" class="form-control textinput" value="<?php echo$r['gravatar'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="gravatar" placeholder="Enter Gravatar Link...">
                <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savegravatar" class="btn btn-secondary save" data-dbid="gravatar" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
          </div>
          <div id="account-proofs" class="tab-pane" role="tabpanel">
            <ul id="proof_items">
<?php $sm=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType='proofs' AND uid=:id ORDER BY ord ASC");
$sm->execute([':id'=>$r['id']]);
while($rm=$sm->fetch(PDO::FETCH_ASSOC)){
  if(!file_exists($rm['file']))$rm['file']=ADMINNOIMAGE;
  list($width,$height)=getimagesize($rm['file']);?>
              <li id="proof_items_<?php echo$rm['id'];?>" class="col-xs-6 col-sm-3">
                <div class="panel panel-default media">
                  <div class="controls btn-group">
                    <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$rm['id'];?>"><?php svg('libre-gui-edit');?></a>
<?php $scn=$sccn=0;
  $sc=$db->prepare("SELECT COUNT(rid) as cnt FROM `".$prefix."comments` WHERE rid=:rid AND contentType='proofs'");
  $sc->execute([':rid'=>$rm['id']]);
  $scn=$sc->fetch(PDO::FETCH_ASSOC);
  $scc=$db->prepare("SELECT COUNT(rid) as cnt FROM `".$prefix."comments` WHERE rid=:rid AND status!='approved'");
  $scc->execute([':rid'=>$rm['id']]);
  $sccn=$scc->fetch(PDO::FETCH_ASSOC);?>
                    <a class="btn btn-default btn-xs<?php echo$sccn['cnt']>0?' btn-success':'';?>" href="<?php echo URL.$settings['system']['admin'].'/content/edit/'.$rm['id'].'#d43';?>"<?php echo$sccn['cnt']>0?' data-tooltip="tooltip" title="'.$sccn['cnt'].' New Comments"':'';?>><?php svg('libre-gui-comments');?>&nbsp;<?php echo$scn['cnt'];?></a>
                    <span class="handle btn btn-default btn-xs"><?php svg('libre-gui-drag');?></span>
                  </div>
                  <div class="panel-body">
                    <a href="<?php echo$rm['file'];?>" data-srcset="<?php echo$rm['file'];?> <?php echo$width;?>w" data-fancybox="gallery" data-width="<?php echo$width;?>" data-height="<?php echo$height;?>" data-caption="<?php echo$rm['title'].$rm['seoCaption']!=''?' - '.$rm['seoCaption']:'';?>"><img src="<?php echo$rm['file'];?>" alt=""></a>
                  </div>
                  <div id="media-title<?php echo$rm['id'];?>" class="panel-footer"><?php echo$rm['title'];?></div>
                </div>
              </li>
<?php }?>
            </ul>
          </div>
          <div role="tabpanel" class="tab-pane" id="account-social">
            <form target="sp" method="post" action="core/add_data.php">
              <div class="form-group row">
                <input type="hidden" name="user" value="<?php echo$r['id'];?>">
                <input type="hidden" name="act" value="add_social">
                <div class="input-group col-sm-12">
                  <span class="input-group-text">Network</span>
                  <select class="form-control" name="icon">
                    <option value="">Select a Social Network</option>
                    <option value="500px">500px</option>
                    <option value="aboutme">About Me</option>
                    <option value="airbnb">AirBNB</option>
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
                    <option value="discord">Discord</option>
                    <option value="discourse">Discourse</option>
                    <option value="disqus">Disqus</option>
                    <option value="dribbble">Dribbble</option>
                    <option value="dropbox">Dropbox</option>
                    <option value="envato">Envato</option>
                    <option value="etsy">Etsy</option>
                    <option value="facebook">Facebook</option>
                    <option value="feedburner">Feedburner</option>
                    <option value="flickr">Flickr</option>
                    <option value="forrst">Forrst</option>
                    <option value="github">GitHub</option>
                    <option value="gitlab">GitLab</option>
                    <option value="google-plus">Google+</option>
                    <option value="gravatar">Gravatar</option>
                    <option value="hackernews">Hackernews</option>
                    <option value="icq">ICQ</option>
                    <option value="instagram">Instagram</option>
                    <option value="kickstarter">Kickstarter</option>
                    <option value="last-fm">Last FM</option>
                    <option value="lego">Lego</option>
                    <option value="linkedin">Linkedin</option>
                    <option value="lynda">Lynda</option>
                    <option value="massroots">Massroots</option>
                    <option value="medium">Medium</option>
                    <option value="myspace">MySpace</option>
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
                  <div class="input-group-text">URL</div>
                  <input type="text" class="form-control" name="url" value="" placeholder="Enter a URL...">
                  <div class="input-group-append"><button class="btn btn-secondary add" data-tooltip="tooltip" title="Add"><?php svg('libre-gui-plus');?></button></div>
                </div>
              </div>
            </form>
            <div id="social">
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='social' AND uid=:uid ORDER BY icon ASC");
$ss->execute([':uid'=>$r['id']]);
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
              <div id="l_<?php echo$rs['id'];?>" class="form-group row">
                <div class="input-group col-sm-12">
                  <div class="input-group-text"><span class="libre-social" data-tooltip="tooltip" title="<?php echo ucfirst($rs['icon']);?>"><?php svg('libre-social-'.$rs['icon']);?></span></div>
                  <input type="text" class="form-control" value="<?php echo$rs['url'];?>" readonly>
                  <div class="input-group-append">
                    <form target="sp" action="core/purge.php">
                      <input type="hidden" name="id" value="<?php echo$rs['id'];?>">
                      <input type="hidden" name="t" value="choices">
                      <button class="btn btn-secondary trash" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                    </form>
                  </div>
                </div>
              </div>
<?php }?>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="account-profile">
            <ul class="nav nav-tabs" role="tablist">
              <li id="nav-profile-bio" class="nav-item" role="presentation">
                <a class="nav-link active" href="#profile-bio" aria-controls="profile-bio" role="tab" data-toggle="tab">BIO</a>
              </li>
              <li id="nav-profile-career" class="nav-item" role="presentation">
                <a class="nav-link" href="#profile-career" aria-controls="profile-career" role="tab" data-toggle="tab">Career</a>
              </li>
              <li id="nav-profile-edu" class="nav-item" role="presentation">
                <a class="nav-link" href="#profile-edu" aria-controls="profile-edu" role="tab" data-toggle="tab">Education</a>
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="profile-bio" aria-labelledby="profile-bio">
                <h4>BIO</h4>
                <div class="form-group row">
                  <label class="col-form-label col-sm-2">Profile Link</label>
                  <div class="input-group col-sm-10">
                    <a class="form-control" target="_blank" href="<?php echo URL.'/profile/'.str_replace(' ','-',$r['name']);?>"><?php echo URL.'/profile/'.str_replace(' ','-',$r['name']);?></a>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="bio_options0" class="col-form-label col-sm-2">Enable</label>
                  <div class="input-group col-sm-10">
                    <label class="switch switch-label switch-success"><input type="checkbox" id="bio_options0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="0"<?php echo$r['bio_options']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="bio_options1" class="col-form-label col-sm-2">Show Address</label>
                  <div class="input-group col-sm-10">
                    <label class="switch switch-label switch-success"><input type="checkbox" id="bio_options1" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="1"<?php echo$r['bio_options']{1}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="name" class="col-form-label col-sm-2">Name</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="name" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="name" class="form-control textinput" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="name" placeholder="Enter a Name...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savename" class="btn btn-secondary save" data-dbid="name" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="url" class="col-form-label col-sm-2">URL</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="url" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="url" class="form-control textinput" value="<?php echo$r['url'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="url" placeholder="Enter a URL...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveurl" class="btn btn-secondary save" data-dbid="url" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="business" class="col-form-label col-sm-2">Business</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="business" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="business" class="form-control textinput" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="business" placeholder="Enter a Business...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="phone" class="col-form-label col-sm-2">Phone</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="phone" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="phone" class="form-control textinput" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="phone" placeholder="Enter a Phone Number...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savephone" class="btn btn-secondary save" data-dbid="phone" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="mobile" class="col-form-label col-sm-2">Mobile</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="mobile" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="mobile" class="form-control textinput" value="<?php echo$r['mobile'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="mobile" placeholder="Enter a Mobile Number...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savemobile" class="btn btn-secondary save" data-dbid="mobile" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="address" class="col-form-label col-sm-2">Address</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="address" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="address" placeholder="Enter an Address...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveaddress" class="btn btn-secondary save" data-dbid="address" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="suburb" class="col-form-label col-sm-2">Suburb</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="suburb" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="suburb" placeholder="Enter a Suburb...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savesuburb" class="btn btn-secondary save" data-dbid="suburb" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="city" class="col-form-label col-sm-2">City</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="city" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="city" placeholder="Enter a City...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savecity" class="btn btn-secondary save" data-dbid="city" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="state" class="control-label col-sm-2">State</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="state" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="state" placeholder="Enter a State...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savestate" class="btn btn-secondary save" data-dbid="state" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="postcode" class="control-label col-sm-2">Postcode</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="postcode" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php echo$r['postcode']!=0?$r['postcode']:'';?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="postcode" placeholder="Enter a Postcode...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savepostcode" class="btn btn-secondary save" data-dbid="postcode" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="country" class="control-label col-sm-2">Country</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="country" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="country" class="form-control textinput" name="country" value="<?php echo$r['country'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="country" placeholder="Enter a Country...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savecountry" class="btn btn-secondary save" data-dbid="country" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="caption" class="control-label col-sm-2">Caption</label>
                  <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="caption" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                    <input type="text" id="caption" class="form-control textinput" name="caption" value="<?php echo$r['caption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="caption" placeholder="Enter a Caption...">
                    <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savecaption" class="btn btn-secondary save" data-dbid="caption" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="notes" class="col-form-label col-sm-2">About</label>
                  <div class="col-sm-10">
                    <div class="card-header p-0">
<?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="da" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button><div id="da" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="notes"></div>':'';?>
                      <form method="post" target="sp" action="core/update.php">
                        <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                        <input type="hidden" name="t" value="login">
                        <input type="hidden" name="c" value="notes">
                        <textarea id="notes" class="form-control summernote" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="profile-career" aria-labelledby="profile-career">
                <h4>Career</h4>
                <div class="form-group row">
                  <label for="bio_options2" class="col-form-label col-8 col-sm-2">Enable</label>
                  <div class="input-group col-4 col-sm-10">
                    <label class="switch switch-label switch-success"><input type="checkbox" id="bio_options2" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="2"<?php echo$r['bio_options']{2}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="resume_notes" class="col-form-label col-sm-2">Resume Notes</label>
                  <div class="col-sm-10">
                    <div class="card-header p-0">
<?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="da2" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button><div id="da2" data-dbid="'.$r['id'].'" data-dbt="login" data-dbc="resume_notes"></div>':'';?>
                      <form method="post" target="sp" action="core/update.php">
                        <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                        <input type="hidden" name="t" value="login">
                        <input type="hidden" name="c" value="resume_notes">
                        <textarea id="resume_notes" class="form-control summernote" name="da"><?php echo rawurldecode($r['resume_notes']);?></textarea>
                      </form>
                    </div>
                  </div>
                </div>
                <h4>Add a Career</h4>
                <form target="sp" method="post" action="core/add_career.php">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <div class="form-group row">
                    <div class="col-4">
                      <input type="text" class="form-control" value="" name="title" placeholder="Title..." required aria-required="true" aria-label="Career Title" role="textbox">
                    </div>
                    <div class="col-4">
                      <input type="text" class="form-control" value="" name="business" placeholder="Business..." required aria-required="true" aria-label="Career Business" role="textbox">
                    </div>
                    <div class="col-2">
                      <input type="text" id="ctis" class="form-control" value="" name="tis" placeholder="Date Start..." autocomplete="off">
                      <input type="hidden" id="ctisx" name="tisx" value="0">
                    </div>
                    <div class="col-2">
                      <input type="text" id="ctie" class="form-control" value="" name="tie" placeholder="Date End..." autocomplete="off">
                      <input type="hidden" id="ctiex" name="tiex" value="0">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col">
                      <textarea name="da" class="cnote" required aria-required="true" aria-label="Career Notes" role="textbox"></textarea>
                    </div>
                    <div class="col-1">
                      <button type="submit" class="btn btn-secondary add" aria-label="Add Career" role="button" data-tooltip="tooltip" title="Add"><?php svg('libre-gui-add');?></button>
                    </div>
                  </div>
                </form>
                <script>
                  $('#ctis').daterangepicker({
                    singleDatePicker:true,
                    linkedCalendars:false,
                    autoUpdateInput:false,
                    showDropdowns:true,
                    showCustomRangeLabel:false,
                    timePicker:false,
                    startDate:"<?php echo date($config['dateFormat'],time());?>",
                    locale:{
                      format:'MMM Do,YYYY h:mm A'
                    }
                  },function(start){
                    $('#ctisx').val(start.unix());
                  });
                  $('#ctis').on('apply.daterangepicker',function(start,picker){
                    $('#ctis').val(picker.startDate.format('YYYY-MMM'));
                  });
                  $('#ctie').daterangepicker({
                    singleDatePicker:true,
                    linkedCalendars:false,
                    autoUpdateInput:false,
                    showDropdowns:true,
                    showCustomRangeLabel:false,
                    timePicker:false,
                    startDate:"<?php echo date($config['dateFormat'],time());?>",
                    locale:{
                      format:'MMM Do,YYYY h:mm A'
                    }
                  },function(start){
                    $('#ctiex').val(start.unix());
                  });
                  $('#ctie').on('apply.daterangepicker',function(start,picker){
                    $('#ctie').val(picker.startDate.format('YYYY-MMM'));
                  });
                  $('.cnote').summernote({
                    toolbar:[],
                    placeholder:'Enter Career Notes...'
                  });
                </script>
                <hr>
                <div id="careers">
<?php $sc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType='career' AND cid=:cid ORDER BY tis ASC");
$sc->execute([':cid'=>$user['id']]);
while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
                  <div id="l_<?php echo$rc['id'];?>">
                    <div class="form-group row">
                      <div class="col-4">
                        <input type="text" class="form-control" value="<?php echo$rc['title'];?>" readonly>
                      </div>
                      <div class="col-4">
                        <input type="text" class="form-control" value="<?php echo$rc['business'];?>" readonly>
                      </div>
                      <div class="col-2">
                        <input type="text" class="form-control" value="<?php echo $rc['tis']==0?'Current':date('Y-M',$rc['tis']);?>" readonly>
                      </div>
                      <div class="col-2">
                        <input type="text" class="form-control" value="<?php echo $rc['tie']==0?'Current':date('Y-M',$rc['tie']);?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col">
                        <div class="form-control"><?php echo$rc['notes'];?></div>
                      </div>
                      <div class="col-1">
                        <button class="btn btn-secondary trash" onclick="purge('<?php echo$rc['id'];?>','content')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                      </div>
                    </div>
                    <hr>
                  </div>
<?php }?>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="profile-edu" aria-labelledby="profile-edu">
                <h4>Education</h4>
                <div class="form-group row">
                  <label for="bio_options3" class="col-form-label col-8 col-sm-2">Enable</label>
                  <div class="input-group col-4 col-sm-10">
                    <label class="switch switch-label switch-success"><input type="checkbox" id="bio_options3" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="bio_options" data-dbb="3"<?php echo$r['bio_options']{3}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                  </div>
                </div>
                <h4>Add a Career</h4>
                <form target="sp" method="post" action="core/add_education.php">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <div class="form-group row">
                    <div class="col-4">
                      <input type="text" class="form-control" value="" name="title" placeholder="Title..." required aria-required="true" aria-label="Education Title" role="textbox">
                    </div>
                    <div class="col-4">
                      <input type="text" class="form-control" value="" name="business" placeholder="Institute..." required aria-required="true" aria-label="Education Institute" role="textbox">
                    </div>
                    <div class="col-2">
                      <input type="text" id="etis" class="form-control" value="" name="tis" placeholder="Date Start..." autocomplete="off">
                      <input type="hidden" id="etisx" name="tisx" value="0">
                    </div>
                    <div class="col-2">
                      <input type="text" id="etie" class="form-control" value="" name="tie" placeholder="Date End..." autocomplete="off">
                      <input type="hidden" id="etiex" name="tiex" value="0">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col">
                      <textarea name="da" class="enote" required aria-required="true" role="textbox"></textarea>
                    </div>
                    <div class="col-1">
                      <button type="submit" class="btn btn-secondary add" data-tooltip="tooltip" title="Add"><?php svg('libre-gui-add');?></button>
                    </div>
                  </div>
                </form>
                <script>
                  $('#etis').daterangepicker({
                    singleDatePicker:true,
                    linkedCalendars:false,
                    autoUpdateInput:false,
                    showDropdowns:true,
                    showCustomRangeLabel:false,
                    timePicker:false,
                    startDate:"<?php echo date($config['dateFormat'],time());?>",
                    locale:{
                      format:'MMM Do,YYYY h:mm A'
                    }
                  },function(start){
                    $('#etisx').val(start.unix());
                  });
                  $('#etis').on('apply.daterangepicker',function(start,picker){
                    $('#etis').val(picker.startDate.format('YYYY-MMM'));
                  });
                  $('#etie').daterangepicker({
                    singleDatePicker:true,
                    linkedCalendars:false,
                    autoUpdateInput:false,
                    showDropdowns:true,
                    showCustomRangeLabel:false,
                    timePicker:false,
                    startDate:"<?php echo date($config['dateFormat'],time());?>",
                    locale:{
                      format:'MMM Do,YYYY h:mm A'
                    }
                  },function(start){
                    $('#etiex').val(start.unix());
                  });
                  $('#etie').on('apply.daterangepicker',function(start,picker){
                    $('#etie').val(picker.startDate.format('YYYY-MMM'));
                  });
                  $('.enote').summernote({
                    toolbar:[],
                    placeholder:'Enter Education Notes...'
                  });
                </script>
                <hr>
                <div id="education">
<?php $sc=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType='education' AND cid=:cid ORDER BY tis ASC");
$sc->execute([':cid'=>$user['id']]);
while($rc=$sc->fetch(PDO::FETCH_ASSOC)){?>
                  <div id="l_<?php echo$rc['id'];?>">
                    <div class="form-group row">
                      <div class="col-4">
                        <input type="text" class="form-control" value="<?php echo$rc['title'];?>" readonly>
                      </div>
                      <div class="col-4">
                        <input type="text" class="form-control" value="<?php echo$rc['business'];?>" readonly>
                      </div>
                      <div class="col-2">
                        <input type="text" class="form-control" value="<?php echo $rc['tis']==0?'Current':date('Y-M',$rc['tis']);?>" readonly>
                      </div>
                      <div class="col-2">
                        <input type="text" class="form-control" value="<?php echo $rc['tie']==0?'Current':date('Y-M',$rc['tie']);?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col">
                        <div class="form-control" readonly><?php echo$rc['notes'];?></div>
                      </div>
                      <div class="col-1">
                        <button class="btn btn-secondary trash" onclick="purge('<?php echo$rc['id'];?>','content')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                      </div>
                    </div>
                    <hr>
                  </div>
<?php }?>
                </div>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="account-settings">
            <form target="sp" method="post" action="core/update.php" onsubmit="Pace.restart();">
              <div class="form-group row">
                <label for="password" class="col-form-label col-sm-2">Password</label>
                <div class="input-group col-sm-10">
                  <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                  <input type="hidden" name="t" value="login">
                  <input type="hidden" name="c" value="password">
                  <input type="password" id="password" class="form-control" name="da" value="" placeholder="Enter a New Password...">
                  <div class="input-group-append"><button type="submit" class="btn btn-secondary">Update Password</button></div>
                </div>
              </div>
            </form>
            <div class="form-group row">
              <label for="active" class="col-form-label col-8 col-sm-2">Active</label>
              <div class="input-group col-4 col-sm-10">
                <label class="switch switch-label switch-success"><input type="checkbox" id="active" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="active" data-dbb="0"<?php echo$r['active']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
<?php if($user['rank']>899){?>
            <div class="form-group row">
              <label for="rank" class="col-form-label col-sm-2">Rank</label>
              <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="rank" data-tooltip="tooltip" title="Fingerprint Analysis">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
                <select id="rank" class="form-control" onchange="update('<?php echo$r['id'];?>','login','rank',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="rank">
                  <option value="0"<?php echo($r['rank']==0?' selected':'');?>>Visitor</option>
                  <option value="100"<?php echo($r['rank']==100?' selected':'');?>>Subscriber</option>
                  <option value="200"<?php echo($r['rank']==200?' selected':'');?>>Member</option>
                  <option value="300"<?php echo($r['rank']==300?' selected':'');?>>Client</option>
                  <option value="400"<?php echo($r['rank']==400?' selected':'');?>>Contributor</option>
                  <option value="500"<?php echo($r['rank']==500?' selected':'');?>>Author</option>
                  <option value="600"<?php echo($r['rank']==600?' selected':'');?>>Editor</option>
                  <option value="700"<?php echo($r['rank']==700?' selected':'');?>>Moderator</option>
                  <option value="800"<?php echo($r['rank']==800?' selected':'');?>>Manager</option>
                  <option value="900"<?php echo($r['rank']==900?' selected':'');?>>Administrator</option>
                  <?php echo($user['rank']==1000?'<option value="1000"'.($r['rank']==1000?' selected':'').'>Developer</option>':'');?>
                </select>
              </div>
            </div>
<?php }
if($user['rank']>899){?>
            <hr>
            <h4>Account Permissions</h4>
            <div class="form-group row">
              <label for="options0" class="col-form-label col-8 col-sm-3">Add/Remove Content</label>
              <div class="input-group col-4 col-sm-9">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options0" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="0"<?php echo$r['options']{0}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="options1" class="col-form-label col-8 col-sm-3">Edit Content</label>
              <div class="input-group col-4 col-sm-9">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options1" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="1"<?php echo$r['options']{1}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="options2" class="col-form-label col-8 col-sm-3">Add/Edit Bookings</label>
              <div class="input-group col-4 col-sm-9">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options2" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="2"<?php echo$r['options']{2}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="options3" class="col-form-label col-8 col-sm-3">Message Viewing/Editing</label>
              <div class="input-group col-4 col-sm-9">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options3" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="3"<?php echo$r['options']{3}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="options4" class="col-form-label col-8 col-sm-3">Orders Viewing/Editing</label>
              <div class="input-group col-4 col-sm-9">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options4" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="4"<?php echo$r['options']{4}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="options5" class="col-form-label col-8 col-sm-3">User Accounts Viewing/Editing</label>
              <div class="input-group col-4 col-sm-9">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options5" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="5"<?php echo$r['options']{5}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="options6" class="col-form-label col-8 col-sm-3">SEO Viewing/Editing</label>
              <div class="input-group col-4 col-sm-9">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options6" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="6"<?php echo$r['options']{6}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
            <div class="form-group row">
              <label for="options7" class="col-form-label col-8 col-sm-3">Preferences Viewing/Editing</label>
              <div class="input-group col-4 col-sm-9">
                <label class="switch switch-label switch-success"><input type="checkbox" id="options7" class="switch-input" data-dbid="<?php echo$r['id'];?>" data-dbt="login" data-dbc="options" data-dbb="7"<?php echo$r['options']{7}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
              </div>
            </div>
<?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
