<div class="notifications center"></div>
<script src="core/js/jquery-2.1.3.min.js"></script>
<script src="core/js/bootstrap.min.js"></script>
<script src="core/js/jquery.notifications.min.js"></script>
<script src="core/js/featherlight.min.js"></script>
<script src="core/js/stupidtable.js"></script>
<?php if($user['rank']>399){
	if($view=='bookings'){
		if($config['layoutBookings']=='calendar'){?>
<script src="core/js/moment.min.js"></script>
<script src="core/js/fullcalendar.min.js"></script>
<?php }
}?>
<script src="core/js/summernote.js"></script>
<script src="core/js/bootstrap-datetimepicker.min.js"></script>
<link href="core/css/cropper.min.css" rel="stylesheet">
<script src="core/js/cropper.min.js"></script>
<script src="core/js/js.js"></script>
<script>/*<![CDATA[*/
<?php if($config['options']{8}==1&&$config['gaClientID']!=''){?>
	(function(w,d,s,g,js,fs){g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f)}};js=d.createElement(s);fs=d.getElementsByTagName(s)[0];js.src='https://apis.google.com/js/platform.js';fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics')}}(window,document,'script'));
	gapi.analytics.ready(function(){
		gapi.analytics.auth.authorize({
			container:'auth-container',
			clientid:"<?php echo$config['gaClientID'];?>",
			userInfoLabel:''
		});
		gapi.analytics.auth.on('success', function(response) {
			$('#auth-container').css({'display':'none'});
		});
		gapi.analytics.auth.on('error', function(response) {
			$('#auth-container').css({'display':'block'});
			$('#auth-container').html('There was a problem!');
		});
		var viewSelector = new gapi.analytics.ViewSelector({
			container:'view-selector'
		});
		viewSelector.execute();
		var sessions=new gapi.analytics.googleCharts.DataChart({
			query:{
				metrics:'ga:sessions',
				dimensions:'ga:date',
				'start-date':'30daysAgo',
				'end-date':'today'
			},
			chart:{
				container:'sessions',
				type:'LINE',
				options:{
					width:'100%'
				}
			}
		});
		var sessionbycountry=new gapi.analytics.googleCharts.DataChart({
			query:{
				metrics:'ga:sessions',
				dimensions:'ga:country',
				'start-date':'30daysAgo',
				'end-date':'today',
				'max-results':6,
				sort:'-ga:sessions'
			},
			chart:{
				container:'sessionbycountry',
				type:'GEO',
				options:{
					width:'100%'
				}
			}
		});
		var topbrowsers=new gapi.analytics.googleCharts.DataChart({
			query:{
				'dimensions':'ga:browser',
				'metrics':'ga:sessions',
				'sort':'-ga:sessions',
				'start-date':'30daysAgo',
				'end-date':'today',
				'max-results':'6'
			},
			chart:{
				type:'TABLE',
				container:'topbrowsers',
				options:{
					width:'100%'
				}
			}
		});
		var trafficsources=new gapi.analytics.googleCharts.DataChart({
			query:{
				'dimensions':'ga:fullReferrer,ga:source',
				'metrics':'ga:sessions',
				'sort':'-ga:sessions',
				'start-date':'30daysAgo',
				'end-date':'today',
				'max-results':'50'
			},
			chart:{
				type:'TABLE',
				container:'trafficsources',
				options:{
					width:'100%'
				}
			}
		});
		var userflow=new gapi.analytics.googleCharts.DataChart({
			query:{
				'dimensions':'ga:landingPagePath,ga:secondPagePath,ga:nextPagePath',
				'metrics':'ga:pageviews,ga:timeOnPage,ga:sessions',
				'sort':'-ga:sessions',
				'start-date':'30daysAgo',
				'end-date':'today',
				'max-results':'50'
			},
			chart:{
				type:'TABLE',
				container:'userflow',
				options:{
					width:'100%'
				}
			}
		});
		viewSelector.on('change',function(ids){
  			sessions.set({query:{ids:ids}}).execute();
			sessionbycountry.set({query:{ids:ids}}).execute();
			topbrowsers.set({query:{ids:ids}}).execute();
			trafficsources.set({query:{ids:ids}}).execute();
			userflow.set({query:{ids:ids}}).execute();
		});
	});
<?php }?>
	$(document).ready(function(){
		$(document).on("hidden.bs.modal",function (e){
			$(e.target).removeData("bs.modal").find(".modal-content").empty()
		});
		$(".summernote").summernote();
		$("#tis").datetimepicker({format:"yy-mm-dd hh:ii"});
		$("#tie").datetimepicker({format:"yy-mm-dd hh:ii"});
		$("#stupidtable").stupidtable();
		$(function(){
			var date_from_string=function(str){
				var months=["jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec"];
				var pattern="^([a-zA-Z]{3})\\s*(\\d{2}),\\s*(\\d{4})$";
				var re=new RegExp(pattern);
				var DateParts=re.exec(str).slice(1);
				var Year=DateParts[2];
				var Month=$.inArray(DateParts[0].toLowerCase(),months);
				var Day=DateParts[1];
				return new Date(Year,Month,Day);
			}
			var moveBlanks=function(a,b){
				if(a<b){
					if(a=="")return 1;else return -1;
				}
				if ( a > b ){
					if (b == "")
						return -1;
					else
						return 1;
				}
				return 0;
			};
			var moveBlanksDesc = function(a, b) {
				if ( a < b )return 1;
				if ( a > b )return -1;
				return 0;
			};
			var table = $("table").stupidtable({
				"date":function(a,b){
					aDate = date_from_string(a);
					bDate = date_from_string(b);
					return aDate - bDate;
				},
				"moveBlanks": moveBlanks,
				"moveBlanksDesc": moveBlanksDesc,
			});
			table.on("beforetablesort", function (event, data) {
				$("#msg").text("Sorting index " + data.column)
			});
			table.on("aftertablesort", function (event, data) {
				var th = $(this).find("th");
				th.find(".arrow").remove();
				var dir = $.fn.stupidtable.dir;
				var arrow = data.direction === dir.ASC ? "sort-asc" : "sort-desc";
				th.eq(data.column).append('<i class="arrow libre libre-'+arrow+' pull-right"></i>');
			});
			$("tr").slice(1).click(function(){
				$(".awesome").removeClass("awesome");
				$(this).addClass("awesome");
			});
		});
<?php	if($config['options']{4}==1){?>
		$('[data-toggle="tooltip"]').tooltip({
			placement:'top',
			container:'body',
			title:'Working on the Tooltip Content'
		});
<?php	}
		if($config['options']{5}==1){?>
		$('[data-toggle="popover"]').popover({
			placement:'top',
			html:'true',
			container:'body',
			title:'Working on a Title',
			content:'Working on the Content'
		});
<?php	}
		if($view=='preferences'){?>
		$("div.theme-chooser").not(".disabled").find("div.theme-chooser-item").on("click",function(){
			$(this).parent().parent().find("div.theme-chooser-item").removeClass("selected");
			$(this).addClass("selected");
			update("1","config","theme",escape($(this).attr("data-theme")))
		});
<?php	}
    if($view=='bookings'&&$config['layoutBookings']=='calendar'){?>
		$('#calendar').fullCalendar({
			header:{
				left:'prev,next',
				center:'title',
				right:'month,basicWeek,basicDay'
			},
			eventLimit: true,
			selectable: true,
			editable: false,
			events:[
<?php	$s=$db->query("SELECT * FROM content WHERE contentType='booking'");
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$bs=$db->prepare("SELECT contentType,title,tis,tie,ti FROM content WHERE id=:id");
			$bs->execute(array(':id'=>$r['rid']));
			$br=$bs->fetch(PDO::FETCH_ASSOC);?>
				{
					id:'<?php echo$r['id'];?>',
					title:'<?php if($br['contentType']=='events'){?>Event: <?php echo$br['title'];}else{echo ucfirst(rtrim($br['contentType'],'s')).': '.$br['title'];}?>',
					start:'<?php if($br['contentType']=='events'){echo date("Y-m-d H:i:s",$r['ti']);}else{echo date("Y-m-d H:i:s",$r['tis']);}?>',
<?php		if($br['contentType']=='services'){
				if($r['tie']>$r['tis']){
                    echo'end:\''.date("Y-m-d H:i:s",$r['tie']).'\',';
                }
			}?>
					allDay:false,
					color:'<?php if($r['status']=='confirmed'){echo'#5cb85c';}else{echo'#d9534f';}?>',
					description:'<?php if($r['business']){echo'Business: '.$r['business'].'<br>';}
			if($r['name']){echo'Name: '.$r['name'].'<br>';}
			if($r['email']){echo'Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>';}
			if($r['phone']){echo'Phone: '.$r['phone'].'<br>';}?>',
					status:'<?php echo$r['status'];?>',
				},
<?php	}?>
				],
				eventMouseover:function(event,domEvent,view){
					var layer='<div id="events-layer" class="fc-transparent">';
					if(event.status=="unconfirmed"){
						layer+='<span id="cbut'+event.id+'" class="btn btn-default btn-xs color-success"><i class="libre libre-approve"></i></span> ';
					}
					layer+='<span id="edbut'+event.id+'" class="btn btn-default btn-xs"><i class="libre libre-edit"></i></span> <span id="delbut'+event.id+'" class="btn btn-default btn-xs color-danger"><i class="libre libre-trash"></i></span></div>';
					var content='Start: '+$.fullCalendar.moment(event.start).format('HH:mm');
					if(event.end>event.start){
						content+='<br>End: '+$.fullCalendar.moment(event.end).format('HH:mm');
					}
					if(event.description!=''){
						content+='<br>'+event.description;
					}
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
						$.get("core/booking.php?id="+event.id,function(data){
							$(".bookings").find(".modal-content").html(data);
						})
						$(".summernote2").destroy();
						$(".bookings").modal("toggle");
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
				dayClick: function(date, jsEvent, view) {
					if(view.name == 'month' || view.name == 'basicWeek') {
						$('#calendar').fullCalendar('changeView', 'basicDay');
						$('#calendar').fullCalendar('gotoDate', date);      
					}
				}
			});
<?php }?>
	});
/*]]>*/</script>
<div class="modal fade bookings">
	<div class="modal-dialog modal-lg">
		<div class="modal-content"></div>
	</div>
</div>
<div id="seo" class="modal fade seo">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
<div id="media" class="modal fade media">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="max-height:85%">
		</div>
	</div>
</div>
<?php }?>
<iframe id="sp" name="sp" class="hidden"></iframe>
<div id="block"><i class="libre libre-spinner-12 libre-5x libre-spin"></i></div>
</body></html>
