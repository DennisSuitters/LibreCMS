<div class="page-toolbar"></div>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#theme" data-toggle="tab"><i class="libre libre-theme visible-xs"></i><span class="hidden-xs"><?php lang('button','theme');?></span></a></li>
			<li><a href="#contact" data-toggle="tab"><i class="libre libre-address-book visible-xs"></i><span class="hidden-xs"><?php lang('button','contact');?></span></a></li>
			<li><a href="#interface" data-toggle="tab"><i class="libre libre-desktop visible-xs"></i><span class="hidden-xs"><?php lang('button','interface');?></span></a></li>
			<li><a href="#banking" data-toggle="tab"><i class="libre libre-bank visible-xs"></i><span class="hidden-xs"><?php lang('button','banking');?></span></a></li>
			<li><a href="#seo" data-toggle="tab"><i class="libre libre-seo visible-xs"></i><span class="hidden-xs"><?php lang('button','seo');?></span></a></li>
			<li><a href="#security" data-toggle="tab"><i class="libre libre-security visible-xs"></i><span class="hidden-xs"><?php lang('button','security');?></span></a></li>
		</ul>
		<div class="tab-content">
			<div id="theme" class="tab-pane fade in active">
				<div class="row theme-chooser">
<?php foreach(new DirectoryIterator('layout') as$folder){
		if($folder->isDOT())continue;
		if($folder->isDir()){
			$theme=parse_ini_file('layout/'.$folder.'/theme.ini',true);?>
					<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
						<div class="theme-chooser-item panel<?php if($config['theme']==$folder)echo' panel-success';?>" data-theme="<?php echo$folder;?>">
							<div class="panel-image">
								<img src="<?php if(file_exists('layout/'.$folder.'/theme.jpg'))echo'layout/'.$folder.'/theme.jpg';elseif(file_exists('layout/'.$folder.'/theme.png'))echo'layout/'.$folder.'/theme.png';else echo'core/images/noimage.jpg';?>" alt="<?php echo$theme['title'];?>">
								<h4 class="panel-title text-white text-shadow-depth-1-half"><?php if(isset($theme['title'])&&$theme['title']!='')echo$theme['title'];else echo'No Title Assigned';?></h4>
							</div>
							<div class="panel-body panel-content">
								<p>
									<small class="version"><?php lang('label','version');?>: <?php if(isset($theme['version'])&&$theme['version']!='')echo$theme['version'];else echo'No Version Assigned';?></small><br>
									<small class="creator"><?php lang('label','creator');?>: <?php if(isset($theme['creator_url'])&&$theme['creator_url']!='')echo'<a target="_blank" href="'.$theme['creator_url'].'">'.$theme['creator'].'</a>';else lang('info','nocreator');?></small><br>
									<small class="description"><?php if(isset($theme['description'])&&$theme['description']!='')echo$theme['description'];else lang('info','nodescription');?></small>
								</p>
							</div>
						</div>
					</div>
<?php	}
	}?>
				</div>
			</div>
			<div id="contact" class="tab-pane fade in">
				<div class="form-group">
					<label for="business" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','business');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="business" class="form-control textinput" value="<?php echo$config['business'];?>" data-dbid="1" data-dbt="config" data-dbc="business" placeholder="<?php lang('placeholder','business');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="abn" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','abn');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="abn" class="form-control textinput" value="<?php echo$config['abn'];?>" data-dbid="1" data-dbt="config" data-dbc="abn" placeholder="<?php lang('placeholder','abn');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','email');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="email" class="form-control textinput" value="<?php echo$config['email'];?>" data-dbid="1" data-dbt="config" data-dbc="email" placeholder="<?php lang('placeholder','email');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="phone" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','phone');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="phone" class="form-control textinput" value="<?php echo$config['phone'];?>" data-dbid="1" data-dbt="config" data-dbc="phone" placeholder="<?php lang('placeholder','phone');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="mobile" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','mobile');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="mobile" class="form-control textinput" value="<?php echo$config['mobile'];?>" data-dbid="1" data-dbt="config" data-dbc="mobile" placeholder="<?php lang('placeholder','mobile');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="address" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','address');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="address" class="form-control textinput" value="<?php echo$config['address'];?>" data-dbid="1" data-dbt="config" data-dbc="address" placeholder="<?php lang('placeholder','address');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="suburb" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','suburb');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="suburb" class="form-control textinput" value="<?php echo$config['suburb'];?>" data-dbid="1" data-dbt="config" data-dbc="suburb" placeholder="<?php lang('placeholder','suburb');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="city" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','city');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="city" class="form-control textinput" value="<?php echo$config['city'];?>" data-dbid="1" data-dbt="config" data-dbc="city" placeholder="<?php lang('placeholder','city');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="state" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','state');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="state" class="form-control textinput" value="<?php echo$config['state'];?>" data-dbid="1" data-dbt="config" data-dbc="state" placeholder="<?php lang('placeholder','state');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="postcode" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','postcode');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="postcode" class="form-control textinput" value="<?php if($config['postcode']!=0)echo$config['postcode'];?>" data-dbid="1" data-dbt="config" data-dbc="postcode" placeholder="<?php lang('placeholder','postcode');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="country" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','country');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="country" class="form-control textinput" value="<?php echo$config['country'];?>" data-dbid="1" data-dbt="config" data-dbc="country" placeholder="<?php lang('placeholder','country');?>">
					</div>
				</div>
			</div>
			<div id="interface" class="tab-pane fade in">
				<div class="form-group">
					<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
						<input type="checkbox" id="options3" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="3"<?php if($config['options']{3}==1)echo' checked';?>><label for="options3">
					</div>
					<label for="options3" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="This allows Users to Create Accounts."';?>><?php lang('label','enablesignups');?></span></label>
				</div>
				<div class="form-group">
					<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
						<input type="checkbox" id="options4" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="4"<?php if($config['options']{4}==1)echo' checked';?>><label for="options4">
					</div>
					<label for="options4" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Administration Tooltips, like this one."';?>><?php lang('label','enabletooltips');?></span></label>
				</div>
				<div class="form-group">
					<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
						<input type="checkbox" id="options5" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="5"<?php if($config['options']{5}==1)echo' checked';?>><label for="options5">
					</div>
					<label for="options5" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Display Helper Button for Content Guide Hints."';?>><?php lang('label','enableguides');?></span>&nbsp;&nbsp;<button class="btn btn-info"><i class="libre libre-seo"></i></button></label>
					<div class="help-block col-xs-7 col-sm-9 col-md-9 col-lg-10 pull-right">
						<?php lang('info','seohelper');?>
					</div>
				</div>
				<div class="clearfix"></div>
				<fieldset>
					<legend><?php lang('title','preferencescontentdisplay');?></legend>
					<div class="form-group">
						<label for="layoutContent" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','content');?></label>
						<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-default<?php if($config['layoutContent']=='card'){echo' active';}?>"><input type="radio" name="options" id="option1" autocomplete="off" onchange="update('1','config','layoutContent','card');"<?php if($config['layoutContent']=='card'){echo' checked';}echo'><i class="libre libre-layout-blocks"></i>';?></label>
								<label class="btn btn-default<?php if($config['layoutContent']=='list'){echo' active';}?>"><input type="radio" name="options" id="option2" autocomplete="off" onchange="update('1','config','layoutContent','list');"<?php if($config['layoutContent']=='list'){echo' checked';}echo'><i class="libre libre-layout-list"></i>';?>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="layoutContent" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','accounts');?></label>
						<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-default<?php if($config['layoutAccounts']=='card'){echo' active';}?>"><input type="radio" name="options" id="option1" autocomplete="off" onchange="update('1','config','layoutAccounts','card');"<?php if($config['layoutAccounts']=='card'){echo' checked';}echo'><i class="libre libre-layout-blocks"></i>';?></label>
								<label class="btn btn-default<?php if($config['layoutAccounts']=='list'){echo' active';}?>"><input type="radio" name="options" id="option2" autocomplete="off" onchange="update('1','config','layoutAccounts','list');"<?php if($config['layoutAccounts']=='list'){echo' checked';}echo'><i class="libre libre-layout-list"></i>';?>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="layoutContent" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','bookings');?></label>
						<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-default<?php if($config['layoutBookings']=='calendar'){echo' active';}?>">
									<input type="radio" name="options" id="option1" autocomplete="off" onchange="update('1','config','layoutAccounts','calendar');"<?php if($config['layoutBookings']=='calendar'){echo' checked';}echo'><i class="libre libre-calendar"></i>';?>
								</label>
								<label class="btn btn-default<?php if($config['layoutBookings']=='list'){echo' active';}?>">
									<input type="radio" name="options" id="option2" autocomplete="off" onchange="update('1','config','layoutBookings','list');"<?php if($config['layoutBookings']=='list'){echo' checked';}echo'><i class="libre libre-layout-list"></i>';?>
								</label>
							</div>
						</div>
					</div>
				</fieldset>
				<div class="form-group">
					<label for="showItems" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','itemcount');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><button class="btn btn-info" data-toggle="popover" title="Number of Items to Show" data-content="Number of Items to Display."><i class="libre libre-seo"></i></button></div>';?>
						<input type="text" id="showItems" class="form-control textinput" value="<?php echo$config['showItems'];?>" data-dbid="1" data-dbt="config" data-dbc="showItems" placeholder="Enter Number of Items to Display..."<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','itemcount');echo'"';}?>>
					</div>
				</div>
				<div class="form-group">
					<label for="idleTime" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','idletime');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="idleTime" class="form-control textinput" value="<?php echo$config['idleTime'];?>" data-dbid="1" data-dbt="config" data-dbc="idleTime" placeholder="Enter a Time in Minutes..."<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','idletime');echo'"';}?>>
						<div class="input-group-addon"><?php lang('Minutes');?></div>
					</div>
					<div class="col-xs-7 col-sm-9 col-md-9 col-lg-10 pull-right">
						<div class="help-block"><?php lang('info','idletime');?></div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="form-group">
					<label for="language" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','language');?></label>
					<div class="input-group col-xs-8 col-sm-9 col-md-9 col-lg-10">
						<select id="language" class="form-control" onchange="update('1','config','language',$(this).val());">
<?php	$languages=parse_ini_file('core/lang/languages.ini');
		foreach($languages as $lang){
			$l=explode(':',$lang);?>
							<option value="<?php echo$l[0];?>"<?php if($config['language']==$l[0])echo' selected';?>><?php echo$l[1];?></option>
<?php	}?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="timezone" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','timezone');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<select id="timezone" class="form-control" onchange="update('1','config','timezone',$(this).val());"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','timezone');echo'"';}?>>
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
					<label for="dateFormat" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','datetimeformat');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="dateFormat" class="form-control textinput" value="<?php echo$config['dateFormat'];?>" data-dbid="1" data-dbt="config" data-dbc="dateFormat" placeholder="Enter a Date Format..."<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','datetimeformat');echo'"';}?>>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">&nbsp;</label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<div class="well">
							<h4 onclick="$('#dateTimeOptions').toggle(400);"<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','dateformatoptions');echo'"';}?>><?php lang('title','dateformatoptions');?>
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
				<h4><?php lang('title','banking');?></h4>
				<div class="form-group">
					<label for="bank" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','bank');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="bank" class="form-control textinput" value="<?php echo$config['bank'];?>" data-dbid="1" data-dbt="config" data-dbc="bank" placeholder="<?php lang('placeholder','bank');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="bankAccountName" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','accountname');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="bankAccountName" class="form-control textinput" value="<?php echo$config['bankAccountName'];?>"data-dbid="1" data-dbt="config" data-dbc="bankAccountName" placeholder="<?php lang('placeholder','accountname');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="bankAccountNumber" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','accountnumber');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="bankAccountNumber" class="form-control textinput" value="<?php echo$config['bankAccountNumber'];?>" data-dbid="1" data-dbt="config" data-dbc="bankAccountNumber" placeholder="<?php lang('placeholder','accountnumber');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="bankBSB" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','bsb');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="bankBSB" class="form-control textinput" value="<?php echo$config['bankBSB'];?>" data-dbid="1" data-dbt="config" data-dbc="bankBSB" placeholder="<?php lang('placeholder','bsb');?>">
					</div>
				</div>
				<h4><?php lang('title','paypal');?></h4>
				<div class="form-group">
					<label for="bankPayPal" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','paypalaccount');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="bankPayPal" class="form-control textinput" value="<?php echo$config['bankPayPal'];?>" data-dbid="1" data-dbt="config" data-dbc="bankPayPal" placeholder="<?php lang('placeholder','paypalaccount');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="ipn" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','paypalipn');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="ipn" class="form-control" value="" readonly<?php if($config['options']{4}==1){echo' data-toggle="tooltip" title="';lang('tooltip','paypalipn');echo'"';}?>>
					</div>
				</div>
				<h4><?php lang('title','orderprocessing');?></h4>
				<div class="form-group">
					<label for="orderPayti" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','allow');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<select id="orderPayti" class="form-control" onchange="update('1','config','orderPayti',$(this).val());">
							<option value="0"<?php if($config['orderPayti']==0)echo' selected';?>><?php lang('button','0days');?></option>
							<option value="604800"<?php if($config['orderPayti']==604800)echo' selected';?>><?php lang('button','7days');?></option>
							<option value="1209600"<?php if($config['orderPayti']==1209600)echo' selected';?>><?php lang('button','14days');?></option>
							<option value="1814400"<?php if($config['orderPayti']==1814400)echo' selected';?>><?php lang('button','21days');?></option>
							<option value="2592000"<?php if($config['orderPayti']==2592000)echo' selected';?>><?php lang('button','30days');?></option>
						</select>
						<div class="input-group-addon"><?php lang('label','forpayments');?></div>
					</div>
				</div>
				<div class="form-group">
					<label for="orderEmailDefaultSubject" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','orderemaildefaultsubject');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<input type="text" id="orderEmailDefaultSubject" class="form-control textinput" value="<?php echo$config['orderEmailDefaultSubject'];?>" data-dbid="1" data-dbt="config" data-dbc="orderEmailDefaultSubject">
						<span class="help-block"><?php lang('info','emailsubjecttokens');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="orderEmailLayout" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','orderemaillayout');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<form method="post" target="sp" action="core/update.php">
							<input type="hidden" name="id" value="1">
							<input type="hidden" name="t" value="config">
							<input type="hidden" name="c" value="orderEmailLayout">
							<textarea id="orderEmailLayout" class="form-control summernote" name="da"><?php echo$config['orderEmailLayout'];?></textarea>
						</form>
						<span class="help-block"><?php lang('info','orderemaillayout');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="orderEmailNotes" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','orderemailnotes');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<form method="post" target="sp" action="core/update.php">
							<input type="hidden" name="id" value="1">
							<input type="hidden" name="t" value="config">
							<input type="hidden" name="c" value="orderEmailNotes">
							<textarea id="orderEmailNotes" class="form-control summernote" name="da"><?php echo$config['orderEmailNotes'];?></textarea>
						</form>
						<span class="help-block"><?php lang('info','orderemailnotes');?></span>
					</div>
				</div>
			</div>
			<div id="seo" class="tab-pane fade in">
				<h4><?php lang('title','analytics');?></h4>
				<div class="form-group">
					<div class="col-xs-5 col-sm-3 col-md-3 col-lg-2"></div>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
						<span class="help-block"><?php lang('info','analytics');?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="seoTitle" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','seotitle');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><button class="btn btn-info" data-toggle="popover" title="" data-content=""><i class="libre libre-seo"></i></button></div>';?>
						<input type="text" id="seoTitle" class="form-control textinput" value="<?php echo$config['seoTitle'];?>" data-dbid="1" data-dbt="config" data-dbc="seoTitle" placeholder="<?php lang('placeholder','seotitle');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="seoCaption" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','seocaption');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><button class="btn btn-info" data-toggle="popover" title="" data-content=""><i class="libre libre-seo"></i></button></div>';?>
						<input type="text" id="seoCaption" class="form-control textinput" value="<?php echo$config['seoCaption'];?>" data-dbid="1" data-dbt="config" data-dbc="seoCaption" placeholder="<?php lang('placeholder','seocaption');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="seoDescription" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','seodescription');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><button class="btn btn-info" data-toggle="popover" title="" data-content=""><i class="libre libre-seo"></i></button></div>';?>
						<input type="text" id="seoDescription" class="form-control textinput" value="<?php echo$config['seoDescription'];?>" data-dbid="1" data-dbt="config" data-dbc="seoDescription" placeholder="<?php lang('placeholder','seodescription');?>">
					</div>
				</div>
				<div class="form-group">
					<label for="seoKeywords" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2"><?php lang('label','seokeywords');?></label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><button class="btn btn-info" data-toggle="popover" title="" data-content=""><i class="libre libre-seo"></i></button></div>';?>
						<input type="text" id="seoKeywords" class="form-control textinput" value="<?php echo$config['seoKeywords'];?>" data-dbid="1" data-dbt="config" data-dbc="seoKeywords" placeholder="<?php lang('placeholder','seokeywords');?>">
					</div>
				</div>
				<h4><?php lang('title','googleanalytics');?></h4>
				<div class="form-group">
					<div class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2 text-right">
						<input type="checkbox" id="options8" data-dbid="1" data-dbt="config" data-dbc="options" data-dbb="8"<?php if($config['options']{8}==1)echo' checked';?>><label for="options8">
					</div>
					<label for="options8" class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10"><span<?php if($config['options']{4}==1)echo' data-toggle="tooltip" title="Disable/Enable Internal Data Collection Widgets Display."';?>>Disable/Enable Google Data Collection Widgets Display.</span></label>
					<div class="help-block col-xs-7 col-sm-9 col-md-9 col-lg-10 pull-right">This will not affect the embedded Google Analytics on the main site.</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group">
					<label for="gaClientID" class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">ClientID</label>
					<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
<?php 	if($config['options']{5}==1)echo'<div class="input-group-btn hidden-xs"><button class="btn btn-info" data-toggle="popover" title="" data-content=""><i class="libre libre-seo"></i></button></div>';?>
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
								<div class="btn btn-default btn-block btn-file">
									Browse for Backup File<input type="file" id="fu" class="form-control" name="fu" accept="application/x-gzip,application/sql">
								</div>
								<div class="input-group-btn">
									<button type="submit" class="btn btn-default" onclick="$('#block').css({'display':'block'});">Restore</button>
								</div>
							</div>
						</form>
					</div>
					<div class="form-group">
<?php foreach(glob("media/backup/backup_*") as$file){
		$file=ltrim($file,'media/backup/');?>
						<div id="l_<?php echo str_replace('.','',$file);?>" class="form-group">
							<label class="control-label col-xs-5 col-sm-3 col-md-3 col-lg-2">&nbsp;</label>
							<div class="input-group col-xs-7 col-sm-9 col-md-9 col-lg-10">
								<a class="btn btn-default btn-block" href="media/backup/<?php echo$file;?>"><?php echo$file;?></a>
								<div class="input-group-btn">
									<button class="btn btn-default" onclick="removeMedia('<?php echo$file;?>')"><i class="libre libre-trash text-danger"></i></button>
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
	</div>
</div>
