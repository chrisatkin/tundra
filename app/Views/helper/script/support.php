/**
 * Tundra Support (Phase 6 rewrite -- vanilla JS, no MooTools)
 * Tooltips, toast notifications and the clock.
 *
 * Replaces assets/scripts/tundra.support.js for the CI4 dashboard only --
 * that file is untouched since the CI2 app (still running under MAMP
 * Apache) still depends on its MooTools-based FaceTip/Notimoo classes.
 */

/* Clock
---------------------------------- */
function update_clock(elementId)
{
	var d = new Date();

	var hours = d.getHours(), min = d.getMinutes(), sec = d.getSeconds();
	var am_pm = hours < 12 ? 'AM' : 'PM';

	hours = (hours > 12) ? hours - 12 : hours;
	hours = (hours == 0) ? 12 : hours;

	var format = function(s) {
		return (s < 10 ? '0' : '') + s;
	};

	document.getElementById(elementId).innerHTML =
		'The time is <strong>' + hours + ':' + format(min) + ':' + format(sec) + ' ' + am_pm + '</strong>';

	setTimeout(function() { update_clock(elementId); }, 1000);
}

/* Tooltips (FaceTip replacement)
---------------------------------- */
function initTooltips(selector)
{
	document.querySelectorAll(selector || '.tipped').forEach(function(el) {
		if (el.dataset.tundraTipBound) return;
		el.dataset.tundraTipBound = 'true';

		var tip = null;

		el.addEventListener('mouseenter', function() {
			var text = el.getAttribute('tip');
			if (!text) return;

			var rect = el.getBoundingClientRect();

			tip = document.createElement('div');
			tip.className = 'facetip';
			tip.textContent = text;
			tip.style.position = 'absolute';
			tip.style.left = (rect.left + window.scrollX) + 'px';

			var arrow = document.createElement('div');
			arrow.className = 'facetip-arrow-down';
			tip.appendChild(arrow);

			document.body.appendChild(tip);

			var tipHeight = tip.getBoundingClientRect().height;
			var arrowBorder = parseInt(getComputedStyle(arrow).borderTopWidth, 10) || 0;
			arrow.style.top = tipHeight + 'px';
			tip.style.top = (rect.top + window.scrollY - tipHeight - arrowBorder) + 'px';
		});

		el.addEventListener('mouseleave', function() {
			if (tip) {
				tip.remove();
				tip = null;
			}
		});
	});
}

/* Toast notifications (Notimoo replacement)
---------------------------------- */
var notifications = {
	_active: [],

	show: function(options)
	{
		var el = document.createElement('div');
		el.className = 'notimoo' + (options.customClass ? ' ' + options.customClass : '');
		el.style.top = '10px';
		el.style.right = '10px';
		if (options.width) el.style.width = options.width + 'px';

		var title = document.createElement('span');
		title.className = 'title';
		title.innerHTML = options.title || '';

		var message = document.createElement('div');
		message.className = 'message';
		message.innerHTML = options.message || '';

		el.appendChild(title);
		el.appendChild(message);

		var self = this;
		var close = function() {
			el.style.opacity = '0';
			setTimeout(function() {
				el.remove();
				self._active = self._active.filter(function(e) { return e !== el; });
				self._reflow();
			}, 300);
		};

		el.addEventListener('click', close);
		el.style.transition = 'opacity 0.3s, top 0.3s';
		el.style.opacity = '0';

		document.body.appendChild(el);
		this._active.push(el);
		this._reflow();

		// Force layout so the opacity transition actually runs.
		void el.offsetHeight;
		el.style.opacity = '0.95';

		if (!options.sticky) {
			setTimeout(close, options.visibleTime || 5000);
		}
	},

	_reflow: function()
	{
		var top = 10;
		this._active.forEach(function(el) {
			el.style.top = top + 'px';
			top += el.getBoundingClientRect().height + 5;
		});
	}
};
