<?php
$content.='<main id="content" class="libr8-col-md-12">';
	$content.='<div class="libr8-panel libr8-panel-default">';
		$content.='<div class="libr8-panel-body">';
if($user['rank']>699){
	if(isset($args[0])){
		$q=$db->prepare("UPDATE content SET status='read' WHERE id=:id");
		$q->execute(array(':id'=>$args[0]));
		$q=$db->prepare("SELECT * FROM content WHERE id=:id");
		$q->execute(array(':id'=>$args[0]));
		$r=$q->fetch(PDO::FETCH_ASSOC);
			$content.='<div class="libr8-form-group">';
				$content.='<label for="ti" class="libr8-control-label libr8-col-lg-1 libr8-col-md-2 libr8-col-sm-2 libr8-col-xs-4">Created</label>';
				$content.='<div class="libr8-input-group libr8-col-lg-11 libr8-col-md-10 libr8-col-sm-10 libr8-col-xs-8">';
					$content.='<input type="text" id="ti" class="libr8-form-control" value="'.date($config['dateFormat'],$r['ti']).'" readonly>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="libr8-form-group">';
				$content.='<label for="subject" class="libr8-control-label libr8-col-lg-1 libr8-col-md-2 libr8-col-sm-2 libr8-col-xs-4">Subject</label>';
				$content.='<div class="libr8-input-group libr8-col-lg-11 libr8-col-md-10 libr8-col-sm-10 libr8-col-xs-8">';
					$content.='<input type="text" id="subject" class="libr8-form-control" value="'.$r['subject'].'" readonly>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="libr8-form-group">';
				$content.='<label for="email" class="libr8-control-label libr8-col-lg-1 libr8-col-md-2 libr8-col-sm-2 libr8-col-xs-4">From</label>';
				$content.='<div class="libr8-input-group libr8-col-lg-11 libr8-col-md-10 libr8-col-sm-10 libr8-col-xs-8">';
					$content.='<input type="text" id="email" class="libr8-form-control" value="'.$r['name'].' <'.$r['email'].'>" readonly>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="libr8-form-group">';
				$content.='<label for="phone" class="libr8-control-label libr8-col-lg-1 libr8-col-md-2 libr8-col-sm-2 libr8-col-xs-4">Phone</label>';
				$content.='<div class="libr8-input-group libr8-col-lg-11 libr8-col-md-10 libr8-col-sm-10 libr8-col-xs-8">';
					$content.='<input type="text" id="phone" class="libr8-form-control" value="'.$r['phone'].'" data-dbid="'.$r['id'].'" data-dbt="content" data-dbc="phone" placeholder="Not Supplied" readonly>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="libr8-form-grop">';
				$content.='<label for="ip" class="libr8-control-label libr8-col-lg-1 libr8-col-md-2 libr8-col-sm-2 libr8-col-xs-4">IP</label>';
				$content.='<div class="libr8-input-group libr8-col-lg-11 libr8-col-md-10 libr8-col-sm-10 libr8-col-xs-8">';
					$content.='<input type="text" id="ip" class="libr8-form-control" value="'.$r['ip'].'" readonly>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="libr8-form-group">';
				$content.='<label for="order_notes" class="libr8-control-label libr8-col-lg-1 libr8-col-md-2 libr8-col-sm-2 libr8-col-xs-4">Message</label>';
				$content.='<div class="libr8-input-group libr8-col-lg-11 libr8-col-md-10 libr8-col-sm-10 libr8-col-xs-8">';
					$content.='<div class="libr8-well libr8-text-left" readonly>';
						$content.=$r['notes'];
					$content.='</div>';
				$content.='</div>';
			$content.='</div>';
			$content.='<div class="libr8-form-group">';
				$content.='<div class="libr8-input-group libr8-pull-right">';
					$content.='<a class="libr8-btn libr8-btn-primary libr8-btn-xs" href="mailto:'.$r['email'].'">Reply</a>&nbsp;';
					$content.='<button class="libr8-btn libr8-btn-primary libr8-btn-xs" onclick="makeClient(\''.$r['id'].'\')">Add Client</button>';
				$content.='</div>';
			$content.='</div>';
		$content.='</div>';
	}else{
			$content.='<div class="libr8-table-responsive">';
				$content.='<table class="libr8-table libr8-table-condensed">';
					$content.='<thead>';
						$content.='<tr>';
							$content.='<th>Date</th>';
							$content.='<th>From</th>';
							$content.='<th>Subject</th>';
							$content.='<th class="libr8-col-sm-2">Status</th>';
							$content.='<th class="libr8-col-sm-3"></th>';
							$content.='<th class="libr8-hidden"></th>';
						$content.='</tr>';
					$content.='</thead>';
					$content.='<tbody id="sort">';
		$s=$db->query("SELECT * FROM content WHERE contentType='message_primary' ORDER BY ti DESC");
		while($r=$s->fetch(PDO::FETCH_ASSOC)){
						$content.='<tr id="l_'.$r['id'].'" data-id="'.$r['id'].'" class="libr8-handle libr8-placeholder';if($r['status']=='delete'){$content.=' danger';}$content.='">';
							$content.='<td>'.date($config['dateFormat'],$r['ti']).'</td>';
							$content.='<td>'.$r['name'].' &lt;<a href="mailto:'.$r['email'].'">'.$r['email'].'</a>&gt;</td>';
							$content.='<td>'.$r['subject'].'</td>';
							$content.='<td>'.$r['status'].'</td>';
							$content.='<td id="controls_'.$r['id'].'" class="libr8-text-right">';
								$content.='<a class="libr8-btn libr8-btn-primary libr8-btn-xs';if($r['status']=='delete'){$content.=' hidden';}$content.='" href="admin/messages/'.$r['id'].'">View</a> ';
								$content.='<button class="libr8-btn libr8-btn-primary libr8-btn-xs';if($r['status']!='delete'){$content.=' hidden';}$content.='" onclick="updateButtons(\''.$r['id'].'\',\'content\',\'status\',\'\')">Restore</button> ';
								$content.='<button class="libr8-btn libr8-btn-danger libr8-btn-xs';if($r['status']=='delete'){$content.=' hidden';}$content.='" onclick="updateButtons(\''.$r['id'].'\',\'content\',\'status\',\'delete\')">Delete</button> ';
			if($user['rank']>699){
								$content.='<button class="libr8-btn libr8-btn-warning libr8-btn-xs';if($r['status']!='delete'){$content.=' hidden';}$content.='" onclick="purge(\''.$r['id'].'\',\'content\')">Purge</button>';
			}
							$content.='</td>';
							$content.='<td class="libr8-hidden">'.$r['notes'].'</td>';
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
