<?php
if($view=='add'){
	$ti=time();
	$q=$db->prepare("INSERT INTO content (contentType,status,ti,tis) VALUES ('booking','unconfirmed',:ti,:tis)");
	$q->execute(array(':ti'=>$ti,':tis'=>$ti));
	$view='bookings';
}?>
<link rel="stylesheet" type="text/css" href="core/css/fullcalendar.min.css" />
<div id="calendar" class="col-lg-9 col-md-9"></div>
