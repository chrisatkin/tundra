<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php echo form_open('helper/widget_configuration', array('class' => 'widgetform', 'id' => 'widget-cfg-' . $config['id'])); ?>

<?php $u = unserialize($config['config']); ?>

<?php foreach(unserialize($widget_info['configuration']) as $item): ?>
	<?php echo form_label($item['description'], $item['name']); ?>
	<?php echo form_input($item['name'], $u[$item['name']]); ?>
	
	<br />
	
<?php endforeach; ?>

<hr>

<?php echo form_label('Refresh time', 'refresh'); ?>
<?php echo form_input('refresh', $config['refresh']); ?>

<?php echo form_hidden('widget', $config['id']); ?>

<?php echo form_submit('submit', 'Save'); ?>

<?php echo form_close(); ?>