<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if($view=='add'){
  $ti=time();
  $q=$db->prepare("INSERT INTO `".$prefix."content` (uid,contentType,status,ti,tis) VALUES (:uid,'booking','unconfirmed',:ti,:tis)");
  $q->execute(
    array(
      ':uid'=>$user['id'],
      ':ti'=>$ti,
      ':tis'=>$ti
    )
  );
  $id=$db->lastInsertId();
  $view='bookings';
  $args[0]='edit';
  echo'<script>/*<![CDATA[*/history.replaceState("","","'.URL.$settings['system']['admin'].'/bookings/edit/'.$id.'");/*]]>*/</script>';
}elseif(isset($args[1]))
  $id=$args[1];
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_bookings.php';
elseif($args[0]=='edit')
  include'core'.DS.'layout'.DS.'edit_bookings.php';
else{?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Bookings</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/add/bookings';?>" data-tooltip="tooltip" data-placement="left" title="Add"><?php svg('libre-gui-add');?></a>
        <a id="calendar-view" href="#" class="btn btn-ghost-normal info<?php echo(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' hidden':'');?>" onclick="toggleCalendar();return false;" data-tooltip="tooltip" data-placement="left" title="Switch to Table View"><?php svg('libre-gui-table');?></a>
        <a id="table-view" href="#" class="btn btn-ghost-normal info<?php echo(isset($_COOKIE['bookingview'])&&$_COOKIE['bookingview']=='calendar'?' hidden':'');?>" onclick="toggleCalendar();return false;" data-tooltip="tooltip" data-placement="left" title="Switch to Calendar View"><?php svg('libre-gui-calendar');?></a>
        <a class="btn btn-ghost-normal info" href="<?php echo URL.$settings['system']['admin'].'/bookings/settings';?>" data-tooltip="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings');?></a>
        <?php if($help['bookings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['bookings_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
        if($help['bookings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['bookings_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div id="calendar-view" class="col<?php echo(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' hidden':'');?>">
          <small>Legend: <span class="badge badge-success" data-tooltip="tooltip" title="Bookings that have been Confirmed">Confirmed</span> <span class="badge badge-danger" data-tooltip="tooltip" title="Bookings that have NOT been Confirmed">Unconfirmed</span></small>
          <div id="calendar"></div>
        </div>
        <div id="table-view" class="table-responsive<?php echo(isset($_COOKIE['bookingview'])&&$_COOKIE['bookingview']=='calendar'?' hidden':'');?>">
          <table class="table table-condensed table-striped table-hover">
            <thead>
              <tr>
                <th></th>
                <th class="col-xs-3"></th>
              </tr>
            </thead>
            <tbody id="bookings">
<?php $s=$db->query("SELECT * FROM `".$prefix."content` WHERE contentType='booking' ORDER BY ti DESC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>" class="<?php echo($r['status']=='unconfirmed'?' danger':'');?>">
                <td>
                  <small><?php echo date($config['dateFormat'],$r['ti']).'<br>Start: '.date($config['dateFormat'],$r['tis']).($r['tie']>$r['tis']?'<br>End: ' . date($config['dateFormat'], $r['tie']):'').($r['business']!=''?'<br>Business: '.$r['business']:'').($r['name']!=''?'<br>Name'.': '.$r['name']:'').($r['email']!=''?'<br>Email'.': <a href="mailto:'.$r['email'].'">'.$r['email'].'</a>':'').($r['phone']!=''?'<br>Phone'.': '.$r['phone']:'');?></small>
                </td>
                <td id="controls_<?php echo$r['id'];?>">
                  <div class="btn-group float-right">
                    <a class="btn btn-secondary" href="<?php echo URL.$settings['system']['admin'];?>/bookings/edit/<?php echo$r['id'];?>" data-tooltip="tooltip" title="Edit"><?php svg('libre-gui-edit');?></a>
                    <button class="btn btn-secondary<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-tooltip="tooltip" title="Restore"><?php svg('libre-gui-untrash');?></button>
                    <button class="btn btn-secondary trash<?php echo($r['status']=='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button>
                    <button class="btn btn-secondary trash<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="purge('<?php echo $r['id'];?>','content')" data-tooltip="tooltip" title="Purge"><?php svg('libre-gui-purge');?></button>
                  </div>
                </td>
              </tr>
<?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>
<script src="core/js/moment.min.js"></script>
<script src="core/js/fullcalendar.min.js"></script>
<script>/*<![CDATA[*/
<?php if($args[0]!='add'||$args[0]!='edit'){?>
  var $contextMenu=$("#contextMenu");
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
<?php $s=$db->query("SELECT * FROM `".$prefix."content` WHERE contentType='booking'");
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $bs=$db->prepare("SELECT contentType,title,tis,tie,ti FROM content WHERE id=:id");
  $bs->execute(array(':id'=>$r['rid']));
  $br=$bs->fetch(PDO::FETCH_ASSOC);?>
      {
        id:'<?php echo$r['id'];?>',
        title:'<?php if($br['contentType']=='events'){?>Event: <?php echo$br['title'];}elseif($br['contentType']!=''){echo ucfirst(rtrim($br['contentType'],'s')).': '.$br['title'];}else echo$r['name'];?>',
        start:'<?php echo date("Y-m-d H:i:s",$r['tis']);?>',
<?php echo($r['tie']>$r['tis']?'eventend: \''.date("Y-m-d H:i:s",$r['tie']).'\',':'');?>
        allDay:false,
        color:'<?php echo($r['status']=='confirmed'?'#4dbd74':'#f86c6b');?>',
        description:'<?php echo($r['business']!=''?'Business: '.$r['business'].'<br>':'').($r['name']!=''?'Name'.': '.$r['name'].'<br>':'').($r['email']!=''?'Email'.': <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>':'').($r['phone']!=''?'Phone'.': '.$r['phone'].'<br>':'');?>',
        status:'<?php echo $r['status'];?>',
      },
<?php	}?>
    ],
    eventMouseover:function(event,domEvent,view){
      var layer='<div id="events-layer" class="btn-group float-right">';
      if(event.status=="unconfirmed")layer+='<button id="cbut'+event.id+'" class="btn btn-secondary btn-sm add" data-tooltip="tooltip" title="Confirm"><?php svg('libre-gui-approve');?></button> ';
      layer+='<button id="edbut'+event.id+'" class="btn btn-secondary btn-sm" data-tooltip="tooltip" title="Edit"><?php svg('libre-gui-edit');?></button><button id="delbut'+event.id+'" class="btn btn-secondary btn-sm trash" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button></div>';
      var content='Start: '+$.fullCalendar.moment(event.start).format('HH:mm');
<?php echo($r['tie']>$r['tis']?'content+=\'<br>End: \'+$.fullCalendar.moment(event.eventend).format(\'HH:mm\');':'');?>
      if(event.description!='')content+='<br>'+event.description;
      var el=$(this);
      el.append(layer);
      if(event.eventend!=''||event.eventend!=null||event.eventend!=0){
        var eventEndClass='eventEnd';
        if(event.status=='confirmed')eventEndClass='eventEndConfirmed';
        $('[data-date="'+moment(event.eventend).format('YYYY-MM-DD')+'"]').addClass(eventEndClass);
      }
      $("#cbut"+event.id).click(function(){
        $("#cbut"+event.id).remove();
        $("#events-layer").remove();
        event.color="#4dbd74";
        event.status="confirmed";
        updateButtons(event.id,"content","status","confirmed");
        $("#calendar").fullCalendar("updateEvent",event);
      });
      $("#delbut"+event.id).click(function(){
        $('#calendar').fullCalendar('removeEvents',event.id);
        window.top.window.purge(event.id,"content");
        window.top.window.$(el).remove();
        window.top.window.$(".popover").remove();});$("#edbut"+event.id).click(function(){
          window.location="<?php echo$settings['system']['admin'];?>/bookings/edit/"+event.id;
        });
        $(this).popover({
          title:event.title,
          placement:"top",
          html:true,
          container:"body",
          content:content,
        }).popover("show");
      },
      eventMouseout:function(event){
        $("#events-layer").remove();
        $(this).not(event).popover("hide");
        var eventEndClass='eventEnd';
        if(event.status=='confirmed')eventEndClass='eventEndConfirmed';
        $('[data-date="'+moment(event.eventend).format('YYYY-MM-DD')+'"]').removeClass(eventEndClass);
        $('[data-tooltip="tooltip"], .tooltip').tooltip('hide');
      },
      dayClick:function(date,jsEvent,view){
        if(view.name=='month'||view.name=='basicWeek'){
          $('#calendar').fullCalendar('changeView','basicDay');
          $('#calendar').fullCalendar('gotoDate',date);
        }
      },
      eventDrop:function(event){
        Pace.restart();
        updateButtons(event.id,"content","tis",event.start.unix());
      }
    });
    $(window).resize(function(){
      var calHeight=$(window).height()*0.83;
      $('#calendar').fullCalendar('option','height',calHeight);
    });
<?php }?>
/*]]>*/</script>
<?php }
