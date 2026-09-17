<?php
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
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
</table>
<?php echo form_submit('cancel', 'Delete account'); ?>
<?php echo form_close(); ?>
