<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Change Order Client
 *
 * change_orderClient.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Change Order Client
 * @package    core/change_orderClient.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
echo'<script>';
require'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$oid=filter_input(INPUT_GET,'oid',FILTER_SANITIZE_NUMBER_INT);
$q=$db->prepare("UPDATE `".$prefix."orders` SET cid=:cid WHERE id=:oid");
$q->execute([
  ':cid'=>$id,
  ':oid'=>$oid
]);
if($id==0){
  $c=[
    'id'=>0,
    'username'=>'',
    'name'=>'',
    'business'=>'',
    'address'=>'',
    'suburb'=>'',
    'state'=>'',
    'city'=>'',
    'postcode'=>'',
    'email'=>'',
    'phone'=>'',
    'mobile'=>''
  ];
}else{
  $q=$db->prepare("SELECT * FROM `".$prefix."login` WHERE id=:id");
  $q->execute([':id'=>$id]);
  $c=$q->fetch(PDO::FETCH_ASSOC);
}?>
  window.top.window.$('#client_business').val('<?php echo$c['username'].($c['name']!=''?' ['.$c['name'].']':'').($c['business']!=''?' -> '.$c['business']:'');?>');
  window.top.window.$('#address').val('<?php echo$c['address'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#suburb').val('<?php echo$c['suburb'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#state').val('<?php echo$c['state'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#city').val('<?php echo$c['city'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#postcode').val('<?php echo$c['postcode'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#email').val('<?php echo$c['email'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#phone').val('<?php echo$c['phone'];?>').data("dbid",<?php echo$c['id'];?>);
  window.top.window.$('#mobile').val('<?php echo$c['mobile'];?>').data("dbid",<?php echo$c['id'];?>);
<?php
echo'</script>';
