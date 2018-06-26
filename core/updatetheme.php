<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
define('DS',DIRECTORY_SEPARATOR);
$file=$_POST['file'];
$code=$_POST['code'];
$fp=fopen('..'.DS.$file,'w');
fwrite($fp,$code);
fclose($fp);?>
<script>/*<![CDATA[*/
  window.top.window.Pace.stop();
/*]]>*/</script>
