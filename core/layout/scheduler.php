<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/content';?>">Content</a></li>
    <li class="breadcrumb-item active" aria-current="page">Scheduler</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        <a class="btn btn-ghost-normal info" href="<?php echo URL.$settings['system']['admin'].'/content/settings';?>" data-tooltip="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings');?></a>
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
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</main>
<script src="core/js/moment.min.js"></script>
<script src="core/js/fullcalendar.min.js"></script>
<script>/*<![CDATA[*/
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
<?php $s=$db->query("SELECT * FROM `".$prefix."content`");
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
      var layer='<div id="events-layer" class="btn-group float-right">';
      layer+='<button id="edbut'+event.id+'" class="btn btn-secondary btn-sm" data-tooltip="tooltip" title="Edit"><?php svg('libre-gui-edit');?></button><button id="delbut'+event.id+'" class="btn btn-secondary btn-sm trash" data-tooltip="tooltip" title="Delete"><?php svg('libre-gui-trash');?></button></div>';
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
        window.top.window.$(".popover").remove();});$("#edbut"+event.id).click(function(){
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
/*]]>*/</script>
