<?php if($user['rank']>399){?>
<div id="libre_admin_header">
	<nav class="navbar navbar-toolbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle pull-left" style="margin-left:7px" data-toggle="collapse" data-target="#admin-collapse">
					<span class="sr-only">Menu</span>
<?php	if($config['buttonType']=='text')echo'Menu <i class="caret"></i>';
		else echo'<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>';?>
				</button>
			</div>
			<div id="admin-collapse" class="collapse navbar-collapse" style="margin-right:50px;">
				<ul class="nav navbar-nav relative">
<?php				echo'<li';if($view=='statistics')echo' class="active"';echo'><a href="'.URL.'admin/statistics"><small>Statistics</small></a></li>';
					echo'<li';if($view=='pages')echo' class="active"';echo'><a href="'.URL.'admin/pages"><small>Pages</small></a></li>';
					echo'<li';if($view=='content'||$view=='article'||$view=='portfolio'||$view=='events'||$view=='news'||$view=='testimonials'||$view=='inventory'||$view=='services'||$view=='gallery')echo' class="active"';echo'><a href="'.URL.'admin/content"><small>Content</small></a></li>';
if($user['rank']==1000||$user['options']{1}==1){
					echo'<li';if($view=='bookings')echo' class="active"';echo'><a href="'.URL.'admin/bookings"><small>Bookings</small></a></li>';
}
if($user['rank']==1000||$user['options']{2}==1){
					echo'<li';if($view=='orders')echo' class="active"';echo'><a href="'.URL.'admin/orders/all"><small>Orders</small></a></li>';
}
if($user['rank']==1000||$user['options']{3}==1){
					echo'<li';if($view=='media')echo' class="active"';echo'><a href="'.URL.'admin/media"><small>Media</small></a></li>';
}
					echo'<li';if($view=='accounts')echo' class="active"';echo'><a href="'.URL.'admin/accounts"><small>Accounts</small></a></li>';?>
				</ul>
			</div>
					<div class="btn-group pull-right" style="position:absolute;top:9px;right:7px;">
			<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
			<img id="avatar" class="img-circle" src="<?php if($user['gravatar']!='')echo$user['gravatar'];elseif($user['avatar']!=''&&file_exists('media/avatar/'.$user['avatar']))echo'media/avatar/'.$user['avatar'];else echo$noavatar;?>"> <i class="caret"></i></a>
			<ul class="dropdown-menu pull-right">
<?php if($user['rank']==1000||$user['options']{6}==1)echo'<li><a href="'.URL.'admin/preferences"><i class="libre libre-wrench libre-fw"></i> Settings</a></li>';?>
				<li><a href="<?php echo URL.'admin/accounts/edit/'.$user['id'];?>"><i class="libre libre-pencil libre-fw"></i> Account</a></li>
				<li><a href="<?php echo URL.'admin/messages';?>"><i class="libre libre-inbox"></i> Messages
<?php $s=$db->prepare("SELECT COUNT(id) as cnt FROM messages WHERE folder='INBOX' AND status='unread'");
	$s->execute();
	$cnt=$s->fetch(PDO::FETCH_ASSOC);?>
				</li>
				<li class="divider"></li>
				<li><a href="<?php echo URL;?>logout"><i class="libre libre-sign-out libre-fw"></i> Logout</a></li>
			</ul>
		</div>
		</div>

	</nav>
</div>
<?php }
