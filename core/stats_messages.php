<?php
require_once'db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443) define('PROTOCOL','https://'); else define('PROTOCOL','http://');
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url']);
$s=$db->query("SELECT * FROM content WHERE contentType='message_primary' AND status='unread' LIMIT 0,10");
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	echo'<div class="panel-footer"><a href="'.URL.'/admin/messages/'.$r['id'].'"><span class="pull-left">'.$r['subject'].'</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span></a><div class="clearfix"></div></div>';
}