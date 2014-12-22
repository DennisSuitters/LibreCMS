<?php
if($view=='add'){
	$ti=time();
	$q=$db->prepare("INSERT INTO content (contentType,status,ti,tis) VALUES ('booking','unconfirmed',:ti,:tis)");
	$q->execute(array(':ti'=>$ti,':tis'=>$ti));
	$view='bookings';
}?>
<div id="calendar" class="col-md-9"></div>
<div class="col-md-3">
	Here
</div>
