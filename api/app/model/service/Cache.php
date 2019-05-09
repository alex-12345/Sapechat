<?php
declare(strict_types=1);
namespace app\model\service;

use Memcache; 


class Cache{
	private static $cache; 
	
	public static function init():bool{
		self::$cache = new Memcache;
		return self::$cache->connect('localhost', 11211);
	}
	public static function addToken(string $token, int $user_id, int $time):bool
	{
		return self::$cache->add($token, ["user_id" => $user_id, "last_update" => time()], 0, $time);	
	}
	
	public static function getCacheUserIdByTokenAndUpdateTime(string $token):int
	{
		$cahe_arr = self::$cache->get($token);
		if(!$cahe_arr) return 0;
		self::updateTimeByToken($token, $cahe_arr["user_id"], intval($cahe_arr["last_update"]));
		return intval($cahe_arr["user_id"]);	
	}
	
	public static function updateTimeByToken(string $token, int $user_id, int $last_update)
	{
		if(time() - $last_update > 7200){
			self::$cache->replace($token, ["user_id" => $user_id, "last_update" => time()], 0, 14400);
		}
	}
	
	public static function removeToken(string $token):bool
	{
		return self::$cache->delete($token);	
	}
	
	public static function disconnect()
	{
		self::$cache = NULL;
	}
	
	public static function setRegistrionConfirmationTime(string $regkey, int $user_id):bool
	{
		$time = 60*60*24*3;
		return self::$cache->add($regkey, ["user_id" => $user_id], 0, $time);	
	}
	public static function getRegistrionConfirmationData(string $regkey):array
	{
		return self::$cache->get($regkey);	
	}
	public static function removeRegistrionConfirmationData(string $regkey):bool
	{
		return self::$cache->delete($regkey);	
	}
	
	public static function addSearchRequest(string $request, array $data):bool
	{
		return self::$cache->add("_search_".$request, $data, 0, 120);	
	}
	
	public static function getSearchRequest(string $request):array
	{
		$arr = self::$cache->get($request);
		if($arr !== false){
			self::$cache->replace("_search_".$request, $data, 0, 120);
			return $arr;
		}
		return [];	
	}
	
}