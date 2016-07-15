var btn=$.fn.button.noConflict();
$.fn.btn=btn;
$("#menu-toggle").click(function(e){
	e.preventDefault();
	$("#sidemenu,#content").toggleClass("toggled");
});
function purge(id,t){
	$('#busy').css({'display':'inline-block'});
	$('#sp').load('core/purge.php?id='+id+'&t='+t);
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
		var button_icon='<i class="libre"><svg xmlns="http://www.w3.org/2000/svg" id="libre-floppy" viewBox="0 0 14 14"><path d="m 4,12 h 6 V 9 H 4 v 3 z m 7,0 h 1 V 5 Q 12,4.890625 11.9219,4.699219 11.8438,4.507813 11.76564,4.429688 L 9.57033,2.234375 Q 9.49223,2.156245 9.30471,2.078125 9.11719,2 9,2 V 5.25 Q 9,5.5625 8.78125,5.78125 8.5625,6 8.25,6 H 3.75 Q 3.4375,6 3.21875,5.78125 3,5.5625 3,5.25 V 2 H 2 V 12 H 3 V 8.75 Q 3,8.4375 3.21875,8.21875 3.4375,8 3.75,8 h 6.5 Q 10.5625,8 10.78125,8.21875 11,8.4375 11,8.75 V 12 z M 8,4.75 V 2.25 Q 8,2.148438 7.9258,2.074219 7.85156,2 7.75,2 H 6.25 Q 6.14844,2 6.07422,2.07422 6,2.148438 6,2.25 v 2.5 Q 6,4.851562 6.0742,4.925781 6.14844,5 6.25,5 h 1.5 Q 7.85156,5 7.92578,4.92578 8,4.851562 8,4.75 z M 13,5 v 7.25 q 0,0.3125 -0.21875,0.53125 Q 12.5625,13 12.25,13 H 1.75 Q 1.4375,13 1.21875,12.78125 1,12.5625 1,12.25 V 1.75 Q 1,1.4375 1.21875,1.21875 1.4375,1 1.75,1 H 9 q 0.3125,0 0.6875,0.15625 0.375,0.15625 0.59375,0.375 l 2.1875,2.1875 Q 12.6875,3.9375 12.84375,4.3125 13,4.6875 13,5 z"/></svg></i>';
		var button_style='btn-danger';
		var id=$(this).data("dbid");
		var t=$(this).data("dbt");
		var c=$(this).data("dbc");
		if($(this).data("bt")){
			var bt=$(this).data("bt");
			if(bt=='text')var button_icon='save';
		}
		if($(this).data("bs")){
			var button_style=$(this).data("bs");
		}
		var da=$(this).val();
		if(t=='menu'){
			$('#'+c+'save').remove();
			$('#'+c).after('<div id="'+c+'save" class="input-group-btn"><button class="btn '+button_style+'">'+button_icon+'</button></div>');
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
$(document).on(
	'click','#content input[type=checkbox]',
	{},
	function(event){
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
			var a=$(this).data("dba");
			$('#sp').load('core/toggle.php?id='+id+'&t='+t+'&c='+c+'&b='+b);
			if(t=='menu'&&c=='active'){
				var trow=$('#l_'+id).closest('tr');
				$('#l_'+id).closest('tr').remove();
				if(a==1){
					$('#inactive').append(trow);
					$('#active'+id).attr('data-dba','0');
				}else{
					$('#sortable').append(trow);
					$('#active'+id).attr('data-dba','1');
				}
			}
		}
	}
);
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
	var busy='<i id="'+c+'" class="busy libre"><svg xmlns="http://www.w3.org/2000/svg" id="libre-cog" viewBox="0 0 14 14"><path d="M 9,7 Q 9,6.171875 8.41406,5.585938 7.82813,5 7,5 6.17187,5 5.58594,5.585938 5,6.171875 5,7 5,7.828125 5.58594,8.414062 6.17187,9 7,9 7.82813,9 8.41406,8.414062 9,7.828125 9,7 z M 13,6.148437 V 7.882813 Q 13,7.976563 12.9375,8.0625 12.875,8.14844 12.78125,8.164062 l -1.44531,0.218751 q -0.14844,0.421875 -0.30469,0.710937 0.27344,0.390625 0.83594,1.078125 0.0781,0.09375 0.0781,0.195313 0,0.101562 -0.0703,0.179687 -0.21094,0.289063 -0.77344,0.84375 -0.5625,0.554687 -0.73437,0.554687 -0.0937,0 -0.20313,-0.07031 l -1.07812,-0.84375 q -0.34375,0.179688 -0.71094,0.296875 -0.125,1.0625 -0.22656,1.453125 Q 8.09375,13 7.86719,13 H 6.13281 q -0.10937,0 -0.1914,-0.06641 -0.082,-0.06641 -0.0898,-0.167969 l -0.21875,-1.4375 q -0.38281,-0.125 -0.70312,-0.289063 l -1.10157,0.835938 q -0.0781,0.07031 -0.19531,0.07031 -0.10937,0 -0.19531,-0.08594 -0.98437,-0.890625 -1.28906,-1.3125 -0.0547,-0.07813 -0.0547,-0.179687 0,-0.09375 0.0625,-0.179688 Q 2.27348,10.023429 2.55473,9.667959 2.83598,9.312491 2.9766,9.117178 2.76566,8.726554 2.65629,8.343741 L 1.226603,8.132803 Q 1.125,8.117188 1.0625,8.035156 1,7.953125 1,7.851563 V 6.117187 Q 1,6.023437 1.0625,5.9375 1.125,5.85156 1.210937,5.835938 L 2.66406,5.617187 Q 2.77344,5.257813 2.96875,4.898437 2.65625,4.453125 2.13281,3.820313 2.05471,3.726563 2.05471,3.632812 q 0,-0.07812 0.0703,-0.179687 0.20312,-0.28125 0.76953,-0.839844 0.56641,-0.558593 0.73828,-0.558593 0.10157,0 0.20313,0.07812 L 4.91407,2.968746 Q 5.25782,2.789058 5.62501,2.671871 5.75001,1.609371 5.85157,1.218746 5.90625,1 6.13281,1 h 1.73438 q 0.10937,0 0.1914,0.06641 0.082,0.06641 0.0898,0.167969 l 0.21875,1.4375 q 0.38281,0.125 0.70312,0.289063 l 1.10938,-0.835938 q 0.0703,-0.07031 0.1875,-0.07031 0.10156,0 0.19531,0.07812 1.00781,0.929688 1.28906,1.328125 0.0547,0.0625 0.0547,0.171875 0,0.09375 -0.0625,0.179688 -0.11719,0.164062 -0.39844,0.519531 -0.28125,0.355469 -0.42187,0.550782 0.20312,0.390624 0.32031,0.765624 L 12.7734,5.86719 q 0.10156,0.01562 0.16406,0.09766 0.0625,0.08203 0.0625,0.183593 z"/></svg></i>';
	if(t=='comments'){
		if(c=='status'){
			$('#approve_'+id).remove();
		}
		if(da=='approved'){
			$('#l_'+id).removeClass('danger');
		}
	}else{
		$('#'+c).before(busy);
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
				$('#'+c+'save').remove()
			}else{
				$('#'+c+'save').remove()
			}
			$('#'+c).remove()
		}
		if(t=='content'&&c=='contentType'){
			$('[id^=d]').removeClass('hidden');
			var els='';
			if(da=='article')els='#d5,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d15,#d16,#d19,#d20,#d21,#d26t,#d54,#d060,#d60';
			if(da=='portfolio')els='#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d19,#d20,#d21,#d22,#d24,#d26t,#d53,#d54,#d060,#d60';
			if(da=='events')els='#d5,#d6,#d7,#d8,#d9,#d10,#d21,#d22,#d24,#d26t,#d53,#d060,#d60';
			if(da=='news')els='#d5,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d15,#d16,#d19,#d20,#d21,#d22,#d24,#d26t,#d54,#d060,#d60';
			if(da=='testimonials')els='#d6,#d7,#d8,#d9,#d10,#d11,#d12,#d17,#d18,#d19,#d20,#d21,#d22,#d24,#d26nt,#d043,#d43,#d53,#d54,#d060,#d60';
			if(da=='inventory')els='#d5,#d6,#d11,#d12,#d13,#d14,#d15,#d16,#d24,#d26t,#d043,#d43,#d54';
			if(da=='service')els='#d5,#d6,#d9,#d10,#d11,#d12,#d13,#d14,#d15,#d16,#d21,#d24,#d26t,#d043,#d43';
			if(da=='gallery')els='#d5,#d7,#d8,#d9,#d10,#d11,#d12,#d13,#d14,#d15,#d16,#d19,#d20,#d21,#d24,#d26t,#d043,#d43,#d54,#d060,#d60';
			if(da=='proofs')els='#d3,#d7,#d8,#d9,#d10,#d11,#d12,#d19,#d20,#d21,#d22,#d24,#d26t,#d46,#d47,#d53,#d54,#d060,#d60';
			$(els).addClass('hidden');
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
				$('#'+c+'image').attr('src','../core/images/nocover.jpg');
			}
		}else{
			if(imgsrc==''){
				$('#'+c+'image').attr('src',da);
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
function removeBackup(id2,id){
	$('#sp').load('core/removebackup.php?id2='+id2+'&id='+id);
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
	$('#block').css({display:'block'});
	$('#more_'+is).html('');
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
		$('#l_activity').append(msg);
		$('#block').css({display:'none'});
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
