/**
 * Registration script
 */
var Register = new (function(){

	var self = this;

	$(document).ready(function(){

		$('#ooo, #fiz, #ur').submit(function(e){

			e.preventDefault();
			self.register(this);
		});
	});

	this.register = function( form ) {

		var fields = {};

		Object.getOwnPropertyNames(form.elements).forEach(function(i){

			if (form.elements.hasOwnProperty( i ) && isNaN(parseInt(i)) ) {

				fields[ i ] = form.elements[i].value;
			}
		});

		$.post('/', {

			AJAX_REQUEST: 'Y',
			method: 'registerUser',
			params: {
				fields: fields
			}
		},
		function(result){

			try{ var result = JSON.parse( result );}
			catch(e){}

			if ( parseInt(result.status) > 0 ) {

				window.location.href = '/';
			} else {

				alert( result.error_message );
			}
		});
	}
});