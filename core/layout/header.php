<?php if($user['rank']>399){?>
<div class="nav-side-menu shadow-depth-2">
	<div class="profile clearfix">
		<div class="profile-usertitle">
			<img class="visible-xs" src="core/images/librecms.png" alt="LibreCMS">
			<div class="profile-usertitle-name">
				<?php if($user['name']!='')echo$user['name'];else echo$user['username'];?>
			</div>
			<div class="profile-usertitle-job">
<?php if($user['rank']==400)echo'Contributor';
if($user['rank']==500)echo'Author';
if($user['rank']==600)echo'Editor';
if($user['rank']==700)echo'Moderator';
if($user['rank']==800)echo'Manager';
if($user['rank']==900)echo'Administrator';
if($user['rank']==1000)echo'Developer';?>
			</div>
		</div>
		<div class="profile-sidebar hidden-xs">
			<div class="profile-userpic">
				<img class="img-thumbnail shadow-depth-1" src="<?php if($user['gravatar']!='')echo$user['gravatar'];elseif($user['avatar']!=''&&file_exists('media/avatar/'.$user['avatar']))echo'media/avatar/'.$user['avatar'];else echo$noavatar;?>">
			</div>
		</div>
	</div>
	<hr>
	<i class="libre libre-chevron-down libre-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
	<div class="menu-list">
		<ul id="menu-content" class="menu-content collapse out">
<?php				echo'<li';if($view=='statistics')echo' class="active"';echo'><a href="'.URL.'admin/statistics"><i class="libre libre-chart-line libre-3x"></i><span>Statistics</span></a></li>';
					echo'<li';if($view=='pages')echo' class="active"';echo'><a href="'.URL.'admin/pages"><i class="libre libre-file-text libre-3x"></i><span>Pages</span></a></li>';
					echo'<li';if($view=='content'||$view=='article'||$view=='portfolio'||$view=='events'||$view=='news'||$view=='testimonials'||$view=='inventory'||$view=='services'||$view=='gallery')echo' class="active"';echo'><a href="'.URL.'admin/content"><i class="libre libre-content libre-3x"></i><span>Content</span></a></li>';
if($user['rank']==1000||$user['options']{1}==1)echo'<li';if($view=='bookings')echo' class="active"';echo'><a href="'.URL.'admin/bookings"><i class="libre libre-calendar libre-3x"></i><span>Bookings</span></a></li>';
if($user['rank']==1000||$user['options']{2}==1)echo'<li';if($view=='orders')echo' class="active"';echo'><a href="'.URL.'admin/orders/all"><i class="libre libre-order libre-3x"></i><span>Orders</span></a></li>';
if($user['rank']==1000||$user['options']{3}==1)echo'<li';if($view=='media')echo' class="active"';echo'><a href="'.URL.'admin/media"><i class="libre libre-browse-media libre-3x"></i><span>Media</span></a></li>';
					echo'<li';if($view=='messages')echo' class="active"';echo'><a href="'.URL.'admin/messages"><i class="libre libre-inbox libre-3x"></i><span>Messages</span><a></li>';
					echo'<li';if($view=='accounts')echo' class="active"';echo'><a href="'.URL.'admin/accounts"><i class="libre libre-users libre-3x"></i><span>Accounts</span></a></li>';
					echo'<li';if($view=='preferences')echo' class="active"';echo'><a href="'.URL.'admin/preferences"><i class="libre libre-settings libre-3x"></i><span>Preferences</span></a></li>';
if($user['rank']>899)echo'<li';if($view=='activity')echo' class="active"';echo'><a href="'.URL.'admin/activity"><i class="libre libre-activity libre-3x"></i><span>Activity</span></a></li>';?>
		</ul>
	</div>
	<footer class="hidden-xs">
		<div class="brand"><img src="core/images/librecms.png" alt="LibreCMS"></div>
		<ul>
			<li><a href="<?php echo URL;?>admin/logout">Logout</a></li>
			<li><a href="<?php echo URL;?>"><small>Front</small></a></li>
		</ul>
	</footer>
</div>
<?php }
