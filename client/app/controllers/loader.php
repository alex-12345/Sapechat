<?php
declare(strict_types=1);

$query = rtrim($_SERVER['REQUEST_URI'], '/');

use controllers\service\Router as Router;


spl_autoload_register(function ($class_name) {
	$class_name = str_replace('\\', '/', $class_name);
	$i = strrpos($class_name, '/');
	$latter = ucfirst($class_name[$i+1]);
	$class_name[$i+1] = $latter;
    $file = __DIR__.'./../'.$class_name.'.php';
	if(!file_exists(__DIR__.'/../'.$class_name.'.php')){
		http_response_code(404);
		exit;
	}
	require_once $file;
	
});
Router::add('^$', ['controller' => 'Profile']);
Router::add('/(?<controller>[a-z]+)(?<id>[0-9]+)');
Router::add('/(?<controller>[a-z]+)');
if(!Router::dispatch($query)){
		http_response_code(404);
		exit;
};

