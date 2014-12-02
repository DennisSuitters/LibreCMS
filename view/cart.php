<?php
$content.='<main id="content" class="col-md-12">';
if($args[0]=="confirm"){
	include"includes/add_order.php";
}else{
	$total=0;
	$s=$db->prepare("SELECT * FROM cart WHERE si=:si ORDER BY ti DESC");
	$s->execute(array(':si'=>SESSIONID));
	if($s->rowCount()>0){
	$content.='<div class="panel panel-default"><div class="panel-body"><div class="invoice table-responsive"><table class="table table-striped table-condensed"><thead><tr><th>Code</th><th>Title</th><th class="text-center col-sm-1">Quantity</th><th class="col-md-1 text-center">Cost</th><th class="col-md-2 text-right">Total</th><th class="col-sm-1"></th></tr></thead><tbody id="updateorder">';
	while($oi=$s->fetch(PDO::FETCH_ASSOC)){
		$si=$db->prepare("SELECT * FROM content WHERE id=:id");
		$si->execute(array(':id'=>$oi['iid']));
		$i=$si->fetch(PDO::FETCH_ASSOC);
		$content.='<tr><td class="text-left">'.$i['code'].'</td><td class="text-left">'.$i['title'].'</td><td class="text-center"><form target="sp" action="includes/update.php"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="cart"><input type="hidden" name="c" value="quantity"><input class="form-control text-center" name="da" value="'.$oi['quantity'].'"></form></td><td class="col-md-1 text-right"><input class="form-control text-center" value="'.$oi['cost'].'" readonly></td><td class="text-right">'.$oi['cost']*$oi['quantity'].'</td><td class="text-right"><button class="btn btn-danger" onclick="$(\'#sp\').load(\'includes/update.php?id='.$oi['id'].'&t=cart&c=quantity&da=0\');"><i class="fa fa-trash"></i></button></td></tr>';
		$total=$total+($oi['cost']*$oi['quantity']);
	}
	$content.='<tr><td colspan="3">&nbsp;</td><td class="text-right"><strong>Total</strong></td><td class="text-right"><strong>';
	$total=$total+$oi['postagecost'];
	$content.=$total.'</strong></td><td></td></tr></tbody><tfoot><tr><td colspan="6"><small class="text-muted">Enter \'0\' as the Quantity to remove items</small></td></tr></tfoot></table></div></div></div><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">Create or Add to Existing Account</h3></div><div class="panel-body"><form method="post" action="cart/confirm"><div class="form-group"><label class="control-label col-sm-2">&nbsp;</label><div class="input-group col-sm-10 text-danger">Highlighted Fields are Required</div></div><div class="form-group"><label for="email" class="control-label col-md-2 col-xs-4 text-danger">Email</label><div class="input-group col-md-10 col-xs-8 has-error"><input type="text" id="email" class="form-control" name="email" value="" placeholder="Enter an Email" required><div class="input-group-btn"><button class="btn btn-default" onclick="getClient($(\'#email\').val());return false">Retrieve</button></div></div></div><div class="form-group"><label for="business" class="control-label col-md-2 col-xs-4">Business</label><div class="input-group col-md-10 col-xs-8"><input type="text" id="business" class="form-control" name="business" value="" placeholder="Enter a Business..."></div></div><div class="form-group"><label for="address" class="control-label col-md-2 col-xs-4">Address</label><div class="input-group col-md-10 col-xs-8"><input type="text" id="address" class="form-control" name="address" value="" placeholder="Enter an Address..."></div></div><div class="form-group"><label for="suburb" class="control-label col-md-2 col-xs-4">Suburb</label><div class="input-group col-md-10 col-xs-8"><input type="text" id="suburb" class="form-control" name="suburb" value="" placeholder="Enter a Suburb..."></div></div><div class="form-group"><label for="city" class="control-label col-md-2 col-xs-4">City</label><div class="input-group col-md-10 col-xs-8"><input type="text" id="city" class="form-control" name="city" value="" placeholder="Enter a City..."></div></div><div class="form-group"><label for="state" class="control-label col-md-2 col-xs-4">State</label><div class="input-group col-md-10 col-xs-8"><input type="text" id="state" class="form-control" name="state" value="" placeholder="Enter a State..."></div></div><div class="form-group"><label for="postcode" class="control-label col-md-2 col-xs-4">Postcode</label><div class="input-group col-md-10 col-xs-8"><input type="text" id="postcode" class="form-control" name="postcode" value="" placeholder="Enter a Postcode..."></div></div><div class="form-group"><label for="phone" class="control-label col-md-2 col-xs-4">Phone</label><div class="input-group col-md-10 col-xs-8"><input type="text" id="phone" class="form-control" name="phone" value="" placeholder="Enter a Phone Number..."></div></div><div class="pull-right"><button class="btn btn-success">Confirm Order</button></div></form></div></div>';
	}else{
	$content.='<div class="alert alert-info">You don\'t have any Items in the Cart</div>';
	}
}
$content.='</main>';
