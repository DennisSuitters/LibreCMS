<h1 class="page-header">
	Activity
		<div class="btn-group pull-right">
			<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
<?php if(!isset($args[1])||$args[1]==''){
		if($config['buttonType']=='text')echo'Show';
		else echo'<i class="libre libre-view"></i> ';
	}else{
		if($config['buttonType']=='text')echo'Show';
		else echo'<i class="libre libre-view"></i> ';
	}
	if(isset($args[1]))echo ucfirst($args[1]);?> <i class="caret"></i></button>
			<ul class="dropdown-menu pull-right">
				<li><a href="<?php echo URL.'admin/activity';?>">All</a></li>
<?php	$st=$db->query("SELECT DISTINCT action FROM logs ORDER BY action ASC");
		while($sr=$st->fetch(PDO::FETCH_ASSOC))echo'<li><a href="'.URL.'admin/activity/action/'.$sr['action'].'">'.ucfirst($sr['action']).'</a></li>';?>
			</ul>
		</div>
</h1>
<div class="clearfix"></div>
<div class="panel panel-default">
	<div class="panel-body">
<?php
$is=0;
$ie=$config['showItems'];
if(isset($args[1]))$action=$args[1];else $action='';
include('core/layout/activity_items.php');?>
	</div>
</div>
