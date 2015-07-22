<div class="row col-xs-12 text-right">
	<div class="btn-group">
		<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
<?php if(!isset($args[1])||$args[1]==''){
		if($config['buttonType']=='text')echo'Show';
		else echo'<i class="libre libre-view"></i> ';
	}else{
		if($config['buttonType']=='text')echo'Show';
		else echo'<i class="libre libre-view"></i> ';
	}
	if($args[1])echo ucfirst($args[1]);?> <i class="caret"></i></button>
		<ul class="dropdown-menu pull-right">
			<li><a href="<?php echo URL.'admin/timeline';?>">All</a></li>
<?php	$st=$db->query("SELECT DISTINCT action FROM logs ORDER BY action ASC");
		while($sr=$st->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.'admin/timeline/action/'.$sr['action'].'">'.ucfirst($sr['action']).'</a></li>';?>
		</ul>
	</div>
</div>
<?php
$is=0;
$ie=$config['showItems'];
$action=$args[1];
include('core/layout/timeline_items.php');

