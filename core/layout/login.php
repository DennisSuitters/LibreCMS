<!DOCTYPE HTML>
<html lang="en-AU">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>LibreCMS - Administration</title>
		<base href="<?php echo URL;?>">
<?php /*		<meta http-equiv="X-FRAME-OPTIONS" content="DENY"> */?>
		<link rel="alternate" media="handheld" href="<?php echo URL;?>">
		<link rel="alternate" hreflang="x-default" href="<?php echo URL;?>">
		<link rel="alternate" hreflang="en-AU" href="<?php echo URL;?>">
		<link rel="icon" href="<?php echo URL.'/'.$favicon;?>">
		<link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
		<meta name="viewport" content="width=400,initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="core/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="core/css/libreicons.css">
		<link rel="stylesheet" type="text/css" href="core/css/admin.css">
	</head>
	<body>
		<div class="container">
			<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
				<div class="login-panel panel panel-default animated fadeInDown">
					<div class="panel-body">
						<form role="form" method="post" action="<?php echo rtrim(URL,'logout').'admin';?>" accept-charset="UTF-8">
							<h4>Login</h4>
							<input type="hidden" name="act" value="login">
							<div class="form-group">
								<label for="username" class="control-label hidden-xs col-xs-12 col-sm-4 col-md-5 col-lg-4">Username</label>
									<div class="input-group col-xs-12 col-sm-8 col-md-7 col-lg-8">
									<div class="input-group-addon"><i class="libre libre-user"></i></div>
									<input type="text" id="username" class="form-control" name="username" value="" placeholder="Enter a Username..." autofocus>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="control-label hidden-xs col-xs-12 col-sm-4 col-md-5 col-lg-4">Password</label>
								<div class="input-group col-xs-12 col-sm-8 col-md-7 col-lg-8">
									<div class="input-group-addon"><i class="libre libre-key"></i></div>
									<input type="password" id="password" class="form-control" name="password" placeholder="Enter a Password..." autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label hidden-xs col-xs-12 col-lg-4 col-md-5 col-sm-4">&nbsp;</label>
								<div class="input-group col-xs-12 col-lg-8 col-md-7 col-sm-8">
									<button class="btn btn-success btn-large btn-block text-bold">Login</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<footer class="clearfix navbar navbar-default navbar-fixed-bottom">
			<span class="navbar-brand"><img src="core/images/librecms.png" alt="LibreCMS"></span>
			<ul class="nav navbar-nav navbar-right">
				<li><a target="_blank" href="http://www.gnu.org/licenses/gpl-3.0.txt"><small>GNUv3</small></a></li>
				<li><a target="_blank" href="https://github.com/StudioJunkyard/Libr8"><small>GitHub</small></a></li>
				<li><a href="<?php echo URL;?>"><small>Front</small></a></li>
			</ul>
		</footer>
	</body>
</html>
		