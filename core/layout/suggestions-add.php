<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
$getcfg=true;
require_once'..'.DS.'db.php';
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');?>
<div id="suggestions_add">
  <form id="suggestionsform" method="post" action="core/add_suggestion.php">
    <input type="hidden" name="id" value="<?php echo$id;?>">
    <input type="hidden" name="t" value="<?php echo$t;?>">
    <input type="hidden" name="c" value="<?php echo$c;?>">
<?php if($c!='notes'){?>
    <div class="form-group">
      <label for="suggestedit" class="control-label col-xs-4">Suggested Edit</label>
      <div class="input-group col-xs-8">
        <input id="suggestedit" class="form-control" name="da" value="" placeholder="Enter the suggested edit...">
      </div>
    </div>
<?php }else{?>
    <div class="form-group">
      <div class="alert alert-info">Edit the content within the Editor before adding this suggestion, just don't save the content.</div>
      <textarea id="suggestda" name="da" class="d-none"></textarea>
    </div>
<?php }?> 
    <div class="form-group">
      <label for="suggestreason" class="control-label col-xs-4">Reason</label>
      <div class="input-group col-xs-8">
        <input id="suggestreason" class="form-control" name="dar" value="" placeholder="Enter a reason for the suggested edit...">
      </div>
    </div>
    <div class="form-group text-right">
      <button type="submit" class="btn btn-secondary add">Add Suggestion</button>
    </div>
  </form>
</div>
<script>/*<![CDATA[*/
<?php if($c=='notes'){?>
  $('#suggestda').html($('#notes').summernote('code'));
<?php }?>
  $("#suggestionsform").submit(function(){
      $.post($(this).attr("action"),$(this).serialize(),function(data){
          $("#suggestions_add").html(data);
      });
      return false;
  });
/*]]>*/</script>
