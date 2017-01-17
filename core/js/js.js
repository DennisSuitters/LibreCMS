var btn=$.fn.button.noConflict();
$.fn.btn=btn;
function blocker(){
	$('#block').css({'display':'block'});
}
$("#menu-toggle").click(function(e){
	e.preventDefault();
	$("#sidemenu,#content,#menu-toggle").toggleClass("toggled");
});
function getExif(id,t,c){
	$('#busy').css({'display':'block'});
	$('#sp').load('core/getexif.php?id='+id+'&t='+t+'&c='+c);
}
function purge(id,t){
	$('#busy').css({'display':'block'});
	$('#sp').load('core/purge.php?id='+id+'&t='+t);
}
function restore(id){
	$('#busy').css({'display':'block'});
	$('#sp').load('core/restore.php?id='+id);
}
function makeClient(id){
	$('#busy').css({'display':'block'});
	$('#sp').load('core/add_data.php?id='+id+'&act=make_client');
}
function changeClient(id,oid,w){
	$('#block').css({'display':'block'});
	if(w=='booking'){
		$('#sp').load('core/change_bookingClient.php?id='+id+'&bid='+oid);
	}else{
		$('#sp').load('core/change_orderClient.php?id='+id+'&oid='+oid);
	}
}
function addOrderItem(oid,iid){
	$('#busy').css({'display':'block'});
	$('#sp').load('core/add_data.php?act=add_orderitem&oid='+oid+'&iid='+iid);
}
function getClient(email){
	$('#busy').css({'display':'block'});
	$('#sp').load('core/get_client.php?email='+email);
}
function associated(id,el,a){
	var assoc=a.split('|');
	if(assoc[1]==''){
		$(el).slideUp(500,function(){
			$(this).html('<input type="hidden" name="assoc[]" value="0">');
		})
	}else{
		$(el).slideUp(500,function(){
			$(this).load('core/associated.php?id='+id+'&a='+assoc[1],function(){
				$(this).slideDown(200);
			});
		});
	}
	if(id!=0){
		update(id,'bookings','service',assoc[0]);
	}
}
$(".textinput").on({
	keydown:function(event){
		var id=$(this).data("dbid");
		var t=$(this).data("dbt");
		var c=$(this).data("dbc");
		var da=$(this).val();
		if(event.keyCode==46||event.keyCode==8){
			$(this).trigger('keypress');
		}
	},
	keyup:function(event){
		if(event.which==9){
			var id=$(this).data("dbid");
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var da=$(this).val();
			$(this).trigger('keypress');
//			update(id,t,c,da);
			$(this).next("input").focus();
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
			event.preventDefault();
		}
	},
	change:function(event){
		var id=$(this).data("dbid");
		var t=$(this).data("dbt");
		var c=$(this).data("dbc");
		var da=$(this).val();
		update(id,t,c,da);
//		$(this).trigger('keypress')
	}
})
$('#seoTitle').keyup(function(){
	var length=$(this).val().length;
	var max=70;
	var length=max-length;
	$("#seoTitlecnt").text(length);
	if(length<0){
		$("#seoTitlecnt").addClass('text-danger');
	}else{
		$("#seoTitlecnt").removeClass('text-danger');
	}
});
$('#seoCaption').keyup(function(){
	var length=$(this).val().length;
	var max=160;
	var length=max-length;
	$("#seoCaptioncnt").text(length);
	if(length<0){
		$("#seoCaptioncnt").addClass('text-danger');
	}else{
		$("#seoCaptioncnt").removeClass('text-danger');
	}
});
$('#seoDescription').keyup(function(){
	var length=$(this).val().length;
	var max=160;
	var length=max-length;
	$("#seoDescriptioncnt").text(length);
	if(length<0){
		$("#seoDescriptioncnt").addClass('text-danger');
	}else{
		$("#seoDescriptioncnt").removeClass('text-danger');
	}
});
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
			if(this.checked){
				$('.checkboxtoggle').each(function(){
					this.checked=true;
				});
			}else{
				$('.checkboxtoggle').each(function(){
					this.checked=false;
				});
			}
		}else{
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var b=$(this).data("dbb");
			var a=$(this).data("dba");
			$('#sp').load('core/toggle.php?id='+id+'&t='+t+'&c='+c+'&b='+b);
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
	var busy='<i id="'+c+'" class="busy libre animated spin"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" id="libre-spinner-13"><g id="g3341" transform="matrix(0.05331877,0,0,0.0470101,-0.19803392,13.487394)" style="stroke-width:9.81667709;stroke-miterlimit:4;stroke-dasharray:none"><ellipse style="fill:none;stroke:#000000;stroke-width:9.81667709;stroke-miterlimit:4;stroke-dasharray:none" ry="144" rx="40" cy="-138" cx="135" id="e"/><use height="100%" width="100%" y="0" x="0" id="use5" transform="matrix(0.5,0.8660254,-0.8660254,0.5,-52.011501,-185.91343)" xlink:href="#e" style="stroke-width:9.81667709;stroke-miterlimit:4;stroke-dasharray:none"/><use height="100%" width="100%" y="0" x="0" id="use7" transform="matrix(0.5,-0.8660254,0.8660254,0.5,187.0115,47.91343)" xlink:href="#e" style="stroke-width:9.81667709;stroke-miterlimit:4;stroke-dasharray:none"/></g></svg></i>';
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
				$('#'+c+'save').remove();
			}else{
				$('#'+c+'save').remove();
			}
			$('#'+c).remove();
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
		$('#block').css({'display':'none'});
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
			$('#avatar').attr('src','');
			$('#menu_avatar').attr('src','');
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
	$('#sp').load('core/update.php?id='+id+'&t='+t+'&c='+c+'&da='+escape(da));
}
function removeBackup(id2,id){
	$('#sp').load('core/removebackup.php?id2='+id2+'&id='+id);
}
function showDetails(id,c){
	if($('#show'+id).hasClass('hidden')){
		$('#show'+id).load('core/show_details.php?id='+id,function(){
			$(this).addClass('fadeInDown');
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
	$('#block').css({'display':'block'});
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
		$('#block').css({'display':'none'});
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
function removeStopWords(id,txt){
	$('#block').css({'display':'block'});
	var x;
	var y;
	var word;
	var stop_word;
	var regex_str;
	var regex;
	var cleansed_string=txt;
	var stop_words=new Array('a','about','above','across','after','again','against','all','almost','alone','along','already','also','although','always','among','an','and','another','any','anybody','anyone','anything','anywhere','are','area','areas','around','as','ask','asked','asking','asks','at','away','b','back','backed','backing','backs','be','became','because','become','becomes','been','before','began','behind','being','beings','best','better','between','big','both','but','by','c','came','can','cannot','case','cases','certain','certainly','clear','clearly','come','could','d','did','differ','different','differently','do','does','done','down','down','downed','downing','downs','during','e','each','early','either','end','ended','ending','ends','enough','even','evenly','ever','every','everybody','everyone','everything','everywhere','f','face','faces','fact','facts','far','felt','few','find','finds','first','for','four','from','full','fully','further','furthered','furthering','furthers','g','gave','general','generally','get','gets','give','given','gives','go','going','good','goods','got','great','greater','greatest','group','grouped','grouping','groups','h','had','has','have','having','he','her','here','herself','high','high','high','higher','highest','him','himself','his','how','however','i','if','important','in','interest','interested','interesting','interests','into','is','it','its','itself','j','just','k','keep','keeps','kind','knew','know','known','knows','l','large','largely','last','later','latest','least','less','let','lets','like','likely','long','longer','longest','m','made','make','making','man','many','may','me','member','members','men','might','more','most','mostly','mr','mrs','much','must','my','myself','n','necessary','need','needed','needing','needs','never','new','new','newer','newest','next','no','nobody','non','noone','not','nothing','now','nowhere','number','numbers','o','of','off','often','old','older','oldest','on','once','one','only','open','opened','opening','opens','or','order','ordered','ordering','orders','other','others','our','out','over','p','part','parted','parting','parts','per','perhaps','place','places','point','pointed','pointing','points','possible','present','presented','presenting','presents','problem','problems','put','puts','q','quite','r','rather','really','right','right','room','rooms','s','said','same','saw','say','says','second','seconds','see','seem','seemed','seeming','seems','sees','several','shall','she','should','show','showed','showing','shows','side','sides','since','small','smaller','smallest','so','some','somebody','someone','something','somewhere','state','states','still','still','such','sure','t','take','taken','than','that','the','their','them','then','there','therefore','these','they','thing','things','think','thinks','this','those','though','thought','thoughts','three','through','thus','to','today','together','too','took','toward','turn','turned','turning','turns','two','u','under','until','up','upon','us','use','used','uses','v','very','w','want','wanted','wanting','wants','was','way','ways','we','well','wells','went','were','what','when','where','whether','which','while','who','whole','whose','why','will','with','within','without','work','worked','working','works','would','x','y','year','years','yet','you','young','younger','youngest','your','yours','z');
	words=cleansed_string.match(/[^\s]+|\s+[^\s+]$/g);
	for(x=0;x<words.length;x++){
		for(y=0;y<stop_words.length;y++){
			word=words[x].replace(/\s+|[^a-z]+/ig,"");
			stop_word=stop_words[y];
			if(word.toLowerCase()==stop_word){
				regex_str="^\\s*"+stop_word+"\\s*$";
				regex_str+="|^\\s*"+stop_word+"\\s+";
				regex_str+="|\\s+"+stop_word+"\\s*$";
				regex_str+="|\\s+"+stop_word+"\\s+";
				regex=new RegExp(regex_str, "ig");
				cleansed_string=cleansed_string.replace(regex," ");
			}
		}
	}
	txt=cleansed_string.replace(/^\s+|\s+$/g,"");
	$('#'+id).val(txt).change();
}
