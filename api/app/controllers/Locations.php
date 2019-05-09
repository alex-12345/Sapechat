<?php
declare(strict_types=1);
namespace app\controllers;

use app\model\Locations as Model;
use app\controllers\service\Reporter;


class Locations{
	use service\Singleton;
	
	public function getCountries():bool{
		if(!Model::setDBSession()) return false;
		return Reporter::output(Model::getCountries());
	}
	
	public function getCities():bool{
		if(!isset($_REQUEST["country_id"]))
			return Reporter::error_report(1);
		if(!Model::setDBSession()) return false;
		return Reporter::output(Model::getCities(intval($_REQUEST["country_id"])));
	}
	
	
	
}