<?php
$error=0;
if($_POST['emailtrap']==''){
	$dbtype=filter_input(INPUT_POST,'dbtype',FILTER_SANITIZE_STRING);
	$dbhost=filter_input(INPUT_POST,'dbhost',FILTER_SANITIZE_STRING);
	$dbport=filter_input(INPUT_POST,'dbport',FILTER_SANITIZE_NUMBER_INT);
	$dbschema=filter_input(INPUT_POST,'dbschema',FILTER_SANITIZE_STRING);
	$dbusername=filter_input(INPUT_POST,'dbusername',FILTER_SANITIZE_STRING);
	$dbpassword=filter_input(INPUT_POST,'dbpassword',FILTER_SANITIZE_STRING);
	try{
   		$db=new PDO($dbtype.':host='.$dbhost.';port='.$dbport.';dbname='.$dbschema,$dbusername,$dbpassword);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e){
		$error=1;?>
<script>/*<![CDATA[*/
	window.top.window.$('#dberror').html('<div class="alert alert-danger">The Database Settings Entered are Incorrect.</div>');
/*]]>*/</script>
<?php }
	if($error==0){?>
<script>/*<![CDATA[*/
	window.top.window.$('#dberror').html('');
	window.top.window.$('#dbsuccess').html('<div class="alert alert-success">Database Connection Succeeded, writing settings to config file.</div>');
/*]]>*/</script>
<?php $sql=file_get_contents('libre.sql');
	$q=$db->exec($sql);
	$e=$db->errorInfo();
	if(is_null($e[2])){?>
<script>/*<![CDATA[*/
	window.top.window.$('#dbsuccess').append('<div class="alert alert-success">Database Imported Succeeded.</div>');
/*]]>*/</script>
<?php	$sysurl=filter_input(INPUT_POST,'sysurl',FILTER_SANITIZE_STRING);
		$sysadmin=filter_input(INPUT_POST,'sysadmin',FILTER_SANITIZE_STRING);
		$sysname=filter_input(INPUT_POST,'sysname',FILTER_SANITIZE_STRING);
		$txt='[database]'.PHP_EOL;
		$txt.='driver = '.$dbtype.PHP_EOL;
		$txt.='host = '.$dbhost.PHP_EOL;
		if($dbport=='')$txt.=';port = 3306'.PHP_EOL;
		else $txt.='port = '.$dbport.PHP_EOL;
		$txt.='schema = '.$dbschema.PHP_EOL;
		$txt.='username = '.$dbusername.PHP_EOL;
		$txt.='password = '.$dbpassword.PHP_EOL;
		$txt.='[system]'.PHP_EOL;
		$txt.='url = '.$sysurl.PHP_EOL;
		if($sysadmin=='')$txt.='admin'.PHP_EOL;
		else $txt.='admin = '.$sysadmin.PHP_EOL;
		$oFH=fopen("config.ini",'w');
		fwrite($oFH,$txt);
		fclose($oFH);
		$aName=filter_input(INPUT_POST,'aName',FILTER_SANITIZE_STRING);
		$aEmail=filter_input(INPUT_POST,'aEmail',FILTER_SANITIZE_STRING);
		$aUsername=filter_input(INPUT_POST,'aUsername',FILTER_SANITIZE_STRING);
		$aPassword=filter_input(INPUT_POST,'aPassword',FILTER_SANITIZE_STRING);
		$hash=password_hash($aPassword,PASSWORD_DEFAULT);
		$q=$db->prepare("UPDATE login SET name=:aName,email=:aEmail,username=:aUsername,password=:aPassword WHERE id='1'");
		$q->execute(array(':aName'=>$aName,':aEmail'=>$aEmail,':aUsername'=>$aUsername,':aPassword'=>$hash));
		$q=$db->prepare("UPDATE config SET maintenance='1',seoTitle=:seoTitle,seoRSSTitle=:seoRSSTitle WHERE id='1'");
		$q->execute(array(':seoTitle'=>$sysname,':seoRSSTitle'=>$sysname));
		$e=$db->errorInfo();
		if(is_null($e[2])){?>
<script>/*<![CDATA[*/
	window.top.window.$('#d0').html('<div class="alert alert-success text-center">Your new Website is ready to use!<br>NOTE: The Website is currently in Maintenance Mode!</div>');
/*]]>*/</script>
<?php	}else{?>
<script>/*<![CDATA[*/
	window.top.window.$('#d0').html('<div class="alert alert-danger">There was an Issue Setting the Settings!<br>You may need to contact your Server Administrator!<br><?php echo$e[2];?></div>');
/*]]>*/</script>
<?php	}
	}else{?>
<script>/*<![CDATA[*/
	window.top.window.$('#dbsuccess').append('<div class="alert alert-danger">There was an Issue Importing the Database.<br><?php echo$e[2];?></div>');
/*]]>*/</script>
<?php }
	}
}?>
<script>/*<![CDATA[*/
	window.top.window.$('#block').css({'display':'none'});
/*]]>*/</script>
