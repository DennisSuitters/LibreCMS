<?php
$settings=parse_ini_file('../config.ini',TRUE);
$handle=@fopen('https://www.studiojunkyard.com/update/version.ini','r');
if($handle){
  $getVersion=file_get_contents('https://www.studiojunkyard.com/update/version.ini');
  $remoteVersion=parse_ini_string($getVersion,TRUE);
  if($remoteVersion!=''){
    if($remoteVersion['system']['version']>$settings['system']['version']){?>
<div class="alert alert-info">
  <p>A System Update is available.</p>
  <p>Current System last update was on <?php echo date('M jS, Y g:i A',$settings['system']['version']);?></p>
  <p>Latest Update was available on <?php echo date('M jS, Y g:i A',$remoteVersion['system']['version']);?></p>
  <p>
    What this update does:<br>
    <?php echo$remoteVersion['system']['description'];?>
  </p>
  <p>
    <form target="sp" method="POST" action="core/upgrade.php" onsubmit="$('#block').css({'display':'block'});">
      <input type="hidden" name="version" value="<?php echo$remoteVersion['system']['version'];?>">
      <button type="submit" class="btn btn-success">Update Now....</button>
    </form>
  </p>
</div>
<?php }
  }
}
