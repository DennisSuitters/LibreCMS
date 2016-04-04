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
        <link rel="stylesheet" type="text/css" href="core/css/libreicons.css">
        <link rel="stylesheet" type="text/css" href="core/css/summernote.css">
        <link rel="stylesheet" type="text/css" href="core/css/featherlight.min.css">
        <link rel="stylesheet" type="text/css" href="core/css/admin.css">
    </head>
    <body>
        <div id="top" class="hidden"></div>
        <div class="nav-side-menu shadow-depth-2">
            <div class="profile clearfix">
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"><?php if($user['name']!='')echo$user['name'];else echo$user['username'];?></div>
                    <div class="profile-usertitle-job"><?php echo$rankText;?></div>
                </div>
                <div class="profile-sidebar">
                    <div class="profile-userpic">
                        <img class="img-thumbnail shadow-depth-1" src="<?php if($user['avatar']!=''&&file_exists('media/avatar/'.$user['avatar']))	echo'media/avatar/'.$user['avatar'];elseif($user['gravatar']!=''){if(stristr($user['gravatar'],'@'))echo'http://gravatar.com/avatar/'.md5($user['gravatar']);elseif(stristr($user['gravatar'],'gravatar.com/avatar/'))echo$user['gravatar'];else echo$noavatar;}else echo$noavatar;?>">
                    </div>
                </div>
            </div>
            <hr>
            <div class="menu-list">
                <ul id="menu-content" class="menu-content">
                    <li<?php if($view=='dashboard')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/dashboard';?>"><i class="libre libre-chart-line" name="Dashboard"></i><span>Dashboard</span></a></li>
                    <li<?php if($view=='pages')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>"><i class="libre libre-content" name="Pages"></i><span>Pages</span></a></li>
                    <li<?php if($view=='content'||$view=='article'||$view=='portfolio'||$view=='events'||$view=='news'||$view=='testimonials'||$view=='inventory'||$view=='services'||$view=='gallery')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><i class="libre libre-content" name="Content"></i><span>Content</span></a></li>
<?php if($user['rank']==1000||$user['options']{1}==1){?>
                    <li<?php if($view=='bookings')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>"><i class="libre libre-calendar" name="Bookings"></i><span>Bookings</span></a></li>
<?php }
    if($user['rank']==1000||$user['options']{2}==1){?>
                    <li<?php if($view=='orders')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/orders/all';?>"><i class="libre libre-order" name="Orders"></i><span>Orders</span></a></li>
<?php }
    if($user['rank']==1000||$user['options']{3}==1){?>
                    <li<?php if($view=='media')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/media';?>"><i class="libre libre-picture" name="Media"></i><span>Media</span></a></li>
<?php }?>
                    <li<?php if($view=='messages')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><i class="libre libre-mail" name="Messages"></i><span>Messages</span><a></li>
                    <li<?php if($view=='accounts')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"><i class="libre libre-users" name="Accounts"></i><span>Accounts</span></a></li>
                    <li<?php if($view=='preferences')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><i class="libre libre-settings" name="Preferences"></i><span>Preferences</span></a></li>
<?php if($user['rank']>899){?>
                    <li<?php if($view=='activity')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/activity';?>"><i class="libre libre-activity" name="Activity"></i><span>Activity</span></a></li>
<?php }?>
                    <li<?php if($view=='search')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/search';?>"><i class="libre libre-search" name="Search"></i><span>Search</span></a></li>
                </ul>
            </div>
<?php if($config['maintenance']{0}==1){?>
            <div class="alert alert-warning">Note: Site is currently in <a href="<?php echo URL.$settings['system']['admin'].'/preferences#interface';?>">Maintenance Mode</a></div>
<?php }?>
            <footer class="hidden-xs">
                <div class="brand">
                    <img src="core/images/librecms.png" alt="LibreCMS">
                </div>
                <ul>
                    <li><a href="<?php echo URL.$settings['system']['admin'].'/logout';?>" title="Sign Out"><i class="libre libre-sign-out"></i></a></li>
                    <li><a target="_blank" href="https://github.com/StudioJunkyard/LibreCMS/wiki" title="Wiki"><i class="libre libre-social-wikipedia"></i></li>
                    <li><a href="<?php echo URL;?>" title="Front"><i class="libre libre-desktop"></i></a></li>
                </ul>
            </footer>
        </div>
        <main id="content">
<?php if($view=='add'){
        if($args[0]=='bookings')
            require'core/layout/bookings.php';
        else require'core/layout/content.php';
    }else
        require'core/layout/'.$view.'.php';?>
        </main>
        <footer class="clearfix navbar navbar-default visible-xs">
            <span class="navbar-brand">
                <img src="core/images/librecms.png" alt="LibreCMS">
            </span>
            <ul class="nav navbar-nav pull-right">
                <li><a target="_blank" href="https://github.com/StudioJunkyard/LibreCMS"><i class="libre libre-social-github"></i></a></li>
                <li><a href="<?php echo URL;?>"><i class="libre libre-desktop"></i></a></li>
            </ul>
        </footer>
        <div class="notifications center"></div>
        <script src="core/js/jquery-2.1.3.min.js"></script>
        <script src="core/js/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="core/css/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="core/css/jquery-ui.theme.css">
        <link rel="stylesheet" type="text/css" href="core/elfinder/css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" href="core/elfinder/css/theme-bootstrap-libreicons.css">
        <script src="core/js/bootstrap.min.js"></script>
        <script src="core/js/summernote.js"></script>
        <script src="core/js/plugin/summernote-save-button/summernote-save-button.js"></script>
        <script src="core/js/plugin/summernote-image-attributes/summernote-image-attributes.js"></script>
        <script src="core/js/plugin/elfinder/elfinder.js"></script>
		<script src="core/elfinder/js/elfinder.min.js"></script>
        <script>
            function mediaDialog(){
                var fm=$('<div/>').dialogelfinder({
                    url:'<?php echo URL;?>core/elfinder/php/connector.php',
                    lang:'en',
                    width:840,
                    height:450,
                    destroyOnClose:true,
                    getFileCallback:function(files,fm){
                        $('.summernote').summernote('editor.insertImage',files.url);
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
            $().ready(function() {
               var f=$('#elfinder').elfinder({
                 url:'<?php echo URL;?>core/elfinder/php/connector.php',
               }).elfinder('instance');
             });
<?php }?>
            var unsaved=false;
            $(window).bind('beforeunload', function() {
                if(unsaved){
                    return "You have unsaved changes in the Editor. Do you want to leave this page and discard your changes or stay on this page?";
                }
            });
            $('.summernote').summernote({
                height:<?php if($view=='bookings'||$view=='preferences')echo'100';else echo'500';?>,
                tabsize:2,
                popover: {
                    image: [
                        ['custom', ['imageAttributes']],
                        ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']],
                    ],
                },
                toolbar:[
<?php if($view=='bookings'||$view=='preferences'){?>
                    ['save',['save']],
                    ['font',['bold','italic','underline']],
                    ['insert',['link','hr']],
<?php if($_SESSION['rank']>399){?>
                    ['view',['codeview']]
<?php }
    }else{?>
                    ['save',['save']],
                    ['style',['style']],
                    ['font',['bold','italic','underline','clear']],
                    ['fontname',['fontname']],
                    ['color',['color']],
                    ['para',['ul','ol','paragraph']],
                    ['height',['height']],
                    ['table',['table']],
                    ['insert',['media','link','hr']],
                    ['view',['fullscreen','codeview']],
                    ['help',['help']]
<?php }?>
                ]
            });
        </script>
        <script src="core/js/jquery.notifications.min.js"></script>
        <script src="core/js/featherlight.min.js"></script>
<?php if($view=='bookings'){?>
        <script src="core/js/moment.min.js"></script>
        <script src="core/js/fullcalendar.min.js"></script>
        <script>
<?php
if($view=='bookings'&&$args[0]!='add'||$args[0]!='edit'){?>
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
                    if(event.status=="unconfirmed")layer+='<span id="cbut'+event.id+'" class="btn btn-success btn-xs"><i class="libre libre-approve"></i></span> ';
                    layer+='<span id="edbut'+event.id+'" class="btn btn-info btn-xs"><i class="libre libre-edit"></i></span> <span id="delbut'+event.id+'" class="btn btn-danger btn-xs"><i class="libre libre-trash"></i></span></div>';
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
                    update(event.id,"content","tis",event.start.format('X'));
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
        <link href="core/css/cropper.min.css" rel="stylesheet">
        <script src="core/js/cropper.min.js"></script>
<?php if($view=='pages'){?>
        <script src="core/js/sortable.min.js"></script>
<?php }?>
        <script src="core/js/js.js"></script>
        <script>/*<![CDATA[*/
            $('#search').search_filter();
<?php		if($view=='pages'){?>
            $('#listtype').sortable({
                handle:'.handle',
                forcePlaceholderSize:true,
                placeholderClass:'sort-placeholder',
                items:':not(.disabled)',
                dragImage:$('.ghost')[0]
            }).bind('sortupdate',function(e,ui){
                var ord=$('#listtype').find('.item').map(function(){return $(this).data('id')}).get();
                var t=$('#listtype').data('t');
                var c=$('#listtype').data('c');
                $.ajax({
                    type:"GET",
                    url:"core/reorder.php",
                    data:{
                        t:t,
                        c:c,
                        ord:ord
                    }
                })
            });
<?php		}?>
            $(document).ready(function(){
                $(document).on("hidden.bs.modal",function (e){
                    $(e.target).removeData("bs.modal").find(".modal-content").empty()
                });
<?php		if($config['options']{4}==1){?>
                $('[data-toggle="tooltip"]').tooltip({
                    container:'body',
                    title:"Tooltip Content Not Set..."
                });
<?php		}
    if($view=='preferences'){?>
                $("div.theme-chooser").not(".disabled").find("div.theme-chooser-item").on("click",function(){
                    $('#theme .theme-chooser-item').removeClass("panel-success");
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
                    })(jQuery)
<?php		}?>
        });
        /*]]>*/</script>
        <div id="media" class="modal fade media">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="max-height:85%"></div>
            </div>
        </div>
        <iframe id="sp" name="sp" class="hidden"></iframe>
        <div id="block"><i class="libre libre-spinner-1 libre-5x libre-spin"></i></div>
    </body>
</html>
<?php }else require'core/layout/login.php';
