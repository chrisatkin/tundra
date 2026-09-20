/**
 * Tundra Init (Phase 6 rewrite -- vanilla JS, no MooTools)
 */

var tundra;

document.addEventListener('DOMContentLoaded', function() {

	/* Clock
	------------------------------------------------- */
	update_clock('clock');

	/* Start Tundra
	------------------------------------------------- */
	console.log('Getting page configuration...');

	fetch('<?php echo site_url('helper/get_page_configuration/' . request()->getGet('tab')); ?>')
		.then(function(res) { return res.json(); })
		.then(function(data) {
			tundra = new Tundra({ 'conf': data, 'edit': <?php echo request()->getGet('edit'); ?> });
			tundra.trigger();
		})
		.catch(function(err) {
			alert('Error: could not load page configuration.\n\nWhat you should do: try again then file a bug report at http://bugs.projects.chrisatk.in if you see this again. \n\nThe error has been logged to the console');
			console.log(err);
		});
});
