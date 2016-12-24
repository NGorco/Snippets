/**
 * Common js scripts for all site
 */

var Common = new (function(){

	this.phoneCallback =  function(form) {

		$.post('/', {
			AJAX_REQUEST: 'Y',
			method: 'phoneCallback',
			params:{
				name: form.elements.formName.value,
				phone: form.elements.formPhone.value
			}
		})
		.done(function(){

			var notice = jQuery('<br><br><br><p>Уведомление доставлено! С Вами скоро свяжутся наши менеджеры</p>');
			jQuery(form).find('.button').after(notice);

			setTimeout(function(){

				jQuery('.fancybox-close').click();
				notice.remove();
				form.elements.formName.value = '';
				form.elements.formPhone.value = '';
			}, 5000);
		});
	};

	this.logout = function() {

		$.post('/', {

			AJAX_REQUEST: 'Y',
			method: 'logout'
		}, 'json').
		done(function(data) {

			try{ var data = JSON.parse(data);} catch(e){}

			if ( data.status == true ) {

				window.location.reload();
			}
		});
	}
});