<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


$arProducts = CIBlockElement::GetList(
	[],
	[ 'IBLOCK_ID' => 4 ],
	false,
	[ 'nTopCount' => $arParams['PRODS_CNT'] ],
	[ 'DETAIL_PAGE_URL', 'DETAIL_PICTURE' ]
);

$arResult['prods'] = [];

while ( $prod = $arProducts->GetNext() ) {

	$prod1 = $arProducts->GetNext();
	$arResult['prods'][] = [ $prod, $prod1 ];
}


$this->IncludeComponentTemplate();
?>