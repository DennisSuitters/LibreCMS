<?php
header('Content-Type:text/plain');
include'db.php';
$config=$db->query("SELECT url FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);?>
User-agent: *
Disallow: /cgi-bin/
Sitemap: http://<?php echo$_SERVER['HTTP_HOST'].$config['url'];?>sitemap.xml
