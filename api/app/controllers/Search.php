<?php
declare(strict_types=1);
namespace app\controllers;

use app\model\{Search as Model, service\Cache};
use app\controllers\service\{RestrictedAccess, Reporter};


class Search extends RestrictedAccess{
	use service\Singleton;
	
	public function request():bool{
		if(!Model::checkParametrs($_REQUEST, ["query","amount", "start"])) return Reporter::error_report(1);
		$q = $_REQUEST['query'];
		$amount = intval($_REQUEST['amount']);
		$start = intval($_REQUEST['start']);
		$cache_flag = true;
		if(!Cache::init()) $cache_flag = false;
		$cache_result = [];
		if($cache_flag) $cache_result = Cache::getSearchRequest($q);
		if(!empty($cache_result)){
			 $db_array = $cache_result;
		}else{
			if(mb_strlen($q) < 5) return Reporter::error_report(6);
			
			$arr = Model::getSearchArguments($q);
			
			if(count($arr) < 2) return Reporter::error_report(7);
			
			if(!Model::setDBSession()) return false;
			$db_array = Model::getSearchArray($arr[0], $arr[1]);
			$total_amount = count($db_array);
			$cache_size = $total_amount;
			if($cache_size >  325) $cache_size = 325;
			if($cache_flag) Cache::addSearchRequest($q, array_slice($db_array, 0, $cache_size));
		}
		if(isset($_REQUEST['friends'])){
			if(!isset($_REQUEST["token"])) return Reporter::error_report(1);
			if(!parent::setUserId($_REQUEST["token"])) return Reporter::error_report(101);
			Model::getFriendList(self::$current_user_id);
			$db_array = Model::getFriendsResults($db_array);
			$total_amount = count($db_array);
		}
		if(isset($_REQUEST['age_min']) or isset($_REQUEST['age_max'])){
			$db_array = Model::setAge($db_array); 
			$total_amount = count($db_array);
			if(isset($_REQUEST['age_min'])){
				$db_array = Model::removeMinAge($db_array, intval($_REQUEST['age_min']));
				$total_amount = count($db_array);
			}
			if(isset($_REQUEST['age_max'])){
				$db_array = Model::removeMaxAge($db_array, intval($_REQUEST['age_max']));
				$total_amount = count($db_array);
			}
		}
		if(isset($_REQUEST['country_id'])){
			$db_array = Model::filterCountryId($db_array, intval($_REQUEST['country_id']));
			$total_amount = count($db_array);
			if(isset($_REQUEST['city_id'])){
				$db_array = Model::filterCityId($db_array, intval($_REQUEST['city_id']));
				$total_amount = count($db_array);
			}
		}
		return Reporter::output(array_slice($db_array, $start, $amount), $total_amount);		
	}
	
	
	
}