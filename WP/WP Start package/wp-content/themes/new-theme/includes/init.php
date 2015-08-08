<?php
/*
 * @package Massique
 * @subpackage Base_Theme
 */

if (!is_admin()) 
{
	define ('TPL', get_template_directory_uri());

	wp_enqueue_style('main-styles', TPL . '/style.css');

	wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?v=3.exp', array('jquery'));
	wp_enqueue_script('common-theme-scripts', TPL . '/js/common.js', array('jquery'));
}

add_theme_support('post-thumbnails');

register_sidebar( array(
	'name' => 'Secondary Sidebar',
	'description' => 'The secondary widget area',
	'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

register_nav_menus( array(
	'main' => 'Main Navigation Menu',
	'secondary' => 'Secondary navigation Menu'
) );


function pre($str){

	echo "<pre>";
	print_r($str);
	echo "</pre>";
}

function custom_excerpt_length( $length )
{
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

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

load_modules(__DIR__);