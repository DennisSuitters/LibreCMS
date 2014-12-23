<?php
if($view=='add'){
	$ti=time();
	$q=$db->prepare("INSERT INTO content (contentType,status,ti,tis) VALUES ('booking','unconfirmed',:ti,:tis)");
	$q->execute(array(':ti'=>$ti,':tis'=>$ti));
	$view='bookings';
}?>
<link rel="stylesheet" type="text/css" href="includes/css/fullcalendar.min.css" />
<link rel="stylesheet" type="text/css" href="includes/css/bootstrap-datetimepicker.min.css" />
<div id="calendar"></div>
