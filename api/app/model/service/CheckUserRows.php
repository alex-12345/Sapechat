<?php
declare(strict_types=1);
namespace app\model\service;

use app\controllers\service\Reporter;
use PDO;

class CheckUserRows{
	
	private static function checkLength(string $str, int $min, int $max):bool
	{
		$lenght = mb_strlen($str);
		if($lenght < $min or $lenght > $max) return false;
		return true;	
	}
	
	public static function checkFirstName(string $f_name):bool
	{
		if(!self::checkLength($f_name, 2, 20)) return Reporter::error_report(30);
		return true;
	}
	
	public static function checkLastName(string $l_name):bool
	{
		if(!self::checkLength($l_name, 2, 20)) return Reporter::error_report(31);
		return true;
	}
	
	public static function checkPswd(string $pswd):bool
	{
		if(!self::checkLength($pswd, 7, 20)) return Reporter::error_report(32);
		return true;
	}
	
	public static function checkUserAbout(string $pswd):bool
	{
		if(!self::checkLength($pswd, 5, 400)) return Reporter::error_report(37);
		return true;
	}
	
	public static function checkEmail(string $eml):bool
	{
		if(filter_var($eml, FILTER_VALIDATE_EMAIL) === false) return Reporter::error_report(33);
		return true;
		
	}
	
	public static function checkDate(array $date):bool
	{
		if(!isset($date["b_d"]) or !isset($date["b_m"]) or !isset($date["b_y"])) return Reporter::error_report(34);
		$b_d = intval($date["b_d"]);
		$b_m = intval($date["b_m"]);
		$b_y = intval($date["b_y"]);
		$current_year = intval(date('Y'));
		if(!checkdate($b_m, $b_d, $b_y) or (($current_year-7) < $b_y)) return Reporter::error_report(34);
		return true;
	}
	
	public static function checkGender(int $gender):bool
	{
		if($gender !== 0 and $gender !== 1) return Reporter::error_report(36);
		return true;
	}
	
	public static function checkEmailInDB(PDO $db_session, string $eml):bool
	{
		$query = $db_session->prepare("SELECT user_id FROM users WHERE user_email = :eml LIMIT 0,1");
		$query->bindParam(':eml', $eml, PDO::PARAM_STR);
		$query->execute();
		if(count($query->fetchAll()) !== 0)
			return true;	
		return false;
	}
	
	public static function checkCountryId(PDO $db_session, int $country_id):bool
	{
		if($country_id === 0) return true;
		$query = $db_session->prepare("SELECT count(country_id) as amount FROM countries WHERE country_id = :country_id LIMIT 0,1");
		$query->bindParam(':country_id', $country_id, PDO::PARAM_INT);
		$query->execute();
		if(intval($query->fetch()['amount']) !== 0)
			return true;	
		return Reporter::error_report(38);
	}
	
	public static function checkCityId(PDO $db_session, int $country_id, int $city_id):bool
	{
		if($city_id === 0) return true;
		$query = $db_session->prepare("SELECT count(city_id) as amount FROM cities WHERE country_id = :country_id AND city_id = :city_id LIMIT 0,1");
		$query->bindParam(':country_id', $country_id, PDO::PARAM_INT);
		$query->bindParam(':city_id', $city_id, PDO::PARAM_INT);
		$query->execute();
		if(intval($query->fetch()['amount']) !== 0)
			return true;	
		return Reporter::error_report(39);
		
		
	}
	
	public static function checkOldPswd(PDO $db_session, int $user_id, string $old_pswd):bool
	{
		$query = $db_session->prepare("SELECT count(user_id) as amount FROM users WHERE user_id = :id and user_pswd = :pswd LIMIT 0,1");
		$query->bindParam(':id', $user_id, PDO::PARAM_STR);
		$query->bindParam(':pswd', $old_pswd, PDO::PARAM_STR);
		$query->execute();
		if(intval($query->fetch()['amount']) !== 0)
			return true;	
		return Reporter::error_report(41);
	}
	
}
	