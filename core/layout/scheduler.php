<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Content Scheduler
 *
 * scheduler.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Scheduler
 * @package    core/layout/scheduler.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item active" aria-current="page">Scheduler</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
<?php if($help['scheduler_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['scheduler_text'].'" data-tooltip="tooltip" data-placement="left" title="Help" savefrom_lm="false">'.svg2('libre-gui-help').'</a>';
if($help['scheduler_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['scheduler_video'].'" data-tooltip="tooltip" data-placement="left" title="Watch Video Help" savefrom_lm="false">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="alert alert-info">Not all the Scheduler Functions are currently working at this time, we are working on it though.</div>
    <div class="card">
      <div class="card-body">
        <div id="calendar-view" class="col">
          <small>Legend: <span class="badge badge-success" data-tooltip="tooltip" title="Content items that have already been Published">Published</span> <span class="badge badge-danger" data-tooltip="tooltip" title="Content items that have NOT been Published">Unpublished</span></small>
          <div class="float-right">
            <small>View: <a class="badge badge-<?php echo !isset($args[1])?'success':'secondary';?>" href="<?php echo URL.$settings['system']['admin'].'/content/scheduler';?>">All</a>
<?php $s=$db->query("SELECT DISTINCT(contentType) as contentType FROM `".$prefix."content` WHERE contentType!='booking' ORDER BY contentType ASC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
            <a class="badge badge-<?php echo isset($args[1])&&$args[1]==$r['contentType']?'success':'secondary';?>" href="<?php echo URL.$settings['system']['admin'].'/content/scheduler/'.$r['contentType'];?>"><?php echo ucfirst($r['contentType']);?></a>&nbsp;
<?php }?>
            </small>
          </div>
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
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
<?php
//$args[1]=!isset($args[1])||$args[1]==''?'%':$args[1];
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType LIKE :contentType");
$s->execute([':contentType'=>!isset($args[1])||$args[1]==''?'%':$args[1]]);
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
      {
        id:'<?php echo$r['id'];?>',
        title:'<?php echo ucfirst($r['contentType']);?>',
        start:'<?php echo date("Y-m-d H:i:s",$r['pti']);?>',
        allDay:false,
        color:'<?php echo($r['status']=='published'?'#4dbd74':'#f86c6b');?>',
        description:'<?php echo ucfirst($r['contentType']).': '.$r['title'];?>',
        status:'<?php echo $r['status'];?>',
      },
<?php	}?>
    ],
    eventMouseover:function(event,domEvent,view){
      var layer='<div id="events-layer" class="btn-group float-right"><button id="edbut'+event.id+'" class="btn btn-secondary btn-sm" data-tooltip="tooltip" title="Edit"><?php svg('libre-gui-edit');?></button><button id="delbut'+event.id+'" class="btn btn-secondary btn-sm trash" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button></div>';
      var content='Published: '+$.fullCalendar.moment(event.start).format('HH:mm');
      if(event.description!='')content+='<br>'+event.description;
      var el=$(this);
      el.append(layer);
      if(event.eventend!=''||event.eventend!=null||event.eventend!=0){
        var eventEndClass='eventEnd';
        $('[data-date="'+moment(event.eventend).format('YYYY-MM-DD')+'"]').addClass(eventEndClass);
      }
      $("#cbut"+event.id).click(function(){
        $("#cbut"+event.id).remove();
        $("#events-layer").remove();
        event.color="#4dbd74";
        event.status="published";
        updateButtons(event.id,"content","status","confirmed");
        $("#calendar").fullCalendar("updateEvent",event);
      });
      $("#delbut"+event.id).click(function(){
        $('#calendar').fullCalendar('removeEvents',event.id);
        window.top.window.purge(event.id,"content");
        window.top.window.$(el).remove();
        window.top.window.$(".popover").remove();
      });
      $("#edbut"+event.id).click(function(){
        window.location="<?php echo$settings['system']['admin'];?>/content/edit/"+event.id;
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
      if(event.status=='published')eventEndClass='eventEndConfirmed';
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
      updateButtons(event.id,"content","pti",event.start.unix());
      if(event.start.unix()>moment().unix()){
        updateButtons(event.id,"content","status","unpublished");
        event.color="#f86c6b";
        event.status="unpublished";
        $("#calendar").fullCalendar("updateEvent",event);
      }
    }
  });
  $(window).resize(function(){
    var calHeight=$(window).height()*0.83;
    $('#calendar').fullCalendar('option','height',calHeight);
  });
</script>
