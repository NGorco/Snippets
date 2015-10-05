<?php
/*
Plugin Name: MQ Socials 
Version: 1.0
Description: Socials login and register for WP
Author: Alex Petlenko
Site: http://massique.com
*/


class MQ_Socials
{
	public $VK_ID;
	public $FB_ID;
	public $socials_to_show = Array('fb', 'tw', 'vk');

	function __construct($PARAMS = Array())
	{	
		$this->hooks();

		if(!is_admin())
		$this->enqueue_scripts();

		if(is_array($PARAMS['socials_to_show']) && count($PARAMS['socials_to_show']) > 0)
		{
			$this->socials_to_show = $PARAMS['socials_to_show'];	
		}
	}

	function enqueue_scripts()
	{
		wp_enqueue_script('vk-api', '//vk.com/js/api/openapi.js');
		wp_enqueue_script('mq-socials-scripts', plugin_dir_url( __FILE__ ) . '/assets/js/socials.js' , array('jquery', 'vk-api'), '', true);
	}

	static function register()
	{
		$show = Array('fb', 'tw', 'vk')
		?>
	<div class="row mq-socials social-btns">
	<?
		foreach($show as $social)
		{
			?>
			<div class="col-md-4 col-sm-4 col-xs-4">
				<div class="soc-btn <?=$social?>-social social-control" data-social="<?=$social?>_register"></div>
			</div>			
			<?
		}?>
	</div>
	<?
	}

	static function login()
	{
		$show = Array('fb', 'tw', 'vk')
		?>
	<div class="row mq-socials social-btns">
	<?
		foreach($show as $social)
		{
			?>
			<div class="col-md-4 col-sm-4 col-xs-4">
				<div class="soc-btn <?=$social?>-social social-control" data-social="<?=$social?>_login"></div>
			</div>	
			<?
		}?>
	</div><?
	}

	static function register_user()
	{		
		$nickname = '';
		$email = '';
		$name = '';
		$login = '';
		$vk_id = '';
		$tw_id = '';
		$fb_id = '';
		$site = '';

		if($_POST['SOC'] == 'VK')
		{
			$user = $_POST['user']['session']['user'];

			$name = $user['first_name'];
			$last_name =  $user['last_name'];
			$id = $user['id'];
			$nickname = $user['nickname'];
			$site = $user['href'];
			$email = 'vk_' . $id . '@' . $_SERVER['SERVER_NAME'];
		}

		if($_POST['SOC'] == 'FB')
		{
			$user = $_POST['user'];

			$name = $user['first_name'];
			$last_name =  $user['last_name'];
			$id = $user['id'];
			$nickname = $user['nickname'];
			$site = $user['link'];
			$email = $user['email'] != '' ? $user['email'] : 'fb_' . $id . '@' . $_SERVER['SERVER_NAME'];
		}



		$errors = register_new_user($email, $email);

		if( !is_wp_error($errors) )
		{
			$pass = md5($id);
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
				) ;

		}else{
			echo json_encode(array('status' => 'failed', 'message' => $errors));
		}
		die();
	}

	static function login_user()
	{
		if(!empty($_POST['SOC']))
		{	
			$email = '';

			if($_POST['SOC'] == 'VK')
			{				
				$user = $_POST['user']['session']['user'];

				$id = $user['id'];
				$email = 'vk_' . $id . '@' . $_SERVER['SERVER_NAME'];
			}

			if($_POST['SOC'] == 'FB')
			{				
				$user = $_POST['user'];
				
				$id = $user['id'];
				$email = $user['email'] != '' ? $user['email'] : 'fb_' . $id . '@' . $_SERVER['SERVER_NAME'];
			}

			$user = get_users(array('email' => $email) );

			if(count($user) > 0)
			{
				$pass = md5($id);
				$creds['user_login'] = $email;
				$creds['user_password'] = $pass;
				$creds['remember'] = true;
				$user = wp_signon( $creds, false );

				echo json_encode(array('status' => 'success'));
			}else{
				echo json_encode(array('status' => 'failed', 'message' => array('no_user' => array('Пользователь не зарегистрирован.'))));
			}
		}else{
			echo json_encode(array('status' => 'failed', 'message' => $errors));
		}
		die();
	}

	public function hooks()
	{
		add_action('wp_ajax_register_mq_social', 'MQ_Socials::register_user');
		add_action('wp_ajax_login_mq_social', 'MQ_Socials::login_user');

		add_action('wp_ajax_nopriv_register_mq_social', 'MQ_Socials::register_user');
		add_action('wp_ajax_nopriv_login_mq_social', 'MQ_Socials::login_user');
	}
}

new MQ_Socials();
?>