<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
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
				<?php echo form_open($this->uri->uri_string()); ?>
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
				
					<?php if ($show_captcha) {
						if ($use_recaptcha) { ?>
					<tr>
						<td colspan="2">
							<div id="recaptcha_image"></div>
						</td>
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
						<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
						<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
						<?php echo $recaptcha_html; ?>
					</tr>
					<?php } else { ?>
					<tr>
						<td colspan="3">
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
				
					<!--<tr>
						<td colspan="3">
							<?php echo form_checkbox($remember); ?>
							<?php echo form_label('Remember me', $remember['id']); ?>
							<?php //echo anchor('/auth/forgot_password/', 'Forgot password'); ?>
							<?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?>
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