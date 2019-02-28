<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Reorder Media Items
 *
 * reordermedia.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Reorder Media Items
 * @package    core/reordermedia.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
require'db.php';
$i=0;
foreach($_POST['media_items'] as$id){
  $s=$db->prepare("UPDATE `".$prefix."media` SET ord=:ord WHERE id=:id");
  $s->execute([
    ':ord'=>$i,
    ':id'=>$id
  ]);
  $i++;
}
