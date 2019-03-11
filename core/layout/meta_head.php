<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Meta-Head contains <head> and Stylsheet logic and JS Links
 *
 * meta_head.php version 2.0.1
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
 * @version    2.0.1
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Fix wrong Meta-Tags and Add Manifest link.
 */?>
<!DOCTYPE HTML>
<!--
     LibreCMS - Copyright (C) Diemen Design 2019
          the MIT Licensed Open Source Content Management System.
     
     Project Maintained at https://github.com/DiemenDesign/LibreCMS
-->
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
    <link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>"><?php
    echo$view=='media'||$view=='pages'||$args[0]=='edit'||$args[0]=='security'||($view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings')?'<link rel="stylesheet" type="text/css" href="'.URL.'core'.DS.'css'.DS.'jquery-ui.min.css">':'';
    echo$view=='media'||$args[0]=='edit'||$args[0]=='security'||($view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings')?'<link rel="stylesheet" type="text/css" href="'.URL.'core'.DS.'elfinder'.DS.'css'.DS.'elfinder.min.css">':'';
    echo$view=='bookings'||$args[0]=='scheduler'?'<link rel="stylesheet" type="text/css" href="'.URL.'core'.DS.'css'.DS.'fullcalendar.min.css">':'';?>
    <link id="themecss" rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'style-'.(isset($_COOKIE['adminbg'])?$_COOKIE['adminbg']:'dark').'.css';?>">
    <Link rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'libreicons-svg.css';?>"><?php
    echo$args[0]=='settings'||$args[0]=='security'?'<link rel="stylesheet" type="text/css" href="'.URL.'core'.DS.'css'.DS.'codemirror.css">':'';
    echo$view=='bookings'||$args[0]=='edit'?'<Link rel="stylesheet" type="text/css" href="'.URL.'core'.DS.'css'.DS.'daterangepicker.css">':'';?>
    <Link id="theme2css" rel="stylesheet" type="text/css" href="<?php echo URL.'core'.DS.'css'.DS.'style2-'.(isset($_COOKIE['adminbg'])?$_COOKIE['adminbg']:'dark').'.css';?>">
    <script src="<?php echo URL.'core'.DS.'js'.DS.'jquery.min.js';?>"></script><?php 
    echo$view=='media'||$view=='pages'||$args[0]=='edit'||$args[0]=='security'||($view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings')?'<script src="'.URL.'core'.DS.'js'.DS.'jquery-ui.min.js"></script>':'';?>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'bootstrap.min.js';?>"></script><?php
    echo$args[0]=='edit'||($view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings')?'<script src="'.URL.'core'.DS.'js'.DS.'summernote-lite.js"></script>':'';
    echo$args[0]=='edit'||($view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings')?'<script src="'.URL.'core'.DS.'js'.DS.'plugin'.DS.'summernote'.DS.'summernote-save-button.js"></script>':'';
    echo$view=='media'||$args[0]=='edit'||$args[0]=='security'||($view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings')?'<script src="'.URL.'core'.DS.'js'.DS.'plugin'.DS.'elfinder'.DS.'elfinder.js"></script>':'';
    echo$view=='media'||$args[0]=='edit'||$args[0]=='security'||($view=='accounts'||$view=='orders'||$view=='bookings'||$view=='newsletters'||$view=='messages'&&$args[0]=='settings')?'<script src="'.URL.'core'.DS.'elfinder'.DS.'js'.DS.'elfinder.min.js"></script>':'';?>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'libre.min.js';?>"></script><?php
    echo$view=='bookings'||$args[0]=='scheduler'||$args[0]=='edit'?'<script src="'.URL.'core'.DS.'js'.DS.'moment.min.js"></script>':'';
    echo$view=='bookings'||$args[0]=='scheduler'?'<script src="'.URL.'core'.DS.'js'.DS.'fullcalendar.min.js"></script>':'';
    echo$view=='bookings'||$args[0]=='edit'?'<script src="'.URL.'core'.DS.'js'.DS.'daterangepicker.js"></script>':'';
    echo$view=='pages'&&$args[0]=='settings'||$args[0]=='security'?'<script src="'.URL.'core'.DS.'js'.DS.'codemirror.js"></script>':'';?>
    <script src="<?php echo URL.'core'.DS.'js'.DS.'js.js';?>"></script>
  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
