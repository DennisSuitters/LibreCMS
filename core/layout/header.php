<?php if($user['rank']>399){?>
<div id="libre_admin_header">
	<nav class="navbar navbar-toolbar navbar-default" role="navigation">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?php echo URL.'admin';?>"><img src="core/images/librecms.png"></a>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#admin-collapse">
					<span class="sr-only">Administration</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="admin-collapse" class="collapse navbar-collapse">
				<ul class="nav navbar-nav pull-right relative">
					<li<?php if($view=='statistics')echo' class="active"';?>><a href="<?php echo URL;?>admin/statistics"><small>Statistics</small></a></li>
					<li<?php if($view=='pages')echo' class="active"';?>><a href="<?php echo URL;?>admin/pages"><small>Pages</small></a></li>
					<li<?php if($view=='content'||$view=='article'||$view=='portfolio'||$view=='events'||$view=='news'||$view=='testimonials'||$view=='inventory'||$view=='services'||$view=='gallery')echo' class="active"';?>><a href="<?php echo URL;?>admin/content"><small>Content</small></a></li>
<?php if($user['rank']==1000||$user['options']{1}==1){?>
					<li<?php if($view=='bookings')echo' class="active"';?>><a href="<?php echo URL;?>admin/bookings"><small>Bookings</small></a></li>
<?php }
if($user['rank']==1000||$user['options']{2}==1){?>
					<li<?php if($view=='orders')echo' class="active"';?>><a href="<?php echo URL;?>admin/orders/all"><small>Orders</small></a></li>
<?php }
if($user['rank']==1000||$user['options']{3}==1){?>
					<li<?php if($view=='media')echo' class="active"';?>><a href="<?php echo URL;?>admin/media"><small>Media</small></a></li>
<?php }?>
					<li<?php if($view=='accounts')echo' class="active"';?>><a href="<?php echo URL;?>admin/accounts"><small>Accounts</small></a></li>
					<li style="padding-top:7px">
<?php if($user['rank']==1000||$user['options']{0}==1){?>
						<button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-placement="right"><?php if($config['buttonType']=='text')echo'<small>Add</small>';else echo'<i class="libre libre-plus"></i>';?> <i class="caret"></i></button>
						<ul class="dropdown-menu multi-level pull-right">
							<li><a href="<?php echo URL;?>admin/add/article">Article</a></li>
							<li><a href="<?php echo URL;?>admin/add/portfolio">Portfolio</a></li>
							<li><a href="<?php echo URL;?>admin/add/events">Event</a></li>
							<li><a href="<?php echo URL;?>admin/add/news">News</a></li>
							<li><a href="<?php echo URL;?>admin/add/testimonials">Testimonial</a></li>
							<li><a href="<?php echo URL;?>admin/add/inventory">Inventory</a></li>
							<li><a href="<?php echo URL;?>admin/add/services">Service</a></li>
							<li><a href="<?php echo URL;?>admin/add/gallery">Gallery</a></li>
							<li><a href="<?php echo URL;?>admin/add/bookings">Booking</a></li>
							<li><a href="<?php echo URL;?>admin/add/proofs">Proofs</a></li>
							<li><a href="<?php echo URL;?>admin/accounts/add">Account</a></li>
							<li class="dropdown-submenu pull-left">
								<a href="#">Orders</a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo URL;?>admin/orders/addquote">Quote</a></li>
									<li><a href="<?php echo URL;?>admin/orders/addinvoice">Invoice</a></li>
								</ul>
							</li>
						</ul>
					</li>
<?php }?>
					<li style="padding-top:7px">
						<div class="btn-group">
							<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
								<img id="avatar" class="img-circle" src="<?php if($user['gravatar']!='')echo$user['gravatar'];elseif($user['avatar']!=''&&file_exists('media/avatar/'.$user['avatar']))echo'media/avatar/'.$user['avatar'];else echo$noavatar;?>"> <i class="caret"></i></a><ul class="dropdown-menu pull-right">
<?php if($user['rank']==1000||$user['options']{6}==1)echo'<li><a href="'.URL.'admin/preferences"><i class="libre libre-wrench libre-fw"></i> Preferences</a></li>';?>
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
					</li>
				</ul>

			</div>
		</div>
	</nav>
</div>
<?php }
