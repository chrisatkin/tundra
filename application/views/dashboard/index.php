<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Tundra | <?php echo ucfirst($this->uri->rsegment(3)); ?></title>
		<?php echo get_style('dashboard.core.css'); ?>
		<?php echo get_style('dashboard.core.widget.css'); ?>
		<?php echo get_style('themes/' . $profile['theme']['directory'] . '/styles/theme.css'); ?>
		<script type="text/javascript">var _current_tab = '<?php echo $this->uri->rsegment(3); ?>';</script>
	</head>
	<body><div id="super-container">
		<!-- Bar -->
		<div id="bar"><div class="wrapper">
			<div id="bar-left"><strong>Tundra</strong> &nbsp;&nbsp;&nbsp;<?php echo tagline(); ?></div>
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
						echo '<li' . ($tab['name'] == ucfirst($this->uri->rsegment(3)) ? ' id="active" ' : '') . '>' . anchor('dashboard/' . strtolower($tab['name']) . (isset($_GET['edit']) ? '?edit' : ''), $tab['name']) . '</li>';
				?>
			
				<li class="rightside">
					<?php
						if(!isset($_GET['edit'])) echo '<a href="?edit">Edit page</a>';
						else echo '<a href="'. current_url() . '">Done</a>';
					?>
				</li>
			</ul>
		</div></div>
		<!-- /Tabs -->
	
		<!-- Content -->
		<div id="content"><div class="wrapper">
			<noscript>Please enable JavaScript to use Tundra. <a href="http://help.yahoo.com/l/us/yahoo/help/faq/browsers/browsers-63474.html" target="_blank">Instructions</a></noscript>
			<script type="text/javascript">document.write('<div id="content-loading"><?php echo get_image('loading.gif'); ?>Standby...</div>');</script>
			
			<?php if(isset($_GET['edit'])): ?>
			<div id="edit-result"></div>
			<?php endif; ?>
			
			<div id="_target" style="opacity: 0"></div>
			
			<div class="clear"></div>
		</div></div>
		<!-- /Content -->

		<!-- Footer -->
		<div id="footer"><div class="wrapper">
			<div id="footer-left">
				<strong>Tundra</strong> Last updated: <?php echo $this->config->item('last_updated'); ?>
			</div>
			<div id="footer-right">
				<ul>
					<li><a href="http://chrisatk.in" target="_blank">Made by Chris Atkin-Granville &raquo;</a></li>
					<li><a href="http://bugs.projects.chrisatk.in" target="_blank">Report Bugs &raquo;</a></li>
					<li><a href="http://chrisatk.in/project.php?id=tundra" target="_blank">Project Page &raquo;</a></li>
				</ul>
			</div>
			
			<div class="clear"></div>
		</div></div>
		<!-- /Footer -->
	</div></body>
	<?php
		$edit = isset($_GET['edit']) ? 'true' : 'false';
	
		echo get_script('mt.core.js');
		echo get_script('mt.more.js');
		echo get_script('tundra.support.js');
		echo '<script type="text/javascript" src="'. site_url('helper/script/core').'"></script>';
		echo '<script type="text/javascript" src="'. site_url('helper/script/widget').'"></script>';
		echo '<script type="text/javascript" src="'. site_url('helper/script/init?tab=' . $this->uri->rsegment(3)).'&edit=' . $edit . '"></script>';
	?>
</html>
