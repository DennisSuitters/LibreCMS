<?php
require_once'db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443) define('PROTOCOL','https://'); else define('PROTOCOL','http://');
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url']);
$s=$db->query("SELECT browser,COUNT(DISTINCT ip) as cnt FROM tracker WHERE browser IN ('Chrome','Firefox','Safari','Explorer') GROUP BY browser");
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	echo'<div class="panel-footer" title="'.$r['browser'].'"><span class="pull-left">'.$r['cnt'].'</span><span class="pull-right"><i class="fa icon-'.strtolower($r['browser']).'"></i></span><div class="clearfix"></div></div>';
}
