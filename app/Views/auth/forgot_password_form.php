<?php
// Ported from application/views/auth/forgot_password_form.php. Tank Auth's
// forgot/reset-password flow is replaced by Shield's magic-link login (see
// app/Config/Auth.php), so this now asks for an email address -- the field
// this view originally called `login` (username-or-email) is `email` here
// since that's what CodeIgniter\Shield\Controllers\MagicLinkController
// expects and Tank Auth's own login_by_email was FALSE, login_by_username
// was TRUE, so there's no equivalent "login-or-email" field to preserve.
$login = array(
	'name'	=> 'email',
	'id'	=> 'login',
	'value' => old('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$errors = session()->getFlashdata('errors') ?? [];
?>
<?php echo form_open(); ?>
<table>
	<tr>
		<td><?php echo form_label('Email', $login['id']); ?></td>
		<td><?php echo form_input($login); ?></td>
		<td style="color: red;"><?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : session()->getFlashdata('error'); ?></td>
	</tr>
</table>
<?php echo form_submit('reset', 'Get a new password'); ?>
<?php echo form_close(); ?>
