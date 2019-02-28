function update(id,t,c,da){
	if(t=='comments'){
		if(c=='status'){
			$('#approve_'+id).remove();
		}
		if(da=='approved'){
			$('#l_'+id).removeClass('danger');
		}
	}else{
		if(t=='media'){
//        			$('#mediab'+c).before(busy);
		}else{
//        			$('#'+c).before(busy);
		}
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
			if(t=='media'){
				$('#mediab'+c).remove();
			}else{
//				$('#'+c).remove();
			}
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
		Pace.stop();
		$('#block').css({'display':'none'});
	})
}
function toggleCalendar(){
	$('#calendar-view,#table-view').toggleClass('hidden');
	$('.libre-calendar,.libre-table').toggleClass('hidden');
	if(!$('#calendar-view').hasClass('hidden')){
		Cookies.set('bookingview','calendar',{expires:14});
		$('#calendar').fullCalendar('render');
	}else{
		Cookies.set('bookingview','table',{expires:14});
	}
	return false;
}
function updateButtons(id,t,c,da){
	$('#sp').load('core/update.php?id='+id+'&t='+t+'&c='+c+'&da='+escape(da));
}
function changeTheme(){
	var link=$("#themecss[rel=stylesheet]")[0].href;
	var css=link.substring(link.lastIndexOf('/')+1,link.length);
	$('#themecss').attr('href','core/css/style-'+(css=='style-dark.css'?'light':'dark')+'.css');
	$('#theme2css').attr('href','core/css/style2-'+(css=='style-dark.css'?'light':'dark')+'.css');
	Cookies.remove('adminbg');
	Cookies.set('adminbg',(css=='style-dark.css'?'light':'dark'),{expires:14});
	return false;
}
function restore(id){
	Pace.restart();
	$.ajax({
		type:"GET",
		url:"core/restore.php",
		data:{
			id:id,
		}
	}).done(function(msg){
		$('#sp').html(msg);
	});
}
function purge(id,t,c){
	Pace.restart();
	$.ajax({
		type:"GET",
		url:"core/purge.php",
		data:{
			id:id,
			t:t,
			c:c
		}
	}).done(function(msg){
		if(t=='iplist'||t=='tracker'||t=='logs'&&id==0){
			$('#l_'+t).addClass('animated zoomOut');
			setTimeout(function(){$('#l_'+t).remove();},500);
		}else{
			$('#l_'+id).addClass('animated zoomOut');
			setTimeout(function(){$('#l_'+id).remove();},500);
		}
		Pace.stop();
		$('[data-tooltip="tooltip"], .tooltip').tooltip('hide');
	});
}
function suggest(id){
	Pace.restart();
	$.ajax({
		type:"GET",
		url:"core/suggest.php",
		data:{
			id:id
		}
	}).done(function(msg){
		$('#sp').html(msg);
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
			$('#'+c+'image').attr('src','core/images/libre-gui-noimage.svg');
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
		if(t=='login'&&c=='avatar'&&da==''){
			$('.img-avatar').attr('src','core/images/libre-gui-noavatar.svg');
		}else{
			if(da==''){
				$('#'+c).html('');
			}else{
				$('#'+c).html('<img src="media/'+da+'">');
			}
		}
	})
}
function insertAtCaret(aId,t) {
	var ta=document.getElementById(aId);
	var sP=ta.scrollTop;
	var cP=ta.selectionStart;
	var f=(ta.value).substring(0,cP);
	var b=(ta.value).substring(ta.selectionEnd,ta.value.length);
	ta.value=f+t+b;
	cP=cP+t.length;
	ta.selectionStart=cP;
	ta.selectionEnd=cP;
	ta.focus();
	ta.scrollTop=sP;
}
function removeStopWords(id,txt){
	Pace.restart();
//	$('#block').css({'display':'block'});
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
function makeClient(id){
	Pace.restart();
//	$('#busy').css({'display':'block'});
	$('#sp').load('core/add_data.php?id='+id+'&act=make_client');
}
function changeClient(id,oid,w){
	Pace.restart();
	if(w=='booking'){
		$('#sp').load('core/change_bookingClient.php?id='+id+'&bid='+oid);
	}else{
		if(id==0){
			$('#sp').load('core/change_orderClient.php?id='+id+'&oid='+oid);
			$('.oce').attr('readonly','readonly');
			$('.ocesave').addClass('hidden');
			$('.ocehelp').removeClass('hidden');
		}else{
			$('#sp').load('core/change_orderClient.php?id='+id+'&oid='+oid);
			$('.oce').removeAttr('readonly');
			$('.ocesave').removeClass('hidden');
			$('.ocehelp').addClass('hidden');
		}
	}
	Pace.stop();
}
function reload(c){
	location.reload(true);
}
function loadMore(l,is,ie,action,lang){
	Pace.restart();
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
		Pace.stop();
//		$('#block').css({'display':'none'});
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
