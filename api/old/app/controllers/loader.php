<?php

$query = rtrim($_SERVER['REQUEST_URI'], '/');

require_once __DIR__.'/../../vendor/autoload.php'; 
$db = new MongoDB\Client("mongodb://127.0.0.1:27017");

//загружаем имена используемых классы
use controllers\service\Router as Router;

//Функция автозагрузки классов
spl_autoload_register(function ($class_name) {
	$class_name = str_replace('\\', '/', $class_name);
	$i = strrpos($class_name, '/');
	$latter = ucfirst($class_name[$i+1]);
	$class_name[$i+1] = $latter;
    $file = __DIR__.'./../'.$class_name.'.php';
	if(file_exists(__DIR__.'/../'.$class_name.'.php')){
		require_once $file;
	}else{
		systemError(8, "Ошибка такого контролера не существует!");
	}
	
});

Router::add('/(?<controller>[a-z]+)-(?<action>[a-z]+)');

Router::dispatch($query);
