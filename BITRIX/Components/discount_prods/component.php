<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arProducts = CIBlockElement::GetList( ['sort' => 'rand'], [ 'IBLOCK_ID' => 2 ], false, [ 'nTopCount' => $arParams['PRODS_CNT'] ],
[ 'NAME', 'ID', 'DETAIL_PAGE_URL', 'DETAIL_PICTURE' ] );

$arResult['prods'] = [];

while ( $prod = $arProducts->GetNext() ) {

	$arResult['prods'][] = $prod;
}

$arResult['prods_popup'] = [];
$arResult['prods'] = array_map(function($item){

    $item['OFFERS'] = CHelper::getOffersPrices( $item['ID'], 'min' );

    $offers = CIBlockElement::GetList([], ['IBLOCK_ID' => 3, 'PROPERTY_31' => $item['ID']], false, [], ['ID']);


	if ( $offers->result->num_rows > 1 ) {

		$arResult['prods_popup'][ $item['ID'] ] = CHelper::get_product_popup_array( $item['ID'] );
	}

	return $item;
}, $arResult['prods'] );

$this->IncludeComponentTemplate();
?>