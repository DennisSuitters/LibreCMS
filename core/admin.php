<?php require'core/db.php';
$config=$this->getconfig($db);
$ti=time();
$favicon=$this->favicon();
$share_image=$favicon;
$noimage=$this->noimage();
$noavatar=$this->noavatar();
$sp=$db->prepare("SELECT * FROM menu WHERE contentType=:contentType");
$sp->execute(array(':contentType'=>$view));
require'core/login.php';
if($_SESSION['rank']>399){
    if(isset($_SESSION['rank'])){
    	if($_SESSION['rank']==100)$rankText='Subscriber';
    	if($_SESSION['rank']==200)$rankText='Member';
    	if($_SESSION['rank']==300)$rankText='Client';
    	if($_SESSION['rank']==400)$rankText='Contributor';
    	if($_SESSION['rank']==500)$rankText='Author';
    	if($_SESSION['rank']==600)$rankText='Editor';
    	if($_SESSION['rank']==700)$rankText='Moderator';
    	if($_SESSION['rank']==800)$rankText='Manager';
    	if($_SESSION['rank']==900)$rankText='Administrator';
    	if($_SESSION['rank']==1000)$rankText='Developer';
    }else $rankText='Visitor';?>
<!DOCTYPE HTML>
<html lang="<?php echo$config['language'];?>" id="libreCMS">
    <head>
        <meta name="generator" content="LibreCMS">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>Administration - LibreCMS</title>
        <base href="<?php echo URL;?>">
        <link rel="alternate" media="handheld" href="<?php echo URL;?>">
        <link rel="alternate" hreflang="x-default" href="<?php echo URL;?>">
        <link rel="alternate" hreflang="AU-en" href="<?php echo URL;?>">
        <link rel="icon" href="<?php echo URL.$favicon;?>">
        <link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
        <meta name="viewport" content="initial-scale=1.0">
        <script src="core/js/pace.min.js"></script>
        <link rel="stylesheet" type="text/css" href="core/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="core/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" type="text/css" href="core/css/libreicons-svg.css">
        <link rel="stylesheet" type="text/css" href="core/css/summernote.css">
        <link rel="stylesheet" type="text/css" href="core/css/featherlight.min.css">
        <link rel="stylesheet" type="text/css" href="core/css/bootstrap-tokenfield.min.css">
        <link rel="stylesheet" type="text/css" href="core/css/tokenfield-typeahead.min.css">
        <link rel="stylesheet" type="text/css" href="core/css/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="core/elfinder/css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" href="core/elfinder/css/theme-bootstrap-libreicons-svg.css">
        <link rel="stylesheet" type="text/css" href="core/css/style.css">
    </head>
    <body>
        <div id="sidemenu">
            <a href="#menu-toggle" class="btn btn-primary" id="menu-toggle"><?php svg('layout-list');?></a>
        <aside class="nav-side-menu">
            <div class="profile clearfix">
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"><?php if($user['name']!='')echo$user['name'];else echo$user['username'];?></div>
                    <div class="profile-usertitle-job"><?php echo$rankText;?></div>
                </div>
                <div class="profile-sidebar">
                    <div class="profile-userpic">
                        <img id="menu_avatar" class="img-thumbnail" src="<?php if($user['avatar']!=''&&file_exists('media/avatar/'.$user['avatar']))	echo'media/avatar/'.$user['avatar'];elseif($user['gravatar']!=''){if(stristr($user['gravatar'],'@'))echo'http://gravatar.com/avatar/'.md5($user['gravatar']);elseif(stristr($user['gravatar'],'gravatar.com/avatar/'))echo$user['gravatar'];else echo$noavatar;}else echo$noavatar;?>">
                    </div>
                </div>
            </div>
            <div class="menu-list">
                <ul id="menu-content" class="menu-content">
                    <li<?php if($view=='dashboard')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/dashboard';?>"><?php svg('chart-line');?> Dashboard</a></li>
                    <li<?php if($view=='pages')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>"><?php svg('content');?> Pages</a></li>
                    <li<?php if($view=='content'||$view=='article'||$view=='portfolio'||$view=='events'||$view=='news'||$view=='testimonials'||$view=='inventory'||$view=='services'||$view=='gallery')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php svg('content');?> Content</a></li>
                    <li<?php if($view=='bookings')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>"><?php svg('calendar');?> Bookings</a></li>
                    <li<?php if($view=='orders')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/orders/all';?>"><?php svg('order');?> Orders</a></li>
                    <li<?php if($view=='media')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/media';?>"><?php svg('picture');?> Media</a></li>
                    <li<?php if($view=='messages')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('envelope');?> Messages<a></li>
                    <li<?php if($view=='accounts')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"><?php svg('users');?> Accounts</a></li>
                    <li<?php if($view=='preferences')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php svg('settings');?> Preferences</a></li>
                    <li<?php if($view=='activity')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/activity';?>"><?php svg('activity');?> Activity</a></li>
                    <li class="search<?php if($view=='search')echo' active';?>">
                        <form class="" method="post" action="admin/search">
                            <?php svg('search');?>
                            <input class="form-control" type="search" name="search" value="" placeholder="Search" onblur="$(this).val('');$('#menu_search_icon').toggleClass('hidden');" onfocus="$('#menu_search_icon').toggleClass('hidden');">
                        </form>
                    </li>
                </ul>
            </div>
            <footer>
                <ul>
                    <li><img class="logo" src="core/images/librecms-white-60.png"></li>
                    <li><a class="btn btn-libre btn-xs" target="_blank" href="https://github.com/StudioJunkyard/LibreCMS/wiki" title="Wiki"><?php svg('social-wikipedia');?></a></li>
                    <li><a class="btn btn-libre btn-xs" href="<?php echo URL;?>" title="Front"><?php svg('desktop');?></i></a></li>
                    <li><a class="btn btn-libre btn-xs" href="<?php echo URL.$settings['system']['admin'].'/logout';?>" title="Sign Out"><?php svg('sign-out');?></a></li>
                </ul>
            </footer>
        </aside>
    </div>
        <main id="content">
<?php if($view=='add'){
        if($args[0]=='bookings')
            require'core/layout/bookings.php';
        else require'core/layout/content.php';
    }else
        require'core/layout/'.$view.'.php';?>
        </main>
        <div class="notifications center"></div>
        <script src="core/js/jquery-2.1.3.min.js"></script>
        <script src="core/js/jquery-ui.min.js"></script>
        <script src="core/js/bootstrap.min.js"></script>
        <script src="core/js/bootstrap-tokenfield.min.js"></script>
        <script src="core/js/summernote.js"></script>
        <script src="core/js/plugin/summernote-save-button/summernote-save-button.js"></script>
        <script src="core/js/plugin/summernote-image-attributes/summernote-image-attributes.js"></script>
        <script src="core/js/plugin/summernote-cleaner/summernote-cleaner.js"></script>
        <script src="core/js/plugin/elfinder/elfinder.js"></script>
		<script src="core/elfinder/js/elfinder.min.js"></script>
        <script>
            var btn=$.fn.button.noConflict();
            $.fn.btn=btn;
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#sidemenu,#content").toggleClass("toggled");
            });
<?php $st=$db->prepare("SELECT DISTINCT tags FROM content");
$st->execute();
$tags='';
while($sr=$st->fetch(PDO::FETCH_ASSOC)){
    if($sr['tags']!=''){
        $tgs=explode(',',$sr['tags']);
        foreach($tgs as $ts){
            if(stristr($tags,$ts))continue;
            $tags.="'".$ts."',";
        }
    }
}?>
            $('#tags').tokenfield({
              autocomplete:{
                source: [<?php echo$tags;?>],
                delay:100
              },
              showAutocompleteOnFocus:false
            })
            function mediaDialog(id,t,c){
                var fm=$('<div/>').dialogelfinder({
                    url:'<?php echo URL;?>core/elfinder/php/connector.php',
                    lang:'en',
                    width:840,
                    height:450,
                    destroyOnClose:true,
                    uiOptions:{
                        cwd:{
                            getClass:function(file){
                                if(file.name.match(/archive/i)){
                                    return'archive-folder';
                                }else if(file.name.match(/attachment/i)){
                                    return'attachments-folder';
                                }else if(file.name.match(/avatar|user|users/i)){
                                    return'users-folder';
                                }else if(file.name.match(/backup/i)){
                                    return'backup-folder';
                                }else if(file.name.match(/carousel|featured/i)){
                                    return'featured-folder';
                                }else if(file.name.match(/order/i)){
                                    return'orders-folder';
                                }else if(file.name.match(/photo|picture|image/i)){
                                    return'picture-folder';
                                }else if(file.name.match(/doc/i)){
                                    return'document-folder';
                                }else if(file.name.match(/vid|mov/i)){
                                    return'video-folder';
                                }else{
                                    return'';
                                }
                            }
                        }
                    },
                    getFileCallback:function(files,fm){
                        if(id>0){
                            $('#block').css({display:'block'});
                            $('#'+c).val(files.url);
                            $('#'+c+'image').attr('src',files.url);
                            update(id,t,c,files.url);
                        }else{
                            $('.summernote').summernote('editor.insertImage',files.url);
                        }
                    },
                    commandsOptions:{
                        getfile:{
                            oncomplete:'close',
                            folders:false
                        }
                    }
                }).dialogelfinder('instance');
            }
<?php if($view=='media'){?>
            $().ready(function(){
                var f=$('#elfinder').elfinder({
                    url:'<?php echo URL;?>core/elfinder/php/connector.php',
                    handlers:{
                      dblclick:function(e,eI){
                        e.preventDefault();
                        eI.exec('getfile')
                          .done(function(){eI.exec('quicklook');})
                          .fail(function(){eI.exec('open');});
                      }
                    },
                    uiOptions:{
                        cwd:{
                            getClass:function(file){
                                if(file.name.match(/archive/i)){
                                    return'archive-folder';
                                }else if(file.name.match(/attachment/i)){
                                    return'attachments-folder';
                                }else if(file.name.match(/avatar|user|users/i)){
                                    return'users-folder';
                                }else if(file.name.match(/backup/i)){
                                    return'backup-folder';
                                }else if(file.name.match(/carousel|featured/i)){
                                    return'featured-folder';
                                }else if(file.name.match(/order/i)){
                                    return'orders-folder';
                                }else if(file.name.match(/photo|picture|image/i)){
                                    return'picture-folder';
                                }else if(file.name.match(/doc/i)){
                                    return'document-folder';
                                }else if(file.name.match(/vid|mov/i)){
                                    return'video-folder';
                                }else{
                                    return'';
                                }
                            }
                        }
                    },
                    getFileCallback:function(){
                      return false;
                    },
                }).elfinder('instance');
            });
<?php }?>
            var unsaved=false;
            $(window).bind('beforeunload',function(){
                if(unsaved){
                    return"You have unsaved changes in the Editor. Do you want to leave this page and discard your changes or stay on this page?";
                }
            });
            $('.summernote').summernote({
                height:<?php if($view=='bookings'||$view=='orders'||$view=='preferences'||$view=='accounts')echo'100';else echo'300';?>,
                tabsize:2,
                popover:{
                    image:[
                        ['custom',['imageAttributes']],
                        ['imagesize',['imageSize100','imageSize50','imageSize25']],
                        ['float',['floatLeft','floatRight','floatNone']],
                        ['remove',['removeMedia']],
                    ],
                },
                toolbar:[
                    ['save',['save']],
                    ['cleaner',['cleaner']],
                    ['style',['style']],
                    ['font',['bold','italic','underline','clear']],
                    ['fontname',['fontname']],
                    ['fontsize',['fontsize']],
                    ['color',['color']],
                    ['para',['ul','ol','paragraph']],
                    ['height',['height']],
                    ['table',['table']],
                    ['insert',['media','link','hr']],
                    ['view',['fullscreen','codeview']],
                    ['help',['help']]
                ]
            });
        </script>
        <script src="core/js/jquery.notifications.min.js"></script>
        <script src="core/js/featherlight.min.js"></script>
<?php if($view=='bookings'){?>
        <script src="core/js/moment.min.js"></script>
        <script src="core/js/fullcalendar.min.js"></script>
        <script>
<?php   if($args[0]!='add'||$args[0]!='edit'){?>
            $('#calendar').fullCalendar({
                header:{
                    left:'prev,next',
                    center:'title',
                    right:'month,basicWeek,basicDay'
                },
                eventLimit:true,
                selectable:true,
                editable:true,
                height:$(window).height()*0.83,
                events:[
<?php			$s=$db->query("SELECT * FROM content WHERE contentType='booking'");
    while($r=$s->fetch(PDO::FETCH_ASSOC)){
        $bs=$db->prepare("SELECT contentType,title,tis,tie,ti FROM content WHERE id=:id");
        $bs->execute(array(':id'=>$r['rid']));
        $br=$bs->fetch(PDO::FETCH_ASSOC);?>
                    {
                        id:'<?php echo$r['id'];?>',
                        title:'<?php if($br['contentType']=='events'){?>Event: <?php echo$br['title'];}elseif($br['contentType']!=''){echo ucfirst(rtrim($br['contentType'],'s')).': '.$br['title'];}else echo$r['name'];?>',
                        start:'<?php if($br['contentType']=='events'){echo date("Y-m-d H:i:s",$r['ti']);}else{echo date("Y-m-d H:i:s",$r['tis']);}?>',
<?php				if($br['contentType']=='services'){
            if($r['tie']>$r['tis']){
        echo'End: '.date("Y-m-d H:i:s",$r['tie']).'\',';
            }
        }?>
                        allDay:false,
                        color:'<?php if($r['status']=='confirmed')echo'#5cb85c';else echo'#d9534f';?>',
                        description:'<?php if($r['business'])echo'Business: '.$r['business'].'<br>';
                        if($r['name'])echo'Name'.': '.$r['name'].'<br>';
                        if($r['email'])echo'Email'.': <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>';
                        if($r['phone'])echo'Phone'.': '.$r['phone'].'<br>';?>',
                        status:'<?php echo$r['status'];?>',
                    },
<?php			}?>
                ],
                eventMouseover:function(event,domEvent,view){
                    var layer='<div id="events-layer" class="fc-transparent">';
                    if(event.status=="unconfirmed")layer+='<span id="cbut'+event.id+'" class="btn btn-default btn-xs"><?php svg('approve');?></span> ';
                    layer+='<span id="edbut'+event.id+'" class="btn btn-default btn-xs"><?php svg('edit');?></span> <span id="delbut'+event.id+'" class="btn btn-default trash btn-xs"><?php svg('trash');?></span></div>';
                    var content='Start: '+$.fullCalendar.moment(event.start).format('HH:mm');
                    if(event.end>event.start)content+='<br>End: '+$.fullCalendar.moment(event.end).format('HH:mm');
                    if(event.description!='')content+='<br>'+event.description;
                    $(this).append(layer);
                    var el=$(this);
                    $("#cbut"+event.id).click(function(){
                        $("#cbut"+event.id).remove();
                        $("#events-layer").remove();
                        event.color="#5cb85c";
                        event.status="confirmed";
                        update(event.id,"content","status","confirmed");
                        $("#calendar").fullCalendar("updateEvent",event);
                    });
                    $("#delbut"+event.id).click(function(){
                        $('#calendar').fullCalendar('removeEvents', event.id);
                        window.top.window.purge(event.id,"content");
                        window.top.window.$(el).remove();
                        window.top.window.$(".popover").remove();

                    });
                    $("#edbut"+event.id).click(function(){
                        window.location="<?php echo$settings['system']['admin'];?>/bookings/edit/"+event.id;
                    });
                    $(this).popover({
                        title:event.title,
                        placement:"top",
                        html:true,
                        container:"body",
                        content:content,
                    }).popover("show")
                },
                eventMouseout:function(event){
                    $("#events-layer").remove();
                    $(this).not(event).popover("hide")
                },
                dayClick:function(date,jsEvent,view){
                    if(view.name=='month'||view.name=='basicWeek'){
                        $('#calendar').fullCalendar('changeView','basicDay');
                        $('#calendar').fullCalendar('gotoDate',date);
                    }
                },
                eventDrop:function(event){
                    $('#block').css({'display':'block'});
                    update(event.id,"content","tis",event.start.format());
                }
            });
            $(window).resize(function(){
                var calHeight=$(window).height()*0.83;
                $('#calendar').fullCalendar('option','height',calHeight);
            });
<?php 		}?>
        </script>
<?php }?>
        <script src="core/js/bootstrap-datetimepicker.min.js"></script>
        <script>
            $("#pti").datetimepicker({format:'M d, yyyy h:ii P'}).on('changeDate',function(ev){$('#block').css({display:'block'});update($('#pti').data("dbid"),'content','pti',ev.date)});
            $("#tis").datetimepicker({format:'M d, yyyy h:ii P'}).on('changeDate',function(ev){update($('#tis').data("dbid"),'content','tis',ev.date)});
            $("#tie").datetimepicker({format:'M d, yyyy h:ii P'}).on('changeDate',function(ev){update($('#tie').data("dbid"),'content','tie',ev.date)});
        </script>
        <script src="core/js/js.js"></script>
        <script>/*<![CDATA[*/
            $(document).ready(function(){
<?php if($view=='dashboard'){?>
                $('#commits').load('core/layout/git_commits.php');
<?php	}
	if($view=='pages'){?>
                $('#sortable').sortable({
                    items:"tr",
                    placeholder:".ghost",
                    helper:fixWidthHelper,
                    axis:"y",
                    update:function(e,ui){
                        var order=$("#sortable").sortable("serialize");
                        $.ajax({
                            type:"POST",
                            dataType:"json",
                            url:"core/reorder.php",
                            data:order
                        });
                    }
                }).disableSelection();
                function fixWidthHelper(e,ui){
                    ui.children().each(function(){
                        $(this).width($(this).width());
                    });
                    return ui;
                }
<?php		}?>
//                $(document).on("hidden.bs.modal",function (e){
//                    $(e.target).removeData("bs.modal").find(".modal-content").empty()
//                });
<?php		if($config['options']{4}==1){?>
                $('[data-toggle="tooltip"]').tooltip({
                    container:'body',
                    title:"Tooltip Content Not Set..."
                });
<?php		}
    if($view=='preferences'){?>
                $("div.theme-chooser").not(".disabled").find("div.theme-chooser-item").on("click",function(){
                    $('#preference-theme .theme-chooser-item').removeClass("panel-success");
                    $(this).addClass("panel-success");
                    update("1","config","theme",escape($(this).attr("data-theme")))
                });
<?php		}

    if($config['idleTime']!=0){?>
                idleTimer=null;
                idleState=false;
                idleWait=<?php echo$config['idleTime']*60000;?>;
                (function($){
                    $(document).ready(function(){
                        $('*').bind('mousemove keydown scroll',function(){
                            clearTimeout(idleTimer);
                            idleState=false;
                            idleTimer=setTimeout(function(){
                                var newUrl="<?php echo URL.$settings['system']['admin'].'/logout';?>";
                                document.location.href=newUrl;
                                idleState=true},idleWait);
                            });
                            $("body").trigger("mousemove");
                        });
                    })(jQuery);
<?php		}?>
        });
        /*]]>*/</script>
        <iframe id="sp" name="sp" class="hidden"></iframe>
        <div id="block"><div class="spinner"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div></div>
    </body>
</html>
<?php }else require'core/layout/login.php';
