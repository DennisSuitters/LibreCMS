<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo'<script>/*<![CDATA[*/';
include'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
$q=$db->prepare("UPDATE orders SET cid=:cid WHERE id=:oid");
$q->execute(
  array(
    ':cid'=>$id,
    ':oid'=>$oid
  )
);
if($id==0){
  $c=array(
    'id'      =>0,
    'username'=>'',
    'name'    =>'',
    'business'=>'',
    'address' =>'',
    'suburb'  =>'',
    'state'   =>'',
    'city'    =>'',
    'postcode'=>'',
    'email'   =>'',
    'phone'   =>'',
    'mobile'  =>''
  );
}else{
  $q=$db->prepare("SELECT * FROM login WHERE id=:id");
  $q->execute(array(':id'=>$id));
  $c=$q->fetch(PDO::FETCH_ASSOC);
}?>
  window.top.window.$('#client_business').val('<?php echo$c['username'].($c['name']!=''?' ['.$c['name'].']':'').($c['business']!=''?' -> '.$c['business']:'');?>');
  window.top.window.$('#client_address').val('<?php echo$c['address'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#client_suburb').val('<?php echo$c['suburb'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#client_state').val('<?php echo$c['state'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#client_city').val('<?php echo$c['city'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#client_postcode').val('<?php echo$c['postcode'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#client_email').val('<?php echo$c['email'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#client_phone').val('<?php echo$c['phone'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#client_mobile').val('<?php echo$c['mobile'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.Pace.stop();
<?php
echo'/*]]>*/</script>';
