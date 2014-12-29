<?php
require'includes/db.php';
$config=$this->getconfig($db);
$ti=time();
$favicon=$this->favicon();
$share_image=$favicon;
$noimage=$this->noimage();
$noavatar=$this->noavatar();
$sp=$db->prepare("SELECT * FROM menu WHERE contentType=:contentType");
$sp->execute(array(':contentType'=>$view));
require'includes/login.php';
if($user['rank']>399){
	require'includes/layout/meta_head.php';
	require'includes/layout/header.php';?>
<main id="content" class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-body">
<?php if($view=='add'){
		if($args[0]=='bookings'){
			require'includes/layout/bookings.php';
		}else{
			require'includes/layout/content.php';
		}
}else{
	require'includes/layout/'.$view.'.php';
}?>
		</div>
	</div>
</main>
<?php require'includes/layout/footer.php';
	require'includes/layout/meta_footer.php';
}else{
	require'includes/layout/login.php';
}