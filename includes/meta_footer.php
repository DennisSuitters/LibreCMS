<?php
$foot.='<div class="notifications center"></div>';
$foot.='<script src="includes/js/jquery-2.1.1.min.js"></script>';
$foot.='<script src="includes/js/bootstrap.min.js"></script>';
$foot.='<script src="includes/js/jquery.notifications.min.js"></script>';
$foot.='<script src="includes/js/masonry.pkgd.min.js"></script>';
$foot.='<script src="includes/js/intense.min.js"></script>';
$foot.='<script>/*<![CDATA[*/ window.onload=function(){Intense(document.querySelectorAll(".intense"));} /*]]>*/</script>';
if($user['rank']>99){
	if($view=='bookings'){
		$foot.='<script src="includes/js/moment.min.js"></script>';
        $foot.='<script src="includes/js/fullcalendar.min.js"></script>';
    }
	$foot.='<script src="includes/js/summernote.js"></script>';
    $foot.='<script src="includes/js/bootstrap-datetimepicker.min.js"></script>';
    $foot.='<script src="includes/js/js.js"></script>';
    $foot.='<script>/*<![CDATA[*/ ';
	$foot.='$(document).ready(function(){';
    $foot.='$(".summernote").summernote();';
    $foot.='$("#tis").datetimepicker({format:"yy-mm-dd hh:ii"});';
    $foot.='$("#tie").datetimepicker({format:"yy-mm-dd hh:ii"});';
    $foot.='$("#seodrop").click(function(){$("#seocontent").toggle(function(){$("#seocontent").animate({height:0},200)},function(){$("#seocontent").animate({height:600},200)});return false});';
    if($view=='preferences'){
        $foot.='$("div.theme-chooser").not(".disabled").find("div.theme-chooser-item").on("click",function(){$(this).parent().parent().find("div.theme-chooser-item").removeClass("selected");$(this).addClass("selected");update("1","config","theme",escape($(this).attr("data-theme")))});';
    }
    if($view=='bookings'){
        $foot.='$(\'#calendar\').fullCalendar({';
        $foot.='header:{left:\'prev,next\',';
        $foot.='center:\'title\',';
        $foot.='right:\'month,basicWeek,basicDay\'},';
        $foot.='editable:false,';
        $foot.='events:[';
        $s=$db->query("SELECT * FROM content WHERE contentType='booking'");
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$bs=$db->prepare("SELECT contentType,title,tis,tie,ti FROM content WHERE id=:id");
			$bs->execute(array(':id'=>$r['rid']));
			$br=$bs->fetch(PDO::FETCH_ASSOC);
            $foot.='{';
            $foot.='id:'.$r['id'].',';
            $foot.='title:\'';
            if($br['contentType']=='events'){
                $foot.='Event: '.$br['title'];
            }else{
                $foot.=ucfirst(rtrim($br['contentType'],'s')).': '.$br['title'];
            }
            $foot.='\',';
            $foot.='start:\'';if($br['contentType']=='events'){$foot.=date("Y-m-d H:i:s",$r['ti']);}else{$foot.=date("Y-m-d H:i:s",$r['tis']);}$foot.='\',';
            if($br['contentType']=='services'){
				if($r['tie']>$r['tis']){
                    $foot.='end:\''.date("Y-m-d H:i:s",$r['tie']).'\',';
                }
			}
            $foot.='allDay:false,';
            $foot.='color:';if($r['status']=='confirmed'){$foot.='\'#0c0\'';}else{$foot.='\'#c00\'';}$foot.=',';
            $foot.='description:\'';if($r['business']){$foot.='Business: '.$r['business'].'<br>';}
            if($r['name']){$foot.='Name: '.$r['name'].'<br>';}
            if($r['email']){$foot.='Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>';}
            if($r['phone']){$foot.='Phone: '.$r['phone'].'<br>';}$foot.='\',';
            $foot.='status:\''.$r['status'].'\',';
            $foot.='},';
        }
            $foot.='],';
            $foot.='timeFormat:\'H(:mm)\',';
            $foot.='eventMouseover:function(event,domEvent){';
            $foot.='var layer=\'<div id="events-layer" class="fc-transparent">\';';
            $foot.='if(event.status=="unconfirmed"){';
            $foot.='layer+=\'<span id="cbut\'+event.id+\'" class="btn btn-success btn-xs"><i class="fa fa-check"></i></span> \';';
            $foot.='}';
            $foot.='layer+=\'<span id="edbut\'+event.id+\'" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></span> <span id="delbut\'+event.id+\'" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span></div>\';';
            $foot.='var content=\'Start:\'+$.fullCalendar.formatDate(event.start,\'dS MMM, yyyy at HH:mm\');';
            $foot.='if(event.end>event.start){';
            $foot.='content+=\'<br>End:\'+$.fullCalendar.formatDate(event.end,\'dS MMM, yyyy at HH:mm\');';
            $foot.='}';
            $foot.='if(event.description!=\'\'){';
            $foot.='content+=\'<br>\'+event.description;';
            $foot.='}';
            $foot.='$(this).append(layer);';
            $foot.='var el=$(this);';
            $foot.='$("#cbut"+event.id).click(function(){';
            $foot.='$("#cbut"+event.id).remove();';
            $foot.='$("#events-layer").remove();';
            $foot.='event.color="#0c0";';
            $foot.='event.status="confirmed";';
            $foot.='update(event.id,"content","status","confirmed");';
            $foot.='$("#calendar").fullCalendar("updateEvent",event);';
            $foot.='});';
            $foot.='$("#delbut"+event.id).click(function(){';
            $foot.='window.top.window.purge(event.id,"content");';
            $foot.='window.top.window.$(el).remove();';
            $foot.='window.top.window.$(".popover").remove();';
            $foot.='});';
            $foot.='$("#edbut"+event.id).click(function(){';
            $foot.='$(".bookings").modal("toggle");';
            $foot.='$.get("includes/booking.php?id="+event.id,function(data){';
            $foot.='$(".bookings").find(".modal-content").html(data);';
            $foot.='})';
            $foot.='});';
            $foot.='$(this).popover({';
            $foot.='title:event.title,';
            $foot.='placement:"top",';
            $foot.='html:true,';
            $foot.='container:"body",';
            $foot.='content:content,';
            $foot.='}).popover("show")';
            $foot.='},';
            $foot.='eventMouseout:function(event){';
            $foot.='$("#events-layer").remove();';
            $foot.='$(this).not(event).popover("hide")';
            $foot.='},';
            $foot.='});';
    }
        $foot.='});';
		$foot.='/*]]>*/</script>';
		$foot.='<iframe id="sp" name="sp" class="hidden"></iframe>';
		$foot.='<div id="block"><i class="fa fa-cog fa-5x fa-spin hidden"></i></div>';
		$foot.='<div class="modal fade bookings">';
			$foot.='<div class="modal-dialog modal-lg">';
				$foot.='<div class="modal-content">';
				$foot.='</div>';
			$foot.='</div>';
		$foot.='</div>';
    }else{
        if($view=='bookings'||$view=='contactus'||$view=='cart'){
		$foot.='<iframe id="sp" name="sp" class="hidden"></iframe>';
        }
    }
	$foot.='</body>';
$foot.='</html>';
