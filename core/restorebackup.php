<script>/*<![CDATA[*/
    window.top.window.$('#backup_info').html('');
<?php
session_start();
include'db.php';
$fu=$_FILES['fu'];
if(isset($_FILES['fu'])){
    $tp='../media/backup/'.basename($_FILES['fu']['name']);
    if(move_uploaded_file($_FILES['fu']['tmp_name'],$tp)){
        $sql=file_get_contents($tp);
        $q=$db->exec($sql);
        $e=$db->errorInfo();
        if(is_null($e[2])){?>
    window.top.window.$('#backup_info').html('<div class="alert alert-success">Restore from Backup Successful!</div>');
<?php   }else{?>
    window.top.window.$('#backup_info').html('<div class="alert alert-danger">There was an issue Restoring the Backup!<br><?php echo$r[2];?></div>');
<?php   }
    }
}
if(file_exists($tp))unlink($tp);?>
    window.top.window.$('#block').css("display","none");
/*]]>*/</script>
