<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Add Blacklist Item
 *
 * add_blacklist.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Add Blacklist
 * @package    core/add_blacklist.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-type:text/xml');
require'db.php';
echo'<?xml version="1.0" encoding="UTF-8"?>';?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php $s=$db->query("SELECT contentType FROM `".$prefix."menu` WHERE active='1'");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
  <url>
    <loc><?php echo URL.$r['contentType'];?></loc>
    <changefreq>daily</changefreq>
    <priority>0.64</priority>
  </url>
<?php $s2=$db->prepare("SELECT contentType,title FROM `".$prefix."content` WHERE contentType=:contentType AND contentType!='testimonials' AND status='published' AND internal!='1' ORDER BY ti DESC");
  $s2->execute([':contentType'=>$r['contentType']]);
  while($r2=$s2->fetch(PDO::FETCH_ASSOC)){?>
  <url>
    <loc><?php echo URL.$r['contentType'].'/'.url_encode($r2['title']);?></loc>
    <changefreq>daily</changefreq>
    <priority>0.64</priority>
  </url>
<?php }
}?>
</urlset>
