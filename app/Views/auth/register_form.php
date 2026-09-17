<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'value' => old('username'),
	'maxlength'	=> 20,
	'size'	=> 30,
);
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> old('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => old('password'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'password_confirm',
	'id'	=> 'confirm_password',
	'value' => old('password_confirm'),
	'size'	=> 30,
);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tundra Registration</title>
		<?php echo get_style('auth.core.css'); ?>
	</head>

	<body><div id="wrapper">

		<!--<?php echo get_image('welcome.logo.png'); ?>-->
		<div id="login">
			<div id="header">
				<?php echo anchor('welcome', 'Welcome to Tundra<sup>beta</sup>'); ?>
			</div>
			<div id="content">
				<?php echo form_open(); ?>
				<table>
					<tr>
						<td>
							<div class="notice">Please remember that Tundra is in <em>beta</em>. I'll try to prevent it, but you may loose
							your widget configurations at any time. Also, you'll be logged out whenever I update it.</div>
							<div class="info">Tundra requires a modern browser (Safari 5+, Chrome, Firefox 5+). Internet Explorer is not supported.</div>
						</td>
					</tr>

					<tr>
						<td><?php echo form_input(array('name' => $username['name'], 'id' => $username['id'], 'placeholder' => 'username', 'value' => @$username['value'])) ?></td>
					</tr>

					<tr>
						<td><?php echo form_input(array('name' => $email['name'], 'id' => $email['id'], 'placeholder' => 'email address', 'value' => @$email['value'])) ?></td>
					</tr>
					<tr>
						<td><?php echo form_password(array('name' => $password['name'], 'id' => $password['id'], 'placeholder' => 'password', 'value' => @$password['value'])) ?></td>
					</tr>
					<tr>
						<td><?php echo form_password(array('name' => $confirm_password['name'], 'id' => $confirm_password['id'], 'placeholder' => 'confirm password', 'value' => @$confirm_password['value'])) ?></td>
					</tr>
				</table>
				<?php echo form_submit('register', 'Register'); ?>
				<?php echo form_close(); ?>
				</div>
		</div>
		</div>
</body>
</html>
