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
	public static function addToken(string $token, int $user_id, int $time):bool{
		return self::$cache->add($token, ["user_id" => $user_id], 0, $time);	
	}
	
	public static function getUserIdByToken(string $token):int{
		$arr = self::$cache->get($token);
		return intval($arr['user_id']);	
	}
	
	
}