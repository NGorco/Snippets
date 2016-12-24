<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arFilter = [ 'IBLOCK_ID' => 2 ];

if ( ! empty( $arParams['PRODUCTS_IDS'] ) ) {

	$arFilter['ID'] = $arParams['PRODUCTS_IDS'];
} else {

	$arFilter['SECTION_ID'] = $arParams['SECTION_ID'];
}

$arRelProducts = CIBlockElement::GetList([], $arFilter, false, [ 'nTopCount' => $arParams['PRODS_CNT'] ] );

$arResult['prods'] = [];
$arResult['prods_popup'] = [];

while ( $prod = $arRelProducts->GetNext() ) {

	$offers = CIBlockElement::GetList([], ['IBLOCK_ID' => 3, 'PROPERTY_31' => $prod['ID']], false, [], ['ID']);


	if ( $offers->result->num_rows > 1 ) {

		$arResult['prods_popup'][ $prod['ID'] ] = CHelper::get_product_popup_array( $prod['ID'] );
	}

	$prices = CHelper::getOffersPrices( $prod['ID'], 'min' );

	$prod['OFFERS_PRICES'] = $prices;
	$arResult['prods'][] = $prod;
}

$this->IncludeComponentTemplate();
?>