<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Clear IP
 *
 * purge.php version 2.0.5
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Clear IP
 * @package    core/clearip.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.5
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
if(session_status()==PHP_SESSION_NONE)session_start();
require'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
$tbl=filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$s=$db->prepare("DELETE FROM ".$prefix."tracker WHERE ip=:id");
$s->execute([':id'=>$id]);
