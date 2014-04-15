<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
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
				<?php echo form_open($this->uri->uri_string()); ?>
				<table>
					<tr>
						<td>
							<div class="notice">Please remember that Tundra is in <em>beta</em>. I'll try to prevent it, but you may loose
							your widget configurations at any time. Also, you'll be logged out whenever I update it.</div>
							<div class="info">Tundra requires a modern browser (Safari 5+, Chrome, Firefox 5+). Internet Explorer is not supported.</div>
						</td>
					</tr>
				
					<?php if ($use_username): ?>
						<tr>
							<td><?php echo form_input(array('name' => $username['name'], 'id' => $username['id'], 'placeholder' => 'username', 'value' => @$username['value'])) ?></td>
						</tr>
					<?php endif; ?>
					
					<tr>
						<td><?php echo form_input(array('name' => $email['name'], 'id' => $email['id'], 'placeholder' => 'email address', 'value' => @$email['value'])) ?></td>
					</tr>
					<tr>
						<td><?php echo form_password(array('name' => $password['name'], 'id' => $password['id'], 'placeholder' => 'password', 'value' => @$password['value'])) ?></td>
					</tr>
					<tr>
						<td><?php echo form_password(array('name' => $confirm_password['name'], 'id' => $confirm_password['id'], 'placeholder' => 'confirm password', 'value' => @$confirm_password['value'])) ?></td>
					</tr>
				
					<?php if ($captcha_registration) {
						if ($use_recaptcha) { ?>
					<tr>
						<td>
							<div id="recaptcha_image"></div>
						</td>
					</tr>
					<tr>
						<td>
							<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
							<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
							<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="recaptcha_only_if_image">Enter the words above</div>
							<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
						</td>
					</tr>
					<tr>
						<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
						<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
						<?php echo $recaptcha_html; ?>
					</tr>
					<?php } else { ?>
					<tr>
						<td>
							<p>Enter the code exactly as it appears:</p>
							<?php echo $captcha_html; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
						<td><?php echo form_input($captcha); ?></td>
						<td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
					</tr>
					<?php }
					} ?>
				</table>
				<?php echo form_submit('register', 'Register'); ?>
				<?php echo form_close(); ?>
				</div>
		</div>
		</div>
</body>
</html>