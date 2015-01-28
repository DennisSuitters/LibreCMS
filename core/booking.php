<?php
include'db.php';
$config=$db->query("SELECT dateFormat FROM config WHERE id='1'")->fetch(PDO::FETCH_ASSOC);
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$s=$db->prepare("SELECT * FROM content WHERE id=:id");
$s->execute(array(':id'=>$id));
$r=$s->fetch(PDO::FETCH_ASSOC);
$sr=$db->prepare("SELECT contentType FROM content where id=:id");
$sr->execute(array(':id'=>$r['rid']));
$rs=$sr->fetch(PDO::FETCH_ASSOC);?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4>&nbsp;</h4>
</div>
<style>
	#booking .form-inline{
		margin-bottom:5px;
	}
	#booking .control-label{
		width:100px;
		text-align:right;
		padding-right:10px;
		vertical-align:top;
	}
	#booking .input-group{
		width:708px;
	}
	#booking input{
		width:100%;
	}
	#booking .input-group.half{
		width:300px;
	}
</style>
<div id="booking" class="modal-body">
	<div class="form-inline">
		<div class="form-group">
			<label for="tis" class="control-label">Booked For</label>
			<div class="input-group half">
<?php if($rs['contentType']=='events'){?>
				<input type="text" id="tis" class="form-control" value="<?php echo date($config['dateFormat'],$r['tis']);?>" readonly>
<?php }else{?>
				<input type="text" id="tis" class="form-control" data-tooltip data-original-title="<?php if($r['tis']==0){echo'Select a Date...';}else{echo date($config['dateFormat'],$r['tis']);}?>" value="<?php if($r['tis']!=0){echo date('Y-m-d h:m',$r['tis']);}?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tis" placeholder="Select a Date...">
<?php }?>
			</div>
		</div>
		<div class="form-group">
			<label for="tie" class="control-label">Booking End</label>
			<div class="input-group half">
<?php if($rs['contentType']=='events'){?>
				<input type="text" id="tie" class="form-control" value="<?php echo date($config['dateFormat'],$r['tie']);?>" readonly>
<?php }else{?>
				<input type="text" id="tie" class="form-control" data-tooltip data-original-title="<?php if($r['tie']==''||$r['tie']==0){echo'Select a Date...';}else{echo date($config['dateFormat'],$r['tie']);}?>" value="<?php if($r['tie']!=0){echo date('Y-m-d h:m',$r['tie']);}?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="tie" placeholder="Select a Date...">
<?php }?>
			</div>
		</div>
	</div>
	<div class="form-inline">
		<label for="status" class="control-label">Status</label>
		<div class="input-group col=md-8">
			<input type="text" id="status" class="form-control" value="<?php echo ucfirst($r['status']);?>" readonly>
		</div>
	</div>
	<div class="form-inline">
		<div class="form-group">
			<label for="email" class="control-label">Email</label>
			<div class="input-group half">
				<input type="text" id="email" class="form-control" name="email" value="<?php echo$r['email'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="email" placeholder="Enter an Email...">
				<div id="emailsave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
			</div>
		</div>
		<div class="form-group">
			<label for="phone" class="control-label">Phone</label>
			<div class="input-group half">
				<input type="text" id="phone" class="form-control" name="phone" value="<?php echo$r['phone'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="phone" placeholder="Enter a Phone Number...">
				<div id="phonesave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
			</div>
		</div>
	</div>
	<div class="form-inline">
		<div class="form-group">
			<label for="name" class="control-label">Name</label>
			<div class="input-group">
				<input type="text" id="name" class="form-control" name="name" value="<?php echo$r['name'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="name" placeholder="Enter a Name...">
				<div id="namesave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
			</div>
		</div>
	</div>
	<div class="form-inline">
		<div class="form-group">
			<label for="business" class="control-label">Business</label>
			<div class="input-group">
				<input type="text" id="business" class="form-control" name="business" value="<?php echo$r['business'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="business" placeholder="Enter a Business...">
				<div id="businesssave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
			</div>
		</div>
	</div>
	<div class="form-inline">
		<div class="form-group">
			<label for="address" class="control-label">Address</label>
			<div class="input-group">
				<input type="text" id="address" class="form-control" name="address" value="<?php echo$r['address'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="address" placeholder="Enter an Address...">
				<div id="addresssave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
			</div>
		</div>
	</div>
	<div class="form-inline">
		<div class="form-group">
			<label for="suburb" class="control-label">Suburb</label>
			<div class="input-group half">
				<input type="text" id="suburb" class="form-control" name="suburb" value="<?php echo$r['suburb'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="suburb" placeholder="Enter a Suburb...">
				<div id="suburbsave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
			</div>
		</div>
		<div class="form-group">
			<label for="city" class="control-label">City</label>
			<div class="input-group half">
				<input type="text" id="city" class="form-control" name="city" value="<?php echo$r['city'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="city" placeholder="Enter a City...">
				<div id="citysave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
			</div>
		</div>
	</div>
	<div class="form-inline">
		<div class="form-group">
			<label for="state" class="control-label">State</label>
			<div class="input-group half">
				<input type="text" id="state" class="form-control" name="state" value="<?php echo$r['state'];?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="state" placeholder="Enter a State...">
				<div id="statesave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
			</div>
		</div>
		<div class="form-group">
			<label for="postcode" class="control-label">Postcode</label>
			<div class="input-group half">
				<input type="text" id="postcode" class="form-control" name="postcode" value="<?php if($r['postcode']!=0){echo$r['postcode'];}?>" data-dbid="<?php echo$r['id'];?>" data-dbt="content" data-dbc="postcode" placeholder="Enter a Postcode...">
				<div id="postcodesave" class="input-group-btn hidden"><button class="btn btn-danger">Save</button></div>
			</div>
		</div>
	</div>
<?php $sql=$db->query("SELECT id,contentType,code,title,assoc FROM content WHERE bookable='1' AND title!='' AND status='published' AND internal!='1' ORDER BY code ASC, title ASC");
	if($sql->rowCount()>0){?>
	<div class="form-inline">
		<div class="form-group">
			<label for="rid" class="control-label">Booked</label>
			<div class="input-group">
				<select id="rid" class="form-control" name="rid" onchange="update('<?php echo$r['id'];?>','content','rid',$(this).val());">
					<option value="0">Select an Item...</option>
<?php	while($row=$sql->fetch(PDO::FETCH_ASSOC)){?>
					<option value="<?php echo$row['id'];?>"<?php if($r['rid']==$row['id']){echo' selected';}?>><?php echo ucfirst($row['contentType']).':'.$row['code'].':'.$row['title'];?></option>
<?php	}?>
				</select>
			</div>
		</div>
	</div>
<?php }?>
	<div class="form-inline">
		<div class="form-group">
			<label for="notes" class="control-label">Notes</label>
			<div class="input-group" style="width:708px;">
				<form method="post" target="sp" action="core/update.php">
					<input type="hidden" name="id" value="<?php echo$r['id'];?>">
					<input type="hidden" name="t" value="content">
					<input type="hidden" name="c" value="notes">
					<textarea id="notes" class="summernote2" name="da"><?php echo$r['notes'];?></textarea>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer"></div>
<script src="js/summernote.js"></script>
<script src="includes/js/bootstrap-datetimepicker.min.js"></script>
<script>/*<![CDATA[*/
	$('#tis').datetimepicker({format:'yy-mm-dd hh:ii'});
	$('#tie').datetimepicker({format:'yy-mm-dd hh:ii'});
	$('.summernote2').summernote({toolbar:[['style',['save','bold','italic','underline','clear']]]});
	$('[data-tooltip]').tooltip();
	$(".modal-body input[type=text]").on({
		keydown:function(event){
			var id=$(this).data("dbid");
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var da=$(this).val();
			if(event.keyCode==46||event.keyCode==8){
				$(this).trigger('keypress');
			}
		},
		keyup:function(event){
			if(event.which==9){
				var id=$(this).data("dbid");
				var t=$(this).data("dbt");
				var c=$(this).data("dbc");
				var da=$(this).val();
				update(id,t,c,da);
				$(this).next("input").focus();
			}
		},
		keypress:function(event){
			var id=$(this).data("dbid");
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var da=$(this).val();
			$('#'+c+'save').removeClass('hidden');
			if(event.which==13){
				update(id,t,c,da);
				event.preventDefault();
			}
		},
		change:function(event){
			var id=$(this).data("dbid");
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var da=$(this).val();
			update(id,t,c,da);
		}
	});
	$(".modal-body input[type=checkbox]").on({
		click:function(event){
			var id=$(this).data("dbid");
			var t=$(this).data("dbt");
			var c=$(this).data("dbc");
			var b=$(this).data("dbb");
			$('#'+c+b).before('<i id="'+t+c+b+'" class="busy fa fa-cog fa-spin"></i>')
			$('#sp').load('toggle.php?id='+id+'&t='+t+'&c='+c+'&b='+b);
		}
	});
	function update(id,t,c,da){
		$('#'+c).before('<i id="'+c+'" class="busy fa fa-cog fa-spin"></i>');
		$.ajax({
			type:"GET",
			url:"core/update.php",
			data:{
				id:id,
				t:t,
				c:c,
				da:da
			}
		}).done(function(msg){
			$('#'+c).remove();
			$('#'+c+'save').addClass('hidden')
		})
	}
	function updateButtons(id,t,c,da){
		$('#sp').load('core/update.php?id='+id+'&t='+t+'&c='+c+'&da='+escape(da));
	}
/*]]>*/</script>
