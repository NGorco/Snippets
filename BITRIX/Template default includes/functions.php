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