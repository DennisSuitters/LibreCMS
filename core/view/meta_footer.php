<?php
$content.='<div class="notifications center"></div>';
$content.='<script src="layout/default/js/jquery-2.1.3.min.js"></script>';
$content.='<script src="layout/default/js/bootstrap.min.js"></script>';
$content.='<script src="layout/default/js/jquery.notifications.min.js"></script>';
$content.='<script src="layout/default/js/masonry.pkgd.min.js"></script>';
$content.='<script src="layout/default/js/intense.min.js"></script>';
$content.='<script>/*<![CDATA[*/ window.onload=function(){Intense(document.querySelectorAll(".intense"))}/*]]>*/</script>';
if($view=='bookings'||$view=='contactus'||$view=='cart'){
	$content.='<iframe id="sp" name="sp" class="hidden"></iframe>';
}
$content.='</body></html>';
