<?php

class CHighL{

	static function HL_Upd($HL_ID, $ROW_ID, $arFields){

		if(!is_numeric(intval($HL_ID))||!is_numeric(intval($ROW_ID))||empty($arFields)) return false;
		
		CModule::IncludeModule('highloadblock');
		$rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('ID'=>$HL_ID)));
		if ( !($arData = $rsData->fetch()) ){
			echo 'Инфоблок не найден';
			return false;
		}
		
		$HL = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
		$dataClass = $HL->getDataClass();
		

		return $dataClass::update($ROW_ID, $arFields);
	}

	static function HL_Ins($HL_ID, $arFields){

		if(!is_numeric(intval($HL_ID))||empty($arFields)) return false;

		CModule::IncludeModule('highloadblock');
		$rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('ID'=>$HL_ID)));
		if ( !($arData = $rsData->fetch()) ){
			echo 'Инфоблок не найден';
			return false;
		}
		
		$HL = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
		$dataClass = $HL->getDataClass();
		
		return $dataClass::add($arFields);
	}

	static function HL_Sel($HL_ID, $arFilter = Array(), $arSelect = Array('*')){

		if(!is_numeric(intval($HL_ID))) return false;

		$rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('ID'=>$HL_ID)));
		if ( !($arData = $rsData->fetch()) ){
			echo 'Инфоблок не найден';
			return false;
		}
		
		$HL = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
		
		//Создадим объект - запрос
		$main_query = new \Bitrix\Main\Entity\Query($HL); 

		//Зададим параметры запроса, любой параметр можно опустить
		$main_query->setSelect($arSelect);
		$main_query->setFilter($arFilter);

		//Выполним запрос
		$result = $main_query->exec();

		//Получаем результат по привычной схеме
		$result = new CDBResult($result);
		$arOut = array();
		while ($row = $result->Fetch()){
			$arOut[] = $row;
		}
		
		return $arOut;
		
	}

	static function HL_Rmv($HL_ID,$arFilter){
	
		if(!is_numeric(intval($HL_ID))||empty($arFilter)) return false;
		
		CModule::IncludeModule('highloadblock');
		$rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('ID'=>$HL_ID)));
		if ( !($arData = $rsData->fetch()) ){
			echo 'Инфоблок не найден';
			return false;
		}
		
		$HL = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
		
		//Создадим объект - запрос
		$main_query = new \Bitrix\Main\Entity\Query($HL); 

		//Зададим параметры запроса, любой параметр можно опустить
		$main_query->setSelect(array('*'));
		$main_query->setFilter($arFilter);

		//Выполним запрос
		$result = $main_query->exec();
		
		$dataClass = $HL->getDataClass();
		
		//Получаем результат по привычной схеме
		$result = new CDBResult($result);

		while ($row = $result->Fetch()){
			
			if($row['ID']!=''){
				return $dataClass::delete($row['ID']); 
			}
		}		
	}
}

?>