
<main id="content" class="col-md-9 no-padding">
	<div class="panel-body">
<?php $s=$db->query("SELECT DISTINCT contentType FROM content WHERE contentType!='' AND internal!='1' AND status='published' ORDER BY contentType ASC");
while($r=$s->fetch(PDO::FETCH_ASSOC)){?>
	<div class="form-group">
		<label class="control-label col-sm-2"><?php echo ucfirst($r['contentType']);?></label>
		<div class="input-group col-sm-10">
<?php $ss=$db->prepare("SELECT DISTINCT id,title FROM content WHERE contentType=:content_type AND title!='' AND status='published' AND internal!='1' ORDER BY contentType ASC, ord ASC, ti DESC");
	$ss->execute(array(':content_type'=>$r['contentType']));
	while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
		echo'<a href="'.$r['contentType'].'/'.str_replace(' ','-',$rs['title']).'">'.$rs['title'].'</a><br>';
	}?>
		</div>
	</div>
<?php }?>
	</div>
</main>
