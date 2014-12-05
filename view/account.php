<?php
if($user['rank']>0){
    $content.='<div id="libr8_admin_header" class="libr8 nopadding nomargin">';
		$content.='<nav class="libr8 navbar navbar-inverse no-margin" role="navigation">';
			$content.='<div class="libr8 container-fluid">';
				$content.='<div class="libr8 navbar-header">';
					$content.='<button type="button" class="libr8 navbar-toggle" data-toggle="collapse" data-target="#libr8-admin-collapse">';
						$content.='<span class="libr8 sr-only">Administration</span>';
						$content.='<span class="libr8 icon-bar"></span>';
						$content.='<span class="libr8 icon-bar"></span>';
						$content.='<span class="libr8 icon-bar"></span>';
					$content.='</button>';
    if($user['rank']>699){
        $content.='<span class="libr8 navbar-brand"><a class="libr8 admin_logo" href=""><img src="images/libr8.png"></a></span>';
    }
	$content.='</div>';
	$content.='<div class="libr8 collapse navbar-collapse" id="libr8-admin-collapse">';
		$content.='<ul class="libr8 nav navbar-nav pull-right relative" style="margin-right:20px;">';
    if($user['rank']>899){
        if($user['options']{3}==1){
			$content.='<li';if($view=='orders'){$content.=' class="libr8 active"';}$content.='><a href="admin/orders/all">Orders</a></li>';
        }
       $content.='<li';if($view=='media'){$content.=' class="libr8 active"';}$content.='><a href="admin/media">Media</a></li>';
        if($user['options']{5}==1){
			$content.='<li';if($view=='accounts'){$content.=' class="libr8 active"';}$content.='><a href="admin/accounts">Accounts</a></li>';
        }
	   if($user['options']{0}==1){
			$content.='<li';if($view=='proofs'){$content.=' class="libr8 active"';}$content.='><a href="admin/proofs">Proofs</a></li>';
        }
			$content.='<li';if($view=='messages'){$content.=' class="libr8 active"';}$content.='><a href="admin/messages">Messages</a></li>';
        if($user['options']{4}==1||$user['options']{1}==1){
			$content.='<li';if($view=='preferences'){$content.=' class="libr8 active"';}$content.='><a href="admin/preferences">Preferences</a></li>';
        }
	   if($user['options']{0}==1){
			$content.='<li>';
				$content.='<button class="libr8 btn btn-success dropdown-toggle" style="margin:7px 10px;" data-toggle="dropdown" data-placement="right">Add <i class="libr8 caret"></i></button>';
				$content.='<ul class="libr8 dropdown-menu multi-level pull-right">';
           $sq=$db->query("SELECT * FROM menu WHERE active='1' AND contentType!='index' AND contentType!='contactus' AND contentType!='cart' AND contentType!='tos' ORDER BY ord ASC");
           while($sr=$sq->fetch(PDO::FETCH_ASSOC)){
					$content.='<li><a href="'.$sr['contentType'].'/add">'.$sr['title'].'</a></li>';
            }
					$content.='<li><a href="admin/proofs/add">Proofs</a></li>';
					$content.='<li><a href="admin/accounts/add">Account</a></li>';
					$content.='<li class="libr8 dropdown-submenu pull-left">';
						$content.='<a href="#">Orders</a>';
						$content.='<ul class="libr8 dropdown-menu">';
							$content.='<li><a href="admin/orders/addquote">Quote</a></li>';
							$content.='<li><a href="admin/orders/addinvoice">Invoice</a></li>';
						$content.='</ul>';
					$content.='</li>';
				$content.='</ul>';
			$content.='</li>';
        }
	}else{
        $content.='<li';
        if($view=='proofs')$content.=' class="libr8 active"';
        $content.='><a href="proofs">Proofs</a></li><li';
        if($view=='orders')$content.=' class="libr8 active"';
        $content.='><a href="orders">Orders</a></li><li';
        if($view=='settings')$content.=' class="libr8 active"';
        $content.='><a href="settings">Settings</a></li>';
    }
    $content.='</ul>';
 	if($user['gravatar']!=''){
		$avatar='http://www.gravatar.com/avatar/'.md5($user['gravatar']);
	}elseif($user['avatar']!=''&&file_exists('media/'.$user['avatar'])){
		$avatar='media/'.$user['avatar'];
	}else{
		$avatar=$noavatar;
	}
    $content.='<img id="avatar" class="libr8 pull-right img-circle" src="'.$avatar.'"></div></div></nav></div>';
}
