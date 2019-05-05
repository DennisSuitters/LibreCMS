<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Index, the start of it all
 *
 * xmlrpc.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Index - The Beginning
 * @package    index.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add ROOT_DIR Define to help Installer resolve from any folder location.
 * @changes    v2.0.3 Add Set UTF-8 Character Encoding.
 */
mb_internal_encoding("UTF-8");
mb_http_output( "UTF-8" );
ini_set('session.use_trans_sid',0);
ini_set('session.use_cookies',1);
ini_set('session.use_only_cookies',1);
define('MINIFY',0);
define('ROOT_DIR',realpath(__DIR__));
require'core/core.php';
