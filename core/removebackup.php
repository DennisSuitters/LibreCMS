<?php
define('DS',DIRECTORY_SEPARATOR);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
$id2=isset($_POST['id2'])?filter_input(INPUT_POST,'id2',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'id2',FILTER_SANITIZE_STRING);
unlink('..'.DS.'media'.DS.'backup'.DS.$id);?>
<script>/*<![CDATA[*/
	window.top.window.$('#l_<?php echo$id2;?>').slideUp(500,function(){$(this).remove()});
/*]]>*/</script>
