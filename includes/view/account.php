<?php
if($user['rank']>0){
	$content.='<div id="libr8_admin_header">';
		$content.='<nav class="navbar navbar-inverse" role="navigation">';
			$content.='<div class="container-fluid">';
				$content.='<div class="navbar-header">';
					$content.='<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#admin-collapse">';
						$content.='<span class="sr-only">Administration</span>';
						$content.='<span class="icon-bar"></span>';
						$content.='<span class="icon-bar"></span>';
						$content.='<span class="icon-bar"></span>';
					$content.='</button>';
				$content.='</div>';
				$content.='<div class="collapse navbar-collapse" id="admin-collapse">';
					$content.='<ul class="nav navbar-nav pull-right relative" style="margin-right:20px;">';
						$content.='<li';if($view=='proofs')$content.=' class="active"';$content.='><a href="proofs">Proofs</a></li>';
						$content.='<li';if($view=='orders')$content.=' class="active"';$content.='><a href="orders">Orders</a></li>';
						$content.='<li';if($view=='settings')$content.=' class="active"';$content.='><a href="settings">Settings</a></li>';
					$content.='</ul>';
 	if($user['gravatar']!=''){
		$avatar='http://www.gravatar.com/avatar/'.md5($user['gravatar']);
	}elseif($user['avatar']!=''&&file_exists('media/'.$user['avatar'])){
		$avatar='media/'.$user['avatar'];
	}else{
		$avatar=$noavatar;
	}
				$content.='<img id="avatar" class="pull-right img-circle" src="'.$avatar.'">';
			$content.='</div>';
//		$content.='</div>';
	$content.='</nav>';
$content.='</div>';
}
