<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo'<script>/*<![CDATA[*/';
echo'window.top.window.$("#updateheading").html("System Updates...");';
echo'window.top.window.$("#update").html("");';
ini_set('max_execution_time',60);
require'db.php';
$config=$db->query("SELECT update_url,development FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
$settings=parse_ini_file('config.ini',TRUE);
$gV=file_get_contents($config['update_url'].'versions');
$update=0;
$uL='';
$found=true;
$vL=explode("\n",$gV);
foreach($vL as$aV){
  if($aV=='')continue;
  if($aV<$settings['system']['version'])continue;
  if(!is_file('..'.DS.'media'.DS.'updates'.DS.$aV.'.zip')){?>
  window.top.window.$('#update').append('<div class="alert alert-info">Downloading New Update...</div>');
<?php if(false===file_get_contents($config['update_url'].$aV.".zip",0,null,0,1)){
    $found=false;?>
  window.top.window.$('#update').append('<div class="alert alert-danger">File doesn\'t exist on remote server...</div>');
<?php }else{
    $newUpdate=file_get_contents($config['update_url'].$aV.'.zip');
    if(!is_dir('..'.DS.'media'.DS.'updates'.DS))mkdir('..'.DS.'media'.DS.'updates'.DS);
    $dlHandler=fopen('..'.DS.'media'.DS.'updates'.DS.$aV.'.zip','w');
    if(!fwrite($dlHandler,$newUpdate)){
      $found=false;?>
  window.top.window.$('#update').append('<div class="alert alert-danger">Could note save new update. Aborted!!!</div>');
<?php
      exit();
    }
    fclose($dlHandler);?>
  window.top.window.$('#update').append('<div class="alert alert-success">Update Downloaded And Saved...</div>');
<?php
    }
  }else{?>
  window.top.window.$('#update').append('<div class="alert alert-info">Update already downloaded....</div>');
<?php }
if($found==true){
  $zipHandle=zip_open('..'.DS.'media'.DS.'updates'.DS.$aV.'.zip');
  $html='<ul>';
  while($aF=zip_read($zipHandle)){
    $thisFileName=zip_entry_name($aF);
    $thisFileDir=dirname($thisFileName);
    if(substr($thisFileName,-1,1)=='/')continue;
    if(!is_dir('..'.DS.$thisFileDir)){
      mkdir('..'.DS.$thisFileDir);
      $html.='<li>Created Directory '.$thisFileDir.'</li>';
    }
    if(!is_dir('..'.DS.$thisFileName)){
      $html.='<li>'.$thisFileName.'...........';
      $contents=zip_entry_read($aF,zip_entry_filesize($aF));
      $updateThis='';
      if($thisFileName=='core'.DS.'doupgrade.php'){
        $upgradeExec=fopen('doupgrade.php', 'w');
        fwrite($upgradeExec,$contents);
        fclose($upgradeExec);
        include('doupgrade.php');
        unlink('doupgrade.php');
        $html.=' <strong class="text-success">EXECUTED</strong></li>';
      }else{
        $updateThis=fopen('..'.DS.$thisFileName,'w');
        fwrite($updateThis,$contents);
        fclose($updateThis);
        unset($contents);
        $html.=' <strong class="text-success">UPDATED</strong></li>';
      }
    }
  }?>
  window.top.window.$('#update').append('<?php echo$html;?>');
<?php $updated=TRUE;
  $txt='[database]'.PHP_EOL.
       'driver = '.$settings['database']['driver'].PHP_EOL.
       'host = '.$settings['database']['host'].PHP_EOL.
       (isset($settings['database']['port'])==''?';port = 3306'.PHP_EOL:'port = '.$settings['database']['post'].PHP_EOL).
       'schema = '.$settings['database']['schema'].PHP_EOL.
       'username = '.$settings['database']['username'].PHP_EOL.
       'password = '.$settings['database']['password'].PHP_EOL.
       '[system]'.PHP_EOL.
       'version = '.time().PHP_EOL.
       'url = '.$settings['system']['url'].PHP_EOL.
       'admin = '.$settings['system']['admin'].PHP_EOL;
  if(file_exists('config.ini'))unlink('config.ini');
  $oFH=fopen("config.ini",'w');
  fwrite($oFH,$txt);
  fclose($oFH);?>
  window.top.window.$('#update').append('<div class="alert alert-success">Configuration Updated!</div>');
<?php }else{?>
  window.top.window.$('#update').append('<div class="alert alert-danger">Could not find latest Update.</div>');
<?php }
}
$su=$db->prepare("UPDATE config SET uti=:uti WHERE id='1'");
$su->execute(array(':uti'=>time()));
echo'window.top.window.Pace.stop();';
echo'/*]]>*/</script>';
