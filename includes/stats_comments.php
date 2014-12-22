<?php
require_once'db.php';
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443) define('PROTOCOL','https://'); else define('PROTOCOL','http://');
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url']);
$s=$db->query("SELECT rid FROM comments WHERE status='unapproved' LIMIT 0,10");
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	$sc=$db->prepare("SELECT id,contentType,title FROM content WHERE id=:id");
	$sc->execute(array(':id'=>$r['rid']));
	$rc=$sc->fetch(PDO::FETCH_ASSOC);
	echo'<a href="'.URL.'/admin/content/edit/'.$rc['id'].'#comments"><div class="panel-footer"><span class="pull-left">'.$rc['title'].'</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>';
}