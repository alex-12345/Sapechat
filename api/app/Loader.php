<?php
declare(strict_types=1);

$query = rtrim($_SERVER['REQUEST_URI'], '/');

//require_once __DIR__.'/../../vendor/autoload.php';
//$db = new MongoDB\Client("mongodb://127.0.0.1:27017");

use app\controllers\service\Router as Router;
use app\controllers\service\Reporter as Reporter;

spl_autoload_register(function ($class_name) {
	$class_name = str_replace('\\', '/', $class_name);
	$i = strrpos($class_name, '/');
	$latter = ucfirst($class_name[$i+1]);
	$class_name[$i+1] = $latter;
    $file = __DIR__.'/../'.$class_name.'.php';
	if(!file_exists($file)){
		Reporter::error_report(10);
		exit();
	}
	require_once $file;
});

Router::add('/(?<controller>[a-z]+)-(?<action>[a-z]+)');

if(!Router::dispatch($query)){
		exit();
};
