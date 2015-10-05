<?php
/*
Plugin Name: Full Use Subscribe
Version: 1.0
Description: Very basic functionality of subscribe page. You can add, remove subscibers. Mails sent when you publish some post_type 'post' item.
Author: Massique
Author URI: http://massique.com/
*/

wp_enqueue_script('fs-subscribe-ajax', plugin_dir_url(__FILE__) . '/includes/fs-subscribe.js', array('jquery'));

define ('TABLE_NAME','fs_subscribe_list');

include_once( __DIR__ .  '/includes/admin.php');

register_activation_hook( __FILE__ ,'install');
register_uninstall_hook( __FILE__ , 'uninstall');

function install(){	

	global $wpdb;
	$wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}" . TABLE_NAME . "` (id INT PRIMARY KEY AUTO_INCREMENT, email TEXT)");
}

function uninstall(){

	global $wpdb;
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}" . TABLE_NAME );	
}

?>