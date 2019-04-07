<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Displays Bookings
 *
 * bookings.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Bookings
 * @package    core/layout/bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Move Settings to Header
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
if($view=='add'){
  $ti=time();
  $q=$db->prepare("INSERT INTO `".$prefix."content` (uid,contentType,status,ti,tis) VALUES (:uid,'booking','unconfirmed',:ti,:tis)");
  $q->execute([':uid'=>$user['id'],':ti'=>$ti,':tis'=>$ti]);
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
  <ol class="breadcrumb shadow">
    <li class="breadcrumb-item active"><?php echo localize('Bookings');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo URL.$settings['system']['admin'].'/add/bookings';?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Add');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-add');?></a>
        <a href="#" class="btn btn-ghost-normal info<?php echo(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' d-none':'');?>" onclick="toggleCalendar();return false;" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Switch to Table View');?>" role="button" aria-label="<?php echo localize('aria_view_table');?>"><?php svg('libre-gui-table');?></a>
        <a href="#" class="btn btn-ghost-normal info<?php echo(isset($_COOKIE['bookingview'])&&$_COOKIE['bookingview']=='calendar'?' d-none':'');?>" onclick="toggleCalendar();return false;" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Switch to Calendar View');?>" role="button" aria-label="<?php echo localize('aria_view_calendar');?>"><?php svg('libre-gui-calendar');?></a>
        <?php if($help['bookings_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['bookings_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['bookings_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['bookings_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-role="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <div id="calendar-view" class="col<?php echo(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' d-none':'');?>">
          <small><?php echo localize('Legend');?>: <span class="badge badge-success" data-tooltip="tooltip" title="<?php echo localize('Bookings that have been Confirmed');?>"><?php echo localize('Confirmed');?></span> <span class="badge badge-danger" data-tooltip="tooltip" title="<?php echo localize('Bookings that have NOT been Confirmed');?>"><?php echo localize('Unconfirmed');?></span></small>
          <div id="calendar"></div>
        </div>
        <div id="table-view" class="table-responsive<?php echo(isset($_COOKIE['bookingview'])&&$_COOKIE['bookingview']=='calendar'?' d-none':'');?>">
          <table class="table table-condensed table-striped table-hover" role=table>
            <thead>
              <tr role="row">
                <th class="col" role="columnheader"></th>
                <th class="col-sm-3" role="columnheader"></th>
              </tr>
            </thead>
            <tbody id="bookings">
<?php $s=$db->query("SELECT * FROM `".$prefix."content` WHERE contentType='booking' ORDER BY ti DESC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
              <tr id="l_<?php echo$r['id'];?>" class="<?php echo$r['status']=='unconfirmed'?' danger':'';?>" role="row">
                <td role="cell">
                  <?php echo date($config['dateFormat'],$r['ti']).'<br>'.localize('Start').': '.date($config['dateFormat'],$r['tis']).($r['tie']>$r['tis']?'<br>'.localize('End').': ' . date($config['dateFormat'], $r['tie']):'').($r['business']!=''?'<br>'.localize('Business').': '.$r['business']:'').($r['name']!=''?'<br>'.localize('Name').': '.$r['name']:'').($r['email']!=''?'<br>'.localize('Email').': <a href="mailto:'.$r['email'].'">'.$r['email'].'</a>':'').($r['phone']!=''?'<br>Phone'.': '.$r['phone']:'');?>
                </td>
                <td id="controls_<?php echo$r['id'];?>" role="cell">
                  <div class="btn-group float-right" role="group">
                    <a class="btn btn-secondary" href="<?php echo URL.$settings['system']['admin'];?>/bookings/edit/<?php echo$r['id'];?>" data-tooltip="tooltip" title="<?php echo localize('Edit');?>" role="button" aria-label="<?php echo localize('aria_edit');?>"><?php svg('libre-gui-edit');?></a>
                    <button class="btn btn-secondary<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-tooltip="tooltip" title="<?php echo localize('Restore');?>" role="button" aria-label="<?php echo localize('aria_restore');?>"><?php svg('libre-gui-untrash');?></button>
                    <button class="btn btn-secondary trash<?php echo($r['status']=='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                    <button class="btn btn-secondary trash<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="purge('<?php echo $r['id'];?>','content')" data-tooltip="tooltip" title="<?php echo localize('Purge');?>" role="button" aria-label="<?php echo localize('aria_purge');?>"><?php svg('libre-gui-purge');?></button>
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
<script>
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
  $bs->execute([':id'=>$r['rid']]);
  $br=$bs->fetch(PDO::FETCH_ASSOC);?>
      {
        id:'<?php echo$r['id'];?>',
        title:'<?php if($br['contentType']=='events'){echo localize('Event').': '.$br['title'];}elseif($br['contentType']!=''){echo ucfirst(rtrim($br['contentType'],'s')).': '.$br['title'];}else echo$r['name'];?>',
        start:'<?php echo date("Y-m-d H:i:s",$r['tis']);?>',
<?php echo$r['tie']>$r['tis']?'eventend: \''.date("Y-m-d H:i:s",$r['tie']).'\',':'';?>
        allDay:false,
        color:'<?php echo$r['status']=='confirmed'?'#4dbd74':'#f86c6b';?>',
        description:'<?php echo($r['business']!=''?localize('Business').': '.$r['business'].'<br>':'').($r['name']!=''?localize('Name').': '.$r['name'].'<br>':'').($r['email']!=''?localize('Email').': <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>':'').($r['phone']!=''?localize('Phone').': '.$r['phone'].'<br>':'');?>',
        status:'<?php echo$r['status'];?>',
      },
<?php	}?>
    ],
    eventMouseover:function(event,domEvent,view){
      var layer='<div id="events-layer" class="btn-group float-right">';
      if(event.status=="unconfirmed")layer+='<button id="cbut'+event.id+'" class="btn btn-secondary btn-sm add" data-tooltip="tooltip" title="<?php echo localize('Confirm');?>" role="button" aria-label="<?php echo localize('aria_approve');?>"><?php svg('libre-gui-approve');?></button> ';
      layer+='<button id="edbut'+event.id+'" class="btn btn-secondary btn-sm" data-tooltip="tooltip" title="<?php echo localize('Edit');?>" role="button" aria-label="<?php echo localize('aria_edit');?>"><?php svg('libre-gui-edit');?></button><button id="delbut'+event.id+'" class="btn btn-secondary btn-sm trash" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button></div>';
      var content="<?php echo localize('Start');?>: "+$.fullCalendar.moment(event.start).format('HH:mm');
<?php echo$r['tie']>$r['tis']?'content+=\'<br>'.localize('End').': \'+$.fullCalendar.moment(event.eventend).format(\'HH:mm\');':'';?>
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
</script>
<?php }
