<script>/*<![CDATA[*/
<?php
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
function svg($svg,$size=null,$color=null){
	echo'<i class="libre';
	if($size!=null)echo' libre-'.$size;
	if($color!=null)echo' libre-'.$color;
	echo'">';
	include'svg'.DS.'libre-'.$svg.'.svg';
	echo'</i>';
}
$tables=array();
$db->setAttribute(PDO::ATTR_ORACLE_NULLS,PDO::NULL_TO_STRING);
$compression=true;
$nowtimename=time();
if($compression){
	$file=date('y-d-m',time()).'-'.$nowtimename.'.sql.gz';
	$zp=gzopen('..'.DS.'media'.DS.'backup'.DS.$file,"w9");
}else{
	$file=date('y-d-m',time()).'-'.$nowtimename.'.sql';
	$handle=fopen('..'.DS.'media'.DS.'backup'.DS.$file,'a+');
}
$numtypes=array('tinyint','smallint','mediumint','int','bigint','float','double','decimal','real');
if(empty($tables)){
	$pstm1=$db->query('SHOW TABLES');
	while($row=$pstm1->fetch(PDO::FETCH_NUM)){
		$tables[]=$row[0];
	}
}else{
	$tables=is_array($tables)?$tables:explode(',',$tables);
}
foreach($tables as $table){
	$result=$db->query('SELECT * FROM '.$table);
	$num_fields=$result->columnCount();
	$num_rows=$result->rowCount();
	$return="";
	$return.= 'DROP TABLE IF EXISTS `'.$table.'`;';
	$pstm2=$db->query('SHOW CREATE TABLE '.$table);
	$row2=$pstm2->fetch(PDO::FETCH_NUM);
	$ifnotexists=str_replace('CREATE TABLE','CREATE TABLE IF NOT EXISTS',$row2[1]);
	$return.="\n\n".$ifnotexists.";\n\n";
	if($compression)gzwrite($zp,$return);else fwrite($handle,$return);
	$return="";
	if($num_rows){
		$return='INSERT INTO `'.$table."` (";
		$pstm3=$db->query('SHOW COLUMNS FROM '.$table);
		$count=0;
		$type=array();
		while($rows=$pstm3->fetch(PDO::FETCH_NUM)){
			if(stripos($rows[1],'('))$type[$table][]=stristr($rows[1],'(',true);else$type[$table][]=$rows[1];
			$return.=$rows[0];
			$count++;
			if($count<($pstm3->rowCount()))$return.=", ";
		}
		$return.= ")".' VALUES';
		if($compression)gzwrite($zp,$return);else fwrite($handle,$return);
		$return="";
	}
	$count=0;
	while($row=$result->fetch(PDO::FETCH_NUM)){
		$return="\n\t(";
		for($j=0;$j<$num_fields;$j++){
			$row[$j]=addslashes($row[$j]);
			if(isset($row[$j])){
				if(in_array($type[$table][$j],$numtypes))$return.=$row[$j];else$return.='"'.$row[$j].'"' ;
			}else$return.='""';
			if($j<($num_fields-1))$return.= ',';
		}
		$count++;
		if($count<($result->rowCount()))$return.="),";else$return.=");";
		if($compression)gzwrite($zp,$return);else fwrite($handle,$return);
		$return="";
	}
	$return="\n\n-- ------------------------------------------------ \n\n";
	if($compression)gzwrite($zp,$return);else fwrite($handle,$return);
	$return="";
}
if($compression)gzclose($zp);else fclose($handle);
if(file_exists('..'.DS.'media'.DS.'backup'.DS.$file)){
  chmod('..'.DS.'media'.DS.'backup'.DS.$file,0777);
  $fileid=str_replace('.','',$file);
  $fileid=str_replace(DS,'',$fileid);
	$filename=basename($file);
  $ti=time();
  $q=$db->prepare("UPDATE config SET backup_ti=:backup_ti WHERE id='1'");
  $q->execute(array(':backup_ti'=>$ti));?>
  window.top.window.$('#backups').append('<div id="l_<?php echo$fileid;?>" class="form-group"><label class="control-label col-xs-5 col-sm-3 col-lg-2">&nbsp;</label><div class="input-group col-xs-7 col-sm-9 col-lg-10"><a class="btn btn-default btn-block" href="media/backup/<?php echo$file;?>">Click to Download <?php echo$file;?></a><div class="input-group-btn"><button class="btn btn-default trash" onclick="removeBackup(\'<?php echo$fileid;?>\',\'<?php echo$filename;?>\')"><?php svg('trash');?></button></div></div></div>');
  window.top.window.$('#alert_backup').addClass('hidden');
<?php }else{?>
  window.top.window.$('#backup_info').html('<div class="alert alert-danger">There was an issue performing the backup!</div>');
<?php }?>
  window.top.window.Pace.stop();
/*]]>*/</script>
