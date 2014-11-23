<?php
if($user['rank']>0){?>
<div id="libr8_admin_header" class="nopadding nomargin">
	<nav class="navbar navbar-inverse no-margin" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#libr8-admin-collapse">
					<span class="sr-only">Administration</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php if($user['rank']>699){?>
				<span class="navbar-brand"><a class="admin_logo" href=""><img src="images/libr8.png"></a></span>
<?php }?>
			</div>
			<div class="collapse navbar-collapse" id="libr8-admin-collapse">
				<ul class="nav navbar-nav pull-right relative" style="margin-right:20px;">
<?php if($user['rank']>899){
	if($user['options']{3}==1){?>
					<li<?php if($view=='orders'){echo' class="active"';}?>><a href="admin/orders/all">Orders</a></li>
<?php }?>
					<li<?php if($view=='media'){echo' class="active"';}?>><a href="admin/media">Media</a></li>
<?php if($user['options']{5}==1){?>
					<li<?php if($view=='accounts'){echo' class="active"';}?>><a href="admin/accounts">Accounts</a></li>
<?php }
	if($user['options']{0}==1){?>
					<li<?php if($view=='proofs'){echo' class="active"';}?>><a href="admin/proofs">Proofs</a></li>
<?php }?>
					<li<?php if($view=='messages'){echo' class="active"';}?>><a href="admin/messages">Messages</a></li>
<?php if($user['options']{4}==1||$user['options']{1}==1){?>
					<li<?php if($view=='preferences'){echo' class="active"';}?>><a href="admin/preferences">Preferences</a></li>
<?php }
	if($user['options']{0}==1){?>
					<li>
						<button class="btn btn-success dropdown-toggle" style="margin:7px 10px;" data-toggle="dropdown" data-placement="right">Add <i class="caret"></i></button>
						<ul class="dropdown-menu multi-level pull-right">
<?php	$sq=$db->query("SELECT * FROM menu WHERE active='1' AND contentType!='index' AND contentType!='contactus' AND contentType!='cart' ORDER BY ord ASC");
		while($sr=$sq->fetch(PDO::FETCH_ASSOC)){?>
							<li><a href="<?php echo$sr['contentType'];?>/add"><?php echo$sr['title'];?></a></li>
<?php	}?>
							<li><a href="admin/proofs/add">Proofs</a></li>
							<li><a href="admin/accounts/add">Account</a></li>
							<li class="dropdown-submenu pull-left">
								<a href="#">Orders</a>
								<ul class="dropdown-menu">
									<li><a href="admin/orders/addquote">Quote</a></li>
									<li><a href="admin/orders/addinvoice">Invoice</a></li>
								</ul>
							</li>
						</ul>
					</li>
<?php }
	}else{?>
					<li<?php if($view=='proofs'){echo' class="active"';}?>><a href="proofs">Proofs</a></li>
					<li<?php if($view=='orders'){echo' class="active"';}?>><a href="orders">Orders</a></li>
					<li<?php if($view=='settings'){echo' class="active"';}?>><a href="settings">Settings</a></li>
<?php }?>
				</ul>
<?php 	if($user['gravatar']!=''){
			$avatar='http://www.gravatar.com/avatar/'.md5($user['gravatar']);
		}elseif($user['avatar']!=''&&file_exists('media/'.$user['avatar'])){
			$avatar='media/'.$user['avatar'];
		}else{
			$avatar=$noavatar;
		}?>
				<img id="avatar" class="pull-right img-circle" src="<?php echo$avatar;?>">
			</div>
		</div>
	</nav>
</div>
<?php }
