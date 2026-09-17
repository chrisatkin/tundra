<?php
$login = array(
	'name'	=> 'username',
	'id'	=> 'login',
	'value' => old('username'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> old('remember'),
	'style' => 'margin:0;padding:0',
);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login to Tundra</title>
		<?php echo get_style('auth.core.css'); ?>
	</head>

	<body onload="document.getElementById('login').focus();"><div id="wrapper">

		<!--<?php echo get_image('welcome.logo.png'); ?>-->
		<div id="login">
			<div id="header">
				<?php echo anchor('welcome', 'Welcome to Tundra<sup>beta</sup>'); ?>
			</div>
			<div id="content">
				<?php echo form_open(); ?>
				<table>
					<tr>
						<div class="info">
							Don't forget to check the latest Tundra updates when you're logged in by clicking "News" in the top right-hand corner!
						</div>
					</tr>
					<tr>
						<td><?php echo form_input(array('name' => $login['name'], 'id' => $login['id'], 'placeholder' => 'username', 'value' => @$login['value'])); ?></td>
					</tr>
					<tr>
						<td><?php echo form_password(array('name' => $password['name'], 'id' => $password['id'], 'placeholder' => 'password', 'value' => @$password['value'])); ?></td>
					</tr>

					<!--<tr>
						<td colspan="3">
							<?php echo form_checkbox($remember); ?>
							<?php echo form_label('Remember me', $remember['id']); ?>
							<?php //echo anchor('/auth/forgot_password/', 'Forgot password'); ?>
							<?php if (setting('Auth.allowRegistration')) echo anchor('/auth/register/', 'Register'); ?>
						</td>
					</tr>-->
				</table>
				<?php echo form_submit('submit', 'Authenticate'); ?>
				<?php echo form_close(); ?>
			</div>
		</div>

		<div id="last-updated">
			Tundra will log you in for <strong>2 months</strong><br>
			Last updated: October 9th
		</div>

		</div>
	</body>

	<script type="text/javascript">
		document.getElementById("login").focus();
	</script>
</html>
