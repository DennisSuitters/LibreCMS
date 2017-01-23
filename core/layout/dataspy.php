<?php
require'../db.php';
$config=$db->query("SELECT options,dateFormat FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
define('DS',DIRECTORY_SEPARATOR);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$s=$db->prepare("SELECT * FROM logs WHERE rid=:id AND refTable=:t AND refColumn=:c ORDER BY ti DESC");
$s->execute(array(':id'=>$id,':t'=>$t,':c'=>$c));
if($s->rowCount()>0){?>
<table class="table table-condensed table-striped table-hover">
  <thead>
    <tr>
      <th class="col-xs-2 text-center">User</th>
      <th class="col-xs-1 text-center">Table</th>
      <th class="col-xs-1 text-center">Column</th>
      <th class="col-xs-1 text-center">contentType</th>
      <th class="col-xs-1 text-center">Action</th>
      <th class="col-xs-2 text-center">Date</th>
      <th class="col-xs-4 text-center">Data</th>
    </tr>
  </thead>
  <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
      $r['oldda']=rawurldecode($r['oldda']);
      $r['newda']=rawurldecode($r['newda']);?>
    <tr>
      <td><small><a href="<?php echo URL.$settings['system']['admin'].'/accounts/edit/'.$r['uid'];?>"><?php echo$r['username'].':'.$r['name'];?></a></small></td>
      <td class="text-center"><small><?php echo$r['refTable'];?></small></td>
      <td class="text-center"><small><?php echo$r['refColumn'];?></small></td>
      <td class="text-center"><small><?php echo$r['contentType'];?></small></td>
      <td class="text-center"><small><?php echo$r['action'];?></small></td>
      <td class="text-center"><small><small><?php echo date($config['dateFormat'],$r['ti']);?></small></small></td>
      <td>
<?php if($r['refColumn']=='notes'&&strlen($r['oldda'])>400&&strlen($r['newda'])>400){?>
        <div><small>Dataset too large to display</small></div>
<?php }else{?>
        <div><small><?php if($r['action']=='update'){?><button class="btn btn-default btn-xs" onclick="restore('<?php echo$r['id'];?>');"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Restore"';?>><i class="libre"><svg xmlns="http://www.w3.org/2000/svg" id="libre-undo" viewBox="0 0 14 14"><path d="m 7,11.5 c 1.86108,0 3.375,-1.513922 3.375,-3.375 C 10.375,6.263922 8.86108,4.75 7,4.75 V 7 L 3.25,4 7,1 v 2.25 c 2.68798,0 4.875,2.187023 4.875,4.875 C 11.875,10.812977 9.68798,13 7,13 4.31202,13 2.125,10.812977 2.125,8.125 h 1.5 C 3.625,9.986078 5.13892,11.5 7,11.5 z"/></svg></i></button> <?php }?>From: <small><?php if(strlen($r['oldda'])>400)echo'Dataset too large to display.';else echo htmlspecialchars($r['oldda']);?></small></small></div>
        <div><small>To: <small><?php if(strlen($r['newda'])>400)echo'Dataset too large to display.';else echo htmlspecialchars($r['newda']);?></small></small></div>
<?php }?>
      </td>
    </tr>
<?php }?>
  </tbody>
</table>
<small class="help-block text-muted text-right">Note: You won't see changes when Undoing edits until you reload the page.</small>
<?php }else{
  echo'No Results Found.';
}