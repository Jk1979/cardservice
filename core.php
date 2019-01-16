<?php
//--- Ядро сайта ---//
//ob_start();
//session_start();

define('H', $_SERVER['DOCUMENT_ROOT'] . '/');

// Подключаем файл с настройками
include_once H . 'app/config/config.php';

$include = realpath(__DIR__.'/');
set_include_path(get_include_path().PATH_SEPARATOR.$include);
spl_autoload_register(function($className) {
	$fileName = stream_resolve_include_path(
		strtr(ltrim($className, '\\'), '\\', '/').'.php'
	);
	
	if ($fileName) {
		require_once $fileName;
	}
});


 $db = Mysql\Client::init( $dbuser, $dbpassword)
 ->defaultDb($db_name)
 ->charset('utf8');




     

 







	

