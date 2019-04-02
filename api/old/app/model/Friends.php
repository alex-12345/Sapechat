<?php 
namespace model;

use controllers\service\CheckRelation as CU;

class Friends{
	use CU;
	
	
	
	/*
	 * Пригласить в друзья
	 * @param int id 
	 * @param int friend_id 
	 * @return boolean
	 */	
	 
	public function createInviteToFriends(int $id, int $friend_id){
		$url = USERS_URL."account-inviteToFriend?query_id=".$id."&answer_id=".$friend_id."&secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['error']) and $arr['error'] === 0){
				return true;
		}
		else{
			return false;
		}
	}
	
	
	/*
	 * принять в друзья
	 * @param int id 
	 * @param int friend_id 
	 * @return boolean
	 */	
	 
	public function acceptInvite(int $id, int $friend_id){
		$url = USERS_URL."account-acceptInvite?query_id=".$friend_id."&answer_id=".$id."&secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['error']) and $arr['error'] === 0){
				return true;
		}
		else{
			return false;
		}
	}
	
	
	/*
	 * удалить из друзей
	 * @param int id 
	 * @param int friend_id 
	 * @return boolean
	 */	
	 
	public function removeFromFriendList(int $id, int $friend_id){
		$url = USERS_URL."account-removeFromFriends?query_id=".$id."&answer_id=".$friend_id."&secret_key=".USERS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['error']) and $arr['error'] === 0){
				return true;
		}
		else{
			return false;
		}
	}
}