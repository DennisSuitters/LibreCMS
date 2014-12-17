<footer class="clearfix relative">
	<div class="logo"><img src="images/librecms-black-trans.png"></div>
	<nav class="navbar navbar-default">
		<ul class="nav navbar-nav pull-right">
			<li><a target="_blank" href="https://github.com/StudioJunkyard/Libr8/wiki"><small>Help</small></a></li>
			<li><a target="_blank" href="https://github.com/StudioJunkyard/Libr8"><small>GitHub</small></a></li>
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
	</nav>
</footer>
