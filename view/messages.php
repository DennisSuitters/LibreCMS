<?php
$content.='<main id="content" class="col-md-12">';
	$content.='<div class="panel panel-default">';
		$content.='<div class="panel-body">';
if($user['rank']>699){
	if(isset($args[0])){
		$q=$db->prepare("UPDATE content SET status='read' WHERE id=:id");
		$q->execute(array(':id'=>$args[0]));
		$q=$db->prepare("SELECT * FROM content WHERE id=:id");
		$q->execute(array(':id'=>$args[0]));
		$r=$q->fetch(PDO::FETCH_ASSOC);
			$content.='<div class="form-group">';
				$content.='<label for="ti" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Created</label>';
				$content.='<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">';
					$content.='<input type="text" id="ti" class="form-control" value="'.date($config['dateFormat'],$r['ti']).'" readonly>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="form-group">';
				$content.='<label for="subject" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Subject</label>';
				$content.='<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">';
					$content.='<input type="text" id="subject" class="form-control" value="'.$r['subject'].'" readonly>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="form-group">';
				$content.='<label for="email" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">From</label>';
				$content.='<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">';
					$content.='<input type="text" id="email" class="form-control" value="'.$r['name'].' <'.$r['email'].'>" readonly>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="form-group">';
				$content.='<label for="phone" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Phone</label>';
				$content.='<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">';
					$content.='<input type="text" id="phone" class="form-control" value="'.$r['phone'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="phone" placeholder="Not Supplied" readonly>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="form-grop">';
				$content.='<label for="ip" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">IP</label>';
				$content.='<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">';
					$content.='<input type="text" id="ip" class="form-control" value="'.$r['ip'].'" readonly>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="form-group">';
				$content.='<label for="order_notes" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Message</label>';
				$content.='<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">';
					$content.='<div class="well text-left" readonly>';
						$content.=$r['notes'];
					$content.='</div>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="form-group">';
				$content.='<div class="input-group pull-right">';
					$content.='<a class="btn btn-primary btn-xs" href="mailto:'.$r['email'].'">Reply</a>&nbsp;';
					$content.='<button class="btn btn-primary btn-xs" onclick="makeClient(\''.$r['id'].'\')">Add Client</button>';
				$content.='</div>';
			$content.='</div>';
		$content.='</div>';
	}else{
			$content.='<div class="table-responsive">';
				$content.='<table class="table table-condensed sort_table">';
					$content.='<thead>';
						$content.='<tr>';
							$content.='<th>Date</th>';
							$content.='<th>From</th>';
							$content.='<th>Subject</th>';
							$content.='<th class="col-sm-2">Status</th>';
							$content.='<th class="col-sm-3">';
								$content.='<div class="input-group" data-tooltip data-original-title="Enter text to filter out unwanted Messages below">';
									$content.='<input type="text" class="form-control filter" placeholder="Filter">';
									$content.='<div class="input-group-addon">Filter</div>';
								$content.='</div>';
							$content.='</th>';
							$content.='<th class="hidden"></th>';
						$content.='</tr>';
					$content.='</thead>';
					$content.='<tbody id="sort">';
		$s=$db->query("SELECT * FROM content WHERE contentType='message_primary' ORDER BY ti DESC");
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
						$content.='<tr id="l_'.$r['id'].'" data-id="'.$r['id'].'" class="handle placeholder';if($r['status']=='delete'){$content.=' danger';}$content.='">';
							$content.='<td>'.date($config['dateFormat'],$r['ti']).'</td>';
							$content.='<td>'.$r['name'].' &lt;<a href="mailto:'.$r['email'].'">'.$r['email'].'</a>&gt;</td>';
							$content.='<td>'.$r['subject'].'</td>';
							$content.='<td>'.$r['status'].'</td>';
							$content.='<td id="controls_'.$r['id'].'" class="text-right">';
								$content.='<a class="btn btn-primary btn-xs';if($r['status']=='delete'){$content.=' hidden';}$content.='" href="admin/messages/'.$r['id'].'">View</a> ';
								$content.='<button class="btn btn-primary btn-xs';if($r['status']!='delete'){$content.=' hidden';}$content.='" onclick="updateButtons(\''.$r['id'].'\',\'content\',\'status\',\'\')">Restore</button> ';
								$content.='<button class="btn btn-danger btn-xs';if($r['status']=='delete'){$content.=' hidden';}$content.='" onclick="updateButtons(\''.$r['id'].'\',\'content\',\'status\',\'delete\')">Delete</button> ';
			if($user['rank']>699){
								$content.='<button class="btn btn-warning btn-xs';if($r['status']!='delete'){$content.=' hidden';}$content.='" onclick="purge(\''.$r['id'].'\',\'content\')">Purge</button>';
			}
							$content.='</td>';
							$content.='<td class="hidden">'.$r['notes'].'</td>';
						$content.='</tr>';
		}
					$content.='</tbody>';
				$content.='</table>';
			$content.='</div>';
		$content.='</div>';
	}
}else{
	include'includes/noaccess.php';
}
	$content.='</div>';
$content.='</main>';
