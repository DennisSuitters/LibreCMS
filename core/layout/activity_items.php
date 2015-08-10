<?php
if(isset($_GET['is'])){
	require'../db.php';
	$config=$db->query("SELECT * FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
	$is=$_GET['is'];
	$ie=$_GET['ie'];
	$action=$_GET['action'];
	function _ago($time){
		$toTime=time();
		$fromTime=$time;
		$timeDiff=floor(abs($toTime-$fromTime)/60);
		if($timeDiff<2)$timeDiff="Just now";
		elseif($timeDiff>2&&$timeDiff<60)$timeDiff=floor(abs($timeDiff))." minutes ago";
		elseif($timeDiff>60&&$timeDiff<120)$timeDiff=floor(abs($timeDiff/60))." hour ago";
		elseif($timeDiff<1440)$timeDiff=floor(abs($timeDiff/60))." hours ago";
		elseif($timeDiff>1440&& $timeDiff<2880)$timeDiff=floor(abs($timeDiff/1440))." day ago";
		elseif($timeDiff>2880)$timeDiff=floor(abs($timeDiff/1440))." days ago";
		return$timeDiff;
	}
}
if($action!=''){
	$s=$db->prepare("SELECT * FROM logs WHERE action=:action ORDER BY ti DESC LIMIT ".$is.",".$ie);
	$s->execute(array(
		':action'=>$action
	));
}else{
	$s=$db->prepare("SELECT * FROM logs ORDER BY ti DESC LIMIT ".$is.",".$ie);
	$s->execute();
}
$cnt=$s->rowCount();
while($r=$s->fetch(PDO::FETCH_ASSOC)){
	if($r['refTable']=='content'){
		$sql=$db->prepare("SELECT * FROM ".$r['refTable']." WHERE id=:id");
		$sql->execute(array(':id'=>$r['id']));
		$c=$sql->fetch(PDO::FETCH_ASSOC);
	}
	$sql=$db->prepare("SELECT id,username,name,rank FROM login WHERE id=:id");
	$sql->execute(array(':id'=>$r['uid']));
	$u=$sql->fetch(PDO::FETCH_ASSOC);?>
<div id="l_<?php echo$r['id'];?>" class="row">
	<div class="col-xs-2">
		<div class="badger badger-left text-shadow-depth-1" data-status="<?php echo$r['action'];?>" data-contenttype="<?php echo$r['action'];?>"></div>
		<br>
		<div class="text-muted text-center">
<?php echo date($config['dateFormat'],$r['ti']);?><br>
			<small><?php echo _ago($r['ti']);?></small>
		</div>
	</div>
	<div class="col-xs-6">
		<p>
			<strong>Action:</strong> <?php
			if($r['action']=='create'){
				echo ucfirst($r['contentType']).' created';
			}
			if($r['action']=='update'){
				echo ucfirst($r['contentType']).' updated';
			}
			if($r['action']=='purge'){
				echo ucfirst($r['contentType']).' Purged';
			}?><br>
<?php if(isset($c['title'])&&$c['title']!='')echo'<strong>Title:</strong> '.$c['title'].'<br>';
	if($r['action']=='update'){?>
			<strong>Table:</strong> <?php echo$r['refTable'];?><br>
			<strong>Column:</strong> <?php echo$r['refColumn'];?><br>
			<strong>Data:</strong> <?php echo strip_tags(substr($r['oldda'],0,300));?><br>
			<strong>Changed To:</strong> <?php echo strip_tags(substr($r['newda'],0,300));?><br>
<?php }?>
			<strong>by</strong> <?php echo $u['username'].':'.$u['name'];?>
		</p>
	</div>
</div>
<hr>
<?php }
if($cnt==$ie){?>
<div id="more_<?php echo$is+$ie+1;?>">
	<button class="btn btn-default btn-block" onclick="loadMore('activity_items','<?php echo$is+$ie+1;?>','<?php echo$ie;?>','<?php echo$action;?>');">More</button>
</div>
<?php }