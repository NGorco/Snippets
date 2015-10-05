<?php 

 function PDOconnect(){
	$PDO = new PDO("mysql:host=a53141.mysql.mchost.ru;dbname=a53141_dev", 'a53141_dev', '80679025986');  
	 $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $PDO;
 }
 
 //ALL CONSTANTS
 function mail_headers($name='', $mail=''){
$headers= "MIME-Version: 1.0 \r\n";
$headers .= "Content-type:text/html; charset=UTF-8 \r\n";
$headers .= "From: ".iconv("UTF-8","cp1251",$name)."<".$mail.">";
return $headers;
}


function getHeader(){
	include($_SERVER['DOCUMENT_ROOT'].'/views/header.php');
}

function lockedAccess($return = false,$redir_path = '/'){
	if(!isset($_SESSION['loggedin'])&&!isset($_SESSION['id'])){
		header("Location:".$redir_path); 
	}
}

function setv($v){
	if($v!=""){
		return $v;
	}else{
		return "";
	}
}
		
session_start();

?>