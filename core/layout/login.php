<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<!DOCTYPE html>
<html lang="en-AU" id="libreCMS">
  <head>
    <meta charset="UTF-8">
    <meta name="generator" content="LibreCMS">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Administration - LibreCMS</title>
    <base href="<?php echo URL;?>">
    <link rel="alternate" media="handheld" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="x" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="en-AU" href="<?php echo URL;?>">
    <link rel="icon" href="<?php echo URL.$favicon;?>">
    <link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
    <link id="themecss" rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'style-'.(isset($_COOKIE['adminbg'])?$_COOKIE['adminbg']:'dark').'.css';?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'libreicons-svg.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'pace.min.css';?>">
  </head>
  <body class="app flex-row align-items-center">
    <main class="container">
      <noscript><div class="alert alert-danger">Javascript MUST BE ENABLED for LibreCMS to function correctly!</div></noscript>
      <div class="alert alert-warning d-sm-block d-md-none">The Administration works better on larger displays, such as Laptop or Desktop screen sizes. On smaller screens some Elements may be truncated or cut off, making usage difficult.</div>
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <div class="btn-group float-right">
                  <button class="btn btn-ghost-dark" onclick="changeTheme();" aria-label="Change Theme" role="button"><?php svg('libre-gui-tint');?></button>
                  <a class="btn btn-ghost-dark" href="<?php echo URL;?>" aria-label="Back to main site" role="link"><?php svg('libre-gui-back');?></a>
                </div>
                <h1>Login</h1>
                <form id="login" role="form" method="post" action="<?php echo(!empty($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'admin/');?>" accept-charset="UTF-8">
                  <input type="hidden" name="act" value="login">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <?php svg('libre-gui-user');?>
                      </span>
                    </div>
                    <input type="text" id="username" class="form-control" name="username" placeholder="Username..." autofocus required aria-required="true" aria-label="Username" role="textbox">
                  </div>
                  <div class="input-group mb-4">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <?php svg('libre-gui-lock');?>
                      </span>
                    </div>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Password..." autocomplete="off" required aria-required="true" aria-label="Password" role="textbox">
                  </div>
                  <div class="input-group mb-4">
                    <button type="submit" class="btn btn-success btn-block" aria-label="Sign In" role="button"><?php svg('libre-gui-sign-in');?>&nbsp;&nbsp;Sign In</button>
                  </div>
                </form>
                <div class="row">
                  <div class="col-12 text-center">
                    <a href="javascript:return false;" onclick="$('#panel-rst').toggleClass('d-none');" aria-label="Reset Password" role="button">Reset Password</a>
                  </div>
                </div>
                <form target="rstfeedback" id="panel-rst" class="d-none" role="form" method="post" action="core/rst.php" accept-charset="UTF-8">
                  <input type="hidden" name="emailtrap" value="none">
                  <div class="row">
                    <div class="col-12 text-center">
                      <div class="input-group mb-4">
                        <input type="text" id="rst" class="form-control" name="rst" value="" autocomplete="off" placeholder="Enter Account Email..." required aria-required="true" aria-label="Email" role="textbox">
                        <div class="input-group-append">
                          <button id="rstbusy" type="submit" class="btn btn-primary" aria-label="Send Reset Password Email"><?php svg('libre-gui-email-send');?></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="rstfeedback" class="form-group"></div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'popper.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'bootstrap.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'js.cookie.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'js.js';?>"></script>
    <script>/*<![CDATA[*/
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
    /*]]>*/</script>
  </body>
</html>
