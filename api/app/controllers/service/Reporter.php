<?php
declare(strict_types=1);
namespace app\controllers\service;

class Reporter{
	private static $array = [   1 => "Ошибка. Не все необходимые для данного метода параметры переданы!",
								2 => "Ошибка! Вы ввели неверный email или пароль.",
								10 => "Запрошенный контроллер не существет",
								
								11 => "Метод запрошенного контроллера не существует",
								100 => "Ошибка. Сбой при подключении к БД.",
								101 => "Ошибка. Сбой при подключении к кэш серверу."
								
							];
								
	public static function error_report(int $code):bool{
		echo json_encode(["error_code" => $code, "error_description" => self::$array[$code]]);
		return false;
			
	}
	
	public static function output(array $array){
		echo json_encode(["error_code" => 0, "data" => $array]);
			
	}
	
}