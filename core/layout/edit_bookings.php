<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2018
 *
 * Administration - Edit Bookings
 *
 * edit_bookings.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Bookings - Edit
 * @package    core/layout/edit_bookings.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.1 Change Back Link to Referer.
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
$s=$db->prepare("SELECT * FROM `".$prefix."content` WHERE id=:id");
$s->execute([':id'=>$id]);
$r=$s->fetch(PDO::FETCH_ASSOC);
$sr=$db->prepare("SELECT contentType FROM `".$prefix."content` where id=:id");
$sr->execute([':id'=>$r['rid']]);
$rs=$sr->fetch(PDO::FETCH_ASSOC);?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/bookings';?>"><?php echo localize('Bookings');?></a></li>
    <li class="breadcrumb-item active"><span id="bookingname"><?php echo$r['name'];?></span>:<span id="bookingbusiness"><?php echo$r['business'];?></span></li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group">
        <a class="btn btn-ghost-normal add" href="<?php echo$_SERVER['HTTP_REFERER'];?>" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Back');?>" role="button" aria-label="<?php echo localize('aria_back');?>"><?php svg('libre-gui-back');?></a>
        <a href="#" class="btn btn-ghost-normal info" onclick="$('#sp').load('core/email_booking.php?id=<?php echo$r['id'];?>');return false;" data-tooltip="tooltip" data-placement="left" title="<?php echo localize('Email').' '.localize('Booking');?>" role="button" aria-label="<?php echo localize('aria_email');?>"><?php svg('libre-gui-email-send');?></a>
        <?php if($help['bookings_edit_text']!='')echo'<a target="_blank" class="btn btn-ghost-normal info" href="'.$help['bookings_edit_text'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_texthelp').'">'.svg2('libre-gui-help').'</a>';
        if($help['bookings_edit_video']!='')echo'<a href="#" class="btn btn-ghost-normal info" data-toggle="modal" data-frame="iframe" data-target="#videoModal" data-video="'.$help['bookings_edit_video'].'" data-tooltip="tooltip" data-placement="left" title="'.localize('Watch Video Help').'" savefrom_lm="false" role="button" aria-label="'.localize('aria_view_videohelp').'">'.svg2('libre-gui-video').'</a>';?>
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <div class="form-group row">
          <label for="tis" class="col-form-label col-sm-2"><?php echo localize('Booked For');?></label>
          <div class="input-group col-sm-10">
            <?php echo($user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="tis" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'');?>
            <input type="text" id="tis" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" data-datetime="<?php echo date($config['dateFormat'],$r['tis']);?>"<?php echo$user['options']{2}==0?' readonly':'';?> role="textbox">
            <input type="hidden" id="tisx" value="<?php echo$r['tis'];?>">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savetis" class="btn btn-secondary save" data-dbid="tis" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="tie" class="col-form-label col-sm-2"><?php echo localize('Booking').' '.localize('End');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="tie" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="tie" class="form-control" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" data-datetime="<?php echo$r['tie']!=0?date($config['dateFormat'],$r['tie']):date($config['dateFormat'], $r['tis']);?>" autocomplete="off"<?php echo$user['options']{2}==0?' readonly':'';?> role="textbox">
            <input type="hidden" id="tiex" value="<?php echo$r['tie'];?>">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savetie" class="btn btn-secondary save" data-dbid="tie" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="status" class="col-form-label col-sm-2"><?php echo localize('Status');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="status" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <select id="status" class="form-control" onchange="update('<?php echo$r['id'];?>','content','status',$(this).val());"<?php echo$user['options']{2}==0?' readonly':'';?> data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="status" role="listbox">
              <option value="unconfirmed"<?php echo$r['status']=='unconfirmed'?' selected':'';?>><?php echo localize('Unconfirmed');?></option>
              <option value="confirmed"<?php echo$r['status']=='confirmed'?' selected':'';?>><?php echo localize('Confirmed');?></option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="cid" class="col-form-label col-sm-2"><?php echo localize('Client');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="changeClient" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').' </button></div>':'';?>
            <select id="cid" class="form-control" onchange="changeClient($(this).val(),<?php echo$r['id'];?>,'booking');" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="cid" role="listbox">
              <option value="0"<?php echo$r['cid']=='0'?' selected':'';?>><?php echo localize('Select a ').' '.localize('Client');?>...</option>
<?php $q=$db->query("SELECT id,business,username,name FROM `".$prefix."login` WHERE status!='delete' AND status!='suspended' AND active!='0' AND id!='0'");
while($rs=$q->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$rs['id'].'"'.($rs['id']==$r['cid']?' selected="selected"':'').'>'.$rs['username'].($rs['name']!=''?' ['.$rs['name'].']':'').($rs['business']!=''?' -> '.$rs['business']:'').'</option>';?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-form-label col-sm-2"><?php echo localize('Email');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="email" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="email" class="form-control textinput" name="email" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="<?php echo localize('Enter an ').' '.localize('Email');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="saveemail" class="btn btn-secondary save" data-dbid="email" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="phone" class="col-form-label col-sm-2"><?php echo localize('Phone');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="phone" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="phone" class="form-control textinput" name="phone" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone" placeholder="<?php echo localize('Enter a ').' '.localize('Phone');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savephone" class="btn btn-secondary save" data-dbid="phone" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="name" class="col-form-label col-sm-2"><?php echo localize('Name');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="name" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="name" class="form-control textinput" name="name" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="<?php echo localize('Enter a ').' '.localize('Name');?>..." onkeyup="$('#bookingname').html($(this).val());" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savename" class="btn btn-secondary save" data-dbid="name" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="business" class="col-form-label col-sm-2"><?php echo localize('Business');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="business" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="business" class="form-control textinput" name="business" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="<?php echo localize('Enter a ').' '.localize('Business');?>..." onkeyup="$('#bookingbusiness').html($(this).val());" role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savebusiness" class="btn btn-secondary save" data-dbid="business" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="address" class="col-form-label col-sm-2"><?php echo localize('Address');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="address" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="address" class="form-control textinput" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="address" placeholder="<?php echo localize('Enter an ').' '.localize('Address');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="saveaddress" class="btn btn-secondary save" data-dbid="address" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="suburb" class="col-form-label col-sm-2"><?php echo localize('Suburb');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="suburb" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="suburb" class="form-control textinput" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="suburb" placeholder="<?php echo localize('Enter a ').' '.localize('Suburb');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savesuburb" class="btn btn-secondary save" data-dbid="suburb" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="city" class="col-form-label col-sm-2"><?php echo localize('City');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="city" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="city" class="form-control textinput" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="city" placeholder="<?php echo localize('Enter a ').' '.localize('City');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savecity" class="btn btn-secondary save" data-dbid="city" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="state" class="col-form-label col-sm-2"><?php echo localize('State');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="state" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="state" class="form-control textinput" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="state" placeholder="<?php echo localize('Enter a ').' '.localize('State');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savestate" class="btn btn-secondary save" data-dbid="state" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="postcode" class="col-form-label col-sm-2"><?php echo localize('Postcode');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="postcode" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <input type="text" id="postcode" class="form-control textinput" name="postcode" value="<?php echo$r['postcode']!=0?$r['postcode']:'';?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="postcode" placeholder="<?php echo localize('Enter a ').' '.localize('Postcode');?>..." role="textbox">
            <div class="input-group-append" data-tooltip="tooltip" data-placement="top" title="<?php echo localize('Save');?>"><button id="savepostcode" class="btn btn-secondary save" data-dbid="postcode" data-style="zoom-in" role="button" aria-label="<?php echo localize('aria_save');?>"><?php svg('libre-gui-save');?></button></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="rid" class="control-label col-sm-2"><?php echo localize('Service');?></label>
          <div class="input-group col-sm-10">
            <?php echo$user['rank']>899?'<div class="input-group-prepend"><button class="btn btn-secondary fingerprint" data-dbgid="rid" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button></div>':'';?>
            <select id="rid" class="form-control" name="rid" onchange="update('<?php echo$r['id'];?>','content','rid',$(this).val());" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="rid" role="listbox">
              <option value="0"><?php echo localize('Select an ').' '.localize('Item');?>...</option>
<?php $sql=$db->query("SELECT id,contentType,code,title,assoc FROM `".$prefix."content` WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
while($row=$sql->fetch(PDO::FETCH_ASSOC))
  echo'<option value="'.$row['id'].'"'.($r['rid']==$row['id']?' selected':'').'>'.ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'].'</option>';?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="notes" class="col-form-label col-sm-2"><?php echo localize('Notes');?></label>
          <div class="col-sm-10">
            <div class="card-header p-0">
              <?php echo$user['rank']>899?'<button class="btn btn-secondary btn-sm fingerprint" data-dbgid="da" data-tooltip="tooltip" title="'.localize('Fingerprint Analysis').'" role="button" aria-label="'.localize('aria_fingerprintanalysis').'">'.svg2('libre-gui-fingerprint').'</button>':'';
              echo$user['rank']>899?'<div id="da" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="notes"></div>':'';?>
              <form id="summernote" method="post" target="sp" action="core/update.php">
                <input type="hidden" name="id" value="<?php echo$r['id'];?>">
                <input type="hidden" name="t" value="content">
                <input type="hidden" name="c" value="notes">
                <textarea id="notes" class="summernote" name="da" role="textbox"><?php echo rawurldecode($r['notes']);?></textarea>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
