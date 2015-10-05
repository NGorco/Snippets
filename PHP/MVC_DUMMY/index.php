<?php
	/**
	 * PHP Basic MVC Framework Part 7 - Router
	 * By John White (@Jontyy)
	 */
	/*if($_SERVER['REQUEST_URI']=='/'){
	header("HTTP/1.1 301 Moved Permanently"); 
header("Location: http://berize.com/test/view/1"); 
exit();}
	*/
    error_reporting(E_ALL);
	define('SITE_PATH',realpath(dirname(__FILE__)).'/');

	/*Require necessary files.*/
	require_once(SITE_PATH.'application/request.php');
	
	require_once(SITE_PATH.'application/router.php');
	
	require_once(SITE_PATH.'application/baseController.php');
	
	require_once(SITE_PATH.'application/baseModel.php');
	
	require_once(SITE_PATH.'application/load.php');
	require_once(SITE_PATH.'application/registry.php');
	require_once(SITE_PATH.'application/functions.php');
	require_once(SITE_PATH.'controllers/errorController.php');
	try{
		Router::route(new Request);
	}catch(Exception $e){
		$controller = new errorController;
		$controller->error($e->getMessage());
	}
?>