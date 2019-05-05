<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2018
 *
 * Administration - Edit Orders
 *
 * edit_orders.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Orders - Edit
 * @package    core/layout/edit_orders.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer
 * @changes    v2.0.1 Add Breadcrumb Linked Indicator for Order Type
 * @changes    v2.0.1 Add Dropdown to Select Rewards Code if Available
 * @changes    v2.0.1 Add Postage Options Selection and Editable in Order Fields
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
$q=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE id=:id");
$q->execute([':id'=>$id]);
$r=$q->fetch(PDO::FETCH_ASSOC);
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$q->execute([':id'=>$r['cid']]);
$client=$q->fetch(PDO::FETCH_ASSOC);
$q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
$q->execute([':id'=>$r['uid']]);
$usr=$q->fetch(PDO::FETCH_ASSOC);
if($r['notes']==''){
  $r['notes']=$config['orderEmailNotes'];
  $q=$db->prepare("UPDATE `".$prefix."orders` SET notes=:notes WHERE id=:id");
  $q->execute([
    ':notes'=>$config['orderEmailNotes'],
    ':id'=>$r['id']
  ]);
}
if($error==1)echo'<div class="alert alert-danger" role="alert">'.$e[0].'</div>';
else{?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/orders';?>"><?php echo localize('Orders');?></a></li>
    <li class="breadcrumb-item">
<?php if(isset($r['aid'])&&$r['aid']!='')
        echo'<a href="'.URL.$settings['system']['admin'].'/orders/archived">'.localize('Archived').'</a>';
      elseif(isset($r['iid'])&&$r['iid']!='')
        echo'<a href="'.URL.$settings['system']['admin'].'/orders/invoices">'.localize('Invoices').'</a>';
      elseif($r['qid']!='')
        echo'<a href="'.URL.$settings['system']['admin'].'/orders/quotes">'.localize('Quotes').'</a>';
?>
    </li>
    <li class="breadcrumb-item active"><span id="ordertitle"><?php echo$r['qid'].$r['iid'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Back');?>" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=print');return false;" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Print Order');?>" role="button" aria-label="<?php echo localize('aria_print');?>"><?php svg('libre-gui-print');?></a>
        <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/email_order.php?id=<?php echo$r['id'];?>&act=');return false;" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Email Order');?>" role="button" aria-label="<?php echo localize('aria_email');?>"><?php svg('libre-gui-email-send');?></a>
        <?php if($help['orders_edit_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['orders_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['orders_edit_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['orders_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <div class="invoice">
          <div class="row">
            <div class="col-sm-4 border-right">
              <label for="fromfrom" class="h2">From</label>
              <div class="form-group">
                <input type="text" id="fromfrom" class="form-control" name="fromfrom" value="<?php echo$config['business'];?>" readonly role="textbox">
              </div>
              <div class="form-group row">
                <label for="fromabn" class="col-form-label col-sm-3"><?php echo localize('ABN');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromabn" class="form-control form-control-sm" name="fromabn" value="<?php echo$config['abn'];?>" readonly role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="fromaddress" class="col-form-label col-sm-3"><?php echo localize('Address');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromaddress" class="form-control form-control-sm" name="fromaddress" value="<?php echo$config['address'];?>" readonly role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="fromsuburb" class="col-form-label col-sm-3"><?php echo localize('Suburb');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromsuburb" class="form-control form-control-sm" name="fromsuburb" value="<?php echo$config['suburb'];?>" readonly role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="fromcity" class="col-form-label col-sm-3"><?php echo localize('City');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromcity" class="form-control form-control-sm" name="fromcity" value="<?php echo$config['city'];?>" readonly role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="fromstate" class="col-form-label col-sm-3"><?php echo localize('State');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromstate" class="form-control form-control-sm" name="fromstate" value="<?php echo$config['state'];?>" readonly role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="frompostcode" class="col-form-label col-sm-3"><?php echo localize('Postcode');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="frompostcode" class="form-control form-control-sm" name="frompostcode" value="<?php echo$config['postcode']!=0?$config['postcode']:'';?>" readonly role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="fromemail" class="col-form-label col-sm-3"><?php echo localize('Email');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromemail" class="form-control form-control-sm" name="fromemail" value="<?php echo$config['email'];?>" readonly role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="fromphone" class="col-form-label col-sm-3"><?php echo localize('Phone');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="fromphone" class="form-control form-control-sm" name="fromphone" value="<?php echo$config['phone'];?>" readonly role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="frommobile" class="col-form-label col-sm-3"><?php echo localize('Mobile');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="frommobile" class="form-control form-control-sm" name="frommobile" value="<?php echo$config['mobile'];?>" readonly role="textbox">
                </div>
              </div>
            </div>
            <div class="col-sm-4 border-right">
              <label for="client_business" class="h2"><?php echo localize('To');?></label>
              <div class="form-group">
                <input type="text" id="client_business" class="form-control" name="client_business" value="<?php echo$client['username'];echo$client['name']!=''?' ['.$client['name'].']':'';echo$client['business']!=''?' -> '.$client['business']:'';?>" placeholder="<?php echo localize('Username, Business or Name');?>..." readonly role="textbox">
              </div>
              <div class="form-group row">
                <label for="address" class="col-form-label col-sm-3"><?php echo localize('Address');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="address" class="form-control form-control-sm textinput oce" value="<?php echo$client['address'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="address" data-bs="btn-danger" placeholder="<?php echo localize('Enter an ').' '.localize('Address');?>..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?> role="textbox">
                  <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="saveaddress" class="btn btn-secondary btn-sm save" data-dbid="address" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="suburb" class="col-form-label col-sm-3"><?php echo localize('Suburb');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="suburb" class="form-control form-control-sm textinput oce" value="<?php echo$client['suburb'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="suburb" data-bs="btn-danger" placeholder="<?php echo localize('Enter a ').' '.localize('Suburb');?>..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?> role="textbox">
                  <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savesuburb" class="btn btn-secondary btn-sm save" data-dbid="suburb" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
                </div>
              </div>
            <div class="form-group row">
              <label for="city" class="col-form-label col-sm-3"><?php echo localize('City');?></label>
              <div class="input-group col-sm-9">
                <input type="text" id="city" class="form-control form-control-sm textinput oce" value="<?php echo$client['city'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="city" data-bs="btn-danger" placeholder="<?php echo localize('Enter a ').' '.localize('City');?>..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?> role="textbox">
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savecity" class="btn btn-secondary btn-sm save" data-dbid="city" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="state" class="col-form-label col-sm-3"><?php echo localize('State');?></label>
              <div class="input-group col-sm-9">
                <input type="text" id="state" class="form-control form-control-sm textinput oce" value="<?php echo$client['state'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="state" data-bs="btn-danger" placeholder="<?php echo localize('Enter a ').' '.localize('State');?>..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?> role="textbox">
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savestate" class="btn btn-secondary btn-sm save" data-dbid="state" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="postcode" class="col-form-label col-sm-3"><?php echo localize('Postcode');?></label>
              <div class="input-group col-sm-9">
                <input type="text" id="postcode" class="form-control form-control-sm textinput oce" value="<?php echo$client['postcode']!=0?$client['postcode']:'';?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="postcode" data-bs="btn-danger" placeholder="<?php echo localize('Enter a ').' '.localize('Postcode');?>..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?> role="textbox">
                <?php if($r['status']!='archived'){?><div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savepostcode" class="btn btn-secondary btn-sm save" data-dbid="postcode" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div><?php }?>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-form-label col-sm-3"><?php echo localize('Email');?></label>
              <div class="input-group col-sm-9">
                <input type="text" id="email" class="form-control form-control-sm textinput oce" value="<?php echo$client['email'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="email" data-bs="btn-danger" placeholder="<?php echo localize('Enter an ').' '.localize('Email');?>..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?> role="textbox">
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="saveemail" class="btn btn-secondary btn-sm save" data-dbid="email" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="phone" class="col-form-label col-sm-3"><?php echo localize('Phone');?></label>
              <div class="input-group col-sm-9">
                <input type="text" id="phone" class="form-control form-control-sm textinput oce" value="<?php echo$client['phone'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="phone" data-bs="btn-danger" placeholder="<?php echo localize('Enter a ').' '.localize('Phone');?>..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?> role="textbox">
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savephone" class="btn btn-secondary btn-sm save" data-dbid="phone" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="mobile" class="col-form-label col-sm-3"><?php echo localize('Mobile');?></label>
              <div class="input-group col-sm-9">
                <input type="text" id="mobile" class="form-control form-control-sm textinput oce" value="<?php echo$client['mobile'];?>" data-dbid="<?php echo$client['id'];?>" data-dbt="login" data-dbc="mobile" data-bs="btn-danger" placeholder="<?php echo localize('Enter a ').' '.localize('Mobile');?>..."<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' readonly':'';?> role="textbox">
                <div class="input-group-append ocesave<?php echo$r['status']=='archived'||($client['address']==''&&$client['id']==0)?' hidden':'';?>" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savemobile" class="btn btn-secondary btn-sm save" data-dbid="mobile" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
              </div>
            </div>
<?php if($r['status']!='archived'){?>
            <div class="form-group row">
              <label for="changeClient" class="col-form-label col-sm-3"><?php echo localize('Client');?></label>
              <div class="input-group col-sm-9">
                <select id="changeClient" class="form-control form-control-sm" onchange="changeClient($(this).val(),'<?php echo$r['id'];?>');" data-tooltip="tooltip" title="<?php echo localize('Select a ').' '.localize('Client');?>..." role="listbox">
                  <option value="0"<?php echo($r['cid']=='0'?' selected':'');?>><?php echo localize('None');?></option>
                  <?php $q=$db->query("SELECT id,business,username,name FROM `".$prefix."login` WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");while($rs=$q->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rs['id'].'"'.($r['cid']==$rs['id']?' selected':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business'].'</option>':'');?>
                  </select>
                </div>
                <small class="alert alert-info ocehelp mt-2<?php echo$client['id']!=0?' hidden':'';?>" role="alert"><small><?php echo localize('help_oce');?></small></small>
              </div>
<?php }?>
            </div>
            <div class="col-sm-4">
              <h1 class="h2">Details</h1>
              <div class="form-group row">
                <label for="detailsordernumber" class="col-form-label col-sm-3"><?php echo localize('Order');?> #</label>
                <div class="input-group col-sm-9">
                  <input type="text" id="detailsordernumber" class="form-control form-control-sm" name="ordernumber" value="<?php echo$r['iid']==''?$r['qid']:$r['iid'];?>" readonly role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label for="detailscreated" class="col-form-label col-sm-3"><?php echo localize('Created');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="detailscreated" class="form-control form-control-sm" name="created" value="<?php echo$r['iid_ti']!=0?date($config['dateFormat'],$r['iid_ti']):date($config['dateFormat'],$r['qid_ti']);?>" readonly role="textbox">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3"><?php echo localize('Due');?></label>
                <div class="input-group col-sm-9">
                  <input type="text" id="due_ti" class="form-control form-control-sm" data-datetime="<?php echo date($config['dateFormat'],$r['due_ti']);?>" data-dbid="<?php echo$r['id'];?>" data-dbt="orders" data-dbc="due_ti" autocomplete="off" role="textbox">
                  <input type="hidden" id="due_tix" value="<?php echo$r['due_ti'];?>">
<?php if($r['status']!='archived'){?>
                  <div class="input-group-append">
                    <div class="dropdown">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" title="Extend Due Date" role="button" aria-label="<?php echo localize('aria_extend_date');?>"><?php svg('libre-gui-add');?></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+604800;?>');return false;"><?php echo localize('7 Days');?></a>
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+1209600;?>');return false;"><?php echo localize('14 Days');?></a>
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+1814400;?>');return false;"><?php echo localize('21 Days');?></a>
                        <a class="dropdown-item" href="#" onclick="update('<?php echo$r['id'];?>','orders','due_ti','<?php echo$r['due_ti']+2592000;?>');return false;"><?php echo localize('30 Days');?></a>
                      </div>
                    </div>
                  </div>
                  <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savedue_ti" class="btn btn-secondary btn-sm save" data-dbid="due_ti" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
<?php }?>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-sm-3"><?php echo localize('Status');?></label>
                <div class="input-group col-sm-9">
<?php if($r['status']=='archived')
  echo'<input type="text" class="form-control form-control-sm" value="Archived" readonly role="textbox">';
else{?>
                  <select id="status" class="form-control form-control-sm" onchange="update('<?php echo$r['id'];?>','orders','status',$(this).val());" data-tooltip="tooltip" title="<?php echo localize('Change Order Status');?>" role="listbox">
                    <option value="pending"<?php echo$r['status']=='pending'?' selected':'';?>><?php echo localize('Pending');?></option>
                    <option value="overdue"<?php echo$r['status']=='overdue'?' selected':'';?>><?php echo localize('Overdue');?></option>
                    <option value="cancelled"<?php echo$r['status']=='cancelled'?' selected':'';?>><?php echo localize('Cancelled');?></option>
                    <option value="paid"<?php echo$r['status']=='paid'?' selected':'';?>><?php echo localize('Paid');?></option>
                  </select>
<?php }?>
                </div>
              </div>
            </div>
          </div>
<?php if($r['status']!='archived'){?>
          <form target="sp" method="POST" action="core/updateorder.php" role="form">
            <input type="hidden" name="act" value="additem">
            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
            <input type="hidden" name="t" value="orderitems">
            <input type="hidden" name="c" value="">
            <div class="form-group row">
              <div class="input-group col">
                <div class="input-group-text"><?php echo localize('Inventory').'/'.localize('Services');?></div>
                <select class="form-control" name="da" data-tooltip="tooltip" title="<?php echo localize('Select Product, Service or Empty Entry');?>" role="listbox">
                  <option value="0"><?php echo localize('Add Empty Entry');?>...</option>
                  <?php $s=$db->query("SELECT id,contentType,code,cost,title FROM `".$prefix."content` WHERE contentType='inventory' OR contentType='service' OR contentType='events' ORDER BY code ASC");while($i=$s->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$i['id'].'">'.ucfirst(rtrim($i['contentType'],'s')).$i['code'].':$'.$i['cost'].':'.$i['title'].'</option>';?>
                </select>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-secondary add" data-tooltip="tooltip" title="<?php echo localize('Add');?>" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button>
                </div>
              </div>
            </div>
          </form>
<?php $sp=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='postoption' ORDER BY title ASC");
$sp->execute();
if($sp->rowCount()>0){?>
          <form target="sp" method="POST" action="core/updateorder.php" role="form">
            <input type="hidden" name="act" value="addpostoption">
            <input type="hidden" name="id" value="<?php echo$r['id'];?>">
            <input type="hidden" name="t" value="orders">
            <input type="hidden" name="c" value="postageOption">
            <div class="form-group row">
              <div class="input-group col">
                <div class="input-group-text"><?php echo localize('Postage Options');?></div>
                <select class="form-control" name="da" data-tooltip="tooltip" title="<?php echo localize('Select Postage Option or Empty Entry');?>" role="listbox">
                  <option value="0"><?php echo localize('Clear Postage Option and Cost');?></option>
                  <?php while($rp=$sp->fetch(PDO::FETCH_ASSOC))echo'<option value="'.$rp['id'].'">'.$rp['title'].':$'.$rp['value'].'</option>';?>
                </select>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-secondary add" data-tooltip="tooltip" title="Add" role="button" aria-label="<?php echo localize('aria_add');?>"><?php svg('libre-gui-plus');?></button>
                </div>
              </div>
            </div>
          </form>
<?php }
}?>
          <div class="table-responsive">
            <table class="table table-condensed table-borderless" role="table">
              <thead class="thead-light">
                <tr role="row">
                  <th role="columnheader"></th>
                  <th role="columnheader"><?php echo localize('Code');?></th>
                  <th class="col text-left" role="columnheader"><?php echo localize('Title');?></th>
                  <th class="col-sm-2" role="columnheader"><?php echo localize('Option');?></th>
                  <th class="col-sm-1 text-center" role="columnheader"><?php echo localize('Quantity');?></th>
                  <th class="col-sm-2 text-center" role="columnheader"><?php echo localize('Cost');?></th>
                  <th class="col-sm-1 text-right" role="columnheader"><?php echo localize('Total');?></th>
                  <th class="col-sm-1" role="columnheader"></th>
                </tr>
              </thead>
              <tbody id="updateorder">
<?php $s=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid ORDER BY ti ASC,title ASC");
$s->execute([':oid'=>$r['id']]);
$total=0;
while($oi=$s->fetch(PDO::FETCH_ASSOC)){
$is=$db->prepare("SELECT id,thumb,file,fileURL,code,title FROM `".$prefix."content` WHERE id=:id");
$is->execute([':id'=>$oi['iid']]);
$i=$is->fetch(PDO::FETCH_ASSOC);
$sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
$sc->execute([':id'=>$oi['cid']]);
$c=$sc->fetch(PDO::FETCH_ASSOC);
$image='';
if($i['thumb']!=''&&file_exists('media'.DS.basename($i['thumb'])))
  $image='<img class="img-fluid" style="max-width:24px;height:24px" src="media'.DS.basename($i['thumb']).'" alt="'.$i['title'].'">';
elseif($i['file']!=''&&file_exists('media'.DS.basename($i['file'])))
  $image='<img class="img-fluid" style="max-width:24px;height:24px" src="media'.DS.basename($i['file']).'" alt="'.$i['title'].'">';
elseif($i['fileURL']!='')
  $image='<img class="img-fluid" style="max-width:24px;height:24px" src="'.$i['fileURL'].'" alt="'.$i['title'].'">';
else
  $image='';
?>
                <tr role="row">
                  <td class="text-center align-middle" role="cell"><?php echo$image;?></td>
                  <td class="text-left align-middle" role="cell"><?php echo$i['code'];?></td>
                  <td class="text-left align-middle" role="cell">
<?php if($oi['iid']!=0)
  echo$i['title'];
else{?>
                    <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();" role="form">
                      <input type="hidden" name="act" value="title">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="title">
                      <input type="text" class="form-control" name="da" value="<?php echo$oi['title'];?>" role="textbox">
                    </form>
<?php }?>
                  </td>
                  <td class="text-left align-middle" role="cell"><?php echo$c['title'];?></td>
                  <td class="text-center align-middle" role="cell">
<?php if($oi['iid']!=0){?>
                    <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();" role="form">
                      <input type="hidden" name="act" value="quantity">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="quantity">
                      <input type="text" class="form-control text-center" name="da" value="<?php echo$oi['quantity'];?>"<?php echo$r['status']=='archived'?' readonly':'';?> role="textbox">
                    </form>
<?php }else{
if($oi['iid']!=0)
  echo$oi['quantity'];
}?>
                  </td>
                  <td class="text-right align-middle" role="cell">
<?php if($oi['iid']!=0){?>
                    <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();" role="form">
                      <input type="hidden" name="act" value="cost">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="cost">
                      <input class="form-control text-center" style="min-width:80px" name="da" value="<?php echo$oi['cost'];?>"<?php echo$r['status']=='archived'?' readonly':'';?> role="textbox">
                    </form>
<?php }elseif($oi['iid']!=0)
  echo$oi['cost'];?>
                  </td>
                  <td class="text-right align-middle" role="cell"><?php echo$oi['iid']!=0?$oi['cost']*$oi['quantity']:'';?></td>
                  <td class="text-right" role="cell">
                    <form target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();" role="form">
                      <input type="hidden" name="act" value="trash">
                      <input type="hidden" name="id" value="<?php echo$oi['id'];?>">
                      <input type="hidden" name="t" value="orderitems">
                      <input type="hidden" name="c" value="quantity">
                      <input type="hidden" name="da" value="0">
                      <button class="btn btn-secondary trash" data-tooltip="tooltip" title="<?php echo localize('Delete');?>" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                    </form>
                  </td>
                </tr>
<?php if($oi['iid']!=0)
  $total=$total+($oi['cost']*$oi['quantity']);
}
$sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE id=:rid");
$sr->execute([':rid'=>$r['rid']]);
$reward=$sr->fetch(PDO::FETCH_ASSOC);?>
                <tr role="row">
                  <td colspan="3" class="text-right align-middle" role="cell"><strong><?php echo localize('Rewards Code');?></strong></td>
                  <td colspan="2" class="text-center" role="cell">
                    <form id="rewardsinput" target="sp" method="POST" action="core/updateorder.php" onsubmit="Pace.restart();" role="form">
                      <div class="form-group row">
                        <div class="input-group">
                          <input type="hidden" name="act" value="reward">
                          <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                          <input type="hidden" name="t" value="orders">
                          <input type="hidden" name="c" value="rid">
                          <input type="text" id="rewardselect" class="form-control" name="da" value="<?php echo$sr->rowCount()==1?$reward['code']:'';?>" role="textbox">
<?php $ssr=$db->prepare("SELECT * FROM `".$prefix."rewards` ORDER BY code ASC, title ASC");
$ssr->execute();
if($ssr->rowCount()>0){?>
                          <div class="input-group-append">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button"></button>
                            <div class="dropdown-menu">
<?php while($srr=$ssr->fetch(PDO::FETCH_ASSOC)){?>
                              <a class="dropdown-item" href="#" onclick="$('#rewardselect').val('<?php echo$srr['code'];?>');$('#rewardsinput:first' ).submit();return false;">
                                <?php echo$srr['code'].':'.($srr['method']==1?'$'.$srr['value']:$srr['value'].'%').' Off';?>
                              </a>
<?php }?>
                            </div>
                          </div>
<?php }?>
                        </div>
                      </div>
                    </form>
                  </td>
                  <td class="text-center align-middle" role="cell">
<?php if($sr->rowCount()==1){
  if($reward['method']==1){
    echo'$';
    $total=$total-$reward['value'];
  }
  echo$reward['value'];
  if($reward['method']==0){
    echo'%';
    $total=($total*((100-$reward['value'])/100));
  }
  echo' Off';
}?>
                  </td>
                  <td class="text-right align-middle" role="cell"><strong><?php echo$total;?></strong></td>
                  <td role="cell"></td>
                </tr>
                <tr role="row">
                  <td class="text-right align-middle" role="cell"><strong><?php echo localize('Postage');?></strong></td>
                  <td colspan="5" class="text-right align-middle" role="cell">
                    <form target="sp" method="post" action="core/updateorder.php" onchange="$(this).submit();" onsubmit="Pace.restart();" role="form">
                      <input type="hidden" name="act" value="postoption">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <input type="hidden" name="t" value="orders">
                      <input type="hidden" name="c" value="postageOption">
                      <input type="text" class="form-control" name="da" value="<?php echo$r['postageOption'];?>" role="textbox">
                    </form>
                  </td>
                  <td class="text-right pl-0 pr-0" role="cell">
                    <form target="sp" method="POST" action="core/updateorder.php" onchange="$(this).submit();" onsubmit="Pace.restart();" role="form">
                      <input type="hidden" name="act" value="postcost">
                      <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                      <input type="hidden" name="t" value="orders">
                      <input type="hidden" name="c" value="postageCost">
                      <input type="text" class="form-control text-right" name="da" value="<?php echo$r['postageCost'];$total=$total+$r['postageCost'];?>" role="textbox">
                    </form>
                  </td>
                  <td role="cell"></td>
                </tr>
                <tr role="row">
                  <td colspan="6" class="text-right" role="cell"><strong><?php echo localize('Total');?></strong></td>
                  <td class="total text-right border-top" role="cell"><strong><?php echo$total;?></strong></td>
                  <td role="cell"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-sm-6">
<?php if($r['status']!='archived'&&$user['rank']>699){?>
            <form target="sp" method="POST" action="core/update.php" role="form">
              <input type="hidden" name="id" value="<?php echo$r['id'];?>">
              <input type="hidden" name="t" value="orders">
              <input type="hidden" name="c" value="notes">
              <textarea class="summernote" name="da" role="textbox"><?php echo rawurldecode($r['notes']);?></textarea>
            </form>
<?php }else
    echo'<div class="well">'.$r['notes'].'</div>';?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php }
