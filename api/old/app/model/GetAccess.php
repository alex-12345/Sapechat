<?php 
namespace model;

class GetAccess{
	
	
	/*
	 * ВХОД - Получение ид пользователя по email и pswd
	 * @param string text 
	 * @param int user_id 
	 * @param int wall_id 
	 * @return int
	 */	
	 
	public function checkUserPswdAndGetUserId(string $email, string $pswd){
		$url = USERS_URL."account-checkEmailPassword?email=".$email."&password=".$pswd."&secret_key=".USERS_KEY;
		$arr = json_decode(file_get_contents($url), true);
		if($arr['error'] == 0){
			return $arr['id'];
		}elseif($arr['error'] == 1){
			return 0;
		}
		return -1;
	}

	/*
	 * Создание по id пользователя его токена доступа и сохранение его в key-value хранилище
	 * @param int user_id 
	 * @return string
	 */	
	 
	public function createToken(int $user_id){
		global $db;
		$nowTime = time();
		$TTL = time() + (31 * 24 * 60 * 60);
		$token = $user_id.'_'.sha1($user_id.''.$nowTime).'b'.$nowTime;
		$collection = $db->sessions->tokens;
		$collection->insertOne(["id" => $user_id, "token" => $token, "add_time" => $nowTime, "expiration_time" => $TTL]);
		return $token;
		
	}
	
	/*
	 * Проверка отсутсвия email адреса в базе данных
	 * @param string email 
	 * @return boolean
	 */	
	 
	public function checkEmailInDB(string $email){
		$url = USERS_URL."user-checkEmail?email=".$email."&secret_key=".USERS_KEY;
		$arr = json_decode(file_get_contents($url), true);
		if($arr['error'] == 0){
			return true;
		}
		return false;
	}
	
	/*
	 * получение id по reg_key и email
	 * @param string email 
	 * @param string reg_key 
	 * @return int
	 */	
	 
	public function getIdByEmailAndKey(string $email, string $reg_key){
		
		$url = USERS_URL."user-checkEmailKey?email=".$email."&r_key=".$reg_key."&secret_key=".USERS_KEY;
		$arr = json_decode(file_get_contents($url), true);
		if($arr['error'] == 0){
			return $arr['id'];
		}
		return 0;
	}
	
	/*
	 * обновление статуса по id
	 * @param int id
	 * @param int status
	 * @return boolean
	 */	
	 
	public function updateStatus(int $id, int $status){
		$url = USERS_URL."account-changeProfileInfo?id=".$id."&user_status=".$status."&secret_key=".USERS_KEY;
		$arr = json_decode(file_get_contents($url), true);
		if($arr['error'] == 0){
			return true;
		}
		return false;
	}
	
	
	/*
	 * Создание нового аккаунта
	 * @param string f_name 
	 * @param string l_name 
	 * @param string email 
	 * @param string pswd 
	 * @param int gender 
	 * @param int year 
	 * @param int month 
	 * @param int day 
	 * @return array
	 */	
	 
	public function addNewUser(string $f_name, string $l_name, string $email, string $pswd, int $gender, int $year, int $month, int $day){  
		$url = USERS_URL."account-addNewUser?first_name=".$f_name."&last_name=".$l_name."&password=".$pswd."&gender=".$gender."&email=". $email."&b_d=".$day."&b_m=".$month."&b_y=".$year."&secret_key=".USERS_KEY;
		$arr = json_decode(file_get_contents($url), true);
		if($arr['error'] == 0){
			return $arr['reg_info'];
		}
		return [];
	}
	
	
}