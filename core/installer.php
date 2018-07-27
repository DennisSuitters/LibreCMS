<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo'<script>/*<![CDATA[*/'.PHP_EOL;
$error=0;
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):'';
if($_POST['emailtrap']=='none'){
	$dbprefix=isset($_POST['dbprefix'])?filter_input(INPUT_POST,'dbprefix',FILTER_SANITIZE_STRING):'';
	$dbtype=isset($_POST['dbtype'])?filter_input(INPUT_POST,'dbtype',FILTER_SANITIZE_STRING):'';
	$dbhost=isset($_POST['dbhost'])?filter_input(INPUT_POST,'dbhost',FILTER_SANITIZE_STRING):'';
	$dbport=isset($_POST['dbport'])?filter_input(INPUT_POST,'dbport',FILTER_SANITIZE_NUMBER_INT):'';
	$dbschema=isset($_POST['dbschema'])?filter_input(INPUT_POST,'dbschema',FILTER_SANITIZE_STRING):'';
	$dbusername=isset($_POST['dbusername'])?filter_input(INPUT_POST,'dbusername',FILTER_SANITIZE_STRING):'';
	$dbpassword=isset($_POST['dbpassword'])?filter_input(INPUT_POST,'dbpassword',FILTER_SANITIZE_STRING):'';
	$sysurl=isset($_POST['sysurl'])?filter_input(INPUT_POST,'sysurl',FILTER_SANITIZE_STRING):'';
	$sysadmin=isset($_POST['sysadmin'])?filter_input(INPUT_POST,'sysadmin',FILTER_SANITIZE_STRING):'';
	$aName=isset($_POST['aName'])?filter_input(INPUT_POST,'aName',FILTER_SANITIZE_STRING):'';
	$aEmail=isset($_POST['aEmail'])?filter_input(INPUT_POST,'aEmail',FILTER_SANITIZE_STRING):'';
	$aUsername=isset($_POST['aUsername'])?filter_input(INPUT_POST,'aUsername',FILTER_SANITIZE_STRING):'';
	$aPassword=isset($_POST['aPassword'])?filter_input(INPUT_POST,'aPassword',FILTER_SANITIZE_STRING):'';
	$theme=isset($_POST['systheme'])?filter_input(INPUT_POST,'systheme',FILTER_SANITIZE_STRING):'';
	if($act=='step1'){
		$txt='[database]'.PHP_EOL.
				 'prefix = '.$dbprefix.PHP_EOL.
				 'driver = '.$dbtype.PHP_EOL.
				 'host = '.$dbhost.PHP_EOL.
				 ($dbport==''?'port = ':'port = '.$dbport).PHP_EOL.
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
		fclose($oFH);
		echo'window.top.window.$(\'#step1\').addClass(\'hidden\');'.PHP_EOL;
		echo'window.top.window.$(\'#step2\').removeClass(\'hidden\');'.PHP_EOL;
	}
	if($act=='step2'){
		echo'window.top.window.$(\'#dbinfo\').html(\' \');'.PHP_EOL;
		$config=parse_ini_file('config.ini',true);
		$txt='[database]'.PHP_EOL.
				 'prefix = '.$config['database']['prefix'].PHP_EOL.
				 'driver = '.$config['database']['driver'].PHP_EOL.
				 'host = '.$config['database']['host'].PHP_EOL.
				 ($config['database']['port']==''?'port = ':'port = '.$config['database']['port']).PHP_EOL.
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
		$settings=parse_ini_file('config.ini',TRUE);
		$prefix=$settings['database']['prefix'];
		try{
		  $dns=((!empty($settings['database']['driver']))?($settings['database']['driver']):'').((!empty($settings['database']['host']))?(':host='.$settings['database']['host']):'').((!empty($settings['database']['port']))?(';port='.$settings['database']['port']):'').((!empty($settings['database']['schema']))?(';dbname='.$settings['database']['schema']):'');
		  $db=new PDO($dns,$settings['database']['username'],$settings['database']['password']);
		  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$errorHTML='<div class="alert alert-success">Database Connection Established, Imported Tables...</div>';
		}catch(PDOException $e){
		  $error=1;
			$errorHTML='<div class="alert alert-danger">Database Connection Error!<br><a href="" class="alert-link">Click here to restart the installation process and make corrections.</a></div>';
			echo'window.top.window.$(\'#block\').css({\'display\':\'none\'});'.PHP_EOL;
		}
		echo'window.top.window.$(\'#dbinfo\').html(\''.$errorHTML.'\');'.PHP_EOL;
		if($error==0){
			$prefix=$settings['database']['prefix'];
			$txt=file_get_contents('libre.sql');
			if($prefix!=''){
				$txt=str_replace(
					array(
						"CREATE TABLE `",
						"INSERT INTO `",
						"ALTER TABLE `"
					),
					array(
						"CREATE TABLE `".$prefix,
						"INSERT INTO `".$prefix,
						"ALTER TABLE `".$prefix
					),
					$txt
				);
			}
			$q=$db->exec($txt);
			$e=$db->errorInfo();
			if(!is_null($e[2])){
				echo'window.top.window.$(\'#dbinfo\').html(\'<div class="alert alert-success">There was a Database Error.</div>\');'.PHP_EOL;
				echo'window.top.window.$(\'#block\').css({\'display\':\'none\'});'.PHP_EOL;
			}
			$prefix=$settings['database']['prefix'];
			$q=$db->prepare("UPDATE `".$prefix."config` SET theme=:theme,maintenance=1 WHERE id=1");
			$q->execute(
				array(
					':theme'=>$theme
				)
			);
			$e=$db->errorInfo();
			if(!is_null($e[2])){
				echo'window.top.window.$(\'#dbinfo\').html(\'<div class="alert aler-danger">There was a Database issue.</div>\');'.PHP_EOL;
				echo'window.top.window.$(\'#block\').css({\'display\':\'none\'});'.PHP_EOL;
			}else{
				echo'window.top.window.$(\'#step2\').addClass(\'hidden\');'.PHP_EOL;
				echo'window.top.window.$(\'#step3\').removeClass(\'hidden\');'.PHP_EOL;
				echo'window.top.window.$(\'#block\').css({\'display\':\'none\'});'.PHP_EOL;
			}
		}
	}
	if($act=='step3'){
		echo'window.top.window.$(\'#dbinfo\').html(\' \');'.PHP_EOL;
		require'db.php';
		$prefix=$settings['database']['prefix'];
		$hash=password_hash($aPassword,PASSWORD_DEFAULT);
		$q=$db->prepare("INSERT INTO `".$prefix."login` (options,adminTheme,username,password,email,hash,name,language,ti,active,activate,rank) VALUES ('11111111','default',:username,:password,:email,:hash,:name,'en-AU',:ti,'1','','1000')");
		$q->execute(
			array(
				':username'=>$aUsername,
				':password'=>$hash,
				':email'=>$aEmail,
				':hash'=>md5($aEmail),
				':name'=>$aName,
				':ti'=>time()
			)
		);
		$e=$db->errorInfo();
		if(!is_null($e[2])){
			echo'window.top.window.$(\'#dbinfo\').html(\'<div class="alert alert-danger">There was a Database issue.</div>\');'.PHP_EOL;
		}else{
			echo'window.top.window.$(\'#step3\').addClass(\'hidden\');'.PHP_EOL;
			echo'window.top.window.$(\'#step4\').removeClass(\'hidden\');'.PHP_EOL;
		}
	}
}
echo'/*]]>*/</script>';
