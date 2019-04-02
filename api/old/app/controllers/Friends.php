<?php

namespace controllers;

use model\Friends as u_friends;
use controllers\service\MainController;


class Friends extends MainController{
	
	public function __construct(){
		parent::__construct();
	}
	
	/*
	 * Вывод состояния о дружбе
	 * @param int friend_id (get)
	 * http://localhost:8090/friends-checkFriendRelation?friend_id=7&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function checkFriendRelation(){
		if(!isset($_GET['friend_id']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$friends = new u_friends();
		$arr = $friends->checkFriendRelation($this->user_id, intval($_GET['friend_id']));
		if(count($arr) and $arr['relation info'] !== false){
			self::jsonOutput(["error" => 0, "relation" => $arr['relation info']]);
		}else{
			self::jsonOutput(["error" => 0, "relation" => false]);
		}
	}
	
	/*
	 * Пригласить в друзья
	 * @param int friend_id (get)
	 * http://localhost:8090/friends-createInviteToFriends?friend_id=7&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function createInviteToFriends(){
		if(!isset($_GET['friend_id']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$friends = new u_friends();
		
		$arr = $friends->checkFriendRelation($this->user_id, intval($_GET['friend_id']));
		
		if(count($arr) and isset($arr['relation info']) and $arr['relation info'] == false){
			if($friends->createInviteToFriends($this->user_id, intval($_GET['friend_id']))){
				self::jsonOutput(["error" => 0]);
			} else{
				systemError(2, "Не удалось добавить в друзья!");
			}
		}else{
			systemError(1, "Этот пользователь уже есть в вашем списке друзей!");
		}
	}
	
	
	/*
	 * Принять инвайт
	 * @param int friend_id (get)
	 * http://localhost:8090/friends-acceptInvite?friend_id=7&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function acceptInvite(){
		if(!isset($_GET['friend_id']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$friends = new u_friends();
		
		$arr = $friends->checkFriendRelation($this->user_id, intval($_GET['friend_id']));
		if(count($arr) and isset($arr['relation info']['relation_status']) and $arr['relation info']['relation_status'] == 1){
			if($friends->acceptInvite($this->user_id, intval($_GET['friend_id']))){
				self::jsonOutput(["error" => 0]);
			} else{
				systemError(2, "Не удалось принять в друзья, вы являетсь владельцем заявки!");
			}
		}else{
			systemError(1, "Этот пользователь не находиться у вас в списке входящих заявок в друзья!");
		}
	}
	
	/*
	 * Удалить из друзей или из списка инвайтов
	 * @param int friend_id (get)
	 * http://localhost:8090/friends-removeFromFriendList?friend_id=7&token=1_5bcf0cbd9fcfbba5f9c508fad576d26b8c40f33cb1544219549
	 */
	public function removeFromFriendList(){
		if(!isset($_GET['friend_id']) ){
			systemError(5, "Ошибка, вы не указали какой-то из параметров!");
		}
		$friends = new u_friends();
		
		$arr = $friends->checkFriendRelation($this->user_id, intval($_GET['friend_id']));
		if(count($arr) and isset($arr['relation info']['relation_status']) and !empty($arr['relation info']['relation_status'])){
			if($friends->removeFromFriendList($this->user_id, intval($_GET['friend_id']))){
				self::jsonOutput(["error" => 0]);
			} else{
				systemError(2, "Не удалось удалить из друзей");
			}
		}else{
			systemError(1, "Этот пользователь не находиться у вас в списке входящих заявок в друзья или в списке друзей!");
		}
	}
	
}

