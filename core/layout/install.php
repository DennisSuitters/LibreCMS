<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<!DOCTYPE HTML>
<html lang="en-AU">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>Install - LibreCMS</title>
		<link rel="icon" href="core/images/favicon.png">
		<link rel="apple-touch-icon" href="core/images/favicon.png">
		<meta name="viewport" content="width=400,initial-scale=1.0">
		<script src="core/js/jquery-2.1.3.min.js"></script>
		<script src="core/js/pace.min.js"></script>
		<link rel="stylesheet" type="text/css" href="core/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="core/css/libreicons.css">
		<link rel="stylesheet" type="text/css" href="core/css/style.css">
	</head>
	<body>
		<div class="container">
			<noscript>
				<div class="alert alert-danger">Javascript MUST BE ENABLED for LibreCMS to function correctly!</div>
			</noscript>
			<img class="installimg img-responsive" src="core/images/librecms.png" alt="LibreCMS">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Installation</h2>
				</div>
				<div id="d0" class="panel-body">
<?php
$error=0;
if(version_compare(phpversion(),'5.5.9','<'))echo'<div class="alert alert-warning">LibreCMS was built using PHP v5.5.9, your installed version is lower. While LibreCMS may operate on your system, some functionality may not work or be available. We recommend using PHP 7+ if available on you\'re services.</div>';
if(extension_loaded('pdo')){
	if (empty(PDO::getAvailableDrivers())){
		$error=1;
		echo'<div class="alert aler-danger">Great PDO is Installed and Active, but there are no Database Drivers Installed.</div>';
	}
}else{
	$error=1;
	echo'<div class="alert alert-danger">LibreCMS uses PDO for Database Interaction, please Install or Enable PDO.</div>';
}
if(file_exists('core/config.ini')&&!is_writable('core/config.ini')){
	$error=1;
	echo'<div class="alert alert-danger">"core/config.ini" Exists, but is not writeable. There is two ways to fix this, either make "core/config.ini" writable, or remove the file.</div>';
}
if(!isset($_SERVER['HTTP_MOD_REWRITE'])){
	$error=1;
	echo'<div class="alert alert-danger">"mod_rewrite" must be available and enabled for LibreCMS to function correctly.</div>';
}
if(!extension_loaded('gd')&&!function_exists('gd_info')){
	$error=1;
	echo'<div class="alert alert-danger">GD-Image is NOT Installed or Enabled.</div>';
}
echo(!function_exists('exif_read_data')?'<div class="alert alert-info">EXIF Functions are NOT enabled or installed. While not Mandatory, some features won\'t work.</div>':'');
echo($error==1?'<div class="alert alert-danger">Please fix the above Issue\'s outlined within the Red Sections, then Refresh the page to Check Again.</div>':'');
if($error==0){?>
					<form target="sp" method="post" action="core/installer.php" onsubmit="Pace.restart();">
						<input type="hidden" name="emailtrap" value="">
						<div class="well">
							<h4 class="page-header">Database Settings</h3>
							<div id="dberror"></div>
							<div class="form-group">
								<label for="dbtype" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Type</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<select id="dbtype" name="dbtype" class="form-control">
<?php	foreach(PDO::getAvailableDrivers() as$DRIVER)echo'<option value="'.$DRIVER.'">'.strtoupper($DRIVER).'</option>';?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="dbhost" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Host</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="dbhost" name="dbhost" type="text" class="form-control" value="localhost" placeholder="Enter a Host..." required>
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
									<input id="dbschema" name="dbschema" type="text" class="form-control" value="" placeholder="Enter Database Schema/Name..." required>
								</div>
							</div>
							<div class="form-group">
								<label for="dbusername" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Username</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="dbusername" name="dbusername" type="text" class="form-control" value="" placeholder="Enter Database Username..." required>
								</div>
							</div>
							<div class="form-group">
								<label for="dbpassword" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Password</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="dbpassword" name="dbpassword" type="password" class="form-control" value="" placeholder="Enter Database Password..." required>
								</div>
							</div>
							<div id="dbsuccess"></div>
						</div>
						<div class="well">
							<h4 class="page-header">System Settings</h3>
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
								<label for="sysadmin" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Administration Page Folder</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="sysadmin" name="sysadmin" type="text" class="form-control" value="" placeholder="Enter Administration Page Folder...">
									<span class="help-text">Leave blank to use default: "admin". e.g. http://www.sitename.com/admin/</span>
								</div>
							</div>
							<div class="form-group">
								<label for="systheme" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Theme</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<select id="systheme" class="form-control" name="systheme">
<?php foreach(new DirectoryIterator('layout') as$folder){
    if($folder->isDOT())continue;
    if($folder->isDir()){
      $theme=parse_ini_file('layout/'.$folder.'/theme.ini',true);?>
										<option value="<?php echo$folder;?>"<?php echo(stristr($folder,'default')?' selected':'');?>><?php echo$theme['title'];?></option>
<?php }
}?>
									</select>
								</div>
							</div>
						</div>
						<div class="well">
							<h4 class="page-header">Administrator Account Settings</h4>
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
			</div>
		</div>
		<iframe id="sp" name="sp" class="hidden"></iframe>
	</body>
</html>
