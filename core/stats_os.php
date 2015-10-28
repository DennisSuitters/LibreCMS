<?php
require_once'db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443) define('PROTOCOL','https://'); else define('PROTOCOL','http://');
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url']);
$s=$db->query("SELECT DISTINCT browser FROM tracker WHERE browser!='Unknown'");
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	$sb=$db->prepare("SELECT COUNT(ip) AS cnt FROM tracker WHERE browser=:browser");
	$sb->execute(array(':browser'=>$r['browser']));
	$rb=$sb->fetch(PDO::FETCH_ASSOC);
	echo'<div class="panel-footer" title="'.$r['browser'];'"><span class="pull-left">'.$rb['cnt'].'</span><span class="pull-right"><i class="fa icon-'.strtolower($r['browser']).'"></i></span><div class="clearfix"></div></div>';
}
