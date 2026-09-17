<?php
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> old('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
?>
<?php echo form_open(); ?>
<table>
	<tr>
		<td><?php echo form_label('Password', $password['id']); ?></td>
		<td><?php echo form_password($password); ?></td>
		<td style="color: red;"><?php echo $errors[$password['name']] ?? ''; ?></td>
	</tr>
	<tr>
		<td><?php echo form_label('New email address', $email['id']); ?></td>
		<td><?php echo form_input($email); ?></td>
		<td style="color: red;"><?php echo $errors[$email['name']] ?? ''; ?></td>
	</tr>
</table>
<?php echo form_submit('change', 'Change email'); ?>
<?php echo form_close(); ?>
