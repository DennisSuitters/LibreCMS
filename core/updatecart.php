<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * Core - Update Cart
 *
 * updatecart.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - Core - Update Cart
 * @package    core/updatecart.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
echo'<script>';
if(session_status()==PHP_SESSION_NONE)session_start();
$getcfg=true;
require'db.php';
define('SESSIONID',session_id());
define('THEME','..'.DS.'layout'.DS.$config['theme']);
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
define('UNICODE','UTF-8');
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
$act=filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING);
$ip=$_SERVER['REMOTE_ADDR']=='::1'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];
$si=session_id();
$error=0;
$ti=time();
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$tbl=filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING);
$col=filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING);
$da=filter_input(INPUT_POST,'da',FILTER_SANITIZE_NUMBER_INT);
$cnt='';
if($act=='quantity'){
  if($da==0){
    $q=$db->prepare("DELETE FROM `".$prefix."cart` WHERE id=:id");
    $q->execute([':id'=>$id]);
  }else{
    $q=$db->prepare("UPDATE `".$prefix."cart` SET quantity=:quantity WHERE id=:id");
    $q->execute([
      ':id'=>$id,
      ':quantity'=>$da
    ]);
  }
  $q=$db->prepare("SELECT SUM(quantity) as quantity FROM `".$prefix."cart` WHERE si=:si");
  $q->execute([':si'=>$si]);
  $r=$q->fetch(PDO::FETCH_ASSOC);
  $cnt=$r['quantity'];
  if($r['quantity']==0)$cnt='';?>
  window.top.document.getElementById("cart").innerHTML='<?php echo$cnt;?>';
<?php $total=0;
  $content='';
  $q=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE si=:si ORDER BY ti DESC");
  $q->execute([':si'=>$si]);
  if($q->rowCount()==0){?>
  window.top.document.getElementById("content").innerHTML='<?php echo$theme['settings']['cart_empty'];?>';
<?php }else{
  $total=0;
  $s=$db->prepare("SELECT * FROM `".$prefix."cart` WHERE si=:si ORDER BY ti DESC");
  $s->execute([':si'=>SESSIONID]);
  $html=file_get_contents(THEME.DS.'cart.html');
  preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
  $cartloop=$matches[1];
  $cartitems='';
  if($s->rowCount()>0){
    while($ci=$s->fetch(PDO::FETCH_ASSOC)){
      $cartitem=$cartloop;
      $si=$db->prepare("SELECT id,code,title FROM `".$prefix."content` WHERE id=:id");
      $si->execute([':id'=>$ci['iid']]);
      $i=$si->fetch(PDO::FETCH_ASSOC);
      $cartitem=preg_replace([
        '/<print content=[\"\']?code[\"\']?>/',
        '/<print content=[\"\']?title[\"\']?>/',
        '/<print cart=[\"\']?id[\"\']?>/',
        '/<print cart=[\"\']?quantity[\"\']?>/',
        '/<print cart=[\"\']?cost[\"\']?>/',
        '/<print itemscalculate>/'
      ],[
        $i['code'],
        $i['title'],
        $ci['id'],
        $ci['quantity'],
        $ci['cost'],
        $ci['cost']*$ci['quantity']
      ],$cartitem);
      $total=$total+($ci['cost']*$ci['quantity']);
      $cartitems.=$cartitem;
    }?>
  window.top.document.getElementById("total").innerHTML='<?php echo$total;?>';
  window.top.document.getElementById("orderitems").innerHTML='<?php echo preg_replace('/^\s+|\n|\r|\s+$/m','',$cartitems);?>';
<?php }
  }
}
echo'</script>';
