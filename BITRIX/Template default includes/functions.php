<?php


function pred($str){

	echo "<details style='position:absolute; z-index:2; background:white;' onclick='this.removeAttribute(\"open\")'>
  <summary>DEBUG</summary><pre>";
		print_r($str);
	echo "</pre></details>";
}


function pre($str){

	echo "<pre>";
		print_r($str);
	echo "</pre>";
}

function am_log($var) {

	file_put_contents($_SERVER['DOCUMENT_ROOT'].'/log.txt', print_r($CML2_LINK, true), FILE_APPEND);
}