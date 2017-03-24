/**
 * Moduleriser library
 */

'use strict';

(function() {

	function moduleriser(options) {

		if ( typeof options == 'string' ) {

			var moduleLoadEvent = options;
		} else {

			var moduleLoadEvent = options.moduleLoadEvent;
		}

		var modulesId = options.modulesId || 'moduleId', // module identifier
			functionsPrefix = options.methods || 'methods', // methods prefix
			inheritanceParent = options.inheritanceParent || undefined, // To inherit from some class
			modules = {};

		if ( moduleLoadEvent ) {

			setTimeout(function(){

				document.dispatchEvent(new CustomEvent(moduleLoadEvent, {

					detail: module.loadComponent
				}));
			}, 0);
		}

		return modules;
	}

	moduleriser.prototype.loadComponent = function(dataObj) {

		if ( ! modulesId in dataObj ) return false;

		if ( dataObj[modulesId] in this ) {

			console.warn('Property constructor <' + dataObj[modulesId] + '> already exists!');
			return false;
		}

		var newClassConstructor = function(options) {

			Object.assign(this, options);

			if ( typeof inheritanceParent == 'function' ) {
				
				inheritanceParent.call(this, options);
			}
		}

		var fn;
		eval("fn = function " + dataObj[modulesId] + "(options){newClassConstructor.call(this, options)}");
		/**
		 * like fn = function modulesId(options)...
		 */

		this[ dataObj[modulesId] ] = fn;

		if ( inheritanceParent && inheritanceParent.prototype ) {

			fn.prototype = Object.create(inheritanceParent.prototype);
		}

		Object.assign(fn.prototype, dataObj); // Basic Component methods

		if ( dataObj[functionsPrefix] ) {

			Object.assign(fn.prototype, dataObj[functionsPrefix]); // Basic Component methods
			delete dataObj[functionsPrefix];
		}
	}

	window.moduleriser = moduleriser;
})();
