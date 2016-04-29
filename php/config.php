<?php 	
/**
 * root folder for this project
 */
function base_url() {
	$currentPath = $_SERVER['PHP_SELF']; // or alternatively $_SERVER['SERVER_NAME'] will generate the same
	
	// output: Array ( [dirname] => /QuestionBank [basename] => index.php [extension] => php [filename] => index ) 
	$pathInfo = pathinfo($currentPath); 
	
	// output: localhost
	$hostName = $_SERVER['HTTP_HOST']; 
	
	// output: http://
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
	
	// return: http://localhost/QuestionBank/
	return $protocol.$hostName.'/realestate/';
}

define( "ROOT", $_SERVER['DOCUMENT_ROOT'] . "/realestate/" );

/**
 * asset folder path for this projcet
 */
define("ASSETS_PATH", base_url() . "assets/");

/**
 * css folder path
 */
define("CSS_PATH" , ASSETS_PATH . "css/");
/**
 * css folder path
 */
define("JS_PATH" , ASSETS_PATH . "js/");

define("UPLOADS_PATH" , base_url() . "uploads/");

