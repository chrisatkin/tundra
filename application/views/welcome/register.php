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
				<?php echo get_image('welcome.logo.png'); ?>
			</div>
		</div>
		
		<h1>
			Register
		</h1>
		
		<p>
			A public beta is coming soon.
		</p>
		
		<p>
			<?php echo anchor('auth', 'Already have an account?'); ?>
		</p>
	
	</div></body>
</html>