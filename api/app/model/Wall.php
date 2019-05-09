<?php
declare(strict_types=1);
namespace app\model;

use app\model\service\ModelModule;
use PDO;

class Wall extends ModelModule{
	use service\Db;
	public static function addPost(int $user_id, string $text, int $wall_id):int{
		$time = gmdate("Y-m-d H:i:s ");
		$query = self::$db_session->prepare("INSERT INTO posts (post_content, post_utc_date, user_id, wall_id) VALUES (:text, '$time', :u_id, :w_id)");
		$query->bindParam(':u_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':w_id', $wall_id, PDO::PARAM_INT);
		$query->bindParam(':text', $text, PDO::PARAM_STR);
		$query->execute();
		$instance = stream_socket_client("tcp://127.0.0.1:1234");
		fwrite($instance, json_encode(['user' => $user_id, 'message' => $text])  . "\n");
		fclose($instance);
		return intval(self::$db_session->lastInsertId());
	}
	
	
	public static function removePost(int $user_id, int $post_id):bool{
		$query = self::$db_session->prepare("DELETE FROM posts WHERE post_id = :p_id AND (user_id = :u_id OR wall_id = :w_id)");
		$query->bindParam(':u_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':w_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':p_id', $post_id, PDO::PARAM_INT);
		$query->execute();
		return boolval($query->rowCount());
	}
}