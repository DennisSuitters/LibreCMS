<?php
if(!isset($db))require'db.php';
$s=$db->query("ALTER TABLE login ADD adminTheme VARCHAR(32) NOT NULL AFTER options");

$sql="CREATE TABLE tracker(
  id BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
  pid BIGINT(20),
  urlDest VARCHAR(255),
  urlFrom VARCHAR(255),
  userAgent VARCHAR(255),
  ip VARCHAR(15),
  browser VARCHAR(32),
  os VARCHAR(32),
  sid VARCHAR(64),
  ti INT(10)
);";
$db->exec($sql);
