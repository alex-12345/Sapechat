<?php 
declare(strict_types=1);
namespace app\controllers\service;

use app\model\service\Cache;

class RestrictedAccess{
	
	protected static $current_user_id = 0;
	
	protected static function setUserId(string $token):bool{
		if(!Cache::init()) return false;
		self::$current_user_id = Cache::getCacheUserIdByTokenAndUpdateTime($token);
		Cache::disconnect();
		if(self::$current_user_id === 0) return false;
		return true;
		
		
	}
	
	
}