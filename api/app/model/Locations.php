<?php
declare(strict_types=1);
namespace app\model;

use app\model\service\ModelModule;
use PDO;

class Locations extends ModelModule{
	use service\Db;
	public static function getCountries():array{
		$query = self::$db_session->prepare("SELECT * FROM countries ORDER BY country_name");
		$query->execute();
		return $query->fetchAll();
	}
	
	
	public static function getCities(int $country_id):array{
		$query = self::$db_session->prepare("SELECT city_id, city_name FROM cities WHERE country_id = :id ORDER BY city_name");
		$query->bindParam(':id', $country_id, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll();
	}
}