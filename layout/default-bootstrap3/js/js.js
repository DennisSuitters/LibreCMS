function getClient(email){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/get_client.php?email='+email);
}