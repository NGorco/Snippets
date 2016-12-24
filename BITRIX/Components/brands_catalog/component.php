<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$rsBrand = CIBlockElement::GetList(
	[],
	[
		'IBLOCK_ID' => $arParams['BRAND_IBLOCK_ID'],
		'CODE' => $arParams['BRAND_CODE']
	]
);

$brand = $rsBrand->GetNext();


$rsProds = CIBlockElement::GetList(
	[],
	[
		'IBLOCK_ID' => $arParams['PRODS_IBLOCK_ID'],
		$arParams['BRAND_PROPERTY_LINK'] => $brand['ID']
	],
	false,
	['nPageSize' => $arParams['PRODUCTS_PER_PAGE']],
	$arParams['FIELDS_SELECT_PRODUCT']
);

$arResult['NAV_STRING'] = $rsProds->GetPageNavStringEx(
	$navComponentObject,
	"",
	$arParams["PAGER_TEMPLATE"]
);

$arResult['PRODS'] = [];

while( $prod = $rsProds->GetNext() ) {

	if ( $arParams['USE_OFFERS'] == 'Y' ) {

		$rsOffers = CIBlockElement::GetList(
			[],
			['IBLOCK_ID' => $arParams['OFFERS_IBLOCK_ID'], $arParams['OFFERS_PROPERTY_LINK'] => $prod['ID']],
			false,
			[],
			$arParams['FIELDS_SELECT_OFFER']
		);

		while ( $offer = $rsOffers->GetNext() ) {

			$prod['OFFERS'][] = $offer;
		}
	}

	$arResult['PRODS'][] = $prod;
}

$this->IncludeComponentTemplate();