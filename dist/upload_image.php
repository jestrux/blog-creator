<?php

$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

if ($fn) {
	$relative_path = 'uploads/' . $fn;

	file_put_contents(
		$relative_path,
		file_get_contents('php://input')
	);
	echo getBaseUrl() . '/' . $relative_path;
	exit();
}else{
	exit();
}

function getBaseUrl() {
	// output: /myproject/index.php
	$currentPath = $_SERVER['PHP_SELF'];
	
	// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
	$pathInfo = pathinfo($currentPath);
	
	// output: localhost
	$hostName = $_SERVER['HTTP_HOST'];
	
	// output: http://
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
	
	// return: http://localhost/myproject/
	return $protocol.$hostName."/";
}