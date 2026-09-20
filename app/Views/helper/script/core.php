/**
 * Tundra Core (Phase 6 rewrite -- vanilla JS, no MooTools)
 * Loads and manages widgets. Drag-and-drop reordering uses SortableJS
 * (assets/scripts/Sortable.min.js) in place of MooTools' Sortables.
 */

class Tundra
{
	constructor(options)
	{
		this.conf = options.conf;
		this.edit = options.edit;
		this.columnTarget = document.getElementById('_target');
		this.columns = [];

		var numColumns = Object.keys(this.conf.columns).length;

		Object.keys(this.conf.columns).forEach((index) => {
			var ul = document.createElement('ul');
			ul.style.width = (100 / numColumns) + '%';
			this.columns[index] = ul;
			this.columnTarget.appendChild(ul);
		});

		console.log('In edit mode: ' + this.edit);
	}

	trigger()
	{
		console.log('Tundra triggered, loading content');

		var loading = document.getElementById('content-loading');
		loading.style.transition = 'opacity 0.3s';
		loading.style.opacity = '0';

		setTimeout(() => {
			loading.style.display = 'none';

			// Create the widgets
			Object.keys(this.conf.columns).forEach((index) => {
				this.conf.columns[index].forEach((widget) => {
					var w = TundraWidgetFactory(widget.type, this.columns[index], widget, this.edit);

					if (w.redrawAfter() != 0 && !w.inEditMode()) {
						setInterval(function() { w.render(); }, w.redrawAfter() * 1000 * 60);
					}
				});
			});

			// Fade in the widgets
			this.columnTarget.style.transition = 'opacity 0.3s';
			this.columnTarget.style.opacity = '1';

			initTooltips('.tipped');

			// Enable sorting if in edit mode
			if (this.edit) {
				document.querySelectorAll('.title-bar').forEach(function(el) {
					el.style.cursor = 'all-scroll';
				});

				this.columns.forEach((ul) => {
					new Sortable(ul, {
						group: 'tundra-columns',
						handle: '.title-bar',
						animation: 150,
						onEnd: () => this.saveOrder()
					});
				});
			}
		}, 300);
	}

	saveOrder()
	{
		var order = {};
		this.columns.forEach(function(ul, index) {
			order[index] = Array.from(ul.children).map(function(li) { return li.id; });
		});

		console.log(order);

		var formData = new FormData();
		Object.keys(order).forEach(function(col) {
			order[col].forEach(function(id) { formData.append('order[' + col + '][]', id); });
		});
		formData.append('tab', _current_tab);

		fetch('<?php echo site_url('helper/set_widget_order'); ?>', { method: 'POST', body: formData })
			.then(function(res) {
				if (!res.ok) throw new Error('HTTP ' + res.status);

				console.log('Widget configuration saved');
				notifications.show({ title: 'Tundra', message: 'Widget order saved' });
			})
			.catch(function(err) {
				console.log(err);
				alert("Couldn't save widget configuration!");
			});
	}
}
