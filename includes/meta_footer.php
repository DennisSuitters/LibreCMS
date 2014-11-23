<?php
if($config['options']{2}==1){
	require'widgets/index/modal_login.php';
}?>
		<div class='notifications center'></div>
		<script src="includes/js/jquery-2.1.1.min.js"></script>
		<script src="includes/js/bootstrap.min.js"></script>
		<script src="includes/js/jquery.notifications.min.js"></script>
		<script src="includes/js/masonry.pkgd.min.js"></script>
		<script src="includes/js/intense.min.js"></script>
		<script>/*<![CDATA[*/
			window.onload=function(){
				Intense(document.querySelectorAll('.intense'));
			}
		/*]]>*/</script>
<?php if($user['rank']>99){
	if($view=='bookings'){?>
		<script src="includes/js/moment.min.js"></script>
		<script src="includes/js/fullcalendar.min.js"></script>
<?php }?>
		<script src="includes/js/summernote.js"></script>
		<script src="includes/js/bootstrap-datetimepicker.min.js"></script>
		<script src="includes/js/js.js"></script>
		<script>/*<![CDATA[*/
			$(document).ready(function(){
				$('.summernote').summernote();
				$('#tis').datetimepicker({format:'yy-mm-dd hh:ii'});
				$('#tie').datetimepicker({format:'yy-mm-dd hh:ii'});
				$('#seodrop').click(function(){
					$("#seocontent").toggle(function(){
						$("#seocontent").animate({height:0},200);
					},function(){
						$("#seocontent").animate({height:600},200);
					});
					return false;
				});
<?php if($view=='preferences'){?>
				$('div.theme-chooser').not('.disabled').find('div.theme-chooser-item').on('click',function(){
					$(this).parent().parent().find('div.theme-chooser-item').removeClass('selected');
					$(this).addClass('selected');
					update('1','config','theme',escape($(this).attr('data-theme')));
				});
<?php }
    if($view=='bookings'){?>
				$('#calendar').fullCalendar({
					header:{left:'prev,next',
					center:'title',
					right:'month,basicWeek,basicDay'},
					editable:false,
					events:[
<?php	$s=$db->query("SELECT * FROM content WHERE contentType='booking'");
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$bs=$db->prepare("SELECT contentType,title,tis,tie,ti FROM content WHERE id=:id");
			$bs->execute(array(':id'=>$r['rid']));
			$br=$bs->fetch(PDO::FETCH_ASSOC);?>
						{
							id:<?php echo$r['id'];?>,
							title:'<?php if($br['contentType']=='events'){echo'Event: ',$br['title'];}else{echo ucfirst(rtrim($br['contentType'],'s')).': '.$br['title'];}?>',
							start:'<?php if($br['contentType']=='events'){echo date("Y-m-d H:i:s",$r['ti']);}else{echo date("Y-m-d H:i:s",$r['tis']);}?>',
<?php		if($br['contentType']=='services'){
				if($r['tie']>$r['tis']){?>
							end:'<?php echo date("Y-m-d H:i:s",$r['tie']);?>',
<?php			}
			}?>
			 				allDay:false,
							color:<?php if($r['status']=='confirmed'){?>'#0c0'<?php }else{?>'#c00'<?php }?>,
							description:'<?php if($r['business']){echo'Business: '.$r['business'].'<br>';}
		if($r['name']){echo'Name: '.$r['name'].'<br>';}
		if($r['email']){echo'Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>';}
		if($r['phone']){echo'Phone: '.$r['phone'].'<br>';}?>',
							status:'<?php echo$r['status'];?>',
						},
<?php	}?>
					],
					timeFormat:'H(:mm)',
					eventMouseover:function(event,domEvent){
						var layer='<div id="events-layer" class="fc-transparent">';
						if(event.status=='unconfirmed'){
							layer+='<span id="cbut'+event.id+'" class="btn btn-success btn-xs"><i class="fa fa-check"></i></span> ';
						}
						layer+='<span id="edbut'+event.id+'" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></span> <span id="delbut'+event.id+'" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span></div>';
						var content='Start:'+$.fullCalendar.formatDate(event.start,"dS MMM, yyyy 'at' HH:mm");
						if(event.end>event.start){
							content+='<br>End:'+$.fullCalendar.formatDate(event.end,"dS MMM, yyyy at HH:mm")
						}
						if(event.description!=''){
							content+='<br>'+event.description
						}
						$(this).append(layer);
						var el=$(this);
						$("#cbut"+event.id).click(function(){
							$('#cbut'+event.id).remove();
							$("#events-layer").remove();
							event.color='#0c0';
							event.status='confirmed';
							update(event.id,'content','status','confirmed');
							$('#calendar').fullCalendar('updateEvent',event);
						});
						$("#delbut"+event.id).click(function(){
							window.top.window.purge(event.id,'content');
							window.top.window.$(el).remove();
							window.top.window.$('.popover').remove()
						});
						$("#edbut"+event.id).click(function(){
							$('.bookings').modal('toggle')
							$.get("includes/booking.php?id="+event.id, function(data){
								$('.bookings').find('.modal-content').html(data);
							})
						});
						$(this).popover({
							title:event.title,
							placement:'top',
							html:true,
							container:'body',
							content:content,
						}).popover('show')
					},
					eventMouseout:function(event){
						$("#events-layer").remove();
						$(this).not(event).popover('hide')
					},
				});
<?php }?>
			});
		/*]]>*/</script>
		<iframe id="sp" name="sp" class="hidden"></iframe>
		<div id="block"><i class="fa fa-cog fa-5x fa-spin hidden"></i></div>
		<div class="modal fade bookings">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
				</div>
			</div>
		</div>
<?php }else{
	if($view=='bookings'||$view=='contactus'||$view=='cart'){?>
		<iframe id="sp" name="sp" class="hidden"></iframe>
<?php	if($view=='contactus'){?>
		<script src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
		<script src="includes/js/mapsed.js"></script>
		<script>/*<![CDATA[*/
<?php		if($config['geoLocation']!=''){
				$geoloc=explode(',',$config['geoLocation']);?>
			$("#map").mapsed({
				showOnLoad:[{
					autoShow:false,
					canEdit:false,
					lat:<?php echo$geoloc[0];?>,
					lng:<?php echo$geoloc[1];?>
<?php 			if($config['geoReference']!=''){?>
					reference:'<?php echo$config['geoReference'];?>'
<?php			}?>
				}]
			});
<?php 		}?>
		/*]]>*/</script>
<?php	}
	}
}
if($config['options']{6}==1&&$config['seoGoogleTracking']!=''&&$config['seoGoogleDomain']!=''){?>
		<script>/*<![CDATA[*/
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create','<?php echo$config['seoGoogleTracking'];?>','<?php echo$config['seoGoogleDomain'];?>');ga('send','pageview');
		/*]]>*/</script>
<?php }?>
	</body>
</html>
