<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo '<script>/*<![CDATA[*/';
if (session_status() == PHP_SESSION_NONE) session_start();
$getcfg = true;
include 'db.php';
define('SESSIONID', session_id());
define('THEME', '..' . DS . 'layout' . DS . $config['theme']);
define('URL', PROTOCOL . $_SERVER['HTTP_HOST'] . $settings['system']['url'] . '/');
define('UNICODE', 'UTF-8');
$theme = parse_ini_file(THEME . DS . 'theme.ini', true);
$act   = filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING);
$ip    = $_SERVER['REMOTE_ADDR'];
$si    = session_id();
$error = 0;
$ti    = time();
$id    = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$tbl   = filter_input(INPUT_POST, 't',  FILTER_SANITIZE_STRING);
$col   = filter_input(INPUT_POST, 'c',  FILTER_SANITIZE_STRING);
$da    = filter_input(INPUT_POST, 'da', FILTER_SANITIZE_NUMBER_INT);
$cnt   = '';
if ($act == 'quantity') {
  if ($da == 0) {
    $q = $db -> prepare("DELETE FROM cart WHERE id=:id");
    $q -> execute(
      array(
        ':id' => $id
      )
    );
  } else {
    $q = $db -> prepare("UPDATE cart SET quantity=:quantity WHERE id=:id");
    $q -> execute(
      array(
        ':id'       => $id,
        ':quantity' => $da
      )
    );
  }
  $q = $db -> prepare("SELECT SUM(quantity) as quantity FROM cart WHERE si=:si");
  $q -> execute(
    array(
      ':si' => $si
    )
  );
  $r = $q -> fetch(PDO::FETCH_ASSOC);
  $cnt = $r['quantity'];
  if ($r['quantity'] == 0) $cnt = '';
?>
  window.top.document.getElementById("cart").innerHTML='<?php echo $cnt;?>';
<?php $total = 0;
  $content = '';
  $q = $db -> prepare("SELECT * FROM cart WHERE si=:si ORDER BY ti DESC");
  $q -> execute(
    array(
      ':si' => $si
    )
  );
  if ($q -> rowCount() == 0) {?>
  window.top.document.getElementById("content").innerHTML='<?php echo $theme['settings']['cart_empty'];?>';
<?php } else {
  $total = 0;
  $s =$db -> prepare("SELECT * FROM cart WHERE si=:si ORDER BY ti DESC");
  $s -> execute(
    array(
      ':si' => SESSIONID
    )
  );
  $html = file_get_contents(THEME . DS . 'cart.html');
  preg_match('/<items>([\w\W]*?)<\/items>/', $html, $matches);
  $cartloop = $matches[1];
  $cartitems = '';
  if ($s -> rowCount() > 0) {
    while ($ci = $s -> fetch(PDO::FETCH_ASSOC)) {
      $cartitem = $cartloop;
      $si = $db -> prepare("SELECT id,code,title FROM content WHERE id=:id");
      $si -> execute(
        array(
          ':id' => $ci['iid']
        )
      );
      $i = $si -> fetch(PDO::FETCH_ASSOC);
      $cartitem = str_replace('<print content="code">', $i['code'], $cartitem);
      $cartitem = str_replace('<print content="title">', $i['title'], $cartitem);
      $cartitem = str_replace('<print cart=id>', $ci['id'], $cartitem);
      $cartitem = str_replace('<print cart=quantity>', $ci['quantity'], $cartitem);
      $cartitem = str_replace('<print cart=cost>', $ci['cost'], $cartitem);
      $cartitem = str_replace('<print itemscalculate>', $ci['cost'] * $ci['quantity'], $cartitem);
      $total = $total + ($ci['cost'] * $ci['quantity']);
      $cartitems .= $cartitem;
    }?>
  window.top.document.getElementById("total").innerHTML='<?php echo $total;?>';
  window.top.document.getElementById("orderitems").innerHTML='<?php echo preg_replace('/^\s+|\n|\r|\s+$/m', '', $cartitems);?>';
<?php }
  }
}
echo '/*]]>*/</script>';
