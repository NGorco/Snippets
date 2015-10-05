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

	static function contactFormFeedbackClbk($PARAMS)
	{
		$message = "Письмо от: " . $PARAMS['fname'] . " " . $PARAMS['lname'] . "\n\n";
		$message .= $PARAMS['message'] . "\n\n";
		$message .= "Контакты: " . $PARAMS['email']. ", " . $PARAMS['phone'];

		$status = wp_mail( get_option('email_admin_address'), "Новое письмо с сайта " . get_option('blogname'), $message );

		if(!!$status)
		{
			self::$CLBK['status'] = 'success';
		}else{
			self::$CLBK['status'] = 'false';
		}	
		
	}

	static function addCalendarEventClbk($PARAMS)
	{
		global $wpdb;

		$cat = Array();
		$cat[] = json_decode($PARAMS['post_category']);

		unset($PARAMS['post_category']);


		$post_id = wp_insert_post( $PARAMS , $wp_error);

		wp_set_post_terms($post_id, $cat, 'category', true);

		foreach($PARAMS['meta'] as $meta_key => $meta_value)
		{
			$meta_id = update_post_meta( $post_id, $meta_key, $meta_value);	
			$sql = $wpdb->prepare(
				"INSERT INTO {$wpdb->prefix}mf_post_meta VALUES (%s, %s, %d, %d, %d)",
				$meta_id,
				$meta_key,
				1,
				1,
				$post_id
			);

			$wpdb->query($sql);
		}
		
		self::$CLBK['status'] = 'success';
		self::$CLBK['id'] = $post_id;
		self::$CLBK['err'] = $PARAMS;
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
		imagefilledrectangle($im, 0, 0, $block_len, 35, $white);

		// Замена пути к шрифту на пользовательский
		$font =  get_template_directory() . '/assets/fonts/ARIAL.TTF';

		// Текст
		imagettftext($im, 18, 0, 8, 22, $black, $font,$text);
		imagepng($im);
		imagedestroy($im);

		$_SESSION['CAPTCHA'] = $text;
	}

	static function calendarEventsClbk($PARAMS)
	{
		if(IntVal($_REQUEST['ano']) > 0)
		{
			$posts = get_posts(
				Array(
					'post_type' => 'events',
					'date_query' => Array(
						'year' => $_REQUEST['ano']
					)
				) 
			);

			$out = Array();

			foreach ($posts as $key => $post) 
			{				
				$date = CUtil::get_meta('event_date', $post->ID);

				$date = new DateTime($date);

				$out[] = Array(

					'date' => $date->format('j/n/Y'),
					'title' => '',
					'color' => '#ccc'
					);
			}

			self::$CLBK = $out;

		}else{

			self::$CLBK['status'] = 'false';
		}
	}

	static function endReg1()
	{
		if(is_user_logged_in() && count($_POST['user']) > 0)
	    {
	        $user_id = get_current_user_id();
	        foreach ($_POST['user'] as $meta_key => $meta_value) 
	        {               
	            update_user_meta( $user_id, $meta_key, $meta_value );
	        }

	        if($_FILES['avatar'])
	        {
	            $path = wp_upload_dir();
	            $path = $path['path'];

	            $ext = array_pop(explode($_FILES['avatar']['name'], "."));
	            $rand = md5(mt_rand() . date('X'));
	            $filename = $rand . "." + $ext;
	            move_uploaded_file($_FILES['avatar']['tmp_name'], $path . "/" . $filename);
	            
	            // The ID of the post this attachment is for.
	            $parent_post_id = 0;

	            // Check the type of file. We'll use this as the 'post_mime_type'.
	            $filetype = wp_check_filetype( basename( $filename ), null );

	            pre(wp_upload_dir());

	            // Prepare an array of post data for the attachment.
	            $attachment = array(
	                'guid'           => $path . "/" . basename( $filename ), 
	                'post_mime_type' => $filetype['type'],
	                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
	                'post_content'   => '',
	                'post_status'    => 'inherit'
	            );

	            // Insert the attachment.
	            //$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

	            // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
	            require_once( ABSPATH . 'wp-admin/includes/image.php' );

	            // Generate the metadata for the attachment, and update the database record.
	            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	            wp_update_attachment_metadata( $attach_id, $attach_data );

	            update_user_meta( $user_id, 'avatar_id', $attach_id );
	        }

	        return true;
	    }
	}

	static function registerUserClbk($PARAMS)
	{	
		self::$CLBK['rt'] = $_SESSION['CAPTCHA'];
		if($_SESSION['CAPTCHA'] != $PARAMS['cap']){

			self::$CLBK['message'] = array("errors"=>array("wrong_cap" => array('Неверно введены проверочные символы. Введите снова.')));
			self::$CLBK['status'] = false;
			return false;
		}
		
		$email = $PARAMS['email'];
		$login = $PARAMS['login'];

		$errors = register_new_user($email, $email);

		if( !is_wp_error($errors) )
		{
			$pass = md5($PARAMS['pass']);
			wp_set_password( $pass, $errors );

			echo json_encode(array('status' => 'success'));

			$creds = array();
			$creds['user_login'] = $email;
			$creds['user_password'] = $pass;
			$creds['remember'] = true;
			$user = wp_signon( $creds, false );

			wp_update_user( 
				array( 
					'ID' => $errors, 
					'user_url' =>  $site, 
					'first_name' => $name,
					'last_name' => $last_name,
					'nickname' => $nickname != '' ? $nickname : $name
				)
			);

		}else{
			echo json_encode(array('status' => 'failed', 'message' => $errors));
		}
		die();
	}

	static function logoutClbk()
	{
		wp_logout();

		self::$CLBK['status'] = 'success';
	}

	static function loginClbk($PARAMS)
	{		
		$creds = array();
		$creds['user_login'] = $PARAMS['login'];
		$creds['user_password'] = $PARAMS['password'];
		$creds['remember'] = $PARAMS['remember'] ? true: false;
		$login = wp_signon( $creds, false );

		

		if($login->data){

			self::$CLBK['status'] = 'success';
		}else{

			self::$CLBK['message'] = array("errors"=>array("wrong_cap" => array('Неверная пара логин/пароль.')));
		}
	}

	static function recoverPassClbk($PARAMS)
	{	
		if(!empty($PARAMS['email']))
		{
			$user = get_users('search=' . $PARAMS['email']);

			if(count($user) > 0)
			{	
				$user = array_shift($user);

				$pass = md5(date('X') . $user->id);
				wp_set_password($pass, $user->id );
				$subject = 'Восстановление пароля Willad.ru';
				$message = sprintf ("Вы запросили восстановление пароля. \n\n Новый пароль от личного кабинета: \n\n%s", $pass );
			
				$headers[] = 'From: Willad.ru <info@willad.ru>';
				wp_mail( $PARAMS['email'], $subject, $message, $headers );
				self::$CLBK['status'] = 'success';
			}else{
				self::$CLBK['status'] = false;
				self::$CLBK['message'] = array("errors"=>array("wrong_cap" => array('Пользователя с таким email не существует')));
			}
		}
	}	
}
?>
