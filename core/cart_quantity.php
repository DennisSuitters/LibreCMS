<?php
$cart='';
$dti=$ti-86400;
$q=$db->prepare("DELETE FROM cart WHERE ti<:ti");
$q->execute(array(':ti'=>$dti));
$q=$db->prepare("SELECT SUM(quantity) as quantity FROM cart WHERE si=:si");
$q->execute(array(':si'=>SESSIONID));
$r=$q->fetch(PDO::FETCH_ASSOC);
$cart=$theme['settings']['cart_menu'];
$cart=str_replace('<print quantity>',$r['quantity'],$cart);
