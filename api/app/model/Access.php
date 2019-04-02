<?php
declare(strict_types=1);
namespace app\model;

use app\model\service\Cache;

class Access{
	
	use service\Db;
	
	private static $email;
	private static $pswd;
	private static $user_id;
	private static $token;
	
	public static function checkParametrs(array $arr, array $param):bool{
		foreach($param as $key => $value){
			if(!isset($arr[$value]) or empty($arr[$value]))
				return false;
		}
		return true;
	}
	
	public static function setPswdAndEmail(string $email, string $pswd){
		self::$email = $email;
		self::$pswd = md5($pswd);
	}
	
	public static function setUserIdThroughPswdAndEmail():bool{
		$query = self::$db_session->prepare("SELECT user_id FROM users WHERE user_email = :eml AND user_pswd = :pswd");
		$query->execute(["pswd" => self::$pswd , "eml" => self::$email]);
		$arr = $query->fetch();
		self::$user_id = intval($arr["user_id"]);
		if(self::$user_id > 0){
			return true;	
		}
		return false;
		
	}
	
	public static function createToken():bool{
		self::$token = self::$user_id."_".md5(self::$user_id.random_int(0, 10000). microtime());
		if(!Cache::init()) return false;
		if(!Cache::addToken(self::$token, self::$user_id, 60*10))
			return false;
		return true;
		//echo Cache::getUserIdByToken("2_e696557a2b006efd79cb9ae37a6e6143");
	}
	
	public static function getToken():?string{
		return self::$token;
	}
	 
}