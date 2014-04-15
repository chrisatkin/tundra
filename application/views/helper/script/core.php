/**
 * Tundra Core
 * Tundra class for loading and managing widgets
 * 
 * @author		Chris Atkin
 * @link		http://chrisatk.in
 * @email		contact {at} chrisatk {dot} com
 * 
 * @file		tundra.core.js
 * @version		1.0
 * @date		10/09/2011
 * 
 * Copyright (c) 2011 Chris Atkin. All rights reserved
 */
 
var Tundra = new Class({
	Implements: Options,
	
	options : {
		'conf': null,
		'column_target' : '_target',
	},
	
	/**
	 * Constructor
	 */
	initialize: function(options)
	{
		// Set the options
		this.setOptions(options);
		
		// Load the targets
		this.$_columns = new Array();
		this.$_column_target = $(this.options.column_target);
		
		// Inject the columns
		var self = this;
		Object.each(this.options.conf.columns, function(column, index) {
			self.$_columns[index] = new Element('ul', {styles: {width: (100 / Object.keys(self.options.conf.columns).length).toInt() + '%'}});			
			self.$_column_target.adopt(self.$_columns[index]);
		});
		
		console.log('In edit mode: ' + this.options.edit);
	},
	
	trigger: function()
	{
		console.log('Tundra triggered, loading content');
		var self = this;
		
		// Fade out the "loading" spinner
		new Fx.Tween($('content-loading'))
		.start('opacity', 0)
		.chain(function() {
			$('content-loading').setStyle('display', 'none');
			this.callChain();
		})
		
		// Create the widgets
		.chain(function() {
			// Loop through the columns...
			Object.each(self.options.conf.columns, function(item, index){
			
				// Each widget...
				Object.each(item, function(widget) {
					var w = new TundraWidgetFactory(widget.type, self.$_columns[index], widget, self.options.edit);
					
					if(w.redrawAfter() != 0 && !w.inEditMode())
						setInterval(function() {w.render();} , w.redrawAfter() * 1000 * 60);
				});
			});
			
			this.callChain();
		})
		
		// Fade in the widgets
		.chain(function() {
			new Fx.Tween($('_target')).start('opacity', 1);
			
			this.callChain();
		})
		
		.chain(function() {
			new FaceTip($$('.tipped'));

			// Enable sorting if in edit mode
			if(self.options.edit)
			{
				// Set cursor to a scroll one so the widgets are visibly draggable
				$$('.title-bar').setStyle('cursor', 'all-scroll');
			
				// Enable sorting
				var sorting = new Sortables('#_target UL', {
					clone: true,
					revert: true,
					handle: '.title-bar',
					opacity: 0.7,
					onStart: function(element)
					{
						element.setStyle('opacity', 0.7);
					},
					
					onComplete: function(element)
					{
						element.setStyle('opacity', 1);
						
						var order = this.serialize();
						console.log(order);
					
						new Request({
							'url': '<?php echo site_url('helper/set_widget_order'); ?>',
							'noCache': true,
							
							'onSuccess': function(text)
							{
								console.log('Widget configuration saved');
								
								notifications.show({
									title: 'Tundra',
									message: 'Widget order saved'
								});
							},
							
							'onFailure': function(xhr)
							{
								console.log(xhr);
								alert("Couldn't save widget configuration!");
							}
						}).post({
							'order': order,
							'tab': _current_tab,
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'});
					}
				});
			}
		});
	}
});
 
/* End of file tundra.core.js */
/* Location: ./assets/scripts/tundra.core.js */