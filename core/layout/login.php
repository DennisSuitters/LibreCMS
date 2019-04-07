<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Login Page
 *
 * login.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Login
 * @package    core/layout/login.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Clean up Layout and Restyle CMS Logo.
 * @changes    v2.0.1 Fix Meta Tags.
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 * @changes    v2.0.2 Fix Cookie Setting for Theme Selection.
 * @changes    v2.0.2 Add Tooltips.
 */?>
<!DOCTYPE html>
<!--
     LibreCMS - Copyright (C) Diemen Design 2019
          the MIT Licensed Open Source Content Management System.
     
     Project Maintained at https://github.com/DiemenDesign/LibreCMS
-->
<html lang="<?php echo$config['language'];?>" id="libreCMS">
  <head>
    <meta charset="UTF-8">
    <meta name="generator" content="LibreCMS">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="application-name" content="LibreCMS">
    <meta name="description" content="<?php echo localize('Administration').($config['business']!=''?' for '.$config['business']:'');?> - LibreCMS">
    <title><?php echo localize('Administration').($config['business']!=''?' for '.$config['business']:'');?> - LibreCMS</title>
    <base href="<?php echo URL;?>">
    <link rel="manifest" href="<?php echo URL;?>core/manifestadmin.php">
    <meta name="theme-color" content="#000000">
    <link rel="alternate" media="handheld" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="<?php echo$config['language'];?>" href="<?php echo URL;?>">
    <link rel="icon" href="<?php echo URL.$favicon;?>">
    <link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
    <link id="themecss" rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'style-'.(isset($_COOKIE['adminbg'])?$_COOKIE['adminbg']:'dark').'.css';?>">
    <link id="theme2css" rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'style2-'.(isset($_COOKIE['adminbg'])?$_COOKIE['adminbg']:'dark').'.css';?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'libreicons-svg.css';?>">
  </head>
  <body class="app flex-row align-items-center">
    <main class="container">
      <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
      <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
      <div class="row justify-content-center">
        <div class="card login col-10 col-sm-4">
          <div class="card-body mt-2">
            <div class="d-flex justify-content-center">
              <div class="brand_logo_container">
                <img src="core/images/librecmslogin.png" class="brand_logo" alt="Logo">
              </div>
            </div>
            <div class="btn-group float-right">
              <button class="btn btn-ghost-dark" onclick="changeTheme();" data-tooltip="tooltip" title="Change Theme" role="button" aria-label="Change Theme"><?php svg('libre-gui-tint');?></button>
              <a class="btn btn-ghost-dark" href="<?php echo URL;?>" data-tooltip="tooltip" title="Back to Main Site" role="link" aria-label="Back to main site"><?php svg('libre-gui-back');?></a>
            </div>
            <form id="login" method="post" action="<?php echo(!empty($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'admin/');?>" accept-charset="UTF-8" role="form">
              <input type="hidden" name="act" value="login">
              <div class="input-group mb-3" data-tooltip="tooltip" title="Username">
                <div class="input-group-prepend">
                  <label for="username" class="input-group-text"><?php svg('libre-gui-user');?></label>
                </div>
                <input type="text" id="username" class="form-control" name="username" placeholder="<?php echo localize('Username');?>..." autofocus required aria-required="true" role="textbox" aria-label="Username">
              </div>
              <div class="input-group mb-4" data-tooltip="tooltip" title="Password">
                <div class="input-group-prepend">
                  <label for="password" class="input-group-text"><?php svg('libre-gui-lock');?></label>
                </div>
                <input type="password" id="password" class="form-control" name="password" placeholder="<?php echo localize('Password');?>..." autocomplete="off" required aria-required="true" role="textbox" aria-label="Password">
              </div>
              <div class="input-group mb-4">
                <button type="submit" class="btn btn-secondary btn-block" role="button" aria-label="Sign In"><?php echo svg2('libre-gui-sign-in').'&nbsp;&nbsp'.localize('Sign In');?></button>
              </div>
            </form>
            <div class="row">
              <div class="col-12 text-center">
                <button class="btn btn-link" onclick="$('#panel-rst').slideToggle();" data-tooltip="tooltip" title="Click to show Password Reset Field" role="button" aria-label="Reset Password"><?php echo localize('Reset Password');?></button>
              </div>
            </div>
            <form target="rstfeedback" id="panel-rst" style="display:none;" method="post" action="core/rst.php" accept-charset="UTF-8" role="form">
              <input type="hidden" name="emailtrap" value="none">
              <div class="row">
                <div class="col-12 text-center">
                  <div class="input-group mb-4" data-tooltip="tooltip" title="Enter Email Associcated With Account">
                    <input type="text" id="rst" class="form-control" name="rst" value="" autocomplete="off" placeholder="<?php echo localize('Enter ').' '.localize('Email');?>..." required aria-required="true" role="textbox" aria-label="Email">
                    <div class="input-group-append">
                      <button id="rstbusy" type="submit" class="btn btn-success" role="button" aria-label="Send Reset Password Email"><?php svg('libre-gui-email-send');?></button>
                    </div>
                  </div>
                </div>
              </div>
              <div id="rstfeedback" class="form-group"></div>
            </form>
          </div>
        </div>
      </div>
    </main>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'popper.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'bootstrap.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'libre.min.js';?>"></script>
    <script>
      $('[data-tooltip="tooltip"]').tooltip()
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
      function changeTheme(){
      	var link=$("#themecss[rel=stylesheet]")[0].href;
      	var css=link.substring(link.lastIndexOf('/')+1,link.length);
      	$('#themecss').attr('href','core/css/style-'+(css=='style-dark.css'?'light':'dark')+'.css');
      	$('#theme2css').attr('href','core/css/style2-'+(css=='style-dark.css'?'light':'dark')+'.css');
      	Cookies.remove('adminbg');
      	Cookies.set('adminbg',(css=='style-dark.css'?'light':'dark'),{expires:14});
      	return false;
      }
    </script>
  </body>
</html>
