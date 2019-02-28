<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Database Preferences
 *
 * pref_database.php version 2.0.0
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
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<main id="content" class="main">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a class="text-muted" href="<?php echo URL.$settings['system']['admin'].'/preferences';?>">Preferences</a></li>
    <li class="breadcrumb-item active" aria-current="page">Database</li>
    <li class="breadcrumb-menu">
      <div class="btn-group" role="group" aria-label="">
        
      </div>
    </li>
  </ol>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <legend>Database Options</legend>
        <form target="sp" method="post" action="core/changeprefix.php">
          <div class="form-group row">
            <label for="prefix" class="col-form-label col-sm-2">Table Prefix</label>
            <div class="input-group col-sm-10">
              <input type="text" id="prefix" class="form-control textinput" name="dbprefix" value="<?php echo$prefix;?>" placeholder="Enter a Prefix...">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary" onclick="$('body').append('<div id=blocker><div></div></div>');Pace.restart();">Update</button>
              </div>
            </div>
          </div>
        </form>
        <legend>Database Backup/Restore</legend>
        <div id="backup" name="backup">
          <div id="backup_info">
<?php $tid=$ti-2592000;
if($config['backup_ti']<$tid)
  echo$config['backup_ti']==0?'<div class="alert alert-info">A Backup has yet to be performed.</div>':'<div class="alert alert-danger">It has been more than 30 days since a Backup has been performed.</div>';?>
          </div>
          <form target="sp" method="post" action="core/backup.php">
            <div class="form-group row">
              <label class="col-form-label col-sm-2">Backup</label>
              <div class="input-group col-sm-10">
                <button type="submit" class="btn btn-secondary btn-block" onclick="Pace.restart();">Perform Backup</button>
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
                <a class="btn btn-secondary col" href="<?php echo$file;?>">Click to Download <?php echo ltrim($file,'media'.DS.'backup'.DS);?></a>
                <div class="input-group-append">
                  <button class="btn btn-secondary trash" onclick="removeBackup('<?php echo$filename;?>')"><?php svg('libre-gui-trash');?></button>
                </div>
              </div>
            </div>
<?php }?>
          </div>
          <form target="sp" method="post" enctype="multipart/form-data" action="core/restorebackup.php">
            <div class="form-group row">
              <label class="col-form-label col-sm-2">Restore</label>
              <div class="input-group col-sm-10">
                <div class="custom-file col">
                  <input id="restorefu" type="file" class="custom-file-input" name="fu" accept="application/sql">
                  <label class="custom-file-label" for="resturefu">Choose file</label>
                </div>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-secondary" onclick="Pace.restart();">Restore</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
