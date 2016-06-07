function getClient(email){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/get_client.php?email='+email);
}
$(document).on("click",".addCart",function(){
	$('#cart').load('core/add_cart.php?id='+$(this).data('cartid'));
});
