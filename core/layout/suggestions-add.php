<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Administration - Add Suggestions Popup
 *
 * suggestions-add.php version 2.0.2
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Popup - Add Suggestions
 * @package    core/layout/suggestions-add.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.2
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 * @changes    v2.0.2 Add i18n.
 * @changes    v2.0.2 Fix ARIA Attributes.
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require'..'.DS.'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');?>
<div id="suggestions_add">
  <form id="suggestionsform" method="post" action="core/add_suggestion.php" role="form">
    <input type="hidden" name="id" value="<?php echo$id;?>">
    <input type="hidden" name="t" value="<?php echo$t;?>">
    <input type="hidden" name="c" value="<?php echo$c;?>">
<?php if($c!='notes'){?>
    <div class="form-group">
      <label for="suggestedit" class="control-label col-xs-4"><?php localize('Suggested Edit');?></label>
      <div class="input-group col-xs-8">
        <input id="suggestedit" class="form-control" name="da" value="" placeholder="<?php localize('Enter ').' '.localize('Suggested Edit');?>..." role="textbox">
      </div>
    </div>
<?php }else{?>
    <div class="form-group">
      <div class="alert alert-info" role="alert"><?php localize('help_suggestion');?></div>
      <textarea id="suggestda" name="da" class="d-none"></textarea>
    </div>
<?php }?> 
    <div class="form-group">
      <label for="suggestreason" class="control-label col-xs-4"><?php localize('Reason');?></label>
      <div class="input-group col-xs-8">
        <input id="suggestreason" class="form-control" name="dar" value="" placeholder="Enter a reason for the suggested edit..." role="textbox">
      </div>
    </div>
    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary add"><?php localize('Add Suggestion');?></button>
    </div>
  </form>
</div>
<script>
<?php if($c=='notes'){?>
  $('#suggestda').html($('#notes').summernote('code'));
<?php }?>
  $("#suggestionsform").submit(function(){
    $.post($(this).attr("action"),$(this).serialize(),function(data){
      $("#suggestions_add").html(data);
    });
    return false;
  });
</script>
