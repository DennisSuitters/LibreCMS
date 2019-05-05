<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Orders
 *
 * orders.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Orders
 * @package    core/layout/orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Move Settings to Header
 * @changes    v2.0.1 Add Indicator to determine if display "All" Orders
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
$uid=isset($_SESSION['uid'])?$_SESSION['uid']:$uid=0;
$error=0;
$ti=time();
$oid='';
if(isset($args[1]))$id=$args[1];
if($args[0]=='duplicate'){
  $sd=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE id=:id");
  $sd->execute([':id'=>$id]);
  $rd=$sd->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("INSERT INTO `".$prefix."orders` (cid,uid,contentType,due_ti,notes,status,recurring,ti) VALUES (:cid,:uid,:contentType,:due_ti,:notes,:status,:recurring,:ti)");
  $s->execute([':cid'=>$rd['cid'],':uid'=>$uid,':contentType'=>$rd['contentType'],':due_ti'=>$ti+$config['orderPayti'],':notes'=>$rd['notes'],':status'=>'outstanding',':recurring'=>$rd['recurring'],':ti'=>$ti]);
  $iid=$db->lastInsertId();
  if($rd['qid']!=''){
    $rd['qid']='Q'.date("ymd",$ti).sprintf("%06d",$iid+1,6);
    $qid_ti=$ti+$config['orderPayti'];
  }else
    $qid_ti=0;
  if($rd['iid']!=''){
    $rd['iid']='I'.date("ymd",$ti).sprintf("%06d",$iid+1,6);
    $iid_ti=$ti+$config['orderPayti'];
  }else
    $iid_ti=0;
  $s=$db->prepare("UPDATE `".$prefix."orders` SET qid=:qid,qid_ti=:qid_ti,iid=:iid,iid_ti=:iid_ti WHERE id=:id");
  $s->execute([':qid'=>$rd['qid'],':qid_ti'=>$qid_ti,':iid'=>$rd['iid'],':iid_ti'=>$iid_ti,':id'=>$iid]);
  $s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid");
  $s->execute(array(':oid'=>$id));
  while($r=$s->fetch(PDO::FETCH_ASSOC)){
    $so=$db->prepare("INSERT INTO `".$prefix."orderitems` (oid,iid,title,quantity,cost,status,ti) VALUES (:oid,:iid,:title,:quantity,:cost,:status,:ti)");
    $so->execute([':oid'=>$iid,':iid'=>$r['iid'],':title'=>$r['title'],':quantity'=>$r['quantity'],':cost'=>$r['cost'],':status'=>$r['status'],':ti'=>$ti]);
  }
  $aid='A'.date("ymd",$ti).sprintf("%06d",$id,6);
  $s=$db->prepare("UPDATE `".$prefix."orders` SET aid=:aid,aid_ti=:aid_ti WHERE id=:id");
  $s->execute([':aid'=>$aid,':aid_ti'=>$ti,':id'=>$id]);
  $args[0]='all';
}
if($args[0]=='addquote'||$args[0]=='addinvoice'){
  $r=$db->query("SELECT MAX(id) as id FROM `".$prefix."orders`")->fetch(PDO::FETCH_ASSOC);
  $dti=$ti+$config['orderPayti'];
  if($args[0]=='addquote'){
    $oid='Q'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
    $q=$db->prepare("INSERT INTO `".$prefix."orders` (uid,qid,qid_ti,due_ti,status) VALUES (:uid,:qid,:qid_ti,:due_ti,'pending')");
    $q->execute([':uid'=>$uid,':qid'=>$oid,':qid_ti'=>$ti,':due_ti'=>$dti]);
  }
  if($args[0]=='addinvoice'){
    $oid='I'.date("ymd",$ti).sprintf("%06d",$r['id']+1,6);
    $s=$db->prepare("INSERT INTO `".$prefix."orders` (uid,iid,iid_ti,due_ti,status) VALUES (:uid,:iid,:iid_ti,:due_ti,'pending')");
    $s->execute([':uid'=>$uid,':iid'=>$oid,':iid_ti'=>$ti,':due_ti'=>$dti]);
  }
  $id=$db->lastInsertId();
  $e=$db->errorInfo();
  $args[0]='edit';?>
<script>history.replaceState('','','<?php echo URL.$settings['system']['admin'].'/orders/edit/'.$id;?>');</script>
<?php }
if($args[0]=='to_invoice'){
  $q=$db->prepare("SELECT qid FROM `".$prefix."orders` WHERE id=:id");
  $q->execute(array(':id'=>$id));
  $r=$q->fetch(PDO::FETCH_ASSOC);
  $q=$db->prepare("UPDATE `".$prefix."orders` SET iid=:iid,iid_ti=:iid_ti,qid='',qid_ti='0' WHERE id=:id");
  $q->execute([':iid'=>'I'.date("ymd",$ti).sprintf("%06d",$id,6),':iid_ti'=>$ti,':id'=>$id]);
  if(file_exists('..'.DS.'media'.DS.'order'.DS.$r['qid'].'.pdf'))unlink('..'.DS.'media'.DS.'orders'.DS.$r['qid'].'.pdf');
  $args[0]='invoices';
}
if($args[0]=='settings')
  include'core'.DS.'layout'.DS.'set_orders.php';
elseif($args[0]=='edit')
  include'core'.DS.'layout'.DS.'edit_orders.php';
else{
  if($args[0]=='all'||$args[0]==''){
    $sort="all";
    if($user['rank']==300){
      $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE aid='' AND cid=:cid ORDER BY ti DESC");
      $s->execute([':cid'=>$user['id']]);
    }else{
      $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE aid='' ORDER BY ti DESC");
      $s->execute();
    }
  }
  if($args[0]=='quotes'){
    $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE qid!='' AND iid='' AND aid='' ORDER BY ti DESC");
    $s->execute();
  }
  if($args[0]=='invoices'){
    $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE qid='' AND iid!='' ORDER BY ti DESC");
    $s->execute();
  }
  if($args[0]=='archived'){
    $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE aid!='' ORDER BY ti DESC");
    $s->execute();
  }
  if($args[0]=='pending'){
    $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE status='pending' ORDER BY ti DESC");
    $s->execute();
  }
  if($args[0]=='recurring'){
    $s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE recurring='1' ORDER BY ti DESC");
    $s->execute();
  }?>
<main id="content" class="main">
  <ol class="breadcrumb shadow">
    <li class="breadcrumb-item"><?php if(isset($args[0])&&$args[0]!='')echo'<a href="'.URL.$settings['system']['admin'].'/orders">'.localize('Orders').'</a>';else echo localize('Orders');?></li>
    <li class="breadcrumb-item active"><?php echo$args[0]!=''?ucfirst(localize($args[0])):localize('All');?></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
<?php if($args[0]!=''){
        if($args[0]=='quotes')echo'<a class="btn btn-ghost-normal add" href="'.URL.$settings['system']['admin'].'/orders/addquote" data-tooltip="tooltip" data-placement="left" title="'.localize('Add').' '.localize('Quote').'" role="button" aria-label="'.localize('aria_add').'">'.svg2('libre-gui-plus').'</a>';
        if($args[0]=='invoices')echo'<a class="btn btn-ghost-normal add" href="'.URL.$settings['system']['admin'].'/orders/addinvoice" data-tooltip="tooltip" data-placement="left" title="'.localize('Add').' '.localize('Invoice').'" role="button" aria-label="'.localize('aria_add').'">'.svg2('libre-gui-plus').'</a>';
      }
        if($help['orders_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['orders_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['orders_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['orders_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <div id="notifications" role="alert"></div>
        <div class="table-responsive">
          <table id="stupidtable" class="table table-condensed table-hover" role="table">
            <thead>
              <tr role="row">
                <th role="columnheader"><?php echo localize('Order');?></th>
                <th role="columnheader"><?php echo localize('Client');?></th>
                <th role="columnheader"><?php echo localize('Date');?></th>
                <th role="columnheader"><?php echo localize('Status');?></th>
                <th role="columnheader"></th>
              </tr>
            </thead>
            <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
  if($r['due_ti']<$ti){
    $us=$db->prepare("UPDATE `".$prefix."orders` SET status='overdue' WHERE id=:id");
    $us->execute([':id'=>$r['id']]);
    $r['status']='overdue';
  }
  $cs=$db->prepare("SELECT username,name,email,business FROM `".$prefix."login` WHERE id=:id");
  $cs->execute([':id'=>$r['cid']]);
  $c=$cs->fetch(PDO::FETCH_ASSOC);?>
              <tr id="l_<?php echo$r['id'];?>" role="row">
                <td role="cell">
                  <a href="<?php echo URL.$settings['system']['admin'].'/orders/edit/'.$r['id'];?>"><?php echo$r['aid']!=''?$r['aid'].'<br>':'';echo$r['qid'].$r['iid'];?></a>
                </td>
                <td role="cell">
                  <?php echo$c['username'].($c['name']!=''?' ['.$c['name'].']':'').':'.($c['name']!=''&&$c['business']!=''?'<br>':'').($c['business']!=''?$c['business']:'');?>
                </td>
                <td role="cell">
                  <?php echo' '.date($config['dateFormat'],($r['iid_ti']==0?$r['qid_ti']:$r['iid_ti']));?><br>
                  <small><?php echo localize('Due');?>: <?php echo date($config['dateFormat'],$r['due_ti']);?></small>
                </td>
                <td role="cell">
                  <span class="badge badge-<?php echo($ti>$r['due_ti'])||($r['status']=='overdue')?'danger"':'info';?>"><?php echo ucfirst($r['status']);?></span>
                </td>
                <td id="controls_<?php echo$r['id'];?>" role="cell">
                  <div class="btn-group float-right" role="group">
                    <?php echo$r['qid']!=''&&$r['aid']==''?'<a class="btn btn-secondary'.($r['status']=='delete'?' hidden':'').'" href="'.URL.$settings['system']['admin'].'/orders/to_invoice/'.$r['id'].'" data-tooltip="tooltip" title="'.localize('Convert to Invoice').'..." role="button" aria-label="'.localize('aria_order_converttoinvoice').'">'.svg2('libre-gui-order-quotetoinvoice').'</a>':'';
                    echo$r['aid']==''?'<button class="btn btn-secondary'.($r['status']=='delete'?' hidden':'').'" onclick="update(\''.$r['id'].'\',\'orders\',\'status\',\'archived\')" data-tooltip="tooltip" title="'.localize('Archive').'" role="button" aria-label="'.localize('aria_archive').'">'.svg2('libre-gui-archive').'</button>':'';?>
                    <button class="btn btn-secondary" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');" data-tooltip="tooltip" title="<?php echo localize('Print Order');?>" role="button" aria-label="<?php echo localize('aria_print');?>"><?php svg('libre-gui-print');?></button>
                    <?php echo$c['email']!=''?'<button class="btn btn-secondary" onclick="$(\'#sp\').load(\'core/email_order.php?id='.$r['id'].'&act=\');" data-tooltip="tooltip" title="'.localize('Email Order').'" role="button" aria-label="'.localize('aria_email').'">'.svg2('libre-gui-email-send').'</button>':'';?>
                    <a class="btn btn-secondary<?php echo$r['status']=='delete'?' hidden':'';?>" href="<?php echo URL.$settings['system']['admin'].'/orders/duplicate/'.$r['id'];?>" data-tooltip="tooltip" title="<?php echo localize('Duplicate');?>" role="button" aria-label="<?php echo localize('aria_duplicate');?>"><?php svg('libre-gui-copy');?></a>
                    <a class="btn btn-secondary<?php echo$r['status']=='delete'?' hidden':'';?>" href="<?php echo URL.$settings['system']['admin'].'/orders/edit/'.$r['id'];?>" data-tooltip="tooltip" title="<?php echo localize('Edit');?>" role="button" aria-label="<?php echo localize('aria_edit');?>"><?php svg('libre-gui-edit');?></a>
<?php if($user['rank']>399){?>
                    <button class="btn btn-secondary<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','orders','status','')" data-tooltip="tooltip" title="<?php echo localize('Restore');?>" role="button" aria-label="<?php echo localize('aria_restore');?>"><?php svg('libre-gui-untrash');?></button>
                    <button class="btn btn-secondary trash<?php echo$r['status']=='delete'?' hidden':'';?>" onclick="updateButtons('<?php echo$r['id'];?>','orders','status','delete')" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                    <button class="btn btn-secondary trash<?php echo$r['status']!='delete'?' hidden':'';?>" onclick="purge('<?php echo$r['id'];?>','orders')" data-tooltip="tooltip" title="<?php echo localize('Purge');?>" role="button" aria-label="<?php echo localize('aria_purge');?>"><?php svg('libre-gui-purge');?></button>
<?php }?>
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
<?php }
