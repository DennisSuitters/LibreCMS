<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo '<script>/*<![CDATA[*/';
if (session_status() == PHP_SESSION_NONE) session_start();
$getcfg = true;
require'db.php';
function svg ($svg, $color = null, $class = null, $size = null) {
	echo '<i class="libre';
	if ($size != null) echo ' libre-' . $size;
	if ($color == true) $svg = 'col' . DS . $svg;
	elseif ($color != null) echo ' libre-' . $color;
  if ($class != null) echo ' ' . $class;
	echo '">';
	include 'svg' . DS . $svg . '.svg';
	echo '</i>';
}
function svg2 ($svg, $color = null, $class = null, $size = null) {
	$svgout = '<i class="libre';
	if ($size != null) $svgout .= ' libre-' . $size;
	if ($color == true) $svg = 'col' . DS . $svg;
	elseif ($color != null) $svgout .= ' libre-' . $color;
  if ($class != null) $svgout .= ' ' . $class;
	$svgout .= '">';
	$svgout .= file_get_contents('svg' . DS . $svg . '.svg');
	$svgout .= '</i>';
	return $svgout;
}
$act = isset($_POST['act']) ? filter_input(INPUT_POST, 'act', FILTER_SANITIZE_STRING) : filter_input(INPUT_GET, 'act', FILTER_SANITIZE_STRING);
$id = isset($_POST['id']) ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) : filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$t = isset($_POST['t']) ? filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING) : filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING);
$c = isset($_POST['c']) ? filter_input(INPUT_POST, 'c', FILTER_SANITIZE_STRING) : filter_input(INPUT_GET, 'c', FILTER_SANITIZE_STRING);
$da = isset($_POST['da']) ? filter_input(INPUT_POST, 'da', FILTER_SANITIZE_STRING) : filter_input(INPUT_GET, 'da', FILTER_SANITIZE_STRING);
$ti = time();
if ($act == 'additem') {
	if ($da != 0) {
		$q =$db -> prepare("SELECT title,cost FROM content WHERE id=:id");
		$q -> execute(
      array(
        ':id' => $da
      )
    );
		$r = $q -> fetch(PDO::FETCH_ASSOC);
		if ($r['cost'] == '' || !is_numeric($r['cost']))
      $r['cost'] = 0;
	} else {
    $r = array(
      'title' => '',
      'cost'  => 0
    );
  }
	$q = $db -> prepare("INSERT INTO orderitems (oid,iid,title,quantity,cost,ti) VALUES (:oid,:iid,:title,'1',:cost,:ti)");
	$q -> execute(
    array(
      ':oid'   => $id,
      ':iid'   => $da,
      ':title' => $r['title'],
      ':cost'  => $r['cost'],
      ':ti'    => time()
    )
  );
}
if ($act == 'title') {
  $ss = $db -> prepare("SELECT * FROM orderitems WHERE id=:id");
  $ss -> execute(
    array(
      ':id' => $id
    )
  );
  $r = $ss -> fetch(PDO::FETCH_ASSOC);
  $s = $db -> prepare("UPDATE orderitems SET title=:title WHERE id=:id");
  $s -> execute(
    array(
      ':id'    => $id,
      ':title' => $da
    )
  );
  $id = $r['oid'];
}
if ($act == 'quantity' || $act == 'trash') {
  $ss = $db -> prepare("SELECT * FROM orderitems WHERE id=:id");
  $ss -> execute(
    array(
      ':id' => $id
    )
  );
  $r = $ss -> fetch(PDO::FETCH_ASSOC);
  if ($da == 0) {
    $s =$db -> prepare("DELETE FROM orderitems WHERE id=:id");
    $s -> execute(
      array(
        ':id' => $id
      )
    );
  } else {
    $s = $db -> prepare("UPDATE orderitems SET quantity=:quantity WHERE id=:id");
    $s -> execute(
      array(
        ':quantity' => $da,
        ':id'       => $id
      )
    );
  }
  $id = $r['oid'];
}
if ($act == 'cost') {
  $ss = $db -> prepare("SELECT * FROM orderitems WHERE id=:id");
  $ss -> execute(
    array(
      ':id' => $id
    )
  );
  $r =$ss -> fetch(PDO::FETCH_ASSOC);
  $s =$db -> prepare("UPDATE orderitems SET cost=:cost WHERE id=:id");
  $s -> execute(
    array(
      ':cost' => $da,
      ':id'   => $id
    )
  );
  $id = $r['oid'];
}
if ($act == 'reward') {
  $sr =$db -> prepare("SELECT * FROM rewards WHERE code=:code");
  $sr -> execute(
    array(
      ':code' => $da
    )
  );
  $reward = $sr -> fetch(PDO::FETCH_ASSOC);
  $s = $db -> prepare("UPDATE orders SET rid=:rid WHERE id=:id");
  $s -> execute(
    array(
      ':rid' => $reward['id'],
      ':id'  => $id
    )
  );
}
if ($act == 'postage') {
  $s =$db -> prepare("UPDATE orders SET postage=:postage WHERE id=:id");
  $s -> execute(
    array(
      ':postage' => $da,
      ':id'      => $id
    )
  );
}
$s = $db -> prepare("SELECT * FROM orders WHERE id=:id");
$s -> execute(
  array(
    ':id' => $id
  )
);
$r = $s -> fetch(PDO::FETCH_ASSOC);
$si = $db -> prepare("SELECT * FROM orderitems WHERE oid=:oid ORDER BY ti ASC,title ASC");
$si -> execute(
  array(
    ':oid' => $r['id']
  )
);
$total = 0;
$html = '';
while ($oi = $si -> fetch(PDO::FETCH_ASSOC)) {
  $is = $db -> prepare("SELECT id,code,title FROM content WHERE id=:id");
  $is -> execute(
    array(
      ':id' => $oi['iid']
    )
  );
  $i = $is -> fetch(PDO::FETCH_ASSOC);
  $sc = $db -> prepare("SELECT * FROM choices WHERE id=:id");
  $sc -> execute(
    array(
      ':id' => $oi['cid']
    )
  );
  $c =$sc -> fetch(PDO::FETCH_ASSOC);
  $html .= '<tr>';
    $html .= '<td class="text-left">';
      $html .= $i['code'];
    $html .= '</td>';
    $html .= '<td class="text-left">';
  if ($oi['iid'] != 0) $html .= $i['title'];else {
      $html .= '<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();">';
        $html .= '<input type="hidden" name="act" value="title">';
        $html .= '<input type="hidden" name="id" value="' . $oi['id'] . '">';
        $html .= '<input type="hidden" name="t" value="orderitems">';
        $html .= '<input type="hidden" name="c" value="title">';
        $html .= '<input type="text" class="form-control" name="da" value="' . $oi['title'] . '">';
      $html .= '</form>';
  }
    $html .= '</td>';
    $html .= '<td class="text-left hidden-xs">' . $c['title'] . '</td>';
    $html .= '<td class="col-sm-1 text-center">';
  if ($oi['iid'] != 0) {
      $html .= '<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();">';
        $html .= '<input type="hidden" name="act" value="quantity">';
        $html .= '<input type="hidden" name="id" value="' . $oi['id'] . '">';
        $html .= '<input type="hidden" name="t" value="orderitems">';
        $html .= '<input type="hidden" name="c" value="quantity">';
        $html .= '<input class="form-control text-center" name="da" value="' . $oi['quantity'] . '"';
      if ($r['status'] == 'archived') $html .= ' readonly';$html .= '>';
      $html .= '</form>';
  } else {
    if ($oi['iid'] != 0) echo $oi['quantity'];
  }
    $html .= '</td>';
    $html .= '<td class="col-sm-1 text-right">';
  if ($oi['iid'] != 0){
      $html .= '<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();">';
        $html .= '<input type="hidden" name="act" value="cost">';
        $html .= '<input type="hidden" name="id" value="' . $oi['id'] . '">';
        $html .= '<input type="hidden" name="t" value="orderitems">';
        $html .= '<input type="hidden" name="c" value="cost">';
        $html .= '<input class="form-control text-center" name="da" value="' . $oi['cost'] . '"';if ($r['status'] == 'archived') $html .= ' readonly';$html .= '>';
      $html.='</form>';
  } elseif ($oi['iid'] != 0) echo $oi['cost'];
    $html .= '</td>';
    $html .= '<td class="col-sm-1 text-right">';
  if ($oi['iid'] != 0)
    $html .= $oi['cost'] * $oi['quantity'];
    $html .= '</td>';
    $html .= '<td class="text-right">';
      $html .= '<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();">';
        $html .= '<input type="hidden" name="act" value="trash">';
        $html .= '<input type="hidden" name="id" value="' . $oi['id'] . '">';
        $html .= '<input type="hidden" name="t" value="orderitems">';
        $html .= '<input type="hidden" name="c" value="quantity">';
        $html .= '<input type="hidden" name="da" value="0">';
        $html .= '<button class="btn btn-default trash">' . svg2('libre-gui-trash',($config['iconsColor']==1?true:null)) . '</button>';
      $html .= '</form>';
    $html .= '</td>';
  $html .= '</tr>';
  if ($oi['iid'] != 0) $total = $total + ($oi['cost'] * $oi['quantity']);
}
$rs = $db -> prepare("SELECT * FROM rewards WHERE id=:rid");
$rs -> execute(
  array(
    ':rid' => $r['rid']
  )
);
$reward = $rs -> fetch(PDO::FETCH_ASSOC);
  $html .= '<tr>';
    $html .= '<td colspan="3" class="text-right"><strong>Rewards Code</strong></td>';
    $html .= '<td class="text-center">';
      $html .= '<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();">';
        $html .= '<input type="hidden" name="act" value="reward">';
        $html .= '<input type="hidden" name="id" value="' . $r['id'] . '">';
        $html .= '<input type="hidden" name="t" value="orders">';
        $html .= '<input type="hidden" name="c" value="rid">';
        $html .= '<input type="text" class="form-control" name="da" value="';if ($rs -> rowCount() == 1) $html .= $reward['code'];$html .= '">';
      $html .= '</form>';
    $html .= '</td>';
    $html .= '<td class="text-center">';
if ($rs -> rowCount() == 1) {
  if ($reward['method'] == 1) {
    $html .= '$';
    $total = $total - $reward['value'];
  }
  $html .= $reward['value'];
  if ($reward['method'] == 0) {
    $html .= '%';
    $total = ($total * ((100 - $reward['value']) / 100));
  }
  $html .= ' Off';
}
    $html .= '</td>';
    $html .= '<td class="text-right"><strong>' . $total . '</strong></td>';
    $html .= '<td></td>';
  $html .= '</tr>';
  $html .= '<tr>';
    $html .= '<td colspan="5" class="text-right"><strong>Postage</strong></td>';
    $html .= '<td class="postage">';
      $html .= '<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();">';
        $html .= '<input type="hidden" name="act" value="postage">';
        $html .= '<input type="hidden" name="id" value="' . $r['id'] . '">';
        $html .= '<input type="hidden" name="t" value="orders">';
        $html .= '<input type="hidden" name="c" value="postage">';
        $html .= '<input type="text" class="form-control text-right" name="da" value="' . $r['postage'];$total = $total + $r['postage'];$html .= '">';
      $html .= '</form>';
    $html .= '</td>';
    $html .= '<td></td>';
  $html .= '</tr>';
  $html .= '<tr>';
    $html .= '<td colspan="5" class="text-right"><strong>Total</strong></td>';
    $html .= '<td class="total text-right"><strong>' . $total . '</strong></td>';
    $html .= '<td></td>';
  $html .= '</tr>';?>
  window.top.window.$('#updateorder').html('<?php echo $html;?>');
  window.top.window.Pace.stop();
<?php
echo '/*]]>*/</script>';
