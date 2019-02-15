<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
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
