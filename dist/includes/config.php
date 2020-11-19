<?php
	// WINDOWS CREDENTIALS
	// defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
	// defined('DB_USER')   ? null : define("DB_USER", "root");
	// defined('DB_PASS')   ? null : define("DB_PASS", "");
	// defined('DB_PORT')   ? null : define("DB_PORT", "3306");
	// defined('DB_NAME')   ? null : define("DB_NAME", "mkawa");


	// MAC CREDENTIALS
	defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
	defined('DB_USER')   ? null : define("DB_USER", "root");
	defined('DB_PASS')   ? null : define("DB_PASS", "root");
	defined('DB_PORT')   ? null : define("DB_PORT", "3306");
	// defined('DB_SOCKET') ? null : define("DB_SOCKET", "/Applications/MAMP/tmp/mysql/mysql.sock");
	defined('DB_SOCKET') ? null : define("DB_SOCKET", "/tmp/mysql.sock");
	defined('DB_NAME')   ? null : define("DB_NAME", "youlead");
?>