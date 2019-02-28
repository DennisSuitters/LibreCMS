<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Cart Quantity
 *
 * cart_quantity.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Cart Quantity
 * @package    core/cart_quantity.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$cart='';
$dti=$ti-86400;
$q=$db->prepare("DELETE FROM `".$prefix."cart` WHERE ti<:ti");
$q->execute([':ti'=>$dti]);
$q=$db->prepare("SELECT SUM(quantity) as quantity FROM `".$prefix."cart` WHERE si=:si");
$q->execute([':si'=>SESSIONID]);
$r=$q->fetch(PDO::FETCH_ASSOC);
$cart=$theme['settings']['cart_menu'];
$cart=preg_replace('/<print cart=[\"\']?quantity[\"\']?>/',$r['quantity'],$cart);
