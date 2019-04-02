<?php 
namespace model;

class UserFeed{
	
	
	/*
	 * Вывод части последних чатов пользователя пользователя
	 * @param int id 
	 * @param int amount 
	 * @param int start 
	 * @return array
	 */	
	 
	public function getLastFeed(int $id, int $amount, int $start){
		
		$url = USERS_URL."users-getFriendsId?id=".$id."&secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['error']) and $arr['error'] == 0){
			$arr_ids = $arr['relation_data'];
			$arr_ids_only = [];
			foreach($arr_ids as $key => $value){
				array_push($arr_ids_only, $value['user_id']);
			}
			$ids = implode(",", $arr_ids_only);
			$url = POSTS_URL."posts-getFriendsFeed?ids=".$ids.",".$id."&amount=".$amount."&start=".$start."&secret_key=".POSTS_KEY;
			$content = file_get_contents($url);
			$arr = json_decode($content, true);
			if(!isset($arr['error'])){
				return $arr;
			}else{
				return [];
			}
		}
		else{
			return [];
		}
	}
	
	/*
	 * Вывод краткой информации о пользователе
	 * @param int id  
	 * @return array
	 */	
	 
	public function getBriefUserInfo(int $id){
		$url = USERS_URL."user-getInfo?param=user_id,user_first_name,user_img,user_last_name,user_email&id=".$id.'&secret_key='.USERS_KEY;
$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(!isset($arr['error']) ){
				return $arr;
		}
		else{
			return [];
		}
	}

}