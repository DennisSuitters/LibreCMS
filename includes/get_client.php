<script>/*<![CDATA[*/
<?php session_start();
include'db.php';
$email=filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING);
$content='';
if($email==''){?>
	window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'You must enter an Email to retrieve account information'}}).show();
<?php }else{
	$s=$db->prepare("SELECT * FROM login WHERE email=:email AND status!='delete' AND active!='0'");
	$s->execute(array('email'=>$email));
	if($s->rowCount()>0){
		$r=$s->fetch(PDO::FETCH_ASSOC);?>
	window.top.window.$("#business").val("<?php echo$r['business'];?>");
	window.top.window.$("#address").val("<?php echo$r['address'];?>");
	window.top.window.$("#suburb").val("<?php echo$r['suburb'];?>");
	window.top.window.$("#city").val("<?php echo$r['city'];?>");
	window.top.window.$("#state").val("<?php echo$r['state'];?>");
	window.top.window.$("#postcode").val("<?php if($r['postcode']!=0){echo$r['postcode'];}else{echo'';}?>");
	window.top.window.$("#phone").val("<?php echo$r['phone'];?>");
<?php }else{?>
	window.top.window.$('.notifications').notify({type:'danger',icon:'',message:{text:'No account Exists with Email matching <strong><?php echo$email;?></strong>'}}).show();
<?php }
}?>
	window.top.window.$('#busy').css("display","none");
/*]]>*/</script>
