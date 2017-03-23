<?php
require'db.php';
$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$nous=$db->prepare("SELECT COUNT(id) AS cnt FROM login WHERE lti>:lti AND rank!=1000");
$nous->execute(array(':lti'=>time()-300));
$nou=$nous->fetch(PDO::FETCH_ASSOC);
$nc=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE contentType!='review' AND status='unapproved'")->fetch(PDO::FETCH_ASSOC);
$nr=$db->query("SELECT COUNT(id) AS cnt FROM comments WHERE contentType='review' AND  status='unapproved'")->fetch(PDO::FETCH_ASSOC);
$nm=$db->query("SELECT COUNT(status) AS cnt FROM messages WHERE status='unread'")->fetch(PDO::FETCH_ASSOC);
$po=$db->query("SELECT COUNT(status) AS cnt FROM orders WHERE status='pending'")->fetch(PDO::FETCH_ASSOC);
$nb=$db->query("SELECT COUNT(status) AS cnt FROM content WHERE contentType='booking' AND status!='confirmed'")->fetch(PDO::FETCH_ASSOC);
$nu=$db->query("SELECT COUNT(id) AS cnt FROM login WHERE activate!='' AND active=0")->fetch(PDO::FETCH_ASSOC);
$nt=$db->query("SELECT COUNT(id) AS cnt FROM content WHERE contentType='testimonials' AND status!='published' AND active!=1")->fetch(PDO::FETCH_ASSOC);
$navStat=$nc['cnt']+$nr['cnt']+$nm['cnt']+$po['cnt']+$nb['cnt']+$nu['cnt']+$nt['cnt'];
print$navStat.','.$nou['cnt'].','.$nc['cnt'].','.$nr['cnt'].','.$nm['cnt'].','.$po['cnt'].','.$nb['cnt'].','.$nu['cnt'].','.$nt['cnt'];
