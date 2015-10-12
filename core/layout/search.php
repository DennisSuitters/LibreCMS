<?php
$search=isset($_POST['search'])?trim(filter_input(INPUT_POST,'search',FILTER_SANITIZE_STRING)):'';
$what=isset($_POST['what'])?filter_input(INPUT_POST,'what',FILTER_SANITIZE_STRING):'content';
$status=isset($_POST['status'])?filter_input(INPUT_POST,'status',FILTER_SANITIZE_STRING):'published';
$ord=isset($_POST['ord'])?filter_input(INPUT_POST,'ord',FILTER_SANITIZE_STRING):'desc';?>
<br><br><br>
<div class="container">
	<form class="form-inline" method="post" action="admin/search">
		<div class="form-group">
			<div class="input-group">
				<div class="input-group-addon">Search</div>
				<div class="input-group-btn">
					<select class="form-control" name="what">
						<option value="content"<?php if($what=='content')echo' selected';?>>Content</option>
						<option value="comments"<?php if($what=='comments')echo' selected';?>>Comments</option>
						<option value="login"<?php if($what=='login')echo' selected';?>>Accounts</option>
						<option value="messages"<?php if($what=='messages')echo' selected';?>>Messages</option>
						<option value="orders"<?php if($what=='orders')echo' selected';?>>Orders</option>
						<option value="menu"<?php if($what=='menu')echo' selected';?>>Pages</option>
					</select>
				</div>
				<div class="input-group-addon">for</div>
				<input type="text" class="form-control" name="search" value="<?php echo trim($search);?>" placeholder="<?php lang('placeholder','search');?>">
				<div class="input-group-btn">
					<select class="form-control" name="status">
						<option value="all"<?php if($status=='all')echo' selected';?>>where Status doesn't matter</option>
						<option value="published"<?php if($status=='published')echo' selected';?>>where Status is Published</option>
						<option value="unpublished"<?php if($status=='unpublished')echo' selected';?>>where Status is Unpublished</option>
					</select>
				</div>
				<div class="input-group-addon">and</div>
				<div class="input-group-btn">
					<select class="form-control" name="ord">
						<option value="desc"<?php if($ord=='desc')echo' selected';?>>Order by Descending</option>
						<option value="asc"<?php if($ord=='asc')echo' selected';?>>Order by Ascending</option>
					</select>
				</div>
				<div class="input-group-btn">
					<button class="btn btn-success"><i class="libre libre-search visible-xs"></i><span class="hidden-xs"><?php lang('button','search');?></span></button>
				</div>
			</div>
		</div>
	</form>
</div>
<br>
<?php
	if($search!=''){
		$qry="SELECT * FROM ";
		if($what=='content'){
			$qry.="content WHERE
				LOWER(keywords) LIKE LOWER(:search) OR
				LOWER(barcode) LIKE LOWER(:search) OR
				LOWER(fccid) LIKE LOWER(:search) OR
				LOWER(code) LIKE LOWER(:search) OR
				LOWER(brand) LIKE LOWER(:search) OR
				LOWER(title) LIKE LOWER(:search) OR
				LOWER(category_1) LIKE LOWER(:search) OR
				LOWER(category_2) LIKE LOWER(:search) OR
				LOWER(name) LIKE LOWER(:search)	OR
				LOWER(url) LIKE LOWER(:search) OR
				LOWER(email) LIKE LOWER(:search) OR
				LOWER(business) LIKE LOWER(:search) OR
				LOWER(address) LIKE LOWER(:search) OR
				LOWER(suburb) LIKE LOWER(:search) OR
				LOWER(city) LIKE LOWER(:search)	OR
				LOWER(state) LIKE LOWER(:search) OR
				LOWER(postcode) LIKE LOWER(:search)	OR
				LOWER(phone) LIKE LOWER(:search) OR
				LOWER(mobile) LIKE LOWER(:search) OR
				LOWER(attributionImageTitle) LIKE LOWER(:search) OR
				LOWER(attributionImageName) LIKE LOWER(:search)	OR
				LOWER(cost) LIKE LOWER(:search) OR
				LOWER(subject) LIKE LOWER(:search) OR
				LOWER(notes) LIKE LOWER(:search)
				";
		}
/*		if($what=='comments')$qry.='comments ';
		if($what=='login')$qry.='login ';
		if($what=='message')$qry.='messages ';
		if($what=='orders')$qry.='orders '; */
		if($status=='all')$qry.="";
		if($status=='published')$qry.="AND status='published' ";
		if($status=='unpublished')$qry.="AND status='unpublished' ";
		if($ord=='asc')$qry.="ORDER BY ti ASC";
		if($ord=='desc')$qry.="ORDER BY ti DESC";
	$s=$db->prepare($qry);
	$s->execute(array(':search'=>'%'.$search.'%'));
	while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
<div class="searchresults">
	<a class="link" href="<?php echo URL.'admin/';?>"><?php echo$r['title'];?></a><br>
	<small class="text-success"><?php echo URL.'admin/';?></small><br>
	<small><?php echo strip_tags(substr($r['notes'],0,800),'<a>');?></small><br>
	<br>
</div>
<?php	}
}
