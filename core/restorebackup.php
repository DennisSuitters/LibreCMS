<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Restore Backup
 *
 * restorebackup.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Restore Backup
 * @package    core/restorebackup.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
echo"<script>window.top.window.$('#backup_info').html('');";
require'db.php';
$fu=$_FILES['fu'];
if(isset($_FILES['fu'])){
  $file='..'.DS.'media'.DS.'backup'.DS.basename($_FILES['fu']['name']);
  if(move_uploaded_file($_FILES['fu']['tmp_name'],$file)){
    $sql=file_get_contents($file);
    if(stristr($file,'.sql.gz'))$sql=gzinflate(substr($sql,10,-8));
    $q=$db->exec($sql);
    $e=$db->errorInfo();
    if(is_null($e[2])){?>
  window.top.window.$('#backup_info').html('<div class="alert alert-success">Restore from Backup Successful!</div>');
<?php }else{?>
  window.top.window.$('#backup_info').html('<div class="alert alert-danger">There was an issue Restoring the Backup!<br><?php echo$r[2];?></div>');
<?php }
  }
}?>
  window.top.window.Pace.stop();
<?php
echo'</script>';
