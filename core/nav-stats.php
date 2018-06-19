<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
$getcfg = true;
require 'db.php';
$config = $db -> query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$nous = $db -> prepare("SELECT COUNT(id) AS cnt FROM login WHERE lti>:lti AND rank!=1000");
$nous -> execute(array(':lti' => time() - 300));
$nou = $nous -> fetch(PDO::FETCH_ASSOC);
$nc = $db -> query("SELECT COUNT(status) AS cnt FROM comments WHERE contentType!='review' AND status='unapproved'") -> fetch(PDO::FETCH_ASSOC);
$nr = $db -> query("SELECT COUNT(id) AS cnt FROM comments WHERE contentType='review' AND  status='unapproved'") -> fetch(PDO::FETCH_ASSOC);
$nm = $db -> query("SELECT COUNT(status) AS cnt FROM messages WHERE status='unread'") -> fetch(PDO::FETCH_ASSOC);
$po = $db -> query("SELECT COUNT(status) AS cnt FROM orders WHERE status='pending'") -> fetch(PDO::FETCH_ASSOC);
$nb = $db -> query("SELECT COUNT(status) AS cnt FROM content WHERE contentType='booking' AND status!='confirmed'") -> fetch(PDO::FETCH_ASSOC);
$nu = $db -> query("SELECT COUNT(id) AS cnt FROM login WHERE activate!='' AND active=0") -> fetch(PDO::FETCH_ASSOC);
$nt = $db -> query("SELECT COUNT(id) AS cnt FROM content WHERE contentType='testimonials' AND status!='published'") -> fetch(PDO::FETCH_ASSOC);
$navStat = $nc['cnt'] + $nr['cnt'] + $nm['cnt'] + $po['cnt'] + $nb['cnt'] + $nu['cnt'] + $nt['cnt'];
$ns = $db -> prepare("UPDATE config SET navstat=:navstat WHERE id='1'") -> execute(array(':navstat' => $navStat));
if ($navStat > $config['navstat'])
  $navStatU = 1;
else
  $navStatU = 0;
print $navStat . ',' . $navStatU . ',' . $nou['cnt'] . ',' . $nc['cnt'] . ',' . $nr['cnt'] . ',' . $nm['cnt'] . ',' . $po['cnt'] . ',' . $nb['cnt'] . ',' . $nu['cnt'] . ',' . $nt['cnt'];
