<?php
require'../db.php';
$config=$db->query("SELECT options,dateFormat FROM config WHERE id=1")->fetch(PDO::FETCH_ASSOC);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)define('PROTOCOL','https://');else define('PROTOCOL','http://');
define('DS',DIRECTORY_SEPARATOR);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$s=$db->prepare("SELECT * FROM logs WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
$r['oldda']=rawurldecode($r['oldda']);
$r['newda']=rawurldecode($r['newda']);?>
<td colspan="3">
  <table class="table table-condensed">
    <thead>
      <tr>
        <th class="col-xs-2 text-center">User</th>
        <th class="col-xs-1 text-center">Table</th>
        <th class="col-xs-1 text-center">Column</th>
        <th class="col-xs-1 text-center">contentType</th>
        <th class="col-xs-1 text-center">Action</th>
        <th class="col-xs-2 text-center">Date</th>
        <th class="col-xs-4">Data</th>
      </tr>
    </thead>
    <tbody>
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
          <div><small>From: <small><?php if(strlen($r['oldda'])>400)echo'Dataset too large to display.';else echo htmlspecialchars($r['oldda']);?></small></small></div>
          <div><small>To: <small><?php if(strlen($r['newda'])>400)echo'Dataset too large to display.';else echo htmlspecialchars($r['newda']);?></small></small></div>
<?php }?>
        </td>
      </tr>
    </tbody>
  </table>
</td>
<?php