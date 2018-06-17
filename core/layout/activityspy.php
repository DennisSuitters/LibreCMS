<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require'..'.DS.'db.php';
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
<?php if($r['refColumn']=='notes'&&strlen($r['oldda'])>400&&strlen($r['newda'])>400)
  echo'<div><small>Dataset too large to display</small></div>';
else{?>
          <div><small>From: <small><?php echo(strlen($r['oldda'])>400?'Dataset too large to display.':htmlspecialchars($r['oldda']));?></small></small></div>
          <div><small>To: <small><?php echo(strlen($r['newda'])>400?'Dataset too large to display.':htmlspecialchars($r['newda']));?></small></small></div>
<?php }?>
        </td>
      </tr>
    </tbody>
  </table>
</td>
<?php
