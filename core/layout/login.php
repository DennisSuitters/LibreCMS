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
        <link rel="stylesheet" type="text/css" href="core/css/libreicons-svg.css">
        <script src="core/js/jquery-2.1.3.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="panel panel-default login center-block">
                <div class="panel-body">
                    <form role="form" method="post" action="<?php if(strpos(URL,'logout')!=='false')echo rtrim(URL,'logout').$settings['system']['admin'];?>" accept-charset="UTF-8">
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
                        <div class="form-group clearfix">
                            <button class="btn lgn btn-danger pull-left" type="reset"><i class="libre libre-eraser"></i>&nbsp;&nbsp;Reset</button>
                            <button class="btn lgn btn-primary pull-right" type="submit"><i class="libre libre-sign-in"></i>&nbsp;&nbsp;Sign in</button>
                        </div>
                    </form>
                    <div class="form-group text-center">
                        <a href="javascript:return false;" onclick="$('#panel-rst').toggleClass('hidden');">Reset Password</a>
                    </div>
                    <form target="rstfeedback" id="panel-rst" class="hidden" role="form" method="post" action="core/rst.php" accept-charset="UTF-8">
                        <input type="hidden" name="emailtrap" value="">
                        <div class="form-group">
                            <div class="input-group col-xs-12">
                                <input type="text" id="rst" class="form-control" name="rst" value="" autocomplete="off" placeholder="Enter Account Email..." required>
                                <div class="input-group-btn">
                                    <button id="rstbusy" type="submit" class="btn btn-primary pull-right"><i class="libre libre-envelope"></i></button>
                                </div>
                            </div>
                        </div>
                        <div id="rstfeedback" class="form-group"></div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $('#panel-rst').submit(function(){
                $('#rstbusy').html('<i class="libre libre-spinner-1"></i>');
                $.ajax({
                    data:$(this).serialize(),
                    type:$(this).attr('method'),
                    url:$(this).attr('action'),
                    success:function(response){
                        $('#rstfeedback').html(response);
                        $('#rstbusy').html('<i class="libre libre-envelope"></i>');
                    }
                });
                return false;
            });
        </script>
    </body>
</html>
