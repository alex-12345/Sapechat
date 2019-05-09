<?php
declare(strict_types=1);
namespace app\model;

use app\model\service\ModelModule;
use PDO;

class User extends ModelModule{
	
	use service\Db;
	
	private static $id;
	private static $parametrs = [];
	
	public static function checkAndSetParametrs(string $params):bool{
		$availableParams = ['user_id','user_first_name','user_last_name','user_last_name','user_img','user_birthday','user_email','user_about','country_id','city_id','city_name','country_name'];
		
		$rows = explode(",", $params);
		
		foreach($rows as $key => $value){
			if(!in_array($value,$availableParams)) {
				return false;
			}
			if(stripos($value, "user") !== false){
				self::$parametrs[$key] = 'users.'.$value;
			}else if(stripos($value, "country") !== false){
				self::$parametrs[$key] = 'countries.'.$value;
			}else{
				self::$parametrs[$key] = 'cities.'.$value;
			}
		}
		return true;
		
	}
	/*
	 * Вывод информации о пользователе согласно параметрам
	 * @param int id  - id пользователя 
	 * @return array
	 */	
	 
	public static function getUserInfoByParametrs(int $id):array{
		$params = implode(",",self::$parametrs);
		$sql = "SELECT ".$params." FROM users,cities,countries WHERE countries.country_id = users.country_id AND cities.city_id = users.city_id AND user_id = :id LIMIT 0, 1";
		return self::getFetch($sql, ['id'=>$id]);
		
	}
	/*
	 * Получение списка друзей
	 * @param int id  - id пользователя 
	 * @param int amount  - количество вывода 
	 * @param int start  - начиная с  
	 * @param bool random  - флаг рандомного порядка
	 * @return array
	 */	
	public static function getFriends(int $id, int $amount, int $start, bool $random):array{
		$sql = "SELECT users.user_id, users.user_first_name, users.user_last_name, users.user_img, relations.relation_date FROM users INNER JOIN relations ON (relations.query_user_id = :id AND relations.answer_user_id = users.user_id AND relations.relation_status = 2) OR (relations.answer_user_id = :l_id AND relations.query_user_id = users.user_id AND relations.relation_status = 2) ";
		($random) ? $sql .= "ORDER BY RAND() " : $sql .= "ORDER BY relations.relation_date DESC ";
		$sql .= "LIMIT :start, :amount";
		$query = self::$db_session->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->bindParam(':l_id', $id, PDO::PARAM_INT);
		$query->bindParam(':start', $start, PDO::PARAM_INT);
		$query->bindParam(':amount', $amount, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll();
	}
	
	
	
	/*
	 * вывод количества друзей у пользователя id 
	 */
	public function getFriendsCount(int $id):int{
		$query = self::$db_session->prepare("SELECT COUNT(relation_id) as r_count FROM relations WHERE (query_user_id = :id OR answer_user_id = :a_id) AND relation_status = 2");
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->bindParam(':a_id', $id, PDO::PARAM_INT);
		$query->execute();
		$arr = $query->fetch();
		return intval($arr['r_count']);
	}
	
	/* вывод постов со страницы пользователя
	 * @param int id - страница кользователя
	 * @param int amount - в количестве
	 * @param int start - Начиная с 
	 * @param bool flag - если указан то выводить только посты пользователя
	 * @return array
	 */
	 
	 public static function getPostsFromPage(int $id, int $amount, int $start, bool $flag):array{
		 $sql = "SELECT posts.post_id, posts.post_content, posts.post_time, posts.post_utc_date, posts.wall_id, posts.user_id, users.user_first_name, users.user_last_name, users.user_img FROM posts, users WHERE  users.user_id = posts.user_id AND ";
		 
		($flag) ? $sql .= " posts.user_id = :id AND posts.wall_id = :w_id " : $sql .= " posts.wall_id = :id ";
		
		$sql .= " ORDER BY posts.post_id DESC LIMIT :start, :amount";
		$query = self::$db_session->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		if($flag) $query->bindParam(':w_id', $id, PDO::PARAM_INT);
		$query->bindParam(':start', $start, PDO::PARAM_INT);
		$query->bindParam(':amount', $amount, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll();
		
		 
	 }
	 
	 /*
	 * вывод количества постов у пользователя id 
	 */
	public function getPostsCount(int $id, bool $flag):int{
		 $sql = "SELECT COUNT(post_id) as p_count FROM posts WHERE ";
		($flag) ? $sql .= " user_id = :id AND wall_id = :w_id " : $sql .= " wall_id = :id ";
		$query = self::$db_session->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		if($flag) $query->bindParam(':w_id', $id, PDO::PARAM_INT);
		$query->execute();
		$arr = $query->fetch();
		return intval($arr['p_count']);
	}
	
	public function userExistenceCheck(int $user_id):bool{
		if(!self::setDBSession()) exit();
		$sql = "SELECT user_id FROM users WHERE user_id = :id AND user_status = 2 LIMIT 0, 1";
		$query = self::$db_session->prepare($sql);
		$query->bindParam(':id', $user_id, PDO::PARAM_INT);
		$query->execute();
		if(count($query->fetchAll()) == 0) return false;
		return true;
		
		
	}
	
}