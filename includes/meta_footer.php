<?php
$foot.='<div class="notifications center"></div><script src="includes/js/jquery-2.1.1.min.js"></script><script src="includes/js/bootstrap.min.js"></script><script src="includes/js/jquery.notifications.min.js"></script><script src="includes/js/masonry.pkgd.min.js"></script><script src="includes/js/intense.min.js"></script><script>/*<![CDATA[*/ window.onload=function(){Intense(document.querySelectorAll(".intense"));} /*]]>*/</script>';
if($user['rank']>99){
	if($view=='bookings'){
		$foot.='<script src="includes/js/moment.min.js"></script><script src="includes/js/fullcalendar.min.js"></script>';
    }
	$foot.='<script src="includes/js/summernote.js"></script><script src="includes/js/bootstrap-datetimepicker.min.js"></script><script src="includes/js/js.js"></script><script>/*<![CDATA[*/$(document).ready(function(){$(".summernote").summernote();$("#tis").datetimepicker({format:"yy-mm-dd hh:ii"});$("#tie").datetimepicker({format:"yy-mm-dd hh:ii"});$("#seodrop").click(function(){$("#seocontent").toggle(function(){$("#seocontent").animate({height:0},200)},function(){$("#seocontent").animate({height:600},200)});return false});';
    if($view=='preferences'){
        $foot.='$("div.theme-chooser").not(".disabled").find("div.theme-chooser-item").on("click",function(){$(this).parent().parent().find("div.theme-chooser-item").removeClass("selected");$(this).addClass("selected");update("1","config","theme",escape($(this).attr("data-theme")))});';
    }
    if($view=='bookings'){
        $foot.='$(\'#calendar\').fullCalendar({header:{left:\'prev,next\',center:\'title\',right:\'month,basicWeek,basicDay\'},editable:false,events:[';
        $s=$db->query("SELECT * FROM content WHERE contentType='booking'");
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
			$bs=$db->prepare("SELECT contentType,title,tis,tie,ti FROM content WHERE id=:id");
			$bs->execute(array(':id'=>$r['rid']));
			$br=$bs->fetch(PDO::FETCH_ASSOC);
            $foot.='{id:'.$r['id'].',title:\'';
            if($br['contentType']=='events'){
                $foot.='Event: '.$br['title'];
            }else{
                $foot.=ucfirst(rtrim($br['contentType'],'s')).': '.$br['title'];
            }
            $foot.='\',start:\'';if($br['contentType']=='events'){$foot.=date("Y-m-d H:i:s",$r['ti']);}else{$foot.=date("Y-m-d H:i:s",$r['tis']);}$foot.='\',';
            if($br['contentType']=='services'){
				if($r['tie']>$r['tis']){
                    $foot.='end:\''.date("Y-m-d H:i:s",$r['tie']).'\',';
                }
			}
            $foot.='allDay:false,color:';if($r['status']=='confirmed'){$foot.='\'#0c0\'';}else{$foot.='\'#c00\'';}$foot.=',description:\'';if($r['business']){$foot.='Business: '.$r['business'].'<br>';}
            if($r['name']){$foot.='Name: '.$r['name'].'<br>';}
            if($r['email']){$foot.='Email: <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>';}
            if($r['phone']){$foot.='Phone: '.$r['phone'].'<br>';}
            $foot.='\',status:\''.$r['status'].'\',},';
        }
        $foot.='],timeFormat:\'H(:mm)\',eventMouseover:function(event,domEvent){var layer=\'<div id="events-layer" class="fc-transparent">\';if(event.status=="unconfirmed"){layer+=\'<span id="cbut\'+event.id+\'" class="btn btn-success btn-xs"><i class="fa fa-check"></i></span> \';}layer+=\'<span id="edbut\'+event.id+\'" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></span> <span id="delbut\'+event.id+\'" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span></div>\';var content=\'Start:\'+$.fullCalendar.formatDate(event.start,\'dS MMM, yyyy at HH:mm\');if(event.end>event.start){content+=\'<br>End:\'+$.fullCalendar.formatDate(event.end,\'dS MMM, yyyy at HH:mm\');}if(event.description!=\'\'){content+=\'<br>\'+event.description;}$(this).append(layer);var el=$(this);$("#cbut"+event.id).click(function(){$("#cbut"+event.id).remove();$("#events-layer").remove();event.color="#0c0";event.status="confirmed";update(event.id,"content","status","confirmed");$("#calendar").fullCalendar("updateEvent",event);});$("#delbut"+event.id).click(function(){window.top.window.purge(event.id,"content");window.top.window.$(el).remove();window.top.window.$(".popover").remove();});$("#edbut"+event.id).click(function(){$(".bookings").modal("toggle");$.get("includes/booking.php?id="+event.id,function(data){$(".bookings").find(".modal-content").html(data);})});$(this).popover({title:event.title,placement:"top",html:true,container:"body",content:content,}).popover("show")},eventMouseout:function(event){$("#events-layer").remove();$(this).not(event).popover("hide")},});';
    }
    $foot.='});/*]]>*/</script><div class="modal fade bookings"><div class="modal-dialog modal-lg"><div class="modal-content"></div></div></div>';
}
$foot.='<iframe id="sp" name="sp" class="hidden"></iframe><div id="block"><i class="fa fa-cog fa-5x fa-spin hidden"></i></div></body></html>';
