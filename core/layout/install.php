<?php  $error=0;?>
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
		<link rel="stylesheet" type="text/css" href="core/css/libreicons.css">
		<link rel="stylesheet" type="text/css" href="core/css/admin.css">
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
<?php if(file_exists('core/config.ini')){
	$error=0;
	echo'<div class="alert alert-danger">"core/config.ini" Exists, but is not writeable.</div>';
}
/*
if(!function_exists('mod_rewrite')){
	$error=1;?>
	echo'<div class="alert alert-danger">"mod-rewrite" must be available and enabled for LibreCMS to function correctly.</div>';'
}
*/
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
					<form target="sp" method="post" action="core/installer.php">
						<div class="well">
							<h3 class="page-header col-sm-6">Database Settings</h3>
							<div class="clearfix"></div>
							<div class="form-group">
								<label for="dbtype" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Database Type</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<select id="dbtype" name="dbtype" class="form-control">
										<option value="mysql">MySQL</option>
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
							<h3 class="page-header col-sm-6">Administration Settings</h3>
							<div class="clearfix"></div>
							<div class="form-group">
								<label for="aName" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Name</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="aName" name="aName" type="text" class="form-control" value="" placeholder="Enter a Name...">
								</div>
							</div>
							<div class="form-group">
								<label for="aEmail" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Email</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="aEmail" name="aEmail" type="text" class="form-control" value="" placeholder="Enter an Email...">
								</div>
							</div>
							<div class="form-group">
								<label for="aUsername" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Username</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="aUsername" name="aUsername" type="text" class="form-control" value="" placeholder="Enter a Username...">
								</div>
							</div>
							<div class="form-group">
								<label for="aPassword" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Password</label>
								<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input id="aPassword" name="aPassword" type="password" class="form-control" value="" placeholder="Enter a Password...">
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-success btn-block" disabled>Install</button>
					</form>
<?php }?>
				</div>
				<div class="panel-footer text-right">
					<a target="_blank" href="https://github.com/StudioJunkyard/LibreCMS">GitHub</a>
				</div>
			</div>
		</div>
	</body>
</html>
		