<?php
declare(strict_types=1);
namespace app\model\service;


class ModelModule{
	
	public static function checkParametrs(array $arr, array $param):bool{
		foreach($param as $key => $value){
			if(!isset($arr[$value]) or $arr[$value] === "")
				return false;
		}
		return true;
	}
	
	public static function checkParametrsAvalibles(array $arr, array $param):bool{
		if(empty($arr)) return false;
		foreach($arr as $key => $val){
			if(!in_array($key, $param))
				 return false;
		}
		return true;
		
	}
	
	
}