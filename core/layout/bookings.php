<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if($view=='add'){
  $ti=time();
  $q=$db->prepare("INSERT INTO content (uid,contentType,status,ti,tis) VALUES (:uid,'booking','unconfirmed',:ti,:tis)");
  $q->execute(
    array(
      ':uid' => $user['id'],
      ':ti'  => $ti,
      ':tis' => $ti
    )
  );
  $id=$db->lastInsertId();
  $view='bookings';
  $args[0]='edit';?>
<script>/*<![CDATA[*/
  history.replaceState('','','<?php echo URL.$settings['system']['admin'].'/bookings/edit/'.$id;?>');
/*]]>*/</script>
<?php }elseif(isset($args[1]))
  $id=$args[1];
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_bookings.php';
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
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/bookings';?>" data-toggle="tooltip" data-placement="left" title="Back"><?php svg('libre-gui-back',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <button class="btn btn-default" onclick="$('#sp').load('core/email_booking.php?id=<?php echo$r['id'];?>');" data-toggle="tooltip" data-placement="left" title="Email Booking"><?php svg('libre-gui-email-send',($config['iconsColor']==1?true:null));?></button>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#bookings-edit" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div id="notifications"></div>
    <div class="form-group">
      <label for="tis" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Booked For</label>
      <div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="tis">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="tis" class="form-control" data-dbid="<?php echo$r['id'];?>" data-datetime="<?php echo date($config['dateFormat'],$r['tis']);?>"<?php echo($user['options']{2}==0?' readonly':'');?>>
      </div>
    </div>
    <div class="form-group">
      <label for="tie" class="control-label col-xs-5 col-sm-3 col-lg-2">Booking End</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="tie">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="tie" class="form-control" data-dbid="<?php echo$r['id'];?>" data-datetime="<?php echo($r['tie']!=0?date($config['dateFormat'],$r['tie']):date($config['dateFormat'], $r['tis']));?>"<?php echo($user['options']{2}==0?' readonly':'');?>>
      </div>
    </div>
    <div class="form-group">
      <label for="status" class="control-label col-xs-5 col-sm-3 col-lg-2">Status</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="status">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php echo($user['options']{2}==0?' readonly':'');?> data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="status">
          <option value="unconfirmed"<?php echo($r['status']=='unconfirmed'?' selected':'');?>>Unconfirmed</option>
          <option value="confirmed"<?php echo($r['status']=='confirmed'?' selected':'');?>>Confirmed</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="changeClient" class="control-label col-xs-5 col-sm-3 col-lg-2">Client</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="changeClient">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).' </button></div>':'');?>
        <select id="changeClient" class="form-control" onchange="changeClient($(this).val(),<?php echo$r['id'];?>,'booking');" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid">
          <option value="0"<?php echo($r['cid']=='0'?' selected':'');?>>Select a Client...</option>
<?php $q=$db->query("SELECT id,business,username,name FROM login WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
  while($rs=$q->fetch(PDO::FETCH_ASSOC))
    echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['cid']?' selected="selected"':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business']:'').'</option>';?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="control-label col-xs-5 col-sm-3 col-lg-2">Email</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="email">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="email" class="form-control textinput" name="email" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="Enter an Email...">
      </div>
    </div>
    <div class="form-group">
      <label for="phone" class="control-label col-xs-5 col-sm-3 col-lg-2">Phone</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="phone">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="phone" class="form-control textinput" name="phone" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone" placeholder="Enter a Phone Number...">
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="control-label col-xs-5 col-sm-3 col-lg-2">Name</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="name">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="name" class="form-control textinput" name="name" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="Enter a Name...">
      </div>
    </div>
    <div class="form-group">
      <label for="business" class="control-label col-xs-5 col-sm-3 col-lg-2">Business</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="business">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="business" class="form-control textinput" name="business" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="Enter a Business...">
      </div>
    </div>
    <div class="form-group">
      <label for="address" class="control-label col-xs-5 col-sm-3 col-lg-2">Address</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="address">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)) . '</button></div>':'');?>
        <input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="address" placeholder="Enter an Address...">
      </div>
    </div>
    <div class="form-group">
      <label for="suburb" class="control-label col-xs-5 col-sm-3 col-lg-2">Suburb</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="suburb">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="suburb" placeholder="Enter a Suburb...">
      </div>
    </div>
    <div class="form-group">
      <label for="city" class="control-label col-xs-5 col-sm-3 col-lg-2">City</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="city">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="city" placeholder="Enter a City...">
      </div>
    </div>
    <div class="form-group">
      <label for="state" class="control-label col-xs-5 col-sm-3 col-lg-2">State</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="state">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="state" placeholder="Enter a State...">
      </div>
    </div>
    <div class="form-group">
      <label for="postcode" class="control-label col-xs-5 col-sm-3 col-lg-2">Postcode</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="postcode">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php echo($r['postcode']!=0?$r['postcode']:'');?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="postcode" placeholder="Enter a Postcode...">
      </div>
    </div>
<?php $sql=$db->query("SELECT id,contentType,code,title,assoc FROM content WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");?>
    <div class="form-group">
      <label for="rid" class="control-label col-xs-5 col-sm-3 col-lg-2">Booked</label>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10">
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="rid">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');?>
        <select id="rid" class="form-control" name="rid" onchange="update('<?php echo$r['id'];?>','content','rid',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rid">
          <option value="0">Select an Item...</option>
<?php while($row=$sql->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$row['id'].'"'.($r['rid']==$row['id']?' selected':'').'>'.ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'].'</option>';?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="notes" class="control-label col-xs-5 col-sm-3 col-lg-2">Notes</label>
<?php echo($user['rank']>899?'<div class="input-group-btn hidden-xs" style="background-color:#f5f5f5;border:1px solid #ccc;border-bottom:0;"><button class="btn btn-default fingerprint" data-toggle="popover" data-dbgid="da">'.svg2('libre-gui-fingerprint',($config['iconsColor']==1?true:null)).'</button></div>':'');
echo($user['rank']>899?'<div id="da" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="notes"></div>':'');?>
      <div class="input-group col-xs-7 col-sm-9 col-lg-10 pull-right">
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
        <a class="btn btn-default add" href="<?php echo URL.$settings['system']['admin'].'/add/bookings';?>" data-toggle="tooltip" data-placement="left" title="Add"><?php svg('libre-gui-add',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
          <button class="btn btn-default" onclick="toggleCalendar();" data-toggle="tooltip" data-placement="left" title="Switch Between Calendar and Table Views"><?php svg('libre-gui-table',($config['iconsColor']==1?true:null),'libre-table');svg('libre-gui-calendar',($config['iconsColor']==1?true:null),'libre-calendar hidden')?></button>
      </div>
      <div class="btn-group">
        <a class="btn btn-default" href="<?php echo URL.$settings['system']['admin'].'/bookings/settings';?>" data-toggle="tooltip" data-placement="left" title="Settings"><?php svg('libre-gui-settings',($config['iconsColor']==1?true:null));?></a>
      </div>
      <div class="btn-group">
        <a target="_blank" class="btn btn-default info" href="https://github.com/DiemenDesign/LibreCMS/wiki/Administration#bookings" data-toggle="tooltip" data-placement="left" title="Help"><?php svg('libre-gui-help',($config['iconsColor']==1?true:null));?></a>
        <span data-toggle="tooltip" data-placement="left" title="Watch Video Help"><a href="#" class="btn btn-default info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="https://www.youtube.com/embed/FsXG1YSqcjU"><?php svg('libre-gui-video',($config['iconsColor']==1?true:null));?></a></span>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div id="calendar-view" class="col-xs-12<?php echo(isset($_COOKIE['bookingview'])&&($_COOKIE['bookingview']=='table'||$_COOKIE['bookingview']=='')?' hidden':'');?>">
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
<?php $s=$db->query("SELECT * FROM content WHERE contentType='booking' ORDER BY ti DESC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
          <tr id="l_<?php echo$r['id'];?>" class="<?php echo($r['status']=='unconfirmed'?' danger':'');?>">
            <td>
              <small><?php echo date($config['dateFormat'],$r['ti']).'<br>Start: '.date($config['dateFormat'],$r['tis']).($r['tie']>$r['tis']?'<br>End: ' . date($config['dateFormat'], $r['tie']):'').($r['business']!=''?'<br>Business: '.$r['business']:'').($r['name']!=''?'<br>Name'.': '.$r['name']:'').($r['email']!=''?'<br>Email'.': <a href="mailto:'.$r['email'].'">'.$r['email'].'</a>':'').($r['phone']!=''?'<br>Phone'.': '.$r['phone']:'');?></small>
            </td>
            <td id="controls_<?php echo$r['id'];?>" class="text-right">
              <a class="btn btn-default btn-xs" href="<?php echo URL.$settings['system']['admin'];?>/bookings/edit/<?php echo$r['id'];?>" data-toggle="tooltip" title="Edit"><?php svg('libre-gui-edit',($config['iconsColor']==1?true:null));?></a>
              <button class="btn btn-default btn-xs<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','unpublished')" data-toggle="tooltip" title="Restore"><?php svg('libre-gui-restore',($config['iconsColor']==1?true:null));?></button>
              <button class="btn btn-default btn-xs trash<?php echo($r['status']=='delete'?' hidden':'');?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')" data-toggle="tooltip" title="Delete"';?>><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></button>
              <button class="btn btn-default btn-xs trash<?php echo($r['status']!='delete'?' hidden':'');?>" onclick="purge('<?php echo $r['id'];?>','content')" data-toggle="tooltip" title="Purge"';?>><?php svg('libre-gui-purge',($config['iconsColor']==1?true:null));?></button>
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
<?php echo($r['tie']>$r['tis']?'eventend: \''.date("Y-m-d H:i:s",$r['tie']).'\',':'');?>
        allDay:false,
        color:'<?php echo($r['status']=='confirmed'?'#00bc8c':'#e74c3c');?>',
        description:'<?php echo($r['business']!=''?'Business: '.$r['business'].'<br>':'').($r['name']!=''?'Name'.': '.$r['name'].'<br>':'').($r['email']!=''?'Email'.': <a href="mailto:'.$r['email'].'">'.$r['email'].'</a><br>':'').($r['phone']!=''?'Phone'.': '.$r['phone'].'<br>':'');?>',
        status:'<?php echo $r['status'];?>',
      },
<?php	}?>
    ],
    eventMouseover:function(event,domEvent,view){
      var layer='<div id="events-layer" class="fc-transparent">';
      if(event.status=="unconfirmed")layer+='<span id="cbut'+event.id+'" class="btn btn-default btn-xs add"><?php svg('libre-gui-approve',($config['iconsColor']==1?true:null));?></span> ';
      layer+='<span id="edbut'+event.id+'" class="btn btn-default btn-xs"><?php svg('libre-gui-edit',($config['iconsColor']==1?true:null));?></span> <span id="delbut'+event.id+'" class="btn btn-default trash btn-xs"><?php svg('libre-gui-trash',($config['iconsColor']==1?true:null));?></span></div>';
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
        event.color="#00bc8c";
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
