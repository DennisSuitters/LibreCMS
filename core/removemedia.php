<?php
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
unlink('../media/'.str_replace('~',' ',$t));?>
<script>/*<![CDATA[*/
	window.top.window.$('#l_<?php echo$id;?>').slideUp(500,function(){$(this).remove()});
/*]]>*/</script>
