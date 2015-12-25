<?php
session_start();
require'db.php';
$s=$db->prepare("SELECT DISTINCT
	login.email as email,
	login.business as business,
	login.name as name,
	login.phone as phone,
	login.mobile as mobile,
	login.address as address,
	login.suburb as suburb,
	login.city as city,
	login.state as state,
	login.postcode as postcode
	FROM login
	UNION SELECT DISTINCT
	messages.from_email as email,
	messages.from_business as business,
	messages.from_name as name,
	messages.from_phone as phone,
	messages.from_mobile as mobile,
	messages.from_address as address,
	messages.from_suburb as suburb,
	messages.from_city as city,
	messages.from_state as state,
	messages.from_postcode as postcode
	FROM messages
	UNION SELECT DISTINCT
	content.email as email,
	content.name as name,
	content.business as business,
	content.phone as phone,
	content.mobile as mobile,
	content.address as address,
	content.suburb as suburb,
	content.city as city,
	content.state as state,
	content.postcode as postcode
	FROM content
	WHERE contentType='booking'
	");
$s->execute();?>
<div class="modal-header clearfix">
	<button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4>Contacts</h4>
</div>
<div class="modal-body" style="max-height:450px;overflow-y:auto;">
    <table class="table table-stripped">
        <thead>
            <tr>
                <th>Name/Business</th>
				<th>Phone/Mobile</th>
                <th>Address</th>
				<th></th>
            </tr>
        </thead>
        <tbody>
<?php while($r=$s->fetch(PDO::FETCH_ASSOC)){
    if($r['email']=='')continue;?>
            <tr>
                <td>
<?php 	if($r['name']!=''){
			echo$r['name'].'<br>';
			if($r['business']!='')
				echo'<small>'.$r['business'].'</small><br>';
		}elseif($r['business']!='')
			echo$r['business'].'<br>';?>
					<small><?php echo$r['email'];?></small>
				</td>
                <td>
					<?php if($r['phone']!='')echo'<a href="tel:'.$r['phone'].'">'.$r['phone'].'</a><br>';
					if($r['mobile']!='')echo'<a href="tel:'.$r['mobile'].'">'.$r['mobile'].'</a>';?>
				</td>
				<td>

				</td>
                <td><button class="btn btn-success" onclick="addContact('<?php echo$r['email'];?>');">Add</button></td>
            </tr>
<?php }?>
        </tbody>
    </table>
</div>
<div class="modal-footer"></div>
<script>/*<![CDATA[*/
    function addContact(email){
        var toeml=$('#to_email').val();
        if(toeml!=''){
            $('#to_email').val(toeml+','+email);
        }else{
            $('#to_email').val(email);
        }
    }
/*]]>*/</script>
