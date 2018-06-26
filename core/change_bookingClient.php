<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo'<script>/*<![CDATA[*/';
include'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$bid=filter_input(INPUT_GET,'bid',FILTER_SANITIZE_NUMBER_INT);
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
}
$q=$db->prepare("UPDATE content SET  cid=:cid,business=:business,name=:name,address=:address,suburb=:suburb,state=:state,city=:city,postcode=:postcode,email=:email,phone=:phone,mobile=:mobile WHERE id=:id");
$q->execute(
  array(
    ':cid'     =>$id,
    ':business'=>$c['business'],
    ':name'    =>$c['name'],
    ':address' =>$c['address'],
    ':suburb'  =>$c['suburb'],
    ':state'   =>$c['state'],
    ':city'    =>$c['city'],
    ':postcode'=>$c['postcode'],
    ':email'   =>$c['email'],
    ':phone'   =>$c['phone'],
    ':mobile'  =>$c['mobile'],
    ':id'      =>$bid
  )
);?>
  window.top.window.$('#business').val('<?php echo$c['business'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#name').val('<?php echo$c['name'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#address').val('<?php echo$c['address'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#suburb').val('<?php echo$c['suburb'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#state').val('<?php echo$c['state'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#city').val('<?php echo$c['city'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#postcode').val('<?php echo$c['postcode'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#email').val('<?php echo$c['email'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#phone').val('<?php echo$c['phone'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#mobile').val('<?php echo$c['mobile'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.Pace.stop();
<?php
echo'/*]]>*/</script>';
