<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Tundra</title>
		<?php echo get_style('dashboard.core.css'); ?>
		<?php echo get_style('dashboard.settings.css'); ?>
		<?php echo get_style('themes/' . $profile['theme']['directory'] . '/styles/theme.css'); ?>
	</head>
	<body>
		<!-- Bar -->
		<div id="bar"><div class="wrapper">
			<div id="bar-left"><strong>Tundra</strong> &nbsp;&nbsp;&nbsp;<?php echo ucfirst(strtolower(tagline())); ?></div>
			<div id="bar-right">
				<span id="clock"></span>
				<?php echo anchor('news', 'News'); ?>
				<?php echo anchor('settings', 'Settings'); ?>
				<?php echo anchor('auth/logout', 'Logout');?>
			</div>
			
			<div class="clear"></div>
		</div></div>
		<!-- /Bar -->
		
		<!-- Header -->
		<div id="header"><div class="wrapper">
			<div id="header-left"></div>
			<div id="header-right"></div>
			
			<form method="get" action="<?php echo $profile['search_engine']['action']; ?>">
				<input type="text" name="<?php echo $profile['search_engine']['modifier']; ?>" placeholder="Search <?php echo $profile['search_engine']['name']; ?>..." />
			</form>
			
			<div class="clear"></div>
		</div></div>
		<!-- /Header -->

		<!-- Tabs -->
		<div id="tabs"><div class="wrapper">
			<ul>
				<?php
					foreach($tabs as $tab)
						echo '<li' . ($tab['name'] == ucfirst($this->uri->rsegment(3)) ? ' id="active" ' : '') . '>' . anchor('dashboard/' . strtolower($tab['name']), $tab['name']) . '</li>';
				?>
			</ul>
		</div></div>
		<!-- /Tabs -->
	
		<!-- Content -->
		<div id="content"><div class="wrapper">
			<?php echo $contents; ?>
		</div></div>
		<!-- /Content -->
		
		<!-- Footer -->
		<div id="footer"><div class="wrapper">
			<div id="footer-left">
				<strong>Chris Atkin &copy; 2011</strong><br/>Not responsible for the content of external sites.
			</div>
			<div id="footer-right">
				<ul>
					<li><a href="http://chrisatk.in" target="_blank">Chris Atkin &raquo;</a></li>
					<li><a href="mailto:contact@chrisatk.in?subject=Tundra%20bugs">Report Bugs &raquo;</a></li>
					<li><a href="http://chrisatk.in/project.php?id=tundra" target="_blank">Project Page &raquo;</a></li>
				</ul>
			</div>
			
			<div class="clear"></div>
		</div></div>
		<!-- /Footer -->
	</body>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/mootools/1.3.2/mootools-yui-compressed.js"></script>
	<?php
		echo get_script('tundra.support.js');
		echo get_script('tundra.core.js');
		echo '<script type="text/javascript" src="'. site_url('helper/widget_script').'"></script>';
		echo get_script('tundra.init.js');
	?>
</html>
