/**
 * Small cart singleton
 */

var QuickCart = new (function() {

	var inner = {};

	$(document).ready(function(){

		inner.prods_cnt = $("#minicart-count");
		inner.sum = $("#minicart-sum");
	});

	this.addItem = function(id, cnt, price, name) {

		if ( ! id || ! cnt || ! price || ! name ) throw 'no required field';

		$.post('/',

		{
			'AJAX_REQUEST': 'Y',
			'method': 'addItem',
			'params': {

				'ID': id,
				'CNT': cnt,
				'PRICE': price,
				'NAME': name
			}
		},
		function(result){

			try{
				var data = JSON.parse(result);
			} catch(e){}

			inner.prods_cnt.html(data.prods.cnt);
			inner.sum.html(data.prods.sum + ' р.');
		});
	}
});