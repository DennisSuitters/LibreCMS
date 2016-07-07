<?php
header('Content-type:text/xml');
include'db.php';
echo'<?xml version="1.0" encoding="UTF-8"?>';?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php $s=$db->query("SELECT contentType FROM menu WHERE active='1'");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
    <url>
        <loc><?php echo URL.$r['contentType'];?></loc>
        <xhtml:link rel="alternate" hreflang="en-au" href="<?php echo URL.$r['contentType'];?>" />
        <xhtml:link rel="alternate" hreflang="x-default" href="<?php echo URL.$r['contentType'];?>" />
        <changefreq>daily</changefreq>
        <priority>0.64</priority>
    </url>
<?php $s2=$db->prepare("SELECT contentType,title FROM content WHERE contentType=:contentType AND status='published' AND internal!='1' ORDER BY ti DESC");
    $s2->execute(array(':contentType'=>$r['contentType']));
    while($r2=$s2->fetch(PDO::FETCH_ASSOC)){?>
    <url>
        <loc><?php echo URL.$r['contentType'].'/'.urlencode(str_replace(' ','-',$r2['title']));?></loc>
        <xhtml:link rel="alternate" hreflang="en-au" href="<?php echo URL.$r['contentType'].'/'.urlencode(str_replace(' ','-',$r2['title']));?>" />
        <xhtml:link rel="alternate" hreflang="x-default" href="<?php echo URL.$r['contentType'].'/'.urlencode(str_replace(' ','-',$r2['title']));?>" />
        <changefreq>daily</changefreq>
        <priority>0.64</priority>
    </url>
<?php }
}?>
</urlset>
