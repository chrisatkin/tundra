<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php echo form_open(); ?>
<table id="themes">
	<thead>
		<tr>
			<td id="preview">Preview</td>
			<td id="name">Name</td>
			<td id="description">Description</td>
			<td id="creator">Who made this?</td>
			<td id="select"></td>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach($themes as $theme): ?>
			<tr <?php if($theme['name'] == $profile['theme']['name']) echo 'id="active"'; ?>>
				<td id="preview"><img src="<?php echo base_url(); ?>assets/themes/<?php echo $theme['directory']; ?>/art/preview.jpg" alt="<?php echo $theme['name']; ?> preview" /></td>
				<td id="name"><?php echo $theme['name']; ?></td>
				<td id="description"><?php echo $theme['description']; ?></td>
				<td id="creator"><?php echo $theme['creator']; ?></td>
				<td id="select"><?php echo form_radio('theme', $theme['id'], $profile['theme']['name'] == $theme['name']); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	
	<tfoot>
		<tr>
			<td colspan="5">
				<?php echo form_submit('submit', 'Save'); ?>
			</td>
		</tr>
	</tfoot>
</table>
<?php echo form_close(); ?>