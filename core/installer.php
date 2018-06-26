<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo'<script>/*<![CDATA[*/';
$error=0;
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
if($_POST['emailtrap']==''){
	$dbtype    =isset($_POST['dbtype'])?filter_input(INPUT_POST,'dbtype',FILTER_SANITIZE_STRING):'';
	$dbhost    =isset($_POST['dbhost'])?filter_input(INPUT_POST,'dbhost',FILTER_SANITIZE_STRING):'';
	$dbport    =isset($_POST['dbport'])?filter_input(INPUT_POST,'dbport',FILTER_SANITIZE_NUMBER_INT):'';
	$dbschema  =isset($_POST['dbschema'])?filter_input(INPUT_POST,'dbschema',FILTER_SANITIZE_STRING):'';
	$dbusername=isset($_POST['dbusername'])?filter_input(INPUT_POST,'dbusername',FILTER_SANITIZE_STRING):'';
	$dbpassword=isset($_POST['dbpassword'])?filter_input(INPUT_POST,'dbpassword',FILTER_SANITIZE_STRING):'';
	$sysurl    =isset($_POST['sysurl'])?filter_input(INPUT_POST,'sysurl',FILTER_SANITIZE_STRING):'';
	$sysadmin  =isset($_POST['sysadmin'])?filter_input(INPUT_POST,'sysadmin',FILTER_SANITIZE_STRING):'';
	$aName     =isset($_POST['aName'])?filter_input(INPUT_POST,'aName',FILTER_SANITIZE_STRING):'';
	$aEmail    =isset($_POST['aEmail'])?filter_input(INPUT_POST,'aEmail',FILTER_SANITIZE_STRING):'';
	$aUsername =isset($_POST['aUsername'])?filter_input(INPUT_POST,'aUsername',FILTER_SANITIZE_STRING):'';
	$aPassword =isset($_POST['aPassword'])?filter_input(INPUT_POST,'aPassword',FILTER_SANITIZE_STRING):'';
	$theme     =isset($_POST['systheme'])?filter_input(INPUT_POST,'systheme',FILTER_SANITIZE_STRING):'';
	if($act=='step1'){
		$txt='[database]'.PHP_EOL.
				 'driver = '.$dbtype.PHP_EOL.
				 'host = '.$dbhost.PHP_EOL.
				 'port = '.($dbport==''?'3306':$dbport).PHP_EOL.
				 'schema = '.$dbschema.PHP_EOL.
				 'username = '.$dbusername.PHP_EOL.
				 'password = '.$dbpassword.PHP_EOL.
				 '[system]'.PHP_EOL.
				 'version = '.time().PHP_EOL.
				 'url = '.PHP_EOL.
				 'admin = '.PHP_EOL;
		if(file_exists('config.ini'))unlink('config.ini');
		$oFH=fopen("config.ini",'w');
		fwrite($oFH,$txt);
		fclose($oFH);?>
		window.top.window.$('#step1').addClass('hidden');
		window.top.window.$('#step2').removeClass('hidden');
<?php	}

	if($act=='step2'){
		$config=parse_ini_file('config.ini',true);
		$txt='[database]'.PHP_EOL.
				 'driver = '.$config['database']['driver'].PHP_EOL.
				 'host = '.$config['database']['host'].PHP_EOL.
				 'port = '.$config['database']['port'].PHP_EOL.
				 'schema = '.$config['database']['schema'].PHP_EOL.
				 'username = '.$config['database']['username'].PHP_EOL.
				 'password = '.$config['database']['password'].PHP_EOL.
				 '[system]'.PHP_EOL.
				 'version = '.time().PHP_EOL.
				 'url = '.ltrim($sysurl).PHP_EOL.
				 'admin = '.($sysadmin==''?'admin':$sysadmin).PHP_EOL;
		if(file_exists('config.ini'))unlink('config.ini');
		$oFH=fopen("config.ini",'w');
		fwrite($oFH,$txt);
		fclose($oFH);
		include'db.php';
		if(!isset($db)){
			$error=1;?>
	window.top.window.$('#dbsuccess').html('<div class="alert alert-danger">Database Connection Error!</div>');
<?php }
		if($error==0){
			$sql=file_get_contents('libre.sql');
			$q=$db->exec($sql);
			$e=$db->errorInfo();
			if(is_null($e[2])){?>
	window.top.window.$('#dbsuccess').html('<div class="alert alert-success">Database Import Succeeded.</div>');
<?php	}
			include'db.php';
			$sql=$db->prepare("UPDATE config SET theme=:theme,maintenance=1 WHERE id=1");
			$sql->execute(
				array(
					':theme'=>$theme
				)
			);
			$e=$db->errorInfo();
			if(!is_null($e[2])){?>
	window.top.window.alert('<?php echo$e[2];?>');
<?php }else{?>
	window.top.window.$('#step2').addClass('hidden');
	window.top.window.$('#step3').removeClass('hidden');
<?php }
		}
	}

	if($act=='step3'){
		include'db.php';
		$hash=password_hash($aPassword,PASSWORD_DEFAULT);
		$sql=$db->prepare("INSERT INTO login (options,adminTheme,username,password,email,hash,name,language,ti,active,activate,rank) VALUES ('11111111','default',:username,:password,:email,:hash,:name,'en-AU',:ti,'1','','1000')");
		$sql->execute(
			array(
				':username'=>$aUsername,
				':password'=>$hash,
				':email'   =>$aEmail,
				':hash'    =>md5($aEmail),
				':name'    =>$aName,
				':ti'      =>time()
			)
		);
		$e=$db->errorInfo();
		if(!is_null($e[2])){?>
window.top.window.alert('<?php echo$e[2];?>');
<?php }else{?>
	window.top.window.$('#step3').addClass('hidden');
	window.top.window.$('#step4').removeClass('hidden');
<?php }
	}
}
echo'/*]]>*/</script>';
