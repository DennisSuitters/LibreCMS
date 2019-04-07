<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Check for Updates
 *
 * updatecheck.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Update Check
 * @package    core/layout/updatecheck.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require'..'.DS.'db.php';
$config=$db->query("SELECT language,update_url FROM `".$prefix."config` WHERE id=1")->fetch(PDO::FETCH_ASSOC);
function localize($t){
  static $tr=NULL;
  global $config;
  if(is_null($tr)){
    if(file_exists('..'.DS.'..'.DS.'core'.DS.'i18n'.DS.$config['language'].'.txt'))
      $lf='..'.DS.'..'.DS.'core'.DS.'i18n'.DS.$config['language'].'.txt';
    else
      $lf='core'.DS.'i18n'.DS.'en-AU.txt';
    $lfc=file_get_contents($lf);
    $tr=json_decode($lfc,true);
  }
  if(is_array($tr)){
    if(!array_key_exists($t,$tr))
      echo'Error: No "'.$t,'" Key in '.$config['language'];
    else
      return$tr[$t];
  }else
    echo'Error: '.$config['language'].' is malformed';
}
if($config['update_url']!=''){
  $settings=parse_ini_file('..'.DS.'config.ini',TRUE);
  $gV=@file_get_contents($config['update_url'].'versions') or die();
  $update=0;
  $uL='';
  if($gV!=''){
    $vL=explode("\n",$gV);
    foreach($vL as$aV){
      if($vL=='')continue;
      $uV=(int)$aV;
      if($uV>$settings['system']['version']){
        $update=1;
        $uL.='<p>Update available: '.date('M jS, Y g:i A',$uV).'.<br>'.@file_get_contents($config['update_url'].$uV.'.nfo').'</p>';
      }
    }
  }
  if($update==0){?>
  <div class="col-form-label col-sm-2"></div>
  <div class="input-group col-sm-10">
    <div class="col alert alert-success" role="alert"><?php echo localize('warning_updatenoupdate');?></div>
  </div>
<?php if($update==1){?>
  <div class="col-form-label col-sm-2"></div>
  <div class="input-group col-sm-10">
    <div class="col alert alert-warning" role="alert">
      <p><?php echo localize('Current update was on ').date('M jS, Y g:i A',$settings['system']['version']);?></p>
      <p><?php echo$uL;?></p>
      <p>
        <form target="sp" method="POST" action="core/upgrade.php" onsubmit="Pace.restart();" role="form">
          <input type="hidden" name="version" value="<?php echo$remoteVersion['system']['version'];?>">
          <button type="submit" class="btn btn-success" role="button" aria-label="Do Updates"><?php echo localize('Do Updates');?>....</button>
        </form>
      </p>
    </div>
  </div>
<?php }
  }
}else{?>
  <div class="col-form-label col-sm-2"></div>
  <div class="input-group col-sm-10">
    <div class="col alert alert-danger" role="alert"><?php echo localize('warning_updatenourl');?></div>
  </div>
<?php }
