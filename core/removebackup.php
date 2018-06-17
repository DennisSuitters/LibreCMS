<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT
 */
define('DS', DIRECTORY_SEPARATOR);
$id = isset($_POST['id']) ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING) : filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
unlink('..' . DS . 'media' . DS . 'backup' . DS . $id . '.sql.gz');?>
<script>/*<![CDATA[*/
  window.top.window.$("#l_<?php echo $id;?>").slideUp(500,function(){$(this).remove()});
/*]]>*/</script>