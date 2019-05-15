<?php
declare(strict_types=1);

//$memory = memory_get_usage();
$start = microtime(true);
ini_set('display_errors', "1");

if(isset($_SERVER['HTTP_ORIGIN']) &&  $_SERVER['HTTP_ORIGIN'] == "http://sapechat.ru")
    header("Access-Control-Allow-Origin: http://sapechat.ru");
else
    header("Access-Control-Allow-Origin: http://localhost:8080");

header('Access-Control-Allow-Methods: POST, GET');
//header('Access-Control-Allow-Headers: X-Requested-With, content-type');

//включаем ввывод всех ошибок

//подключаем основную библиотеку и конфигурационный файл
require_once __DIR__."/config.php";



//подключаем основной загрузчик
require_once __DIR__."/app/Loader.php";
//echo "Время работы: ". (microtime(true) - $start)."";
//echo "Память. Вначале - ". $memory.". В конце - ".memory_get_usage();

