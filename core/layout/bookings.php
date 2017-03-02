<?php
if($view=='add'){
  $ti=time();
  $q=$db->prepare("INSERT INTO content (uid,contentType,status,ti,tis) VALUES (:uid,'booking','unconfirmed',:ti,:tis)");
  $q->execute(array(':uid'=>$user['id'],':ti'=>$ti,':tis'=>$ti));
  $id=$db->lastInsertId();
  $view='bookings';
  $args[0]='edit';?>
<script>/*<![CDATA[*/
  history.replaceState('','','<?php echo URL.$settings['system']['admin'].'/bookings/edit/'.$id;?>');
/*]]>*/</script>
<?php }elseif(isset($args[1]))$id=$args[1];
if($args[0]=='settings')include'core'.DS.'layout'.DS.'set_bookings.php';
elseif($args[0]=='edit'){
  $s=$db->prepare("SELECT * FROM content WHERE id=:id");
  $s->execute(array(':id'=>$id));
  $r=$s->fetch(PDO::FETCH_ASSOC);
  $sr=$db->prepare("SELECT contentType FROM content where id=:id");
  $sr->execute(array(':id'=>$r['rid']));
  $rs=$sr->fetch(PDO::FETCH_ASSOC);?>
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Bookings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/bookings"';if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back';?>"><?php svg('back');?></a>
      </div>
      <div class="btn-group">
        <button class="btn btn-default" onclick="$('#sp').load('core/email_booking.php?id=<?php echo$r['id'];?>');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Email Booking"';?>><?php svg('email-send');?></button>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#bookings-edit"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div id="notifications"></div>
    <div class="form-group">
      <label for="tis" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Booked For</label>
      <div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="tis"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="tis" class="form-control" data-dbid="<?php echo$r['id'];?>" data-datetime="<?php echo date($config['dateFormat'],$r['tis']);?>"<?php if($user['options']{1}==0)echo' readonly';?>>
      </div>
    </div>
    <div class="form-group">
      <label for="tie" class="control-label col-xs-5 col-sm-3 col-lg-2">Booking End</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="tie"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="tie" class="form-control" data-dbid="<?php echo$r['id'];?>" data-datetime="<?php if($r['tie']!=0)echo date($config['dateFormat'],$r['tie']);else echo date($config['dateFormat'],$r['tis']);?>"<?php if($user['options']{1}==0)echo' readonly';?>>
      </div>
    </div>
    <div class="form-group">
      <label for="status" class="control-label col-xs-5 col-sm-3 col-lg-2">Status</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="status"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php if($user['options']{1}==0)echo' readonly';?> data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="status">
          <option value="unconfirmed"<?php if($r['status']=='unconfirmed')echo' selected';?>>Unconfirmed</option>
          <option value="confirmed"<?php if($r['status']=='confirmed')echo' selected';?>>Confirmed</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="changeClient" class="control-label col-xs-5 col-sm-3 col-lg-2">Client</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="changeClient"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <select id="changeClient" class="form-control" onchange="changeClient($(this).val(),<?php echo$r['id'];?>,'booking');" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid">
          <option value="0"<?php if($r['cid']=='0')echo' selected';?>>Select a Client...</option>
<?php $q=$db->query("SELECT id,business,username,name FROM login WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
  while($rs=$q->fetch(PDO::FETCH_ASSOC)){
    echo'<option value="'.$rs['id'].'"';
    if($rs['id']==$r['cid'])echo' selected="selected"';
    echo'>'.$rs['username'];
    if($rs['name']!='')echo' ['.$rs['name'].']';
    if($rs['business']!='')echo' -> '.$rs['business'].'</option>';
  }?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="control-label col-xs-5 col-sm-3 col-lg-2">Email</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="email"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="email" class="form-control textinput" name="email" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="Enter an Email...">
      </div>
    </div>
    <div class="form-group">
      <label for="phone" class="control-label col-xs-5 col-sm-3 col-lg-2">Phone</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="phone"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="phone" class="form-control textinput" name="phone" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone" placeholder="Enter a Phone Number...">
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="name"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="name" class="form-control textinput" name="name" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="Enter a Name...">
      </div>
    </div>
    <div class="form-group">
      <label for="business" class="control-label col-xs-5 col-sm-3 col-lg-2">Business</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="business"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="business" class="form-control textinput" name="business" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="Enter a Business...">
      </div>
    </div>
    <div class="form-group">
      <label for="address" class="control-label col-xs-5 col-sm-3 col-lg-2">Address</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="address"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="address" placeholder="Enter an Address...">
      </div>
    </div>
    <div class="form-group">
      <label for="suburb" class="control-label col-xs-5 col-sm-3 col-lg-2">Suburb</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="suburb"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="suburb" placeholder="Enter a Suburb...">
      </div>
    </div>
    <div class="form-group">
      <label for="city" class="control-label col-xs-5 col-sm-3 col-lg-2">City</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="city"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="city" placeholder="Enter a City...">
      </div>
    </div>
    <div class="form-group">
      <label for="state" class="control-label col-xs-5 col-sm-3 col-lg-2">State</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="state"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="state" placeholder="Enter a State...">
      </div>
    </div>
    <div class="form-group">
      <label for="postcode" class="control-label col-xs-5 col-sm-3 col-lg-2">Postcode</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="postcode"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php if($r['postcode']!=0){echo$r['postcode'];}?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="postcode" placeholder="Enter a Postcode...">
      </div>
    </div>
<?php $sql=$db->query("SELECT id,contentType,code,title,assoc FROM content WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");?>
    <div class="form-group">
      <label for="rid" class="control-label col-xs-5 col-sm-3 col-lg-2">Booked</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="rid"><?php svg('fingerprint');?></button>
        </div>
<?php }?>
        <select id="rid" class="form-control" name="rid" onchange="update('<?php echo$r['id'];?>','content','rid',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rid">
          <option value="0">Select an Item...</option>
<?php while($row=$sql->fetch(PDO::FETCH_ASSOC)){?>
          <option value="<?php echo$row['id'];?>"<?php if($r['rid']==$row['id']){echo' selected';}?>><?php echo ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'];?></option>
<?php }?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="notes" class="control-label col-xs-5 col-sm-3 col-lg-2">Notes</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php if($user['rank']>899){?>
        <div class="input-group-btn hidden-xs">
          <button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="da"><?php svg('fingerprint');?></button>
        </div>
        <div id="da" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="notes"></div>
<?php }?>
        <form id="summernote" method="post" target="sp" action="core/update.php">
          <input type="hidden" name="id" value="<?php echo$r['id'];?>">
          <input type="hidden" name="t" value="content">
          <input type="hidden" name="c" value="notes">
          <textarea id="notes" class="summernote" name="da"><?php echo rawurldecode($r['notes']);?></textarea>
        </form>
      </div>
    </div>
  </div>
</div>
<?php }else{?>
<link rel="stylesheet" type="text/css" href="core/css/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="core/css/fullcalendar.theme.css">
<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h4 class="col-xs-8">Bookings</h4>
    <div class="pull-right">
      <div class="btn-group">
        <a class="btn btn-default add" href="<?php echo URL.$settings['system']['admin'].'/add/bookings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Add"';?>><?php svg('add');?></a>
      </div>
      <div class="btn-group">
          <button class="btn btn-default" onclick="toggleCalendar();"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Switch Between Calendar and Table Views"';?>><?php svg('table','libre-table');svg('calendar','libre-calendar hidden')?></button>
      </div>
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/bookings/settings';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Settings"';?>><?php svg('cogs');?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/StudioJunkyard/LibreCMS/wiki/Administration#bookings"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Help"';?>><?php svg('help');?></a>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div id="calendar-view" class="col-xs-12<?php if(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']==''))echo' hidden';?>">
      <div id="calendar"></div>
    </div>
    <div id="table-view" class="table-responsive<?php if(isset($_COOKIE['bookingview'])&&$_COOKIE['bookingview']=='calendar')echo' hidden';?>">
      <table class="table table-condensed table-striped table-hover">
        <thead>
          <tr>
            <th></th>
            <th class="col-xs-3"></th>
          </tr>
        </thead>
        <tbody id="bookings">
<?php $s=$db->query("SELECT * FROM content WHERE contentType='booking' ORDER BY ti DESC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
          <tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='unconfirmed')echo' danger';?>">
            <td>
              <small><?php echo date($config['dateFormat'],$r['ti']).'<br>Start: '.date($config['dateFormat'],$r['tis']);if($r['tie']>$r['tis'])echo'<br>End: '.date($config['dateFormat'],$r['tie']);if($r['business'])echo'<br>Business: '.$r['business'];if($r['name'])echo'<br>Name'.': '.$r['name'];if($r['email'])echo'<br>Email'.': <a href="mailto:'.$r['email'].'">'.$r['email'].'</a>';if($r['phone'])echo'<br>Phone'.': '.$r['phone'];?></small>
            </td>
            <td id="controls_<?php echo$r['id'];?>" class="text-right">
              <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'];?>/bookings/edit/<?php echo$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><?php svg('edit');?></a>
              <button class="btn btn-default btn-xs<?php if($r['status']!='delete'){echo' hidden';}?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><?php svg('restore');?></button>
              <button class="btn btn-default btn-xs trash<?php if($r['status']=='delete'){echo' hidden';}?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Delete"';?>><?php svg('trash');?></button>
              <button class="btn btn-default btn-xs trash<?php if($r['status']!='delete'){echo' hidden';}?>" onclick="purge('<?php echo$r['id'];?>','content')"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Purge"';?>><?php svg('purge');?></button>
            </td>
          </tr>
<?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
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
<?php $s=$db->query("SELECT * FROM content WHERE contentType='booking'");
while($r=$s->fetch(PDO::FETCH_ASSOC)){
  $bs=$db->prepare("SELECT contentType,title,tis,tie,ti FROM content WHERE id=:id");
  $bs->execute(array(':id'=>$r['rid']));
  $br=$bs->fetch(PDO::FETCH_ASSOC);?>
      {
        id:'<?php echo$r['id'];?>',
        title:'<?php if($br['contentType']=='events'){?>Event: <?php echo$br['title'];}elseif($br['contentType']!=''){echo ucfirst(rtrim($br['contentType'],'s')).': '.$br['title'];}else echo$r['name'];?>',
        start:'<?php echo date("Y-m-d H:i:s",$r['tis']);?>',
<?php if($r['tie']>$r['tis']){echo'eventend: \''.date("Y-m-d H:i:s",$r['tie']).'\',';}?>
        allDay:false,
        color:'<?php if($r['status']=='confirmed')echo'#88f288';else echo'#f28888';?>',
        description:'<?php if($r['business'])echo'Business: '.$r['business'].'<br>';if($r['name'])echo'Name'.': '.$r['name'].'<br>';if($r['email'])echo'Email'.': <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>';if($r['phone'])echo'Phone'.': '.$r['phone'].'<br>';?>',
        status:'<?php echo$r['status'];?>',
      },
<?php	}?>
    ],
    eventMouseover:function(event,domEvent,view){
      var layer='<div id="events-layer" class="fc-transparent">';
      if(event.status=="unconfirmed")layer+='<span id="cbut'+event.id+'" class="btn btn-default btn-xs add"><?php svg('approve');?></span> ';
      layer+='<span id="edbut'+event.id+'" class="btn btn-default btn-xs"><?php svg('edit');?></span> <span id="delbut'+event.id+'" class="btn btn-default trash btn-xs"><?php svg('trash');?></span></div>';
      var content='Start: '+$.fullCalendar.moment(event.start).format('HH:mm');
<?php if($r['tie']>$r['tis']){?>
      content+='<br>End: '+$.fullCalendar.moment(event.eventend).format('HH:mm');
<?php }?>
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
        event.color="#88f288";
        event.status="confirmed";
        update(event.id,"content","status","confirmed");
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
      },
      dayClick:function(date,jsEvent,view){
        if(view.name=='month'||view.name=='basicWeek'){
          $('#calendar').fullCalendar('changeView','basicDay');
          $('#calendar').fullCalendar('gotoDate',date);
        }
      },
      eventDrop:function(event){
        Pace.restart();
        update(event.id,"content","tis",event.start.format());
      }
    });
    $(window).resize(function(){
      var calHeight=$(window).height()*0.83;
      $('#calendar').fullCalendar('option','height',calHeight);
    });
<?php }?>
/*]]>*/</script>
<?php }
