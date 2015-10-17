<?php
require'core/db.php';
$config=$this->getconfig($db);
$ti=time();
$favicon=$this->favicon();
$share_image=$favicon;
$noimage=$this->noimage();
$noavatar=$this->noavatar();
$sp=$db->prepare("SELECT * FROM menu WHERE contentType=:contentType");
$sp->execute(array(':contentType'=>$view));
require'core/login.php';
if(isset($user)&&$user['language']=='')$user=['language'=>$config['language']];
if(isset($user['language'])&&file_exists('core/lang/'.$user['language'].'.php'))require'core/lang/'.$user['language'].'.php';else require'core/lang/en-AU.php';
if($_SESSION['rank']>399){?>
<!DOCTYPE HTML>
<html lang="<?php echo$config['language'];?>" id="libreCMS">
	<head>
		<meta name="generator" content="LibreCMS">
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>LibreCMS - <?php lang('Administration');?> - <?php lang($view);?></title>
		<base href="<?php echo URL;?>">
<?php /*		<meta http-equiv="X-FRAME-OPTIONS" content="DENY"> */ ?>
		<link rel="alternate" media="handheld" href="<?php echo URL;?>">
		<link rel="alternate" hreflang="x-default" href="<?php echo URL;?>">
		<link rel="alternate" hreflang="<?php echo$user['language'];?>" href="<?php echo URL;?>">
		<link rel="icon" href="<?php echo URL.$favicon;?>">
		<link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="core/js/pace.min.js"></script>
		<link rel="stylesheet" type="text/css" href="core/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="core/css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" type="text/css" href="core/css/libreicons.css">
		<link rel="stylesheet" type="text/css" href="core/css/summernote.css">
		<link rel="stylesheet" type="text/css" href="core/css/featherlight.min.css">
		<link rel="stylesheet" type="text/css" href="core/css/admin.css">
	</head>
	<body>
		<div id="top" class="hidden"></div>
		<div class="nav-side-menu shadow-depth-2">
			<div class="profile clearfix">
				<div class="profile-usertitle">
					<div class="profile-usertitle-name"><?php if($user['name']!='')echo$user['name'];else echo$user['username'];?></div>
					<div class="profile-usertitle-job"><?php lang('rank',$user['rank']);?></div>
				</div>
				<div class="profile-sidebar">
					<div class="profile-userpic">
						<img class="img-thumbnail shadow-depth-1" src="<?php if($user['gravatar']!='')echo$user['gravatar'];elseif($user['avatar']!=''&&file_exists('media/avatar/'.$user['avatar']))echo'media/avatar/'.$user['avatar'];else echo$noavatar;?>">
					</div>
				</div>
			</div>
			<hr>
			<div class="menu-list">
				<ul id="menu-content" class="menu-content">
					<li<?php if($view=='statistics')echo' class="active"';?>><a href="<?php echo URL.'admin/statistics';?>"><i class="libre libre-chart-line" name="<?php lang('Statistics');?>"></i><span><?php lang('Statistics');?></span></a></li>
					<li<?php if($view=='pages')echo' class="active"';?>><a href="<?php echo URL.'admin/pages';?>"><i class="libre libre-content" name="<?php lang('Pages');?>"></i><span><?php lang('Pages');?></span></a></li>
					<li<?php if($view=='content'||$view=='article'||$view=='portfolio'||$view=='events'||$view=='news'||$view=='testimonials'||$view=='inventory'||$view=='services'||$view=='gallery')echo' class="active"';?>><a href="<?php echo URL.'admin/content';?>"><i class="libre libre-content" name="<?php lang('Content');?>"></i><span><?php lang('Content');?></span></a></li>
<?php	if($user['rank']==1000||$user['options']{1}==1){?>
					<li<?php if($view=='bookings')echo' class="active"';?>><a href="<?php echo URL.'admin/bookings';?>"><i class="libre libre-calendar" name="<?php lang('Bookings');?>"></i><span><?php lang('Bookings');?></span></a></li>
<?php	}
		if($user['rank']==1000||$user['options']{2}==1){?>
					<li<?php if($view=='orders')echo' class="active"';?>><a href="<?php echo URL.'admin/orders/all';?>"><i class="libre libre-order" name="<?php lang('Orders');?>"></i><span><?php lang('Orders');?></span></a></li>
<?php	}
		if($user['rank']==1000||$user['options']{3}==1){?>
					<li<?php if($view=='media')echo' class="active"';?>><a href="<?php echo URL.'admin/media';?>"><i class="libre libre-picture" name="<?php lang('Media');?>"></i><span><?php lang('Media');?></span></a></li>
<?php	}?>
					<li<?php if($view=='messages')echo' class="active"';?>><a href="<?php echo URL.'admin/messages';?>"><i class="libre libre-mail" name="<?php lang('Messages');?>"></i><span><?php lang('Messages');?></span><a></li>
					<li<?php if($view=='accounts')echo' class="active"';?>><a href="<?php echo URL.'admin/accounts';?>"><i class="libre libre-users" name="<?php lang('Accounts');?>"></i><span><?php lang('Accounts');?></span></a></li>
					<li<?php if($view=='preferences')echo' class="active"';?>><a href="<?php echo URL.'admin/preferences';?>"><i class="libre libre-settings" name="<?php lang('Preferences');?>"></i><span><?php lang('Preferences');?></span></a></li>
<?php	if($user['rank']>899){?>
					<li<?php if($view=='activity')echo' class="active"';?>><a href="<?php echo URL.'admin/activity';?>"><i class="libre libre-activity" name="<?php lang('Activity');?>"></i><span><?php lang('Activity');?></span></a></li>
<?php	}?>
					<li<?php if($view=='search')echo' class="active"';?>><a href="<?php echo URL.'admin/search';?>"><i class="libre libre-search" name="<?php lang('Search');?>"></i><span><?php lang('Search');?></span></a></li>
				</ul>
			</div>
			<footer class="hidden-xs">
				<div class="brand"><img src="core/images/librecms.png" alt="LibreCMS"></div>
				<ul>
					<li><a href="<?php echo URL;?>admin/logout"><?php lang('Logout');?></a></li>
					<li><a href="<?php echo URL;?>"><?php lang('Front');?></a></li>
				</ul>
			</footer>
		</div>
		<main id="content">
<?php	if($view=='add'){
			if($args[0]=='bookings')
				require'core/layout/bookings.php';
			else
				require'core/layout/content.php';
		}else
			require'core/layout/'.$view.'.php';?>
		</main>
		<footer class="clearfix navbar navbar-default visible-xs">
			<span class="navbar-brand"><img src="core/images/librecms.png" alt="LibreCMS"></span>
			<ul class="nav navbar-nav pull-right">
				<li><a target="_blank" href="https://github.com/StudioJunkyard/LibreCMS"><small>GitHub</small></a></li>
				<li><a href="<?php echo URL;?>"><small><?php lang('Front');?></small></a></li>
			</ul>
		</footer>
		<div class="notifications center"></div>
		<script src="core/js/jquery-2.1.3.min.js"></script>
		<script src="core/js/bootstrap.min.js"></script>
		<script src="core/js/jquery.notifications.min.js"></script>
		<script src="core/js/featherlight.min.js"></script>
<?php 	if($user['rank']>399){
			if($view=='bookings'){
				if($user['layoutBookings']=='calendar'){?>
		<script src="core/js/moment.min.js"></script>
		<script src="core/js/fullcalendar.min.js"></script>
<?php			}
			}?>
		<script src="core/js/summernote.js"></script>
<?php /*		<script src="core/lang/summernote-<?php echo$config['language'];?>.js"></script> */ ?>
		<script src="core/js/bootstrap-datetimepicker.min.js"></script>
		<link href="core/css/cropper.min.css" rel="stylesheet">
		<script src="core/js/cropper.min.js"></script>
<?php		if($view=='pages'){?>
		<script src="core/js/sortable.min.js"></script>
<?php		}?>
		<script src="core/js/js.js"></script>
		<script>/*<![CDATA[*/
			$('#search').search_filter();
<?php		if($view=='pages'){?>
			$('#listtype').sortable({
				handle:'.handle',
				forcePlaceholderSize:true,
				placeholderClass:'sort-placeholder',
				items:':not(.disabled)',
				dragImage:$('.ghost')[0]
			}).bind('sortupdate',function(e,ui){
				var ord=$('#listtype').find('.item').map(function(){return $(this).data('id')}).get();
				var t=$('#listtype').data('t');
				var c=$('#listtype').data('c');
				$.ajax({
					type:"GET",
					url:"core/reorder.php",
					data:{
						t:t,
						c:c,
						ord:ord
					}
				})
			});
<?php		}
			if($config['options']{8}==1&&$config['gaClientID']!=''){?>
			(function(w,d,s,g,js,fs){g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f)}};js=d.createElement(s);fs=d.getElementsByTagName(s)[0];js.src='https://apis.google.com/js/platform.js';fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics')}}(window,document,'script'));
			gapi.analytics.ready(function(){
				gapi.analytics.auth.authorize({container:'auth-container',clientid:"<?php echo$config['gaClientID'];?>",userInfoLabel:''});
				gapi.analytics.auth.on('success',function(response){$('#auth-container').css({'display':'none'})});
				gapi.analytics.auth.on('error',function(response){$('#auth-container').css({'display':'block'});$('#auth-container').html("<?php lang('error','problem');?>")});
				var viewSelector=new gapi.analytics.ViewSelector({container:'view-selector'});
				viewSelector.execute();
				var sessions=new gapi.analytics.googleCharts.DataChart({
					query:{metrics:'ga:sessions',dimensions:'ga:date','start-date':'30daysAgo','end-date':'today'},
					chart:{container:'sessions',type:'LINE',options:{width:'100%'}}
				});
				var sessionbycountry=new gapi.analytics.googleCharts.DataChart({
					query:{metrics:'ga:sessions',dimensions:'ga:country','start-date':'30daysAgo','end-date':'today','max-results':6,sort:'-ga:sessions'},
					chart:{container:'sessionbycountry',type:'GEO',options:{width:'100%'}}
				});
				var topbrowsers=new gapi.analytics.googleCharts.DataChart({
					query:{'dimensions':'ga:browser','metrics':'ga:sessions','sort':'-ga:sessions','start-date':'30daysAgo','end-date':'today','max-results':'6'},
					chart:{type:'TABLE',container:'topbrowsers',options:{width:'100%'}}
				});
				var trafficsources=new gapi.analytics.googleCharts.DataChart({
					query:{'dimensions':'ga:fullReferrer,ga:source','metrics':'ga:sessions','sort':'-ga:sessions','start-date':'30daysAgo','end-date':'today','max-results':'50'},
					chart:{type:'TABLE',container:'trafficsources',options:{width:'100%'}}
				});
				var userflow=new gapi.analytics.googleCharts.DataChart({
					query:{'dimensions':'ga:landingPagePath,ga:secondPagePath,ga:nextPagePath','metrics':'ga:pageviews,ga:timeOnPage,ga:sessions','sort':'-ga:sessions','start-date':'30daysAgo','end-date':'today','max-results':'50'},
					chart:{type:'TABLE',container:'userflow',options:{width:'100%'}}
				});
				viewSelector.on('change',function(ids){sessions.set({query:{ids:ids}}).execute();sessionbycountry.set({query:{ids:ids}}).execute();topbrowsers.set({query:{ids:ids}}).execute();trafficsources.set({query:{ids:ids}}).execute();userflow.set({query:{ids:ids}}).execute();
				});
			});
<?php		}?>
			$(document).ready(function(){
				$(document).on("hidden.bs.modal",function (e){
					$(e.target).removeData("bs.modal").find(".modal-content").empty()
				});
				$(".summernote").summernote({
//					lang:'<?php echo$user["language"];?>'
				});
				$("#tis").datetimepicker({format:"yy-mm-dd hh:ii"});
				$("#tie").datetimepicker({format:"yy-mm-dd hh:ii"});
<?php		if($config['options']{4}==1){?>
				$('[data-toggle="tooltip"]').tooltip({
					container:'body',
					title:"<?php lang('tooltip','nulltitle');?>"
				});
<?php		}
			if($config['options']{5}==1){?>
				$('[data-toggle="popover"]').popover({
					placement:'top',
					html:'true',
					container:'body',
					title:"<?php lang('popover','nulltitle');?>",
					content:"<?php lang('popover','nullcontent');?>"
				});
<?php		}
			if($view=='preferences'){?>
				$("div.theme-chooser").not(".disabled").find("div.theme-chooser-item").on("click",function(){
					$('#theme .theme-chooser-item').removeClass("panel-success");
					$(this).addClass("panel-success");
					update("1","config","theme",escape($(this).attr("data-theme")))
				});
<?php		}
    		if($view=='bookings'&&$user['layoutBookings']=='calendar'){?>
				$('#calendar').fullCalendar({
					header:{
						left:'prev,next',
						center:'title',
						right:'month,basicWeek,basicDay'
					},
					eventLimit:true,
					selectable:true,
					editable:false,
					events:[
<?php			$s=$db->query("SELECT * FROM content WHERE contentType='booking'");
				while($r=$s->fetch(PDO::FETCH_ASSOC)){
					$bs=$db->prepare("SELECT contentType,title,tis,tie,ti FROM content WHERE id=:id");
					$bs->execute(array(':id'=>$r['rid']));
					$br=$bs->fetch(PDO::FETCH_ASSOC);?>
						{
							id:'<?php echo$r['id'];?>',
							title:'<?php if($br['contentType']=='events'){lang('Event');?>: <?php echo$br['title'];}else{echo ucfirst(rtrim($br['contentType'],'s')).': '.$br['title'];}?>',
							start:'<?php if($br['contentType']=='events'){echo date("Y-m-d H:i:s",$r['ti']);}else{echo date("Y-m-d H:i:s",$r['tis']);}?>',
<?php				if($br['contentType']=='services'){
						if($r['tie']>$r['tis']){
                    echo lang('End').':\''.date("Y-m-d H:i:s",$r['tie']).'\',';
                		}
					}?>
							allDay:false,
							color:'<?php if($r['status']=='confirmed'){echo'#5cb85c';}else{echo'#d9534f';}?>',
							description:'<?php if($r['business']){echo lang('Business').': '.$r['business'].'<br>';}
					if($r['name']){echo lang('Name').': '.$r['name'].'<br>';}
					if($r['email']){echo lang('Email').': <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>';}
					if($r['phone']){echo lang('Phone').': '.$r['phone'].'<br>';}?>',
							status:'<?php echo$r['status'];?>',
						},
<?php			}?>
						],
						eventMouseover:function(event,domEvent,view){
							var layer='<div id="events-layer" class="fc-transparent">';
							if(event.status=="unconfirmed")layer+='<span id="cbut'+event.id+'" class="btn btn-success btn-xs"><i class="libre libre-approve"></i></span> ';
							layer+='<span id="edbut'+event.id+'" class="btn btn-info btn-xs"><i class="libre libre-edit"></i></span> <span id="delbut'+event.id+'" class="btn btn-danger btn-xs"><i class="libre libre-trash"></i></span></div>';
							var content='<?php lang('Start');?>: '+$.fullCalendar.moment(event.start).format('HH:mm');
							if(event.end>event.start)content+='<br><?php lang('End');?>: '+$.fullCalendar.moment(event.end).format('HH:mm');
							if(event.description!='')content+='<br>'+event.description;
							$(this).append(layer);
							var el=$(this);
							$("#cbut"+event.id).click(function(){
								$("#cbut"+event.id).remove();
								$("#events-layer").remove();
								event.color="#5cb85c";
								event.status="confirmed";
								update(event.id,"content","status","confirmed");
								$("#calendar").fullCalendar("updateEvent",event);
							});
							$("#delbut"+event.id).click(function(){
								window.top.window.purge(event.id,"content");
								window.top.window.$(el).remove();
								window.top.window.$(".popover").remove();
							});
							$("#edbut"+event.id).click(function(){
								window.location='admin/bookings/edit/'+event.id;
							});
							$(this).popover({
								title:event.title,
								placement:"top",
								html:true,
								container:"body",
								content:content,
							}).popover("show")
						},
						eventMouseout:function(event){
							$("#events-layer").remove();
							$(this).not(event).popover("hide")
						},
						dayClick:function(date,jsEvent,view){
							if(view.name=='month'||view.name=='basicWeek'){
								$('#calendar').fullCalendar('changeView','basicDay');
								$('#calendar').fullCalendar('gotoDate',date);
							}
						}
					});
<?php 		}
			if($config['idleTime']!=0){?>
					idleTimer=null;
					idleState=false;
					idleWait=<?php echo$config['idleTime']*60000;?>;
					(function($){
						$(document).ready(function(){
							$('*').bind('mousemove keydown scroll',function(){
								clearTimeout(idleTimer);
								idleState=false;
								idleTimer=setTimeout(function(){
								var newUrl="<?php echo URL.'admin/logout';?>";
								document.location.href=newUrl;
								idleState=true},idleWait);
							});
							$("body").trigger("mousemove");
						});
					})(jQuery)
<?php		}?>
				window.addEventListener("keydown",function(e){
				    if(e.keyCode===114||(e.ctrlKey&&e.keyCode===70)){
						$('#search').css({'display':'block'});
						e.preventDefault();
				    }
					if(e.keyCode===27)$('#search').css({'display':'none'})
				})
				$('#searchclose').click(function(e){
					$('#search').css({'display':'none'});
					e.preventDefault();
				})
			});
		/*]]>*/</script>
		<div class="modal fade bookings">
			<div class="modal-dialog modal-lg">
				<div class="modal-content"></div>
			</div>
		</div>
		<div id="seo" class="modal fade seo">
			<div class="modal-dialog">
				<div class="modal-content"></div>
			</div>
		</div>
		<div id="media" class="modal fade media">
			<div class="modal-dialog modal-lg">
				<div class="modal-content" style="max-height:85%"></div>
			</div>
		</div>
		<div id="search">
			<form class="form-inline search col-xs-12 col-xs-offset-1 col-md-12 col-md-offset-1" method="post" action="admin/search">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><?php lang('button','search');?></div>
						<div class="input-group-btn">
							<select class="form-control" name="what">
								<option value="content"<?php if(isset($what)&&$what=='content')echo' selected';?>><?php lang('Content');?></option>
								<option value="comments"<?php if(isset($what)&&$what=='comments')echo' selected';?>><?php lang('Comments');?></option>
								<option value="messages"<?php if(isset($what)&&$what=='messages')echo' selected';?>><?php lang('Messages');?></option>
								<option value="orders"<?php if(isset($what)&&$what=='orders')echo' selected';?>><?php lang('Orders');?></option>
								<option value="pages"<?php if(isset($what)&&$what=='pages')echo' selected';?>><?php lang('Pages');?></option>
							</select>
						</div>
						<div class="input-group-addon"><?php lang('for');?></div>
						<input type="text" class="form-control" name="search" value="<?php if(isset($search)){echo trim($search);}?>" placeholder="<?php lang('placeholder','search');?>">
						<div class="input-group-btn">
							<select class="form-control" name="status">
								<option value="all"<?php if(isset($status)&&$status=='all')echo' selected';?>><?php lang('search','all');?></option>
								<option value="published"<?php if(isset($status)&&$status=='published')echo' selected';?>><?php lang('search','published');?></option>
								<option value="unpublished"<?php if(isset($status)&&$status=='unpublished')echo' selected';?>><?php lang('search','unpublished');?></option>
							</select>
						</div>
						<div class="input-group-addon"><?php lang('and');?></div>
						<div class="input-group-btn">
							<select class="form-control" name="ord">
								<option value="desc"<?php if(isset($ord)&&$ord=='desc')echo' selected';?>><?php lang('search','desc');?></option>
								<option value="asc"<?php if(isset($ord)&&$ord=='asc')echo' selected';?>><?php lang('search','asc');?></option>
							</select>
						</div>
						<div class="input-group-btn">
							<button class="btn btn-success"><i class="libre libre-search visible-xs"></i><span class="hidden-xs"><?php lang('button','search');?></span></button>
						</div>
					</div>
				</div>
			</form>
		</div>
<?php	}?>
		<iframe id="sp" name="sp" class="hidden"></iframe>
		<div id="block"><i class="libre libre-spinner-1 libre-5x libre-spin"></i></div>
	</body>
</html>
<?php }else require'core/layout/login.php';
