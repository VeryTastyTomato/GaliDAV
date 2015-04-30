<!-- File modified for GaliDAV -->

<?php $galidav_path = 'http://test.davical.net/galidav/'; ?>

<div class = "navbar">
	<div class = "navbar-inner">
		<div class = "container-fluid">
			<span class = "brand">
				<?php echo $title ?>
			</span>

			<p class = "navbar-text pull-right" id = "loading">
				<?php echo img(array('src' => 'img/loading.gif')); ?>
			</p>

			<?php
				if (isset($logged_in)):
			?>
					<ul class = "nav pull-right">
						<li class = "dropdown" id = "admin_button">
							<a href = "<?php $galidav_path ?>/login_admin.php?user=<?php echo $this->auth->get_user() ?>" class = "ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-primary" role = "button">
								<span class = "ui-button-text">Administration</span>
							</a>
						</li>
						<li class = "dropdown" id = "usermenu">
							<a href = "#">
								<span class = "username">
									<?php echo $this->auth->get_user() ?>
								</span>
								<b class = "caret"></b>
							</a>
						</li>
					</ul>
			<?php
				endif;
			?>
		</div>
	</div>
</div>
