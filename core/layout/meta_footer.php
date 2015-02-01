		<div class="notifications center"></div>
		<script src="core/js/jquery-2.1.3.min.js"></script>
		<script src="core/js/bootstrap.min.js"></script>
		<script src="core/js/jquery.notifications.min.js"></script>
		<script src="core/js/featherlight.min.js"></script>
<?php if($user['rank']>399){
	if($view=='bookings'){?>
		<script src="core/js/moment.min.js"></script>
		<script src="core/js/fullcalendar.min.js"></script>
<?php }?>
		<script src="core/js/summernote.js"></script>
		<script src="core/js/bootstrap-datetimepicker.min.js"></script>
		<script src="core/js/jquery.simplecolorpicker.js"></script>
		<script src="core/js/js.js"></script>
		<script>/*<![CDATA[*/
			$(document).ready(function(){
				$(document).on("hidden.bs.modal", function (e) {
    				$(e.target).removeData("bs.modal").find(".modal-content").empty();
				});
				$(".summernote").summernote();
				$("#backgroundColor").simplecolorpicker();
				$("#tis").datetimepicker({format:"yy-mm-dd hh:ii"});
				$("#tie").datetimepicker({format:"yy-mm-dd hh:ii"});
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
    if($view=='bookings'){?>
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
<?php       $s=$db->query("SELECT * FROM content WHERE contentType='booking'");
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
					color:'<?php if($r['status']=='confirmed'){echo'#0c0';}else{echo'#c00';}?>',
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
						layer+='<span id="cbut'+event.id+'" class="btn btn-success btn-xs"><i class="fa fa-check"></i></span> ';
					}
					layer+='<span id="edbut'+event.id+'" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></span> <span id="delbut'+event.id+'" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span></div>';
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
						event.color="#0c0";
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
<?php }?>
		<iframe id="sp" name="sp" class="hidden"></iframe>
		<div id="block"><i class="fa fa-cog fa-5x fa-spin hidden"></i></div>
	</body>
</html>
