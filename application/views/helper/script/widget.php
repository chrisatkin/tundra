/**
 * Tundra Widget
 * 
 * @author		Chris Atkin
 * @link		http://chrisatk.in
 * @email		contact {at} chrisatk {dot} com
 * 
 * @file		tundra.core.widget.js
 * @version		1.0
 * @date		10/09/2011
 * 
 * Copyright (c) 2010 Chris Atkin. All rights reserved
 */
 
var TundraWidgetFactory = new Class({
	initialize: function(type, target, options, edit)
	{
		switch(type)
		{
			case 'TundraRssWidget': return new TundraRssWidget(target, options, edit); break;
			case 'TundraIframeWidget': return new TundraIframeWidget(target, options, edit); break;
			case 'TundraRedditBrowser': return new TundraRedditBrowser(target, options, edit); break;
			case 'TundraBbcFeed': return new TundraBbcFeed(target, options, edit); break;
			case 'TundraWelcomeWidget': return new TundraWelcomeWidget(target, options, false); break;
			
			default: console.log('Fatal error: cannot find widget of type ' + type); break;
		}
	}
}); 

var TundraWidget = new Class({
	Implements: Options,
	
	initialize: function(target, options, edit)
	{
		// Load options
		this.setOptions(options);
		this.edit = edit;
		
		//this.$_widget.set('html', '<div class="widget-loading"><?php echo get_image('loading.gif'); ?><br/>Standby...</div>');
		
		// Create elements
		this.$_widget = new Element('li', {'id': 'widget-' + options.id});												// Overarching container. Need this for dropshadows
		this.$_container = new Element('div', {'class': 'tundrawidget'}, 'top');		// The actual widget
		this.$_title_bar = new Element('div', {'class': 'title-bar'});					// The black titlebar
		this.$_widget_title = new Element('div', {'class': 'widget-title'});			// Containing the text
		this.$_widget_refreshes = new Element('div', {'class': 'widget-refreshes'});		// How often the widget updates
		this.$_content = new Element('div', {'class': 'widget-content'});				// The main content
		
		// Inject them
		//this.$_title_container.adopt(this.$_refreshes_time, 'top');
		this.$_title_bar.adopt(this.$_widget_title, 'top');
		if(!this.edit)
			this.$_title_bar.adopt(this.$_widget_refreshes, 'bottom');
		this.$_title_bar.adopt(new Element('div', {'class': 'clear'}));
		this.$_container.adopt(this.$_title_bar, 'top');
		this.$_container.adopt(this.$_content, 'bottom');
		this.$_widget.adopt(this.$_container, 'top');
		
		target.adopt(this.$_widget);
	},
	
	setTitle: function(title)
	{
		this.$_widget_title.set('html', title);
	},
	
	setRefreshTime: function(custom, time)
	{		
		if(time != 0)
			this.$_widget_refreshes.set('html', '<span class="tipped" tip="This widget updates every ' + time + ' minutes">Auto updates</span>');
	},
	
	setContent: function(elem)
	{
		this.$_content.empty();
		this.$_content.adopt(elem, 'top');
	},
	
	setContentHtml: function(html)
	{
		this.$_content.empty();
		this.$_content.set('html', html);
	},
	
	appendContentHtml: function(html)
	{
		this.$_content.set('html', this.$_content.get('html') + html);
	},
	
	setContainerClass: function(c)
	{
		this.$_container.addClass(c);
	},
	
	inEditMode: function()
	{
		return this.edit;
	},
	
	setLoading: function(message)
	{
		loading = new Element('div', {'class': 'widget-loading'});
		loading.set('html', '<?php echo get_image('loading.gif'); ?><br/>' + message + '...');
		
		this.setContent(loading, 'top');
	},
	
	loadSettings: function()
	{
		var self = this;
		
		new Request({
			'url': '<?php echo site_url('helper/widget_configuration/'); ?>/' + this.options.id,
			'method': 'get',
			'evalScripts': true,
			'noCache': true,
			'onSuccess': function(text) {
				self.setContentHtml(text);
				
				$('widget-cfg-' + self.options.id).addEvent('submit', function(evt) {
					evt.stop();
					console.log($('widget-cfg-' + self.options.id));
					
					new Request({
						url: '<?php echo site_url('helper/widget_configuration'); ?>',
						data: $('widget-cfg-' + self.options.id),
						onComplete: function(text) {
							console.log(text);
							self.render();
							
						notifications.show({
							title: 'Tundra',
							message: 'Widget configuration saved!'
						});
	
						}
					}).send();
				});
			},
			
			'onFailure': function(xhr) {
				//alert('Could not load configuration for the widget ' + self.options.title);
			}
		}).send();
	},
	
	redrawAfter: function()
	{
		return this.options.refresh;
	}
});

var TundraRssWidget = new Class({
	Extends: TundraWidget,
	
	initialize: function(target, options, edit)
	{
		this.parent(target, options, edit);
				
		console.log('TundraRssWidget loaded using feed ' + this.options.config.feed);
		
		this.setContainerClass('TundraRssWidget');
		this.setTitle('<a href="' + this.options.config.url + '" target="_blank">' + this.options.title + '</a>');
		this.setRefreshTime(false, this.options.refresh);
		this.render();
	},
	
	render: function()
	{
		console.log('Rendering widget "' + this.options.title + '"');
		
		if(this.edit)
		{
			this.loadSettings();
		}
		else
		{
			this.setLoading('Standby');
			this.loadRss();
		}
		
	},
	
	loadRss: function()
	{
		var self = this;
	
		new Request({
			'url': '<?php echo site_url('helper/rss_proxy'); ?>?url=' + this.options.config.feed + '&display=' + this.options.config.display,
			'method': 'get',
			'noCache': true,
			'headers': {'Content-Type': 'application/rss+xml'},
			
			'onSuccess': function(text)
			{
				self.setContentHtml(text);
			},
			
			'onFailure': function(xhr)
			{
				self.setContent('An error was encountered. Check the console for information.');
				console.log(xhr);
				
			}
		}).send();
	},
});

var TundraIframeWidget = new Class({
	Extends: TundraWidget,
	
	initialize: function(target, options, edit)
	{
		this.parent(target, options, edit);
		
		console.log('TundraIframeWidget loaded using source ' + this.options.config.src);
		
		this.setContainerClass('TundraIframeWidget');
		this.setRefreshTime(false, this.options.refresh);
		this.setTitle(this.options.title);
		this.render();
	},
	
	render: function()
	{
		this.setLoading('Standby');
	
		if(this.edit)
			this.loadSettings();
		else
			this.setContent(new Element('iframe', {'src': this.options.config.src, styles: {'height' : this.options.config.height}, 'scrolling': 'no'}));
	},
});

var TundraRedditBrowser = new Class({
	Extends: TundraWidget,
	
	initialize: function(target, options, edit)
	{
		this.parent(target, options, edit);
		
		console.log('TundraRedditBrowser loaded');
		
		this.setContainerClass('TundraRedditBrowser');
		this.setRefreshTime(false, this.options.refresh);
		this.setTitle(this.options.title);
		this.render();
	},
	
	render: function()
	{
		this.setLoading('Standby');
		
		var self = this;
	
		new Request.JSON({
			url: '<?php echo site_url('helper/json_proxy/?url=http:\/\/reddit.com/.json'); ?>',
			onSuccess: function(data)
			{
				self.setLoading('Rendering');
				
				console.log(data);
			
				Object.each(data.data.children, function(value, key) {
					// Create 
					var e = new Element('div', {'class': 'item'});
				});
					
				self.setContentHtml("Hello");
			}
		}).send();
	}
});

var TundraBbcFeed = new Class({
	Extends: TundraWidget,
	
	initialize: function(target, options, edit)
	{
		this.parent(target, options, edit);
		
		console.log('TundraBbcFeed loaded');
		
		this.setContainerClass('TundraBbcFeed');
		this.setRefreshTime(false, this.options.refresh);
		this.setTitle('<a href="http://bbc.co.uk/news" target="_blank">BBC News - UK Editon</a>');
		this.render();
	},
	
	render: function()
	{
		var self = this;
	
		this.setLoading('Loading BBC Feed');
		
		new Request({
			'url': '<?php echo site_url('helper/rss_proxy'); ?>?url=http://feeds.bbci.co.uk/news/rss.xml&display=7&preview=all',
			'method': 'get',
			'noCache': true,
			'headers': {'Content-Type': 'application/rss+xml'},
			
			'onSuccess': function(text)
			{
				self.setContentHtml('<div class="header"><?php echo get_image('bbc-news.gif'); ?></div>');
				self.appendContentHtml(text);
			},
			
			'onFailure': function(xhr)
			{
				self.setContent('An error was encountered. Check the console for information.');
				console.log(xhr);
				
			}
		}).send();

	}
});
 
var TundraWelcomeWidget = new Class({
	Extends: TundraWidget,
	
	initialize: function(target, options, edit)
	{
		this.parent(target, options, edit);
		
		console.log('TundraWelcomeWidget loaded');
		
		this.setContainerClass('TundraWelcomeWidget');
		this.setRefreshTime(false, 0);
		this.setTitle('Welcome to Tundra');
		this.render();
	},
	
	render: function()
	{
		new Request({
			'url': '<?php echo site_url('helper/get_widget_html/welcome'); ?>',
			'onSuccess': function(text)
			{
				this.setContentHtml(text);
			}.bind(this),
			'onFailure': function(xhr)
			{
				console.log(xhr);
				this.setContentHtml('Could not load the HTML for the welcome widget.<br><br>What you should do: try again and if the issue persists, file a bug report at http://bugs.projects.chrisatk.in');
			}.bind(this)
		}).send();
	}
});
 
/* End of file tundra.core.widget.js */
/* Location: ./_assets/scripts/tundra.core.widget.js */