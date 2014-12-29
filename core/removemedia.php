<?php
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
unlink('../media/'.$id);?>
<script>/*<![CDATA[*/
	window.top.window.$('#l_<?php echo str_replace('.','',$id);?>').slideUp(500,function(){$(this).remove()});
/*]]>*/</script>
