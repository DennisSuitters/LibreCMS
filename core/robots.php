<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
header('Content-Type:text/plain');?>
<?php echo'# As always, Asimov\'s Three Laws are in effect:'.
'# 1. A robot may not injure a human being or, through inaction, allow a human being to come to harm.'.
'# 2. A robot must obey orders given it by human beings except where such orders would conflict with the First Law.'.
'# 3. A robot must protect its own existence as long as such protection does not conflict with the First or Second Law.';?>

User-agent: *
Disallow: /harming/humans
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
