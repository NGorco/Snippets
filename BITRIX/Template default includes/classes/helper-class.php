<?php


/**
* Custom helping functions
*/
class CHelper {

	static function inc_file( $path ) {

		global $APPLICATION;

		$APPLICATION->IncludeFile( $path, Array(), Array(
	    	"MODE"      => "html",
	    ));
	}

	static function min($price, $discount) {

		if ( $discount > 0 ) {

			return min($price, $discount);
		} else {

			return $price;
		}
	}

	static function price_format($price){

		if(is_numeric($price)){
			return number_format($price,0, '.', ' ');
		}else{
			return 0;
		}
	}

	static function get_product_popup_array( $prodID ) {

		$rsOffers = CIBlockElement::GetList( [], [

			'IBLOCK_ID' => 3, 'PROPERTY_31' => $prodID ],
			false,
			[],
			['PROPERTY_VALUE_ML', 'DETAIL_PICTURE', 'NAME', 'ID']);

		$offers = [];

		while ( $offer = $rsOffers->GetNext() ) {

			$price = CHelper::getPriceForUser( $offer['ID'], 'min' );

			if ( floatval( $price ) > 0 ) {

				$offer['PRICE'] = $price;
			} else {

				$offer['PRICE'] = 0;
			}

			$pic = CFile::GetFileArray( $offer['DETAIL_PICTURE'] );

			$offers[] = [
				'id' => $offer['ID'],
				'name' => $offer['NAME'],
				'price' => $offer['PRICE'],
				'picture' =>  $pic['SRC'],
				'ml' => intval( $offer['PROPERTY_VALUE_ML_VALUE'] )
			];
		}

		$prod = CIBlockElement::GetList( [], ['IBLOCK_ID' => 2, 'ID' => $prodID], false, [], ['ID', 'NAME', 'PROPERTY_DISP_WHAT_FOR']);

		$prod = $prod->GetNext();

		return [
			'name' => $prod['NAME'],
			'id' => $prod['ID'],
			'used_for' => $prod['PROPERTY_DISP_WHAT_FOR_VALUE'],
			'offers' => $offers
		];
	}

	static function titleCut($str,$len=1000){

		if(strlen($str)>$len){
			return mb_substr ($str,0,$len,"UTF-8")."...";
		}else{
			return $str;
		}
	}

	static function resizePic($pic, $width, $height, $attr_text = '', $returnRaw = false){

		if ( ! empty( $pic ) && ( int ) $width > 0 && ( int ) $height > 0 ) {

			$pic = CFile::ResizeImageGet( $pic, array( 'width' => $width, 'height' => $height ), BX_RESIZE_IMAGE_PROPORTIONAL, true );

			if ( $returnRaw ) {

				return $pic;
			} else {

				return "<img  src='" . $pic['src'] . "' " . $attr_text . "/>";
			}
		}

	}

	static function moveUploadFile($POSTITEM){

		$uploadfile = $_SERVER['DOCUMENT_ROOT']."/upload/temp/" . $POSTITEM['name'];
	    if (move_uploaded_file($POSTITEM['tmp_name'], $uploadfile)) {

	        return $uploadfile;
	    } else {
	    	return false;
	    }
	}

	static function get_curr_basket( $summaryValues = false ) {

		$arID = array();

		$arBasketItems = array();

		$dbBasketItems = CSaleBasket::GetList(
		    [ "NAME" => "ASC", "ID" => "ASC" ],
		    [ "FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID ],
		    false,
		    false,
		    [ "ID" ]
		);

		while ( $arItems = $dbBasketItems->Fetch() ) {

		    $arID[] = $arItems["ID"];
		}

		if ( ! empty( $arID ) ) {

			$dbBasketItems = CSaleBasket::GetList(
		    	[ "NAME" => "ASC", "ID" => "ASC" ],
		     	[ "ID" => $arID, "ORDER_ID" => "NULL" ],
		        false,
		        false,
		        [ "ID", "PRODUCT_ID", "QUANTITY", "PRICE", "NAME" ]
		    );

			while ( $arItems = $dbBasketItems->Fetch() ) {

			    $arBasketItems[] = $arItems;
			}

			if ( ! $summaryValues ) {

				return $arBasketItems;
			} else {

				$cnt = 0;
				$sum = 0;

				foreach( $arBasketItems as $prod ) {

					$tmp_cnt = ( float ) $prod['QUANTITY'];
					$cnt += $tmp_cnt;

					$tmp_sum = ( float ) $prod['PRICE'];

					$tmp_sum = $tmp_sum * $tmp_cnt;
					$sum += $tmp_sum;
				}

				return [ 'sum' => $sum, 'cnt' => $cnt ];
			}
		}
	}

	static function getOffersPrices( $prodID, $min = false ) {

		$rsOffers = CIBlockElement::GetList( [],
	     	[
	     		'IBLOCK_ID' => 3,
	     		'PROPERTY_31' => $prodID,
	            '>PROPERTY_PRICE' => 0,
	     	],
	     	false, [ 'nTopCount' => 100 ],
	     	[ 'ID' ]);

	    $offers = [];

	    while ( $offer = $rsOffers->GetNext() ) {

	    	$offers[] = CHelper::getPriceForUser( $offer['ID'], $min );
	    }

	    return $offers;
	}

	// Offer price for current user
	static function getPriceForUser( $ID, $min = false ) {

		$arProd = CIBlockElement::GetList( [], ['ID' => $ID, 'IBLOCK_ID' => 3 ], false, [], [ 'PROPERTY_PRICE', 'PROPERTY_SALE_PRICE', 'PROPERTY_PRICE_DISCOUNT', 'PROPERTY_SALE_PRICE_DISC' ] );

		$arProd = $arProd->GetNext();


		if ( ZG_USER_TYPE == 'SALE' ) {

			$prices = [
					'PRICE' => $arProd['PROPERTY_SALE_PRICE_VALUE'],
					'PRICE_DISCOUNT' => $arProd['PROPERTY_SALE_PRICE_DISC_VALUE']
				];
		} else {

			$prices = [
					'PRICE' => $arProd['PROPERTY_PRICE_VALUE'],
					'PRICE_DISCOUNT' => $arProd['PROPERTY_PRICE_DISCOUNT_VALUE']
				];
		}

		if ( $min == 'min' ) {

			return ( floatval( $prices['PRICE_DISCOUNT'] ) > 0) ? $prices['PRICE_DISCOUNT'] : $prices['PRICE'];
		} else {

			return $prices;
		}
	}

	static function change_catalog_sort_by() {

	    if ( $_SESSION['SORT_CATALOG_BY'] == 'PROPERTY_SORT_PRICE' ) {

	        $_SESSION['SORT_CATALOG_BY'] = 'PROPERTY_RATE';
	    } else {

	        $_SESSION['SORT_CATALOG_BY'] = 'PROPERTY_SORT_PRICE';
	    }
	}

	static function change_catalog_order() {

	    if ( $_SESSION['ORDER_CATALOG'] == 'ASC' ) {

	        $_SESSION['ORDER_CATALOG'] = 'DESC';
	    } else {

	        $_SESSION['ORDER_CATALOG'] = 'ASC';
	    }
	}

	static function catalog_order_sort_init() {

		if ( empty( $_SESSION['SORT_CATALOG_BY'] ) ) {

		    $_SESSION['SORT_CATALOG_BY'] = 'PROPERTY_SORT_PRICE';
		}

		if ( empty( $_SESSION['ORDER_CATALOG'] ) ) {

		    $_SESSION['ORDER_CATALOG'] = 'ASC';
		}

		if ( isset( $_GET['CATALOG_SORT'] ) ) {

		    self::change_catalog_sort_by();
		}

		if ( isset( $_GET['CATALOG_ORDER'] ) ) {

		    self::change_catalog_order();
		}
	}
}

?>