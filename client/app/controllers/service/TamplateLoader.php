<?php
declare(strict_types=1);
namespace controllers\service;

class TamplateLoader{
	public static $css = [];
	public static $js = [];
	public static function load(array $tamplates_arr, array $css, array $js):?bool{
		self::$css = $css;
		self::$js = $js;
		foreach($tamplates_arr as $key => $value){
			require_once __DIR__."./../../view/".$value.".tpl";
		}
		return true;
	}
}