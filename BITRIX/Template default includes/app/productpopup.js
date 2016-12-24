/**
 * Product list scripts (to perform popup product buying)
 */
var ProductPopup = new (function() {

	this.popupData = {};
	this.templateString = '';
	this.outputEl = {};
	this.template = '#product-popup-template';
	this.output = '#product-card1';

	var allProducts = {};

	this.addData = function( data ) {

		allProducts = _.extend(allProducts, data);
	}

	this.show = function( id ) {

		if ( allProducts[ id ] ) {

			this.load( allProducts[ id ] );
		} else {

			console.warn('No product with given ID');
		}
	}

	this.load = function( data ) {

		if ( ! data ) return false;

		this.popupData = data;
		this.templateString = $(this.template).html();
		this.outputEl = $(this.output);

		this.setMainProduct( this.popupData.offers[0].id );
		this.render();

		$.fancybox(this.outputEl);
	}

	this.getOfferById = function( id ) {

		return this.popupData.offers.filter(function(item) {

			if (item.id == id) return item;
		}).shift();
	}

	this.render = function() {

		var html = _.template(this.templateString, this.popupData);
		this.outputEl.html(html);
	}

	this.setMainProduct = function( id ) {


		this.popupData.offers.map(function(item) {

			if ( item.id == id ) {

				item.active = true;
			} else {

				item.active = false;
			}

			return item;
		});

		this.popupData.main = this.getOfferById( id );
		this.render();
	}

	this.addToCart = function() {

		QuickCart.addItem(

			this.popupData.main.id,
			parseInt($('#product-card1 #quantity-value').val()),
			this.popupData.main.price,
			this.popupData.main.name
		);

		this.destroy();
	}

	this.destroy = function() {

		this.popupData = {};
		this.templateString = '';
		this.outputEl = {};

		$.fancybox.close();
	}
});

/** Lame code for quantity */
$(document).ready(function(){

	$(document).on('click', '#product-card1 .quantity-increment', function(){

		var qnt = $(this).closest('.quantity').find('input').eq(0);
		qnt.val( parseInt(qnt.val()) + 1 );
	});

	$(document).on('click', '#product-card1 .quantity-decrement', function(){

		var qnt = $(this).closest('.quantity').find('input').eq(0);

		if ( parseInt(qnt.val()) == 1 ) {

			qnt.val(1);
		} else {

			qnt.val( parseInt(qnt.val()) - 1 );
		}
	});
});