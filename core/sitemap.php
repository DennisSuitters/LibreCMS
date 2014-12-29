<?php
header('Content-type:text/xml');
include'db.php';
$config=$db->query("SELECT url FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
echo'<?xml version="1.0" encoding="UTF-8"?>';?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
	<url>
		<loc><?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?></loc>
		<changefreq>daily</changefreq>
		<priority>1.00</priority>
	</url>
	<url>
		<loc><?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>index</loc>
		<changefreq>daily</changefreq>
		<priority>0.85</priority>
	</url>
	<url>
		<loc><?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>article</loc>
		<changefreq>daily</changefreq>
		<priority>0.85</priority>
	</url>
	<url>
		<loc><?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>bookings</loc>
		<changefreq>daily</changefreq>
		<priority>0.85</priority>
	</url>
	<url>
		<loc><?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>inventory</loc>
		<changefreq>daily</changefreq>
		<priority>0.85</priority>
	</url>
	<url>
		<loc><?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>services</loc>
		<changefreq>daily</changefreq>
		<priority>0.85</priority>
	</url>
	<url>
		<loc><?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>gallery</loc>
		<changefreq>daily</changefreq>
		<priority>0.85</priority>
	</url>
	<url>
		<loc><?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>contactus</loc>
		<changefreq>daily</changefreq>
		<priority>0.85</priority>
	</url>
<?php $s=$db->query("SELECT contentType,title FROM content WHERE status='published' AND internal!='1' ORDER BY ti DESC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
	<url>
		<loc><?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'].'/'.$r['contentType'].'/'.str_replace(' ','-',$r['title']);?></loc>
		<changefreq>daily</changefreq>
		<priority>0.85</priority>
	</url>
<?php }?>
</urlset>
