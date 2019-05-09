<?php 
declare(strict_types=1);
namespace app\model\service;

use PDO;
use app\controller\service\Reporter;


trait Db{
	
	private static $db_session;
	
	public static function setDBSession():bool{
		
		$opt = [
				 PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				 PDO::ATTR_EMULATE_PREPARES   => true 
 				];
		try {
			self::$db_session = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME.';charset=utf8', DBUSER, DBPSWD, $opt);
		}
		catch (PDOException $e) {
			Reporter::error_report(100);
			return false;
		}
		return true;
		
	}
	
	public static function getFetch(string $sql, array $params):array{
		$query = self::$db_session->prepare($sql);
		$query->execute($params);
		return $query->fetch();
	}
	
	public static function getFetchAll(string $sql, array $params):array{
		$query = self::$db_session->prepare($sql);
		$query->execute($params);
		return $query->fetchAll();
	}
	
	
}