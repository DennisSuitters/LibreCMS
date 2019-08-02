<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Meta-Head contains <head> and Stylsheet logic and JS Links
 *
 * meta_head.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Meta-Head
 * @package    core/layout/meta_head.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Fix wrong Meta-Tags and Add Manifest link.
 * @changes    v2.0.2 Add i18n.
 */?>
<!DOCTYPE HTML>
<!--
     LibreCMS - Copyright (C) Diemen Design 2019
          the MIT Licensed Open Source Content Management System.
     
     Project Maintained at https://github.com/DiemenDesign/LibreCMS
-->
<html lang="<?php echo$config['language'];?>" id="libreCMS">
  <head>
    <meta charset="UTF-8">
    <meta name="generator" content="LibreCMS">
    <meta name="robots" content="noindex,nofollow">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo localize('Administration').($config['business']!=''?' for '.$config['business']:'');?> - LibreCMS</title>
    <base href="<?php echo URL;?>">
    <link rel="alternate" media="handheld" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="<?php echo$config['language'];?>" href="<?php echo URL;?>">
    <link rel="icon" href="<?php echo URL.$favicon;?>">
    <link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'jquery-ui.min.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'elfinder'.DS.'css'.DS.'elfinder.min.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'fullcalendar.min.css';?>">
    <link id="themecss" rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'style-'.(isset($_COOKIE['adminbg'])?$_COOKIE['adminbg']:'dark').'.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'simpleLightbox.min.css';?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'libreicons-svg.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'codemirror.css';?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'daterangepicker.css';?>">
    <Link id="theme2css" rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'style2-'.(isset($_COOKIE['adminbg'])?$_COOKIE['adminbg']:'dark').'.css';?>">
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery-ui.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'bootstrap.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'summernote-lite.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'plugin'.DS.'summernote'.DS.'summernote-save-button.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'codemirror.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'plugin'.DS.'elfinder'.DS.'elfinder.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'elfinder'.DS.'js'.DS.'elfinder.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'libre.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'simpleLightbox.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'moment.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'fullcalendar.min.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'daterangepicker.js';?>"></script>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'js.js';?>"></script>
  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
