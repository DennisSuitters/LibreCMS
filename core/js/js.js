function purge(id,t){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/purge.php?id='+id+'&t='+t)
}
function restore(id){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/restore.php?id='+id)
}
function makeClient(id){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/add_data.php?id='+id+'&act=make_client')
}
function changeClient(id,oid,w){
	$('#block').css({'display':'inline-block'});
	if(w=='booking'){
		$('#sp').load('core/change_bookingClient.php?id='+id+'&bid='+oid)
	}else{
		$('#sp').load('core/change_orderClient.php?id='+id+'&oid='+oid)
	}
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
			$(this).trigger('keypress')
//			update(id,t,c,da);
			$(this).next("input").focus()
		}
	},
	keypress:function(event){
		var button_icon='<i class="libre libre-floppy"></i>';
		var button_style='btn-danger';
		var id=$(this).data("dbid");
		var t=$(this).data("dbt");
		var c=$(this).data("dbc");
		if($(this).data("bt")){
			var bt=$(this).data("bt");
			if(bt=='text')var button_icon='Save';
		}
		if($(this).data("bs")){
			var button_style=$(this).data("bs");
		}
		var da=$(this).val();
		if(t=='menu'){
			$('#'+c+id+'save').remove();
			$('#'+c+id).after('<div id="'+c+id+'save" class="input-group-btn"><button class="btn '+button_style+'">'+button_icon+'</button></div>');
		}else{
			$('#'+c+'save').remove();
			$('#'+c).after('<div id="'+c+'save" class="input-group-btn"><button class="btn '+button_style+'">'+button_icon+'</button></div>');
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
//		$(this).trigger('keypress')
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
});
function pinToggle(id,t,c,b){
	$.ajax({
		type:"GET",
		url:"core/toggle.php",
		data:{
			id:id,
			t:t,
			c:c,
			b:b
		}
	}).done(function(msg){
		$('#pin'+id).toggleClass('btn-success');
	})
	return false;
}
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
		if(t=='login'){
			if(c=='layoutAccounts'||c=='layoutContent'){
				$('#listtype').removeClass('list card table').addClass(da);
			}
		}
		if(t!='comments'){
			if(t=='menu'){
				$('#'+c+id+'save').remove()
			}else{
				$('#'+c+'save').remove()
			}
			$('#'+c).remove()
		}
		if(t=='content'&&c=='contentType'){
			if(da=='article'){
				$('#d1,#d3,#d4,#d15,#d16,#d20,#d21,#d23,#d24').removeClass('hidden');
				$('#d2,#d5,#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d17,#d18,#d19,#d22').addClass('hidden');
			}
			if(da=='portfolio'){
				$('#d1,#d4,#d15,#d16,#d20,#d21,#d23').removeClass('hidden');
				$('#d2,#d3,#d5,#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d17,#d18,#d19,#d22,#d24').addClass('hidden');
			}
			if(da=='booking'){
				$('#d1').removeClass('hidden');
				$('#d2,#d3,#d4,#d5,#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d15,#d16,#d17,#d18,#d19,#d20,#d21,#d22,#d23,#d24').addClass('hidden');
			}
			if(da=='events'){
				$('#d1,#d5,#d9,#d10,#d15,#d16,#d20,#d21,#d22,#d23,#d24').removeClass('hidden');
				$('#d2,#d3,#d4,#d6,#d7,#d8,#d11,#d12,#d13,#d14,#d17,#d18,#d19').addClass('hidden');
			}
			if(da=='news'){
				$('#d1,#d5,#d12,#d13,#d14,#d15,#d16,#d20,#d21,#d23,#d24').removeClass('hidden');
				$('#d2,#d3,#d4,#d6,#d7,#d8,#d9,#d10,#d11,#d17,#d18,#d19,#d22').addClass('hidden');
			}
			if(da=='testimonials'){
				$('#d1,#d2,#d11,#d12,#d13').removeClass('hidden');
				$('#d3,#d4,#d5,#d6,#d7,#d8,#d9,#d10,#d14,#d15,#d16,#d17,#d18,#d19,#d20,#d21,#d22,#d23,#d24').addClass('hidden');
			}
			if(da=='inventory'){
				$('#d1,#d4,#d5,#d6,#d7,#d8,#d15,#d16,#d17,#d18,#d19,#d20,#d21,#d23').removeClass('hidden');
				$('#d2,#d3,#d9,#d10,#d11,#d12,#d13,#d14,#d22,#d24').addClass('hidden');
			}
			if(da=='service'){
				$('#d1,#d4,#d5,#d15,#d16,#d17,#d18,#d20,#d21,#d22,#d23').removeClass('hidden');
				$('#d2,#d3,#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d19,#d24').addClass('hidden');
			}
			if(da=='gallery'){
				$('#d1,#d4,#d15,#d16,#d20,#d21,#d23').removeClass('hidden');
				$('#d2,#d3,#d5,#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d17,#d18,#d19,#d22,#d24').addClass('hidden');
			}
			if(da=='proofs'){
				$('#d2,#d4,#d14,#d24').removeClass('hidden');
				$('#d1,#d3,#d5,#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d15,#d16,#d17,#d18,#d19,#d20,#d21,#d22,#d23').addClass('hidden');
			}
		}
		$('#block').css({display:'none'});
	})
}
function coverUpdate(id,t,c,da){
	var imgsrc=$('#cover').attr('val');
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
		if(da==''){
			$('#'+c).val('');
			if(imgsrc==''){
				$('#coverimg').animate({height:"hide"},500,function(){
					$(this).html('');
				});
			}
		}else{
			if(imgsrc==''){
				$('#coverimg').html('<img src="'+da+'">').animate({height:"show"},500);
			}
		}
	})
}
function imageUpdate(id,t,c,da){
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
		if(t=='login'&&c=='avatar'){
			$('#'+c).val('');
		}else{
			if(da==''){
				$('#'+c).html('');
			}else{
				$('#'+c).html('<img src="media/'+da+'">');
			}
		}
	})
}
function updateButtons(id,t,c,da){
	$('#sp').load('core/update.php?id='+id+'&t='+t+'&c='+c+'&da='+escape(da))
}
function removeMedia(t){
	$('#sp').load('core/removemedia.php?t='+t);
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
function reload(c){
	location.reload(true);
}
function loadMore(l,is,ie,action,lang){
	$('#more_'+is).html('<div class="text-center"><i class="libre libre-spinner-12 libre-2x animated spin"></i></div>');
	$.ajax({
		type:"GET",
		url:"core/layout/"+l+".php",
		data:{
			is:is,
			ie:ie,
			action:action,
			l:lang
		}
	}).done(function(msg){
		$('#more_'+is).html(msg);
	})
}
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
(function($){
	$.fn.search_filter=function(options){
		var settings=$.extend({
			'filter_inverse':false,
			'enable_space':true,
			'el':'#listtype',
			'cell_selector':'.item'
		},options);
		return this.each(function(){
			var $this=$(this);
			$this.bind("keyup",function(){
				var txt=$this.val().toLowerCase();
				var obj=$(settings.el).find(settings.cell_selector);
				$.each(obj,function(){
					var show_el=(settings.filter_inverse)?true:false;
					var inner_obj=$(this).find(settings.cell_selector);
					$.each(inner_obj,function(){
						var el_txt=$.trim($(this).text()).toLowerCase();
						if(settings.enable_space){
							var el_array=txt.split(" ");
							$.each(el_array,function(i){
								var el_value=el_array[i];
								if(el_txt.indexOf(el_value)!=-1){
									show_el=(settings.filter_inverse)?false:true
								}
							})
						}else{
							if(el_txt.indexOf(txt)!=-1){
								show_el=(settings.filter_inverse)?false:true
							}
						}
					});
					if(show_el){
						$(this).fadeIn('slow')
					}else{
						$(this).fadeOut('slow')
					}
				});
				if($.trim(txt)==""){
					$(settings.el).find(".item").fadeIn('slow')
				}
			})
		})
	}
})(jQuery);
