<?php
require'core/db.php';
if(isset($_GET['previous']))header("location:".$_GET['previous']);
$config=$this->getconfig($db);
$ti=time();
$favicon=$this->favicon();
$share_image=$favicon;
$noimage=$this->noimage();
$noavatar=$this->noavatar();
$theme=parse_ini_file(THEME.DS.'theme.ini',TRUE);
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
  }else$rankText='Visitor';
$nous=$db->prepare("SELECT COUNT(id) AS cnt FROM login WHERE lti>:lti AND rank!=1000");
$nous->execute(array(':lti'=>time()-300));
$nou=$nous->fetch(PDO::FETCH_ASSOC);
$nc=$db->query("SELECT COUNT(status) AS cnt FROM comments WHERE contentType!='review' AND status='unapproved'")->fetch(PDO::FETCH_ASSOC);
$nr=$db->query("SELECT COUNT(id) AS cnt FROM comments WHERE contentType='review' AND  status='unapproved'")->fetch(PDO::FETCH_ASSOC);
$nm=$db->query("SELECT COUNT(status) AS cnt FROM messages WHERE status='unread'")->fetch(PDO::FETCH_ASSOC);
$po=$db->query("SELECT COUNT(status) AS cnt FROM orders WHERE status='pending'")->fetch(PDO::FETCH_ASSOC);
$nb=$db->query("SELECT COUNT(status) AS cnt FROM content WHERE contentType='booking' AND status!='confirmed'")->fetch(PDO::FETCH_ASSOC);
$nu=$db->query("SELECT COUNT(id) AS cnt FROM login WHERE activate!='' AND active=0")->fetch(PDO::FETCH_ASSOC);
$nt=$db->query("SELECT COUNT(id) AS cnt FROM content WHERE contentType='testimonial' AND status!='confirmed' AND active!=1")->fetch(PDO::FETCH_ASSOC);
$navStat=$nc['cnt']+$nr['cnt']+$nm['cnt']+$po['cnt']+$nb['cnt']+$nu['cnt']+$nt['cnt'];?>
<!DOCTYPE HTML>
<html lang="en-AU" id="libreCMS">
  <head>
    <meta charset="UTF-8">
    <meta name="generator" content="LibreCMS">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Administration - LibreCMS</title>
    <base href="<?php echo URL;?>">
    <link rel="alternate" media="handheld" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="x" href="<?php echo URL;?>">
    <link rel="alternate" hreflang="EN-au" href="<?php echo URL;?>">
    <link rel="icon" href="<?php echo URL.$favicon;?>">
    <link rel="apple-touch-icon" href="<?php echo URL.$favicon;?>">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="core/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="core/css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" type="text/css" href="core/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="core/css/summernote.css">
    <link rel="stylesheet" type="text/css" href="core/css/libreicons-svg.css">
    <link rel="stylesheet" type="text/css" href="core/css/featherlight.min.css">
    <link rel="stylesheet" type="text/css" href="core/css/bootstrap-tokenfield.min.css">
    <link rel="stylesheet" type="text/css" href="core/css/tokenfield-typeahead.min.css">
    <link rel="stylesheet" type="text/css" href="core/css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="core/elfinder/css/elfinder.min.css">
    <link rel="stylesheet" type="text/css" href="core/css/codemirror.css">
    <link rel="stylesheet" type="text/css" href="core/elfinder/css/theme-bootstrap-libreicons-svg.css">
    <link rel="stylesheet" type="text/css" href="core/css/style.css">
    <script src="core/js/jquery-2.1.3.min.js"></script>
    <script src="core/js/pace.min.js"></script>
    <script src="core/js/jquery-ui.min.js"></script>
    <script src="core/js/bootstrap.min.js"></script>
    <script src="core/js/bootstrap-tokenfield.min.js"></script>
    <script src="core/js/codemirror.js"></script>
    <script src="core/js/xml.js"></script>
    <script src="core/js/autorefresh.js"></script>
    <script src="core/js/htmlmixed.js"></script>
    <script src="core/js/matchbrackets.js"></script>
    <script src="core/js/matchtags.js"></script>
    <script src="core/js/hardwrap.js"></script>
    <script src="core/js/summernote.js"></script>
    <script src="core/js/plugin/summernote/plugins.php"></script>
    <script src="core/js/plugin/elfinder/elfinder.js"></script>
    <script src="core/elfinder/js/elfinder.min.js"></script>
    <script src="core/js/bootstrap-notify.min.js"></script>
    <script src="core/js/featherlight.min.js"></script>
    <script src="core/js/bootstrap-datetimepicker.min.js"></script>
    <script src="core/js/ion.sound.min.js"></script>
    <script src="core/js/bootstrap-contextmenu.js"></script>
  </head>
  <body>
    <div id="sidemenu">
      <aside class="nav-side-menu">
        <ul class="header">
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 500 90" id="librecms"><path id="libre" d="m 0,47.406885 0,-42.59302 7.79538,0.36704 7.79538,0.36705 0.33094,35.44523 0.33094,35.4452 18.06615,0 18.06615,0 0,6.7808 0,6.7808 -26.19247,0 -26.19246,0 z m 61.11576,11.7712 0,-30.82192 8.10719,0 8.10719,0 0,30.82192 0,30.8219 -8.10719,0 -8.10719,0 z m 29.93425,-14.1781 0,-44.99997 8.10719,0 8.1072,0 0,20.00034 c 0,18.47533 0.14842,19.79093 1.9466,17.25322 4.0697,-5.74329 14.44495,-8.70835 22.7433,-6.4996 11.82728,3.14802 18.23391,13.39351 18.15939,29.04051 -0.0516,10.8498 -1.7537,16.0869 -7.36694,22.6677 -4.74378,5.5614 -9.99938,7.5378 -20.04466,7.5378 -8.12241,0 -8.46571,-0.1302 -13.13629,-4.9834 l -4.79592,-4.9834 0,4.9834 0,4.9834 -6.85994,0 -6.85993,0 z m 37.24286,30.7783 c 4.63341,-3.8538 6.99733,-13.3406 5.2117,-20.9153 -3.05002,-12.9382 -19.02237,-15.9623 -24.84693,-4.7043 -0.76628,1.4811 -1.39324,6.6684 -1.39324,11.5274 0,8.4032 0.20701,9.0391 4.24068,13.0262 5.37055,5.3086 11.23884,5.6812 16.78779,1.066 z m 33.85099,-16.6002 0,-30.82192 6.85993,0 6.85994,0 0,5.15343 0,5.15339 4.38063,-5.05874 c 4.4859,-5.18033 9.6927,-7.31883 14.30025,-5.87331 2.00684,0.6296 2.51864,1.84563 2.50346,5.94804 -0.025,6.74831 -0.91885,7.80701 -6.56304,7.77361 -3.48685,-0.021 -5.59381,0.8436 -8.10719,3.3256 -3.39335,3.351 -3.39625,3.3697 -3.7899,24.2877 l -0.39394,20.9341 -8.02507,0 -8.02507,0 z m 61.54013,29.6413 c -2.16755,-0.5105 -5.8139,-2.0094 -8.10295,-3.3309 -11.51508,-6.6476 -15.33878,-25.3714 -8.38508,-41.0599 3.2772,-7.3938 5.57954,-9.73303 12.94552,-13.15292 18.75709,-8.70858 35.51564,3.72186 35.53997,26.36132 l 0.007,6.4726 -18.08528,0 -18.08527,0 0,2.9726 c 0,3.7713 6.13142,8.9937 11.7914,10.0433 3.92157,0.7272 12.26693,-0.4765 17.05457,-2.4598 1.64784,-0.6827 2.19361,0.2384 2.8999,4.8939 0.47851,3.1542 0.66414,5.9384 0.41249,6.1871 -0.25164,0.2488 -3.77927,1.3075 -7.83918,2.3528 -7.84318,2.0193 -13.74127,2.23 -20.15304,0.7199 z m 17.52098,-39.1961 c -2.19303,-9.1671 -11.40761,-11.8917 -18.04128,-5.3346 -2.00522,1.9821 -3.64584,4.7561 -3.64584,6.1644 0,2.403 0.69262,2.5606 11.2491,2.5606 l 11.24911,0 z M 63.27878,19.732905 c -2.29273,-1.78266 -3.41028,-3.80497 -3.41028,-6.17125 0,-4.9004 5.47505,-9.08885 10.56533,-8.08253 5.04697,0.99775 7.31208,3.50154 7.31208,8.08253 0,7.3411 -8.37037,10.91165 -14.46712,6.17125 z"/><path id="cms" d="m 295.74172,88.17648 c -12.07434,-3.0125 -21.63603,-10.8346 -26.9591,-22.0546 -2.93194,-6.18 -3.2676,-8.3439 -3.2676,-21.0656 0,-13.00958 0.28582,-14.75326 3.46824,-21.1578 4.17481,-8.4017 11.24319,-14.99379 20.70366,-19.30861 9.27036,-4.22811 27.39964,-5.0988 36.94386,-1.7743 5.89765,2.05431 6.25787,2.43226 6.63333,6.95978 0.34944,4.21402 0.12533,4.67743 -1.8709,3.86863 -29.77589,-12.06425 -55.27648,2.42716 -55.27648,31.4123 0,14.7828 6.7668,26.6388 18.37408,32.193 7.26829,3.478 22.76854,3.7914 31.36134,0.6342 3.00173,-1.1029 5.70162,-2.0052 5.99978,-2.0052 0.29816,0 0.36792,2.0804 0.15501,4.6232 -0.3496,4.1752 -0.87067,4.7846 -5.37616,6.2877 -6.30385,2.1031 -24.70728,2.9296 -30.88906,1.3873 z m 50.66222,-8.1692 c 0.44365,-5.1879 0.80664,-25.1859 0.80664,-44.43988 l 0,-35.00728 8.3065,0.36455 8.3065,0.36454 9.7562,25.8904 c 5.36591,14.23977 11.21365,30.32877 12.99495,35.75347 1.78131,5.4246 3.51079,10.6934 3.84331,11.7083 0.33252,1.0149 2.73963,-4.533 5.34913,-12.3288 3.96157,-11.835 16.44333,-45.68156 21.48093,-58.24939 1.2842,-3.20388 1.7967,-3.39041 9.3149,-3.39041 l 7.9558,0 0,23.11643 c 0,12.71403 0.3711,32.68667 0.82,44.38357 l 0.8161,21.2671 -5.0294,0 c -4.6352,0 -5.0906,-0.302 -5.809,-3.8527 -0.4288,-2.1191 -0.8094,-20.0112 -0.846,-39.7603 l -0.066,-35.90753 -2.9715,9.86301 c -1.6343,5.42467 -7.9284,22.62332 -13.9869,38.21922 l -11.01531,28.3561 -5.54784,0 -5.54784,0 -8.5066,-21.5753 C 372.1498,52.91588 365.83408,35.99469 362.79353,27.17961 l -5.52828,-16.02738 -0.0538,34.52055 c -0.0295,18.9863 -0.40165,36.601 -0.82684,39.1438 -0.74381,4.4481 -0.96289,4.6233 -5.78197,4.6233 l -5.00886,0 0.80663,-9.4326 z m 113.92106,8.1526 c -7.226,-1.7912 -9.5918,-3.4379 -9.5918,-6.6762 0,-6.2243 0.9259,-6.8359 6.6392,-4.386 16.2479,6.9671 32.0259,1.7342 32.0259,-10.6218 0,-7.4535 -2.9318,-11.0753 -12.7948,-15.8059 -12.5317,-6.0106 -15.9314,-8.4608 -19.2435,-13.86898 -3.3391,-5.45227 -3.8862,-15.34581 -1.1999,-21.70079 2.2274,-5.26936 9.5683,-11.51121 15.4306,-13.12042 6.2293,-1.70993 17.3592,-1.49993 22.7966,0.43012 3.3488,1.18867 4.4597,2.33958 4.7703,4.94186 0.7077,5.93039 -0.3501,7.02818 -4.7035,4.88146 -6.1823,-3.04858 -16.1941,-3.44873 -21.2278,-0.84841 -8.6601,4.47363 -10.9452,14.24779 -5.0599,21.6434 1.3203,1.65909 7.734,5.61576 14.2527,8.79256 15.2518,7.4328 17.5809,10.405 17.5809,22.4352 0,10.9761 -3.6651,17.2708 -12.5243,21.51 -6.5855,3.1512 -19.5015,4.2901 -27.1507,2.3939 z"/></svg>
          </li>
        </ul>
        <div class="menu-list">
          <ul id="menu-content" class="menu-content">
            <li<?php if($view=='dashboard')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/dashboard';?>"><?php svg('chart-line');?> Dashboard</a></li>
            <li<?php if($view=='pages')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/pages';?>"><?php svg('content');?> Pages</a></li>
            <li<?php if($view=='content'||$view=='article'||$view=='portfolio'||$view=='events'||$view=='news'||$view=='testimonials'||$view=='inventory'||$view=='services'||$view=='gallery')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/content';?>"><?php svg('content');?> Content</a></li>
            <li<?php if($view=='bookings')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>"><?php svg('calendar');?> Bookings</a></li>
            <li<?php if($view=='orders')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/orders/all';?>"><?php svg('order');?> Orders</a></li>
            <li<?php if($view=='rewards')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/rewards';?>"><?php svg('credit-card');?> Rewards</a></li>
            <li<?php if($view=='media')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/media';?>"><?php svg('picture');?> Media</a></li>
            <li<?php if($view=='messages')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/messages';?>"><?php svg('envelope');?> Messages</a></li>
            <li<?php if($view=='newsletters')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/newsletters';?>"><?php svg('newsletter');?> Newsletters</a></li>
            <li<?php if($view=='accounts')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/accounts';?>"><?php svg('users');?> Accounts</a></li>
            <li<?php if($view=='preferences')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php svg('settings');?> Preferences</a></li>
            <li<?php if($view=='activity')echo' class="active"';?>><a href="<?php echo URL.$settings['system']['admin'].'/activity';?>"><?php svg('activity');?> Activity</a></li>
            <li class="search<?php if($view=='search')echo' active';?>"><form class="" method="post" action="admin/search"><a href="<?php echo URL.$settings['system']['admin'].'/search';?>"><?php svg('search');?></a><input class="form-control" type="search" name="search" value="" placeholder="Search" onblur="$(this).val('');$('#menu_search_icon').toggleClass('hidden');" onfocus="$('#menu_search_icon').toggleClass('hidden');"></form></li>
          </ul>
        </div>
      </aside>
    </div>
    <header>
      <nav class="navbar navbar-inverse">
        <a href="#menu-toggle" class="navbar-brand" id="menu-toggle"><?php svg('layout-list');?></a>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php svg('bell','','2x');?><span id="nav-stat" class="badge animated rubberBand"><?php if($navStat>0)echo$navStat;?></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo URL.$settings['system']['admin'];?>/content"><span id="nav-nc"><?php echo$nc['cnt'];?></span> New Comments<?php svg('comments');?></a></li>
              <li><a href="<?php echo URL.$settings['system']['admin'];?>/content"><span id="nav-nr"><?php echo$nr['cnt'];?></span> New Reviews<?php svg('layout-timeline');?></a></li>
              <li><a href="<?php echo URL.$settings['system']['admin'];?>/messages"><span id="nav-nm"><?php echo$nm['cnt'];?></span> New Messages<?php svg('envelope');?></a></li>
              <li><a href="<?php echo URL.$settings['system']['admin'];?>/orders/pending"><span id="nav-po"><?php echo$po['cnt'];?></span> Pending Orders<?php svg('shopping-cart');?></a></li>
              <li><a href="<?php echo URL.$settings['system']['admin'];?>/bookings"><span id="nav-nb"><?php echo$nb['cnt'];?></span> New Bookings<?php svg('calendar');?></a></li>
              <li><a href="<?php echo URL.$settings['system']['admin'];?>/accounts"><span id="nav-nu"><?php echo$nu['cnt'];?></span> New Users<?php svg('users');?></a></li>
              <li><a href="<?php echo URL.$settings['system']['admin'];?>/content/type/testimonials"><span id="nav-nt"><?php echo$nt['cnt'];?></span> New Testimonials<?php svg('signature');?></a></li>
              <li><span id="nav-nou"><?php echo$nou['cnt'];?></span> Active Users <?php svg('users');?></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <div class="userpic"><img id="menu_avatar" src="<?php if($user['avatar']!=''&&file_exists('media/avatar/'.$user['avatar']))
                  echo'media/avatar/'.$user['avatar'];
                elseif($user['gravatar']!=''){
                  if(stristr($user['gravatar'],'@'))
                    echo'http://gravatar.com/avatar/'.md5($user['gravatar']);
                  elseif(stristr($user['gravatar'],'gravatar.com/avatar/'))
                    echo$user['gravatar'];
                  else echo'';
                }else echo'';?>"></div>
              <?php if($user['name']!='')echo$user['name'];else echo$user['username'];?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo$settings['system']['admin'].'/accounts/edit/'.$user['id'];?>">Settings <?php svg('cogs');?></a></li>
              <li><a target="_blank" href="core/vcard.php?u=<?php echo$user['username'];?>">vCard <?php svg('social-vcard');?></a></li>
              <li><a target="_blank" href="https://github.com/StudioJunkyard/LibreCMS/wiki">Help <?php svg('help');?></a></li>
              <li><a target="_blank" href="<?php echo URL;?>">View Site <?php svg('device-desktop');?></a></li>
              <li><a href="<?php echo URL.$settings['system']['admin'].'/logout';?>" title="Sign Out">Log Out <?php svg('sign-out');?></a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </header>
    <main id="content">
<?php if($view=='add'){
  if($args[0]=='bookings')
    require'core/layout/bookings.php';
  else
    require'core/layout/content.php';
}else
  require'core/layout/'.$view.'.php';?>
    </main>
    <script src="core/js/js.js"></script>
    <script>/*<![CDATA[*/
      var unsaved=false;
      $(window).bind('beforeunload',function(e){
        if(unsaved){
          return'You have unsaved changes in the Editor. Do you want to leave this page and discard your changes or stay on this page?';
        }
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
          source:[<?php echo$tags;?>],
          delay:100
        },
        showAutocompleteOnFocus:false
      });
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
              if(files.url.match(/\.(jpeg|jpg|gif|png)$/)){
                $('.summernote').summernote('editor.insertImage',files.url);
              }else{
                $('.summernote').summernote('createLink',{
                  text:files.name,
                  url:files.url,
                  newWindow:true
                });
              }
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
              eI.exec('getfile').done(function(){
                eI.exec('quicklook');
              }).fail(function(){
                eI.exec('open');
              });
            }},
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
        $('.summernote').summernote({
          height:<?php if($view=='bookings'||$view=='orders'||$view=='preferences'||$view=='accounts')echo'100';else echo'300';?>,
          codemirror:{
            theme:'default',
            lineNumbers:true,
            lineWrapping:true,
            mode:"text/html"
          },
          tabsize:2,
          styleTags:['p','blockquote','pre','h2','h3','h4','h5','h6'],
          popover:{
            image:
              [
                ['custom',['imageAttributes','imageShapes','captionIt']],
                ['imagesize',['imageSize100','imageSize50','imageSize25']],
                ['float',['floatLeft','floatRight','floatNone']],
                ['remove',['removeMedia']],
              ],
            link:
              [
                ['link',['linkDialogShow','unlink']]
              ],
            air:
              [
                ['color',['color']],
                ['font',['bold','underline','clear']],
                ['para',['ul','paragraph']],
                ['table',['table']],
                ['insert',['media','link','picture']]
              ]
          },
          lang:'en-US',
          toolbar:
            [
              ['save',['save']],
              ['cleaner',['cleaner','seo']],
              ['style',['style']],
              ['font',['bold','italic','underline','clear']],
              ['fontname',['fontname']],
              ['fontsize',['fontsize']],
              ['color',['color']],
              ['para',['ul','ol','paragraph']],
              ['height',['height']],
              ['table',['table']],
              ['insert',['videoAttributes','media','link','hr']],
              ['view',['fullscreen','codeview']],
              ['help',['help']]
            ],
            callbacks:{
              onInit:function(){
                $('body > .note-popover').appendTo(".note-editing-area");
              }
            }
        });
        $("#pti").datetimepicker({
          format:'M d, yyyy h:ii P'
        }).on('changeDate',function(ev){
          $('#block').css({display:'block'});
          update($('#pti').data("dbid"),'content','pti',ev.date)
        });
<?php if($view!='rewards'){?>
        $("#tis").datetimepicker({
          format:'M d, yyyy h:ii P'
        }).on('changeDate',function(ev){
          update($('#tis').data("dbid"),'content','tis',ev.date)
        });
<?php }else{?>
        $("#tis").datetimepicker();
<?php }?>
<?php if($view!='rewards'){?>
        $("#tie").datetimepicker({
          format:'M d, yyyy h:ii P'
        }).on('changeDate',function(ev){
          update($('#tie').data("dbid"),'content','tie',ev.date)
        });
<?php }else{?>
        $("#tie").datetimepicker();
<?php }?>
        $(document).ready(function(){
<?php if($config['options']{4}==1){?>
          $('[data-toggle="tooltip"]').tooltip({
            container:'body',
            title:"Tooltip Content Not Set..."
          });
<?php }
if($view=='preferences'){}
if($config['idleTime']!=0){?>
          idleTimer=null;
          idleState=false;
          idleWait=<?php echo$config['idleTime']*60000;?>;
          (function($){$(document).ready(function(){
            $('*').bind('mousemove keydown scroll',function(){
              clearTimeout(idleTimer);
              idleState=false;
              idleTimer=setTimeout(function(){
                idleState=true;
                unsaved=false;
                ion.sound.play("autologout");
                var newUrl="<?php echo URL.$settings['system']['admin'].'/logout';?>";
                document.location.href=newUrl;
              },idleWait);
            });
            $("body").trigger("mousemove");
          });
        })(jQuery);
<?php }?>
        $(function(){
          var hash=document.location.hash;
          if(hash){
            $('.nav-tabs a[href='+hash+']').tab('show');
          }
          $('a[data-toggle="tab"]').on('show.bs.tab',function(e){
            window.location.hash=e.target.hash;
          });
        });
      });
      $('[data-toggle="tooltip"]').on({
        mouseleave:function(){
          $('*').tooltip('hide');
        }
      });
<?php if($config['notification_volume']!=0){?>
      ion.sound({
        sounds:[
<?php if(file_exists('core/sounds/notification.mp3')||file_exists('core/sounds/notification.ogg')){?>
          {
            name:"notification"
          },
<?php }?>
        ],
        path:"core/sounds/",
        preload:true,
        multiplay:true,
        volume:<?php echo$config['notification_volume']/100;?>
      });
<?php }?>
        setInterval(function(){
          $.get("core/nav-stats.php",{},function(results){
            var stats=results.split(",");
            var navStat=$('#nav-stat').html();
            var stats=results.split(",");
            var navStat=$('#nav-stat').html();
            if(stats[0]==0)
              stats[0]='';
            $('#nav-nou').html(stats[1]);
            if(navStat<stats[0]){
  <?php if(file_exists('core/sounds/notification.mp3')||file_exists('core/sounds/notification.ogg')&&$config['notification_volume']!=0){?>
              ion.sound.play("notification");
  <?php }?>
            }
            $('#nav-stat').removeClass('rubberBand');
            $('#nav-stat').addClass('rubberBand');
            $('#nav-stat').html(stats[0]);
            $('#nav-nc').html(stats[2]);
            $('#nav-nr').html(stats[3]);
            $('#nav-nm').html(stats[4]);
            $('#nav-po').html(stats[5]);
            $('#nav-nb').html(stats[6]);
            $('#nav-nu').html(stats[7]);
            $('#nav-nt').html(stats[8]);
            if(stats[0]==0){
              document.title='Administration - LibreCMS';
            }else{
              document.title='('+stats[0]+') Administration - LibreCMS';
            }
          });
      },30000);
      $(document).ready(function(){
        var badge=<?php echo$navStat;?>;
        if(badge==0)document.title='Administration - LibreCMS';
        else document.title='('+badge+') Administration - LibreCMS';
<?php if($user['rank']>899){?>
        $('.fingerprint').popover({
          html:true,
          trigger:'click',
          title:'Fingerprint Analysis <button type="button" id="close" class="close" data-dismiss="popover">&times;</button>',
          container:'body',
          placement:'right',
          template:'<div class="popover fingerprint role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
          content:function(){
            var el=$(this).data("dbgid");
            var id=$('#'+el).data("dbid"),
                t=$('#'+el).data("dbt"),
                c=$('#'+el).data("dbc");
            return $.ajax({
              url:'core/layout/dataspy.php',
              dataType:'html',
              async:false,
              data:{
                id:id,
                t:t,
                c:c
              }
            }).responseText;
          }
        });
        $('[data-toggle="popover"]').each(function(){
          var button = $(this);
          button.popover().on('shown.bs.popover',function(){
            $('.popover').draggable({
              zIndex:2500,
              handle:'.popover-title',
              start:function(){
                $('.popover').css({'z-index':'2500'});
                $(this).css({'z-index':'2600'});
              },
              stop:function(){
                $(this).css({'z-index':'2600'});
              }
            });
            button.data('bs.popover')
                  .tip().find('[data-dismiss="popover"]')
                  .on('click',function(){
                    button.popover('hide');
                  });
          });
        });
        $('[data-toggle="tab"]').on('shown.bs.tab',function(){
          $('*').popover('hide');
        });
<?php }?>
      });
    /*]]>*/</script>
    <iframe id="sp" name="sp" class="hidden"></iframe>
    <div class="notifications center"></div>
    <div id="block">
      <div class="pace">
        <div class="pace-activity"></div>
      </div>
    </div>
<?php if(isset($_SESSION['rank'])&&$_SESSION['rank']>899){
  echo'<div class="help-block text-right" style="padding-right:20px;">Process Time: '.elapsed_time().'</div>';
}?>
  </body>
</html>
<?php }else
require'core/layout/login.php';
