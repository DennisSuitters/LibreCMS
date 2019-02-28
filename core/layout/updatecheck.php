<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Check for Updates
 *
 * updatecheck.php version 2.0.0
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
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
require'..'.DS.'db.php';
$config=$db->query("SELECT update_url FROM `".$prefix."config` WHERE id=1")->fetch(PDO::FETCH_ASSOC);
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
}
if($update==0){?>
  <div class="col-form-label col-sm-2"></div>
  <div class="input-group col-sm-10">
    <div class="col alert alert-success">There are currently no updates available or required!</div>
  </div>    
<?php if($update==1){?>
  <div class="col-form-label col-sm-2"></div>
  <div class="input-group col-sm-10">
    <div class="col alert alert-warning">
      <p>Current update was on <?php echo date('M jS, Y g:i A',$settings['system']['version']);?></p>
      <p><?php echo$uL;?></p>
      <p>
        <form target="sp" method="POST" action="core/upgrade.php" onsubmit="Pace.restart();">
          <input type="hidden" name="version" value="<?php echo$remoteVersion['system']['version'];?>">
          <button type="submit" class="btn btn-success">Do Updates....</button>
        </form>
      </p>
    </div>
  </div>
<?php }
}else{?>
  <div class="col-form-label col-sm-2"></div>
  <div class="input-group col-sm-10">
    <div class="col alert alert-danger">
      The URL is NOT valid or NOT set.
    </div>
  </div>
<?php }
