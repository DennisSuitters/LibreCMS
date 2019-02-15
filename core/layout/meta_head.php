<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<!DOCTYPE HTML>
<html lang="en-AU" id="libreCMS">
  <head>
    <meta charset="UTF-8">
    <meta name="generator" content="LibreCMS">
    <meta name="robots" content="noindex,nofollow">
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
    <link rel="stylesheet" type="text/css" href="core/css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'elfinder'.DS.'css'.DS.'elfinder.min.css';?>">
    <link rel="stylesheet" type="text/css" href="core/css/fullcalendar.min.css">
    <link id="themecss" rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'style-'.(isset($_COOKIE['adminbg'])?$_COOKIE['adminbg']:'dark').'.css';?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'libreicons-svg.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'codemirror.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'base16-dark.css';?>">
    <link rel="stylesheet" type="text/css"  href="<?php echo URL.'core'.DS.'css'.DS.'pace.min.css';?>">
    <link rel="stylesheet" type="text/css"  href="<?php echo URL.'core'.DS.'css'.DS.'toastr.min.css';?>">
    <Link rel="stylesheet" type="text/css"  href="<?php echo URL.'core'.DS.'css'.DS.'ladda.min.css';?>">
    <Link rel="stylesheet" type="text/css"  href="<?php echo URL.'core'.DS.'css'.DS.'daterangepicker.css';?>">
    <Link id="theme2css" rel="stylesheet" type="text/css"  href="<?php echo URL.'core'.DS.'css'.DS.'style2-'.(isset($_COOKIE['adminbg'])?$_COOKIE['adminbg']:'dark').'.css';?>">
    <Link rel="stylesheet" type="text/css"  href="<?php echo URL.'core'.DS.'css'.DS.'summernote-lite-flatly.css';?>">
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery-ui.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'popper.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'bootstrap.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'summernote-lite.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'plugin'.DS.'summernote'.DS.'summernote-save-button.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'plugin'.DS.'elfinder'.DS.'elfinder.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'elfinder'.DS.'js'.DS.'elfinder.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'js.cookie.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'pace.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'perfect-scrollbar.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'coreui.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery.countTo.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'ion.sound.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'toastr.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'spin.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'ladda.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'sortable.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'moment.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'daterangepicker.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'js.js';?>"></script>
  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
