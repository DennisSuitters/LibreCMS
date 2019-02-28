<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Social Preferences
 *
 * pref-social.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Preferences - Social
 * @package    core/layout/pref_social.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active" aria-current="page">Social Networking</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label for="options9" class="col-form-label col-sm-2" data-tooltip="tooltip" title="Toggle RSS Feed Icon.">Show RSS Feed Icon</label>
          <div class="input-group col-sm-10">
            <label class="switch switch-label switch-success"><input type="checkbox" id="options9" class="switch-input" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="9"<?php echo$config['options']{9}==1?' checked':'';?>><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
          </div>
        </div>
        <form target="sp" method="post" action="core/add_data.php">
          <input type="hidden" name="user" value="0">
          <input type="hidden" name="act" value="add_social">
          <div class="form-group row">
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
<?php $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='social' AND uid=0 ORDER BY icon ASC");
$ss->execute();
while($rs=$ss->fetch(PDO::FETCH_ASSOC)){?>
          <div id="l_<?php echo$rs['id'];?>" class="form-group row">
            <div class="input-group col-12">
              <div class="input-group-text" data-tooltip="tooltip" title="<?php echo ucfirst($rs['icon']);?>"><span class="libre-social"><?php svg('libre-social-'.$rs['icon']);?></span></div>
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
    </div>
  </div>
</main>
