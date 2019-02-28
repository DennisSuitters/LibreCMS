<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Database SEO
 *
 * pref_seo.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Preferences - SEO
 * @package    core/layout/pref_seo.php
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
    <li class="breadcrumb-item active" aria-current="page">SEO</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label class="col-form-label col-sm-2">sitemap.xml</label>
          <div class="input-group col-sm-10">
            <div class="input-group-text col">
              <a target="_blank" href="<?php echo URL.'sitemap.xml';?>"><?php echo URL.'sitemap.xml';?></a>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">humans.txt</label>
          <div class="input-group col-sm-10">
            <div class="input-group-text col">
              <a id="humans" target="_blank" href="<?php echo URL.'humans.txt';?>"><?php echo URL.'humans.txt';?></a>
            </div>
          </div>
        </div>
        <hr />
        <div class="help-block small text-muted text-right">These will be used if Page or Content Seo Fields are empty.<br>The recommended character count for Title's is 70.</div>
        <div class="form-group row">
          <label for="seoTitle" class="col-form-label col-sm-2">SEO Title</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoTitle" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=70-strlen($config['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div id="seoTitlecnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></div>
            <div class="input-group-append">
              <button class="btn btn-secondary" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-tooltip="tooltip" title="Remove Stop Words."><?php svg('libre-gui-magic');?></button>
            </div>
<?php if($config['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoTitle']);
  echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip"tooltip" title="Suggestions"><button class="btn btn-secondary suggestion" data-dbgid="seoTitle">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';
}?>
            <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$config['seoTitle'];?>" data-dbid="1" data-dbt="config" data-dbc="seoTitle" placeholder="Enter an SEO Title...">
<?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoTitle">'.svg2('libre-gui-idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoTitle" class="btn btn-secondary save" data-dbid="seoTitle" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">The recommended character count for Captions is 160, as sometime Captions may be used in Descriptions.</div>
        <div class="form-group row">
          <label for="seoCaption" class="col-form-label col-sm-2">SEO Caption</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoCaption" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($config['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div id="seoCaptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo $cnt;?></div>
<?php if($config['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoCaption']);
  echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip="tooltip" title="Suggestions"><button class="btn btn-default suggestion" data-dbgid="seoCaption">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';
}?>
            <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$config['seoCaption'];?>" data-dbid="1" data-dbt="config" data-dbc="seoCaption" placeholder="Enter a Caption...">
            <?php echo$user['rank']>899?'<div class="input-group-prepend" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoCaption">'.svg2('libre-gui-idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoCaption" class="btn btn-secondary save" data-dbid="seoCaption" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">The recommended character count for Descriptions is 160.</div>
        <div class="form-group row">
          <label for="seoDescription" class="col-form-label col-sm-2">SEO Description</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoDescription" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($config['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div id="seoDescriptioncnt" class="input-group-text text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></div>
<?php if($config['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoDescription']);
  echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="Suggestions"><button class="btn btn-secondary suggestion" data-dbgid="seoDescription">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';
}?>
            <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$config['seoDescription'];?>" data-dbid="1" data-dbt="config" data-dbc="seoDescription" placeholder="Enter a Description...">
<?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoDescription">'.svg2('libre-gui-idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoDescription" class="btn btn-secondary save" data-dbid="seoDescription" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seoKeywords" class="control-label col-sm-2">SEO Keywords</label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoKeywords" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';
if($config['suggestions']==1){
  $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
  $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoKeywords']);
  echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip="tooltip" title="Suggestions"><button class="btn btn-secondary suggestion" data-dbgid="seoKeywords">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';
}?>
            <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$config['seoKeywords'];?>" data-dbid="1" data-dbt="config" data-dbc="seoKeywords" placeholder="Enter Keywords...">
            <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="Add Suggestion"><button class="btn btn-secondary addsuggestion" data-dbgid="seoKeywords">'.svg2('libre-gui-idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseoKeywords" class="btn btn-secondary save" data-dbid="seoKeywords" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <hr/>
        <h4>SEO Analytics</h4>
        <div class="form-group row">
          <label for="ga_verification" class="col-form-label col-sm-2">Google Verification</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="ga_verification" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="ga_verification" class="form-control textinput" value="<?php echo$config['ga_verification'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_verification" placeholder="Enter Google Site Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savega_verification" class="btn btn-secondary save" data-dbid="ga_verification" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-muted text-right">Go to <a target="_blank" href="https://analytics.google.com">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>The <code>&lt;script&gt;&lt;/script&gt;</code> tags aren't necessary as they will be stripped from the text when saved.</div>
        <div class="form-group row">
          <label for="ga_tracking" class="col-form-label col-sm-2">Tracking Code</label>
          <div class="card-header col-sm-10" style="padding:0;">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="ga_tracking" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div><div id="da" class="hidden-xs" data-dbid="1" data-dbt="config" data-dbc="ga_tracking"></div>':'';?>
            <form target="sp" method="post" action="core/update.php" onsubmit="Pace.restart();$('#ga_tracking_save').removeClass('btn-danger');">
              <input type="hidden" name="id" value="1">
              <input type="hidden" name="t" value="config">
              <input type="hidden" name="c" value="ga_tracking">
              <div class="input-group col-sm-10 p-2">
                <button type="submit" id="ga_tracking_save" class="btn btn-secondary btn-sm" data-tooltip="tooltip" data-placement="bottom" title="Save"><?php svg('libre-gui-save');?></button>
              </div>
              <div class="input-group col p-0">
                <textarea id="ga_tracking" class="form-control" style="height:100px" name="da" onkeyup="$('#ga_tracking_save').addClass('btn-danger');"><?php echo $config['ga_tracking'];?></textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="form-group row">
          <label for="seo_msvalidate" class="col-form-label col-sm-2">Microsoft Validate</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seo_msvalidate" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="seo_msvalidate" class="form-control textinput" value="<?php echo$config['seo_msvalidate'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" placeholder="Enter Microsoft Site Validation Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseo_msvalidate" class="btn btn-secondary save" data-dbid="seo_msvalidate" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_yandexverification" class="col-form-label col-sm-2">Yandex Verification</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seo_yandexverification" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="seo_yandexverification" class="form-control textinput" value="<?php echo$config['seo_yandexverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" placeholder="Enter Yandex Site Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseo_yandexverification" class="btn btn-secondary save" data-dbid="seo_yandexverification" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_alexaverification" class="col-form-label col-sm-2">Alexa Verification</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seo_alexaverification" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="seo_alexaverification" class="form-control textinput" value="<?php echo$config['seo_alexaverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_alexaverification" placeholder="Enter Alexa Site Verification Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseo_alexaverification" class="btn btn-secondary save" data-dbid="seo_alexaverification" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_domainverify" class="col-form-label col-sm-2">Domain Verify</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seo_domainverify" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="seo_domainverify" class="form-control textinput" value="<?php echo$config['seo_domainverify'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" placeholder="Enter Domain Verify Code...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="saveseo_domainverify" class="btn btn-secondary save" data-dbid="seo_domainverify" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <hr/>
        <h4>GEO Location</h4>
        <div class="form-group row">
          <label for="geo_region" class="col-form-label col-sm-2">Region</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="geo_region" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="geo_region" class="form-control textinput" value="<?php echo$config['geo_region'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_region" placeholder="Enter GEO Region...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savegeo_region" class="btn btn-secondary save" data-dbid="geo_region" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="geo_placename" class="col-form-label col-sm-2">Placename</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="geo_placename" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="geo_placename" class="form-control textinput" value="<?php echo$config['geo_placename'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_placename" placeholder="Enter GEO Placename...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savegeo_placename" class="btn btn-secondary save" data-dbid="geo_placename" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="geo_position" class="col-form-label col-sm-2">Position</label>
          <div class="input-group col-sm-10">
<?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="geo_position" data-tooltip="tooltip" title="Fingerprint Analysis.">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="geo_position" class="form-control textinput" value="<?php echo$config['geo_position'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_position" placeholder="Enter GEO Position...">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savegeo_position" class="btn btn-secondary save" data-dbid="geo_position" data-style="zoom-in"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
