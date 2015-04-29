function purge(id,t){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/purge.php?id='+id+'&t='+t)
}
function makeClient(id){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/add_data.php?id='+id+'&act=make_client')
}
function changeClient(id,oid){
	$('#changeClient').before('<i class="busy libre libre-cog libre-spin');
	$('#sp').load('core/change_client.php?id='+id+'&oid='+oid)
}
function addOrderItem(oid,iid){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/add_data.php?act=add_orderitem&oid='+oid+'&iid='+iid)
}
function getClient(email){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/get_client.php?email='+email)
}
function associated(id,el,a){
	var assoc=a.split('|');
	if(assoc[1]==''){
		$(el).slideUp(500,function(){
			$(this).html('<input type="hidden" name="assoc[]" value="0">')
		})
	}else{
		$(el).slideUp(500,function(){
			$(this).load('core/associated.php?id='+id+'&a='+assoc[1],function(){
				$(this).slideDown(200)
			})
		})
	}
	if(id!=0){
		update(id,'bookings','service',assoc[0])
	}
}
$(".textinput").on({
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
		if(t=='menu'){
			$('#'+c+id+'save').remove();
			$('#'+c+id).after('<div id="'+c+id+'save" class="input-group-btn"><button class="btn btn-danger"><i class="libre libre-save"></i></button></div>')
		}else{
			$('#'+c+'save').remove();
			$('#'+c).after('<div id="'+c+'save" class="input-group-btn"><button class="btn btn-danger"><i class="libre libre-save"></i></button></div>')
		}
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
})
$("#content input[type=checkbox]").on({
	click:function(event){
		var id=$(this).data("dbid");
		if('#home input[type=checkbox]'){
			$('#actions').toggleClass('hidden');
		}else{
			$('#actions').toggleClass('hidden');
		}
		if(id=='checkboxtoggle'){
			if(this.checked) { // check select status
				$('.checkboxtoggle').each(function() { //loop through each checkbox
					this.checked = true;  //select all checkboxes with class "checkbox1"
				});
			}else{
				$('.checkboxtoggle').each(function() { //loop through each checkbox
					this.checked = false; //deselect all checkboxes with class "checkbox1"
				});
			}
		}else{
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var b=$(this).data("dbb");
			$('#'+c+b).before('<i id="'+t+c+b+'" class="busy libre libre-cog libre-spin"></i>');
			$('#sp').load('core/toggle.php?id='+id+'&t='+t+'&c='+c+'&b='+b)
		}
	}
})
function update(id,t,c,da){
	if(t=='comments'){
		if(c=='status'){
			$('#approve_'+id).remove()
		}
	}else{
		$('#'+c).before('<i id="'+c+'" class="busy libre libre-cog libre-spin"></i>')
	}
	$.ajax({
		type:"GET",
		url:"core/update.php",
		data:{
			id:id,
			t:t,
			c:c,
			da:da
		}
	}).done(function(msg){
		if(t!='comments'){
			if(t=='menu'){
				$('#'+c+id+'save').remove()
			}else{
				$('#'+c+'save').remove()
			}
			$('#'+c).remove()
		}
	})
}
function updateButtons(id,t,c,da){
	$('#sp').load('core/update.php?id='+id+'&t='+t+'&c='+c+'&da='+escape(da))
}
function removeMedia(id){
	$('#sp').load('core/removemedia.php?id='+id)
}
function showDetails(id,c){
	if($('#show'+id).hasClass('hidden')){
		$('#show'+id).load('core/show_details.php?id='+id,function(){
			$(this).addClass('fadeInDown')
		})
	}else{
		$('#show'+id).removeClass('fadeInDown');
		$('#show'+id).removeClass('fadeOutUp');
	}
}
function statsContent(content){
	$('#stats_'+content).html('<div class="panel-footer text-center"><i class="libre libre-spinner-1 libre-spin"></i></div>').load('core/stats_'+content+'.php');return false}
$(".important").on({
	click:function(event){
		var id=$(this).data("dbid");
		var important=$(this).data("important");
		if(important==1){
			$(this).html('<i class="libre libre-empty-circle-o"></i>');
			$(this).data("important",0);
		}else{
			$(this).html('<i class="libre libre-empty-circle"></i>');
			$(this).data("important",1);
		}
		$('#sp').load('core/toggle.php?id='+id+'&t=messages&c=important&b=0');
		return false;
	}
});
$(".starred").on({
	click:function(event){
		var id=$(this).data("dbid");
		var starred=$(this).data("starred");
		if(starred==1){
			$(this).html('<i class="libre libre-star-o"></i>');
			$(this).data("starred",0);
		}else{
			$(this).html('<i class="libre libre-star"></i>');
			$(this).data("starred",1);
		}
		$('#sp').load('core/toggle.php?id='+id+'&t=messages&c=starred&b=0');
		return false;
	}
});