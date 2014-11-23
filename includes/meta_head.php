<!DOCTYPE HTML>
<html lang="en-AU">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title>Libr8 - Administration</title>
		<base href="<?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>" />
		<meta http-equiv="X-FRAME-OPTIONS" content="DENY">
		<link rel="alternate" media="handheld" href="<?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>" />
		<link rel="alternate" hreflang="x-default" href="<?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>" />
		<link rel="alternate" hreflang="en-AU" href="<?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'];?>" />
		<link rel="icon" href="<?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'].$favicon;?>" />
		<link rel="apple-touch-icon" href="<?php echo'http://'.$_SERVER['HTTP_HOST'].$config['url'].$favicon;?>" />
		<meta name="viewport" content="width=400,initial-scale=1.0" /><link rel="stylesheet" type="text/css" href="<?php echo THEME;?>/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="includes/css/font-awesome.min.css" />
<?php if($view=='contactus'){?>
		<link rel="stylesheet" type="text/css" href="includes/css/mapsed.css" />
<?php }?>
		<link rel="stylesheet" type="text/css" href="<?php echo THEME;?>/css/style.css" />
<?php if($user['rank']>899){
		if($view=='bookings'||$view=='events'){?>
		<link rel="stylesheet" type="text/css" href="includes/css/fullcalendar.min.css" />
		<link rel="stylesheet" type="text/css" href="includes/css/bootstrap-datetimepicker.min.css" />
<?php }?>
		<link rel="stylesheet" type="text/css" href="includes/css/admin.css" />
		<link rel="stylesheet" type="text/css" href="includes/css/summernote.css" />
<?php }?>
	</head>
	<body>
		<div id="top" class="hidden"></div>
<?php if($user['rank']>699){
	if($view=='index'||$view=='article'||$view=='portfolio'||$view=='bookings'||$view=='events'||$view=='news'||$view=='testimonials'||$view=='inventory'||$view=='services'||$view=='gallery'||$view=='contactus'||$view=='tos'||$view=='search'){?>
		<div id="seohead">
			<div id="seocontent">
				<div class="panel-body">
					<div class="form-group">
						<label for="seoTitle" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Page Title</label>
						<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
							<input type="text" id="seoTitle" class="form-control" value="<?php echo$page['seoTitle'];?>" data-dbid="<?php echo$page['id'];?>" data-dbt="menu" data-dbc="seoTitle" placeholder="Enter a Page Title...">
							<div id="seoTitlesave" class="input-group-btn hidden">
								<button class="btn btn-danger"><i class="fa fa-save"></i></button>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="seoCaption" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Page Caption</label>
						<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
							<input type="text" id="seoCaption" class="form-control" value="<?php echo$page['seoCaption'];?>" data-dbid="<?php echo$page['id'];?>" data-dbt="menu" data-dbc="seoCaption" placeholder="Enter a Page Caption...">
							<div id="seoCaptionsave" class="input-group-btn hidden">
								<button class="btn btn-danger"><i class="fa fa-save"></i></button>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="seoDescription" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Page Description</label>
						<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
							<input type="text" id="seoDescription" class="form-control" value="<?php echo$page['seoDescription'];?>" data-dbid="<?php echo$page['id'];?>" data-dbt="menu" data-dbc="seoDescription" placeholder="Enter a Page Description...">
							<div id="seoDescriptionsave" class="input-group-btn hidden">
								<button class="btn btn-danger"><i class="fa fa-save"></i></button>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="seoKeywords" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Page Keywords</label>
						<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
							<input type="text" id="seoKeywords" class="form-control" value="<?php echo$page['seoKeywords'];?>" data-dbid="<?php echo$page['id'];?>" data-dbt="menu" data-dbc="seoKeywords" placeholder="Enter Page Keywords...">
							<div id="seoKeywordssave" class="input-group-btn hidden">
								<button class="btn btn-danger"><i class="fa fa-save"></i></button>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="notes" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Page Notes</label>
						<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
							<form method="post" target="sp" action="includes/update.php">
								<input type="hidden" name="id" value="<?php echo$page['id'];?>">
								<input type="hidden" name="t" value="menu">
								<input type="hidden" name="c" value="notes">
								<textarea id="notes" class="form-control summernote" name="da"><?php echo$page['notes'];?></textarea>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div id="seodrop"><a href=""><i class="fa fa-angle-double-down"></i></a></div>
		</div>
<?php	}
	}