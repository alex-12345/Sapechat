<?php
declare(strict_types=1);
namespace app\controllers;

use app\model\{Access as Model, service\Mailer};
use app\controllers\service\Reporter;


class Access {
	
	use service\Singleton;
	/*
	 * Создание токена через авторизацию
	 * @param http[email] - email пользователя
	 * @param http[pswd] - пароль пользователя
	 * return bool false - ошибка/ true - успех
	 */
	 
	public function signIn():bool
	{
		if(!Model::checkParametrs($_REQUEST, ["pswd","email"]))
			return Reporter::error_report(1);
			
		
		Model::setPswdAndEmail($_REQUEST["email"],$_REQUEST["pswd"]);
		
		if(!Model::setDBSession())
			return false;
		
		$user_status = Model::getUserStatus();
		if($user_status == 0)
			return Reporter::error_report(2);
		if($user_status == 1){
			return Reporter::output(["user_status" => 1]);
		}
		if(!Model::createToken())
			return Reporter::error_report(101);
			
		return Reporter::output(["token" => Model::getToken(), "user_status" => 2]);

		
	}
	
	
	public function signUp():bool
	{
		$_REQUEST['birthday'] = ["b_d" => "07", "b_m" => "05", "b_y" => "1998"];
		if(!Model::checkParametrs($_REQUEST, ["f_name","l_name","pswd","email", "birthday", "gender", "callback_url"]))
			return Reporter::error_report(1);
		$f_name = $_REQUEST["f_name"];
		$l_name = $_REQUEST["l_name"];
		$pswd = $_REQUEST["pswd"];
		$eml = $_REQUEST["email"];
		$birthday = $_REQUEST["birthday"];
		$gender = intval($_REQUEST["gender"]);
		$callback = $_REQUEST["callback_url"];
		
		if(!Model::checkCorrectnesSignUpParams($f_name, $l_name, $pswd, $eml, $birthday, $gender)) return false;
		if(!Model::setDBSession()) return false;
		
		if(Model::checkEmailInDB($eml)) return Reporter::error_report(35);
		$user_id = Model::registerNewUser($f_name, $l_name, $pswd, $eml, intval($birthday["b_d"]),intval($birthday["b_m"]),intval($birthday["b_y"]), $gender);
		
		if($user_id === 0) return Reporter::error_report(103);
		$key = Model::getRegKey();
		(strrchr($callback, "?") === false) ? $callback .= "?" : $callback .= "&";
		$callback .= "user_id=".$user_id."&reg_key=".$key;
		$email_arr = Mailer::constructSignUpEmail($f_name." ".$l_name, $callback, $key);
		if(!Mailer::sendMail($eml, "Подтверждение регистрации", $email_arr["body"], $email_arr["headers"])) return false;
		Model::setConfirmationRegTime($user_id);
		return Reporter::output(["email" => $eml, "user_id" => $user_id]);
			
		
		
	}
	
	public function unsetToken():bool
	{
		
		if(!isset($_REQUEST["token"]))
			return Reporter::error_report(1);
		return (Model::removeSession($_REQUEST["token"]))? Reporter::output_no_errors(): false;
	}
	
	
	
}

