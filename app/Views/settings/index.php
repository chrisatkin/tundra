<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Tundra | Settings</title>
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
				<?php foreach($tabs as $tab): ?>
					<li><?php echo anchor('dashboard/' . strtolower($tab['name']), $tab['name']); ?></li>
				<?php endforeach; ?>
			</ul>
		</div></div>
		<!-- /Tabs -->

		<!-- Content -->
		<div id="content"><div class="wrapper">
			<?php echo form_open(); ?>
			<table id="themes" width="100%">
				<tbody>
					<?php foreach($themes as $theme): ?>
						<tr <?php if($theme['name'] == $profile['theme']['name']) echo 'class="active"'; ?>>
							<td id="preview" colspan="4"><img src="<?php echo base_url(); ?>assets/styles/themes/<?php echo $theme['directory']; ?>/art/header-background.jpg" alt="<?php echo $theme['name']; ?> preview" /></td>
						</tr>
						<tr <?php if($theme['name'] == $profile['theme']['name']) echo 'class="active"'; ?>>
							<td id="name"><?php echo $theme['name']; ?></td>
							<td id="description"><?php echo $theme['description']; ?></td>
							<td id="creator"><?php echo $theme['creator']; ?></td>
							<td id="select"><?php echo form_radio('theme', $theme['id'], $profile['theme']['name'] == $theme['name']); ?></td>
						</tr>

						<tr>
							<td colspan="4">&nbsp;</td>
						</tr>
					<?php endforeach; ?>
				</tbody>

				<tfoot>
					<tr>
						<td colspan="5">
							<?php echo form_submit('submit', 'Save'); ?>
						</td>
					</tr>
				</tfoot>
			</table>
			<?php echo form_close(); ?>
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
	<?php echo '<script type="text/javascript" src="'. site_url('helper/script/support').'"></script>'; ?>
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {
			update_clock('clock');
		});
	</script>
</html>
