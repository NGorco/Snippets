/**
 * Vanilla JS helpers
 */
'use strict';
(function() {

	var $h = new (function() {

		/** Simple DOM query */
		function q(query, query_string) {

			if ( typeof(query) == 'string' ) {

				var out = document.querySelectorAll(query);
				return Array.prototype.slice.call(out);
			} else {

				var out = query.querySelectorAll(query_string);
				return Array.prototype.slice.call(out);
			}
		}

		/** common AJAX function */
		var ajax = function(url,data, success, error, type, json) {

			if ( ! error ) error = function(){};
			if ( ! success ) success = function(){};

			var query = [];

			for (var key in data) {

				query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
			}

			query = query.join('&');

			type = type.toLocaleLowerCase() == 'post' ? 'POST' : 'GET';

			var req = new XMLHttpRequest();
			req.open(type, type == 'GET' ? url += '?' + query : url, true);
			if ( type == 'POST' ) {

				req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			}

			req.onreadystatechange = function () {

				if (req.readyState == 4) {

					if (req.status == 200) {

						success(req.responseText, req);
					} else {

						error(req);
					}
				}
			};

			req.onerror = function() {

				error(Error("network error"), req);
			};

			if ( type == 'POST' ) {

				req.send(query);
			} else {

				req.send();
			}
		};

		q.on = function( el, event, callback) {

			el = document.querySelectorAll(el);
			el = Array.prototype.slice.call(el);

			if ( el.length == 0 ) {

				console.warn('No DOM nodes');
				return false;
			}

			el.forEach(function(item) {

				item.addEventListener(event, callback);
			});

			return this;
		}

		q.delegate = function(el, child, event, callback) {

			var elems = document.querySelectorAll(el);
			elems = Array.prototype.slice.call(elems);

			if ( elems.length == 0 ) {

				console.warn('No DOM nodes');
				return false;
			}

			child.split(',').forEach(function(childSelector) {

				elems.forEach(function(item) {

					item.addEventListener(event, function(e) {

						var target = e.target;

						while ( target != item ) {

							if ( target.matches(childSelector) ) {

								callback.call(target, e);
								return;
							}

							target = target.parentElement;
						}
					});
				});
			});

			return this;
		}

		q.post = function(url, data, success, error, json) {

			json = json == undefined || json == true ? true : false;

			ajax(
				url,
				data,
				success,
				error,
				'post',
				json
			);

			return this;
		}

		q.get = function(url, data, success, error, json) {

			json = json == undefined || json == true ? true : false;

			return ajax(
				url,
				data,
				success,
				error,
				'get',
				json
			);

			return this;
		}

		return q;
	});

	if ( ! window.$h ) {

		window.$h = $h;
	}

	if ( ! window.$$h ) {

		window.$$h = function(query) {

			return document.querySelector(query);
		}
	}
}());

/**
 * POLYFILLS FOR COOL STUFF
 */

// Matches
if (!Element.prototype.matches) {
    Element.prototype.matches =
        Element.prototype.matchesSelector ||
        Element.prototype.mozMatchesSelector ||
        Element.prototype.msMatchesSelector ||
        Element.prototype.oMatchesSelector ||
        Element.prototype.webkitMatchesSelector ||
        function(s) {
            var matches = (this.document || this.ownerDocument).querySelectorAll(s),
                i = matches.length;
            while (--i >= 0 && matches.item(i) !== this) {}
            return i > -1;
        };
}
// Closest
(function(e){
 e.closest = e.closest || function(css){
   var node = this;

   while (node) {
      if (node.matches(css)) return node;
      else node = node.parentElement;
   }
   return null;
 }
})(Element.prototype);