<?php
if(isset($_POST['search']))$search=filter_input(INPUT_POST,'search',FILTER_SANITIZE_STRING);
else$search='';?>
<div class="toolbar">
	<h1>&nbsp;</h1>
	<form class="form-group" method="post" action="admin/search">
		<div class="input-group col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
			<input type="text" class="form-control" name="search" value="<?php echo trim($search);?>" placeholder="<?php lang('placeholder','search');?>">
			<div class="input-group-btn">
				<button class="btn btn-success"><i class="libre libre-search visible-xs"></i><span class="hidden-xs"><?php lang('button','search');?></span></button>
			</div>
		</div>
	</form>
</div>
<?php
	if($search!=''){
	$s=$db->prepare("SELECT * FROM content WHERE
		 LOWER(keywords) LIKE LOWER(:search)				OR LOWER(barcode) LIKE LOWER(:search) OR
		 LOWER(fccid) LIKE LOWER(:search)					OR LOWER(code) LIKE LOWER(:search) OR
		 LOWER(brand) LIKE LOWER(:search)					OR LOWER(title) LIKE LOWER(:search) OR
		 LOWER(category_1) LIKE LOWER(:search)				OR LOWER(category_2) LIKE LOWER(:search) OR
		 LOWER(name) LIKE LOWER(:search)					OR LOWER(url) LIKE LOWER(:search) OR
		 LOWER(email) LIKE LOWER(:search)					OR LOWER(business) LIKE LOWER(:search) OR
		 LOWER(address) LIKE LOWER(:search)					OR LOWER(suburb) LIKE LOWER(:search) OR
		 LOWER(city) LIKE LOWER(:search)					OR LOWER(state) LIKE LOWER(:search) OR
		 LOWER(postcode) LIKE LOWER(:search)				OR LOWER(phone) LIKE LOWER(:search) OR
		 LOWER(mobile) LIKE LOWER(:search)					OR LOWER(attributionImageTitle) LIKE LOWER(:search) OR
		 LOWER(attributionImageName) LIKE LOWER(:search)	OR LOWER(cost) LIKE LOWER(:search) OR
		 LOWER(subject) LIKE LOWER(:search)					OR LOWER(notes) LIKE LOWER(:search)
		 ORDER BY ti DESC");
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
