<?php
declare(strict_types=1);

class Reporter{
	private static $array = [   1 => "Ошибка. Максимальный размер файла 5 МБ!",
								2 => "Ошибка. Файл не был передан методом HTTP POST!",
								3 => "Ошибка. Допустимые форматы файла: jpg, png, gif",
								4 => "Ошибка. Загрузка не удалась",
								5 => "Ошибка. Размер файла неккоректен.",
								6 => "Непредвиденная ошибка. Файл не был загружен",
								400 => "Неизвестная ошибка" ];
								
	public static function error_report(int $code):?string{
		return json_encode(["error_code" => $code, "error_description" => self::$array[$code]]);
			
	}
	
	public static function upload_success(string $url):?string{
		return json_encode(["error_code" => 0, "main_img_url" => $url]);
			
	}
	
}