<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php echo form_open(); ?>

<?php $u = unserialize($config['config']); ?>
<?php foreach(unserialize($widget_info['configuration']) as $item): ?>
	<?php echo form_label($item['description'], $item['id']); ?>
	<?php echo form_input($item['id'], $u[$item['id']]); ?>
	
	<br />
	
<?php endforeach; ?>

<?php echo form_submit('submit', 'Save'); ?>

<?php echo form_close(); ?>