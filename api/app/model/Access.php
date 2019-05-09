<?php
declare(strict_types=1);
namespace app\model;

use app\controllers\service\Reporter;
use app\model\service\{Cache, ModelModule, CheckUserRows};
use PDO;

class Access extends ModelModule{
	
	use service\Db;
	
	private static $email;
	private static $pswd;
	private static $user_id;
	private static $token;
	private static $registration_key = '';
	
	public static function setPswdAndEmail(string $email, string $pswd)
	{
		self::$email = $email;
		self::$pswd = md5($pswd);
	}
	
	public static function getUserStatus():int
	{
		$query = self::$db_session->prepare("SELECT user_id, user_status FROM users WHERE user_email = :eml AND user_pswd = :pswd LIMIT 0, 1");
		$query->execute(["pswd" => self::$pswd , "eml" => self::$email]);
		$arr = $query->fetchAll();
		if(count($arr) === 0) return 0;
		self::$user_id = intval($arr[0]["user_id"]);
		return intval($arr[0]["user_status"]);
		
	}
	
	public static function createToken():bool
	{
		self::$token = self::$user_id."_".md5(self::$user_id.random_int(0, 10000). microtime());
		if(!Cache::init()) return false;
		if(!Cache::addToken(self::$token, self::$user_id, 14400))
			return false;
		return true;
	}
	
	public static function getToken():?string
	{
		return self::$token;
	}
	
	
	
	public static function checkCorrectnesSignUpParams(string $f_name, string $l_name, string $pswd, string $eml, array $birthday, int $gender):bool
	{
		if(!CheckUserRows::checkFirstName($f_name)) return false;
		if(!CheckUserRows::checkLastName($l_name)) return false;
		if(!CheckUserRows::checkPswd($pswd)) return false;
		if(filter_var($eml, FILTER_VALIDATE_EMAIL) === false) return Reporter::error_report(33);
		if(!CheckUserRows::checkDate($birthday)) return false;
		if(!CheckUserRows::checkGender($gender)) return false;
		return true;
		
		
	}
	public static function checkEmailInDB(string $eml):bool
	{
		$query = self::$db_session->prepare("SELECT user_id FROM users WHERE user_email = :eml LIMIT 0,1");
		$query->bindParam(':eml', $eml, PDO::PARAM_STR);
		$query->execute();
		if(count($query->fetchAll()) !== 0)
			return true;	
		return false;
	}
	 
	 public static function registerNewUser(string $f_name, string $l_name, string $pswd, string $eml, int $b_d, int $b_m, int $b_y, int $gender):int
	 {
		 $birthday = date("$b_y-$b_m-$b_d");
		 $sql = "INSERT INTO users(user_first_name, user_last_name, user_pswd, user_email, user_birthday, user_gender, user_status, user_registration_key) VALUES (:f_name, :l_name, :pswd, :eml, '$birthday', :gender, 1, :reg_key)";
		self::$registration_key = sha1(strval(random_int(0, 10000)+time()).$l_name);
		$query = self::$db_session->prepare($sql);
		$pswd_hash = md5($pswd);
		$query->bindParam(':f_name', $f_name, PDO::PARAM_STR);
		$query->bindParam(':l_name', $l_name, PDO::PARAM_STR);
		$query->bindParam(':pswd', $pswd_hash, PDO::PARAM_STR);
		$query->bindParam(':eml', $eml, PDO::PARAM_STR);
		$query->bindParam(':gender', $gender, PDO::PARAM_INT);
		$query->bindParam(':reg_key', self::$registration_key, PDO::PARAM_STR);
		return ($query->execute())? intval(self::$db_session->lastInsertId()): 0;
	}
	
	public static function getRegKey():string
	{
		return self::$registration_key;
	}
	
	public static function setConfirmationRegTime(int $user_id):bool
	{
		if(!Cache::init()) return false;
		if(!Cache::setRegistrionConfirmationTime(self::$registration_key, $user_id)) return false;
		Cache::disconnect();
		return true;
		
	}
	
	public static function checkConfirmationRegData(int $user_id, string $key):array
	{
		Cache::init();
		return Cache::getRegistrionConfirmationData($key);
		
	}
	
	public static function removeSession(string $token):bool
	{
		if(!Cache::init()) return Reporter::error_report(101);
		return (Cache::removeToken($token))? true : Reporter::error_report(16); 	
	}
}