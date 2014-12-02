<?php
$head.='<!DOCTYPE HTML>';
$head.='<html lang="en-AU">';
$head.='<head>';
$head.='<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />';
$head.='<title>'.$seoTitle.'</title>';
$head.='<base href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].'" />';
$head.='<meta name="referrer" content="default" id="meta_referrer" />';
$head.='<meta http-equiv="X-FRAME-OPTIONS" content="DENY">';
$head.='<link rel="alternate" media="handheld" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].'" />';
$head.='<link rel="alternate" type="application/rss+xml" title="'.$seoTitle.', ';
if($view=='index'&&$seoDescription!='')
    $head.=$seoDescription;
else $head.='$seoCaption';
$head.='" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].'rss/" />';
$head.='<link rel="canonical" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].$view.'/'.str_replace(' ','-',$seoTitle).'" />';
$head.='<link rel="alternate" hreflang="x-default" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].'" />';
$head.='<link rel="alternate" hreflang="en-AU" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].'" />';
if($config['seoGoogleVerification']!='')
    $head.='<meta name="google-site-verification" content="'.$config['seoGoogleVerification'].'" />';
if($config['seoBingVerification']!='')
    $head.='<meta name="msvalidate.01" content="'.$config['seoBingVerification'].'" />';
if($config['seoPinterestVerification']!='')
	$head.='<meta name="p:domain_verify" content="'.$config['seoPinterestVerification'].'" />';
$head.='<meta name="description" content="';
if($view=='index'&&$seoDescription!='')
    $head.=$seoDescription;
else $head.=$seoCaption;$head.='" />';
$head.='<meta name="keywords" content="'.$seoKeywords.'" />';
$head.='<meta property="og:locale" content="en-AU" />';
$head.='<meta property="og:title" content="'.$seoTitle.'" />';
$head.='<meta property="og:type" content="'.$view.'" />';
$head.='<meta property="og:image" content="'.$share_image.'" />';
$head.='<meta property="og:url" content="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].$view.'/'.str_replace(' ','-',$seoTitle).'" />';
$head.='<meta property="og:description" content="';
if($view=='index'&&$seoDescription!='')
    $head.=$seoDescription;
else $head.=$seoCaption;
$head.='" />';
$head.='<meta property="og:updated_time" content="'.date(DATE_ATOM,time()).'" />';
$head.='<meta name="twitter:card" content="summary" />';
$head.='<meta name="twitter:title" content="'.$seoTitle.'" />';
$head.='<meta name="twitter:image" content="'.$share_image.'" />';
$head.='<meta name="twitter:description" content="';
if($view=='index'&&$seoDescription!='')
    $head.=$seoDescription;
else $head.=$seoCaption;
$head.='" />';
$head.='<link rel="icon" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].$favicon.'" />';
$head.='<link rel="apple-touch-icon" href="'.PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].$favicon.'" />';
$head.='<meta name="viewport" content="width=400,initial-scale=1.0" />';
$head.='<link rel="stylesheet" type="text/css" href="'.THEME.'/css/bootstrap.min.css" />';
$head.='<link rel="stylesheet" type="text/css" href="includes/css/font-awesome.min.css" />';
if($view=='contactus'){
    $head.='<link rel="stylesheet" type="text/css" href="includes/css/mapsed.css" />';
}
$head.='<link rel="stylesheet" type="text/css" href="'.THEME.'/css/style.css" />';
$head.='</head>';
$head.='<body>';
$head.='<div id="top" class="hidden"></div>';
