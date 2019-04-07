<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Database Preferences
 *
 * pref_database.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Preferences - Database
 * @package    core/layout/pref_database.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo URL.$settings['system']['admin'].'/preferences';?>"><?php echo localize('Preferences');?></a></li>
    <li class="breadcrumb-item active"><?php echo localize('Database');?></li>
  </ol>
  <div class="container-fluid">
    <noscript><div class="alert alert-danger" role="alert"><?php echo localize('alert_all_danger_noscript');?></div></noscript>
    <div class="alert alert-warning d-sm-block d-md-none" role="alert"><?php echo localize('alert_all_warning_smallscreen');?></div>
    <div class="card">
      <div class="card-body">
        <legend><?php echo localize('Database Options');?></legend>
        <form target="sp" method="post" action="core/changeprefix.php" role="form">
          <div class="form-group row">
            <label for="prefix" class="col-form-label col-sm-2"><?php echo localize('Table Prefix');?></label>
            <div class="input-group col-sm-10">
              <input type="text" id="prefix" class="form-control textinput" name="dbprefix" value="<?php echo$prefix;?>" placeholder="<?php echo localize('Enter a ').' '.localize('Table Prefix');?>..." role="textbox">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary" onclick="$('body').append('<div id=blocker><div></div></div>');Pace.restart();" role="button" aria-label="<?php echo localize('aria_update');?>"><?php echo localize('Update');?></button>
              </div>
            </div>
          </div>
        </form>
        <legend><?php echo localize('Database Backup/Restore');?></legend>
        <div id="backup" name="backup">
          <div id="backup_info">
<?php $tid=$ti-2592000;
if($config['backup_ti']<$tid)
  echo$config['backup_ti']==0?'<div class="alert alert-info" role="alert">'.localize('alert_backup_info_nobackup').'</div>':'<div class="alert alert-danger" role="alert">'.localize('alert_backup_danger_30daysbackup').'</div>';?>
          </div>
          <form target="sp" method="post" action="core/backup.php" role="form">
            <div class="form-group row">
              <label class="col-form-label col-sm-2"><?php echo localize('Backup');?></label>
              <div class="input-group col-sm-10">
                <button type="submit" class="btn btn-secondary btn-block" onclick="Pace.restart();" role="button" aria-label="<?php echo localize('aria_backup');?>"><?php echo localize('Perform Backup');?></button>
              </div>
            </div>
          </form>
          <div id="backups" class="form-group">
<?php foreach(glob("media".DS."backup".DS."*") as$file){
  $filename=basename($file);
  $filename=rtrim($filename,'.sql.gz');?>
            <div id="l_<?php echo$filename;?>" class="form-group row">
              <div class="col-form-label col-sm-2"></div>
              <div class="input-group col-sm-10">
                <a class="btn btn-secondary col" href="<?php echo$file;?>"><?php echo localize('Click to Download').' '.ltrim($file,'media'.DS.'backup'.DS);?></a>
                <div class="input-group-append">
                  <button class="btn btn-secondary trash" onclick="removeBackup('<?php echo$filename;?>')" role="button" aria-label="<?php echo localize('aria_delete');?>"><?php svg('libre-gui-trash');?></button>
                </div>
              </div>
            </div>
<?php }?>
          </div>
          <form target="sp" method="post" enctype="multipart/form-data" action="core/restorebackup.php" role="form">
            <div class="form-group row">
              <label class="col-form-label col-sm-2"><?php echo localize('Restore');?></label>
              <div class="input-group col-sm-10">
                <div class="custom-file col">
                  <input id="restorefu" type="file" class="custom-file-input" name="fu" accept="application/sql">
                  <label class="custom-file-label" for="resturefu"><?php echo localize('Choose File');?></label>
                </div>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-secondary" onclick="Pace.restart();" role="button" aria-label="<?php echo localize('aria_restore');?>"><?php echo localize('Restore');?></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
