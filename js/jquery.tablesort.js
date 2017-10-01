/*!
 * Author: Tony Brix, me@tonybrix.info
 * License: MIT 
 * Description: Sort tables by clicking on headers
 */
;
(function ($, undefined) {
	"use strict";
	var pluginName = "tablesort";
	$[pluginName] = function (el, options) {
		var plugin;
		if ($(el).data(pluginName)) {
			plugin = $(el).data(pluginName);
		} else {
			// To avoid scope issues, use 'plugin' instead of 'this'
			// to reference this class from internal events and functions.
			plugin = this;

			// Access to jQuery and DOM versions of element
			plugin.$table = $(el);

			// Add a reverse reference to the DOM object
			plugin.$table.data(pluginName, plugin);
		}

		if (typeof (options) === "object" || options === undefined) {
			plugin._init(options);
		} else if (typeof (options) === "string" && options.substring(0, 1) !== "_" && typeof plugin[options] === "function") {
			plugin[options].apply(plugin, Array.prototype.slice.call(arguments, 1));
		} else {
			throw "Invalid Arguments";
		}
	};

	var pluginPrototype = {
		_defaults: {
			//TODO: PUT DEFAULT OPTIONS HERE
		},
		_init: function (options) {
			var plugin = this;

			if (plugin.initialized) {
				throw "Already Initialized";
			}

			plugin.options = $.extend({}, plugin._defaults, options);

			plugin.$thead = $("thead", plugin.$table);
			plugin.$tbody = $("tbody", plugin.$table);
			plugin.$ths = $("tr th", plugin.$thead);
			plugin.$tds = $("tr td", plugin.$tbody);
			plugin.$rows = $("tr", plugin.$tbody);

			plugin.$table.addClass("tablesort");
			plugin.$ths.each(function (i) {
				var $this = $(this);
				var column = "tablesort-" + i;
				$this.addClass(column).data({
					column: column
				});
				plugin.$tds.filter(":nth-child(" + (i + 1) + ")").addClass(column);
			}).wrapInner("<span class='tablesort-label' />").append("<span class='tablesort-arrows'><div><span class='tablesort-sortdesc'>&#9650;</span><span class='tablesort-sortasc'>&#9660;</span></div></span>").wrapInner("<div class='tablesort-th' />").on("click.tablesort", function (e) {
				var $this = $(this);
				if ($this.hasClass("sortable")) {
					var $target = $(e.target);
					//TODO: if ctrl key down then add sort
					var sort = plugin.$thead.data().sort || " ";
					var current = sort.split(" ");
					var column = $this.data().column;
					var direction = "asc";
					var sorttype = $this.data().sorttype || "string";
					if ($target.hasClass("tablesort-sortdesc") || (current[0] === column && current[1] === "asc" && !$target.hasClass("tablesort-sortasc"))) {
						direction = "desc";
					}
					if (sort === column + " " + direction) {
						return;
					}
					plugin.$thead.data({sort: column + " " + direction});
					if (current[0]) {
						$("." + current[0]).removeClass("tablesort-" + current[1]);
					}
					$("." + column).addClass("tablesort-" + direction);
					//sort
					var sortdir = (direction === "asc" ? -1 : 1);
					plugin.$rows.sort(function (a, b) {
						var av, bv;
						switch (sorttype) {
							case "date":
								av = new Date($("." + column, a).text());
								bv = new Date($("." + column, b).text());
								break;
							case "number":
								av = new Number($("." + column, a).text().replace(/,/g, ""));
								bv = new Number($("." + column, b).text().replace(/,/g, ""));
								break;
							default:
								av = $("." + column, a).text().toLowerCase();
								bv = $("." + column, b).text().toLowerCase();
								break;
						}
						if (av < bv) {
							return sortdir;
						} else if (av > bv) {
							return -sortdir;
						} else {
							return 0;
						}
					}).appendTo(plugin.$tbody);
				}
			});

			plugin.initialized = true;
		},
		destroy: function () {
			var plugin = this;

			plugin.$ths.off(".tablesort").each(function (i) {
				var $this = $(this);
				var column = "tablesort-" + i;
				$this.removeClass(column).unwrapInner("span.tablesort-th").unwrapInner("span.tablesort-label").find(".tablesort-arrows").remove();
				delete $this.data().column;
				plugin.$tds.filter(":nth-child(" + (i + 1) + ")").removeClass(column);
			});

			delete plugin.$table.data()[pluginName];
		}
	};

	$[pluginName].prototype = pluginPrototype;

	$.fn[pluginName] = function (options) {
		return this.each(function () {
			(new $[pluginName](this, options));
		});
	};

	$(function () {
		var $style = $("<style class='" + pluginName + "-stylesheet'>" +
				".tablesort-arrows{" +
				"display: none;" +
				"}" +
				".sortable{" +
				"cursor: pointer;" +
				"}" +
				".sortable .tablesort-th{" +
				"display: table;" +
				"width: 100%;" +
				"}" +
				".sortable .tablesort-arrows{" +
				"display: table-cell;" +
				"width: 1.1em;" +
				"vertical-align: middle;" +
				"}" +
				".sortable .tablesort-arrows div{" +
				"position: relative;" +
				"width: 1.1em;" +
				"min-height: 2.2em;" +
				"}" +
				".sortable .tablesort-label{" +
				"display: table-cell;" +
				"vertical-align: middle;" +
				"}" +
				".sortable .tablesort-sortdesc, .sortable .tablesort-sortasc{" +
				"position: absolute;" +
				"right: 0px;" +
				"color: #666;" +
				"}" +
				".sortable .tablesort-sortdesc{" +
				"top: 0px;" +
				"}" +
				".sortable .tablesort-sortasc{" +
				"top: 1em;" +
				"}" +
				".sortable.tablesort-desc .tablesort-sortdesc, .sortable.tablesort-asc .tablesort-sortasc{" +
				"color: #fff;" +
				"}" +
				"</style>");
		var $styles = $("head link[rel='stylesheet'], head style");
		if ($styles.length > 0) {
			$styles.eq(0).before($style);
		} else {
			$("head").append($style);
		}
	});

})(jQuery);

// unwrapInner function
// http://wowmotty.blogspot.com/2012/07/jquery-unwrapinner.html
jQuery.fn.extend({
	unwrapInner: function (selector) {
		return this.each(function () {
			var t = this,
					c = $(t).children(selector);
			if (c.length === 1) {
				c.contents().appendTo(t);
				c.remove();
			}
		});
	}
});
