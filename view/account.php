<?php
if($user['rank']>0){
    $content.='<div id="libr8_admin_header" class="nopadding nomargin"><nav class="navbar navbar-inverse no-margin" role="navigation"><div class="container-fluid"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#libr8-admin-collapse"><span class="sr-only">Administration</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>';
    if($user['rank']>699){
        $content.='<span class="navbar-brand"><a class="admin_logo" href=""><img src="images/libr8.png"></a></span>';
    }
	$content.='</div><div class="collapse navbar-collapse" id="libr8-admin-collapse"><ul class="nav navbar-nav pull-right relative" style="margin-right:20px;">';
    if($user['rank']>899){
        if($user['options']{3}==1){
           $content.='<li';if($view=='orders'){$content.=' class="active"';}$content.='><a href="admin/orders/all">Orders</a></li>';
        }
       $content.='<li';if($view=='media'){$content.=' class="active"';}$content.='><a href="admin/media">Media</a></li>';
        if($user['options']{5}==1){
            $content.='<li';if($view=='accounts'){$content.=' class="active"';}$content.='><a href="admin/accounts">Accounts</a></li>';
        }
	   if($user['options']{0}==1){
           $content.='<li';if($view=='proofs'){$content.=' class="active"';}$content.='><a href="admin/proofs">Proofs</a></li>';
        }
			$content.='<li';if($view=='messages'){$content.=' class="active"';}$content.='><a href="admin/messages">Messages</a></li>';
        if($user['options']{4}==1||$user['options']{1}==1){
			$content.='<li';if($view=='preferences'){$content.=' class="active"';}$content.='><a href="admin/preferences">Preferences</a></li>';
        }
	   if($user['options']{0}==1){
			$content.='<li><button class="btn btn-success dropdown-toggle" style="margin:7px 10px;" data-toggle="dropdown" data-placement="right">Add <i class="caret"></i></button><ul class="dropdown-menu multi-level pull-right">';
           $sq=$db->query("SELECT * FROM menu WHERE active='1' AND contentType!='index' AND contentType!='contactus' AND contentType!='cart' AND contentType!='tos' ORDER BY ord ASC");
           while($sr=$sq->fetch(PDO::FETCH_ASSOC)){
               $content.='<li><a href="'.$sr['contentType'].'>/add">'.$sr['title'].'</a></li>';
            }
$content.='<li><a href="admin/proofs/add">Proofs</a></li><li><a href="admin/accounts/add">Account</a></li><li class="dropdown-submenu pull-left"><a href="#">Orders</a><ul class="dropdown-menu"><li><a href="admin/orders/addquote">Quote</a></li><li><a href="admin/orders/addinvoice">Invoice</a></li></ul></li></ul></li>';
        }
	}else{
        $content.='<li';if($view=='proofs'){$content.=' class="active"';}$content.='><a href="proofs">Proofs</a></li><li';if($view=='orders'){$content.=' class="active"';}$content.='><a href="orders">Orders</a></li><li';if($view=='settings'){$content.=' class="active"';}$content.='><a href="settings">Settings</a></li>';
    }
    $content.='</ul>';
 	if($user['gravatar']!=''){
		$avatar='http://www.gravatar.com/avatar/'.md5($user['gravatar']);
	}elseif($user['avatar']!=''&&file_exists('media/'.$user['avatar'])){
		$avatar='media/'.$user['avatar'];
	}else{
		$avatar=$noavatar;
	}
    $content.='<img id="avatar" class="pull-right img-circle" src="'.$avatar.'"></div></div></nav></div>';
}
