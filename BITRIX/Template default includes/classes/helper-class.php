<?php


/**
* Custom helping functions
*/
class CHelper
{
	
	public static $TEMPLATE_OPTION_IBLOCK = 5;
	public static $ELEMENT_LOOP_DIR = '/bitrix/templates/adverts/includes/loops';
	public static $ELEMENT_LOOP_DEFAULT = "/bitrix/templates/adverts/includes/loops/default.php";

	static function template_option($OPTION_CODE, $params = array())
	{
		
		if(!isset( $params['TYPE'] )){
			$params['TYPE'] = 'DETAIL_TEXT';
		};
		
		$res = CIBlockElement::GetList(array(), array("CODE" => $OPTION_CODE, "IBLOCK_ID" => self::$TEMPLATE_OPTION_IBLOCK));
		$res = $res->GetNext();		

		if($params['TYPE'] == 'FULL'){
			if($res) return $res;
		}else{
			if($res) return $res[$params['TYPE']];	
		}
		
	}

	static  function elements($args, $template = 'default', $raw = false){

		if(empty($args)) return array();
		$out = Array(); //if raw data

		$res = CIBlockElement::GetList(array_shift($args),array_shift($args), array_shift($args), array_shift($args), array_shift($args));
		while($ITEM = $res->GetNext()){

			if($raw){
				$out[$ITEM['ID']] = $ITEM;
				continue;
			}

			if(file_exists($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DIR . "/" . $template . '-loop.php')){
				include($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DIR . "/"  . $template . '-loop.php');	
			}else{
				include($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DEFAULT);
			}			
		}

		if($raw){
			return $out;
		}
	}

	static  function element($ID, $IBLOCK_ID, $selectFields = Array()){

		$filter = Array("IBLOCK_ID" => $IBLOCK_ID);

		if(is_numeric($ID)){
			$filter['ID'] = $ID;
		}else{
			$filter['CODE'] = $IBLOCK_ID;
		}

		$res = CIBlockElement::GetList(Array(),$filter, false, Array(), $selectFields);		
		return $res->GetNext();
	}

	static function price_format($price){

		if(is_numeric($price)){
			return number_format($price,0, '.', ' ');
		}else{
			return 0;
		}
	}

	static  function section($ID, $IBLOCK_ID, $selectFields = Array()){

		$filter = Array("IBLOCK_ID" => $IBLOCK_ID);

		if(is_numeric($ID)){
			$filter['ID'] = $ID;
		}else{
			$filter['CODE'] = $IBLOCK_ID;
		}

		$res = CIBlockSection::GetList(Array(),$filter, false, $selectFields,  Array());		
		return $res->GetNext();
	}

	static  function sections($args, $template = 'default', $raw = false){

		if(empty($args)) return array();
		$out = Array(); //if raw data

		$res = CIBlockSection::GetList(array_shift($args),array_shift($args),array_shift($args),  array_shift($args),array_shift($args));
		while($ITEM = $res->GetNext()){
			if($raw){
				$out[$ITEM['ID']] = $ITEM;
				continue;
			}

			if(file_exists($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DIR . "/" . $template . '-loop.php')){
				include($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DIR . "/"  . $template . '-loop.php');	
			}else{
				include($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DEFAULT);
			}
		}

		if($raw){
			return $out;
		}
	}

	static function titleCut($str,$len=1000){

		if(strlen($str)>$len){
			return mb_substr ($str,0,$len,"UTF-8")."...";
		}else{
			return $str;
		}
	} 

	static function resizePic($pic, $width, $height, $attr_text = ''){

		if(!empty($pic)&&(int)$width>0&&(int)$height>0){
			$pic = CFile::ResizeImageGet($pic, array('width'=>$width, 'height'=>$height), BX_RESIZE_IMAGE_PROPORTIONAL, true); 
			return "<img  src='".$pic['src']."' ".$attr_text."/>";
		}else{

			if(file_exists(TPL . '/img/nopic.png')){

				return '<div class="nopic" style=\'width:' . $width . 'px; margin:0 auto;\'><div style=\'display:table-cell; vertical-align:middle;width:' . $width .'px; height: ' . $height . 'px;  text-align: center;\' class=\'resizedPicture\'><img style=\'max-width:100%;max-height:100%;min-height:initial; min-width:initial;height:auto\' src=\''. SITE_TEMPLATE_PATH . '/img/nopic.png\'></div></div>';
			}
			return false;
		}
	}

	static function featAdvOptDetail($ID){

		if(!is_numeric($ID)) return false;

		$adv = self::element($ID, 2, Array('ID', 'NAME', 'PROPERTY_9', 'IBLOCK_SECTION_ID'));

		$section = self::section($adv['IBLOCK_SECTION_ID'], 2, Array('ID', 'UF_FEAT_ADV_OPTDET'));

		$options = self::advertOptions($adv['PROPERTY_9_VALUE']);
	
		return $options[$section['UF_FEAT_ADV_OPTDET']];
	}

	static function advertOptions($JSON_str){


		$out = Array();
		$JSON = json_decode(str_replace('&quot;', '"', $JSON_str), TRUE);
		
		if(!is_array($JSON)) return Array();

		$options = self::sections(Array(

			Array("sort" => "ASC"),
			Array("IBLOCK_ID" => 4, "ID" => array_keys($JSON)),
			true,
			Array("NAME","ID","DESCRIPTION")
		),'',true);

		foreach ($options as $key => $option) {
			
			$value = '';
			if($option['ELEMENT_CNT'] == 0){
				$value = $JSON[$option['ID']];
			}else{
				
				$elem = CHelper::element($JSON[$option['ID']], 4);

				if(!empty($elem) && !empty($JSON[$option['ID']])){

					$value = $elem['NAME'];
				}
			}

			if($option['DESCRIPTION'] != ''){
				$value = str_replace("#VAL#", $value, $option['DESCRIPTION']);
			}

			$out[$option['ID']] = Array('NAME' => $option['NAME'], "VALUE" => ($value == '') ? 'Не указано' : $value);
		}

		return $out;
	}

	static function blockViewAdverts($ITEMS,$arResult, $template = 'block-view-advert'){ //Отображение блоков для каталога

		foreach($ITEMS as $key => $PROD){

			$ITEMS[$key]['RAW_PROPS'] = $PROD['DISPLAY_PROPERTIES'];
			$ITEMS[$key]['DISPLAY_PROPERTIES'] = Array();
			$props = &$ITEMS[$key]['DISPLAY_PROPERTIES'];

			$crtDate = new DateTime($PROD['DATE_CREATE']);

			$props['CREATE_DATE_DISPLAY'] = $crtDate->format('H:i, d.m.Y');

			foreach ($PROD['DISPLAY_PROPERTIES'] as $key => $value) {
				
				$props[$key] = $value['VALUE'];
			}

			// Получаем список свойств для блочного вида каталога

			$all_options_list = self::advertOptions($PROD['DISPLAY_PROPERTIES']['OPTIONS']['VALUE']);

			$section = self::section($arResult['ID'], 2, Array('UF_ADVS_OPTIONS'));

			$props['OPTIONS'] = array_intersect_key ($all_options_list, array_flip(unserialize($section['UF_ADVS_OPTIONS'])));
		}


		foreach ($ITEMS as $ITEM) {

			if(file_exists($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DIR . "/" . $template . '-loop.php')){
				include($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DIR . "/"  . $template . '-loop.php');	
			}else{
				include($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DEFAULT);
			}
		}
	}	

	static function blockViewCustomAdverts($ITEMS,$arResult = '', $template = 'block-view-advert'){ //Отображение блочных объявлений в кастомных запросах

		foreach($ITEMS as $key => $PROD){

			$ITEMS[$key]['DISPLAY_PROPERTIES'] = Array();
			$props = &$ITEMS[$key]['DISPLAY_PROPERTIES'];

			// Получаем список свойств для блочного вида каталога

			$all_options_list = self::advertOptions($PROD['PROPERTY_9_VALUE']);

			$section = self::section($PROD['IBLOCK_SECTION_ID'], 2, Array('UF_ADVS_OPTIONS'));

			$props['OPTIONS'] = array_intersect_key ($all_options_list, array_flip(unserialize($section['UF_ADVS_OPTIONS'])));
		}


		foreach ($ITEMS as $ITEM) {

			if(file_exists($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DIR . "/" . $template . '-loop.php')){
				include($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DIR . "/"  . $template . '-loop.php');	
			}else{
				include($_SERVER['DOCUMENT_ROOT'] . self::$ELEMENT_LOOP_DEFAULT);
			}
		}
	}

	static function emailRegistered($email){

		$Cus = new CUser();

		$by = 'timestamp_x';
		$order = 'ASC';
		$res = $Cus->GetList($by, $order, Array('EMAIL'=>$email));
		$out = $res->getNext();
		if($out['EMAIL']){

			return true;
		}else{
			return false;
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

	static function favourControl($PROD_ID){

		global $USER;
		$res = CHighL::HL_Sel(1, Array("UF_USER_ID"=>$USER->getID()));
		
		$FAVS = explode('/',$res[0]['UF_FAVOUR']);
		
		$active = '';
		$title = 'Добавить в избранное';
		if(in_array($PROD_ID, $FAVS)){

			$title = 'Удалить из избранного';
			$active = 'active';
		}
		?>
		<span style="cursor:pointer" title="<?=$title?>" onclick="Handy.addToFavourite(<?=$PROD_ID?>)" class="like-icon <?=$active?> fv<?=$PROD_ID?>"></span>
		<?
	}

	static function processPic($ELEMENT_ID, $FILE_PATH, $CODE, &$PROP_AR,$PROP_VAL_ID, $PROC_TYPE,  $PARAMS = Array( "PROP_ID"=>1, "IBLOCK_ID"=>2)){

		if($PROC_TYPE == "del"){

			CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, $PARAMS['IBLOCK_ID'], array(
					$PARAMS['PROP_ID'] => Array (
						$PROP_VAL_ID =>	Array("VALUE" => array("del" => "Y")),
					)
				)
			); 
			
			$arFile = Array("del" => "Y","MODULE_ID" => "iblock");

			$PROP_AR[$PARAMS['PROP_ID']][$PROP_VAL_ID] = $arFile;
			 return CIBlockElement::SetPropertyValues($ELEMENT_ID, $PARAMS['IBLOCK_ID'], Array ($PROP_VAL_ID => Array("VALUE"=>$arFile) ), $CODE );
		}

		if($PROC_TYPE == 'update'){

			CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, $PARAMS['IBLOCK_ID'], array(
					$PARAMS['PROP_ID'] => Array (
						$PROP_VAL_ID =>	Array("VALUE" => array("del" => "Y")),
					)
				)
			); 

			$arFile = CFile::MakeFileArray($FILE_PATH); $arFile["MODULE_ID"] = "iblock"; $arFile["del"] = "Y"; 

			$PROP_AR[$PARAMS['PROP_ID']][$PROP_VAL_ID] = $arFile; 
			return CIBlockElement::SetPropertyValues($ELEMENT_ID, $PARAMS['IBLOCK_ID'], Array ($PROP_VAL_ID => Array("VALUE"=>$arFile) ), $CODE ); 
		}

		if($PROC_TYPE == 'add'){

			$arFile = CFile::MakeFileArray($FILE_PATH); $arFile["MODULE_ID"] = "iblock"; 

			$PROP_AR[$PARAMS['PROP_ID']][] = $arFile; 
			return CIBlockElement::SetPropertyValueCode($ELEMENT_ID, $CODE, Array("VALUE"=>$arFile) ); 
		}
	}
}

?>