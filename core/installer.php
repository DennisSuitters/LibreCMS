<script>/*<![CDATA[*/
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
	window.top.window.$('#dberror').html('<div class="alert alert-danger">The Database Settings Entered are Incorrect.</div>');
<?php }
	if($error==0){?>
	window.top.window.$('#dberror').html('');
	window.top.window.$('#dbsuccess').html('<div class="alert alert-success">Database Connection Succeeded, writing settings to config file.</div>');
<?php
		$sql=file_get_contents('libre.sql');
		$q=$db->exec($sql);
		$e=$db->errorInfo();
		if(is_null($e[2])){?>
	window.top.window.$('#dbsuccess').append('<div class="alert alert-success">Database Imported Succeeded.</div>');
<?php		$sysurl=filter_input(INPUT_POST,'sysurl',FILTER_SANITIZE_STRING);
			$sysname=filter_input(INPUT_POST,'sysname',FILTER_SANITIZE_STRING);
			$syslang=filter_input(INPUT_POST,'syslang',FILTER_SANITIZE_STRING);
			$aName=filter_input(INPUT_POST,'aName',FILTER_SANITIZE_STRING);
			$aEmail=filter_input(INPUT_POST,'aEmail',FILTER_SANITIZE_STRING);
			$aUsername=filter_input(INPUT_POST,'aUsername',FILTER_SANITIZE_STRING);
			$aPassword=filter_input(INPUT_POST,'aPassword',FILTER_SANITIZE_STRING);
		}else{?>
	window.top.window.$('#dbsuccess').append('<div class="alert alert-danger">There was an Issue Importing the Database.<br><?php echo$e[2];?></div>');
<?php	}
	}
}?>
	window.top.window.$('#block').css({'display':'none'});
/*]]>*/</script>
