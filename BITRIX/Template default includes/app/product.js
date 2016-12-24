/**
 * Product page scripts
 */
var Product = new (function() {

	var self = this;
	var local = {
		ID: '',
		cnt: 1,
		price: 0
	};

	/**
	 * Event listeners
	 */
	$(document).ready(function(){

		// For every listener his own closure to prevent vars mixing
		// Image gallery
		(function(){

			self.mainImg = $('#product-core-image');

			$(document).on('click', '#product-gallery a', function(e) {

				e.stopPropagation();
				e.preventDefault();

				self.mainImg.find('a').attr('href', this.href);
				self.mainImg.find('img').attr('src', this.href);
			});
		}());

		// Prod counter
		(function(){

			var input = $('#quantity-value');

			$(".quantity-increment").click(function(){

				local.cnt++;
				input.val(local.cnt);
			});

 			$(".quantity-decrement").click(function(){

				local.cnt--;

				if ( local.cnt < 1 ) {

					local.cnt = 1;
				}

				input.val(local.cnt);
			});
		}());

		// Offer changer
		(function(){

			$(document).on('click', '#offer-changer > div', function(e) {

				e.preventDefault();
				var item = $(this);

				self.changeOffer( item.index() );
			});
		}());

		self.changeOffer(0);
	});

	this.addToCart = function() {

		QuickCart.addItem( local.ID, local.cnt, local.price, local.name );
		return false;
	}

	this.setOffers = function( offers ) {

		this.offers = offers;
	}

	this.changeOffer = function( index ) {

		var offer = this.offers[ index ];

		local.ID = offer.ID;
		local.name = offer.NAME;
		local.price = parseFloat(offer.PRICE_DISCOUNT) > 0 ?
			parseFloat(offer.PRICE_DISCOUNT) :
			parseFloat(offer.PRICE);

		// Change prices on front
		$('#front-prices > div').hide().eq( index ).show();

		var images = offer.PROPERTIES.MORE_PHOTO.VALUE;

		if ( images.length ) {

			var gallery_container = $('#product-gallery').empty();

			for ( var i in images ) {

				var image = '<div class="image"><a href="' + images[i] + '" class="swipebox"><img src="' + images[i] + '"></a></div>';
				gallery_container.append( image );
			}

			self.mainImg.find('a').attr( 'href', images[0] );
			self.mainImg.find('img').attr( 'src', images[0] );
		}
	}
});