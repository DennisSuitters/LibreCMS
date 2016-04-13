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
        <link rel="stylesheet" type="text/css" href="core/css/style.css">
        <link rel="stylesheet" type="text/css" href="core/css/libreicons.css">
    </head>
    <body>
        <div class="container">
            <div class="panel panel-default libre-cms_login center-block">
                <form class="panel-body" role="form" method="post" action="<?php if(strpos(URL,'logout')!=='false')echo rtrim(URL,'logout').$settings['system']['admin'];?>" accept-charset="UTF-8">
                    <input type="hidden" name="act" value="login">
                    <div class="panel-heading clearfix">
                        <img class="loginimg col-xs-8 pull-right" src="core/images/librecms.png" alt="LibreCMS Logo">
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-addon"><i class="libre libre-user"></i></div>
                        <input type="text" id="username" class="form-control" name="username" value="" placeholder="Username..." autofocus required>
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-addon"><i class="libre libre-lock"></i></div>
                        <input type="password" id="password" class="form-control" name="password" placeholder="Password..." autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger pull-left" type="reset"><i class="libre libre-eraser"></i>&nbsp;&nbsp;Reset</button>
                        <button class="btn btn-primary pull-right" type="submit"><i class="libre libre-sign-in"></i>&nbsp;&nbsp;Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
