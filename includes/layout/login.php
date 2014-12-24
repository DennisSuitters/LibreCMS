<!DOCTYPE HTML>
<html lang="en-AU">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title>LibreCMS - Administration</title>
		<base href="<?php echo URL;?>/" />
		<meta http-equiv="X-FRAME-OPTIONS" content="DENY">
		<link rel="alternate" media="handheld" href="<?php echo URL;?>/" />
		<link rel="alternate" hreflang="x-default" href="<?php echo URL;?>/" />
		<link rel="alternate" hreflang="en-AU" href="<?php echo URL;?>/" />
		<link rel="icon" href="<?php echo URL.'/'.$favicon;?>" />
		<link rel="apple-touch-icon" href="<?php echo URL.'/'.$favicon;?>" />
		<meta name="viewport" content="width=400,initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="includes/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="includes/css/admin.css" />
	</head>
	<body>
		<div class="col-sm-4"></div>
		<main class="panel panel-default col-sm-4 loginbox">
			<div class="panel-body">
				<h4>Login</h4>
				<form method="post" action="" accept-charset="UTF-8">
					<input type="hidden" name="act" value="login">
					<div class="form-group">
						<label for="username" class="control-label col-sm-4">Username</label>
						<div class="input-group col-sm-8">
							<input type="text" id="username" class="form-control" name="username" value="" placeholder="Enter a Username..." autofocus>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="control-label col-sm-4">Password</label>
						<div class="input-group col-sm-8">
							<input type="password" id="password" class="form-control" name="password" placeholder="Enter a Password..." autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">&nbsp;</label>
						<div class="input-group col-sm-8">
							<button class="btn btn-success btn-large btn-block">Login</button>
						</div>
					</div>
				</form>
			</div>
		</main>
		<div class="col-sm-4"></div>
		<footer class="clearfix navbar navbar-default navbar-fixed-bottom">
			<div class="logo"><img src="includes/images/librecms.png"></div>
			<ul class="nav navbar-nav pull-right">
				<li><a target="_blank" href="https://github.com/StudioJunkyard/Libr8/wiki"><small>Help</small></a></li>
				<li><a target="_blank" href="https://github.com/StudioJunkyard/Libr8"><small>GitHub</small></a></li>
				<li><a href="<?php echo URL;?>/"><small>Front</small></a></li>
			</ul>
		</footer>
	</body>
</html>
		