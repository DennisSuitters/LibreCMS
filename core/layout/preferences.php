<ul class="nav nav-tabs">
	<li class="active"><a href="#theme" data-toggle="tab">Theme</a></li>
	<li><a href="#contact" data-toggle="tab">Contact</a></li>
	<li><a href="#interface" data-toggle="tab">Interface</a></li>
	<li><a href="#banking" data-toggle="tab">Banking</a></li>
	<li><a href="#seo" data-toggle="tab">SEO</a></li>
	<li><a href="#security" data-toggle="tab">Security</a></li>
</ul>
<div class="tab-content">
	<div id="theme" class="tab-pane fade in active">
		<div class="row form-group theme-chooser">
<?php foreach(new DirectoryIterator('layout') as$folder){
		if($folder->isDOT())continue;
		if($folder->isDir()){
			$theme=parse_ini_file('layout/'.$folder.'/theme.ini',true);?>
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
				<div class="theme-chooser-item<?php if($config['theme']==$folder)echo' selected';?>" data-theme="<?php echo$folder;?>">
					<img src="<?php if(file_exists('layout/'.$folder.'/theme.jpg'))echo'layout/'.$folder.'/theme.jpg';elseif(file_exists('layout/'.$folder.'/theme.png'))echo'layout/'.$folder.'/theme.png';else echo'core/images/noimage.jpg';?>" class="img-rounded col-xs-4 col-sm-4 col-md-12 col-lg-12" alt="<?php echo$theme['title'];?>">
					<div class="col-xs-8 col-sm-8 col-md-12 col-lg-12">
						<span class="title"><?php if(isset($theme['title'])&&$theme['title']!='')echo$theme['title'];else echo'No Title Assigned';?></span>
						<small class="version">Version: <?php if(isset($theme['version'])&&$theme['version']!='')echo'v'.$theme['version'];else echo'No Version Assigned';?></small>
						<small class="creator">Creator: <?php if(isset($theme['creator_url'])&&$theme['creator_url']!='')echo'<a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>';else echo'No Creator Assigned';?></small>
						<small class="description"><?php if(isset($theme['description'])&&$theme['description']!='')echo$theme['description'];else'No Description Assigned';?></small>
					</div>
					<div class="clear"></div>
				</div>
			</div>
<?php	}
	}?>
		</div>
	</div>
	<div id="contact" class="tab-pane fade in">
		<div class="form-group">
			<label for="business" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Business</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="business" class="form-control textinput" value="<?php echo$config['business'];?>" data-dbid="1" data-dbt="config" data-dbc="business" placeholder="Enter Business Name...">
			</div>
		</div>
		<div class="form-group">
			<label for="abn" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">ABN</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="abn" class="form-control textinput" value="<?php echo$config['abn'];?>" data-dbid="1" data-dbt="config" data-dbc="abn" placeholder="Enter an ABN...">
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Email</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="Enter an Email...">
			</div>
		</div>
		<div class="form-group">
			<label for="phone" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Phone</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="phone" class="form-control textinput" value="<?php echo$config['phone'];?>" data-dbid="1" data-dbt="config" data-dbc="phone" placeholder="Enter a Phone Number...">
			</div>
		</div>
		<div class="form-group">
			<label for="mobile" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Mobile</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="mobile" class="form-control textinput" value="<?php echo$config['mobile'];?>" data-dbid="1" data-dbt="config" data-dbc="mobile" placeholder="Enter a Mobile Number...">
			</div>
		</div>
		<div class="form-group">
			<label for="address" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Address</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="address" class="form-control textinput" value="<?php echo$config['address'];?>" data-dbid="1" data-dbt="config" data-dbc="address" placeholder="Enter an Address...">
			</div>
		</div>
		<div class="form-group">
			<label for="suburb" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Suburb</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="suburb" class="form-control textinput" value="<?php echo$config['suburb'];?>" data-dbid="1" data-dbt="config" data-dbc="suburb" placeholder="Enter a Suburb...">
			</div>
		</div>
		<div class="form-group">
			<label for="city" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">City</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="city" class="form-control textinput" value="<?php echo$config['city'];?>" data-dbid="1" data-dbt="config" data-dbc="city" placeholder="Enter a City...">
			</div>
		</div>
		<div class="form-group">
			<label for="state" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">State</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="state" class="form-control textinput" value="<?php echo$config['state'];?>" data-dbid="1" data-dbt="config" data-dbc="state" placeholder="Enter a State...">
			</div>
		</div>
		<div class="form-group">
			<label for="postcode" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Postcode</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="postcode" class="form-control textinput" value="<?php if($config['postcode']!=0)echo$config['postcode'];?>" data-dbid="1" data-dbt="config" data-dbc="postcode" placeholder="Enter a Postcode...">
			</div>
		</div>
		<div class="form-group">
			<label for="country" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Country</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="country" class="form-control textinput" value="<?php echo$config['country'];?>" data-dbid="1" data-dbt="config" data-dbc="country" placeholder="Enter a Country...">
			</div>
		</div>
	</div>
	<div id="interface" class="tab-pane fade in">
		<div class="form-group">
			<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
				<input type="checkbox" id="options3" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3"<?php if($config['options']{3}==1)echo' checked';?>><label for="options3">
			</div>
			<label for="options3" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="This allows Users to Create Accounts."';?>>Enable Account Sign Ups</span></label>
		</div>
		<div class="form-group">
			<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
				<input type="checkbox" id="options4" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4"<?php if($config['options']{4}==1)echo' checked';?>><label for="options4">
			</div>
			<label for="options4" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Administration Tooltips, like this one."';?>>Enable Tooltips</span></label>
		</div>
		<div class="form-group">
			<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
				<input type="checkbox" id="options5" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="5"<?php if($config['options']{5}==1)echo' checked';?>><label for="options5">
			</div>
			<label for="options5" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Helper Button for Content Guide Hints."';?>>Enable Clickable Helper Guides like this</span>&nbsp;&nbsp;<button class="btn btn-default"><i class="libre libre-help color-danger"></i></button>
			</label>
		</div>
		<div class="form-group">
			<label for="showItems" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Item Count</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="Number of Items to Show" data-content="Number of Items to Display."><i class="libre libre-help color-danger"></i></button></div>';?>
				<input type="text" id="showItems" class="form-control textinput" value="<?php echo$config['showItems'];?>" data-dbid="1" data-dbt="config" data-dbc="showItems" placeholder="Enter Number of Items to Display..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Number of Items to Display."';?>>
			</div>
		</div>
		<div class="form-group">
			<label for="buttonType" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">
				Buttons Type
			</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<select id="buttonType" class="form-control" onchange="update('1','config','buttonType',$(this).val());"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
					<option value="icon"<?php if($config['buttonType']=='icon')echo' selected';?>>Iconic</option>
					<option value="text"<?php if($config['buttonType']=='text')echo' selected';?>>Textual</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="timezone" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Timezone</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<select id="timezone" class="form-control" onchange="update('1','config','timezone',$(this).val());"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
<?php function formatOffset($offset){
        $hours=$offset/3600;
        $remainder=$offset%3600;
        $sign=$hours>0?'+':'-';
        $hour=(int)abs($hours);
        $minutes=(int)abs($remainder/60);
        if($hour==0&&$minutes==0)$sign=' ';
        return$sign.str_pad($hour,2,'0',STR_PAD_LEFT).':'.str_pad($minutes,2,'0');
    }
    $utc=new DateTimeZone('UTC');
    $dt=new DateTime('now',$utc);
    foreach(DateTimeZone::listIdentifiers() as$tz){
        $current_tz=new DateTimeZone($tz);
        $offset=$current_tz->getOffset($dt);
        $transition=$current_tz->getTransitions($dt->getTimestamp(),$dt->getTimestamp());
        $abbr=$transition[0]['abbr'];
					echo'<option value="'.$tz.'"';if($tz==$config['timezone'])echo' selected';echo'>'.$tz.' ['.$abbr.' '.formatOffset($offset).']</option>';
	}?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="dateFormat" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Date/Time Format</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="Date/Time Format" data-content="This sets how Dates/Times are displayed."><i class="libre libre-help color-danger"></i></button></div>';?>
				<input type="text" id="dateFormat" class="form-control textinput" value="<?php echo$config['dateFormat'];?>" data-dbid="1" data-dbt="config" data-dbc="dateFormat" placeholder="Enter a Date Format..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Format Layout of all Dates/Times displayed."';?>>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">&nbsp;</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<div class="well">
					<h4 onclick="$('#dateTimeOptions').toggle(400);"<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Click to show Date/Time Formatting Options."';?>>
						Show Date/Time Formatting Options
						<span class="pull-right"><i class="caret"></i></span>
					</h4>
					<table id="dateTimeOptions" class="table table-striped" style="display:none">
						<thead>
							<tr><th>format character</th><th>Description Example</th><th>returned values</th></tr>
						</thead>
						<tbody>
							<tr><td colspan="3" class="text-center"><strong>Day</strong></td></tr>
							<tr><td>d</td><td>Day of the month, 2 digits with leading zeros</td><td>01 to 31</td></tr>
							<tr><td>D</td><td>A textual representation of a day, three letters</td><td>Mon through Sun</td></tr>
							<tr><td>j</td><td>Day of the month without leading zeros</td><td>1 to 31</td></tr>
							<tr><td>l</td><td>A full textual representation of the day of the week</td><td>Sunday through Saturday</td></tr>
							<tr><td>S</td><td>English ordinal suffix for the day of the month, 2 characters</td><td>st, nd, rd or th. Works well with j</td></tr>
							<tr><td colspan="3" class="text-center"><strong>Month</strong></td></tr>
							<tr><td>F</td><td>A full textual representation of a month, such as January or March</td><td>January through December</td></tr>
							<tr><td>m</td><td>Numeric representation of a month, with leading zeros</td><td>01 through 12</td></tr>
							<tr><td>M</td><td>A short textual representation of a month, three letters</td><td>Jan through Dec</td></tr>
							<tr><td>n</td><td>Numeric representation of a month, without leading zeros</td><td>1 through 12</td></tr>
							<tr><td colspan="3" class="text-center"><strong>Year</strong></td></tr>
							<tr><td>L</td><td>Whether it\'s a leap year</td><td>1 if it is a leap year, 0 otherwise.</td></tr>
							<tr><td>Y</td><td>A full numeric representation of a year, 4 digits</td><td>Examples: 1999 or 2003</td></tr>
							<tr><td>y</td><td>A two digit representation of a year</td><td>Examples: 99 or 03</td></tr>
							<tr><td colspan="3" class="text-center"><strong>Time</strong></td></tr>
							<tr><td>a</td><td>Lowercase Ante meridiem and Post meridiem</td><td>am or pm</td></tr>
							<tr><td>A</td><td>Uppercase Ante meridiem and Post meridiem</td><td>AM or PM</td></tr>
							<tr><td>g</td><td>12-hour format of an hour without leading zeros</td><td>1 through 12</td></tr>
							<tr><td>G</td><td>24-hour format of an hour without leading zeros</td><td>0 through 23</td></tr>
							<tr><td>h</td><td>12-hour format of an hour with leading zeros</td><td>01 through 12</td></tr>
							<tr><td>H</td><td>24-hour format of an hour with leading zeros</td><td>00 through 23</td></tr>
							<tr><td>i</td><td>Minutes with leading zeros</td><td>00 to 59</td></tr>
							<tr><td colspan="3" class="text-center"><strong>Timezone</strong></td></tr>
							<tr><td>I</td><td>Whether or not the date is in daylight saving time</td><td>1 if Daylight Saving Time, 0 otherwise.</td></tr>
							<tr><td colspan="3" class="text-center"><strong>Full Date/Time</strong></td></tr>
							<tr><td>c</td><td>ISO 8601 date (added in PHP 5)</td><td>2004-02-12T15:19:21+00:00</td></tr>
							<tr><td>r</td><td>RFC 2822 formatted date</td><td>Example: Thu, 21 Dec 2000 16:01:07 +0200</td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div id="banking" class="tab-pane fade in">
		<h4>Banking Details</h4>
		<div class="form-group">
			<label for="bank" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Bank</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="bank" class="form-control textinput" value="<?php echo$config['bank'];?>" data-dbid="1" data-dbt="config" data-dbc="bank" placeholder="Enter Bank Name...">
			</div>
		</div>
		<div class="form-group">
			<label for="bankAccountName" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Account Name</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="bankAccountName" class="form-control textinput" value="<?php echo$config['bankAccountName'];?>"data-dbid="1" data-dbt="config" data-dbc="bankAccountName" placeholder="Enter an Account Name...">
			</div>
		</div>
		<div class="form-group">
			<label for="bankAccountNumber" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Account Number</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="bankAccountNumber" class="form-control textinput" value="<?php echo$config['bankAccountNumber'];?>" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" placeholder="Enter an Account Number...">
			</div>
		</div>
		<div class="form-group">
			<label for="bankBSB" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">BSB</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="bankBSB" class="form-control textinput" value="<?php echo$config['bankBSB'];?>" data-dbid="1" data-dbt="config" data-dbc="bankBSB" placeholder="Enter a BSB...">
			</div>
		</div>
		<h4>PayPal Details</h4>
		<div class="form-group">
			<label for="bankPayPal" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Account</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="bankPayPal" class="form-control textinput" value="<?php echo$config['bankPayPal'];?>" data-dbid="1" data-dbt="config" data-dbc="bankPayPal" placeholder="Enter a PayPal Account...">
			</div>
		</div>
		<div class="form-group">
			<label for="ipn" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">IPN</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="ipn" class="form-control" value="" readonly<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title=""';?>>
			</div>
		</div>
		<h4>Order Processing</h4>
		<div class="form-group">
			<label for="orderPayti" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Allow</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<select id="orderPayti" class="form-control" onchange="update('1','config','orderPayti',$(this).val());">
					<option value="0"<?php if($config['orderPayti']==0)echo' selected';}?>>0 Days</option>
					<option value="604800"<?php if($config['orderPayti']==604800)echo' selected';?>>7 Days</option>
					<option value="1209600"<?php if($config['orderPayti']==1209600)echo' selected';?>>14 Days</option>
					<option value="1814400"<?php if($config['orderPayti']==1814400)echo' selected';?>>21 Days</option>
					<option value="2592000"<?php if($config['orderPayti']==2592000)echo' selected';?>>30 Days</option>
				</select>
				<div class="input-group-addon">for Payments</div>
			</div>
		</div>
		<div class="form-group">
			<label for="orderEmailDefaultSubject" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Email Subject</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<input type="text" id="orderEmailDefaultSubject" class="form-control textinput" value="<?php echo$config['orderEmailDefaultSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="orderEmailDefaultSubject">
				<span class="help-block">You can use the following Tokens: {name} {first} {last} {date} {order_number}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="orderEmailLayout" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Email Layout</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<form method="post" target="sp" action="core/update.php">
					<input type="hidden" name="id" value="1">
					<input type="hidden" name="t" value="config">
					<input type="hidden" name="c" value="orderEmailLayout">
					<textarea id="orderEmailLayout" class="form-control summernote" name="da"><?php echo$config['orderEmailLayout'];?></textarea>
				</form>
				<span class="help-block">You can use the following Tokens: {name} {first} {last} {date} {order_number} {notes}</span>
			</div>
		</div>
		<div class="form-group">
			<label for="orderEmailNotes" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Order Notes</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<form method="post" target="sp" action="core/update.php">
					<input type="hidden" name="id" value="1">
					<input type="hidden" name="t" value="config">
					<input type="hidden" name="c" value="orderEmailNotes">
					<textarea id="orderEmailNotes" class="form-control summernote" name="da"><?php echo$config['orderEmailNotes'];?></textarea>
				</form>
				<span class="help-block">You can use the following Tokens: {name} {first} {last} {date} {order_number} {notes}</span>
			</div>
		</div>
	</div>
	<div id="seo" class="tab-pane fade in">
		<h4>Default Analytics</h4>
		<div class="form-group">
			<div class="col-xs-5 col-sm-3 col-md-3 col-lg-2"></div>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
				<span class="help-block">These will be used if Page or Content Seo Fields are empty.</span>
			</div>
		</div>
		<div class="form-group">
			<label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">seoTitle</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help color-danger"></i></button></div>';?>
				<input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$config['seoTitle'];?>" data-dbid="1" data-dbt="config" data-dbc="seoTitle" placeholder="Enter a Page Title..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
			</div>
		</div>
		<div class="form-group">
			<label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">seoCaption</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help color-danger"></i></button></div>';?>
				<input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$config['seoCaption'];?>" data-dbid="1" data-dbt="config" data-dbc="seoCaption" placeholder="Enter a Page Caption..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
			</div>
		</div>
		<div class="form-group">
			<label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">seoDescription</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help color-danger"></i></button></div>';?>
				<input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$config['seoDescription'];?>" data-dbid="1" data-dbt="config" data-dbc="seoDescription" placeholder="Enter a Page Description..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
			</div>
		</div>
		<div class="form-group">
			<label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">seoKeywords</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help color-danger"></i></button></div>';?>
				<input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$config['seoKeywords'];?>" data-dbid="1" data-dbt="config" data-dbc="seoKeywords" placeholder="Enter Page Keywords..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
			</div>
		</div>
		<h4>Google Analytics</h4>
		<div class="form-group">
			<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
				<input type="checkbox" id="options8" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="8"<?php if($config['options']{8}==1)echo' checked';?>><label for="options8">
			</div>
			<label for="options8" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Disable/Enable Internal Data Collection Widgets Display."';?>>Disable/Enable Google Data Collection Widgets Display.</span></label>
			<div class="col-xs-5 col-sm-3 col-md-3 col-lg-2"></div><div class="help-block">This will not affect the embedded Google Analytics on the main site.</div>
		</div>
		<div class="form-group">
			<label for="gaClientID" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">ClientID</label>
			<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn"><button class="btn btn-default" data-toggle="popover" title="" data-content=""><i class="libre libre-help color-danger"></i></button></div>';?>
				<input type="text" id="gaClientID" class="form-control textinput" value="<?php echo$config['gaClientID'];?>" data-dbid="1" data-dbt="config" data-dbc="gaClientID" placeholder="Enter Google Analytics Client ID..."<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title=""';?>>
			</div>
		</div>
	</div>
	<div id="security" class="tab-pane fade in">
		<div id="backup" class="well" name="backup">
			<h4>Database Backup/Restore</h4>
			<div class="form-group">
				<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Backup</label>
				<form target="sp" method="post" action="core/backup.php">
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<div class="input-group-btn">
							<button type="submit" class="btn btn-default btn-block" onclick="$('#block').css({'display':'block'});">Go</button>
						</div>
					</div>
				</form>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">Restore</label>
				<form target="sp" method="post" enctype="multipart/form-data" action="core/restore.php">
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="file" id="fu" class="form-control" name="fu" accept="application/x-gzip,application/sql">
							<div class="input-group-btn">
								<button type="submit" class="btn btn-default" onclick="$('#block').css({'display':'block'});">Restore</button>
							</div>
						</div>
					</form>
				</div>
<?php foreach(glob("media/backup/backup_*") as$file){
		$file=ltrim($file,'media/backup/');?>
				<div id="l_<?php echo str_replace('.','',$file);?>" class="form-group">
					<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">&nbsp;</label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<a class="btn btn-default btn-block" href="media/<?php echo$file;?>"><?php echo$file;?></a>
						<div class="input-group-btn">
							<button class="btn btn-default" onclick="removeMedia('<?php echo$file;?>')"><i class="libre libre-trash color-danger"></i></button>
						</div>
					</div>
				</div>
<?php }?>
			</div>
			<div class="well">
				<h4>File Integrity Check</h4>
			</div>
		</div>
	</div>
</div>
