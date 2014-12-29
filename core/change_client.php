<?php
include'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
$q=$db->prepare("UPDATE orders SET cid=:cid WHERE id=:oid");
$q->execute(array(':cid'=>$id,':oid'=>$oid));
$q=$db->prepare("SELECT business,address,suburb,state,city,postcode,email,phone,mobile FROM login WHERE id=:id");
$q->execute(array(':id'=>$id));
$c=$q->fetch(PDO::FETCH_ASSOC);
$h='<p><strong>'.$c['business'].'</strong></p>';
if($c['address']!=''){$h.='<p>'.$c['address'].'</p>';}
if($c['suburb']!=''){$h.='<p>'.$c['suburb'].', '.$c['state'].'</p>';}
if($c['city']!=''){$h.='<p>'.$c['city'].', '.$c['postcode'].'</p>';}
$h.='<p>Email: <a href="mailto:'.$c['email'].'">'.$c['email'].'</a></p>';
if($c['phone']!=''){$h.='<p>Phone: '.$c['phone'].'</p>';}
if($c['mobile']!=''){$h.='<p>Mobile: '.$c['mobile'].'</p>';}?>
<script>/*<![CDATA[*/
	window.top.window.$('#cC').remove();
	window.top.window.$('#cdetails').html('<?php echo$h;?>');
/*]]>*/</script>
