<?php 
namespace model;

class Chats{
	
	
	/*
	 * Вывод части последних чатов пользователя пользователя
	 * @param int amount 
	 * @param int start 
	 * @return array
	 */	
	 
	public function getLastChats(int $id, int $amount, int $start){
		$url = CHATS_URL."chats-getChatsFeed?id=".$id."&amount=".$amount."&start=".$start."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(!isset($arr['error'])){
			return $arr;
		}else{
			echo $content;
			exit();
		}
	}

	/*
	 * проверка наличия пользователя в чате
	 * @param int user_id 
	 * @param int chat_id 
	 * @return boolean
	 */	
	 
	public function checkUserInChat(int $user_id, int $chat_id){
		$url = CHATS_URL."chat-checkUserInChat?user_id=".$user_id."&chat_id=".$chat_id."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if($arr['error'] === 0){
			return true;
		}
		return false;
	}
	
	/*
	 * проверка наличия пользователей в чате
	 * @param str ids 
	 * @param int chat_id 
	 * @return boolean
	 */	
	 
	public function checkUsersInChat(string $ids, int $chat_id){
		$url = CHATS_URL."chat-countUsesrsInChat?ids=".$ids."&chat_id=".$chat_id."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if($arr['error'] === 0){
			if($arr['count'] == 0){
				return true;
			}
			return false;
		}
		return false;
	}
	
	/*
	 * добавление пользователей в чат наличия пользователей в чате
	 * @param str ids 
	 * @param int chat_id 
	 * @param int invitor_id 
	 * @return boolean
	 */	
	 
	public function addUsersInChat(string $ids, int $chat_id, int $invitor_id){
		$url = CHATS_URL."chat-addUsersInChat?ids=".$ids."&chat_id=".$chat_id."&invitor_id=".$invitor_id."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if($arr['error'] === 0){
			return true;
		}
		return false;
	}
	
	/*
	 * проверка права владения чатом
	 * @param int owner_id 
	 * @param int chat_id 
	 * @return boolean
	 */	
	 
	public function verificationChatOwnerships(int $owner_id, int $chat_id){
		$url = CHATS_URL."chat-chatPermissionsCheck?user_id=".$owner_id."&chat_id=".$chat_id."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if($arr['error'] === 0){
			return true;
		}
		return false;
	}
	
	/*
	 * проверка инвайта
	 * @param int user_id 
	 * @param int invitor_id 
	 * @param int chat_id 
	 * @return boolean
	 */	
	 
	public function checkInvite(int $user_id, int $invitor_id, int $chat_id){
		$url = CHATS_URL."chat-checkInviteInChat?user_id=".$user_id."&invitor_id=".$invitor_id."&chat_id=".$chat_id."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if($arr['error'] === 0){
			return true;
		}
		return false;
	}
	
	/*
	 * удаление пользователя из чата
	 * @param int user_id 
	 * @param int chat_id 
	 * @return boolean
	 */	
	 
	public function deleteUserFromChat(int $user_id, int $chat_id){
		$url = CHATS_URL."chat-removeUserFromChat?user_id=".$user_id."&chat_id=".$chat_id."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if($arr['error'] === 0){
			return true;
		}
		return false;
	}
	
	
	/*
	 * вывод сообщений из чата
	 * @param int chat_id 
	 * @param int start 
	 * @param int amount 
	 * @return array
	 */	
	 
	public function chatOutput(int $chat_id, int $start, int $amount){
		$url = CHATS_URL."chat-chatOutputLastMsg?chat_id=".$chat_id."&start=".$start."&amount=".$amount."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['error']) or (count($arr) == 0)){
			return [];
		}
		return $arr;
	}
	
	/*
	 * добавление сообщения в чат
	 * @param int user_id 
	 * @param int chat_id 
	 * @param string text 
	 * @return int
	 */	
	 
	public function addMassageInChat(int $user_id, int $chat_id, string $text){
		$url = CHATS_URL."massages-addMassage?user_id=".$user_id."&chat_id=".$chat_id."&text=".urlencode($text)."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['error']) and ($arr['error'] == 0)){
			return $arr['massage_id'];
		}
		return 0;
	}
	
	/*
	 * проверка принадлежности сообщения пользователю
	 * @param int user_id 
	 * @param int mgs_id 
	 * @return boolean
	 */	
	 
	public function CheckMsgUser(int $user_id, int $mgs_id){
		$url = CHATS_URL."massages-massagePermissionsCheck?user_id=".$user_id."&massage_id=".$mgs_id."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['error']) and ($arr['error'] == 0)){
			return true;
		}
		return false;
	}
	
	/*
	 * удаление сообщения
	 * @param int mgs_id 
	 * @return boolean
	 */	
	 
	public function removeMsg(int $mgs_id){
		$url = CHATS_URL."massages-removeMassage?massage_id=".$mgs_id."&secret_key=".CHATS_KEY;
		$content = file_get_contents($url);
		$arr = json_decode($content, true);
		if(isset($arr['error']) and ($arr['error'] == 0)){
			return true;
		}
		return false;
	}
}