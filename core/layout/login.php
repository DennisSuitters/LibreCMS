<!--
 * Powered by LibreCMS (https://github.com/StudioJunkyard/LibreCMS)
 * Copyleft 2016 Studio Junkyard (http://studiojunkyard.com/)
 * Licensed under GPLv3 <http://www.gnu.org/licenses/>
-->
<!DOCTYPE HTML>
<html lang="en-AU" id="libreCMS">
    <head>
        <base href="<?php echo URL;?>">
        <title>Administration - LibreCMS</title>
        <meta name="generator" content="LibreCMS">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="alternate" media="handheld" href="<?php echo URL;?>">
        <link rel="alternate" hreflang="x-default" href="<?php echo URL;?>">
        <link rel="alternate" hreflang="en-AU" href="<?php echo URL;?>">
        <link rel="icon" href="<?php echo URL.'/'.$favicon;?>">
        <link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
        <meta name="viewport" content="width=400,initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="core/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="core/css/login.css">
        <link rel="stylesheet" type="text/css" href="core/css/libreicons.css">
    </head>
    <body>
        <div class="container">
            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="login-panel">
                    <div class="panel panel-default shadow-depth-1-half">
                        <div class="panel-body">
                            <form role="form" method="post" action="<?php if(strpos(URL,'logout')!=='false')echo rtrim(URL,'logout').$settings['system']['admin'];?>" accept-charset="UTF-8">
                                <h4 class="page-header col-xs-6">Login</h4>
                                <div class="clearfix"></div>
                                <input type="hidden" name="act" value="login">
                                <div class="form-group">
                                    <label for="username" class="control-label col-xs-12 col-sm-4 col-md-5 col-lg-4">Username</label>
                                    <div class="input-group col-xs-12 col-sm-8 col-md-7 col-lg-8">
                                        <input type="text" id="username" class="form-control" name="username" value="" placeholder="Enter Username" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label col-xs-12 col-sm-4 col-md-5 col-lg-4">Password</label>
                                    <div class="input-group col-xs-12 col-sm-8 col-md-7 col-lg-8">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="Enter Password" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group col-xs-12 col-sm-8 col-md-7 col-lg-8 pull-right">
                                        <button class="btn btn-success btn-large btn-block text-bold">Login</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel-footer text-right">
                            <img class="login img-responsive" src="core/images/librecms.png" alt="LibreCMS">
                            <a target="_blank" href="https://github.com/StudioJunkyard/LibreCMS" title="Visit LibreCMS Project on GitHub"><i class="libre libre-social-github"></i></a>
                            <a href="<?php echo URL;?>" title="Front End"><i class="libre libre-desktop"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
