<?php
declare(strict_types=1);
namespace app\controllers;

use app\model\{Feed as Model, User};
use app\controllers\service\{RestrictedAccess, Reporter};


class Feed extends RestrictedAccess{
	use service\Singleton;
	
	public function getUserDataBrief():bool{
		if(!isset($_REQUEST["token"]))
			return Reporter::error_report(1);
		
		if(!parent::setUserId($_REQUEST["token"])) return Reporter::error_report(101);
		if(!Model::setDBSession()) return false;
		
		return Reporter::output(Model::getBriefUserData(self::$current_user_id));
	}
	
	public function getFriendsFeed():bool{
		if(!Model::checkParametrs($_REQUEST,["token","start","amount"]))
			return Reporter::error_report(1);
		
		if(!parent::setUserId($_REQUEST["token"])) return Reporter::error_report(101);
		if(!Model::setDBSession()) return false;
		
		return Reporter::output(Model::getFriendsFeed(self::$current_user_id, intval($_REQUEST["start"]), intval($_REQUEST["amount"])));
		
	}
	
	
	
	
}