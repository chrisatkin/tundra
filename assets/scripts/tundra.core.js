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
			self.$_columns[index] = new Element('td', {styles: {width: (100 / Object.keys(self.options.conf.columns).length).toInt() + '%'}, 'align': 'center'});			
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
					
					if(w.redrawAfter() != 0)
						setInterval(function() {w.render();} , w.redrawAfter() * 1000 * 60);
				});
			});
			
			this.callChain();
		})
		
		// Fade in the widgets
		.chain(function() {
			$('content-table').setStyle('display', 'table');
			new Fx.Tween($('content-table')).start('opacity', 1);
			
			this.callChain();
		})
		
		.chain(function() {
			new FaceTip($$('.tipped'));
		});
	}
});
 
/* End of file tundra.core.js */
/* Location: ./assets/scripts/tundra.core.js */