<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Welcome to Tundra</title>
		<?php echo get_style('welcome.core.css'); ?>
	</head>
	
	<body><div id="wrapper">
		<div id="header">
			<div id="header-left">
				<?php echo get_image('welcome.logo.png', 'Tundra', null, 'Last updated: ' . $this->config->item('last_updated')); ?>

			</div>
			
			<div id="header-right">
				<ul>
					<li><?php echo anchor('auth', 'Login'); ?></li>
					<!--<li><?php echo anchor('auth/register', 'Sign Up'); ?></li>-->
					<li><?php echo anchor('#', 'Public Beta Coming Soon'); ?></li>
				</ul>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div id="hero">
			<?php echo get_image('welcome.hero.png'); ?>
		</div>
		
		<div id="summary">
			<p>
				Tundra is an app that allows you to keep up-to-date with all your favourite websites on one page.
			</p>
		</div>
		
		<!-- Content -->
	
		<div class="hero-area left-hero">
			<div class="image"><?php echo get_image('welcome.hero.tabs.png'); ?></div>
			<div class="text">
				<span class="title">Tabs, columns and widgets</span>
				<span class="text">
					Organize your online life into as many tabs and widgets as you want. You can have unlimited numbers of tabs and columns, and unlimited numbers of widgets per column. Each widget
					is fully configurable so you can have it just how you like it.
				</span>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div class="hero-area right-hero">
			<div class="image"><?php echo get_image('welcome.hero.refresh.png'); ?></div>
			<div class="text">
				<span class="title">Auto refresh</span>
				<span class="text">
					Each widget can automatically refresh (independently of both the page and other widgets) at any interval you'd like (or not at all) so you're always kept up-to-date. 
				</span>
			</div>
			
			<div class="clear"></div>
		</div>
				
		<div class="hero-area left-hero">
			<div class="image"><?php echo get_image('welcome.hero.command.png'); ?></div>
			<div class="text">
				<span class="title">Power at your fingertips</span>
				<span class="text">
					Tundra includes a powerful command bar that lets you do more in less time. Right now, you can search using any search engine of your choice (either choose from a built-in selection or
					specify your own) but soon it'll support many more features.
				</span>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div class="hero-area right-hero">
			<div class="image"><?php echo get_image('welcome.hero.themes.png'); ?></div>
			<div class="text">
				<span class="title">Instant customisation</span>
				<span class="text">
					Change the look of Tundra instantly with themes. Choose from a list of themes that have been made by someone else or make your own by uploading a CSS file and any resources your
					theme needs (documentation coming soon).
				</span>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div class="hero-area left-hero">
			<div class="image"><?php echo get_image('welcome.hero.history.png'); ?></div>
			<div class="text">
				<span class="title">Viewing history</span>
				<span class="text">	
					Access Tundra on multiple browsers and get fustrated that you don't know what you've already seen? If you opt-in to the view history feature, Tundra will keep a log of the articles that
					you visit through RSS feeds so you never read one thing twice.
				</span>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div class="hero-area right-hero">
			<div class="image"><?php echo get_image('welcome.hero.standards.png'); ?></div>
			<div class="text">
				<span class="title">Developers, start your editors</span>
				<span class="text">
					Tundra uses the latest web standards - HTML5 and CSS3. This allows Tundra to implement the latest features effortlessly so the experience is better for you - the user. Additionally,
					Tundra is written using the CodeIgniter and MooTools frameworks.
				</span>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div id="footer">
			<div id="left-footer">
				Chris Atkin-Granville &copy; 2011
			</div>
			
			<div id="right-footer">
				<ul>
					<li><a href="http://chrisatk.in" target="_blank">Made by Chris Atkin-Granville &raquo;</a></li>
					<li><a href="http://bugs.projects.chrisatk.in" target="_blank">Report Bugs &raquo;</a></li>
					<li><a href="http://chrisatk.in/project.php?id=tundra" target="_blank">Project Page &raquo;</a></li>
				</ul>
			</div>
			
			<div class="clear"></div>
		</div>
	
	</div></body>
</html>