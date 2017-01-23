<script>/*<![CDATA[*/
  window.top.window.$('#backup_info').html('');
<?php include'db.php';
$fu=$_FILES['fu'];
if(isset($_FILES['fu'])){
  $file='../media/backup/'.basename($_FILES['fu']['name']);
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
  window.top.window.$('#block').css({'display':'none'});
/*]]>*/</script>
