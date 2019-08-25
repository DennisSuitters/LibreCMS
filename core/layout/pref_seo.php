<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Database SEO
 *
 * pref_seo.php version 2.0.6
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
 * @version    2.0.6
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 * @changes    v2.0.3 Add metaRobots to Configuration.
 * @changes    v2.0.6 Build workaround for Google Tracking ID.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php echo localize('Preferences');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('SEO');?></li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
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
              <a target="_blank" id="humans" href="<?php echo URL.'humans.txt';?>"><?php echo URL.'humans.txt';?></a>
            </div>
          </div>
        </div>
        <hr />
        <div class="help-block small text-muted text-right"><?php echo localize('help_metarobots');?></div>
        <div class="form-group row">
          <label for="metaRobots" class="col-form-label col-sm-2"><?php echo localize('Meta Robots');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-append"><button class="btn btn-secondary fingerprint" data-dbgid="metaRobots" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="metaRobots" class="form-control textinput" value="<?php echo$config['metaRobots'];?>" data-dbid="1" data-dbt="config" data-dbc="metaRobots" placeholder="<?php echo localize('Enter ').' '.localize('Meta Robots').' '.localize('Options');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savemetaRobots" class="btn btn-secondary save" data-dbid="metaRobots" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-right"><?php echo localize('help_seotitle');?></div>
        <div class="form-group row">
          <label for="seoTitle" class="col-form-label col-sm-2"><?php echo localize('SEO Title');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoTitle" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=70-strlen($config['seoTitle']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div id="seoTitlecnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo$cnt;?></div>
            <div class="input-group-append">
              <button class="btn btn-secondary" onclick="removeStopWords('seoTitle',$('#seoTitle').val());" data-tooltip="tooltip" title="<?php echo localize('Remove Stop Words');?>" role="button" aria-label="<?php echo localize('aria_seo_stopwords');?>"><?php svg('libre-gui-magic');?></button>
            </div>
            <?php if($config['suggestions']==1){
              $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
              $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoTitle']);
              echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip"tooltip" title="'.localize('Suggestions').'"><button class="btn btn-secondary suggestion" data-dbgid="seoTitle" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';
            }?>
            <input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$config['seoTitle'];?>" data-dbid="1" data-dbt="config" data-dbc="seoTitle" placeholder="<?php echo localize('Enter an ').' '.localize('SEO Title');?>..." role="textbox">
            <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-dbgid="seoTitle" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoTitle" class="btn btn-secondary save" data-dbid="seoTitle" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-right"><?php echo localize('help_seocaption');?></div>
        <div class="form-group row">
          <label for="seoCaption" class="col-form-label col-sm-2"><?php echo localize('SEO Caption');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoCaption" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($config['seoCaption']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div id="seoCaptioncnt" class="input-group-text text-success<?php echo$cnt<0?' text-danger':'';?>"><?php echo $cnt;?></div>
            <?php if($config['suggestions']==1){
              $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
              $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoCaption']);
              echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Suggestions').'"><button class="btn btn-default suggestion" data-dbgid="seoCaption" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';
            }?>
            <input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$config['seoCaption'];?>" data-dbid="1" data-dbt="config" data-dbc="seoCaption" placeholder="<?php echo localize('Enter a ').' '.localize('Caption');?>..." role="textbox">
            <?php echo$user['rank']>899?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-dbgid="seoCaption" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoCaption" class="btn btn-secondary save" data-dbid="seoCaption" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-right"><?php echo localize('help_seodescription');?></div>
        <div class="form-group row">
          <label for="seoDescription" class="col-form-label col-sm-2"><?php echo localize('SEO Description');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoDescription" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
$cntc=160-strlen($config['seoDescription']);
if($cntc<0){
  $cnt=abs($cntc);
  $cnt=number_format($cnt)*-1;
}else$cnt=number_format($cntc);?>
            <div id="seoDescriptioncnt" class="input-group-text text-success<?php echo($cnt<0?' text-danger':'');?>"><?php echo$cnt;?></div>
            <?php if($config['suggestions']==1){
              $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
              $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoDescription']);
              echo$ss->rowCount()>0?'<div class="input-group-prepend" data-tooltip="tooltip" title="'.localize('Suggestions').'"><button class="btn btn-secondary suggestion" data-dbgid="seoDescription" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';
            }?>
            <input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$config['seoDescription'];?>" data-dbid="1" data-dbt="config" data-dbc="seoDescription" placeholder="<?php echo localize('Enter a ').' '.localize('Description');?>..." role="textbox">
            <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-dbgid="seoDescription" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoDescription" class="btn btn-secondary save" data-dbid="seoDescription" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seoKeywords" class="control-label col-sm-2"><?php echo localize('SEO Keywords');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seoKeywords" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';
            if($config['suggestions']==1){
              $ss=$db->prepare("SELECT rid FROM `".$prefix."suggestions` WHERE rid=:rid AND t=:t AND c=:c");
              $ss->execute([':rid'=>1,':t'=>'config',':c'=>'seoKeywords']);
              echo$ss->rowCount()>0?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Suggestions').'"><button class="btn btn-secondary suggestion" data-dbgid="seoKeywords" role="button" aria-label="'.localize('aria_suggestions').'">'.svg2('libre-gui-lightbulb','','green').'</button></div>':'';
            }?>
            <input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$config['seoKeywords'];?>" data-dbid="1" data-dbt="config" data-dbc="seoKeywords" placeholder="<?php echo localize('Enter ').' '.localize('Keywords');?>..." role="textbox">
            <?php echo$user['rank']>899?'<div class="input-group-append" data-tooltip="tooltip" title="'.localize('Add Suggestion').'"><button class="btn btn-secondary addsuggestion" data-dbgid="seoKeywords" role="button" aria-label="'.localize('aria_suggestions_add').'">'.svg2('libre-gui-idea').'</button></div>':'';?>
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseoKeywords" class="btn btn-secondary save" data-dbid="seoKeywords" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <hr/>
        <h4><?php echo localize('SEO Analytics');?></h4>
        <div class="form-group row">
          <label for="ga_verification" class="col-form-label col-sm-2"><?php echo localize('Google Verification');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="ga_verification" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="ga_verification" class="form-control textinput" value="<?php echo$config['ga_verification'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_verification" placeholder="<?php echo localize('Enter Google Site Verification Code');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savega_verification" class="btn btn-secondary save" data-dbid="ga_verification" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="help-block small text-right">Go to <a target="_blank" href="https://analytics.google.com/">Google Analytics</a> to setup a Google Analytics Account, and get your Page Tracking Code.<br>Only the UA code is required to enter below.</div>
        <div class="form-group row">
          <label for="ga_tracking" class="col-form-label col-sm-2">Google Tracking Code (UA)</label>
          <div class="input-group col-sm-10">
            <input type="text" id="ga_tracking" class="form-control textinput" value="<?php echo$config['ga_tracking'];?>" data-dbid="1" data-dbt="config" data-dbc="ga_tracking" placeholder="Enter Google UA Code..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="Save"><button id="savega_tracking" class="btn btn-secondary save" data-dbid="ga_tracking" data-style="zoom-in" role="button" aria-label="Save"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_msvalidate" class="col-form-label col-sm-2"><?php echo localize('Microsoft Validate');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seo_msvalidate" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="seo_msvalidate" class="form-control textinput" value="<?php echo$config['seo_msvalidate'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_msvalidate" placeholder="<?php echo localize('Enter Microsoft Site Validation Code');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseo_msvalidate" class="btn btn-secondary save" data-dbid="seo_msvalidate" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_yandexverification" class="col-form-label col-sm-2"><?php echo localize('Yandex Verification');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seo_yandexverification" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="seo_yandexverification" class="form-control textinput" value="<?php echo$config['seo_yandexverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_yandexverification" placeholder="<?php echo localize('Enter Yandex Site Verification Code');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseo_yandexverification" class="btn btn-secondary save" data-dbid="seo_yandexverification" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_alexaverification" class="col-form-label col-sm-2"><?php echo localize('Alexa Verification');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seo_alexaverification" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="seo_alexaverification" class="form-control textinput" value="<?php echo$config['seo_alexaverification'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_alexaverification" placeholder="<?php echo localize('Enter Alexa Site Verification Code');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseo_alexaverification" class="btn btn-secondary save" data-dbid="seo_alexaverification" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="seo_domainverify" class="col-form-label col-sm-2"><?php echo localize('Domain Verify');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="seo_domainverify" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="seo_domainverify" class="form-control textinput" value="<?php echo$config['seo_domainverify'];?>" data-dbid="1" data-dbt="config" data-dbc="seo_domainverify" placeholder="<?php echo localize('Enter Domain Verification Code');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="saveseo_domainverify" class="btn btn-secondary save" data-dbid="seo_domainverify" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <hr/>
        <h4><?php echo localize('GEO Location');?></h4>
        <div class="form-group row">
          <label for="geo_region" class="col-form-label col-sm-2"><?php echo localize('Region');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="geo_region" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="geo_region" class="form-control textinput" value="<?php echo$config['geo_region'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_region" placeholder="<?php echo localize('Enter ').' '.localize('Region');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savegeo_region" class="btn btn-secondary save" data-dbid="geo_region" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="geo_placename" class="col-form-label col-sm-2"><?php echo localize('Placename');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="geo_placename" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="geo_placename" class="form-control textinput" value="<?php echo$config['geo_placename'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_placename" placeholder="<?php echo localize('Enter a').' '.localize('Placename');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savegeo_placename" class="btn btn-secondary save" data-dbid="geo_placename" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="geo_position" class="col-form-label col-sm-2"><?php echo localize('Position');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="geo_position" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="geo_position" class="form-control textinput" value="<?php echo$config['geo_position'];?>" data-dbid="1" data-dbt="config" data-dbc="geo_position" placeholder="<?php echo localize('Enter a').' '.localize('Position');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" title="<?php echo localize('Save');?>"><button id="savegeo_position" class="btn btn-secondary save" data-dbid="geo_position" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
