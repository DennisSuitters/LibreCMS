<?php
	$error=0;
?>
<!DOCTYPE HTML>
<html lang="en-AU">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>LibreCMS - Install</title>
<?php /*		<meta http-equiv="X-FRAME-OPTIONS" content="DENY"> */?>
		<link rel="icon" href="core/images/favicon.png">
		<link rel="apple-touch-icon" href="core/images/favicon.png">
		<meta name="viewport" content="width=400,initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="core/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="core/css/install.css">
	</head>
	<body>
		<div class="container install-panel">
			<img class="login img-responsive" src="core/images/librecms.png" alt="LibreCMS">
			<div class="panel panel-default">
				<div class="panel-body visible-xs">
					<div class="alert alert-danger">
						It is best to install LibreCMS using a Desktop System...
					</div>
				</div>
				<div class="panel-body hidden-xs">
					<h2 class="page-header">Installation</h2>
					<div class="well">
						<h3 class="page-header col-sm-6">System Checks</h3>
						<div class="clearfix"></div>
<?php
if(version_compare(phpversion(),'5.5.9','>')){
	echo'<div class="alert alert-success">LibreCMS was built using PHPv5.5.9, your installed version is higher.</div>';
}else{
	echo'<div class="alert alert-warning">LibreCMS was built using PHPv5.5.9, your installed version is lower. While LibreCMS may operate on your system, some functionality may not work or be available.</div>';
}
if(extension_loaded('pdo')){
	if(empty(PDO::getAvailableDrivers())){
		$error=1;
		echo'<div class="alert aler-danger">Great PDO is Installed and Active, but there are no Database Drivers Installed.</div>';
	}else{
		echo'<div class="alert alert-success">Great PDO is Installed and Active.</div>';
	}
}else{
	$error=1;
	echo'<div class="alert alert-danger">LibreCMS uses PDO for Database Interaction, please Install or Enable PDO.</div>';
}
if(file_exists('core/config.ini')&&!is_writable('core/config.ini')){
	$error=1;
	echo'<div class="alert alert-danger">"core/config.ini" Exists, but is not writeable. There is two ways to fix this, either make "core/config.ini" writable, or remove the file.</div>';
}elseif(file_exists('core/config.ini')&&is_writable('core/config.ini')){
	echo'<div class="alert alert-success">Great! "core/config.ini" Exists, and is writeable. Values entered below, will overwrite any manually entered settings.</div>';
}else{
	echo'<div class="alert alet-warning">"core/config.ini" does NOT exists, that\'s ok, we\'ll create it.</div>';
}
if(!isset($_SERVER['HTTP_MOD_REWRITE'])){
	$error=1;
	echo'<div class="alert alert-danger">"mod_rewrite" must be available and enabled for LibreCMS to function correctly.</div>';
}else{
	echo'<div class="alert alert-success">Great "mod_rewrite" is installed, and enabled.</div>';
}
if(extension_loaded('gd')&&function_exists('gd_info')){
	echo'<div class="alert alert-success">Great! GD-Image is Installed and Enabled.</div>';
}else{
	$error=1;
	echo'<div class="alert alert-danger">GD-Image is NOT Installed or Enabled.</div>';
}
if(!function_exists('exif_read_data')){
	echo'<div class="alert alert-info">EXIF Functions are NOT enabled or installed. While not Mandatory, some features won\'t work.</div>';
}else{
	echo'<div class="alert alert-success">Great EXIF Functions are enabled.</div>';
}
if($error==0){
	echo'<div class="alert alert-success">Checks have been satisfied, you can continue to fill in the rest of Settings Details below.</div>';
}else{
	echo'<div class="alert alert-danger">Please fix the above Issue\'s outlined within the Red Sections, then Refresh the page to Check Again.</div>';
}?>
					</div>
<?php if($error==0){?>
					<form target="sp" method="post" action="core/installer.php" onsubmit="$('#block').css({'display':'block'});">
						<input type="hidden" name="emailtrap" value="">
						<div class="well">
							<h3 class="page-header col-sm-6">Database Settings</h3>
							<div class="clearfix"></div>
							<div id="dberror"></div>
							<div class="form-group">
								<label for="dbtype" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Type</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<select id="dbtype" name="dbtype" class="form-control">
<?php	foreach(PDO::getAvailableDrivers()as$DRIVER){
			echo'<option value="'.$DRIVER.'">'.strtoupper($DRIVER).'</option>';
		}?>

									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="dbhost" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Host</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="dbhost" name="dbhost" type="text" class="form-control" value="localhost" placeholder="Enter a Host...">
								</div>
							</div>
							<div class="form-group">
								<label for="dbport" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Port</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="dbport" name="dbport" type="text" class="form-control" value="" placeholder="Enter Port Number, or leave blank for default...">
								</div>
							</div>
							<div class="form-group">
								<label for="dbschema" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Schema</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="dbschema" name="dbschema" type="text" class="form-control" value="" placeholder="Enter Database Schema/Name...">
								</div>
							</div>
							<div class="form-group">
								<label for="dbusername" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Username</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="dbusername" name="dbusername" type="text" class="form-control" value="" placeholder="Enter Database Username...">
								</div>
							</div>
							<div class="form-group">
								<label for="dbpassword" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Password</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="dbpassword" name="dbpassword" type="password" class="form-control" value="" placeholder="Enter Database Password...">
								</div>
							</div>
							<div id="dbsuccess"></div>
						</div>
						<div class="well">
							<h3 class="page-header col-sm-6">System Settings</h3>
							<div class="clearfix"></div>
							<div class="form-group">
								<label for="sysurl" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Site URL</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="sysurl" name="sysurl" type="text" class="form-control" value="" placeholder="Enter URL Folder if Site isn't in Domain Root...">
								</div>
							</div>
							<div class="form-group">
								<label for="sysname" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Site Name</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="sysname" name="sysname" type="text" class="form-control" value="" placeholder="Enter Site Name...">
								</div>
							</div>
							<div class="form-group">
								<label for="syslang" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Site Language</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<select id="sysland" name="sysland" class="form-control">
										<option value="en-au">English (Australian)</option>
									</select>
								</div>
							</div>
						</div>
						<div class="well">
							<h3 class="page-header col-sm-6">Administrator Account Settings</h3>
							<div class="clearfix"></div>
							<div class="form-group">
								<label for="aName" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Name</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="aName" name="aName" type="text" class="form-control" value="" placeholder="Enter a Name..." required>
								</div>
							</div>
							<div class="form-group">
								<label for="aEmail" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Email</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="aEmail" name="aEmail" type="text" class="form-control" value="" placeholder="Enter an Email..." required>
								</div>
							</div>
							<div class="form-group">
								<label for="aUsername" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Username</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="aUsername" name="aUsername" type="text" class="form-control" value="" placeholder="Enter a Username..." required>
								</div>
							</div>
							<div class="form-group">
								<label for="aPassword" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Password</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="aPassword" name="aPassword" type="password" class="form-control" value="" placeholder="Enter a Password..." required>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-success btn-block">Install</button>
					</form>
<?php }?>
				</div>
				<div class="panel-footer text-right">
					<a target="_blank" href="https://github.com/StudioJunkyard/LibreCMS">GitHub</a>
				</div>
			</div>
		</div>
		<script src="core/js/jquery-2.1.3.min.js"></script>
		<iframe id="sp" name="sp" class="hidden"></iframe>
		<div id="block"><i class="libre libre-spinner-1 libre-5x libre-spin"></i></div>
	</body>
</html>
