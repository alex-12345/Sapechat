<?php
declare(strict_types=1);
namespace controllers\service;

class Reporter{
	private static $array = [   1001 => "Ошибка запрошенный контроллер не существет!",
								2 => "Ошибка. Файл не был передан методом HTTP POST!",
								3 => "Ошибка. Допустимые форматы файла: jpg, png, gif",
								4 => "Ошибка. Загрузка не удалась",
								5 => "Ошибка. Размер файла неккоректен.",
								6 => "Непредвиденная ошибка. Файл не был загружен",
								400 => "Неизвестная ошибка" ];
								
	public static function error_report(int $code):?string{
		return json_encode(["error_code" => $code, "error_description" => self::$array[$code]]);
			
	}
	
	public static function success(array $aray):?string{
		return json_encode(["error_code" => 0, "response" => $url]);
			
	}
	
}