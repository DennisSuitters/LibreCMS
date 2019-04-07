<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Backup Database
 *
 * backup.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Backup Database
 * @package    core/backup.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Fix Display Formatting.
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
echo'<script>';
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$config=$db->query("SELECT language FROM `".$prefix."config` WHERE id=1")->fetch(PDO::FETCH_ASSOC);
function localize($t){
	static $tr=NULL;
	global $config;
	if(is_null($tr)){
		if(file_exists('i18n'.DS.$config['language'].'.txt'))
			$lf='i18n'.DS.$config['language'].'.txt';
		else
			$lf='i18n'.DS.'en-AU.txt';
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
function svg($svg,$class=null,$size=null){
	echo'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
function svg2($svg,$class=null,$size=null){
	return'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
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
$numtypes=[
	'tinyint',
	'smallint',
	'mediumint',
	'int',
	'bigint',
	'float',
	'double',
	'decimal',
	'real'
];
if(empty($tables)){
	$pstm1=$db->query('SHOW TABLES');
	while($row=$pstm1->fetch(PDO::FETCH_NUM))
		$tables[]=$row[0];
}else
	$tables=is_array($tables)?$tables:explode(',',$tables);
foreach($tables as$table){
	$result=$db->query('SELECT * FROM '.$table);
	$num_fields=$result->columnCount();
	$num_rows=$result->rowCount();
	$return="";
	$return.="DROP TABLE IF EXISTS `".$table."`;";
	$pstm2=$db->query("SHOW CREATE TABLE ".$table);
	$row2=$pstm2->fetch(PDO::FETCH_NUM);
	$ifnotexists=str_replace('CREATE TABLE','CREATE TABLE IF NOT EXISTS',$row2[1]);
	$return.="\n\n".$ifnotexists.";\n\n";
	if($compression)
		gzwrite($zp,$return);
	else
		fwrite($handle,$return);
	$return="";
	if($num_rows){
		$return="INSERT INTO `".$table."` (";
		$pstm3=$db->query("SHOW COLUMNS FROM ".$table);
		$count=0;
		$type=array();
		while($rows=$pstm3->fetch(PDO::FETCH_NUM)){
			$type[$table][]=(stripos($rows[1],'(')?stristr($rows[1],'(',true):$rows[1]);
			$return.=$rows[0];
			$count++;
			if($count<($pstm3->rowCount()))
				$return.=", ";
		}
		$return.=") VALUES";
		if($compression)
			gzwrite($zp,$return);
		else
			fwrite($handle,$return);
		$return="";
	}
	$count=0;
	while($row=$result->fetch(PDO::FETCH_NUM)){
		$return="\n\t(";
		for($j=0;$j<$num_fields;$j++){
			$row[$j]=addslashes($row[$j]);
			$return.=isset($row[$j])?(in_array($type[$table][$j],$numtypes)?$row[$j]:"`".$row[$j]."`"):"``";
			if($j<($num_fields-1))
				$return.=",";
		}
		$count++;
		$return.=($count<($result->rowCount())?"),":");");
		if($compression)
			gzwrite($zp,$return);
		else
			fwrite($handle,$return);
		$return="";
	}
	$return="\n\n-- ------------------------------------------------ \n\n";
	if($compression)
		gzwrite($zp,$return);
	else
		fwrite($handle,$return);
	$return="";
}
if($compression)
	gzclose($zp);
else
	fclose($handle);
if(file_exists('..'.DS.'media'.DS.'backup'.DS.$file)){
  chmod('..'.DS.'media'.DS.'backup'.DS.$file,0777);
  $fileid=str_replace('.','',$file);
  $fileid=str_replace(DS,'',$fileid);
	$filename=basename($file);
  $ti=time();
  $q=$db->prepare("UPDATE `".$prefix."config` SET backup_ti=:backup_ti WHERE id='1'");
  $q->execute([':backup_ti'=>$ti]);?>
  window.top.window.$('#backups').append('<?php echo'<div id="l_'.$fileid.'" class="form-group row"><label class="col-form-label col-sm-2">&nbsp;</label><div class="input-group col-sm-10"><a class="btn btn-secondary col" href="media/backup/'.$file.'">',localize('Click to Download').' '.$file.'</a><div class="input-group-append"><button class="btn btn-secondary trash" onclick="removeBackup(\''.$fileid.'\',\''.$filename.'\')" role="button" aria-label="'.localize('aria_delete').'">'.svg2('libre-gui-trash').'</button></div></div></div>';?>');
  window.top.window.$('#alert_backup').addClass('d-none');
<?php }else{?>
	window.top.window.toastr["danger"]('<?php echo localize('alert_backup_danger_error');?>');
<?php }?>
  window.top.window.Pace.stop();
<?php
echo'</script>';
