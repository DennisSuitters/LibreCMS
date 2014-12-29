<?php
echo'<script>/*<![CDATA[*/';
session_start();
include'db.php';
$tables=array();
$db->setAttribute(PDO::ATTR_ORACLE_NULLS,PDO::NULL_NATURAL);
$compression=true;
$nowtimename=date('d-m-Y',time());
if($compression){
	$file='backup_'.$nowtimename.'.sql.gz';
	$zp=gzopen('../media/backup/'.$file,"a9");
}else{
	$file='backup_'.$nowtimename.'.sql';
	$handle=fopen('../media/backup/'.$file,'a+');
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
	$result=$db->query("SELECT * FROM $table");
	$num_fields=$result->columnCount();
	$num_rows=$result->rowCount();
	$return="";
	$return.='DROP TABLE IF EXISTS `'.$table.'`;'; 
	$pstm2=$db->query("SHOW CREATE TABLE $table");
	$row2=$pstm2->fetch(PDO::FETCH_NUM);
	$ifnotexists=str_replace('CREATE TABLE','CREATE TABLE IF NOT EXISTS',$row2[1]);
	$return.="\n\n".$ifnotexists.";\n\n";
	if($compression){
		gzwrite($zp,$return);
	}else{
		fwrite($handle,$return);
	}
	$return="";
	if($num_rows){
		$return='INSERT INTO `'."$table"."` (";
		$pstm3=$db->query("SHOW COLUMNS FROM $table");
		$count=0;
		$type=array();
		while($rows=$pstm3->fetch(PDO::FETCH_NUM)){
			if(stripos($rows[1],'(')){
				$type[$table][]=stristr($rows[1],'(',true);
			}else $type[$table][]=$rows[1];
			$return.="`".$rows[0]."`";
			$count++;
			if($count<($pstm3->rowCount())){
				$return.=", ";
			}
		}
		$return.=")".' VALUES';
		if($compression){
			gzwrite($zp,$return);
		}else{
			fwrite($handle,$return);
		}
		$return="";
	}
	$count=0;
	while($row=$result->fetch(PDO::FETCH_NUM)){
		$return="\n\t(";
		for($j=0;$j<$num_fields;$j++){
			if(isset($row[$j])){
				if((in_array($type[$table][$j],$numtypes))&&(!empty($row[$j])))$return.=$row[$j];else $return.=$db->quote($row[$j]);
			}else{
				$return.='NULL';
			}
			if($j<($num_fields-1)){
				$return.=',';
			}
		}
		$count++;
		if($count<($result->rowCount())){
			$return.="),";
		}else{
			$return.=");";
		}
		if($compression){
			gzwrite($zp,$return);
		}else{
			fwrite($handle,$return);
		}
		$return="";
	}
	$return="\n\n-- ------------------------------------------------ \n\n";
	if($compression){
		gzwrite($zp,$return);
	}else{
		fwrite($handle,$return);
	}
	$return="";
}
if($compression){
	gzclose($zp);
}else{
	fclose($handle);
}
if(file_exists('../media/backup/'.$file)){
    chmod('../media/backup/'.$file,0777);
	$ti=time();
	$q=$db->prepare("UPDATE config SET backup_ti=:backup_ti WHERE id='1'");
	$q->execute(array(':backup_ti'=>$ti));?>
	window.top.window.$('#backup').append('<div id="l_<?php echo str_replace('.','',$file);?>" class="form-group"><label class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">&nbsp;</label><div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8"><a class="btn btn-default btn-block" href="media/backup/<?php echo$file;?>"><?php echo$file;?></a><div class="input-group-btn"><button class="btn btn-danger" onclick="removeMedia(\'<?php echo$file;?>\')">Delete</button></div></div></div>');
<?php }else{?>
	window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'There was an issue performing the backup!'}}).show();
<?php }?>
	window.top.window.$('#block').css("display","none");
/*]]>*/</script>
