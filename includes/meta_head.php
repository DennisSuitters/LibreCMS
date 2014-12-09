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
$head.='<link rel="stylesheet" type="text/css" href="includes/css/bootstrap.min.css" />';
$head.='<link rel="stylesheet" type="text/css" href="'.THEME.'/css/bootstrap.min.css" />';
$head.='<link rel="stylesheet" type="text/css" href="includes/css/font-awesome.min.css" />';
if($view=='contactus')
	$head.='<link rel="stylesheet" type="text/css" href="'.THEME.'/css/mapsed.css" />';
$head.='<link rel="stylesheet" type="text/css" href="'.THEME.'/css/style.css" />';
if($user['rank']>699){
	if($view=='bookings'||$view=='events'){
		$head.='<link rel="stylesheet" type="text/css" href="includes/css/fullcalendar.min.css" />';
		$head.='<link rel="stylesheet" type="text/css" href="includes/css/bootstrap-datetimepicker.min.css" />';
	}
	$head.='<link rel="stylesheet" type="text/css" href="includes/css/summernote.css" />';
}
$head.='<link rel="stylesheet" type="text/css" href="includes/css/admin.css" />';
$head.='</head><body><div id="top" class="hidden"></div>';
if($user['rank']>699){
	if($view=='index'||$view=='article'||$view=='portfolio'||$view=='bookings'||$view=='events'||$view=='news'||$view=='testimonials'||$view=='inventory'||$view=='services'||$view=='gallery'||$view=='contactus'||$view=='tos'||$view=='search'){
	$head.='<div id="seohead">';
		$head.='<div id="seocontent">';
			$head.='<div class="libr8-panel-body">';
				$head.='<div class="libr8-form-group">';
					$head.='<label for="seoTitle" class="libr8-control-label libr8-col-lg-2 libr8-col-md-3 libr8-col-sm-3 libr8-col-xs-5">Page Title</label>';
					$head.='<div class="libr8-input-group libr8-col-lg-10 libr8-col-md-9 libr8-col-sm-9 libr8-col-xs-7">';
						$head.='<input type="text" id="seoTitle" class="libr8-form-control" value="'.$page['seoTitle'].'" data-dbid="'.$page['id'].'" data-dbt="menu" data-dbc="seoTitle" placeholder="Enter a Page Title...">';
						$head.='<div id="seoTitlesave" class="libr8-input-group-btn libr8-hidden">';
							$head.='<button class="libr8-btn libr8-btn-danger"><i class="fa fa-save"></i></button>';
						$head.='</div>';
					$head.='</div>';
				$head.='</div>';
				$head.='<div class="libr8-form-group">';
					$head.='<label for="seoCaption" class="libr8-libr8 libr8-control-label libr8-col-lg-2 libr8-col-md-3 libr8-col-sm-3 libr8-col-xs-5">Page Caption</label>';
					$head.='<div class="libr8-input-group libr8-col-lg-10 libr8-col-md-9 libr8-col-sm-9 libr8-col-xs-7">';
						$head.='<input type="text" id="seoCaption" class="libr8-form-control" value="'.$page['seoCaption'].'" data-dbid="'.$page['id'].'" data-dbt="menu" data-dbc="seoCaption" placeholder="Enter a Page Caption...">';
						$head.='<div id="seoCaptionsave" class="libr8-input-group-btn libr8-hidden">';
							$head.='<button class="libr8-btn btn-danger"><i class="fa fa-save"></i></button>';
						$head.='</div>';
					$head.='</div>';
				$head.='</div>';
				$head.='<div class="libr8-form-group">';
					$head.='<label for="seoDescription" class="libr8-control-label libr8-col-lg-2 libr8-col-md-3 libr8-col-sm-3 libr8-col-xs-5">Page Description</label>';
					$head.='<div class="libr8-input-group libr8-col-lg-10 libr8-col-md-9 libr8-col-sm-9 libr8-col-xs-7">';
						$head.='<input type="text" id="seoDescription" class="libr8-form-control" value="'.$page['seoDescription'].'" data-dbid="'.$page['id'].'" data-dbt="menu" data-dbc="seoDescription" placeholder="Enter a Page Description...">';
						$head.='<div id="seoDescriptionsave" class="libr8-input-group-btn libr8-hidden">';
							$head.='<button class="libr8-btn libr8-btn-danger"><i class="fa fa-save"></i></button>';
						$head.='</div>';
					$head.='</div>';
				$head.='</div>';
				$head.='<div class="libr8-form-group">';
					$head.='<label for="seoKeywords" class="libr8-control-label libr8-col-lg-2 libr8-col-md-3 libr8-col-sm-3 libr8-col-xs-5">Page Keywords</label>';
					$head.='<div class="libr8-input-group libr8-col-lg-10 libr8-col-md-9 libr8-col-sm-9 libr8-col-xs-7">';
						$head.='<input type="text" id="seoKeywords" class="libr8-form-control" value="'.$page['seoKeywords'].'" data-dbid="'.$page['id'].'" data-dbt="menu" data-dbc="seoKeywords" placeholder="Enter Page Keywords...">';
						$head.='<div id="seoKeywordssave" class="libr8-input-group-btn libr8-hidden">';
							$head.='<button class="libr8-btn libr8-btn-danger"><i class="fa fa-save"></i></button>';
						$head.='</div>';
					$head.='</div>';
				$head.='</div>';
				$head.='<div class="libr8-form-group">';
					$head.='<label for="notes" class="libr8-control-label libr8-col-lg-2 libr8-col-md-3 libr8-col-sm-3 libr8-col-xs-5">Page Notes</label>';
					$head.='<div class="libr8-input-group libr8-col-lg-10 libr8-col-md-9 libr8-col-sm-9 libr8-col-xs-7">';
						$head.='<form method="post" target="sp" action="includes/update.php">';
							$head.='<input type="hidden" name="id" value="'.$page['id'].'">';
							$head.='<input type="hidden" name="t" value="menu">';
							$head.='<input type="hidden" name="c" value="notes">';
							$head.='<textarea id="notes" class="libr8-form-control summernote" name="da">'.$page['notes'].'</textarea>';
						$head.='</form>';
					$head.='</div>';
				$head.='</div>';
			$head.='</div>';
		$head.='</div>';
		$head.='<div id="seodrop">';
			$head.='<a href=""><i class="fa fa-angle-double-down"></i></a>';
		$head.='</div>';
	$head.='</div>';
	}
}
