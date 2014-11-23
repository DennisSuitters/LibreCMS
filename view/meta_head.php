<!DOCTYPE HTML>
<html lang="en-AU">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title><?php echo$seoTitle;?></title>
		<base href="<?php echo PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'];?>" />
		<meta name="referrer" content="default" id="meta_referrer" />
		<meta http-equiv="X-FRAME-OPTIONS" content="DENY">
		<link rel="alternate" media="handheld" href="<?php echo PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'];?>" />
		<link rel="alternate" type="application/rss+xml" title="<?php echo$seoTitle.', ';if($view=='index'&&$seoDescription!=''){echo$seoDescription;}else{echo$seoCaption;}?>" href="<?php echo PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].'rss/';?>" />
		<link rel="canonical" href="<?php echo PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].$view.'/'.str_replace(' ','-',$seoTitle);?>" />
		<link rel="alternate" hreflang="x-default" href="<?php echo PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'];?>" />
		<link rel="alternate" hreflang="en-AU" href="<?php echo PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'];?>" />
<?php if($config['seoGoogleVerification']!=''){?>
		<meta name="google-site-verification" content="<?php echo$config['seoGoogleVerification'];?>" />
<?php }
if($config['seoBingVerification']!=''){?>
		<meta name="msvalidate.01" content="<?php echo$config['seoBingVerification'];?>" />
<?php }
if($config['seoPinterestVerification']!=''){?>
		<meta name="p:domain_verify" content="<?php echo$config['seoPinterestVerification'];?>" />
<?php }?>
		<meta name="description" content="<?php if($view=='index'&&$seoDescription!=''){echo$seoDescription;}else{echo$seoCaption;}?>" />
		<meta name="keywords" content="<?php echo$seoKeywords;?>" />
		<meta property="og:locale" content="en-AU" />
		<meta property="og:title" content="<?php echo$seoTitle;?>" />
		<meta property="og:type" content="<?php echo$view;?>" />
		<meta property="og:image" content="<?php echo$share_image;?>" />
		<meta property="og:url" content="<?php echo PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].$view.'/'.str_replace(' ','-',$seoTitle);?>" />
		<meta property="og:description" content="<?php ;if($view=='index'&&$seoDescription!=''){echo$seoDescription;}else{echo$seoCaption;}?>" />
		<meta property="og:updated_time" content="<?php echo date(DATE_ATOM,time());?>" />
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="<?php echo$seoTitle;?>" />
		<meta name="twitter:image" content="<?php echo$share_image;?>" />
		<meta name="twitter:description" content="<?php ;if($view=='index'&&$seoDescription!=''){echo$seoDescription;}else{echo$seoCaption;}?>" />
		<link rel="icon" href="<?php echo PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].$favicon;?>" />
		<link rel="apple-touch-icon" href="<?php echo PROTOCOL.$_SERVER['HTTP_HOST'].$config['url'].$favicon;?>" />
		<meta name="viewport" content="width=400,initial-scale=1.0" /><link rel="stylesheet" type="text/css" href="<?php echo THEME;?>/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="includes/css/font-awesome.min.css" />
<?php if($view=='contactus'){?>
		<link rel="stylesheet" type="text/css" href="includes/css/mapsed.css" />
<?php }?>
		<link rel="stylesheet" type="text/css" href="<?php echo THEME;?>/css/style.css" />
	</head>
	<body>
		<div id="top" class="hidden"></div>
