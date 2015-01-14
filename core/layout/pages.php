<?php
$rank=0;
$show='pages';
if($args[0]=='edit'){
	$s=$db->prepare("SELECT * FROM menu WHERE id=:id");
	$s->execute(array(':id'=>$args[1]));
	$show='item';
}
if($show=='pages'){
	$s=$db->prepare("SELECT * FROM menu ORDER BY menu DESC, ord ASC");
	$s->execute();
?>
<div class="table-responsive">
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th class="col-lg-1 col-md-1 col-sm-1 text-center">Menu</th>
				<th class="text-center">Title</th>
				<th class="col-lg-1 col-md-1 col-sm-1 text-center">Active</th>
				<th class="col-lg-3 col-md-3 col-sm-3 text-right"></th>
			</tr>
		</thead>
		<tbody id="sort">
<?php	while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
			<tr id="l_<?php echo$r['id'];?>">
				<td class="text-center"><small><?php echo ucfirst($r['menu']);?></small></td>
				<td><small><?php echo$r['title'];?></small></td>
				<td class="text-center"><i class="fa fa-<?php if($r['active']==1){echo'check text-success';}else{echo'close text-muted';}?>"></i></td>
				<td id="controls_<?php echo$r['id'];?>" class="text-right">
					<a class="btn btn-primary btn-xs" href="admin/pages/edit/<?php echo$r['id'];?>">View</a> 
				</td>
			</tr>
<?php	}?>
		</tbody>
	</table>
</div>
<?php }
if($show=='item'){
	$r=$s->fetch(PDO::FETCH_ASSOC);?>
<div class="form-group clearfix">
	<div class="input-group pull-right">
		<a class="btn btn-success" href="<?php echo URL.'/admin/pages';?>">Back</a>
	</div>
</div>
<div class="form-group">
	<label for="title" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-4">Title</label>
	<div class="input-group col-lg-10 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" placeholder="Enter a Page Title...">
	</div>
</div>
<div class="form-group">
	<label for="active" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-4">Active</label>
	<div class="input-group col-lg-10 col-md-10 col-sm-10 col-xs-8">
		<input type="checkbox" id="active" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php if($r['active']==1){echo' checked';}?>>
	</div>
</div>
<div class="form-group">
	<label for="menu" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-4">Menu</label>
	<div class="input-group col-lg-10 col-md-10 col-sm-10 col-xs-8">
		<select id="menu" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','menu',$(this).val());">
			<option value="head"<?php if($r['menu']=='head'){echo' selected';}?>>Header</option>
			<option value="footer"<?php if($r['menu']=='footer'){echo' selected';}?>>Footer</option>
		</select>
	</div>
</div>
<div class="form-group">
	<label for="seoTitle" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-4">seoTitle</label>
	<div class="input-group col-lg-10 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" placeholder="Enter a Page seoTitle...">
	</div>
</div>
<div class="form-group">
	<label for="seoCaption" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-4">seoCaption</label>
	<div class="input-group col-lg-10 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" placeholder="Enter a Page Caption...">
	</div>
</div>
<div class="form-group">
	<label for="seoDescription" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-4">seoDescription</label>
	<div class="input-group col-lg-10 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="seoDescription<?php echo$r['id'];?>" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" placeholder="Enter a Page Description...">
	</div>
</div>
<div class="form-group">
	<label for="seoKeywords" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-4">seoKeywords</label>
	<div class="input-group col-lg-10 col-md-10 col-sm-10 col-xs-8">
		<input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" placeholder="Enter Page Keywords...">
	</div>
</div>
<div class="form-group">
	<label for="notes" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-5">Notes</label>
	<div class="input-group col-lg-10 col-md-9 col-sm-9 col-xs-7">
<?php if($user['options']{1}==1){?>
		<form method="post" target="sp" action="core/update.php">
			<input type="hidden" name="id" value="<?php echo$r['id'];?>">
			<input type="hidden" name="t" value="content">
			<input type="hidden" name="c" value="notes">
			<textarea id="notes" class="form-control summernote" name="da" readonly><?php echo$r['notes'];?></textarea>
		</form>
<?php }else{?>
		<div class="panel panel-default">
			<div class="panel-body">
<?php	echo$r['notes'];?>
			</div>
		</div>
<?php }?>
	</div>
</div>
<?php }?>
