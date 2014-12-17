<main id="content" class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-body">
<?php if($user['rank']>699){
	if(isset($args[0])){
		$q=$db->prepare("UPDATE content SET status='read' WHERE id=:id");
		$q->execute(array(':id'=>$args[0]));
		$q=$db->prepare("SELECT * FROM content WHERE id=:id");
		$q->execute(array(':id'=>$args[0]));
		$r=$q->fetch(PDO::FETCH_ASSOC);?>
			<div class="form-group">
				<label for="ti" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Created</label>
				<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
					<input type="text" id="ti" class="form-control" value="<?php echo date($config['dateFormat'],$r['ti']);?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label for="subject" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Subject</label>
				<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
					<input type="text" id="subject" class="form-control" value="<?php echo$r['subject'];?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">From</label>
				<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
					<input type="text" id="email" class="form-control" value="<?php echo$r['name'].' <'.$r['email'];?>>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label for="phone" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Phone</label>
				<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
					<input type="text" id="phone" class="form-control" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone" placeholder="Not Supplied" readonly>
				</div>
			</div>
			<div class="form-grop">
				<label for="ip" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">IP</label>
				<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
					<input type="text" id="ip" class="form-control" value="<?php echo$r['ip'];?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label for="order_notes" class="control-label col-lg-1 col-md-2 col-sm-2 col-xs-4">Message</label>
				<div class="input-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
					<div class="well text-left" readonly>
						<?php echo$r['notes'];?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group pull-right">
					<a class="btn btn-primary btn-xs" href="mailto:'.$r['email'].'">Reply</a> 
					<button class="btn btn-primary btn-xs" onclick="makeClient('<?php echo$r['id'];?>')">Add Client</button>
				</div>
			</div>
		</div>
<?php }else{?>
			<div class="table-responsive">
				<table class="table table-condensed">
					<thead>
						<tr>
							<th>Date</th>
							<th>From</th>
							<th>Subject</th>
							<th class="col-sm-2">Status</th>
							<th class="col-sm-3"></th>
						</tr>
					</thead>
					<tbody id="sort">
<?php	$s=$db->query("SELECT * FROM content WHERE contentType='message_primary' ORDER BY ti DESC");
		while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
						<tr id="l_<?php echo$r['id'];?>" class="<?php if($r['status']=='delete'){echo'danger';}?>">
							<td><?php echo date($config['dateFormat'],$r['ti']);?></td>
							<td><?php echo$r['name'].' &lt;<a href="mailto:'.$r['email'].'">'.$r['email'].'</a>&gt;';?></td>
							<td><?php echo$r['subject'];?></td>
							<td><?php echo$r['status'];?></td>
							<td id="controls_<?php echo$r['id'];?>" class="text-right">
								<a class="btn btn-primary btn-xs<?php if($r['status']=='delete'){echo' hidden';}?>" href="admin/messages/<?php echo$r['id'];?>">View</a> 
								<button class="btn btn-primary btn-xs<?php if($r['status']!='delete'){echo' hidden';}?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','')">Restore</button> 
								<button class="btn btn-danger btn-xs<?php if($r['status']=='delete'){echo' hidden';}?>" onclick="updateButtons('<?php echo$r['id'];?>','content','status','delete')">Delete</button> 
<?php		if($user['rank']>699){?>
								<button class="btn btn-warning btn-xs<?php if($r['status']!='delete'){echo' hidden';}?>" onclick="purge('<?php echo$r['id'];?>','content')">Purge</button>
<?php		}?>
							</td>
						</tr>
<?php	}?>
					</tbody>
				</table>
			</div>
		</div>
<?php }
}else{
	include'includes/noaccess.php';
}?>
	</div>
</main>
