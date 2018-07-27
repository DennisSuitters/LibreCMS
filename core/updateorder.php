<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
echo'<script>/*<![CDATA[*/';
if(session_status()==PHP_SESSION_NONE)session_start();
$getcfg=true;
require_once'db.php';
function svg($svg,$class=null,$size=null){
	echo'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
function svg2($svg,$class=null,$size=null){
	return'<i class="libre'.($size!=null?' libre-'.$size:'').($class!=null?' '.$class:'').'">'.file_get_contents('svg'.DS.$svg.'.svg').'</i>';
}
$act=isset($_POST['act'])?filter_input(INPUT_POST,'act',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'act',FILTER_SANITIZE_STRING);
$id=isset($_POST['id'])?filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT):filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$t=isset($_POST['t'])?filter_input(INPUT_POST,'t',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING);
$c=isset($_POST['c'])?filter_input(INPUT_POST,'c',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING);
$da=isset($_POST['da'])?filter_input(INPUT_POST,'da',FILTER_SANITIZE_STRING):filter_input(INPUT_GET,'da',FILTER_SANITIZE_STRING);
$ti=time();
if($act=='additem'){
	if($da!=0){
		$q=$db->prepare("SELECT title,cost FROM `".$prefix."content` WHERE id=:id");
		$q->execute(array(':id'=>$da));
		$r=$q->fetch(PDO::FETCH_ASSOC);
		if($r['cost']==''||!is_numeric($r['cost']))$r['cost']=0;
	}else{
    $r=array(
      'title'=>'',
      'cost'=>0
    );
  }
	$q=$db->prepare("INSERT INTO `".$prefix."orderitems` (oid,iid,title,quantity,cost,ti) VALUES (:oid,:iid,:title,'1',:cost,:ti)");
	$q->execute(
    array(
      ':oid'=>$id,
      ':iid'=>$da,
      ':title'=>$r['title'],
      ':cost'=>$r['cost'],
      ':ti'=>time()
    )
  );
}
if($act=='title'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE id=:id");
  $ss->execute(array(':id'=>$id));
  $r=$ss->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("UPDATE `".$prefix."orderitems` SET title=:title WHERE id=:id");
  $s->execute(
    array(
      ':id'=>$id,
      ':title'=>$da
    )
  );
  $id=$r['oid'];
}
if($act=='quantity'||$act=='trash'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE id=:id");
  $ss->execute(array(':id'=>$id));
  $r=$ss->fetch(PDO::FETCH_ASSOC);
  if($da==0){
    $s=$db->prepare("DELETE FROM `".$prefix."orderitems` WHERE id=:id");
    $s->execute(array(':id'=>$id));
  }else{
    $s=$db->prepare("UPDATE `".$prefix."orderitems` SET quantity=:quantity WHERE id=:id");
    $s->execute(
      array(
        ':quantity'=>$da,
        ':id'=>$id
      )
    );
  }
  $id=$r['oid'];
}
if($act=='cost'){
  $ss=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE id=:id");
  $ss->execute(array(':id'=>$id));
  $r=$ss->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("UPDATE `".$prefix."orderitems` SET cost=:cost WHERE id=:id");
  $s->execute(
    array(
      ':cost'=>$da,
      ':id'=>$id
    )
  );
  $id=$r['oid'];
}
if($act=='reward'){
  $sr=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE code=:code");
  $sr->execute(array(':code'=>$da));
  $reward=$sr->fetch(PDO::FETCH_ASSOC);
  $s=$db->prepare("UPDATE `".$prefix."orders` SET rid=:rid WHERE id=:id");
  $s->execute(
    array(
      ':rid'=>$reward['id'],
      ':id'=>$id
    )
  );
}
if($act=='postage'){
  $s=$db->prepare("UPDATE `".$prefix."orders` SET postage=:postage WHERE id=:id");
  $s->execute(
    array(
      ':postage'=>$da,
      ':id'=>$id
    )
  );
}
$s=$db->prepare("SELECT * FROM `".$prefix."orders` WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
$si=$db->prepare("SELECT * FROM `".$prefix."orderitems` WHERE oid=:oid ORDER BY ti ASC,title ASC");
$si->execute(array(':oid'=>$r['id']));
$total=0;
$html='';
while($oi=$si->fetch(PDO::FETCH_ASSOC)){
  $is=$db->prepare("SELECT id,code,title FROM `".$prefix."content` WHERE id=:id");
  $is->execute(array(':id'=>$oi['iid']));
  $i=$is->fetch(PDO::FETCH_ASSOC);
  $sc=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE id=:id");
  $sc->execute(array(':id'=>$oi['cid']));
  $c=$sc->fetch(PDO::FETCH_ASSOC);
  $html.='<tr>'.
    			'<td class="text-left">'.$i['code'].'</td>'.
    			'<td class="text-left">'.
						($oi['iid']!=0?$i['title']:'<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();"><input type="hidden" name="act" value="title"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="title"><input type="text" class="form-control" name="da" value="'.$oi['title'].'"></form>').
					'</td>'.
    			'<td class="text-left hidden-xs">'.$c['title'].'</td>'.
					'<td class="col-sm-1 text-center">'.
						($oi['iid']!=0?'<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();"><input type="hidden" name="act" value="quantity"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="quantity"><input class="form-control text-center" name="da" value="'.$oi['quantity'].'"'.($r['status']=='archived'?' readonly':'').'></form>':($oi['iid']!=0?$oi['quantity']:'')).
    			'</td>'.
					'<td class="col-sm-1 text-right">'.
  					($oi['iid'] != 0?'<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();"><input type="hidden" name="act" value="cost"><input type="hidden" name="id" value="'.$oi['id'].'"><input type="hidden" name="t" value="orderitems"><input type="hidden" name="c" value="cost"><input class="form-control text-center" name="da" value="'.$oi['cost'].'"'.($r['status']=='archived'?' readonly':'').'></form>':($oi['iid'] != 0?$oi['cost']:'')).
    			'</td>'.
    			'<td class="col-sm-1 text-right">'.
  					($oi['iid']!=0?$oi['cost']*$oi['quantity']:'').
    			'</td>'.
					'<td class="text-right">'.
						'<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();">'.
							'<input type="hidden" name="act" value="trash">'.
							'<input type="hidden" name="id" value="'.$oi['id'].'">'.
							'<input type="hidden" name="t" value="orderitems">'.
							'<input type="hidden" name="c" value="quantity">'.
							'<input type="hidden" name="da" value="0">'.
							'<button class="btn btn-default trash">'.svg2('libre-gui-trash').'</button>'.
						'</form>'.
					'</td>'.
				'</tr>';
  if($oi['iid']!=0)$total=$total+($oi['cost']*$oi['quantity']);
}
$rs=$db->prepare("SELECT * FROM `".$prefix."rewards` WHERE id=:rid");
$rs->execute(array(':rid'=>$r['rid']));
$reward=$rs->fetch(PDO::FETCH_ASSOC);
  $html.='<tr>'.
					'<td colspan="3" class="text-right"><strong>Rewards Code</strong></td>'.
					'<td class="text-center">'.
						'<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();">'.
							'<input type="hidden" name="act" value="reward">'.
							'<input type="hidden" name="id" value="'.$r['id'].'">'.
							'<input type="hidden" name="t" value="orders">'.
							'<input type="hidden" name="c" value="rid">'.
							'<input type="text" class="form-control" name="da" value="'.($rs->rowCount()==1?$reward['code']:'').'">'.
						'</form>'.
					'</td>'.
					'<td class="text-center">';
			if($rs->rowCount()==1){
			  if($reward['method']==1){
			    $html.='$';
			    $total=$total-$reward['value'];
			  }
			  $html.=$reward['value'];
			  if($reward['method']==0){
			    $html.='%';
			    $total=($total*((100-$reward['value'])/100));
			  }
			  $html.=' Off';
			}
    	$html.= '</td>'.
							'<td class="text-right"><strong>'.$total.'</strong></td>'.
							'<td></td>'.
						'</tr>'.
						'<tr>'.
							'<td colspan="5" class="text-right"><strong>Postage</strong></td>'.
							'<td class="postage">'.
								'<form target="sp" method="POST" action="core/updateorder.php" onsubmit="blocker();">'.
									'<input type="hidden" name="act" value="postage">'.
									'<input type="hidden" name="id" value="'.$r['id'].'">'.
									'<input type="hidden" name="t" value="orders">'.
									'<input type="hidden" name="c" value="postage">'.
									'<input type="text" class="form-control text-right" name="da" value="'.$r['postage'].'">'.
								'</form>'.
							'</td>'.
							'<td></td>'.
						'</tr>'.
						'<tr>'.
							'<td colspan="5" class="text-right"><strong>Total</strong></td>'.
							'<td class="total text-right"><strong>'.$total+$r['postage'].'</strong></td>'.
							'<td></td>'.
						'</tr>';?>
  window.top.window.$('#updateorder').html('<?php echo$html;?>');
  window.top.window.Pace.stop();
<?php
echo'/*]]>*/</script>';
