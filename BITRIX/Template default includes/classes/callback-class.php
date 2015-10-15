<?php
/**
* Класс содержит функции-обработчики AJAX-запросов
*/
class CCallback{
	
	public static $CLBK = Array();
	
	static function router(){
		
		if(isset($_REQUEST)&&!empty($_REQUEST)&&method_exists("CCallback", $_REQUEST['method']."Clbk")){
		
			$methodName = $_REQUEST['method']."Clbk";
			self::$methodName($_REQUEST['params']);
			self::retJson();
		}else{
			self::retJson(Array("error"=>"PHP Callback.router::invalid arguments"));
		}
	
	}
	
	static function retJson(){
	
		if(!is_array(self::$CLBK)){

			self::$CLBK['status'] = 'false';
		}
		
		echo json_encode(self::$CLBK);
	}

	static function checkCaptchaClbk($PARAMS){


		if($_SESSION['CAPTCHA'] == $PARAMS['CAPTCHA']){

			self::$CLBK['status'] = 'success';
		}else{

			self::$CLBK['status'] = false;
		}
	}

	static function changePassClbk($PARAMS){

		$PARAMS = $_REQUEST;
		global $USER;
		$date = new DateTime();
		$pass = md5(date().$PARAMS['USER_LOGIN']);
		$arResult = $USER->ChangePassword($PARAMS['USER_LOGIN'], $PARAMS['USER_CHECKWORD'], $pass, $pass);
		if($arResult["TYPE"] == "OK") {

			$user = CUser::getList(($by=""),($order=""),Array("LOGIN"=>$PARAMS['USER_LOGIN']));
			$user = $user->Fetch();
			
			mail($user['EMAIL'], 'Новый пароль аккаунта на сайте '.$_SERVER['SERVER_NAME'], 'Новый пароль: '. $pass ."\r\nЛогин: " . $PARAMS['USER_LOGIN']);
		}
			header("Location: /");
	}

	static function ChangeSortClbk($PARAMS){

		$_SESSION['CAT_SORT'] = $PARAMS['CAT_SORT'];
	}

	static function ChangeAdvTypeClbk($PARAMS){

		$_SESSION['ADV_TYPE'] = $PARAMS['ADV_TYPE'];
	}

	static function ChangeCatViewClbk($PARAMS){

		$_SESSION['CAT_VIEW'] = $PARAMS['CAT_VIEW'];
	}

	static function sellerPhoneImgClbk($PARAMS){

		if(!isset($PARAMS['ADV_ID']) && !is_numeric($PARAMS['ADV_ID'])) return false;

		$adv = CHelper::element($PARAMS['ADV_ID'], 2, Array('PROPERTY_8'));

		$text = $adv['PROPERTY_8_VALUE'];
		
		header("Content-type: image/png");
		// Текст надписи

		$block_len = mb_strlen($text)*10.5+20;
		$im = imagecreatetruecolor($block_len, 30);

		// Создание цветов
		$white = imagecolorallocate($im, 246, 250, 253);
		$grey = imagecolorallocate($im, 128, 128, 128);
		$black = imagecolorallocate($im, 0, 0, 0);
		imagefilledrectangle($im, 0, 0, $block_len, 29, $white);

		// Замена пути к шрифту на пользовательский
		$font =  TPL . '/fonts/ARIAL.TTF';

		// Текст
		imagettftext($im, 14, 0, 8, 22, $black, $font, $text);
		imagepng($im);
		imagedestroy($im);
	}

		static function captchaClbk(){

		$date = new DateTime();
		$text = substr(md5(base64_encode($date->format("timestamp"))),0, 6);
		
		header("Content-type: image/png");
		// Текст надписи

		$block_len = mb_strlen($text)*12+20;
		$im = imagecreatetruecolor($block_len, 30);

		// Создание цветов
		$white = imagecolorallocate($im, 246, 250, 253);
		$grey = imagecolorallocate($im, 128, 128, 128);
		$black = imagecolorallocate($im, 0, 0, 0);
		imagefilledrectangle($im, 0, 0, $block_len, 29, $white);

		// Замена пути к шрифту на пользовательский
		$font =  TPL . '/fonts/ARIAL.TTF';

		// Текст
		imagettftext($im, 14, 0, 8, 22, $black, $font, $text);
		imagepng($im);
		imagedestroy($im);

		$_SESSION['CAPTCHA'] = $text;
	}

	static function registerUserClbk($PARAMS){

		if($_SESSION['CAPTCHA'] != $PARAMS['CAPTCHA']){

			self::$CLBK['user_error'] = 'Неверно введены проверочные символы. Введите снова.';
			self::$CLBK['status'] = false;
			return false;
		}

		$Cus = new CUser();

		if(CHelper::emailRegistered($PARAMS['REG_EMAIL'])){

			self::$CLBK['user_error'] = 'Такая электронная почта уже зарегистрирована';
			self::$CLBK['status'] = false;
			return false;
		}

		if($ID = $Cus->Add(
				Array(
						"LOGIN"=>$PARAMS['REG_EMAIL'],
						"PASSWORD"=>$PARAMS['REG_PASS'],
						"CONFIRM_PASSWORD"=>$PARAMS['REG_PASS'],
						"EMAIL"=>$PARAMS['REG_EMAIL']
					)
				)
			){

			$Cus->Update($ID, Array('PERSONAL_PHONE'=>$PARAMS['REG_PHONE'], 'NAME' => $PARAMS['REG_NAME']));
			
			$Cus->Authorize($ID);
			$content = "Спасибо за регистрацию на нашем сайте!\n";
			$content .= "\nВаш логин: ".$PARAMS['REG_EMAIL']."\n";
			$content .= "\nВаш пароль: ".$PARAMS['REG_PASS']."\n";
			$headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
			$headers .= 'From: '. COption::GetOptionString('main','site_name') . ' ' . COption::GetOptionString('main','email_from') . "\r\n";
			mail($PARAMS['REG_EMAIL'],"Вы зарегистрированы на сайте odolju.ru",$content, $headers);
			self::$CLBK['status'] = 'success';
			self::$CLBK['ID'] = $ID;
			return $ID;
		}else{

			self::$CLBK['user_error'] = $Cus->LAST_ERROR;
			self::$CLBK['status'] = false;
			return false;
		}
	}

	static function addToFavouriteClbk($PARAMS){

		global $USER;
		$USER_ID = $USER->GetID();
		if($USER->IsAuthorized()&&!empty($PARAMS['ID'])&&is_numeric(intval($PARAMS['ID']))){
			
			$hl = CHighL::HL_Sel(1, Array("UF_USER_ID"=>$USER_ID));		
			
			if($hl[0]['UF_FAVOUR']!=''){
				$ROW_ID = $hl[0]['ID'];
				$hl = unserialize($hl[0]['UF_FAVOUR']);
				
				if(in_array($PARAMS['ID'],$hl)){				
					
					$index = array_search($PARAMS['ID'], $hl);
				
					if(is_numeric(intval($index))){
					
						unset($hl[$index]);
						
						if(count($hl)>0){

							$elems = CHelper::elements(Array(Array(),Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y", "ID"=>$hl)), '', true);

							$hl = Array();
							foreach ($elems as $value) {
								
								$hl[] = $value['ID'];
							}

							$Arr = Array(
								"UF_FAVOUR"=>serialize($hl)
							);
							
							if(CHighL::HL_Upd(1, $ROW_ID, $Arr))	self::$CLBK['type'] = 'unfavoured';
						}else{	
							
							if(CHighL::HL_Rmv(1, Array("ID"=>$ROW_ID)))	self::$CLBK['type'] = 'unfavoured';
						}
					}
				}else{
					
					$hl[] = $PARAMS['ID'];


					$elems = CHelper::elements(Array(Array(),Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y", "ID"=>$hl)), '', true);

					$hl = Array();
					foreach ($elems as $value) {
						
						$hl[] = $value['ID'];
					}

					$Arr = Array("UF_USER_ID"=>$USER_ID,"UF_FAVOUR"=>serialize($hl));
					if(CHighL::HL_Upd(1, $ROW_ID, $Arr))	self::$CLBK['type'] = 'favoured';					
				}
			}else{
				

				$elems = CHelper::elements(Array(),Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y", "ID"=>$PARAMS['ID']), '', true);

				$hl = Array();
				foreach ($elems as $value) {
					
					$hl[] = $value['ID'];
				}


				$Arr = Array("UF_USER_ID"=>$USER_ID,"UF_FAVOUR"=>serialize($hl));
				if(CHighL::HL_Ins(1,$Arr)) self::$CLBK['type'] = 'favoured';			
			}

			$res = CHighL::HL_Sel(1, Array("UF_USER_ID"=>$USER_ID));
			
			if(count($res) > 0){
				self::$CLBK['count'] = count(unserialize($res[0]['UF_FAVOUR']));
			}else{
				self::$CLBK['count'] = 0;
			}
			self::$CLBK['status'] = 'success';
		}else{
		
			self::$CLBK['user_error'] = "Для добавления в избранное выполните вход.";
		}
	}

	static function logoutClbk(){
		global $USER;
		if (!is_object($USER)) $USER = new CUser;

		$USER->Logout();
		self::$CLBK['status'] = 'success';
	}

	static function loginClbk($PARAMS){

		global $USER;
		if (!is_object($USER)) $USER = new CUser;
		$login = $USER->Login($PARAMS['LOGIN_EMAIL'], $PARAMS['LOGIN_PASS']);
		if($login === true){

			self::$CLBK['status'] = 'success';
		}else{

			self::$CLBK['user_error'] = strip_tags($login['MESSAGE']);
		}
	}

	static function recoverPassClbk($PARAMS){
	
		$user = CUser::GetList(($by="personal_country"), ($order="desc"),Array("EMAIL"=>$PARAMS['EMAIL']));
			
		while($use = $user->Fetch()){
			
			if(CUser::SendPassword($use['LOGIN'], $PARAMS['EMAIL'],SITE_ID)){
				self::$CLBK['status'] = 'success';
			}else{
				self::$CLBK['user_error'] = 'Проблема с отправкой письма для восстановления пароля';
			}
		}
	}

	static function getAdvAddFieldsClbk($PARAMS){

		global $USER;
		$out = Array();
		$out_html = '';
		if(!empty($PARAMS['CAT_ID'])){

			$section = CHelper::section($PARAMS['CAT_ID'], 2, Array('ID', 'UF_SECTION_OPTS'));

			if(count(unserialize($section['UF_SECTION_OPTS'])) == 0){ 

				self::$CLBK['status'] = 'no_options';
				return false;
			}
			
			$options = CHelper::sections(Array(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>4, "ID"=>unserialize($section['UF_SECTION_OPTS'])), true), '', true);


			$cnt = 1;
			foreach($options as $option){


				if($option['ELEMENT_CNT']>0){

					$out_html .= '<div class="custom-select default-style input-set">     

                        <div class="down-arrow"><img src="/bitrix/templates/adverts/img/select-arrow-down-grey.png"></div>              
                        <div class="select-text-value"></div>';

                        $out_html .= '<div class="select-option" value="">' . $option['NAME'] . '</div>';

                        $values = CHelper::elements(Array(Array('SORT'=>'ASC'), Array('IBLOCK_ID' => 4, 'SECTION_ID'=>$option['ID'])), '', true);
                        $cnt = 0;
                        $ID_START = 0;
                        foreach ($values as $key => $value) {
                        	if($cnt == 0){

                        		$ID_START = $value['ID'];
                        	}
                        	$cnt++;
                        	$out_html .= '<div class="select-option" value="'.$value['ID'].'">'.$value['NAME'].'</div>';
                        }

                       //$out_html .= '<input type="hidden" name="PROPERTIES_9['.$option['ID'].']" value="'. $ID_START.'"></div>';
                       $out_html .= '<input type="hidden" name="PROPERTIES_9['.$option['ID'].']" value=""></div>';
                        
				}else{

					$out_html .= '<input type="text" placeholder="' . $option['NAME'] . '" name="PROPERTIES_9['.$option['ID'].']" class="default-style">';
				}
				
				$out_temp = Array(

					'NAME' => $option['NAME'],
					'COUNT' => $option['ELEMENT_CNT'],
					'VALUES' => CHelper::elements(Array(Array('NAME'=>'ASC'), Array('IBLOCK_ID' => 4, 'SECTION_ID'=>$option['ID'])), '', true),
					'TYPE' => ($option['ELEMENT_CNT']>0) ? 'SELECT' : 'TEXT'
					);

				$out[] = $out_temp;
			}
		}

		self::$CLBK['status'] = 'success';
		self::$CLBK['adv_options'] = $out;
		self::$CLBK['adv_options_html'] = $out_html;
	}

	static function getCommonTagsClbk($PARAMS){

		if($PARAMS['TAG']!=''){

			$db_res = CSearchTags::GetList(
				array("NAME", "CNT"),
				array("TAG"=>$PARAMS["TAG"]), 
				Array(),
				8
				);

			if($db_res)
			{	
				self::$CLBK['tags'] = '';
				while($res = $db_res->Fetch())
				{
					self::$CLBK['tags'] .= '<div class="select-option" value="' . $res['NAME'] . '">' . $res['NAME']. '</div>';
				}

				self::$CLBK['status'] = 'success';
			}
		}
	}

	static function formSubmitClbk($PARAMS){

		if(method_exists(__CLASS__, $PARAMS['submitAction'])){

			self::$PARAMS['submitAction']($PARAMS);
		}else{

			self::$CLBK['sdfds'] = $PARAMS;
			self::$CLBK['user_error'] = 'no such method in clbkclass';
		}

	}
	static function warnMessage($PARAMS){

		if($_SESSION['CAPTCHA'] != $PARAMS['CAPTCHA']){

			self::$CLBK['status'] = 'error';
			self::$CLBK['user_error'] = 'Неправильно введены проверочные символы.';
			return false;
		}	

		if($PARAMS['MESSAGE'] != ""){

			$to = "rabpamov@mail.ru";
			$headers = 'Content-type: text/plain; charset=utf-8' . "\r\n";

			$res = mail($to, 'Жалоба с сайта Odolzhu.ru', $PARAMS['MESSAGE'], $headers);
			if($res){

				unset($_SESSION['CAPTCHA']);
				self::$CLBK['status'] = 'success';
			}else{
				self::$CLBK['user_error'] = 'Ошибка отправки сообщения';
			}
		}
	}
	

	static function contactToSellerClbk($PARAMS){

		if($_SESSION['CAPTCHA'] != $PARAMS['CAPTCHA']){

			self::$CLBK['status'] = 'error';
			self::$CLBK['user_error'] = 'Неправильно введены проверочные символы.';
			return false;
		}

		if($PARAMS['TO']!='' && $PARAMS['EMAIL']!=''){

			$headers = 'Content-type: text/plain; charset=utf-8' . "\r\n";
			$headers .= 'From: ' . $PARAMS['NAME'] . "<" . $PARAMS['EMAIL'] . ">\r\n";
			
			if($PARAMS['COPY']){

				mail($PARAMS['EMAIL'], 'Письмо от покупателя на сайте Odolzhu.ru', $PARAMS['MESSAGE']. "\n\n".'Ответ на письмо слать на '. $PARAMS['EMAIL'] . ', ' . $PARAMS['NAME'], $headers);
			}

			$res = mail($PARAMS['TO'], 'Письмо от покупателя на сайте Odolzhu.ru', $PARAMS['MESSAGE']. "\n\nОтвет на письмо слать на ". $PARAMS['EMAIL'] . ', ' . $PARAMS['NAME'], $headers);
			if($res){

				unset($_SESSION['CAPTCHA']);
				self::$CLBK['status'] = 'success';
			}else{
				self::$CLBK['user_error'] = 'Ошибка отправки сообщения';
			}
		}
	}

	static function advActionClbk($PARAMS){

		CPersonal::advAction($PARAMS);
		self::$CLBK['status'] = 'success';
	}
}
?>
