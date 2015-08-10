<?php
require'core/db.php';
$config=$this->getconfig($db);
$ti=time();
$favicon=$this->favicon();
$share_image=$favicon;
$noimage=$this->noimage();
$noavatar=$this->noavatar();
$sp=$db->prepare("SELECT * FROM menu WHERE contentType=:contentType");
$sp->execute(array(':contentType'=>$view));
require'core/login.php';
if($_SESSION['rank']>399){
	require'core/layout/meta_head.php';
	require'core/layout/header.php';?>
<main id="content">
<?php if($view=='add'){
		if($args[0]=='bookings')require'core/layout/bookings.php';
		else require'core/layout/content.php';
	}else require'core/layout/'.$view.'.php';?>
</main>
<?php require'core/layout/footer.php';
	require'core/layout/meta_footer.php';
}else require'core/layout/login.php';
