<?php
require_once'db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443) define('PROTOCOL','https://'); else define('PROTOCOL','http://');
require'password.php';
define('SESSIONID',session_id());
$config=$db->query("SELECT * FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
define('THEME','layout/'.$config['theme']);
define('UNICODE','UTF-8');
require'login.php';
