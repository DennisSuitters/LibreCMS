<?php
$head.='<!DOCTYPE HTML>';
$head.='<html lang="en-AU">';
$head.='<head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />';
$head.='<title>Libr8 - Administration</title>';
$head.='<base href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].'" />';
$head.='<meta http-equiv="X-FRAME-OPTIONS" content="DENY">';
$head.='<link rel="alternate" media="handheld" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].'" />';
$head.='<link rel="alternate" hreflang="x-default" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].'" />';
$head.='<link rel="alternate" hreflang="en-AU" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].'" />';
$head.='<link rel="icon" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].$favicon.'" />';
$head.='<link rel="apple-touch-icon" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].$favicon.'" />';
$head.='<meta name="viewport" content="width=400,initial-scale=1.0" />';
$head.='<link rel="stylesheet" type="text/css" href="'.THEME.'/css/bootstrap.min.css" />';
$head.='<link rel="stylesheet" type="text/css" href="includes/css/font-awesome.min.css" />';
$head.='<link rel="stylesheet" type="text/css" href="includes/css/admin.css" />';
if($view=='contactus')
	$head.='<link rel="stylesheet" type="text/css" href="includes/css/mapsed.css" />';
    $head.='<link rel="stylesheet" type="text/css" href="'.THEME.'/css/style.css" />';
if($user['rank']>699){
	if($view=='bookings'||$view=='events'){
		$head.='<link rel="stylesheet" type="text/css" href="includes/css/fullcalendar.min.css" />';
        $head.='<link rel="stylesheet" type="text/css" href="includes/css/bootstrap-datetimepicker.min.css" />';
    }
    $head.='<link rel="stylesheet" type="text/css" href="includes/css/summernote.css" />';
}
$head.='</head><body><div id="top" class="hidden"></div>';
if($user['rank']>699){
    if($view=='index'||$view=='article'||$view=='portfolio'||$view=='bookings'||$view=='events'||$view=='news'||$view=='testimonials'||$view=='inventory'||$view=='services'||$view=='gallery'||$view=='contactus'||$view=='tos'||$view=='search'){
	$head.='<div id="seohead"><div id="seocontent"><div class="panel-body"><div class="form-group"><label for="seoTitle" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Page Title</label><div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7"><input type="text" id="seoTitle" class="form-control" value="'.$page['seoTitle'].'" data-dbid="'.$page['id'].'" data-dbt="menu" data-dbc="seoTitle" placeholder="Enter a Page Title..."><div id="seoTitlesave" class="input-group-btn hidden"><button class="btn btn-danger"><i class="fa fa-save"></i></button></div></div></div><div class="form-group"><label for="seoCaption" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Page Caption</label><div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7"><input type="text" id="seoCaption" class="form-control" value="'.$page['seoCaption'].'" data-dbid="'.$page['id'].'" data-dbt="menu" data-dbc="seoCaption" placeholder="Enter a Page Caption..."><div id="seoCaptionsave" class="input-group-btn hidden"><button class="btn btn-danger"><i class="fa fa-save"></i></button></div></div></div><div class="form-group"><label for="seoDescription" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Page Description</label><div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7"><input type="text" id="seoDescription" class="form-control" value="'.$page['seoDescription'].'" data-dbid="'.$page['id'].'" data-dbt="menu" data-dbc="seoDescription" placeholder="Enter a Page Description..."><div id="seoDescriptionsave" class="input-group-btn hidden"><button class="btn btn-danger"><i class="fa fa-save"></i></button></div></div></div><div class="form-group"><label for="seoKeywords" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Page Keywords</label><div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7"><input type="text" id="seoKeywords" class="form-control" value="'.$page['seoKeywords'].'" data-dbid="'.$page['id'].'" data-dbt="menu" data-dbc="seoKeywords" placeholder="Enter Page Keywords..."><div id="seoKeywordssave" class="input-group-btn hidden"><button class="btn btn-danger"><i class="fa fa-save"></i></button></div></div></div><div class="form-group"><label for="notes" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Page Notes</label><div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7"><form method="post" target="sp" action="includes/update.php"><input type="hidden" name="id" value="'.$page['id'].'"><input type="hidden" name="t" value="menu"><input type="hidden" name="c" value="notes"><textarea id="notes" class="form-control summernote" name="da">'.$page['notes'].'</textarea></form></div></div></div></div><div id="seodrop"><a href=""><i class="fa fa-angle-double-down"></i></a></div></div>';
	}
}
