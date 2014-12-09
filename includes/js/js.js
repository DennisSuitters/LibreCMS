function purge(id,t){
	$('#busy').css({'display':'inline-block'});$('#sp').load('includes/purge.php?id='+id+'&t='+t)
}
function makeClient(id){
	$('#busy').css({'display':'inline-block'});$('#sp').load('includes/add_data.php?id='+id+'&act=make_client')
}
function changeClient(id,oid){
	$('#changeClient').before('<i class="libr8-busy fa fa-cog fa-spin');$('#sp').load('includes/change_client.php?id='+id+'&oid='+oid)
}
function addOrderItem(oid,iid){
	$('#busy').css({'display':'inline-block'});$('#sp').load('includes/add_data.php?act=add_orderitem&oid='+oid+'&iid='+iid)
}
function getClient(email){
	$('#busy').css({'display':'inline-block'});$('#sp').load('includes/get_client.php?email='+email)
}
function associated(id,el,a){
	var assoc=a.split('|');
	if(assoc[1]==''){
		$(el).slideUp(500,function(){
			$(this).html('<input type="hidden" name="assoc[]" value="0">')
		})
	}else{
		$(el).slideUp(500,function(){
			$(this).load('includes/associated.php?id='+id+'&a='+assoc[1],function(){
				$(this).slideDown(200)
			})
		})
	}
	if(id!=0){
		update(id,'bookings','service',assoc[0])
	}
}
$(".libr8-textinput").on({
	keydown:function(event){
		var id=$(this).data("dbid");
		var t=$(this).data("dbt");
		var c=$(this).data("dbc");
		var da=$(this).val();
		if(event.keyCode==46||event.keyCode==8){
			$(this).trigger('keypress')
		}
	},
	keyup:function(event){
		if(event.which==9){
			var id=$(this).data("dbid");
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var da=$(this).val();
			update(id,t,c,da);
			$(this).next("input").focus()
		}
	},
	keypress:function(event){
		var id=$(this).data("dbid");
		var t=$(this).data("dbt");
		var c=$(this).data("dbc");
		var da=$(this).val();
		$('#'+c+'save').removeClass('libr8-hidden');
		if(event.which==13){
			update(id,t,c,da);
			event.preventDefault()
		}
	},
	change:function(event){
		var id=$(this).data("dbid");
		var t=$(this).data("dbt");
		var c=$(this).data("dbc");
		var da=$(this).val();
		update(id,t,c,da)
	}
});
$("#content input[type=checkbox]").on({
	click:function(event){
		var id=$(this).data("dbid");
		var t=$(this).data("dbt");
		var c=$(this).data("dbc");
		var b=$(this).data("dbb");
		$('#'+c+b).before('<i id="'+t+c+b+'" class="libr8-busy fa fa-cog fa-spin"></i>');
		$('#sp').load('includes/toggle.php?id='+id+'&t='+t+'&c='+c+'&b='+b)
	}
});
function update(id,t,c,da){
	if(t=='comments'){
		if(c=='status'){
			$('#approve_'+id).remove()
		}
	}else{
		$('#'+c).before('<i id="'+c+'" class="libr8-busy fa fa-cog fa-spin"></i>')
	}
	$.ajax({
		type:"GET",
		url:"includes/update.php",
		data:{id:id,t:t,c:c,da:da}
	}).done(function(msg){
		if(t!='comments'){
			$('#'+c).remove();
			$('#'+c+'save').addClass('libr8-hidden')
		}
	})
}
function updateButtons(id,t,c,da){$('#sp').load('includes/update.php?id='+id+'&t='+t+'&c='+c+'&da='+escape(da))}
function removeMedia(id){$('#sp').load('includes/removemedia.php?id='+id)}
function showDetails(id,c){if($('#show'+id).hasClass('libr8-hidden')){$('#show'+id).load('includes/show_details.php?id='+id,function(){$(this).removeClass('libr8-hidden')})}else{$('#show'+id).addClass('libr8-hidden')}}
