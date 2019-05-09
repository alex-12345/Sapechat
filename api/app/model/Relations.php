<?php
declare(strict_types=1);
namespace app\model;

use app\model\service\ModelModule;
use PDO;

class Relations extends ModelModule{
	
	use service\Db;
	
		
	public static function checkRelation(int $user_id, int $friend_id):int{
		
		$sql = "SELECT relation_status FROM relations WHERE (query_user_id = :q_id AND  answer_user_id = :a_id) OR (answer_user_id = :s_q_id AND  query_user_id = :s_a_id) LIMIT 0, 1 ";
		
		$query = self::$db_session->prepare($sql);
		$query->bindParam(':q_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':a_id', $friend_id, PDO::PARAM_INT);
		$query->bindParam(':s_q_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':s_a_id', $friend_id, PDO::PARAM_INT);
		$query->execute();
		
		$arr_status = $query->fetchAll();
		if(empty($arr_status)) return 0;
		return intval($arr_status[0]['relation_status']);
		
	}
	
	public static function addFriendRequest(int $user_id, int $friend_id):bool{
		$time = date("Y-m-d");
		$sql = "INSERT INTO relations (query_user_id, answer_user_id, relation_status, relation_date) VALUES (:q_id, :a_id, 1, '$time')";
		$query = self::$db_session->prepare($sql);
		
		$query->bindParam(':q_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':a_id', $friend_id, PDO::PARAM_INT);
		
		return $query->execute();
		
		
	}
	
	public static function acceptOrRejectFriendRequest(int $user_id, int $friend_id, int $new_status):bool{
		
		$sql ="UPDATE  relations SET relation_status = :status WHERE (answer_user_id = :q_id AND  query_user_id = :a_id)";
		
		$query = self::$db_session->prepare($sql);
		$query->bindParam(':status', $new_status, PDO::PARAM_INT);
		$query->bindParam(':q_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':a_id', $friend_id, PDO::PARAM_INT);
		$query->execute();
		return boolval($query->rowCount());
		
	}
	
	public static function cancelFriendRequest(int $user_id, int $friend_id):bool{
		
		$sql ="DELETE FROM relations WHERE answer_user_id = :a_id AND  query_user_id = :q_id AND (relation_status = 1 OR relation_status = 3)";
		
		$query = self::$db_session->prepare($sql);
		$query->bindParam(':q_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':a_id', $friend_id, PDO::PARAM_INT);
		$query->execute();
		return boolval($query->rowCount());
		
	}
	
	
	public static function removeFromFriends(int $user_id, int $friend_id):bool{
		$sql ="UPDATE  relations SET relation_status = 3, answer_user_id = :q , query_user_id = :a WHERE (answer_user_id = :a_id AND query_user_id = :q_id AND relation_status = 2) OR (answer_user_id = :s_a_id AND  query_user_id = :s_q_id  AND relation_status = 2)";
		
		$query = self::$db_session->prepare($sql);
		
		$query->bindParam(':q', $user_id, PDO::PARAM_INT);
		$query->bindParam(':a', $friend_id, PDO::PARAM_INT);
		$query->bindParam(':q_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':a_id', $friend_id, PDO::PARAM_INT);
		$query->bindParam(':s_a_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':s_q_id', $friend_id, PDO::PARAM_INT);
		
		$query->execute();
		return boolval($query->rowCount());
		
		
	}
	
	
	
	
}