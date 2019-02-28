<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Robots Generator
 *
 * robots.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Robots Generator
 * @package    core/robots.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-Type:text/plain');?>
<?php echo'# As always, Asimov\'s Three Laws are in effect:'.
'# 1. A robot may not injure a human being or, through inaction, allow a human being to come to harm.'.
'# 2. A robot must obey orders given it by human beings except where such orders would conflict with the First Law.'.
'# 3. A robot must protect its own existence as long as such protection does not conflict with the First or Second Law.';?>

User-agent: *
Disallow: /harm/to/humans
Disallow: /ignoring/human/orders
Disallow: /harm/to/self
Disallow: /cgi-bin/
Disallow: <?php echo URL.'search';?>
Disallow: <?php echo URL.'admin';?>

User-Agent: Samsung NaviBot
Disallow: outdoor/areas

User-agent: T-800
User-agent: Skynet
User-agent: voltron
User-agent: Sentinels
User-agent: Ultron
Disallow: /

User-Agent: bender
Disallow: /my_shiny_metal_ass

User-Agent: Gort
Disallow: /earth

Sitemap: <?php echo URL.'sitemap.xml';?>
