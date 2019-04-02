<?php

namespace controllers\service;

trait CheckRelation{
	
	/*
	 * Вывод состояния о дружбе
	 * @param int id 
	 * @param int friend_id 
	 * @return array
	 */	
	 
	public function checkFriendRelation(int $id, int $friend_id){
		$url = USERS_URL."account-checkRelation?query_id=".$id."&answer_id=".$friend_id."&secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['error']) and $arr['error'] === 0){
				return $arr;
		}
		else{
			return [];
		}
	}
	
}