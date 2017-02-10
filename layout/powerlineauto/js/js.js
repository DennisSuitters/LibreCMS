function getClient(email){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/get_client.php?email='+email);
}
$(document).on(
	"click",
	".addCart",
		function(){
			$('#cart').load('core/add_cart.php?id='+$(this).data('cartid')+'&cid='+$(this).data('cartchoice'));
		}
);
$(document).on(
	"click",
	".addMore",
		function(){
			var c=$(this).data('contenttype');
			var v=$(this).data('view');
			var i=$(this).data('itemcount');
			$.ajax({
				type:"GET",
				url:"core/view/more.php",
				data:{
					c:c,
					v:v,
					i:i
				}
			}).done(
				function(msg){
					$('#more'+i).hide('fast');
					$('#more'+i).replaceWith(msg)
					$('#more'+i).show('normal');
			});
		}
);
