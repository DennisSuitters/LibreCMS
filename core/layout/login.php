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
		<link rel="stylesheet" type="text/css" href="core/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="core/css/admin.css" />
	</head>
	<body class="login">
		<div class="container">
			<div class="col-lg-4 col-md-4 col-sm-3"></div>
			<main class="panel panel-default col-lg-4 col-md-5 col-sm-6 loginbox">
				<div class="panel-body">
					<form method="post" action="" accept-charset="UTF-8">
						<input type="hidden" name="act" value="login">
						<div class="form-group">
							<label for="username" class="control-label col-lg-4 col-md-4 col-sm-4<?php if(isset($login)&&$login==false){echo' text-danger';}?>">Username</label>
							<div class="input-group col-lg-8 col-md-8 col-sm-8<?php if(isset($login)&&$login==false){echo' has-error';}?>">
								<input type="text" id="username" class="form-control" name="username" value="" placeholder="Enter a Username..." autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="control-label col-lg-4 col-md-4 col-sm-4<?php if(isset($login)&&$login==false){echo' text-danger';}?>">Password</label>
							<div class="input-group col-lg-8 col-md-8 col-sm-8<?php if(isset($login)&&$login==false){echo' has-error';}?>">
								<input type="password" id="password" class="form-control" name="password" placeholder="Enter a Password..." autocomplete="off">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4 col-md-4 col-sm-4">&nbsp;</label>
							<div class="input-group col-lg-8 col-md-8 col-sm-8">
								<button class="btn btn-<?php if(isset($login)&&$login==false){echo'danger';}else{echo'success';}?> btn-large btn-block">Login</button>
							</div>
						</div>
					</form>
				</div>
			</main>
			<div class="col-lg-4 col-md-4 col-sm-3"></div>
		</div>
		<footer class="clearfix navbar navbar-default navbar-fixed-bottom login">
			<div class="logo"><img src="core/images/librecms.png" alt="LibreCMS"></div>
			<ul class="nav navbar-nav pull-right">
				<li><a target="_blank" href="https://github.com/StudioJunkyard/Libr8/wiki"><small>Help</small></a></li>
				<li><a target="_blank" href="https://github.com/StudioJunkyard/Libr8"><small>GitHub</small></a></li>
				<li><a href="<?php echo URL;?>/"><small>Front</small></a></li>
			</ul>
		</footer>
	</body>
</html>
		