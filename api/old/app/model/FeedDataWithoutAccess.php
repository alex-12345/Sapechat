<?php 
namespace model;

class FeedDataWithoutAccess{
	
	
	/*
	 * Вывод информации о пользователе
	 * @param int user_id 
	 * @return array
	 */	
	 
	public function getUserInfo(int $id){
		
		$url = USERS_URL."user-getInfo?id=".$id."&param=user_id,user_first_name,user_img,user_last_name,user_birthday,user_about,country_id,city_id&secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(!isset($arr['error'])){
			return $arr;
		}
		return [];
		
	}
	
	
	/*
	 * Вывод постов на стене пользователя
	 * @param int wall_id 
	 * @param int amount 
	 * @param int start
	 * @return array
	 */	
	 
	public function getWallPosts(int $wall_id, int $amount, int $start){
		
		$url = POSTS_URL."posts-getWallFeed?wall_id=".$wall_id."&amount=".$amount."&start=".$start."&secret_key=".POSTS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(!isset($arr['error'])){
			return $arr;
		}
		return [];
		
	}
	
	/*
	 * Вывод собственных постов на стене пользователя
	 * @param int user_id 
	 * @param int amount 
	 * @param int start
	 * @return array
	 */	
	 
	public function getWallUserPosts(int $user_id, int $amount, int $start){
		$url = POSTS_URL."posts-getUserFeed?id=".$user_id."&amount=".$amount."&start=".$start."&secret_key=".POSTS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(!isset($arr['error'])){
			return $arr;
		}
		return [];
		
	}
	
	/*
	 * Вывод определенного кол-ва друзей пользователя
	 * @param int user_id 
	 * @param int amount 
	 * @param int start
	 * @return array
	 */	
	 
	public function getUserFriends(int $user_id, int $amount, int $start){  
		$url = USERS_URL."users-getFriends?id=".$user_id."&amount=".$amount."&start=".$start."&secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(!isset($arr['error'])){
			return $arr;
		}
		return [];
		
	}
	
	
			

	/*
	 * слияние массива вывода с данными из микросервиса пользователи
	 * @param array arr 
	 * @param string row 
	 * @return array
	 */	
	 
	public function mergeWithUser(array $arr, string $row){
		$arr_ids = [];
		foreach($arr as $key =>$value){
			array_push($arr_ids, $value[$row]);
		}
		$arr_r_ids = array_unique($arr_ids);
		$ids_str = implode(",", $arr_r_ids);
		$url = USERS_URL."users-getArrayUserDescription?ids=".$ids_str."&secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$users_arr = json_decode($content, true);
		
		$result_arr_user = [];
		foreach($users_arr as $key => $value){
			$result_arr_user[$value['user_id']] = ['user_first_name' => $value['user_first_name'], 'user_last_name' => $value['user_last_name'], 'user_img' => $value['user_img']];
		}
		foreach($arr as $key => $value){
			if(isset($result_arr_user[$value['user_id']]))
			{
				$arr[$key]['user_first_name'] = @$result_arr_user[$value[$row]]['user_first_name'];
				$arr[$key]['user_last_name'] = @$result_arr_user[$value[$row]]['user_last_name'];
				$arr[$key]['user_img'] = @$result_arr_user[$value[$row]]['user_img'];
				if(empty($result_arr_user[@$value[$row]]['user_img'])){ $arr[$key]['user_img']=NO_IMG;}
			}else{
				$arr[$key]['user_first_name'] = "Удаленный";
				$arr[$key]['user_last_name'] = "Пользователь";
				$arr[$key]['user_img'] = "noimg.jpg";
			}
			
		}
		return $arr;
		
	}
	
	/*
	 * Вывод всех стран
	 * @return array
	 */	
	 
	public function getCountries(){
		$url = USERS_URL."info-getCountries?secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['countries']) ){
			return $arr['countries'];
		}
		return [];
		
	}
	
	/*
	 * Вывод всех стран
	 * @return array
	 */	
	 
	public function getCities(int $country_id){
		$url = USERS_URL."info-getCities?country_id=".$country_id."&secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['cities']) ){
			return $arr['cities'];
		}
		return [];
		
	}
	
	
}