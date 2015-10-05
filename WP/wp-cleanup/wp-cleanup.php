<?php
/*
Plugin Name: WP-Cleanup
Plugin URI: http://www.jortk.nl/wp-cleanup-optimize-and-cleanup-your-wordpress-database/
Description: Cleanup your Wordpress database in one click!
Version: 1.1.0
Author: JortK
Author URI: http://www.jortk.nl
*/

function cleanup_admin() {
	include('wp-cleanup-admin.php');
}

function cleanup_admin_actions() {
	add_options_page('WP-Cleanup', 'WP-Cleanup', 'administrator', 'WP-Cleanup', 'cleanup_admin');
}

add_action('admin_menu', 'cleanup_admin_actions');
?>
