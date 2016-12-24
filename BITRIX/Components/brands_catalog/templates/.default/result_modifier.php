<?

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

$arResult['POPUP_PRODUCTS'] = array();

$arResult['PRODS'] = array_map( function( $item ) {

	$offers = [];

	foreach ( $item['OFFERS'] as $offer ) {

		$price = CHelper::getPriceForUser( $offer['ID'], 'min' );

		if ( floatval( $price ) > 0 ) {

			$offer['PRICE'] = $price;
		} else {

			$offer['PRICE'] = 0;
		}

		$offers[] = $offer;
	}

	$item['OFFERS'] = $offers;

	return $item;
}, $arResult['PRODS'] );


foreach( $arResult['PRODS'] as $item ) {

	if (  count( $item['OFFERS'] ) > 1 ) {

	$arResult['POPUP_PRODUCTS'][ $item['ID'] ] = CHelper::get_product_popup_array( $item['ID'] );
	}
}