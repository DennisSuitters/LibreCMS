<?php
$foot.='<div class="notifications center"></div>';
$foot.='<script src="layout/default/js/jquery-2.1.3.min.js"></script>';
$foot.='<script src="layout/default/js/bootstrap.min.js"></script>';
$foot.='<script src="layout/default/js/jquery.notifications.min.js"></script>';
$foot.='<script src="layout/default/js/masonry.pkgd.min.js"></script>';
$foot.='<script src="layout/default/js/intense.min.js"></script>';
$foot.='<script>/*<![CDATA[*/ window.onload=function(){Intense(document.querySelectorAll(".intense"))}/*]]>*/</script>';
if($view=='bookings'||$view=='contactus'||$view=='cart'){
	$foot.='<iframe id="sp" name="sp" class="hidden"></iframe>';
}
$foot.='</body></html>';
