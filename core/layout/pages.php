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
	$s->execute();?>
<h1 class="page-header">Pages</h1>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive">
			<table id="stupidtable" class="table table-condensed table-hover">
				<thead>
					<tr>
						<th class="col-xs-1 text-center hidden-xs" data-sort="string">Menu</th>
						<th class="text-center" data-sort="string">Title</th>
						<th class="col-xs-3 text-center hidden-xs" data-sort="string">Edited</th>
						<th class="col-xs-1 text-center">Active</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="sort">
<?php	while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
					<tr id="l_<?php echo$r['id'];?>">
						<td class="text-center hidden-xs"><small><?php echo ucfirst($r['menu']);?></small></td>
						<td><small><?php echo$r['title'];?></small></td>
						<td class="text-center hidden-xs"><small><?php if($r['eti']==0)echo'Never';else echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></small></td>
						<td class="text-center">
							<input type="checkbox" id="active<?php echo$r['id'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php if($r['active']==1)echo' checked';?>>
							<label for="active<?php echo$r['id'];?>">
						</td>
						<td id="controls_<?php echo$r['id'];?>">
							<div class="btn-group pull-right">
								<a class="btn btn-info btn-sm" href="admin/pages/edit/<?php echo$r['id'];?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Edit"';?>><i class="libre libre-edit visible-xs"></i><span class="hidden-xs">Edit</span></a>
							</div>
						</td>
					</tr>
<?php	}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php }
if($show=='item'){
	$r=$s->fetch(PDO::FETCH_ASSOC);?>
<h1 class="page-header">
	Pages
	<div class="btn-group pull-right">
		<a class="btn btn-success" href="<?php echo URL.'/admin/pages';?>"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" data-placement="left" title="Back"';?>><i class="libre libre-back visible-xs"></i><span class="hidden-xs">Back</span></a>
	</div>
</h1>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-group">
			<label for="title" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Title</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><a class="btn btn-info" data-toggle="modal" data-target="#seo" href="core/seo.php?id=1"><i class="libre libre-seo"></i></a></div>';?>
				<input type="text" id="title" class="form-control textinput" value="<?php echo$r['title'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="title" placeholder="Enter a Page Title...">
			</div>
		</div>
		<div class="form-group">
			<label for="active" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Active</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="checkbox" id="active" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="active" data-dbb="0"<?php if($r['active']==1)echo' checked';?>><label for="active">
			</div>
		</div>
		<div class="form-group">
			<label for="menu" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Menu</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<select id="menu" class="form-control" onchange="update('<?php echo$r['id'];?>','menu','menu',$(this).val());">
					<option value="head"<?php if($r['menu']=='head')echo' selected';?>>Head</option>
					<option value="footer"<?php if($r['menu']=='footer')echo' selected';?>>Footer</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">seoTitle</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><a class="btn btn-info" data-toggle="modal" data-target="#seo" href="core/seo.php?id=11"><i class="libre libre-seo"></i></a></div>';?>
				<input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$r['seoTitle'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoTitle" placeholder="Enter a Page seoTitle...">
			</div>
		</div>
		<div class="form-group">
			<label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">seoCaption</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><a class="btn btn-info" data-toggle="modal" data-target="#seo" href="core/seo.php?id=12"><i class="libre libre-seo"></i></a></div>';?>
				<input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$r['seoCaption'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoCaption" placeholder="Enter a Page Caption...">
			</div>
		</div>
		<div class="form-group">
			<label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">seoDescription</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><a class="btn btn-info" data-toggle="modal" data-target="#seo" href="core/seo.php?id=13"><i class="libre libre-seo"></i></a></div>';?>
				<input type="text" id="seoDescription<?php echo$r['id'];?>" class="form-control textinput" value="<?php echo$r['seoDescription'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoDescription" placeholder="Enter a Page Description...">
			</div>
		</div>
		<div class="form-group">
			<label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">seoKeywords</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><a class="btn btn-info" data-toggle="modal" data-target="#seo" href="core/seo.php?id=14"><i class="libre libre-seo"></i></a></div>';?>
				<input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$r['seoKeywords'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="menu" data-dbc="seoKeywords" placeholder="Enter Page Keywords...">
			</div>
		</div>
		<div class="form-group">
			<div class="input-group col-xs-12">
<?php if($user['options']{1}==1){
	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs" style="vertical-align:top;"><a class="btn btn-info" data-toggle="modal" data-target="#seo" href="core/seo.php?id=10"><i class="libre libre-seo"></i></a></div>';?>
				<form method="post" target="sp" action="core/update.php">
					<input type="hidden" name="id" value="<?php echo$r['id'];?>">
					<input type="hidden" name="t" value="menu">
					<input type="hidden" name="c" value="notes">
					<textarea id="notes" class="form-control summernote" name="da" readonly><?php echo$r['notes'];?></textarea>
				</form>
<?php }else{?>
				<div class="panel panel-default">
					<div class="panel-body"><?php echo$r['notes'];?></div>
				</div>
<?php }?>
			</div>
			<small class="help-block text-right">Edited: <?php if($r['eti']==0)echo'Never';else echo date($config['dateFormat'],$r['eti']).' by '.$r['login_user'];?></small>
		</div>
	</div>
</div>
<?php }
