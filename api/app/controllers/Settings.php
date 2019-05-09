<?php
declare(strict_types=1);
namespace app\controllers;

use app\model\Settings as Model;
use app\controllers\service\{RestrictedAccess, Reporter};


class Settings extends RestrictedAccess
{
	use service\Singleton;
	
	public function changeSettings():bool
	{
		
		/*$arr = ["token" => "1_2b2705f6da8a5950577bf23a732fea49",
				"data"  => ["country_id" => 2, 
							"city_id" => 2, 
							"user_about" => "1Стоит отметить, что значение cookie перед отправкой клиенту подвергается URL-кодированию. При обратном получении значение cookie декодируется и помещается в переменную, с тем же именем, что и имя cookie1",
							"user_first_name" => "Алексей",
							"user_last_name"  => "Винников2",
							"user_birthday" => [
								"b_d" => 12,
								"b_m" => 01,
								"b_y" => 2012],
							"user_gender" => 1]
				];
			$_REQUEST = $arr	
				*/
		if(!Model::checkParametrs($_REQUEST,["token","data"]))
			return Reporter::error_report(1);
		
		if(!parent::setUserId($_REQUEST["token"]))
			return Reporter::error_report(101);			
			
		if(!Model::checkParametrsAvalibles($_REQUEST["data"],["country_id","city_id","user_about", "user_first_name", "user_last_name","user_birthday","user_gender"]))
			return Reporter::error_report(3);
		
		if(!Model::setDBSession()) return false;
		if(!Model::setUserParams($_REQUEST["data"])) return false;
		Model::commonUpdate(self::$current_user_id);
		return Reporter::output_no_errors();
	}
	
	public function changePswd():bool
	{
		if(!Model::checkParametrs($_REQUEST,["token","old_pswd","new_pswd"]))
			return Reporter::error_report(1);
		if(!parent::setUserId($_REQUEST["token"]))
			return Reporter::error_report(12);
		if(!Model::setDBSession()) return false;
		if(!Model::updatePswd(self::$current_user_id, $_REQUEST["old_pswd"], $_REQUEST["new_pswd"])) return false;	
				
		return Reporter::output_no_errors();
	}
	
	public function changeEmail():bool
	{
		
		return Reporter::output_no_errors();
	}
	
	public function changeUserImg():bool
	{
		
		return Reporter::output_no_errors();
	}
	
	
	
}