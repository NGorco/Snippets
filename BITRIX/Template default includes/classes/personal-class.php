<?php
/**  
* Personal class
*/
class CPersonal
{
					
	static function addAdvert($PARAMS){
        
    
        global $USER;

        $arFields = Array();
        $arFields['NAME'] = $PARAMS['TITLE'];
        $arFields['DETAIL_TEXT'] = strip_tags($PARAMS['DETAIL_TEXT']);
        $arFields['TAGS'] = $PARAMS['TAGS'];
        $arFields['PROPERTY_VALUES'][2] = $PARAMS['PRICE'];
        $arFields['PROPERTY_VALUES'][3] = $PARAMS['SELLER_NAME'];
        $arFields['PROPERTY_VALUES'][4] = $PARAMS['CITY'];
        $arFields['PROPERTY_VALUES'][5] = $PARAMS['YOUTUBE'];
        $arFields['PROPERTY_VALUES'][6] = $PARAMS['META'];
        $arFields['PROPERTY_VALUES'][7] = $PARAMS['EMAIL'];
        $arFields['PROPERTY_VALUES'][8] = $PARAMS['PHONE'];
        $arFields['PROPERTY_VALUES'][20] = $PARAMS['METRO'];
        $arFields['PROPERTY_VALUES'][19] = $PARAMS['ADDRESS'];
        $arFields['PROPERTY_VALUES'][9] = json_encode($PARAMS['PROPERTIES_9']);
        $arFields['PROPERTY_VALUES'][18] = $USER->getID();
        $arFields['IBLOCK_ID'] = 2;
        $arFields['IBLOCK_SECTION_ID'] = $PARAMS['IBLOCK_SECTION_ID'];

        $FILES = Array();
        
        foreach ($_FILES['PICTURES']['name'] as $key => $value) {
        	
            $filename_arr = explode(".", $_FILES['PICTURES']['name'][$key]);
            $filename_arr[0] = md5($_FILES['PICTURES']['tmp_name'][$key]);


            if(!empty($_FILES['PICTURES']['name'][$key] )){
            	$FILES[] = array(
            		'name' =>implode(".", $filename_arr) ,
            		'type' =>$_FILES['PICTURES']['type'][$key],
            		'tmp_name' =>$_FILES['PICTURES']['tmp_name'][$key],
            		'error' =>$_FILES['PICTURES']['error'][$key],
            		'size' =>$_FILES['PICTURES']['size'][$key]
        		);
            }
        }

       // $arFields['DETAIL_PICTURE'] = CFile::MakeFileArray(CHelper::moveUploadFile($FILES[0]));

        foreach ($FILES as $value) {
        	
        	$arFields['PROPERTY_VALUES'][1][] = CFile::MakeFileArray(CHelper::moveUploadFile($value));
        }
        $el = new CIBlockElement;


       	if($PRODUCT_ID = $el->Add($arFields)){

		  	$res = CHelper::element($PRODUCT_ID, 2);
		  	header("Location: " . $res['DETAIL_PAGE_URL']);
       	}
		else{
		  echo "Ошибка добавления объявления: ".$el->LAST_ERROR;
		}
	}

    static function editAdvert($PARAMS){
        
        global $USER;

        $arFields = Array();
        $arFields['NAME'] = $PARAMS['TITLE'];
        $arFields['DETAIL_TEXT'] = strip_tags($PARAMS['DETAIL_TEXT']);
        $arFields['TAGS'] = $PARAMS['TAGS'];

        $props = Array();

        $rsPrp = CIBlockElement::GetProperty(2, $_REQUEST['ID'], "sort", "asc", array());

        while($ar_props = $rsPrp->Fetch()){

            $props[$ar_props['ID']][] = $ar_props['VALUE'];
        }

        $arFields['PROPERTY_VALUES'] = Array();
        $arFields['PROPERTY_VALUES'][2] = $PARAMS['PRICE'];
        $arFields['PROPERTY_VALUES'][3] = $PARAMS['SELLER_NAME'];
        $arFields['PROPERTY_VALUES'][4] = $PARAMS['CITY'];
        $arFields['PROPERTY_VALUES'][5] = $PARAMS['YOUTUBE'];
        $arFields['PROPERTY_VALUES'][6] = $PARAMS['META'];
        $arFields['PROPERTY_VALUES'][7] = $PARAMS['EMAIL'];
        $arFields['PROPERTY_VALUES'][20] = $PARAMS['METRO'];
        $arFields['PROPERTY_VALUES'][8] = $PARAMS['PHONE'];
        $arFields['PROPERTY_VALUES'][19] = $PARAMS['ADDRESS'];
        $arFields['PROPERTY_VALUES'][9] = json_encode($PARAMS['PROPERTIES_9']);
        $arFields['PROPERTY_VALUES'][18] = $props[18][0];
        $arFields['PROPERTY_VALUES'][14] = $PARAMS['PRIVATE_ADVERT'];
        $arFields['IBLOCK_ID'] = 2;
        $arFields['IBLOCK_SECTION_ID'] = $PARAMS['IBLOCK_SECTION_ID'];

        $arFields['PROPERTY_VALUES'][1] = Array();

        $pictures = Array();
        foreach ($_FILES['PICTURES']['name'] as $key => $value) {
        

        if($value!=''){

            $keyar = explode("_",$key);
                echo $key;
            $FILE = array(
                'name' =>$_FILES['PICTURES']['name'][$key],
                'type' =>$_FILES['PICTURES']['type'][$key],
                'tmp_name' =>$_FILES['PICTURES']['tmp_name'][$key],
                'error' =>$_FILES['PICTURES']['error'][$key],
                'size' =>$_FILES['PICTURES']['size'][$key]
                );
            $file_moved = CHelper::moveUploadFile($FILE);
            $pictures['a'.$keyar[0]] = CFile::MakeFileArray($file_moved);
            }
        }

        //input=text
        foreach ($PARAMS['PICTURES'] as $key=>$PICTURE) {
           
             $keyar = explode("_",$key);
                
                $ar = $PICTURE == '' ? Array("del" => "Y") : CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT']. $PICTURE);
             $pictures['a'.$keyar[0]] = Array("KEYSORT"=>$keyar['1'], "AR" => $ar);

             if($PICTURE == ''){

                CFile::Delete($keyar[1]);
             }

            
        }
        
        ksort($pictures);
      
        foreach ($pictures as $key => $value) {
         
            if(!empty($value['AR'])){
                $out[$value['KEYSORT']] = $value['AR'];
            }
        }

        CIBlockElement::SetPropertyValuesEx($_REQUEST['ID'], 2, array('ADD_PICS' => $out));
      
       // $arFields['DETAIL_PICTURE'] = $detail_arr;

       
        $arFields['PROPERTY_VALUES'][1] = $pictures;

        // return false;
         $props = Array();

        $rsPrp = CIBlockElement::GetProperty(2, $_REQUEST['ID'], "sort", "asc", array());

        while($ar_props = $rsPrp->Fetch()){

            $props[$ar_props['ID']] = $ar_props['VALUE'];
        }
        
        $arFields['PROPERTY_VALUES'][12] = $props[12];
        $arFields['PROPERTY_VALUES'][13] = $props[13];
        $arFields['PROPERTY_VALUES'][10] = $props[10];


        $el = new CIBlockElement;
        if($PRODUCT_ID = $el->Update($PARAMS['ID'],$arFields)){
            header("Location: /personal/advert-edit.php?ID=" . $PARAMS['ID']);
        }
        else{
          echo "Ошибка добавления объявления: ".$el->LAST_ERROR;
        }
    }

    static function checkPersonalInfo(){

        global $USER;

        $props = Array();

        $rsPrp = CIBlockElement::GetProperty(2, $_REQUEST['ID'], "sort", "asc", array());

        while($ar_props = $rsPrp->Fetch()){

            $props[$ar_props['CODE']][] = $ar_props['VALUE'];
        }

        if(!$USER->isAuthorized() || $props['ADV_AUTHOR'][0] != $USER->getID() ) {
            return false;
        }else{
            return true;
        }
    }

    static function advAction($PARAMS){

        global $USER;

        if($PARAMS['ACTION']== '' || $PARAMS['ID']=='' || !$USER->isAuthorized()) return false;

        $el = new CIBlockElement;

        if($PARAMS['ACTION'] == 'unpublish'){

            return $el->Update($PARAMS['ID'],Array("ACTIVE" => "N"));
        }

        if($PARAMS['ACTION'] == 'publish'){

            return $el->Update($PARAMS['ID'],Array("ACTIVE" => "Y"));
        }

        if($PARAMS['ACTION'] == 'remove'){

            return $el->Delete($PARAMS['ID']);
        }

        if($PARAMS['ACTION'] == 'premium'){

            CIBlockElement::SetPropertyValueCode($PARAMS['ID'], "ADVERT_TYPE", "PAYED");
            return CIBlockElement::SetPropertyValueCode($PARAMS['ID'], "ADVERT_STATUS", 4);
        }

        if($PARAMS['ACTION'] == 'top'){

            CIBlockElement::SetPropertyValueCode($PARAMS['ID'], "ADVERT_STATUS", 0);
            return CIBlockElement::SetPropertyValueCode($PARAMS['ID'], "ADVERT_TYPE", "PAYED");
        }

        if($PARAMS['ACTION'] == 'mark'){

            CIBlockElement::SetPropertyValueCode($PARAMS['ID'], "ADVERT_TYPE", "");
            return CIBlockElement::SetPropertyValueCode($PARAMS['ID'], "ADVERT_STATUS", 1);
        }

        if($PARAMS['ACTION'] == 'vip'){

            CIBlockElement::SetPropertyValueCode($PARAMS['ID'], "ADVERT_TYPE", "PAYED");
            return CIBlockElement::SetPropertyValueCode($PARAMS['ID'], "ADVERT_STATUS", 1);
        }
    }

}

?>