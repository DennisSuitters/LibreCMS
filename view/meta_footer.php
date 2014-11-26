<?php
if($config['options']{2}==1)require'view/modal_login.php';
$foot.='<div class="notifications center"></div><script src="includes/js/jquery-2.1.1.min.js"></script><script src="includes/js/bootstrap.min.js"></script><script src="includes/js/jquery.notifications.min.js"></script><script src="includes/js/masonry.pkgd.min.js"></script><script src="includes/js/intense.min.js"></script>';
if($view=='bookings'||$view=='contactus'||$view=='cart'){
	$foot.='<iframe id="sp" name="sp" class="hidden"></iframe>';
    if($view=='contactus'){
        $foot.='<script src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script><script src="includes/js/mapsed.js"></script><script>/*<![CDATA[*/window.onload=function(){Intense(document.querySelectorAll(".intense"));}';
        if($config['geoLocation']!=''){
            $geoloc=explode(',',$config['geoLocation']);
            $foot.='$("#map").mapsed({showOnLoad:[{autoShow:false,canEdit:false,lat:'.$geoloc[0].',lng:'.$geoloc[1].'';
            if($config['geoReference']!=''){
                $foot.=',reference:'.$config['geoReference'];
            }
            $foot.='}]});';
        }
        $foot.='/*]]>*/</script>';
    }
}
if($config['options']{6}==1&&$config['seoGoogleTracking']!=''&&$config['seoGoogleDomain']!=''){
    $foot.='<script>/*<![CDATA[*/(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');ga(\'create\',\''.$config['seoGoogleTracking'].'\',\''.$config['seoGoogleDomain'].'\');ga(\'send\',\'pageview\');/*]]>*/</script>';
}
$foot.='</body></html>';
