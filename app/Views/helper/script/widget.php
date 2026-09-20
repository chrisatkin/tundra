/**
 * Tundra Widget (Phase 6 rewrite -- vanilla JS, no MooTools)
 *
 * TundraRedditBrowser was dropped: it was already dead code in the CI2
 * original (no widget_type row ever used it, and its render() didn't
 * actually render anything -- just set the content to the string "Hello").
 */

function TundraWidgetFactory(type, target, options, edit)
{
	switch (type) {
		case 'TundraRssWidget': return new TundraRssWidget(target, options, edit);
		case 'TundraIframeWidget': return new TundraIframeWidget(target, options, edit);
		case 'TundraBbcFeed': return new TundraBbcFeed(target, options, edit);
		case 'TundraWelcomeWidget': return new TundraWelcomeWidget(target, options, false);

		default: console.log('Fatal error: cannot find widget of type ' + type);
	}
}

class TundraWidget
{
	constructor(target, options, edit)
	{
		this.options = options;
		this.edit = edit;

		this.$widget = document.createElement('li');
		this.$widget.id = 'widget-' + options.id;

		this.$container = document.createElement('div');
		this.$container.className = 'tundrawidget';

		this.$titleBar = document.createElement('div');
		this.$titleBar.className = 'title-bar';

		this.$widgetTitle = document.createElement('div');
		this.$widgetTitle.className = 'widget-title';

		this.$widgetRefreshes = document.createElement('div');
		this.$widgetRefreshes.className = 'widget-refreshes';

		this.$content = document.createElement('div');
		this.$content.className = 'widget-content';

		this.$titleBar.appendChild(this.$widgetTitle);
		if (!this.edit) this.$titleBar.appendChild(this.$widgetRefreshes);

		var clear = document.createElement('div');
		clear.className = 'clear';
		this.$titleBar.appendChild(clear);

		this.$container.appendChild(this.$titleBar);
		this.$container.appendChild(this.$content);
		this.$widget.appendChild(this.$container);

		target.appendChild(this.$widget);
	}

	setTitle(title)
	{
		this.$widgetTitle.innerHTML = title;
	}

	setRefreshTime(time)
	{
		if (time != 0) {
			this.$widgetRefreshes.innerHTML =
				'<span class="tipped" tip="This widget updates every ' + time + ' minutes">Auto updates</span>';
		}
	}

	setContent(elem)
	{
		this.$content.innerHTML = '';
		this.$content.appendChild(elem);
	}

	setContentHtml(html)
	{
		this.$content.innerHTML = html;
	}

	appendContentHtml(html)
	{
		this.$content.innerHTML += html;
	}

	setContainerClass(c)
	{
		this.$container.classList.add(c);
	}

	inEditMode()
	{
		return this.edit;
	}

	setLoading(message)
	{
		var loading = document.createElement('div');
		loading.className = 'widget-loading';
		loading.innerHTML = '<?php echo get_image('loading.gif'); ?><br/>' + message + '...';

		this.setContent(loading);
	}

	loadSettings()
	{
		var self = this;

		fetch('<?php echo site_url('helper/widget_configuration/'); ?>/' + this.options.id)
			.then(function(res) { return res.text(); })
			.then(function(text) {
				self.setContentHtml(text);

				document.getElementById('widget-cfg-' + self.options.id).addEventListener('submit', function(evt) {
					evt.preventDefault();

					fetch('<?php echo site_url('helper/widget_configuration'); ?>', {
						method: 'POST',
						body: new FormData(evt.target)
					})
					.then(function(res) { return res.text(); })
					.then(function(text) {
						console.log(text);
						self.render();

						notifications.show({ title: 'Tundra', message: 'Widget configuration saved!' });
					});
				});
			})
			.catch(function(err) {
				console.log(err);
			});
	}

	redrawAfter()
	{
		return this.options.refresh;
	}
}

class TundraRssWidget extends TundraWidget
{
	constructor(target, options, edit)
	{
		super(target, options, edit);

		console.log('TundraRssWidget loaded using feed ' + this.options.config.feed);

		this.setContainerClass('TundraRssWidget');
		this.setTitle('<a href="' + this.options.config.url + '" target="_blank">' + this.options.title + '</a>');
		this.setRefreshTime(this.options.refresh);
		this.render();
	}

	render()
	{
		console.log('Rendering widget "' + this.options.title + '"');

		if (this.edit) {
			this.loadSettings();
		} else {
			this.setLoading('Standby');
			this.loadRss();
		}
	}

	loadRss()
	{
		var self = this;

		fetch('<?php echo site_url('helper/rss_proxy'); ?>?url=' + this.options.config.feed + '&display=' + this.options.config.display)
			.then(function(res) { return res.text(); })
			.then(function(text) { self.setContentHtml(text); })
			.catch(function(err) {
				self.setContent(document.createTextNode('An error was encountered. Check the console for information.'));
				console.log(err);
			});
	}
}

class TundraIframeWidget extends TundraWidget
{
	constructor(target, options, edit)
	{
		super(target, options, edit);

		console.log('TundraIframeWidget loaded using source ' + this.options.config.src);

		this.setContainerClass('TundraIframeWidget');
		this.setRefreshTime(this.options.refresh);
		this.setTitle(this.options.title);
		this.render();
	}

	render()
	{
		this.setLoading('Standby');

		if (this.edit) {
			this.loadSettings();
		} else {
			var iframe = document.createElement('iframe');
			iframe.src = this.options.config.src;
			iframe.style.height = this.options.config.height;
			iframe.scrolling = 'no';
			this.setContent(iframe);
		}
	}
}

class TundraBbcFeed extends TundraWidget
{
	constructor(target, options, edit)
	{
		super(target, options, edit);

		console.log('TundraBbcFeed loaded');

		this.setContainerClass('TundraBbcFeed');
		this.setRefreshTime(this.options.refresh);
		this.setTitle('<a href="http://bbc.co.uk/news" target="_blank">BBC News - UK Editon</a>');
		this.render();
	}

	render()
	{
		var self = this;

		this.setLoading('Loading BBC Feed');

		fetch('<?php echo site_url('helper/rss_proxy'); ?>?url=http://feeds.bbci.co.uk/news/rss.xml&display=7&preview=all')
			.then(function(res) { return res.text(); })
			.then(function(text) {
				self.setContentHtml('<div class="header"><?php echo get_image('bbc-news.gif'); ?></div>');
				self.appendContentHtml(text);
			})
			.catch(function(err) {
				self.setContent(document.createTextNode('An error was encountered. Check the console for information.'));
				console.log(err);
			});
	}
}

class TundraWelcomeWidget extends TundraWidget
{
	constructor(target, options, edit)
	{
		super(target, options, edit);

		console.log('TundraWelcomeWidget loaded');

		this.setContainerClass('TundraWelcomeWidget');
		this.setRefreshTime(0);
		this.setTitle('Welcome to Tundra');
		this.render();
	}

	render()
	{
		var self = this;

		fetch('<?php echo site_url('helper/get_widget_html/welcome'); ?>')
			.then(function(res) { return res.text(); })
			.then(function(text) { self.setContentHtml(text); })
			.catch(function(err) {
				console.log(err);
				self.setContentHtml('Could not load the HTML for the welcome widget.<br><br>What you should do: try again and if the issue persists, file a bug report at http://bugs.projects.chrisatk.in');
			});
	}
}
