var tundra, notifications;

window.addEvent('domready', function() {
	
	/* Clock
	------------------------------------------------- */
	update_clock('clock');

	/* Start Tundra
	------------------------------------------------- */
	console.log('Getting page configuration...');
	
	notifications = new Notimoo();
	
	new Request.JSON({
		url: '<?php echo site_url('helper/get_page_configuration/' . $this->input->get('tab')); ?>',
		onSuccess: function(data)
		{
			tundra = new Tundra({'conf': data, 'edit': <?php echo $_GET['edit']; ?>});
			tundra.trigger();
		},
		onFailure: function(xhr)
		{
			alert('Error: could not load page configuration.\n\nWhat you should do: try again then file a bug report at http://bugs.projects.chrisatk.in if you see this again. \n\nThe XHR object has been logged to the console');
			console.log(xhr);
		}
	}).send();
});