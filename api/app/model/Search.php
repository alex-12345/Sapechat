<?php
declare(strict_types=1);
namespace app\model;

use app\model\service\ModelModule;
use PDO, DateTime;

class Search extends ModelModule{
	
	use service\Db;
	
	private static $friendList = [];
	public static function getSearchArguments(string $q):array
	{
		$query_arr = explode(" ", $q);
		foreach($query_arr as $key => $value){
			if(mb_strlen($query_arr[$key]) < 2) unset($query_arr[$key]);
		};
		if(count($query_arr) < 2) return [];
		$query_arr = array_slice($query_arr, 0, 2);
		$patern =  '/(ея|а|ии|ой|ого|и|ы|у|ую|юю|ию|ому|ею)$/i';
		$query_arr[0] = preg_replace($patern, '', $query_arr[0]);
		$query_arr[1] = preg_replace($patern, '', $query_arr[1]);
		return $query_arr;
	}
	
	public static function getSearchArray(string $f_p, string $s_p):array
	{
		$f_p = $f_p."%";
		$s_p = $s_p."%";
		$sql = "SELECT user_id, user_first_name, user_last_name, user_img, country_id, city_id, user_birthday FROM users WHERE (user_first_name LIKE :f_a AND user_last_name LIKE :l_a) or (user_first_name LIKE :s_l_a AND user_last_name LIKE :s_f_a) ORDER BY user_id ASC ";
		$query = self::$db_session->prepare($sql);
		$query->bindParam(':f_a', $f_p, PDO::PARAM_STR);
		$query->bindParam(':l_a', $s_p, PDO::PARAM_STR);
		$query->bindParam(':s_l_a', $s_p, PDO::PARAM_STR);
		$query->bindParam(':s_f_a', $f_p, PDO::PARAM_STR);
		$query->execute();
		$priority_arr = $query->fetchAll();
		
		$low_sql = "SELECT user_id, user_first_name, user_last_name, user_img, country_id, city_id, user_birthday FROM users WHERE ((user_first_name NOT LIKE :f_a AND user_last_name LIKE :l_a) OR (user_first_name LIKE :ff_a AND user_last_name NOT LIKE :ll_a)) OR ((user_first_name NOT LIKE :s_l_a AND user_last_name LIKE :s_f_a) OR (user_first_name LIKE :s_ll_a AND user_last_name NOT LIKE :s_ff_a)) ORDER BY user_id ASC ";
		$low_query = self::$db_session->prepare($low_sql);
		$low_query->bindParam(':f_a', $f_p, PDO::PARAM_STR);
		$low_query->bindParam(':l_a', $s_p, PDO::PARAM_STR);
		$low_query->bindParam(':ff_a', $f_p, PDO::PARAM_STR);
		$low_query->bindParam(':ll_a', $s_p, PDO::PARAM_STR);
		
		$low_query->bindParam(':s_l_a', $s_p, PDO::PARAM_STR);
		$low_query->bindParam(':s_f_a', $f_p, PDO::PARAM_STR);
		$low_query->bindParam(':s_ll_a', $s_p, PDO::PARAM_STR);
		$low_query->bindParam(':s_ff_a', $f_p, PDO::PARAM_STR);
		
		$low_query->execute();
		$low_priority = $low_query->fetchAll();
		return array_merge($priority_arr, $low_priority);
	}
	
	public static function getFriendList(int $user_id):array
	{
		$arr = self::getFriendsUserId($user_id);
		foreach($arr as $key => $value){
			array_push(self::$friendList, $value["user_id"]);
		};
		
		return self::$friendList;
		
	}
	
	
	
	public static function getFriendsResults(array $parent_arr):array
	{
		$result_arr =[];
		foreach($parent_arr as $key => $value){
			if(in_array($value['user_id'], self::$friendList)) array_push($result_arr, $value);
		}
		
		return $result_arr;
	}
	
	public static function setAge(array $parent_arr):array
	{
		foreach($parent_arr as $key => $value){
			$birth_date = new DateTime($value['user_birthday']);
			$current_date = new DateTime();
			$age = intval($current_date->format("Y")) - intval($birth_date->format("Y")) - intval($current_date->format("md")<$birth_date->format("md"));
			$parent_arr[$key]['age'] = $age;
		}
		return $parent_arr;
	}
	
	public static function removeMinAge(array $parent_arr, int $min_age):array
	{
		foreach($parent_arr as $key => $value){
			if($value['age'] < $min_age) unset($parent_arr[$key]);
		}
		return $parent_arr;
		
	}
	public static function removeMaxAge(array $parent_arr, int $max_age):array
	{
		foreach($parent_arr as $key => $value){
			if($value['age'] > $max_age) unset($parent_arr[$key]);
		}
		return $parent_arr;
		
	}
	public static function filterCountryId(array $parent_arr, int $country_id):array
	{
		$result_arr =[];
		foreach($parent_arr as $key => $value){
			if($value['country_id'] == $country_id) array_push($result_arr, $value);
		}
		
		return $result_arr;
	}
	public static function filterCityId(array $parent_arr, int $city_id):array
	{
		$result_arr =[];
		foreach($parent_arr as $key => $value){
			if($value['city_id'] == $city_id) array_push($result_arr, $value);
		}
		
		return $result_arr;
	}
	private static function getFriendsUserId(int $id):array
	{
		$sql = "SELECT users.user_id FROM users INNER JOIN relations ON (relations.query_user_id = :id AND relations.answer_user_id = users.user_id AND relations.relation_status = 2) OR (relations.answer_user_id = :l_id AND relations.query_user_id = users.user_id AND relations.relation_status = 2) ";
		$query = self::$db_session->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->bindParam(':l_id', $id, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll();
	}
	
}