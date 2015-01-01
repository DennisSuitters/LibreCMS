function getClient(email){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('includes/get_client.php?email='+email);
}