<?php
declare(strict_types=1);
namespace app\controllers;

use app\model\Access as Model;
use app\controllers\service\Reporter;


class Access {
	
	use service\Singleton;
	/*
	 * Создание токена через авторизацию
	 * @param http[email] - email пользователя
	 * @param http[pswd] - пароль пользователя
	 * return bool false - ошибка/ true - успех
	 */
	 
	public function signIn():bool{
		if(!Model::checkParametrs($_REQUEST, ["pswd","email"])){
			Reporter::error_report(1);
			return false;
		};
		
		Model::setPswdAndEmail($_REQUEST["email"],$_REQUEST["pswd"]);
		
		if(!Model::setDBSession()){
			return false;
		}
		if(!Model::setUserIdThroughPswdAndEmail()){
			Reporter::error_report(2);
			return false;
		};
		if(!Model::createToken()){
			Reporter::error_report(101);
			return false;
		};
		Reporter::output(["token" => Model::getToken()]);
		return true;
		
	}
	
	/*
	 * Подтверждение регистрации 
	 * @param string email (get)
	 * @param string reg_key (get)
	 * http://localhost:8090/access-regConfirmation?email=vin-ni-kov@yandex.ru&reg_key=5FiJzvK6Pmgob1qxdWR8j0Q2BUDpZtksf3IYTOlncyHXauCMSLG4hewN7EVA
	 
	public function regConfirmation(){
		if(!isset($_GET['email']) or !isset($_GET['reg_key']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) or strlen($_GET['reg_key']) != 60){
			systemError(1, "Некорректная передача параметров!");
		}
		$access = new GetAccess();
		$user_id = $access->getIdByEmailAndKey($_GET['email'], $_GET['reg_key']);
		if($user_id > 0){
			if($access->updateStatus($user_id, 2)){
				$token = $access->createToken($user_id);
				echo json_encode(["error" => 0, "user_id" => $user_id, "token" => $token]);
			}else{
				systemError(3, "Неизвестная ошибка. Не удалось обновить статус аккаунта!");
			}
		}else{
			systemError(2, "Пользователь с такой комбинации ключа и email уже подтвердил свой аккаунт, либо такой аккаунт отсутствует вовсе!");
		}
		unset($access);
	}
	
	
	/*
	 * Создание нового аккаунта
	 * @param string f_name (get)
	 * @param string l_name (get)
	 * @param string email (get)
	 * @param string pswd (get)
	 * @param int gender (get)
	 * @param int year (get)
	 * @param int month (get)
	 * @param int day (get)
	 * http://localhost:8090/access-checkIn?f_name=Alex&l_name=Vinnikov&email=mr.a-vinnikov@yandex.ru&password=d9c436b3d4e1f1d22614643588100e16&gender=2&year=2014&month=11&day=1
	 
	public function checkIn(){
		if(!isset($_GET['f_name']) or !isset($_GET['l_name']) or !isset($_GET['email']) or !isset($_GET['pswd']) or !isset($_GET['gender']) or !isset($_GET['year']) or !isset($_GET['month']) or !isset($_GET['day'])){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$access = new GetAccess();
		$email_flag = false;
		if(filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) ){
			$email_flag = $access->checkEmailInDB($_GET['email']);
		}else{
			systemError(1, "Передайте корректный email!");
		}
		if(!$email_flag){
			systemError(2, "Пользователь с таким Email адресом уже существует!");
		}
		$f_n_length = mb_strlen($_GET['f_name']);
		$l_n_length = mb_strlen($_GET['l_name']);
		
		$f_n_flag    = (boolean) ($f_n_length >= 2 and $f_n_length <= 24);
		$l_n_flag    = (boolean) ($l_n_length >= 2 and $l_n_length <= 24);
		$pswd_flag   = (boolean) (mb_strlen($_GET['pswd']) === 32);
		$gender_flag = (boolean) (intval($_GET['gender']) === 2 or intval($_GET['gender']) ===  1);
		
		if(!$f_n_flag or !$l_n_flag or !$pswd_flag or !$gender_flag){
			systemError(3, "Длина имени или фамилии от 2 до 24 знаков. Пароль должен передавать в зашифрованном md5 виде. Диапозон знаений пола [1,2].");
		}
		
		$year = intval($_GET['year']);
		$month = intval($_GET['month']);
		$day = intval($_GET['day']);
		
		if($year < 1930 or $year > (intval(date('Y'))-4) or !checkdate($month,$day,$year)){
			systemError(4, "Передана некорректная дата. Доступный диапазон лет [1930; ".(intval(date('Y'))-4)."]");
		}
		 
		$user_data = $access->addNewUser($_GET['f_name'], $_GET['l_name'], $_GET['email'], $_GET['pswd'], intval($_GET['gender']), $year, $month, $day);
		if(count($user_data)){
			echo json_encode(["error" => 0, "user_data" => $user_data]);
		}else{
			systemError(9, "Неизвестная ошибка при регистрации пользователя или отправки письма!");
		}
		
	}*/
	
	
}

