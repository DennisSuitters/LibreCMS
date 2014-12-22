<footer class="clearfix navbar navbar-default">
	<div class="logo"><img src="includes/images/librecms-bw.png"></div>
	<ul class="nav navbar-nav pull-right">
		<li><a target="_blank" href="https://github.com/StudioJunkyard/LibreCMS/wiki"><small>Help</small></a></li>
		<li><a target="_blank" href="https://github.com/StudioJunkyard/LibreCMS"><small>GitHub</small></a></li>
		<li><a href="<?php echo URL;?>/"><small>Front</small></a></li>
		<li><a href="<?php echo URL;?>/logout"><small>Logout</small></a></li>
		<li>
			<form class="navbar-form" method="post" action="<?php echo URL;?>/search">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" name="search" placeholder="Enter a Search Term...">
						<div class="input-group-btn">
							<button type="submit" class="btn btn-info">Search</button>
						</div>
					</div>
				</div>
			</form>
		</li>
	</ul>
</footer>
