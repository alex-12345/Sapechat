<?php
declare(strict_types=1);
namespace app\model;

use app\model\service\{ModelModule, CheckUserRows};
use PDO;

class Settings extends ModelModule{
	use service\Db;
	
	private static $f_name 		= 	NULL;
	private static $l_name 		= 	NULL;
	private static $u_about 	= 	NULL;
	private static $u_birthday	= 	NULL;
	private static $u_gender	= 	NULL;
	private static $u_country	= 	NULL;
	private static $u_city		= 	NULL;
	
	public static function setUserParams(array $data):bool
	{
		
		if(isset($data["user_first_name"])){
			if(!CheckUserRows::checkFirstName($data["user_first_name"]))
				return false;
			self::$f_name = $data["user_first_name"];
		
		}
		
		if(isset($data["user_last_name"])){
			if(!CheckUserRows::checkLastName($data["user_last_name"]))
				return false;
			self::$l_name = $data["user_last_name"];
		
		}
		
		if(isset($data["user_about"])){
			if(!CheckUserRows::checkUserAbout($data["user_about"]))
				return false;
			self::$u_about = $data["user_about"];
		
		}
		
		if(isset($data["user_birthday"])){
			if(!CheckUserRows::checkDate($data["user_birthday"]))
				return false;
			self::$u_birthday = date(intval($data["user_birthday"]["b_y"])."-".intval($data["user_birthday"]["b_m"])."-".intval($data["user_birthday"]["b_d"]));
		
		}
		
		if(isset($data["user_gender"])){
			if(!CheckUserRows::checkGender($data["user_gender"]))
				return false;
			self::$u_gender = intval($data["user_gender"]);
		
		}
		
		if(isset($data["country_id"])){
			if(!CheckUserRows::checkCountryId(self::$db_session, intval($data["country_id"])))
				return false;
			self::$u_country = intval($data["country_id"]);
		
		}
		
		if(isset($data["city_id"]) and isset(self::$u_country)){
			if(!CheckUserRows::checkCityId(self::$db_session, self::$u_country,intval($data["city_id"])))
				return false;
			self::$u_city = intval($data["city_id"]);
		
		}else if(!isset($data["city_id"]) and isset(self::$u_country)){
			self::$u_city = 0;
		}
		
		return true;
	}
	
	public static function commonUpdate(int $user_id):bool{
		$sql = "UPDATE users SET ";
		if(isset(self::$f_name)) $sql .= " user_first_name = :f_name,";
		if(isset(self::$l_name)) $sql .= " user_last_name = :l_name,";
		if(isset(self::$u_about)) $sql .= " user_about = :u_about,";
		if(isset(self::$u_birthday)) $sql .= " user_birthday = '".self::$u_birthday."',";
		if(isset(self::$u_gender)) $sql .= " user_gender = :u_gender,";
		if(isset(self::$u_country)) $sql .= " country_id = :u_country,";
		if(isset(self::$u_city)) $sql .= " city_id = :u_city,";
		$sql = rtrim($sql, ",");
		$sql .= " WHERE user_id = :u_id";
		
		$query = self::$db_session->prepare($sql);
		if(isset(self::$f_name)) $query->bindParam(':f_name', self::$f_name, PDO::PARAM_STR);
		if(isset(self::$l_name)) $query->bindParam(':l_name', self::$l_name, PDO::PARAM_STR);
		if(isset(self::$u_about)) $query->bindParam(':u_about', self::$u_about, PDO::PARAM_STR);
		if(isset(self::$u_gender)) $query->bindParam(':u_gender', self::$u_gender, PDO::PARAM_INT);
		if(isset(self::$u_country)) $query->bindParam(':u_country', self::$u_country, PDO::PARAM_INT);
		if(isset(self::$u_city)) $query->bindParam(':u_city', self::$u_city, PDO::PARAM_INT);
		$query->bindParam(':u_id', $user_id, PDO::PARAM_INT);
		return $query->execute();
		
	}
	
	public static function updatePswd(int $user_id, string $old_pswd, string $new_pswd):bool
	{
			$old_pswd = md5($old_pswd);	
		
			if(!CheckUserRows::checkOldPswd(self::$db_session, $user_id, $old_pswd) or !CheckUserRows::checkPswd($new_pswd))
				return false;
				
			$new_pswd = md5($new_pswd);
			
			$sql = "UPDATE users SET user_pswd = :pswd WHERE user_id = :id";
			$query = self::$db_session->prepare($sql);
			$query->bindParam(':pswd',$new_pswd, PDO::PARAM_STR);
			$query->bindParam(':id', $user_id, PDO::PARAM_INT);
			
			return $query->execute();
			
		
	}
	
}