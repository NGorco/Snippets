<?php
/*
 * @package Massique
 * @subpackage Base_Theme
 */

new CInit();

/*
/ Class represents start point of theme functionality
*/

class CInit 
{
	function __construct()
	{
		if (!session_id()) 
		{
		    session_start();
		}

		define ('TPL', get_template_directory_uri());

		load_modules(__DIR__);

		$this->theme_settings();
		$this->theme_supports();
		$this->hooks();
		$this->advanced_routes();		
	}

	private function advanced_routes()
	{
		if(isset($_POST['register_end_1']))
		{
			if(CCallback::endReg1())
			{
				header("Location:/user?end-register-2");
			}else{
				header("Location:/user?end-register-1");
			}
		}

		if(isset($_POST['cabinet-edit']))
		{
			CUtil::saveUserData();
		}

		if($_REQUEST['AJAX_REQUEST'] && $_REQUEST['AJAX_REQUEST'] == 'Y')
		{
			CCallback::router();
			exit();
		}

		if(!empty($_POST['end-register-2']))
		{
			FSSubscribeCore::saveSubscribes();
			header("Location: /user?cabinet");
			exit();
		}

		if(is_user_logged_in() && 
			(isset($_GET['login']) || 
			isset($_GET['register']) || 
			isset($_GET['end-register-2']) || 
			isset($_GET['end-register-1']) || 
			isset($_GET['pass-recover']) ))
		{
			header('Location: /user?cabinet');
		}		
	}

	private function theme_settings()
	{	

		register_sidebar( 
			array(
				'name' => 'Calendar Sidebar',
				'description' => 'The secondary widget area',
				'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) 
		);

		register_sidebar( 
			array(
				'name' => 'Single Sidebar',
				'description' => 'Category widget area',
				'before_widget' => '',
				'after_widget' => '',
				'before_title' => '',
				'after_title' => '',
			) 
		);

		register_sidebar( 
			array(
				'name' => 'Category Sidebar',
				'description' => 'Category widget area',
				'before_widget' => '',
				'after_widget' => '',
				'before_title' => '',
				'after_title' => '',
			) 
		);

		register_sidebar( 
			array(
				'name' => 'Main Page Sidebar',
				'description' => 'Main Page widget area',
				'before_widget' => '',
				'after_widget' => '',
				'before_title' => '',
				'after_title' => '',
			) 
		);

		register_nav_menus( 
			array(
				'main' => 'Main Navigation Menu',
				'secondary' => 'Secondary navigation Menu'
			) 
		);

		add_image_size ( 'thumbnail', 110, 80 );

		if(!is_admin())
		{
			

			wp_enqueue_style('main-styles', TPL . '/style.css');
			wp_enqueue_style('owl.carousel-styles', TPL . '/assets/css/owl.carousel.css');
			wp_enqueue_style('owl.carousel-theme', TPL . '/assets/css/owl.theme.css');
			wp_enqueue_style('fancybox', TPL . '/assets/css/jquery.fancybox.css');

			// Scripts in footer

			wp_enqueue_script( 'comment-reply' );
			wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?v=3.exp', array('jquery'), "", true);
			wp_enqueue_script('common-theme-scripts', TPL . '/assets/js/common.js', array('jquery'), "", true);
			wp_enqueue_script( "jquery", TPL . "/assets/js/jquery.min.js", array(), "", true );
			wp_enqueue_script( "bootstrap", TPL . "/assets/js/bootstrap.min.js", array('jquery'), "", true );
			wp_enqueue_script( "datepicker", TPL . "/assets/js/bootstrap-datepicker.js", array('jquery','bootstrap'), "", true );
			wp_enqueue_script( "sidr", TPL . "/assets/js/jquery.sidr.min.js", array('jquery'), "", true );
			wp_enqueue_script( "carou", TPL . "/assets/js/jquery.carouFredSel-6.2.1-packed.js", array('jquery'), "", true );
			wp_enqueue_script( "touch", TPL . "/assets/js/jquery.touchSwipe.min.js", array('jquery'), "", true );
			wp_enqueue_script( "photbox", TPL . "/assets/js/jquery.photobox.js", array('jquery'), "", true );
			wp_enqueue_script( "funcs", TPL . "/assets/js/functions.js", array('jquery'), "", true );
			wp_enqueue_script( "handyWP", TPL . "/assets/js/handyAjax.js", array('jquery'), "", true );
			wp_enqueue_script( "handyMeth", TPL . "/assets/js/handyMethods.js", array('jquery'), "", true );
			wp_enqueue_script( "reCaptchaAPI", "https://www.google.com/recaptcha/api.js", "" );
			wp_enqueue_script( "owl.carousel", TPL . "/assets/js/owl.carousel.min.js", array('jquery'), "", true );
			wp_enqueue_script( "fancybox", TPL . "/assets/js/jquery.fancybox.pack.js", array('jquery'), "", true );
		}
	}

	private function theme_supports()
	{
		add_theme_support( 'post-formats', array('video'));
		add_theme_support('post-thumbnails');
	}

	function tinymce_add_buttons( $plugin_array ) 
	{
	    $plugin_array['wptuts'] = get_template_directory_uri() . '/assets/js/tinyMCEextend.js';
	    return $plugin_array;
	}


	function tinymce_register_buttons( $buttons ) {
	    array_push( $buttons, 'dropcap', 'showrecent' ); // dropcap', 'recentposts
	    return $buttons;
	}

	private function hooks()
	{
		add_filter("the_content", "CUtil::noindex_filter");
		// TinyMCE extend
		add_filter( "mce_external_plugins", "CInit::tinymce_add_buttons" );
	    add_filter( 'mce_buttons', 'CInit::tinymce_register_buttons' );

	    // Exterpt length
		add_filter( 'excerpt_length', function() use ($length) { return 20; }, 999 );

		// Change nav menu classes
		add_filter( 'nav_menu_css_class', 

			function ($classes)
			{
			     if(
			     	in_array('current-menu-item', $classes)||
			     	in_array('current-post-ancestor', $classes)
			     	)
			     {
			             $classes[] = 'current ';
			     }

			     return $classes;
			}
			,10 , 2
		);
	}
}

// Function loads WP-styled modules
function load_modules($dir_path)
{
	$directories = glob($dir_path . '/*' , GLOB_ONLYDIR);

	foreach ($directories as $dir)
	{
		$plugin_file_name = explode('/', $dir);
		$widgetpath = $dir . '/' . array_pop($plugin_file_name) . '.php';

		if(file_exists($widgetpath))
		{
			require_once $widgetpath;
		}
	}
}

function pre($str){

	echo "<pre>";
	print_r($str);
	echo "</pre>";
}




