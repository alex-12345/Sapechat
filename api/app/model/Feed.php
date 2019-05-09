<?php
declare(strict_types=1);
namespace app\model;

use app\model\service\ModelModule;
use PDO;

class Feed extends ModelModule{
	use service\Db;
	
	public static function getBriefUserData(int $user_id):array
	{
		$query = self::$db_session->prepare("SELECT user_id, user_first_name, user_last_name, user_img, user_email FROM users WHERE user_id = :id");
		$query->bindParam(':id', $user_id, PDO::PARAM_INT);
		$query->execute();
		return $query->fetch();
		
	}
	
	public static function getFriendsFeed(int $user_id, int $start, int $amount):array
	{
		$query = self::$db_session->prepare("SELECT users.user_id, users.user_first_name, users.user_last_name, users.user_img, posts.post_id, posts.post_content, posts.post_utc_date FROM posts INNER JOIN users ON (users.user_id= posts.user_id AND (posts.user_id IN (SELECT answer_user_id FROM relations WHERE relation_status = 2 AND query_user_id = :q_id ) OR  posts.user_id IN (SELECT query_user_id FROM relations WHERE relation_status = 2 AND answer_user_id = :q_id))) ORDER BY posts.post_id LIMIT :start, :amount");
		$query->bindParam(':q_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':a_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':start', $start, PDO::PARAM_INT);
		$query->bindParam(':amount', $amount, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll();
	}
	
}